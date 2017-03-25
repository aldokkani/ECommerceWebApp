<?php

class Application_Model_MyAuth {
    /* Logs the user in and creates his/her session with the required data. */

    public function login($id, $credential) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable(
                $db, 'users', 'email', 'password');
        $authAdapter->setIdentity($id)
                ->setCredential(md5($credential));
        if ($authAdapter->authenticate()->isValid()) {
            $auth = Zend_Auth::getInstance();
            $storage = $auth->getStorage();
            $userData = $authAdapter->getResultRowObject(array(
                'id', 'fullname', 'email', 'type', 'isactive'
                ));
            if (!$userData->isactive) {
                return 2; // when user is blocked
            }
            $userData->cart_id = (new Application_Model_Shoppingcart())
                    ->getUserShoppingCart($userData->id);
            $storage->write($userData);
            return 1; // when user is authenticated
        } else {
            return 0; // when user is not authenticated
        }
    }

}
