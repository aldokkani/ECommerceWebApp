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


	function updateCustomerShoppingCart($shopping_cart_id,$quantity,$unit_price,$discount)
	{
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));


		$stmt = $db->query("update Shopping_Cart set total_amount = total_amount + $unit_price , discount = discount+ $discount where id = $shopping_cart_id");
		// $stmt->execute();
	}

	function getUserShoppingCartBillDetails($customer_id)
	{
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));

		//$customer_id = 1;

		$stmt = $db->query("SELECT * FROM dbzend.Shopping_Cart inner join users on Shopping_Cart.customer_id =  users.id where customer_id=$customer_id ORDER BY dbzend.Shopping_Cart.id DESC LIMIT 1");


		// var_dump($stmt);

		$rows = $stmt->fetchAll();
		return $rows;
	}
	



	function getUserShoppingCart($customerid)
	{
		$customerid = 1;
		return $this->fetchAll('customer_id = '. $customerid)->toArray()[0];
	}


	function checkOutCart($shopping_cart_id)
	{

		//update record of shopping cart in table 
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));

		$date = Zend_Date::now();
		$timeStamp = gmdate("Y-m-d H:i:s", $date->getTimestamp());

		$stmt = $db->query("update Shopping_Cart set is_paid = true , payment_date = '".$timeStamp."' where id = $shopping_cart_id");


		$customer_id=1;

$customerBill = $this->getUserShoppingCartBillDetails($customer_id);

$stringBill  = "your total amount is " . $customerBill[0]['total_amount'] ."\n";
$stringBill .= "(-) total disount taken is  " . $customerBill[0]['discount'] ."\n";
$stringBill .= "your due amount is " . $customerBill[0]['due_amount'] ."\n";
		//$stringBill .= "Coupon used " . $customerBill[0]['coupon'] ."</br>";
		
		//this is the string to send into email:
		//var_dump($stringBill);
		//die();



		//emaill

		/** Generates a coupon and send it to the customer's email */
        //$discount = $this->getRequest()->getParam('discount');
        //$coupon_str = (new Application_Model_Coupon())->generateCoupon($discount);
        $user=1;
        // $user = (new Application_Model_User())->selectOne($this->_request->getParam('uid'));

        $user = (new Application_Model_User())->selectOne($user);

        // var_dump($user);
        // die();

        
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
        //$this->redirect('admin/');


		//end email
		// $email_model = new Application_Model_Email();
		// $email_model->sendMail();

		//send email NOW with full bill details
		//INTO eMAIL

		//**************EMAIL***************************//
		// $config = array('auth' => 'login',
  //               'username' => 'myusername',
  //               'password' => 'password');
 
		// $transport = new Zend_Mail_Transport_Smtp('mail.google.com', $config);
		 
		// $mail = new Zend_Mail();
		// $mail->setBodyText('This is the text of the mail.');
		// $mail->setFrom('nada.bayoumy1990@gmail.com', 'Some Sender');
		// $mail->addTo('nada1990.bayoumy@gmail.com', 'Some Recipient');
		// $mail->setSubject('TestSubject');
		// $mail->send($transport);





	// require_once('Zend/Mail/Transport/Smtp.php');
	// require_once 'Zend/Mail.php';
	// $config = array('auth' => 'login',
	//                 'username' => 'somemail@mysite.com',
	//                 'password' => 'somepass',
	//                 'ssl' => 'tls');

	// $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

	// $mail = new Zend_Mail();
	// $mail->setBodyText('This is the text of the mail.');
	// $mail->setFrom('nada.bayoumy1990@gmail.com', 'Some Sender');
	// $mail->addTo('nada1990.bayoumy@gmail.com', 'Some Recipient');
	// $mail->setSubject('TestSubject');
	// $mail->send($transport);



	// $tr = new Zend_Mail_Transport_Sendmail('-freturn_to_me@example.com');
	// Zend_Mail::setDefaultTransport($tr);

	// 		$mail = new Zend_Mail();
	// 		$mail->setBodyText('This is the text of the mail.');
	// 		$mail->setFrom('nada.bayoumy@hotmail.com', 'Some Sender');
	// 		$mail->addTo('nada.bayoumy@hotmail.com', 'Some Recipient');
	// 		$mail->setSubject('TestSubject');
	// 		$mail->send();


		
		//create new shopping cart
		$this->AddUserEmptyCart();


	}




}

