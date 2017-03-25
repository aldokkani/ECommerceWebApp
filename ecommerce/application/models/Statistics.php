<?php

class Application_Model_Statistics 
{

    public function getProductUsers($product_id) {
        
        $db=Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
             ->from(array('s'=>'Shopping_Cart'),array('users_num'=>'count(distinct(customer_id))'))
             ->join(array('d'=>'Shopping_Cart_Det'),'s.id=d.shopping_cart_id', array())
             ->where('d.product_id=?',$product_id);
        $rs=$select->query()->fetchAll();
        return $rs;
    }
    
    public function totalRevenue($product_id) {
        $db=Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
             ->from(array('s'=>'Shopping_Cart'),array('total_revenue'=>'IFNULL(sum(due_amount) ,"0.00")'))
             ->join(array('d'=>'Shopping_Cart_Det'),'s.id=d.shopping_cart_id', array())
             ->where('d.product_id=? and s.is_paid=1',$product_id);
        $rs=$select->query()->fetchAll();
        return $rs;
        
    }
    
    public function topProductOfCategory($category_id) {
        $db=Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
             ->from(array('s'=>'Shopping_Cart'),array('total_revenue'=>'sum(due_amount)'))
             ->join(array('d'=>'Shopping_Cart_Det'),'s.id=d.shopping_cart_id', array())
             ->join(array('p'=>'products'),'p.id=d.product_id', array('p.id','p.name_en'))
             ->where('p.category_id=? and s.is_paid=1',$category_id)
             ->group('d.product_id')
             ->order('total_revenue DESC')
             ->limit(1);
        $rs=$select->query()->fetchAll();
        return $rs;
        
        
    }
    
    public function categoryRevenue($category_id) {
        $db=Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
             ->from(array('s'=>'Shopping_Cart'),array('category_revenue'=>'IFNULL(sum(due_amount) ,"0.00")'))
             ->join(array('d'=>'Shopping_Cart_Det'),'s.id=d.shopping_cart_id', array())
             ->join(array('p'=>'products'),'p.id=d.product_id', array())
             ->where('p.category_id=? and s.is_paid=1',$category_id);
        $rs=$select->query()->fetchAll();
        return $rs;
    }

}

