<?php

class ProductsController extends Zend_Controller_Action {
  private $userData;
    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        $this->userData = $auth->getIdentity();
    }

    public function indexAction() {
        // action body

    }

    public function detailsAction() {
        // action body
        $id = $this->_request->getParam('product_id');
        $offer_model = new Application_Model_Offer();
        $offerData = $offer_model->selectByProduct($id);
        $product_model = new Application_Model_Products();
        $productData = $product_model->selectOne($id);
        $product_model2 = new Application_Model_Products();
        $all_products_data = $product_model2->SelectAll($id);
        $review_model2 = new Application_Model_UserProductReview();
        $comments = $review_model2->selectCommentByProduct($id);
        $this->view->comments = $comments;
        $this->view->all_products_data = $all_products_data;
        $this->view->product_data = $productData;
        $this->view->offer_data = $offerData;
        $form = new Application_Form_CommentForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $review_model = new Application_Model_UserProductReview();
                $product_id =  $this->_request->getParam('product_id');
                $rateValue = 0;
                $comment = $this->_request->getParam('comment');
                $review_model->addNewReview($this->userData->id, $product_id, $rateValue, $comment);
                $this->redirect('/products/details/product_id/' . $id);
            }
        }
        $this->view->new_comment_form = $form;
        $this->view->user_data = $this->userData;
    }

//    public function listAction() {
//        // action body
//        $product_model = new Application_Model_Products();
//        $result = $product_model->SelectAllProductsWithOffer(1);
//        // print_r($result);exit;
//        $this->view->all_products_with_offer = $result;
//        // $offer_model = new Application_Model_Offer();
//        // $this->view->all_offers=$offer_model->selectAll();
//    }

    public function calcRateAction() {
        // action body
        // $product_id = $this->_request->getParam('product_id');
        // echo $product_id;die;
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $rateValue = $this->_request->getParam('rate');
        $comment = "";
        $product_id= $this->_request->getParam('product_id');
        $review2_model = new Application_Model_UserProductReview();
        $review2_model->addNewReview($this->userData->id, $product_id, $rateValue, $comment);
        $review1_model = new Application_Model_UserProductReview();
        $avgRate = $review1_model->selectRateByProduct($product_id);
        echo $avgRate;
    }

    public function searchAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $productName = $this->_request->getParam('name');
        $products = (new Application_Model_Products())->searchByName($productName);
        echo json_encode($products);
    }

    public function displayAction() {
        $id = $this->_request->getParam('cid');
        $product_model = new Application_Model_Products();
        $result = $product_model->SelectAllProductsWithOffer($id);
        $this->view->all_products_with_offer = $result;
        //-----------------------------------------------
         $category_obj=new Application_Model_Category();
        $this->view->all_categories=$category_obj->selectAll();
        

    }

}
