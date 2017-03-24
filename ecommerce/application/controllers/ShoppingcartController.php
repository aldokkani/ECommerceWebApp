<?php
//session_start();

class ShoppingcartController extends Zend_Controller_Action
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
        
//        (new Application_Model_Shoppingcartdetails())->updateItemInCart(42, 3);
//        $shopping_cart = (new Application_Model_Shoppingcart())->fetchAll("id= 12")->toArray()[0];
////        $product = (object)(new Application_Model_Products())->selectOne(19);
//////        var_dump($shopping_cart->discount);exit();
////         (new Application_Model_Shoppingcartdetails())->addItemToCart($shopping_cart, $product);
//        var_dump((new Application_Model_Shoppingcartdetails())->listShoppingCartDetails(4));exit();
////        var_dump($this->userData);exit;
//        $cop = (new Application_Model_Coupon())->selectOne(2);
////        var_dump($cop->updateCoupon(2,3));exit;
//        (new Application_Model_Shoppingcart())->checkOutCart($this->userData, $shopping_cart, $cop);
        
    }

    public function additemtocartAction()
    {
        // action body
        $product_id = $this->_request->getParam("product_id");
        //Add the Product to the Shopping Cart
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
        $this->view->shop_cart_details = $shopping_cart_details_model->addItemToCart($this->userData->id, $this->userData->cart_id ,$product_id);
        //Redirect to Main shopping cart 
        $this->redirect('/shoppingcart/mycart');
    }

    public function createuseremptycartAction()
    {
        // action body
        $shopping_cart_model = new Application_Model_Shoppingcart();
        $shopping_cart_model->AddUserEmptyCart($this->userData->id);

    }

    public function mycartAction()
    {
        // action body
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
//        var_dump($this->userData->id);exit;
        $this->view->all_cart_details = $shopping_cart_details_model->listShoppingCartDetails($this->userData->id);
//        var_dump($this->view->all_cart_details);exit;
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
                $shopping_cart_model->checkOutCart($this->userData->cart_id,$request->getParams()['coupon_id']);
                echo "checked out with coupon ";               
            }
        }        
        else
        {
            $shopping_cart_model = new Application_Model_Shoppingcart();
            $shopping_cart_model->checkOutCart($this->userData->cart_id);
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





















