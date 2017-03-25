$('form#search_form').submit(function(e){
        e.preventDefault();
        console.log("test");
        var search = $('input#search_input').val();
    if($.trim(search) !== "") {
        $.post('/products/search', {name: search}, function(responseData){
            var data = JSON.parse(responseData);
            var htmlStr = "\
            <div>\
                <div>\
                    <h3>Search result</h3>\
                    <hr>\
                </div>\
                <ul class='thumbnails'>\
                                    <li class='span3'>\
                                        <div class='product-box'>\
                                            <p>\
                                                <a href='/products/details/product_id/"+data.id+"'>\
                                                    <img class='my-img-preview_size' src=" + data.photo + ">\
                                                </a>\
                                            </p>\
                                            <a href='/products/details/product_id/"+data.id+"' class='title'>"+data.name_en+"</a><br/>\
                                            <a href='/products/details/product_id/"+data.id+"' class='category'>"+"Category"+"</a>\
                                            <p class='price'>$"+data.price+"</p>\
                                        </div>\
                                    </li>\
                                </ul>\
                                </div>";

            $('div#searchResult').html(htmlStr);
//            location.href = "#search_result";
            console.log(data.photo);

        });
    }
    });

$('button#search_btn').on('click', function(){
    var search = $('input#search_input').val();
    if($.trim(search) !== "") {
        $.post('/products/search', {name: search}, function(responseData){
            var data = JSON.parse(responseData);
            var htmlStr = "\
            <div class='panel panel-warning'>\
                <div class='panel-heading'>\
                    <h3 class='panel-title'>Search result</h3>\
                </div>\
                <div class='panel-body'>\
                    <div class='col-sm-4 col-md-4'>\
                        <div class='thumbnail'>\
                            <img src=" + data.photo + " class='img-circle'>\
                            <div class='caption'>\
                                <h3>" + data.name_en + "</h3>\
                                <p><center><a href='#' class='btn btn-primary'\
                                 role='button'>View Category Products</a></center></p>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>"

            $('div#search_result').html(htmlStr);
//            location.href = "#search_result";
//            console.log(JSON.parse(data));

        });
    }
});

function getRate(id, p_id) {
    // var radios = document.getElementsByClassName('radio');
    var radios = $('.radio');
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            var myRate = radios[i].value;
            $.post('/products/calc-rate', {rate: myRate, product_id: p_id}, function (data) {
              // console.log(myRate,"      fffffff  __", p_id);
              console.log(data);
                $('#star'+data).attr("checked" , "checked")

            });

            break;
        }
    }
}

$('input[type="submit"]').mousedown(function () {
    $(this).css('background', '#2ecc71');
});
$('input[type="submit"]').mouseup(function () {
    $(this).css('background', '#1abc9c');
});

$('#loginform').click(function () {
    $('.login').fadeToggle('slow');
    $(this).toggleClass('green');
});



$(document).mouseup(function (e)
{
    var container = $(".login");

    if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
        $('#loginform').removeClass('green');
    }
});


$('.carousel').carousel({
    interval: 5000
});
