<?php

class WishlistController extends Zend_Controller_Action
{
    private  $userData;
    
    public function init()
    {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        $this->userData = $auth->getIdentity();
    }
    public function indexAction()
    {
        // action body
    }

    public function addItemToWishlistAction()
    {
        // action body
        $product_id=$this->_request->getParam('product_id');
        $wishlist_obj=new Application_Model_Wishlist();
        $check=$wishlist_obj->checkOnProduct($product_id,$this->userData->id);
        //echo $this->userData->id;  die();
        if ($check)
        {
            $this->redirect('wishlist/my-wishlist');
        }
        else 
        {
            $wishlist_obj->addToWishlist($this->userData->id, $product_id);
            $this->redirect('wishlist/my-wishlist');
        }
        
        
        
    }

    public function myWishlistAction()
    {
        // action body
        $wishlist_obj=new Application_Model_Wishlist();
        $wishlist_items=$wishlist_obj->selectAll($this->userData->id);
        $this->view->mywishlist_items_ctx=$wishlist_items;
        
        
    }

    public function deleteWishlistItemAction()
    {
        // action body
        $product_id=$this->_request->getParam('product_id');
        $wishlist_obj=new Application_Model_Wishlist();
        $wishlist_obj->deleteFromWishlist($this->userData->id, $product_id);
        $this->redirect('wishlist/my-wishlist');

    }


}







