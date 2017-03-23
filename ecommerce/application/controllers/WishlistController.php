<?php

class WishlistController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addItemToWishlistAction()
    {
        // action body
        $product_id=$this->_request->getParam('product_id');
        $customer_id=1;
        $wishlist_obj=new Application_Model_Wishlist();
        $check=$wishlist_obj->checkOnProduct($product_id);
        if ($check)
        {
            $this->redirect('wishlist/my-wishlist');
        }
        else 
        {
            $wishlist_obj->addToWishlist($customer_id, $product_id);
            $this->redirect('wishlist/my-wishlist');
        }
        
        
        
    }

    public function myWishlistAction()
    {
        // action body
        $customer_id=1;
        $wishlist_obj=new Application_Model_Wishlist();
        $wishlist_items=$wishlist_obj->selectAll($customer_id);
        $this->view->mywishlist_items_ctx=$wishlist_items;
        
        
    }

    public function deleteWishlistItemAction()
    {
        // action body
        $customer_id=1;
        $product_id=$this->_request->getParam('product_id');
        $wishlist_obj=new Application_Model_Wishlist();
        $wishlist_obj->deleteFromWishlist($customer_id, $product_id);
        $this->redirect('wishlist/my-wishlist');

    }


}







