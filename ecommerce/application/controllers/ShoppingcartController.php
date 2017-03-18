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

    public function listproductsAction()
    {
        // action body
//         $user_model = new Application_Model_User();
// $this->view->users = $user_model->listUsers();
        $products_array = array('1','2', '3');
        $this->view->products = $products_array;
    }

    public function additemtocartAction()
    {
        // action body
        $product_id = $this->_request->getParam("product_id");
        // var_dump($product_id);
        // die();

        $shopping_cart_id = 1;
        $customer_id =1;
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();

        $this->view->shop_cart_details = $shopping_cart_details_model->addItemToCart($customer_id,$shopping_cart_id,$product_id);

        //then load all other details

        //of cart
        //redirect to action list of shopping cart or main shopping cart 
        $this->redirect('/shoppingcart/mycart');
       

    }

    public function productdetailsAction()
    {
        // action body
        $product_details = '1';
        $this->view->product_details = $product_details;
    }

    public function createuseremptycartAction()
    {
        // action body
        $shopping_cart_model = new Application_Model_Shoppingcart();

        $shopping_cart_model->AddUserEmptyCart();

    }

    public function mycartAction()
    {
        // action body
        $customer_id =1;
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();

         $this->view->all_cart_details = $shopping_cart_details_model->listShoppingCartDetails($customer_id);
    }

    public function removeitemfromcartAction()
    {
        // action body
        $detail_id = $this->_request->getParam("shopping_cart_det_id");

        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
        $shopping_cart_details_model->removeItemFromCart($detail_id);

        $this->redirect('/shoppingcart/mycart');
    }

    public function checkoutAction()
    {
        // action body
        $form = new Application_Form_Checkout();
        $this->view->checkout_form = $form;

        $request = $this->getRequest();
        if($request->isPost())
        {
            // var_dump($request->getParams());
            // die();
             $shopping_cart_id =1;
            if($request->getParams() == "verify")
            {
                //if this code is valid >> 
               
                
                $shopping_cart_model = new Application_Model_Shoppingcart();
                $shopping_cart_model->checkOutCart($shopping_cart_id);
                

            }
            else
            {
                $shopping_cart_model = new Application_Model_Shoppingcart();
                $shopping_cart_model->checkOutCart($shopping_cart_id);
                
            }



            // if($form->isValid($request->getParams()))
            // {
        
            //     $user_model = new Application_Model_Shoppingcart();
            //     $user_model->checkOutCart($request->getParams());
            //     $this->redirect('/user/list');

            // }
        }

        // $shopping_cart_model = new Application_Model_Shoppingcart();
        // $shopping_cart_model->checkOutCart();

    }


}















