<?php

class Application_Form_SignUp extends Zend_Form {

    public function init() {
        $this->setMethod('POST');
        $fname = new Zend_Form_Element_Text('fname');
        $fname->setLabel('First Name');
        $fname->setRequired();
        $fname->addValidator('StringLength', false, array(3, 10));
        $fname->addFilter('StringTrim');
        $fname->setAttribs(array(
            'class' => 'input-xlarge',
            'placeholder' => 'John'
        ));

        $lname = new Zend_Form_Element_Text('lname');
        $lname->setLabel('Last Name');
        $lname->setRequired();
        $lname->addValidator('StringLength', false, array(3, 10));
        $lname->addFilter('StringTrim');
        $lname->setAttribs(array(
            'class' => 'input-xlarge',
            'placeholder' => 'Mark'
        ));

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail');
        $email->setRequired();
        $email->addValidator('EmailAddress');
        $email->setAttribs(array(
            'class' => 'input-xlarge',
            'placeholder' => 'john_mark@example.me'
        ));

        
        $passwd = new Zend_Form_Element_Password('passwd');
        $passwd->setLabel('Password')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'input-xlarge',
        ));

        $conf_passwd = new Zend_Form_Element_Password('conf_passwd');
        $conf_passwd->setLabel('Re-type Password')
                ->setRequired()
                ->addValidator('Identical', false, array('token' => 'passwd'))
                ->setAttribs(array(
                    'class' => 'form-control',
        ));

        $submit = new Zend_Form_Element_Submit('Sign Up');
        $submit->setAttribs(array(
            'class' => 'btn btn-success',
            'name' => 'register_submit'
        ));

        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->setAttribs(array(
            'class' => 'btn btn-warning'
        ));

        $this->addElements(
                array($fname, $lname, $email, $passwd, $conf_passwd, $submit, $reset)
        );
    }

}
