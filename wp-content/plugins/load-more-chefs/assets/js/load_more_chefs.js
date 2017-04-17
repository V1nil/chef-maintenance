
offset = 4;
$=jQuery;

$(document).on('click', ".loadmore-chefs", function (event) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: ({ action: "loadMore_chefs", offset : offset}),
        success: function(response) {
          if(response !==''){
            offset = offset  + 4;
            $(".load-more-chefs-reveal").before(response);
            $(".grid-chefs").last().slideDown("slow");
            

//            jQuery('.load_me_here').append(response);
         }else{
             $(".loadmore-chefs").addClass("load-more-chefs-done");

         }
        },
    });
});