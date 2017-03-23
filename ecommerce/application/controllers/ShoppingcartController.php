<?php
session_start();

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

    public function additemtocartAction()
    {
        // action body
        $product_id = $this->_request->getParam("product_id");
        //Add the Product to the Shopping Cart
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
        $this->view->shop_cart_details = $shopping_cart_details_model->addItemToCart($_SESSION['customer_id'],$_SESSION['shopping_cart_id'],$product_id);
        //Redirect to Main shopping cart 
        $this->redirect('/shoppingcart/mycart');
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
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
         $this->view->all_cart_details = $shopping_cart_details_model->listShoppingCartDetails($_SESSION['customer_id']);
        $request = $this->getRequest();
        if($request->isPost())
        {
            $quantity = $request->getParams()['quantity'];
        }
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
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
       
        $request = $this->getRequest();
        if(isset($request->getParams()['coupon_id']))
        {
            if(isset($request->getParams()['coupon_id']) && $request->getParams()['coupon_id'] != "")
            {
                $shopping_cart_model = new Application_Model_Shoppingcart();
                $shopping_cart_model->checkOutCart($_SESSION['shopping_cart_id'],$request->getParams()['coupon_id']);

                echo "checked out with coupon ";               
            }
        }        
        else
        {
            $shopping_cart_model = new Application_Model_Shoppingcart();
            $shopping_cart_model->checkOutCart($_SESSION['shopping_cart_id']);
            echo "checked out with  NO coupon ";        
        }   
        $this->redirect('/products');
    }

    public function updateshoppingcartquantityAction()
    {
        // action body
        $detail_id = $this->_request->getParam("shopping_cart_det_id");
        $quantity = $this->_request->getParam("new_quantity");
        $shopping_cart_det_model = new Application_Model_Shoppingcartdetails();
        $shopping_cart_det_model->updateItemInCart($detail_id,$quantity);
        echo $detail_id ;
        echo $quantity ;
    }


}





















