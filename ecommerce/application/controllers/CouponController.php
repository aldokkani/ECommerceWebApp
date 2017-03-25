<?php

class CouponController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //action body
        // $request = $this->getRequest();
        // $couponpar = $request->getParams()['c_hash'];

       

        // $coupon_model = new Application_Model_Coupon();        
        // $coupon = $coupon_model->verifyCoupon($couponpar);


        // if(isset($coupon[0]["c_hash"]))
        // {
        // 	//echo $coupon[0]["c_hash"];
        // 	if($coupon && $coupon[0]["c_hash"] === $couponpar )
	       //  {
	       //  	//var_dump("hello word");
	       //  	// die();

	       //  	//$this->redirect('/Coupon/verifyCoupon/coupon_used/true');

	       //  }
        // }
        // else
        // {
        // 	//echo "no coupon found";
        // }



        // if($coupon && $coupon[0]["c_hash"] === $couponpar )
        // {
        // 	var_dump("hello word");
        // 	die();
        // }

        // var_dump("_" .$coupon);
        // die();
        //$this->redirect('/shoppingcart/mycart');
    }

    public function verifyCouponAction()
    {
    	//c_hash

    	var_dump("in verify");
        die();

    	$request = $this->getRequest();
        $couponpar = $request->getParams()['c_hash'];

        //var_dump($couponpar);
        //die();
       

        $coupon_model = new Application_Model_Coupon();        
        $coupon = $coupon_model->verifyCoupon($couponpar);


        if(isset($coupon[0]["c_hash"]))
        {
        	//echo $coupon[0]["c_hash"];
        	if($coupon && $coupon[0]["c_hash"] === $couponpar )
	        {
	        	var_dump("hello word is valid");
	        	//die();

	        	//$this->redirect('/Coupon/verifyCoupon/coupon_used/true');

	        }
        }
        else
        {
        	var_dump("not valid");
	        //die();
        	//echo "no coupon found";
        }







    	// var_dump("verify cooooo");
    	// die();
     //    // action body
     //    $coupon = $request->getParams()['c_hash'];
     //    var_dump( "elloooo in coupon");
     //    die();
     //    $this->redirect('/shoppingcart/mycart');

    	// if($request->getParams()['coupon_used'] && $request->getParams()['coupon_used'] == "true")
     //    {
     //        var_dump("returned back from oupon and is valid");
     //        //die();
     //       // $this->redirect('/shoppingcart/mycart');
     //        // return;
     //    }



    }

    public function validateAction()
    {
        // action body

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

    	$request = $this->getRequest();
        $couponpar = $request->getParams()['c_hash'];

        
        $coupon_model = new Application_Model_Coupon();        
        $coupon = $coupon_model->verifyCoupon($couponpar);


        if(isset($coupon[0]["c_hash"]))
        {
        	if($coupon && $coupon[0]["c_hash"] === $couponpar )
	        {
	        	echo "Success: Coupon entered is valid | ". $coupon[0]["id"]."|".$coupon[0]["discount"];
                //echo "(".$coupon[0]["discount"].")";
	        	// die();
	        	
	        }
            else{
                echo "Fail: Coupon is Not Valid";
            }
        }
        else
        {
        	echo "Fail: Coupon is Not Valid";
        	//die();
        }


    }


}





