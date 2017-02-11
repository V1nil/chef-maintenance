(function ($) {
    'use strict';

    /**
     * All of the code for your admin-specific JavaScript source
     * should reside in this file.
     *
     * Note that this assume you're going to use jQuery, so it prepares
     * the $ function reference to be used within the scope of this
     * function.
     *
     * From here, you're able to define handlers for when the DOM is
     * ready:
     *
     * $(function() {
     *
     * });
     *
     * Or when the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and so on.
     *
     * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
     * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
     * be doing this, we should try to minimize doing that in our own work.
     */

    $(function () {

        /* Setting Page -> Tab Menu */
        $('.nav-tab-wrapper a').on("click", function (e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
            $('.settings_panel').hide();
            $('.nav-tab-active').removeClass('nav-tab-active');
            $($(this).attr('href')).show();
            $(this).addClass('nav-tab-active');
            return false;
        });

        /* Display Settings Tabs Previous State on Form Submit */
        if (window.location.hash.length > 0) {
            $('.settings_panel').hide();
            $('.nav-tab-active').removeClass('nav-tab-active');
            $(window.location.hash).show();
            $('a[href=' + window.location.hash + ']').addClass('nav-tab-active');
        }

        var feature_form = $("#job_feature_form");
        var jobapp_form = $("#job_app_form");

        /* Setting Page -> Job Feature Settings */
        $('#settings_addFeature').on("click", function () {
            var field_name_raw = $('#settings_jobfeature_name').val(); // Get Raw value.
            var job_feature_value = $('#settings_jobfeature_value').val(); //Job Feature value
            var fieldName;

            field_name_raw = field_name_raw.trim();    // Remove White Spaces from both ends.
            fieldName = field_name_raw.split(' ').join('_').toLowerCase(); //Replace white space with _.            
            
            if (fieldName != '') {
                var jobfeature_value_textbox;
                
                if ('' == job_feature_value) {
                    jobfeature_value_textbox = '<input type="hidden" value="empty" name="jobfeature_value[]"/>';
                } else {
                    jobfeature_value_textbox = '<input type="text" value="' + job_feature_value + '" name="jobfeature_value[]" >';
                }
                $('#settings_job_features').append('<li class="' + fieldName + '"><label for="' + fieldName + '">Field Name: ' + field_name_raw + '</label>\n\
                    <input type="hidden"  name="jobfeature[]" value="jobfeature_' + fieldName + '"  >' + jobfeature_value_textbox + ' &nbsp;\n\
                    <div class="button removeField" >Delete</div></li>');
                $('#settings_jobfeature_name').val(""); //Reset Field value.
                $('#settings_jobfeature_value').val(""); //Reset Field value.
            } else {
                
                /* Empty Job Feature Alert -> Making Translation Ready String Through Script Locaization */
                alert( settings_application_form.admin_jquery_alerts['empty_feature_name'] );
                $('#settings_jobfeature_name').focus(); //Keep focus on this input
            }
        });

        /* Remove Job App or Job Feature Fields */
        $('.jobpost_fields').on('click', 'li .removeField', function () {
            $(this).parent('li').remove();     // remove HTML
        });

        /* On Click Save button */
        $('#jobfeature_form').on('click', function () {
            feature_form.submit();
        });

        /* Setting Page -> Job Application MetaBox */
        $('#app_add_field').on("click", function () {
            var app_field_raw = $('#setting_jobapp_name').val(); // Get Raw value.
            var app_field_raw = app_field_raw.trim(); // Remove White Spaces from both ends.
            var app_field_name = app_field_raw.split(' ').join('_').toLowerCase(); //Replace white space with _.          
            var app_sanitized_field_name = app_field_raw.replace(/[&\/\\#,+()$~%.^!'"@:=*?|؟<>{}]/g, '').replace(/[_\s]/g, '_').toLowerCase(); //Replace white space with _.
            var app_field_type = $('#setting_jobapp_field_type').val();
            var selected_field_name = $("#setting_jobapp_field_type option:selected").text();
            var field_options = $('#settings_jobapp_field_options');
            var fieldOptions = field_options.val();
            var isRequired = $("#settings_jobapp_required_field").attr("checked") ? "checked" : "unchecked";

            if (app_field_name != '') {

                /* Show Options for [Checkbox],[Radio] and [Dropdown]  */
                var application_field_option;
                if ('text' === app_field_type || 'date' === app_field_type || 'text_area' === app_field_type || 'email' === app_field_type || 'phone' === app_field_type) {
                    application_field_option = '<input type="hidden" name="field_option[]" value="empty_options" >';
                } else {
                    application_field_option = '<input type="text" name="field_option[]" value="' + fieldOptions + '" >';
                }

                $('#settings_app_form_fields').append('<li class="jobapp_' + app_sanitized_field_name + '">\n\
                    <label for="' + app_field_name + '">' + app_field_raw + '</label>\n\
                    <input type="hidden" name="field_name[]" value="jobapp_' + app_field_name + '" >\n\
                    <input type="hidden" name="field_type[]" value="' + app_field_type + '" >\n\
                    <select class="setting_jobapp_field_type" name="jobapp_' + app_field_name + '[type]"  >\n\
                    <option value="' + app_field_type + '" >' + selected_field_name + '</option>\n\
                    </select>\n\
                    ' + application_field_option + ' \n\
                    <input type="checkbox" class="settings_jobapp_required_field"  ' + isRequired + '/>\n\
                    <input type="hidden"   name="field_optional[]"  value="' + isRequired + '"/>Required\
                    &nbsp; <div class="button removeField">Delete</div></li>');
                $('.' + app_sanitized_field_name + ' .' + app_field_type).attr('selected', 'selected');
                $('#setting_jobapp_name').val('');
                field_options.hide();
                $('#setting_jobapp_field_type').val('text');
                $('#settings_jobapp_required_field').prop('checked', true);
            } else {
                
                /* Empty Form Field Name Alert -> Making Translation Ready String Through Script Locaization */
                alert(settings_application_form.admin_jquery_alerts['empty_field_name']);
                $('#setting_jobapp_name').focus(); //Keep focus on this input
            }
        });

        /* Change the Required & Optional Field Parameter*/
        $('.settings-jobapp-required-field').on("change", function () {
            var input = $(this);
            input.attr("checked") ? input.next().val("checked") : input.next().val("unchecked");
        });

        /* Job Application Field Type Change */
        $('#setting_jobapp_field_type').on("change", function () {
            var option_value = $('#settings_jobapp_field_options');
            var fieldType = $(this).val();

            if (!('text' == fieldType || 'date' == fieldType || 'text_area' == fieldType || 'email' == fieldType || 'phone' == fieldType)) {
                option_value.show();
            } else {
                option_value.hide();
                option_value.val('');
            }
        });

        /* Job Application Form Submission */
        $('#jobapp_btn').on('click', function () {
            jobapp_form.submit();
        });

        /* Sortable Fields */
        if ($('#settings_job_features , #settings_app_form_fields , #job_features , #app_form_fields').length) {
            $("#settings_job_features , #settings_app_form_fields , #job_features , #app_form_fields").sortable();
            $("#settings_job_features , #settings_app_form_fields , #job_features , #app_form_fields").disableSelection();
        }     
                
        if ($('.simple-job-board-upload-button').length) {
            window.simple_job_board_uploadfield = '';

            $('.simple-job-board-upload-button').live('click', function () {
                window.simple_job_board_uploadfield = $('.upload_field', $(this).parents('.file_url'));
                tb_show('Upload', 'media-upload.php?type=image&TB_iframe=true', false);

                return false;
            });

            window.simple_job_board_send_to_editor_backup = window.send_to_editor;
            window.send_to_editor = function (html) {
                if (window.simple_job_board_uploadfield) {
                    if ($('img', html).length >= 1) {
                        var image_url = $('img', html).attr('src');
                    } else {
                        var image_url = $($(html)[0]).attr('href');
                    }
                    $(window.simple_job_board_uploadfield).val(image_url);
                    window.simple_job_board_uploadfield = '';

                    tb_remove();
                } else {
                    window.simple_job_board_send_to_editor_backup(html);
                }
            }
        }
    });
})(jQuery);