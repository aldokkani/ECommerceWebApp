<?php

class Application_Model_Email
{
    public function sendMail($mailInfo) {
        // uncomment this 'extension=php_openssl.dll' line in php.ini
        $tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', array(
            'auth'     => 'login',
            'username' => 'ecommerce.zend@gmail.com',
            'password' => 'ecommerce.zend*',
            'port'     => '587',
            'ssl'      => 'tls',
        ));
        
        try {
            $mail = new Zend_Mail();
            $mail->setBodyText($mailInfo['mail_body']);
            $mail->setFrom('ecommerce.zend@gmail.com', 'ECommerce');
            $mail->addTo($mailInfo['cust_mail'], $mailInfo['cust_name']);
            $mail->setSubject($mailInfo['mail_subject']);
            $mail->send($tr);
            return 1;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();exit;
            echo 'Faild to send mail';exit();
        }
    }

}

