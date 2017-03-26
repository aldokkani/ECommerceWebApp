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
        
        $photo = new Zend_Form_Element_Text('photo');
        $photo->setLabel('Photo URL: ')
                ->setAttribs(array('class'=>'form-control','placeholder'=>'photo url'))
                ->setRequired();

//        $parent = new Zend_Form_Element_Select('parent_cat_id');  // drop down list
//        $catModel = new Application_Model_Category();
//        $allcats = $catModel->selectAll();
//        foreach ($allcats as $key => $value){
//          $parent->addMultiOption($value['id'],$value['name']);
//        }
//        $parent->setLabel('Parent Category:');
//        $parent->setAttribs(array('class'=>'form-control'));

        $submit= new Zend_Form_Element_Submit('Submit');
        $submit->setAttribs(array('class'=>'btn btn-success btn-block'));

        $reset= new Zend_Form_Element_Submit('Reset');
        $reset->setAttribs(array('class'=>'btn btn-warning btn-block'));

        $this->addElements(array(
          $name,
          $photo,
//          $parent,
          $submit,
          $reset
        ));
    }


}
