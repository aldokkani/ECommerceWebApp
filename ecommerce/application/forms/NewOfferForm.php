<?php

class Application_Form_NewOfferForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        $discount = new Zend_Form_Element_Text('discount');  // <input type="text" name="fname" class="form-control">
        $discount->setLabel('Discount % : ');
        $discount->setAttribs(array('class'=>'form-control','placeholder'=>'example:10'));   //style
        $discount->setRequired();
        $discount->addValidator('Digits');

        $start_date = new Zend_Form_Element_Text('start_date');  // <input type="text" name="fname" class="form-control">
        $start_date->setLabel('Start date: ');
        $start_date->setAttribs(array('class'=>'form-control','placeholder'=>'example:YYYY-MM-DD'));
        $start_date->setRequired();
        $start_date->addValidator('Date');
        // $start_date->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => "It can't be empty!")));

        $end_date = new Zend_Form_Element_Text('end_date');  // <input type="text" name="fname" class="form-control">
        $end_date->setLabel('End date: ');
        $end_date->setAttribs(array('class'=>'form-control','placeholder'=>'example:YYYY-MM-DD'));
        $end_date->setRequired();
        $end_date->addValidator('Date');

        $submit= new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));

        $reset= new Zend_Form_Element_Submit('reset');
        $reset->setAttribs(array('class'=>'btn btn-danger'));

        $this->addElements(array(
          $discount,
          $start_date,
          $end_date,
          $submit,
          $reset
        ));
    }


}
