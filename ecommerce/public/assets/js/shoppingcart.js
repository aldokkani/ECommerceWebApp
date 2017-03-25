function quantitychanged()
{
    $id = $.trim($(this).attr('id'));
    $qn = $.trim($(this).val());
    var price = $(this).parent().next('td').text();
    price = price.split('LE')[0];

    var extended_price = $(this).parent().next('td').next('td').text();
    extended_price = extended_price.split('LE')[0];

    extended_price = price * $qn;
    $(this).parent().next('td').next('td').html(extended_price+"LE");


    var total_cart_value_cell = $(this).closest('tr').next('tr').children().eq(5).text();

    //console.log("it is " + total_cart_value_cell+"___");




    $.post('/shoppingcart/updateshoppingcartquantity?shopping_cart_det_id='+$id+'&new_quantity='+$qn , {'message' : $id},
            function (respond) { 
                console.log(respond);
                console.log("updated success"); 
                var respond = respond.split('|');

                // echo $shopping_cart_details['total_amount']."|".$shopping_cart_details['discount']."|". $shopping_cart_details['due_amount'];
                $('#discount_total_call').text(respond[1]);
                $('#sub_total_call').text(respond[3]);
                $('#total_cart_cell').text(respond[0]);
                $('#total_cart_cell_bottom').text(respond[0]);
            }
    );
}


function paybillwithemail()
{
    var coupon_id = $('#coupon_id').val();
    var message = $('#coupon').val();
    console.log("message is " + message);
    if(coupon_id)
    {
      $.post('/shoppingcart/checkout/coupon_id/'+ coupon_id , {'message' : message},
        function (respond) {
          $(".show-msg").html("Donnneee"); 
          
        }
      );
    }
    else
    {
       $.post('/shoppingcart/checkout' , {'message' : message},
        function (respond) {

        }
      );
    }
           
}

function verifycoupon()
{

        var message = $('#coupon').val();
        console.log(message);

        if (message != '') {
          $.post('/coupon/validate/c_hash/'+ $('#coupon').val() + '', {'message' : message},
            function (respond) {  

              if((respond.split("|")[2]))
              {
                  var discountPercentage = (respond.split("|")[2]);
                  var currenttotalbeforecoupon = $('#total_amount_after_coupon').text();
                  var totalaftercoupon = currenttotalbeforecoupon - (currenttotalbeforecoupon * (discountPercentage/100));
                  $('#total_amount_after_coupon').html(totalaftercoupon);

                  $(".show-msg").removeClass( "alert alert-danger" );
                  $(".show-msg").addClass( "alert alert-success" );           

                  $(".show-msg").html((respond.split("|")[0]).trim() + " You Have a Discount of " + (respond.split("|")[2]).trim() + " %") ; 

              }
              else{
                  $(".show-msg").removeClass( "alert alert-success" );                 
                  $(".show-msg").addClass( "alert alert-danger" );    
                  
                  $(".show-msg").html((respond.split("|")[0]));
              }

              if((respond.split("|")[1])){
                 $('input#coupon_id').val((respond.split("|")[1]).trim());
              }
                       
            }
          );


        }
}