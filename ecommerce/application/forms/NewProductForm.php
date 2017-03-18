<?php

class Application_Form_NewProductForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        $name_en = new Zend_Form_Element_Text('name_en');  // <input type="text" name="fname" class="form-control">
        $name_en->setLabel('English Name: ');
        $name_en->setAttribs(array('class'=>'form-control','placeholder'=>'example:laptop'));   //style
        $name_en->setRequired();

        $name_ar = new Zend_Form_Element_Text('name_ar');  // <input type="text" name="fname" class="form-control">
        $name_ar->setLabel('Arabic Name: ');
        $name_ar->setAttribs(array('class'=>'form-control','placeholder'=>'example:لاب توب'));   //style
        $name_ar->setRequired();

        $description_en = new Zend_Form_Element_Text('description_en');  // <input type="text" name="fname" class="form-control">
        $description_en->setLabel('English description: ');
        $description_en->setAttribs(array('class'=>'form-control'));   //style
        $description_en->setRequired();

        $description_ar = new Zend_Form_Element_Text('description_ar');  // <input type="text" name="fname" class="form-control">
        $description_ar->setLabel('Arabic description: ');
        $description_ar->setAttribs(array('class'=>'form-control'));   //style
        $description_ar->setRequired();

        $unit_price = new Zend_Form_Element_Text('unit_price');  // <input type="text" name="fname" class="form-control">
        $unit_price->setLabel('Unir price: ');
        $unit_price->setAttribs(array('class'=>'form-control'));   //style
        $unit_price->setRequired();
        $unit_price->addValidator('Digits');

        $photo = new Zend_Form_Element_Text('photo');  // <input type="text" name="fname" class="form-control">
        $photo->setLabel('Put image link: ');
        $photo->setAttribs(array('class'=>'form-control'));   //style
        $photo->setRequired();

        $category = new Zend_Form_Element_Select('category_id');
        $category->setLabel('Category:');
        $category->setAttribs(array('class'=>'form-control'));
        $catModel = new Application_Model_Category();
        $allcats = $catModel->selectAll();
        foreach ($allcats as $key => $value){
          $category->addMultiOption($value['id'],$value['name']);
        }


        $submit= new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));

        $reset= new Zend_Form_Element_Submit('reset');
        $reset->setAttribs(array('class'=>'btn btn-danger'));

        $this->addElements(array(
          $name_en,
          $name_ar,
          $description_en,
          $description_ar,
          $unit_price,
          $photo,
          $category,
          $submit,
          $reset
        ));
    }


}
