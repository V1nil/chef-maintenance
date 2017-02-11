jQuery(document).ready(function ($) {
    jQuery('#wpupg_add_custom_image').on('click', function(e) {
        e.preventDefault();

        var button = jQuery(this);
        var input_url = button.parents('#wpupg_form_post').find('#wpupg_custom_image');
        var input_id = button.parents('#wpupg_form_post').find('#wpupg_custom_image_id');

        if(typeof wp.media == 'function') {
            var custom_uploader = wp.media({
                title: 'Insert Media',
                button: {
                    text: 'Set Custom Image'
                },
                multiple: false
            })
                .on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    input_url.val(attachment.url);
                    input_id.val(attachment.id);
                })
                .open();
        }
    });

    jQuery('#wpupg_custom_image').on('keyup change', function() {
        jQuery(this).siblings('#wpupg_custom_image_id').val('');
    });

    jQuery('.term-custom-image').on('click', '#wpupg_custom_image_button.button-add', function (e) {
        console.log(wp.media);
        if(typeof wp.media == 'function') {
            var custom_uploader = wp.media({
                title: wpupg_admin_post.text_add_grid_image,
                button: {
                    text: wpupg_admin_post.text_add_grid_image
                },
                multiple: false
            })
                .on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    jQuery('#wpupg_custom_image_img').attr('src', attachment.url);
                    jQuery('#wpupg_custom_image').val(attachment.id);
                    jQuery('#wpupg_custom_image_button')
                        .removeClass('button-add')
                        .addClass('button-remove')
                        .val(wpupg_admin_post.text_remove_grid_image);
                })
                .open();
        }
    });

    jQuery('.term-custom-image').on('click', '#wpupg_custom_image_button.button-remove', function (e) {
        jQuery('#wpupg_custom_image_img').attr('src', '');
        jQuery('#wpupg_custom_image').val('');
        jQuery('#wpupg_custom_image_button')
            .removeClass('button-remove')
            .addClass('button-add')
            .val(wpupg_admin_post.text_add_grid_image);
    });
});