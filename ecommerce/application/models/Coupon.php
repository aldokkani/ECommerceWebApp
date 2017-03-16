<?php

class Application_Model_Coupon extends Zend_Db_Table_Abstract
{
    protected $_name = 'coupon';
    
    public function selectAll() {
        return $this->fetchAll()->toArray();
    }
    
    public function selectOne($c_id) {
        return $this->find($c_id)->toArray()[0];
    }
    
    public function addCoupon($discount_amount) {
        $coupon = array (
            'c_hash' => md5(bin2hex(random_bytes(60))),
            'discount' => (int)$discount_amount
        );
        $row = $this->createRow($coupon);
        return $row->save();
    }
    
    public function updateCoupon($c_id, $user_id) {
        $coupon = array (
            'user_id' => (int)$user_id
        );
        return $this->update($coupon, "id= $c_id");
    }
    
    public function deleteCoupon($c_id) {
        return $this->delete("id= $c_id");
    }
}

