<?php

class Application_Model_Shoppingcartdetails extends Zend_Db_Table_Abstract
{
	protected $_name = 'Shopping_Cart_Det';
	protected $_referenceMap = array(
			   'Scheme' => array(
			   'columns' => array('shopping_cart_id'),  
			   'refColumns' => array('id'), 
			   'refTableClass' => 'Shopping_Cart',  
	),
	);

	function listShoppingCartDetails($customer_id)
	{
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));

		$stmt = $db->query("SELECT Shopping_Cart_Det.id as shopping_cart_det_id,  products.id as product_id,  quantity,  Shopping_Cart_Det.unit_price,  Shopping_Cart_Det.discount as item_discount,  Shopping_Cart_Det.date,  Shopping_Cart.total_amount as total_cart_amount,  Shopping_Cart.discount as total_cart_discount,  Shopping_Cart.due_amount as total_cart_due_amount,  is_paid, payment_date, coupon_id, products.name_en, products.name_ar, products.description_en, products.description_ar, products.photo, products.category_id     FROM Shopping_Cart_Det  join Shopping_Cart   on Shopping_Cart.id = Shopping_Cart_Det.shopping_cart_id  join products   on Shopping_Cart_Det.product_id = products.id   where customer_id = $customer_id");

		$rows = $stmt->fetchAll();
		return $rows;
	}

	function addItemToCart($customer_id,$shopping_cart_id,$product_id)
	{
		$product_model = new Application_Model_Products();
		$product_info = $product_model->selectOne($product_id);
		$unit_price = $product_info['unit_price'];
		//Get Discount from Offer 
		$offer_model = new Application_Model_Offer();
		$percent_of_discount = $offer_model->getProductOffer($product_id);
		if($percent_of_discount !== 0)
		{
			$discount = $unit_price * $percent_of_discount/100;
		}
		else
		{
			$discount =0;
		}
		//check if item already exists add quantity on it
		$shopping_cart_product_details_model = $this->checkProductInShoppingCartDetails($product_id);

		if(sizeof($shopping_cart_product_details_model)!=0)
		{
		        $detail_id = $_SESSION['shopping_cart_id'];       
		        $quantity = $shopping_cart_product_details_model['quantity']+1;
				$this->updateItemInCart($shopping_cart_product_details_model['id'],$quantity);
				$shopping_cart_model = new Application_Model_Shoppingcart();
				$shopping_cart_model->updateCustomerShoppingCart($shopping_cart_id,$quantity,$unit_price);
		}
		else
		{
				$quantity =1;
				//second way....
				$userData['customer_id']=$customer_id;
				$userData['shopping_cart_id']=$shopping_cart_id;
				$userData['product_id']=$product_id;
				$userData['quantity']=$quantity;
				$userData['unit_price'] = $unit_price;
				$userData['discount'] = $discount;

				$row = $this->createRow($userData);
				$row->save();
				
				$shopping_cart_model = new Application_Model_Shoppingcart();
				$shopping_cart_model->updateCustomerShoppingCart($shopping_cart_id,$quantity,$unit_price,$discount);
		}
	}

	public function selectOne($detail_id) {
        return $this->fetchAll('id = '. $detail_id)->toArray()[0];
    }

    public function checkProductInShoppingCartDetails($product_id) {
        return $this->fetchAll('product_id = '. $product_id)->toArray()[0];
    }

	function removeItemFromCart($detail_id)
	{
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));

		$stmt = $db->query("Delete from Shopping_Cart_Det where id = " . $detail_id);
		$stmt->execute();
	}

	function updateItemInCart($detail_id,$quantity)
	{
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
		    'host'     => 'localhost',
		    'username' => 'root',
		    'password' => 'ROOT',
		    'dbname'   => 'dbzend'
		));
		$details_returned = $this->fetchAll('id='. $detail_id)->toArray()[0];
		$stmt = $db->query("update Shopping_Cart_Det set quantity = ". $quantity  ." where id = " . $detail_id);
		$shopping_cart_model = new Application_Model_Shoppingcart();
		$discount=0;
		$unit_price =$details_returned['unit_price'];
		$shopping_cart_id = $_SESSION['shopping_cart_id'];
		$shopping_cart_model->updateCustomerShoppingCart($shopping_cart_id,$quantity,$unit_price);
	}


}

