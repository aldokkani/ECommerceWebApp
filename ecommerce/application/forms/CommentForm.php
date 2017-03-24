<?php

class Application_Form_CommentForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        $comment = new Zend_Form_Element_Text('comment');  // <input type="text" name="fname" class="form-control">
        $comment->setLabel('Add comment: ');
        $comment->setAttribs(array('class'=>'input-xlarge','rows'=>'4','placeholder'=>'example:this is amazing product'));   //style
        // $comment->setAttrib("rows",4);


        $submit= new Zend_Form_Element_Submit('Submit');
        $submit->setAttribs(array('class'=>'btn btn-success '));

        $reset= new Zend_Form_Element_Submit('Reset');
        $reset->setAttribs(array('class'=>'btn btn-warning'));

        $this->addElements(array(
          $comment,
          $submit,
          $reset
        ));
    }


}
