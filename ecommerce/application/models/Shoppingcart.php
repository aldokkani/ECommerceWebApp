<?php

class Application_Model_Shoppingcart extends Zend_Db_Table_Abstract {

    protected $_name = 'Shopping_Cart';
//	protected $_dependentTables = array('Application_Model_ShoppingCartDetails');

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
//        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
//            'host' => 'localhost',
//            'username' => 'root',
//            'password' => 'ROOT',
//            'dbname' => 'dbzend'
//        ));
//
//        //get all details of shopping cart and compute total amount here 
//        //or use mysql trigger
//        $shopping_cart_details_model = new Application_Model_Shoppingcartdetails();
//        $all_det = $shopping_cart_details_model->listShoppingCartDetails($_SESSION['customer_id']);
//        var_dump($all_det);
//        $total_due_amount = 0;
//        $total_discount_amount = 0;
//        for ($detail = 0; $detail < sizeof($all_det); $detail++) {
//            $total_due_amount += ($all_det[$detail]['unit_price'] * $all_det[$detail]['quantity']);
//
//            $total_discount_amount += ($all_det[$detail]['discount'] );
//        }
//
//        if ($disount == null) {
//            $stmt = $db->query("update Shopping_Cart set total_amount = " . $total_due_amount . " , discount = discount + " . $total_discount_amount . " ,due_amount = " . ($total_due_amount - $total_discount_amount) . "  where id = $shopping_cart_id");
//        } else {
//            $new_dis = $disount + $total_due_amount - $total_discount_amount;
//            $stmt = $db->query("update Shopping_Cart set total_amount = " . $total_due_amount . " , discount = discount + " . $new_dis . " , due_amount = " . ($total_due_amount - $total_discount_amount) . "  where id = $shopping_cart_id");
//        }
//        var_dump($stmt);
    }

//    function getUserShoppingCartBillDetails($customer_id) {
//        
//        $db = Zend_Db_Table::getDefaultAdapter();
//        $select = $db->select()
//                ->from(array('sc' => 'Shopping_Cart'))
//                ->joinInner(array('users' => 'users'), 'sc.customer_id = users.id')
//                ->where("sc.customer_id = $customer_id")
//                ->order('sc.id DESC')
//                ->limit(1);
//        $result = $select->query()->fetchAll();
////        var_dump($result);exit;
//        return $result;
////        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
////            'host' => 'localhost',
////            'username' => 'root',
////            'password' => 'ROOT',
////            'dbname' => 'dbzend'
////        ));
////        $stmt = $db->query("SELECT * FROM dbzend.Shopping_Cart inner join users on Shopping_Cart.customer_id =  users.id where customer_id=" . $_SESSION['customer_id'] . " ORDER BY dbzend.Shopping_Cart.id DESC LIMIT 1");
////        $rows = $stmt->fetchAll();
////        return $rows;
//    }

    function getUserShoppingCart($customerid) {
        return $this->fetchAll('customer_id = ' . $customerid)->toArray()[0];
    }

    function checkOutCart($userData, $shopping_cart, $coupon = null) {
        
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
        
//        $customerBill = $this->getUserShoppingCartBillDetails($userData->id);
        
//        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
//            'host' => 'localhost',
//            'username' => 'root',
//            'password' => 'ROOT',
//            'dbname' => 'dbzend'
//        ));
//
////        $customer_id = $_SESSION['customer_id'];
//        $customerBill = $this->getUserShoppingCartBillDetails($userData->id);
//
//        if ($coupon_id != null) {
//            //Get Discount from COUPON to update due amount
//            $coupon_model = new Application_Model_Coupon();
//            $percent_of_coupon = $coupon_model->selectOne($coupon_id);
//            $percent_of_coupon = $percent_of_coupon["discount"];
//            if ($percent_of_coupon !== 0) {
//                $net = $customerBill[0]['total_amount'] - $customerBill[0]['discount'];
//                $discount_on_net = $net * ($percent_of_coupon / 100);
//                $due_amount_after_coupon = $net - $discount_on_net;
//                $discount = $discount_on_net;
//                $date = Zend_Date::now();
//                $timeStamp = gmdate("Y-m-d H:i:s", $date->getTimestamp());
//                $stmt = $db->query("update Shopping_Cart set due_amount = " . $due_amount_after_coupon . ", coupon_id = " . $coupon_id . " ,is_paid = true , payment_date = '" . $timeStamp . "' where id = $shopping_cart_id");
//            }
//        } else {
//            $discount = 0;
//            $date = Zend_Date::now();
//            $timeStamp = gmdate("Y-m-d H:i:s", $date->getTimestamp());
//            $stmt = $db->query("update Shopping_Cart set is_paid = true , payment_date = '" . $timeStamp . "' where id = $shopping_cart_id");
//        }
//        $stringBill = "your total amount is " . $customerBill[0]['total_amount'] . "\n";
//        $stringBill .= "(-) total disount taken is  " . $customerBill[0]['discount'] . "\n";
//        $stringBill .= "your due amount is " . $customerBill[0]['due_amount'] . "\n";
//
//        if ($coupon_id != null) {
//            $stringBill .= "Coupon used " . $coupon_id . "</br>";
//        }
//        $user = (new Application_Model_User())->selectOne($_SESSION['customer_id']);
//        $mailBody = "Hello Mr/Mrs " . $user['fullname'] . ",\n\n "
//                . $stringBill
//                . "\n\nHave a nice day. :)";
//
//        $mailInfo = [
//            'cust_name' => $user['fullname'],
//            'cust_mail' => $user['email'],
//            'mail_body' => $mailBody,
//            'mail-subject' => "ECommerce Bill Information"
//        ];
//
//        (new Application_Model_Email())->sendMail($mailInfo);
//
//        //create new shopping cart
//        $this->AddUserEmptyCart();
    }

}
