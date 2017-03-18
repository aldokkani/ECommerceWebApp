<?php

class Application_Form_Shoppingcart extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        //********** WARNING ***** Static Data *****//
        $customer_id = 1;

        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
        $allShoppingCartDetails = $shopping_cart_details_model->listShoppingCartDetails($customer_id);

        foreach ($allTracks as $key => $value) {
            $track->addMultiOption($value['tr_name'], $value['tr_name']);
        }
        //<input type='text' name='fname' class='form-control'/>
        /* Form Elements & Other Definitions Here ... */
        $fname = new Zend_Form_Element_Text('fname');
        $fname->setlabel('First Name: ')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'example: Ahmed'
                ))
                ->setRequired()
                ->addValidator('StringLength', false, Array(4, 20))
                ->addFilter('StringTrim');


        $lname = new Zend_Form_Element_Text('lname');
        $lname->setlabel('Lirst Name: ');
        $lname->setAttribs(array(
            'class' => 'form-control',
            'placeholder' => 'example: Ali'
        ));



        $email = new Zend_Form_Element_Text('email');
        $email->setlabel('Email: ');
        $email->setAttribs(array(
            'class' => 'form-control',
            'placeholder' => 'example: nada.bayoumy@hotmail.com'
        ));






        $track = new Zend_Form_Element_Select('track');
        // $track->addMultiOption('opensource','OS');
        // $track->addMultiOption('systemadmin','SA');
        // $track->addMultiOption('systemdevelopment','SD');

        $track->setlabel('track');
        $track->setAttribs(array('class' => 'form-control'));

        $trackModel = new Application_Model_Track();
        $allTracks = $trackModel->getAllTracks();

        foreach ($allTracks as $key => $value) {
            $track->addMultiOption($value['tr_name'], $value['tr_name']);
        }




        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class' => 'btn btn-success'));


        $reset = new Zend_Form_Element_Reset('reset');
        $reset->setAttribs(array('class' => 'btn btn-danger'));





        $lname->setRequired();
        $lname->addValidator('StringLength', false, Array(4, 20));
        $lname->addFilter('StringTrim');

        $email->setRequired();
        $email->addFilter('StringTrim');
        $email->addValidator('StringLength', false, Array(4, 20));



        $track->setRequired();
        $track->addValidator('StringLength', false, Array(4, 20));
        $track->addFilter('StringTrim');




        $this->addElement($email);
        $this->addElement($fname);
        $this->addElement($lname);
        $this->addElement($track);
        $this->addElement($submit);
        $this->addElement($reset);
    }
}
