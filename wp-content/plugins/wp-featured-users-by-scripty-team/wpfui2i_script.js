jQuery(document).ready(function($) {
	var wpfui2i_vars_plugin_dir=wpfui2i_vars.wpfui2i_plugin_dir;
	var wpfui2i_js_script_ajax_nonce=wpfui2i_vars.wpfui2i_js_script_ajax_nonce;
	jQuery('img.wpfui2i_featured_user').live('click',function(e) {
		/*console.log("hi:"+wpfui2i_vars_plugin_dir);*/
		if( jQuery(this).attr('featured') == 'no' ) {
			jQuery(this).attr({src:wpfui2i_vars_plugin_dir+'/active_user.png',featured:'yes'});
		}
		else {
			jQuery(this).attr({src:wpfui2i_vars_plugin_dir+'/inactive_user.png',featured:'no'});
		}
		var featured = jQuery(this).attr('featured');
		var user_id = jQuery(this).attr('user-id');	
			
	    jQuery.post(
        wpfui2i_vars.wpfui2i_ajax_url,
        {
            action: 'wpfui2i_toggle_featured_user_status',
            featured: featured,
            user_id: user_id,
            wpfui2i_js_script_ajax_nonce:wpfui2i_js_script_ajax_nonce
        },
	    function( featuredEvent ) {
	    	console.log(featuredEvent);
	    }
	    );

	});

});