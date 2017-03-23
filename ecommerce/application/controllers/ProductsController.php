<?php

class ProductsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $product_model = new Application_Model_Products();
        $this->view->all_products = $product_model->selectAll();
    }

    public function detailsAction()
    {
        // action body
        $id= $this->_request->getParam('product_id');
        $offer_model = new Application_Model_Offer();
        $offerData=$offer_model->selectByProduct($id);
        $product_model = new Application_Model_Products();
        $productData=$product_model->selectOne($id);
        $this->view->product_data=$productData;
        $this->view->offer_data=$offerData;


    }

    public function listAction()
    {
        // action body
        $product_model = new Application_Model_Products();
        $this->view->all_products = $product_model->selectAll();
        // $offer_model = new Application_Model_Offer();
        // $this->view->all_offers=$offer_model->selectAll();
    }

    public function listAllByVendorAction()
    {
        // action body
        $product_model = new Application_Model_Products();
        $vendor_id= $this->_request->getParam('vendor_id');
        // var_dump($vendor_id);exit();
        $this->view->all_productsByVendor = $product_model->selectAllByVendor($vendor_id);
    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_NewProductForm();
        $request = $this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
              $product_model = new Application_Model_Products();
              $vendor_id= $this->_request->getParam('vendor_id');
              $product_model-> addProduct($request->getParams(),$vendor_id);
              $this->redirect('/products');
            }
          }
      $this->view->newProduct_form = $form;
    }

    public function editAction()
    {
        // action body
        $form = new Application_Form_NewProductForm();
        $product_model = new Application_Model_Products();
        $id = $this->_request->getParam('product_id');
        $product_data = $product_model-> selectOne($id);
        $form->populate($product_data);
        $this->view->product_form = $form;

        $request = $this->getRequest();
        if($request-> isPost()){
          if($form-> isValid($request-> getPost())){
            $product_model->editProduct($id, $_POST) ;
            $this->redirect('/products/list-all-by-vendor/vendor_id/1');
          }
        }
    }

    public function vendorOfferAction()
    {
        // action body
        $form = new Application_Form_NewOfferForm();
        $request = $this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
              $product_model = new Application_Model_Offer();
              $product_id= $this->_request->getParam('product_id');
              $product_model-> addOffer($request->getParams(),$product_id);
              $this->redirect('/products/list-all-by-vendor/vendor_id/1');
            }
          }
      $this->view->newOffer_form = $form;
    }

    public function deleteAction()
    {
        // action body
        $product_model = new Application_Model_Products();
        $product_id = $this->_request->getParam("product_id");
        $product_model->deleteProduct($product_id);
        $this->redirect("/products/list-all-by-vendor/vendor_id/1");
    }

    public function calcRateAction()
    {
        // action body

    }

    public function searchAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $productName = $this->_request->getParam('name');
        $products = (new Application_Model_Products())->searchByName($productName);
        
        //var_dump(json_encode($products));
        json_encode($products);
       
    }

    public function displayAction()
    {
        // action body
    }


}



