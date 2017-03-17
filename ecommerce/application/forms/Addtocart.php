<?php

class Application_Form_Addtocart extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');


        /************ TODO i need shopping cart id from session user id ****/
        //get shopping cart id through getting the last shopping cart id where user id from current session.
        /************* END TODO ********************************/


        //product id
        $product = new Zend_Form_Element_Select('product');
        $product->setlabel('product');
        $product->setAttribs(array('class'=>'form-control'));

        $productModel = new Application_Model_Product();
        

        /**TODO here i need function to return array of all products*****/
        //TODO here i need function to return array of all products 
        //$allProducts = $productModel->getAllProducts();
        //foreach ($allProducts as $key => $value) {
        $product ->addMultiOption(1,1);
        //}
        /************* END TODO ********************************/


        //********** TODO get price of item on select change *****/
        //unit price
        // $unit_price = new Zend_Form_Element_Text('unit_price');
        // $unit_price->setlabel('unit_price: ')
        // ->setAttribs(array(
        // 		'class'=>'form-control',
        // 		'placeholder'=>'example: 1'
        // 		));
        /************* END TODO ********************************/






        //quantity needed
        $quantity = new Zend_Form_Element_Text('quantity');
        $quantity->setlabel('quantity: ')
        ->setAttribs(array(
        		'class'=>'form-control',
        		'placeholder'=>'example: 1'
        		));








        // $lname = new Zend_Form_Element_Text('lname');
        // $lname->setlabel('Lirst Name: ');
        // $lname->setAttribs(array(
        // 		'class'=>'form-control',
        // 		'placeholder'=>'example: Ali'
        // 		));



        // $email = new Zend_Form_Element_Text('email');
        // $email->setlabel('Email: ');
        // $email->setAttribs(array(
        // 		'class'=>'form-control',
        // 		'placeholder'=>'example: nada.bayoumy@hotmail.com'
        // 		));











        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));


		// $reset = new Zend_Form_Element_Reset('reset');
  		// $reset->setAttribs(array('class'=>'btn btn-danger'));



       

		// $lname->setRequired();
		// $lname->addValidator('StringLength', false, Array(4,20));
		// $lname->addFilter('StringTrim');

		// $email->setRequired();
  //       $email->addFilter('StringTrim');
		// $email->addValidator('StringLength', false, Array(4,20));
		


		// $track->setRequired();
		// $track->addValidator('StringLength', false, Array(4,20));
		// $track->addFilter('StringTrim');






//add to form elements
     //    $this->addElement($product);
     // 	$this->addElement($quantity);

    	// $this->addElement($submit);







    }





}

