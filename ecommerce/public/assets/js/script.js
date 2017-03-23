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
                    </iv>\
                </div>\
            </div>"
                
            $('div#searchResult').html(htmlStr);
         //console.log(data);
            
        });
    }
});
    


$('input[type="submit"]').mousedown(function(){
  $(this).css('background', '#2ecc71');
});
$('input[type="submit"]').mouseup(function(){
  $(this).css('background', '#1abc9c');
});

$('#loginform').click(function(){
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
