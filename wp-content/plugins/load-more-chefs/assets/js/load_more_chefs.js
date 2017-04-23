
offset = 4;
$=jQuery;

$(document).on('click', ".loadmore-chefs", function (event) {
    event.preventDefault();
    $(document.body).css({'cursor' : 'wait'});  //UX de carga
    var filter = $('[name="filter-loadmorechefs"]').val();  //Filtros del shortcode
    
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: ({ action: "loadMore_chefs", offset : offset, filter : filter}),
        success: function(response) {
        $(document.body).css({'cursor' : 'default'});
          if(response !==''){
            offset = offset  + 4;
            $(".load-more-chefs-reveal").before(response);
            $(".grid-chefs").last().slideDown("slow");
         }else{
             $(".loadmore-chefs").addClass("load-more-chefs-done");

         }
        },
    });
});