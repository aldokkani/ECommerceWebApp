<?php

class Application_Model_Category extends Zend_Db_Table_Abstract {

    protected $_name = 'category';

    function selectAll() {
        return $this->fetchall()->toarray();   //select * from category;
    }

    function selectOne($id) {
        return $this->find($id)->toArray()[0];     //select * from category where id=$id;
    }

    function deleteCategory($id) {
        $this->delete("id=$id");                 //delete from category where id=$id
    }

    function addNewCategory($formData) {
        $row = $this->createRow();
        $row->name = $formData['name'];   //$row->fname ==esm el column ...$formData['fname'] ==esm el element
        $row->photo = $formData['photo'];
        $row->parent_cat_id = $formData['parent_cat_id'];
        $row->save();
    }

    function editCategory($id, $formData) {
        $catData['name'] = $formData['name'];
        $catData['parent_cat_id'] = $formData['parent_cat_id'];
        $catData['photo'] = $formData['photo'];

        $this->update($catData, "id=$id");
    }

}
