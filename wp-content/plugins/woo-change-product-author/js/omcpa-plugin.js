;(function($) {

	$('.omcpa-plugin-notice').on('click', function() {
		$.ajax({
	        url: ajaxurl,
	        data: {
	            action: 'dismiss_omcpa_notice'
	        }
	    });
	});

})(jQuery);