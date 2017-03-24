<?php

class Application_Model_Shoppingcartdetails extends Zend_Db_Table_Abstract {

    protected $_name = 'Shopping_Cart_Det';

    function listShoppingCartDetails($customer_id) {
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                ->from(array('scd' => 'Shopping_Cart_Det'), array('zzzzzz'=>'scd.product_id'))
                ->joinInner(array('sc' => 'Shopping_Cart'), 'scd.shopping_cart_id = sc.id')
                ->joinInner(array('pro' => 'products'), 'scd.product_id = pro.id')
                ->where("sc.customer_id = 4");
        $result = $select->query()->fetchAll();
        return $result;
//        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
//            'host' => 'localhost',
//            'username' => 'root',
//            'password' => '123456',
//            'dbname' => 'dbzend'
//        ));
//
//        $stmt = $db->query("SELECT Shopping_Cart_Det.id as shopping_cart_det_id,  products.id as product_id,  quantity,  Shopping_Cart_Det.unit_price,  Shopping_Cart_Det.discount as item_discount,  Shopping_Cart_Det.date,  Shopping_Cart.total_amount as total_cart_amount,  Shopping_Cart.discount as total_cart_discount,  Shopping_Cart.due_amount as total_cart_due_amount,  is_paid, payment_date, coupon_id, products.name_en, products.name_ar, products.description_en, products.description_ar, products.photo, products.category_id     FROM Shopping_Cart_Det  join Shopping_Cart   on Shopping_Cart.id = Shopping_Cart_Det.shopping_cart_id  join products   on Shopping_Cart_Det.product_id = products.id   where customer_id = $customer_id");
//
//        $rows = $stmt->fetchAll()[0];
//        var_dump($rows);exit;
//        return $rows;
    }

    function addItemToCart($shopping_cart, $product) {

        $already_added_item = $this->fetchAll(
                        "product_id= $product->id and shopping_cart_id= $shopping_cart->id"
                )->toArray();
        if($already_added_item) {
//            var_dump($already_added_item[0]);
            $this->updateItemInCart(
                    $already_added_item[0]['id'], $already_added_item[0]['quantity']+1
                    );
        } else {
            $cart_item['quantity'] = 1;
            $cart_item['shopping_cart_id'] = $shopping_cart->id;
            $cart_item['product_id'] = $product->id;
            $cart_item['unit_price'] = $product->unit_price;
            $cart_item['date'] = gmdate("Y-m-d H:i:s", Zend_Date::now()->getTimestamp());
            $discount = (new Application_Model_Offer())
                            ->selectByProduct($product->id)['discount'];
            $cart_item['discount'] = $product->unit_price * $discount;
            $row = $this->createRow($cart_item);
            $row->save();
        }
//        $product_model = new Application_Model_Products();
//        $product_info = $product_model->selectOne($product_id);
//        $unit_price = $product_info['unit_price'];
//        //Get Discount from Offer 
//        $offer_model = new Application_Model_Offer();
//        $percent_of_discount = $offer_model->getProductOffer($product_id);
//        if ($percent_of_discount !== 0) {
//            $discount = $unit_price * $percent_of_discount / 100;
//        } else {
//            $discount = 0;
//        }
//        //check if item already exists add quantity on it
//        $shopping_cart_product_details_model = $this->checkProductInShoppingCartDetails($product_id);
//
//        if (sizeof($shopping_cart_product_details_model) != 0) {
//            $detail_id = $_SESSION['shopping_cart_id'];
//            $quantity = $shopping_cart_product_details_model['quantity'] + 1;
//            $this->updateItemInCart($shopping_cart_product_details_model['id'], $quantity);
//            $shopping_cart_model = new Application_Model_Shoppingcart();
//            $shopping_cart_model->updateCustomerShoppingCart($shopping_cart_id, $quantity, $unit_price);
//        } else {
//            $quantity = 1;
//            //second way....
//            $userData['customer_id'] = $customer_id;
//            $userData['shopping_cart_id'] = $shopping_cart_id;
//            $userData['product_id'] = $product_id;
//            $userData['quantity'] = $quantity;
//            $userData['unit_price'] = $unit_price;
//            $userData['discount'] = $discount;
//
//            $row = $this->createRow($userData);
//            $row->save();
//
//            $shopping_cart_model = new Application_Model_Shoppingcart();
//            $shopping_cart_model->updateCustomerShoppingCart($shopping_cart_id, $quantity, $unit_price, $discount);
//        }
    }

//    public function selectOne($detail_id) {
//        return $this->fetchAll('id = ' . $detail_id)->toArray()[0];
//    }
    public function selectAllByShoppingCart($shopping_cart_id) {
        return $this->fetchAll("shopping_cart_id= $shopping_cart_id")->toArray();
    }

//    public function checkProductInShoppingCartDetails($product_id) {
//        return $this->fetchAll('product_id = ' . $product_id)->toArray()[0];
//    }

    function removeItemFromCart($detail_id) {

        return $this->delete("id= $detail_id");
//        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
//            'host' => 'localhost',
//            'username' => 'root',
//            'password' => 'ROOT',
//            'dbname' => 'dbzend'
//        ));
//
//        $stmt = $db->query("Delete from Shopping_Cart_Det where id = " . $detail_id);
//        $stmt->execute();
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

        //        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
//            'host' => 'localhost',
//            'username' => 'root',
//            'password' => 'ROOT',
//            'dbname' => 'dbzend'
//        ));
//        $details_returned = $this->fetchAll('id=' . $detail_id)->toArray()[0];
//        $stmt = $db->query("update Shopping_Cart_Det set quantity = " . $quantity . " where id = " . $detail_id);
//        $shopping_cart_model = new Application_Model_Shoppingcart();
//        $discount = 0;
//        $unit_price = $details_returned['unit_price'];
//        $shopping_cart_id = $_SESSION['shopping_cart_id'];
//        $shopping_cart_model->updateCustomerShoppingCart($shopping_cart_id, $quantity, $unit_price);
    }

}
