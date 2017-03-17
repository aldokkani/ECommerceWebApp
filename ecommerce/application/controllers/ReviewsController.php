<?php

class ReviewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listallAction()
    {
        // action body
        $rev_model = new Application_Model_UserProductReview();
        $this->view->all_reviews = $rev_model->selectAll();
    }

    public function detailsAction()
    {
        // action body
        $rev_model = new Application_Model_UserProductReview();
        $uid=$_GET['uid'];
        $pid=$_GET['pid'];
        // $requestparams=$this->_request->getParams();
        // foreach($requestparams as $key => $value) {
        //   switch ($key) {
        //   case 'uid':
        //     $u_id=$value[$key];
        //       //set value for something
        //       break;
        //   case 'pid':
        //     $p_id=$value[$key];
        //       //set value for something else
        //       break;
        //   }
        // }
        // $id= $this->_request->getParam('u_id');
        $reviewData=$rev_model->selectOne($uid,$pid);
        $this->view->rev_data=$reviewData;
    }

    public function deleteAction()
    {
        // action body
        $rev_model = new Application_Model_UserProductReview();
        $uid=$_GET['uid'];
        $pid=$_GET['pid'];
        // $rev_id = $this->_request->getParam("cid");
        $rev_model->deleteReview($uid,$pid);
        $this->redirect("/reviews/listall");
    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_ReviewForm();
        $request = $this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
              $rev_model = new Application_Model_UserProductReview();
              $rev_model-> addNewReview($request->getParams());
              $this->redirect('/reviews/listall');
            }
          }
      $this->view->rev_form = $form;
    }

    public function listAllByProductAction()
    {
        // action body
        $rev_model = new Application_Model_UserProductReview();
        $this->view->all_reviews = $rev_model->selectAllByProduct(3);
    }

    public function listAllByUserAction()
    {
        // action body
        $rev_model = new Application_Model_UserProductReview();
        $this->view->all_reviews = $rev_model->selectAllByUser(1);
    }


}
