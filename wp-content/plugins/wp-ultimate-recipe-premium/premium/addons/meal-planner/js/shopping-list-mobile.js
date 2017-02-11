jQuery(document).ready(function() {
    if(window.opener) {
        jQuery('#wpurp-meal-plan-shopping-list-mobile-tip').show();
    }

    jQuery('.wpurp-shopping-list-ingredient-checkbox').on('change', function(e) {
        var checkbox = jQuery(this);
        if(checkbox.is(':checked')) {
            checkbox.closest('tr').addClass('ingredient-checked');
        } else {
            checkbox.closest('tr').removeClass('ingredient-checked');
        }
    });

    jQuery('#submit').on('click', function() {
        var email = jQuery('#email').val();

        if(email.length > 0) {
            jQuery(this).attr('disabled', 'disabled');

            var data = {
                action: 'shopping_list_mobile_mail',
                security: ajax_nonce,
                email: email,
                link: window.location.href
            };

            jQuery.post(ajax_url, data, function(html) {
                console.log(html);
                jQuery('#wpurp-meal-plan-shopping-list-mobile-tip').slideUp(200);
            });
        }
    });
});