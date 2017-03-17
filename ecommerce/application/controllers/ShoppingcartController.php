<?php

class ShoppingcartController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listshoppingcartAction()
    {
        // action body       
    }


    //TODO We need to discuss to get last shopping cart because each customer has multiple shopping carts
    public function getusershoppingcartAction()
    {
        $userid = 1;

        $shopping_cart_model = new Application_Model_ShoppingCart();       
        $this->view->shopping_cart = $shopping_cart_model->getUserShoppingCart($userid);

        $shopping_cart_id = $shopping_cart_model->getUserShoppingCart($userid)['id'];

        $shopping_cart_details_model = new Application_Model_ShoppingCartDetails();        
        $this->view->shopping_cart_details = $shopping_cart_details_model->ShoppingCartDetails($shopping_cart_id);
        // action body
    }

    public function additemtoshoppingcartAction()
    {
        

        // action body
        //Get the shopping cart id of the user 
        //Get data from user product id, quantity , unit price , discount
        //Insert into shopping cart details where shopping cart id is shopping cart user id 
        //Check if Shopping cart table contains shopping cart for the user
        //Insert new record into shopping cart table if there is no record exists
        //Update shopping cart table total_amount, discount, and due_amount
        

        // $form = new Application_Form_User();
        // $this->view->user_form = $form;

        // $request = $this->getRequest();
        // if($request->isPost()){
        //     if($form->isValid($request->getParams()))
        //     {
        //         $user_model = new Application_Model_User();
        //         $user_model->addNewUser($request->getParams());
        //         $this->redirect('/user/list');

        //     }
        // }
    }


}







