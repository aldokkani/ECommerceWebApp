<?php

class Application_Model_Shoppingcart extends Zend_Db_Table_Abstract
{
	protected $_name = 'Shopping_Cart';
	protected $_dependentTables = array('Application_Model_ShoppingCartDetails');

	function listShoppingCarts()
	{
		return $this->fetchAll()->toArray();
	}

	function AddUserEmptyCart()
	{
		$userData['customer_id']=1;
		$row = $this->createRow($userData);
		$row->save();
	}


	function updateCustomerShoppingCart($shopping_cart_id,$quantity,$unit_price,$discount=null)
	{
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));

		//get all details of shopping cart and compute total amount here 
		//or use mysql trigger
		$shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
		$all_det = $shopping_cart_details_model->listShoppingCartDetails($_SESSION['customer_id']);
		var_dump($all_det);
		$total_due_amount=0;
		$total_discount_amount=0;
		for ($detail=0; $detail < sizeof($all_det) ; $detail++) { 
			$total_due_amount += ($all_det[$detail]['unit_price'] * $all_det[$detail]['quantity']);

			$total_discount_amount += ($all_det[$detail]['discount'] );
		}

		if($disount==null){		
			$stmt = $db->query("update Shopping_Cart set total_amount = ".$total_due_amount." , discount = discount + ".$total_discount_amount. " ,due_amount = ". ($total_due_amount - $total_discount_amount)."  where id = $shopping_cart_id");
		}
		else{
			$new_dis = $disount + $total_due_amount - $total_discount_amount;
			$stmt = $db->query("update Shopping_Cart set total_amount = ".$total_due_amount." , discount = discount + ".$new_dis. " , due_amount = ". ($total_due_amount - $total_discount_amount)."  where id = $shopping_cart_id");
		}
		var_dump($stmt);
	}

	function getUserShoppingCartBillDetails($customer_id)
	{
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));
		$stmt = $db->query("SELECT * FROM dbzend.Shopping_Cart inner join users on Shopping_Cart.customer_id =  users.id where customer_id=".$_SESSION['customer_id']." ORDER BY dbzend.Shopping_Cart.id DESC LIMIT 1");
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function getUserShoppingCart($customerid)
	{
		$customerid = $_SESSION['customer_id'];
		return $this->fetchAll('customer_id = '. $customerid)->toArray()[0];
	}

	function checkOutCart($shopping_cart_id,$coupon_id=null)
	{
		//update record of shopping cart in table 
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));

		$customer_id=$_SESSION['customer_id'];
		$customerBill = $this->getUserShoppingCartBillDetails($customer_id);

		if($coupon_id!=null){
			//Get Discount from COUPON to update due amount
			$coupon_model = new Application_Model_Coupon();
			$percent_of_coupon = $coupon_model->selectOne($coupon_id);
			$percent_of_coupon = $percent_of_coupon["discount"];
			if($percent_of_coupon !== 0)
			{
				$net = $customerBill[0]['total_amount'] - $customerBill[0]['discount'];
				$discount_on_net = $net * ($percent_of_coupon/100);
				$due_amount_after_coupon = $net - $discount_on_net;
				$discount = $discount_on_net;
				$date = Zend_Date::now();
				$timeStamp = gmdate("Y-m-d H:i:s", $date->getTimestamp());
				$stmt = $db->query("update Shopping_Cart set due_amount = ".$due_amount_after_coupon.", coupon_id = ". $coupon_id. " ,is_paid = true , payment_date = '".$timeStamp."' where id = $shopping_cart_id");
			}			
		}
		else
		{
			$discount =0;
			$date = Zend_Date::now();
			$timeStamp = gmdate("Y-m-d H:i:s", $date->getTimestamp());
			$stmt = $db->query("update Shopping_Cart set is_paid = true , payment_date = '".$timeStamp."' where id = $shopping_cart_id");
		}
		$stringBill  = "your total amount is " . $customerBill[0]['total_amount'] ."\n";
		$stringBill .= "(-) total disount taken is  " . $customerBill[0]['discount'] ."\n";
		$stringBill .= "your due amount is " . $customerBill[0]['due_amount'] ."\n";
		
		if($coupon_id != null)
		{
			$stringBill .= "Coupon used " . $coupon_id ."</br>";	
		}
        $user = (new Application_Model_User())->selectOne($_SESSION['customer_id']);
        $mailBody = "Hello Mr/Mrs ".$user['fullname'].",\n\n "
        		.  $stringBill              
                . "\n\nHave a nice day. :)";
        
        $mailInfo = [
            'cust_name' => $user['fullname'],
            'cust_mail' => $user['email'],
            'mail_body' => $mailBody,
            'mail-subject' => "ECommerce Bill Information"
            ];
        
        (new Application_Model_Email())->sendMail($mailInfo);
       
		//create new shopping cart
		$this->AddUserEmptyCart();
	}
}

