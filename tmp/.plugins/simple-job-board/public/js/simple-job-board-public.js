(function ($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
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

    $(document).ready(function () {

        $(".jobpost_form").on("submit", function (event) {
            var applicant_resume = $("#applicant_resume");
            var jobpost_submit_button = $('#jobpost_submit_button');
            var jobpost_form_status = $('#jobpost_form_status');
            var datastring = new FormData(document.getElementById("sjb-application-form"));

            /** 
             * Application Form Submit -> Validate Email & Phone 
             * @since 2.2.0          
             */
            var is_valid_email = sjb_is_valid_input(event, "email", "sjb-email-address");
            var is_valid_phone = sjb_is_valid_input(event, "phone", "sjb-phone-number");

            /* Empty File Upload Validation */
            if (0 === document.getElementById("applicant_resume").files.length) {              
               document.getElementById('file-error-message').innerHTML = application_form.jquery_alerts['empty_attachment'];
                return false;
            }

            /**
             *  Uploded File Extensions Checks
             *  Get Uploded File Ext
             */
            var file_ext = applicant_resume.val().split('.').pop().toLowerCase();

            // All Allowed File Extensions
            var allowed_file_exts = application_form.allowed_extensions;

            // Settings File Extensions && Getting value From Script Localization
            var settings_file_exts = application_form.setting_extensions;
            var selected_file_exts = (('yes' === application_form.all_extensions_check) || null == settings_file_exts) ? allowed_file_exts : settings_file_exts;

            if ($.inArray(file_ext, selected_file_exts) > -1) {
                jobpost_submit_button.attr('disabled', false);
            }
            else {
                /* Translation Ready String Through Script Locaization */
                alert(application_form.jquery_alerts['invalid_extension']);
                applicant_resume.val('');
                return false;
            }

            /* Stop Form Submission on Invalid Phone & Email */
            if (!is_valid_email || !is_valid_phone) {
                return false;
            }
            $.ajax({
                url: application_form.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: datastring,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {

                    jobpost_form_status.html('Submitting.....');
                    jobpost_submit_button.attr('disabled', 'diabled');
                },
                success: function (response) {
                    if (response['success'] == true) {
                        $('.jobpost_form').slideUp();

                        /* Translation Ready String Through Script Locaization */
                        jobpost_form_status.html(application_form.jquery_alerts['application_submitted']);
                    }
                    if (response['success'] == false) {

                        /* Translation Ready String Through Script Locaization */
                        jobpost_form_status.html(response['error'] + application_form.jquery_alerts['application_not_submitted'] + '</div>');
                        jobpost_submit_button.removeAttr('disabled');
                        applicant_resume.val('');
                    }

                }
            });
            return false;
        });

        if ('logo-detail' === application_form.job_listing_view) {
            $(".company-logo").show();
            $(".job-description").show();
        }

        if ('without-logo' === application_form.job_listing_view) {
            $(".job-description").show();
            $(".company-logo").hide();
            $(".company-name").css({"margin-left": "15px"});
        }

        if ('without-logo-detail' === application_form.job_listing_view) {
            $(".company-logo").hide();
            $(".job-description").hide();
            $(".company-name").css({"margin-left": "15px"});
        }

        /** 
         * Application Form -> On Input Email Validation 
         * @since 2.2.0          
         */
        $('.sjb-email-address').on('input', function () {
            var input = $(this);
            var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            var is_email = re.test(input.val());
            var error_element = $("span", $(this).parent());
            if (is_email) {
                input.removeClass("invalid").addClass("valid");
                error_element.removeClass("error-show").addClass("sjb-invalid-email");
            }
            else {
                input.removeClass("valid").addClass("invalid");
            }
        });

        /**
         * Remove Message -> On File Attachment
         * @since 2.2.0
         */
        $("#applicant_resume").on('change', function () {
            document.getElementById('file-error-message').innerHTML = '';
        });

        /**
         * Initialise TelInput Plugin
         * @since 2.2.0
         */
        var telInput_id = $('.sjb-phone-number').map(function () {
            return this.id;
        }).get();

        for (var input_ID in telInput_id) {
            var telInput = $('#' + telInput_id[input_ID]);
            telInput.intlTelInput();
        }

        /**
         * Application Form -> Phone Number Validation
         * @since 2.2.0
         */
        $('.sjb-phone-number').on('input', function () {
            var telInput = $(this);
            var telInput_id = $(this).attr('id');
            var error_element = $("#" + telInput_id + "-invalid-phone");

            // Validate Phone Number
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    telInput.removeClass("invalid").addClass("valid");
                    error_element.removeClass("error-show").addClass("sjb-invalid-phone");
                } else {
                    telInput.removeClass("valid").addClass("invalid");
                }
            }
        });

        /** 
         * Stop Form Submission -> On Invalid Email / Phone 
         * @since 2.2.0          
         */
        function sjb_is_valid_input(event, input_type, input_class) {
            var jobpost_form_inputs = $("." + input_class).serializeArray();
            var error_free = true;

            for (var i in jobpost_form_inputs) {
                var element = $("#" + jobpost_form_inputs[i]['name']);
                var valid = element.hasClass("valid");
                var is_required_class = element.hasClass("sjb-not-required");
                if (!(is_required_class && "" === jobpost_form_inputs[i]['value'])) {
                    if ("email" === input_type) {
                        var error_element = $("span", element.parent());
                    } else if ("phone" === input_type) {
                        var error_element = $("#" + jobpost_form_inputs[i]['name'] + "-invalid-phone");
                    }

                    if (!valid) {
                        error_element.removeClass("sjb-invalid-" + input_type).addClass("error-show");
                        error_free = false;
                    }
                    else {
                        error_element.removeClass("error-show").addClass("sjb-invalid-" + input_type);
                    }

                    if (!error_free) {
                        event.preventDefault();
                    }
                }
            }
            return error_free;
        }

        /**
         * Empty Filter -> Remove Background Color
         * @since 2.2.0 
         */
        if (!($('.sjb-job-filters-form')).children().length) {
            $('.sjb-job-filters').removeAttr('id');
        }

    });
})(jQuery);
