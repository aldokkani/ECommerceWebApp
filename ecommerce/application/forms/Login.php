<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
            ->setRequired()
            ->setAttribs(array(
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

        $submit = new Zend_Form_Element_Submit('Login');
        $submit->setAttribs(array(
            'class' => 'btn btn-inverse large',
            'name' => 'login_submit'
        ));

        $this->addElements(array($email, $passwd, $submit));
    }


}
