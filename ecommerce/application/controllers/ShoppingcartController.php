<?php
//session_start();

class ShoppingcartController extends Zend_Controller_Action
{
    private  $userData;    
    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->userData = $auth->getIdentity();
    }

    public function indexAction()
    {          
    }

    public function additemtocartAction()
    {
        $product_id = $this->_request->getParam("product_id");        
        $product_model = new Application_Model_Products();
        $productData = $product_model->selectOne($product_id);
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
        $this->view->shop_cart_details = $shopping_cart_details_model->addItemToCart($this->userData->cart_id ,$productData);        
        $this->redirect('/shoppingcart/mycart');
    }

    public function createuseremptycartAction()
    {
        $shopping_cart_model = new Application_Model_Shoppingcart();
        $shopping_cart_model->AddUserEmptyCart($this->userData->id);
    }

    public function mycartAction()
    {
        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
        $this->view->all_cart_details = $shopping_cart_details_model->listShoppingCartDetails($this->userData->id);
    //-----------------------------------------------------
         $category_obj=new Application_Model_Category();
        $this->view->all_categories=$category_obj->selectAll();
        

        
    }

    public function removeitemfromcartAction()
    {
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
                $coupon_model = new Application_Model_Coupon();
                $coupon =$coupon_model->selectOne($request->getParams()['coupon_id']);

                $shopping_cart_model = new Application_Model_Shoppingcart();
                $shopping_cart_model->checkOutCart($this->userData,$this->userData->cart_id,$coupon);
                echo "checked out with coupon ";               
            }
        }        
        else
        {
            $shopping_cart_model = new Application_Model_Shoppingcart();
            $shopping_cart_model->checkOutCart($this->userData, $this->userData->cart_id);
            echo "checked out with  NO coupon ";        
        }   
        $this->redirect('/products');
    }

    public function updateshoppingcartquantityAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        // action body
        $detail_id = $this->_request->getParam("shopping_cart_det_id");
        $quantity = $this->_request->getParam("new_quantity");
        $shopping_cart_det_model = new Application_Model_Shoppingcartdetails();
        $shopping_cart_det_model->updateItemInCart($detail_id,$quantity);
        //to get the total amount to view it in the shopping cart
        $shopping_cart_model = new Application_Model_Shoppingcart();
        $shopping_cart_details = $shopping_cart_model->getUserShoppingCartWhereShoppingCartId($this->userData->cart_id['id']);
        echo $shopping_cart_details['total_amount']."|".$shopping_cart_details['discount']."|". $shopping_cart_details['due_amount'];

    }


}





















