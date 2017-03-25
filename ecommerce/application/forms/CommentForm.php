<?php

class Application_Form_CommentForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');

        $comment = new Zend_Form_Element_Textarea('comment');  // <input type="text" name="fname" class="form-control">
        $comment->setLabel('Add comment: ');
        $comment->setAttribs(array('style'=>'width: 540px;','ROWS'=>'4', 'placeholder'=>'example:this is amazing product , all my family loved it'));   //style


        $submit= new Zend_Form_Element_Submit('Submit');
        $submit->setAttribs(array('class'=>'btn ','style'=>'background-color:#f5f5f5'));
        $submit->setLabel('Add comment');
        $this->addElements(array(
          $comment,
          $submit
        ));
    }


}
