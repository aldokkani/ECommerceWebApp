<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
      // action body
      $cat_model = new Application_Model_Category();
      $this->view->all_categories = $cat_model->selectAll();

    }

    public function detailsAction()
    {
        // action body
        $cat_model = new Application_Model_Category();
        $id= $this->_request->getParam('cid');
        $categoryData=$cat_model->selectOne($id);
        $this->view->cat_data=$categoryData;
    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_CatForm();
        $request = $this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
              $cat_model = new Application_Model_Category();
              $cat_model-> addNewCategory($request->getParams());
              $this->redirect('/category/list');
            }
          }
      $this->view->cat_form = $form;
    }

    public function deleteAction()
    {
        // action body
      $cat_model = new Application_Model_Category();
      $cat_id = $this->_request->getParam("cid");
      $cat_model->deleteCategory($cat_id);
      $this->redirect("/category/list");
    }

    public function updateAction()
    {
        // action body
        $form = new Application_Form_CatForm();
        $cat_model = new Application_Model_Category();
        $id = $this->_request->getParam('cid');
        $cat_data = $cat_model-> selectOne($id);
        $form->populate($cat_data);
        $this->view->cat_form = $form;

        $request = $this->getRequest();
        if($request-> isPost()){
          if($form-> isValid($request-> getPost())){
            $cat_model->editCategory($id, $_POST) ;
            $this->redirect('/category/list ');
          }
        }
    }
    


}
