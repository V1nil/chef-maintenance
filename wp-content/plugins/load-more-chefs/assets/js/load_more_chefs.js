/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


offset = 4;
jQuery(".dcs_loadmore").click(function(event) {
   	event.preventDefault();
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: ({ action: "loadMore_users", offset : offset}),
        success: function(response) {
          if(response !='0'){
            offset = offset  + 4;
           jQuery('.load_me_here').append(response);
         }else{
          //jQuery('.dcs_loadmore_related_innovators').hide();
          jQuery('.load_me_here').append('<p class="dcs_para_center">No More Users to display...</p>');
          jQuery('.dcs_loadmore').hide();
          return false;
         }
        },
    });
});