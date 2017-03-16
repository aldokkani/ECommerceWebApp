<?php

class Application_Model_ShoppingCartDetails extends Zend_Db_Table_Abstract
{
	protected $_name = 'Shopping_Cart_Det';

	protected $_referenceMap = array(
			   'Scheme' => array(
			   'columns' => array('shopping_cart_id'),  
			   'refColumns' => array('id'), 
			   'refTableClass' => 'Shopping_Cart',  
	),
	);


	function ShoppingCartDetails($shopping_cart_id)
	{
		return $this->fetchAll('shopping_cart_id = '. $shopping_cart_id)->toArray();
	}

	//*************TODO get product id from form data ***/
	function RemoveItemFromShoppingCart($formData , $shopping_cart_id)
	{
		$product_id = $formData['product_id'];
		$this->delete("product_id=$product_id and shopping_cart_id= $shopping_cart_id");
	}
	//***********END TODO***********************************//

	function AddItemToShoppingCart($formData , $shopping_cart_id)
	{
	
	//SELECT `id`, `product_id`, `shopping_cart_id`, `quantity`, `unit_price`, `discount`, `date` FROM `Shopping_Cart_Det` WHERE 1


		//***** TODO comment these lines and put the right values from form ***/
		// $userData['product_id']=1;
		// $userData['shopping_cart_id']= $shopping_cart_id;
		// $userData['quantity']=12;
		// $userData['unit_price']=9.8;
		// $userData['discount']=0.0;
		// $userData['date']= Zend_Date::now();
		//***********END TODO***********************************//


		//***** TODO un comment these lines setting values from products form***/
		$userData['product_id']=$formData['product_id'];
		$userData['shopping_cart_id']= $shopping_cart_id;
		$userData['quantity']=$formData['quantity'];
		$userData['unit_price']=$formData['unit_price'];
		$userData['discount']=$formData['discount'];
		$userData['date']= Zend_Date::now();
		//***********END TODO***********************************//

		$row = $this->createRow($userData);
		$row->save();		
	}


}

