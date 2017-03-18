<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        /* Displays the managments pages for Categories and Users */
        $this->view->categories = (new Application_Model_Category())->selectAll();
        $this->view->users = (new Application_Model_User())->selectAll();
    }

//    public function usersAction()
//    {
//        $this->view->users = (new Application_Model_User())->selectAll();
//    }

    public function blockAction()
    {
        /* Blocks an activated user */
        (new Application_Model_User())->blockUser($this->_request->getParam('uid'));
        $this->redirect('admin/');
    }

    public function activateAction()
    {
        /* Activates a blocked user */
        (new Application_Model_User())->activateUser($this->_request->getParam('uid'));
        $this->redirect('admin/');
    }

    public function couponAction()
    {
        /** Generates a coupon and send it to the customer's email */
        $discount = $this->getRequest()->getParam('discount');
        $coupon_str = (new Application_Model_Coupon())->generateCoupon($discount);
        $user = (new Application_Model_User())->selectOne($this->_request->getParam('uid'));
        
        $mailBody = "Hello Mr/Mrs ".$user['fullname'].",\n\nWe have made a discount for "
                . "you with amount of ".$discount."% for upcoming purchase order."
                . "\nWrite this in discount field when purchasing next time:"
                . "\n\n\t".$coupon_str
                . "\n\nHave a nice day. :)";
        
        $mailInfo = [
            'cust_name' => $user['fullname'],
            'cust_mail' => $user['email'],
            'mail_body' => $mailBody,
            'mail_subject' => "ECommerce Discount Coupon"
            ];
        
        (new Application_Model_Email())->sendMail($mailInfo);
        $this->redirect('admin/');
    }

//    public function categoriesAction()
//    {
//        $this->view->categories = (new Application_Model_Category())->selectAll();
//    }

    public function editcatAction() 
    {
        /* Edits a category */
        $form = new Application_Form_CatForm();
        $cat_model = new Application_Model_Category();
        $cat_id = $this->getRequest()->getParam('cat_id');
        $category = $cat_model->selectOne($cat_id);
        $form->populate($category);
        $this->view->cat_form = $form;
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat_model->editCategory($cat_id, $request->getParams());
                $this->redirect('admin/');
            }
        }
        
    }

    public function delcatAction() 
    {
        /* Deletes a category */
        (new Application_Model_Category())->deleteCategory($this->getRequest()->getParam('cat_id'));
        $this->redirect('admin/');
    }

    public function addcatAction() 
    {
        /* Adds a category */
        $form = new Application_Form_CatForm();
        $this->view->cat_form = $form;
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat_model = new Application_Model_Category();
                $cat_model->addNewCategory($request->getParams());
                $this->redirect('admin/');
            }
        }
    }


}














