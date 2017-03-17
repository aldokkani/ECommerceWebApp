<?php

class Application_Form_ReviewForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        $product_id = new Zend_Form_Element_Text('product_id');  // <input type="text" name="fname" class="form-control">
        $product_id->setLabel('product ID: ');
        $product_id->setAttribs(array('class'=>'form-control'));   //style
        $product_id->setRequired();

        $user_id = new Zend_Form_Element_Text('user_id');  // <input type="text" name="fname" class="form-control">
        $user_id->setLabel('User ID: ');
        $user_id->setAttribs(array('class'=>'form-control'));   //style
        $user_id->setRequired();

        $rate = new Zend_Form_Element_Select('parent_cat_id');  // drop down list
        for ($i=1;$i<=5;$i++){
          $rate->addMultiOption($i,$i);
        }
        $rate->setLabel('Rate: ');
        $rate->setAttribs(array('class'=>'form-control'));

        $comment = new Zend_Form_Element_Text('comment');  // <input type="text" name="fname" class="form-control">
        $comment->setLabel('comment: ');
        $comment->setAttribs(array('class'=>'form-control'));   //style
        $comment->setRequired();

        $submit= new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));

        $reset= new Zend_Form_Element_Submit('reset');
        $reset->setAttribs(array('class'=>'btn btn-danger'));

        $this->addElements(array(
          $user_id,
          $product_id,
          $rate,
          $comment,
          $submit,
          $reset
        ));
    }


}
