<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        
        $products_obj = new Application_Model_Products();
        $this->view->new_products = $products_obj->getNewProducts();
        $this->view->feature_products = $products_obj->getFeatureProducts();
        
        $category_obj = new Application_Model_Category();
        $this->view->all_categories_ctx = $category_obj->selectAll();
    }

}
