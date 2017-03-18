<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $products_obj=new Application_Model_Products();
        //$this->view->all_products_ctx=$products_obj->listProducts();
        $this->view->new_products=$products_obj->getNewProducts();
        //-----------------------------------------------------------
        $category_id=$this->_request->getParam("category_id");
        $this->view->category_products=$products_obj->getCategoryProducts($category_id);
        //----------------------------------------------------------
        $category_obj=new Application_Model_Category();
        $this->view->all_categories_ctx=$category_obj->selectAll();
        
        
    }

   
}



