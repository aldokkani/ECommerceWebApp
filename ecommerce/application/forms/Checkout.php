<?php

class Application_Form_Checkout extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        $customer_id = 1;

        $shopping_cart_model = new Application_Model_Shoppingcart();
        $shopping_cart_details =  $shopping_cart_model->getUserShoppingCart($customer_id);


        // var_dump($shopping_cart_details['id']);
        // die();



        $total_amount = new Zend_Form_Element_Text('total_amount');
        $total_amount->setlabel('total amount before discount:')
        ->setAttribs(array(
        		'class'=>'form-control',
        		'disabled' => 'disabled'
        		))
        ->setValue($shopping_cart_details["total_amount"]);



        $total_discount = new Zend_Form_Element_Text('total_discount');
        $total_discount->setlabel('total discount:')
        ->setAttribs(array(
        		'class'=>'form-control',
        		'disabled' => 'disabled'
        		))
        ->setValue($shopping_cart_details["discount"]);




        $due_amount = new Zend_Form_Element_Text('due_amount');
        $due_amount->setlabel('Due amount:')
        ->setAttribs(array(
        		'class'=>'form-control',
        		'disabled' => 'disabled'
        		))
        ->setValue($shopping_cart_details["total_amount"] - $shopping_cart_details["discount"]);






        $coupon = new Zend_Form_Element_Text('coupon');
        $coupon->setlabel('Use Coupon: ')
        ->setAttribs(array(
        		'class'=>'form-control',
        		'placeholder'=>'example: #8882122jncjdd##21229'
        		))
        ->addFilter('StringTrim');





        $verify = new Zend_Form_Element_Submit('verify');
        $verify->setAttribs(array('class'=>'btn btn-success'));



        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));





        $this->addElement($total_amount);
        $this->addElement($total_discount);
        $this->addElement($due_amount);
     	$this->addElement($coupon);
    	$this->addElement($verify);
    	$this->addElement($submit);




    }


}

