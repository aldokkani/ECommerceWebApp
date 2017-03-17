<?php

class UserProductReviewController extends Zend_Controller_Action
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
        $this->view->all_reviews = $rev_model->getAllReviews();
    }


}
