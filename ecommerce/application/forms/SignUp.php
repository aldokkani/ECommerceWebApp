<?php

class Application_Form_SignUp extends Zend_Form {

    public function init() {
        $this->setMethod('POST');
        $fname = new Zend_Form_Element_Text('fullname');
        $fname->setLabel('Full Name');
        $fname->setRequired();
        $fname->addValidator('StringLength', false, array(3, 50));
        $fname->addFilter('StringTrim');
        $fname->setAttribs(array(
            'class' => 'input-xlarge',
            'placeholder' => 'Enter your full name'
        ));

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail');
        $email->setRequired();
        $email->addValidator('EmailAddress');
        $email->setAttribs(array(
            'class' => 'input-xlarge',
            'placeholder' => 'Enter your email'
        ));

        
        $passwd = new Zend_Form_Element_Password('passwd');
        $passwd->setLabel('Password')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'input-xlarge',
                    'placeholder' => 'Enter your password'
        ));

        $conf_passwd = new Zend_Form_Element_Password('conf_passwd');
        $conf_passwd->setLabel('Re-type Password')
                ->setRequired()
                ->addValidator('Identical', false, array('token' => 'passwd'))
                ->setAttribs(array(
                    'class' => 'input-xlarge',
                    'placeholder' => 'Re-enter your password'
        ));

        $submit = new Zend_Form_Element_Submit('Sign Up');
        $submit->setAttribs(array(
            'class' => 'btn btn-inverse large',
            'name' => 'register_submit'
        ));

        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->setAttribs(array(
            'class' => 'btn large'
        ));

        $this->addElements(
                array($fname, $email, $passwd, $conf_passwd, $submit, $reset)
        );
    }

}
