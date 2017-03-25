<?php

class Application_Model_Shoppingcart extends Zend_Db_Table_Abstract {

    protected $_name = 'Shopping_Cart';

    function listShoppingCarts() {
        return $this->fetchAll()->toArray();
    }

    function AddUserEmptyCart($u_id) {
        $userData['customer_id'] = $u_id;
        $row = $this->createRow($userData);
        $row->save();
    }

    function updateShoppingCart($shopping_cart_id) {
        /* Selects all the shopping cart's details in Shopping_Cart_Det */
        $shopping_cart_details = (new Application_Model_Shoppingcartdetails())
                ->selectAllByShoppingCart($shopping_cart_id);        
        $shopping_cart = ['due_amount' => 0, 'discount' => 0, 'total_amount' => 0];
        foreach ($shopping_cart_details as $shopping_detail) {
            $shopping_cart['due_amount'] += ($shopping_detail['quantity'] * $shopping_detail['unit_price']);
            $shopping_cart['discount'] += $shopping_detail['discount'];
        }        
        $shopping_cart['total_amount'] = $shopping_cart['due_amount'] - $shopping_cart['discount'];
        return $this->update($shopping_cart, "id= $shopping_cart_id");
    }

    function getUserShoppingCart($customerid) {
        return $this->fetchAll('customer_id = ' . $customerid)->toArray()[0];
    }

    function getUserShoppingCartWhereShoppingCartId($shopping_cart_id) {
        return $this->fetchAll('id = ' . $shopping_cart_id)->toArray()[0];
    }

    function checkOutCart($userData , $shopping_cart , $coupon = null) {
        
        $shopping_cart_data['is_paid'] = true;
        $shopping_cart_data['payment_date'] = gmdate(
                "Y-m-d H:i:s", Zend_Date::now()->getTimestamp()
                );
        $shopping_cart_data['discount'] = $shopping_cart['discount'];
        $shopping_cart_data['total_amount'] = 
                $shopping_cart['due_amount'] - $shopping_cart['discount'] ;
        if($coupon){
            $shopping_cart_data['coupon_id'] = $coupon['id'];           
            $shopping_cart_data['total_amount'] -=
                    $shopping_cart['total_amount'] * ($coupon['discount']/100) ;
            $shopping_cart_data['discount'] += 
                    $shopping_cart['total_amount'] - $shopping_cart_data['total_amount'];
            (new Application_Model_Coupon())->updateCoupon($coupon['id'], $userData->id);
        }
        $this->update($shopping_cart_data, "id = ".$shopping_cart['id']);
        
        $stringBill = "your total amount is " . $shopping_cart_data['total_amount'] . "\n";
        $stringBill .= "(-) total disount taken is  " . $shopping_cart_data['discount'] . "\n";
        $stringBill .= "your due amount is " . $shopping_cart['due_amount'] . "\n";
        $stringBill .= ($coupon) ? "Coupon used " . $coupon['id'] : "" ;
        $mailBody = "Hello Mr/Mrs " . $userData->fullname . ",\n\n "
                . $stringBill
                . "\n\nHave a nice day. :)";

        $mailInfo = [
            'cust_name' => $userData->fullname,
            'cust_mail' => $userData->email,
            'mail_body' => $mailBody,
            'mail_subject' => "ECommerce Bill Information"
        ];

        (new Application_Model_Email())->sendMail($mailInfo);
        //create new shopping cart
        $this->AddUserEmptyCart($userData->id);
    }

}
