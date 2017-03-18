$('input#search_btn').on('click', function(){
    var search = $('input#search').val();
    if($.trim(search) != "") {
        $.post('file.php', {name: search}, function(data){
            $('div#data').text(data);
        });
    }
});