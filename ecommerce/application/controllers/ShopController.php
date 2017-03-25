<?php

class ShopController extends Zend_Controller_Action
{
    private  $userData;

    public function init()
    {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        $this->userData = $auth->getIdentity();
        if (!$auth->hasIdentity() || $this->userData->type != 'shop' ) {
            $this->redirect('/');
            return;
        }
    }

    public function indexAction()
    {
        $product_model = new Application_Model_Products();
        $this->view->all_productsByVendor = $product_model->SelectAllProductsWithOfferByVendor($this->userData->id);

    }

    public function detailsAction() {
        // action body
        $id = $this->_request->getParam('product_id');
        $offer_model = new Application_Model_Offer();
        $offerData = $offer_model->selectByProduct($id);
        $product_model = new Application_Model_Products();
        $productData = $product_model->selectOne($id);
        $review_model2 = new Application_Model_UserProductReview();
        $comments = $review_model2->selectCommentByProduct($id);
        $this->view->comments = $comments;
        $this->view->product_data = $productData;
        $this->view->offer_data = $offerData;
        $form = new Application_Form_CommentForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $review_model = new Application_Model_UserProductReview();
                $user_id = 1;
                $product_id = 19;
                $rateValue = 0;
                $comment = $this->_request->getParam('comment');
                $review_model->addNewReview($user_id, $product_id, $rateValue, $comment);
                $this->redirect('/shop/details/product_id/' . $id);
            }
        }
        $this->view->new_comment_form = $form;
    }

//    public function listAllByVendorAction() {
//        // action body
//        $product_model = new Application_Model_Products();
//        $vendor_id = $this->_request->getParam('vendor_id');
//        // var_dump($vendor_id);exit();
//        $this->view->all_productsByVendor = $product_model->selectAllByVendor($vendor_id);
//    }

    public function addAction() {
        // action body
        $form = new Application_Form_NewProductForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $product_model = new Application_Model_Products();
                $product_model->addProduct($request->getParams(), $this->userData->id);
                $this->redirect('/shop');
            }
        }
        $this->view->newProduct_form = $form;
    }

    public function editAction() {
        // action body
        $form = new Application_Form_NewProductForm();
        $product_model = new Application_Model_Products();
        $id = $this->_request->getParam('product_id');
        $product_data = $product_model->selectOne($id);
        $form->populate($product_data);
        $this->view->product_form = $form;

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $product_model->editProduct($id, $_POST);
                $this->redirect('/shop');
            }
        }
    }

    public function deleteAction() {
        // action body
        $product_model = new Application_Model_Products();
        $product_id = $this->_request->getParam("product_id");
        $product_model->deleteProduct($product_id);
        $this->redirect("/shop");
    }

    public function vendorOfferAction() {
        // action body
        $form = new Application_Form_NewOfferForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $product_model = new Application_Model_Offer();
                $product_id = $this->_request->getParam('product_id');
                $product_model->addOffer($request->getParams(), $product_id);
                $this->redirect('/shop/details/product_id/' . $product_id);
            }
        }
        $this->view->newOffer_form = $form;
    }

    public function deleteOfferAction() {
        // action body
        $offer_model = new Application_Model_Offer();
        $product_id = $this->_request->getParam("product_id");
        $offer_model->deleteOffer($product_id);
        $this->redirect("/shop/details/product_id/" . $product_id);
    }
}
