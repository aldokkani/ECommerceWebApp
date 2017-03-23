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

    function addNewReview($user_id,$product_id,$rateValue,$comment){
        @$result=$this->fetchall("user_id=$user_id and product_id=$product_id")->toArray();
        // var_dump($result);exit;
        if (count($result)) {
          if($rateValue ==0){
            $revData['user_id'] = $user_id;
            $revData['product_id'] = $product_id;
            $revData['comment'] = $comment;
            $this->update($revData, "user_id=$user_id and product_id=$product_id");
          }else {
            $revData['user_id'] = $user_id;
            $revData['product_id'] = $product_id;
            $revData['rate'] = $rateValue;
            $this->update($revData, "user_id=$user_id and product_id=$product_id");
          }

        }else {
          $row=$this->createRow();
          $row->user_id=$user_id;
          $row->product_id=$product_id;
          $row->rate=$rateValue;
          $row->comment=$comment;
          $row->save();
        }
    }

    function selectAllByProduct($product_id){
        return $this ->fetchall("product_id=$p_id")->toarray();

    }

    function selectRateByProduct($product_id){
      $result=$this->fetchall("product_id=$product_id")->toArray();
      $count=count($result);
      $sum=0;
      for ($i=0; $i<$count; $i++) {
        $sum+=$result[$i]['rate'];
      }
      $avgRate=$sum/$count;
      $avgRate=(int)$avgRate;
      $product_model = new Application_Model_Products();
      $product_model->editRate($product_id,$avgRate);
      return $avgRate;

    }

    function selectCommentByProduct($product_id){

      $db=Zend_Db_Table::getDefaultAdapter();
      $select = $db->select()
           ->from(array('r'=>'user_product_review'),
              array('comment'))
           ->join(array('u'=>'users'),'r.user_id = u.id', array('fullname'))
           ->where('r.product_id = ?', $product_id);
          //  echo $select;exit;
      $rs=$select->query()->fetchAll();
      return $rs;
    }

    function selectAllByUser($u_id){
        return $this ->fetchall("user_id=$u_id")->toarray();
    }
}
