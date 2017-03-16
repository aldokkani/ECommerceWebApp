<?php

class Application_Form_SignUp extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');
        //fullname-------------------------------------------------
        $fullname=new Zend_Form_Element_Text('fullname');
        $fullname->setLabel('Full Name : ');
        $fullname->setAttribs(array(
          'class'=>'form-control',
          'placeholder'=>'example: Mahmoud Magdy Kamel'
        ));
        $fullname->setRequired();
        $fullname->addValidator('StringLength', false, Array(3,45));
        $fullname->addFilter('StringTrim');
        //email------------------------------------------------
        $email=new Zend_Form_Element_Text('email');
        $email->setLabel('Email Address: ');
        $email->setAttribs(array(
          'class'=>'form-control',
          'placeholder'=>'example:mahmoudmagdy@gmail.com'
        ));
        $email->setRequired();
        //password---------------------------------------------
        $password=new Zend_Form_Element_Password('password');
        $password->setLabel('Password: ')
                 ->setRequired(true)
                 ->setAttrib('class', 'form-control');
        //confirm Password--------------------------------------
        $cnf_password=new Zend_Form_Element_Password('cnf_password');
        $cnf_password->setLabel('Confirm Password : ')
                 ->setRequired(true)
                 ->setAttrib('class', 'form-control');
        //Type-------------------------------------------------------
//        $type= new Zend_Form_Element_Radio('type');
//        $type->setLabel('Choose User Type : ');
//        $type->setValueOptions(array(
//        '0' => 'CustomerUser',
//        '1' => 'ShopUser',
//        '2' => 'AdminUser'
//        ));
//        $type->setRequired(true)
//             ->setAttrib('class', 'form-control');
        //submit-----------------------------------------------------
        $submit=new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array(
          'class'=>'btn btn-success'
        ));
        //reset------------------------------------------------------
        $reset=new Zend_Form_Element_Reset('reset');
        $reset->setAttribs(array(
          'class'=>'btn btn-danger'
        ));
        //-----------------------------------------------------------
        $this->addElements(array(
          $fullname,
          $email,
          $password,
          $cnf_password,
          //$type,
          $submit,
          $reset
        ));
    }


}

