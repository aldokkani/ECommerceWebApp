<?php

class Application_Model_Shoppingcartdetails extends Zend_Db_Table_Abstract {

    protected $_name = 'Shopping_Cart_Det';

    function listShoppingCartDetails($customer_id, $shopping_cart_det_id) {
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                ->from(array('scd' => 'Shopping_Cart_Det'), array('shopping_cart_det_id'=>'scd.id', 'unit_price' => 'scd.unit_price','item_discount'=>'scd.discount','date'=>'scd.date','quantity'=>'scd.quantity'))
                ->joinInner(array('sc' => 'Shopping_Cart'), 'scd.shopping_cart_id = sc.id')
                ->joinInner(array('pro' => 'products'), 'scd.product_id = pro.id')
                ->where("sc.customer_id = $customer_id and sc.id = $shopping_cart_det_id");
        $result = $select->query()->fetchAll();
//        var_dump($result);exit;
        return $result;
    }

    function addItemToCart($shopping_cart, $product) {
        $already_added_item = $this->fetchAll("product_id=".$product['id']." and shopping_cart_id=".$shopping_cart['id'])->toArray();
        if($already_added_item) {
            $this->updateItemInCart(
                    $already_added_item[0]['id'], $already_added_item[0]['quantity']+1
                    );
        } else {
            $cart_item['quantity'] = 1;
            $cart_item['shopping_cart_id'] = $shopping_cart['id'];
            $cart_item['product_id'] = $product['id'];
            $cart_item['unit_price'] = $product['unit_price'];
            $cart_item['date'] = gmdate("Y-m-d H:i:s", Zend_Date::now()->getTimestamp());
            $discount = (new Application_Model_Offer())
                            ->selectByProduct($product['id'])['discount'];
            $cart_item['discount'] = $product->unit_price * $discount;
            $row = $this->createRow($cart_item);
            $row->save();
           
            (new Application_Model_Shoppingcart())
                ->updateShoppingCart($shopping_cart['id']);
        }
    }

    public function selectAllByShoppingCart($shopping_cart_id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                ->from(array('scd' => 'Shopping_Cart_Det'), array('shopping_cart_det_id'=>'scd.id', 'unit_price' => 'scd.unit_price','item_discount'=>'scd.discount','date'=>'scd.date','quantity'=>'scd.quantity'))
                ->joinInner(array('sc' => 'Shopping_Cart'), 'scd.shopping_cart_id = sc.id')
                ->joinInner(array('pro' => 'products'), 'scd.product_id = pro.id')
                ->where("sc.id = $shopping_cart_id ");
        $result = $select->query()->fetchAll();
        return $result;
    }

    function removeItemFromCart($detail_id) {
        return $this->delete("id= $detail_id");
    }

    function updateItemInCart($det_id, $quantity) {

        $shopping_cart_detail = $this->find($det_id)->toArray()[0];
        $discount = (new Application_Model_Offer())
                        ->selectByProduct($shopping_cart_detail['product_id'])['discount'];
        $unit_price = $this->fetchAll("id= $det_id")->toArray()[0]['unit_price'];
        $shopping_cart_det['quantity'] = $quantity;
        $shopping_cart_det['discount'] = $quantity * $unit_price * ($discount / 100);
        $shopping_cart_det['date'] = gmdate("Y-m-d H:i:s", Zend_Date::now()->getTimestamp());
        $this->update($shopping_cart_det, "id=$det_id");
        (new Application_Model_Shoppingcart())
                ->updateShoppingCart($shopping_cart_detail['shopping_cart_id']);
    }

}
