<?php

class Application_Form_Addtocart extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        $product = new Zend_Form_Element_Select('product');
        $product->setlabel('product');
        $product->setAttribs(array('class'=>'form-control'));
        $productModel = new Application_Model_Product();
        $product ->addMultiOption(1,1);       
        $quantity = new Zend_Form_Element_Text('quantity');
        $quantity->setlabel('quantity: ')
        ->setAttribs(array(
        		'class'=>'form-control',
        		'placeholder'=>'example: 1'
        		));
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));

    }
}

