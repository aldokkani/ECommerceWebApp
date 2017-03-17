<?php

class Application_Model_UserProductReview extends Zend_Db_Table_Abstract
{
    protected $_name = 'user_product_review';

    function selectAll(){
      return $this ->fetchall()->toarray();
    }

    function selectOne($u_id,$p_id){
   return $this->find($u_id,$p_id)->toArray()[0];
  }

    function deleteReview($u_id,$p_id)
    {
    $this->delete("user_id=$u_id and product_id=$p_id");
    }

    function addNewReview($formData){
      $row=$this->createRow();
      $row->user_id=$formData['user_id'];
      $row->product_id=$formData['product_id'];
      $row->rate=$formData['rate'];
      $row->comment=$formData['comment'];
      $row->save();
    }

    function selectAllByProduct($p_id){
      return $this ->fetchall("product_id=$p_id")->toarray();
    }

    function selectAllByUser($u_id){
      return $this ->fetchall("user_id=$u_id")->toarray();
    }





}
