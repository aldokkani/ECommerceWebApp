<?php

class AdminController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        $userData = $auth->getIdentity();
        if (!$auth->hasIdentity() || $userData->type != 'admin') {
            $this->redirect('/');
            return;
        }
    }

    public function indexAction() {
        /* Displays the managments pages for Categories and Users */
        $this->view->categories = (new Application_Model_Category())->selectAll();
        $this->view->users = (new Application_Model_User())->selectAll();
    }

    public function blockAction() {
        /* Blocks an activated user */
        (new Application_Model_User())->blockUser($this->_request->getParam('uid'));
        $this->redirect('admin/');
    }

    public function activateAction() {
        /* Activates a blocked user */
        (new Application_Model_User())->activateUser($this->_request->getParam('uid'));
        $this->redirect('admin/');
    }

    public function couponAction() {
        /** Generates a coupon and send it to the customer's email */
        $discount = $this->getRequest()->getParam('discount');
        $coupon_str = (new Application_Model_Coupon())->generateCoupon($discount);
        $user = (new Application_Model_User())->selectOne($this->_request->getParam('uid'));

        $mailBody = "Hello Mr/Mrs " . $user['fullname'] . ",\n\nWe have made a discount for "
                . "you with amount of " . $discount . "% for upcoming purchase order."
                . "\nWrite this in discount field when purchasing next time:"
                . "\n\n\t" . $coupon_str
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

    public function editcatAction() {
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

    public function delcatAction() {
        /* Deletes a category */
        (new Application_Model_Category())->deleteCategory($this->getRequest()->getParam('cat_id'));
        $this->redirect('admin/');
    }

    public function addcatAction() {
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

    public function statisticsAction() {
        // action body
        $products_model = new Application_Model_Products();
        $statistics_model = new Application_Model_Statistics();
        $this->view->all_products = $products_model->SelectAll();
        $all_products = $products_model->SelectAll();
        
        $counter = 0;
        $products = [];
        foreach ($all_products as $product) {
            //print_r($value['id']);
//            $product_id=$value['id'];
            //$this->view->users_num_ctx=$statistics_model->getProductUsers($product_id);
            $usersCount = $statistics_model
                            ->getProductUsers($product['id'])[0]['users_num'];
            $totalRevenue=$statistics_model
                            ->totalRevenue($product['id'])[0]['total_revenue'];
            $topProduct=$statistics_model
                            ->topProductOfCategory($product['category_id']); //[0]['name_en'];
            $trueTopProduct = ($topProduct) ? $topProduct[0]['name_en'] : "No Top Product" ;
            $categoryRevenue=$statistics_model
                            ->categoryRevenue($product['category_id'])[0]['category_revenue'];
//                   var_dump($statistics_model
//                            ->getProductUsers($product['id'])[0]['users_num']);exit;
//            $product['users_num'] = $usersCount;
            $products[$counter]['p_name'] = $product['name_en'];
            $products[$counter]['p_cat'] = $product['category_id'];
            $products[$counter]['users_num'] = $usersCount;
            $products[$counter]['totalrevenue']=$totalRevenue;
            $products[$counter]['top_product']=$trueTopProduct;
            $products[$counter]['category_revenue']=$categoryRevenue;
            
            //$this->view->all_products=$products[$counter];
            $counter++;
            
        }
        //var_dump($products);die;
         $this->view->all_products=$products;
    }

}
