<?php

class Application_Form_CatForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        $name = new Zend_Form_Element_Text('name');  // <input type="text" name="fname" class="form-control">
        $name->setLabel('Name: ');
        $name->setAttribs(array('class'=>'form-control','placeholder'=>'example:sports'));   //style
        $name->setRequired();

        $parent = new Zend_Form_Element_Select('parent_cat_id');  // drop down list
        $catModel = new Application_Model_Category();
        $allcats = $catModel->selectAll();
        foreach ($allcats as $key => $value){
          $parent->addMultiOption($value['id'],$value['name']);
        }
        $parent->setLabel('parent:');
        $parent->setAttribs(array('class'=>'form-control'));

        $submit= new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));

        $reset= new Zend_Form_Element_Submit('reset');
        $reset->setAttribs(array('class'=>'btn btn-danger'));

        $this->addElements(array(
          $name,
          $parent,
          $submit,
          $reset
        ));
    }


}
