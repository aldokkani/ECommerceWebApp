<?php

class Application_Model_Wishlist extends Zend_Db_Table_Abstract {

    protected $_name = 'wishlist';

    public function selectAll($customer_id) {
        
        $db=Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
             ->from(array('p'=>'products'),array('name_en','name_ar'))
             ->join(array('w'=>'wishlist'),'p.id = w.product_id', array('product_id'))
             ->where('w.customer_id= ?',$customer_id);
//        $select=$db->select()->from('wishlist')->where('product_id= ?', 4);
//        $rs=$select->query()->fetchAll();
//        print_r($rs); die();
        $rs=$select->query()->fetchAll();
        return $rs;
        //print_r($rs);
        //die();
     
    }

    public function addToWishlist($customer_id, $product_id) {
        $row = $this->createRow();
        $row->customer_id = $customer_id;
        $row->product_id = $product_id;
        return $row->save();
        
    }

    public function deleteFromWishlist($customer_id,$product_id) {
        
        //var_dump($this->delete("product_id=$product_id and customer_id=$customer_id"));
        //die();
        return $this->delete("product_id=$product_id and customer_id=$customer_id");
        
    }
    
    public function checkOnProduct($product_id,$user_id)
    {
        $db=Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
             ->from(array('w'=>'wishlist'),'product_id')
             
             ->where('w.product_id=?', $product_id)
             ->where('w.customer_id=?', $user_id);
        //echo $select; die();
        $rs=$select->query()->fetchAll();
        return $rs;
    }

}
