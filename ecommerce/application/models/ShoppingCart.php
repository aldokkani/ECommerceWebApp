<?php

class Application_Model_ShoppingCart extends Zend_Db_Table_Abstract
{

	protected $_name = 'Shopping_Cart';
	
	protected $_dependentTables = array('Application_Model_ShoppingCartDetails');

	//*****TODO Get user's last shopping cart LAST ONE *************//
	function getUserShoppingCart($customerid)
	{
		return $this->fetchAll('customer_id = '. $customerid)->toArray()[0];
	}
	//***** End TODO *************//


	//update the shopping cart values with the last shopping cart created by this user.
	//TODO *********** Get user session id ********//
	//TODO *********** Get the values from the details to update its parent shopping cart ****//

	function updateUserShoppingCart($customerid , $shopping_cart_id , $quantity , $unit_price, $discount)
	{
		//get biggest shopping cart id details
		$user_shopping_cart = $this->fetchAll('customer_id = '. $customerid)->toArray()[0];

		$userData['customer_id']=$customerid;			
		$userData['total_amount']=$user_shopping_cart['total_amount']+ $quantity;	
		$userData['discount']=$user_shopping_cart['discount']+ $discount;	
		$userData['due_amount'] = $userData['total_amount'] - $userData['discount'];

		$this->update($userData,"id=$shopping_cart_id");

	}
	//***** End TODO *************//


	function billUserShoppingCart($customerid , $shopping_cart_id)
	{
		//get biggest shopping cart id details
		$user_shopping_cart = $this->fetchAll('customer_id = '. $customerid)->toArray()[0];

	}

// function updateUserData($id,$formData)
// 	{
// 		// var_dump($formData);
// 		// exit();
// 		$userData['fname']=$formData['fname'];
// 		$userData['lname']=$formData['lname'];
// 		$userData['email']=$formData['email'];
// 		$userData['track']=$formData['track'];

// 		$this->update($userData,"id=$id");
		
// 	}




	

	

}

