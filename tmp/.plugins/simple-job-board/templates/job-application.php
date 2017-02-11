<?php do_action('sjb_job_application_before'); ?>
<section class="sjb-job-application" id="apply">
    <?php do_action('sjb_job_application_start'); ?>
    <form class="jobpost_form" name="c-assignments-form" id="sjb-application-form" enctype="multipart/form-data">
        <h3><?php echo apply_filters('sjb_job_application_form_title', __('Apply Online', 'simple-job-board')); ?></h3>
        <div class="sjb-row">
            <div class="sjb-col-md-10 sjb_col-xs-12">
                <div class="sjb-row">
                    <?php
                    do_action('sjb_job_application_form_fields_start');

                    $keys = get_post_custom_keys(get_the_ID());
                    if (NULL != $keys):
                        foreach ($keys as $key):
                            if (substr($key, 0, 7) == 'jobapp_'):
                                $val = get_post_meta(get_the_ID(), $key, TRUE);
                                $val = unserialize($val);
                                $is_required = isset($val['optional']) ? "checked" === $val['optional'] ? 'required="required"' : "" : 'required="required"';
                                $is_required_class = isset($val['optional']) ? "checked" === $val['optional'] ? "sjb-required" : "sjb-not-required" : "sjb-required";
                                $is_required_label_asterisk = isset($val['optional']) ? "checked" === $val['optional'] ? '<span id="sjb-required">*</span>' : "" : '<span id="sjb-required">*</span>';
                                $id = preg_replace('/[^\p{L}\p{N}\_]/u', '_', $key);
                                $name = preg_replace('/[^\p{L}\p{N}\_]/u', '_', $key);

                                switch ($val['type']) {
                                    case 'text':
                                        echo '<div class="sjb-form-group">'
                                        . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                        . '<input type="text" name="' . $name . '" class="sjb-form-control ' . $is_required_class . '" id="' . $id . '" ' . $is_required . ' >'
                                        . '</div>';
                                        break;

                                    case 'text_area':
                                        echo '<div class="sjb-form-group">'
                                        . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                        . '<textarea name="' . $name . '" class="sjb-form-control ' . $is_required_class . '" id="' . $id . '" ' . $is_required . '></textarea>'
                                        . '</div>';
                                        break;

                                    case 'email':
                                        echo '<div class="sjb-form-group">'
                                        . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                        . '<input type="email" name="' . $name . '" class="sjb-form-control sjb-email-address ' . $is_required_class . '" id="' . $id . '" ' . $is_required . '><span class="sjb-invalid-email">' . __('A valid email address is required.', 'simple-job-board') . '</span>'
                                        . '</div>';
                                        break;

                                    case 'phone':
                                        echo '<div class="sjb-form-group">'
                                        . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                        . '<input type="tel" name="' . $name . '" class="sjb-form-control sjb-phone-number ' . $is_required_class . '" id="' . $id . '" ' . $is_required . '><span class="sjb-invalid-phone" id="' . $id . '-invalid-phone">' . __('A valid phone number is required.', 'simple-job-board') . ' </span>'
                                        . '</div>';
                                        break;

                                    case 'date':
                                        echo '<div class="sjb-form-group">'
                                        . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                        . '<input type="date" name="' . $name . '" class="sjb-form-control ' . $is_required_class . '" id="' . $id . '" ' . $is_required . '>'
                                        . '</div>';
                                        break;

                                    case 'radio':
                                        if ($val['options'] != '') {
                                            echo '<div class="sjb-form-group">'
                                            . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                            . '<div id="' . $key . '" >';
                                            $options = explode(',', $val['options']);
                                            $i = 0;
                                            foreach ($options as $option) {
                                                echo '<input type="radio" name="' . $name . '" class=" ' . $is_required_class . '" id="' . $id . '" value="' . $option . '"  ' . job_board_is_checked($i) . '><label class="sjb-label-control small">' . $option . ' </label> ';
                                                $i++;
                                            }
                                            echo '</div></div>';
                                        }
                                        break;

                                    case 'dropdown':
                                        if ($val['options'] != '') {
                                            echo '<div class="sjb-form-group">'
                                            . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                            . '<div id="' . $key . '" >'
                                            . '<select class="sjb-form-control" name="' . $name . '" id="' . $id . '" ' . $is_required . '>';
                                            $options = explode(',', $val['options']);
                                            foreach ($options as $option) {
                                                echo '<option class="' . $is_required_class . '" value="' . $option . '" >' . $option . ' </option>';
                                            }
                                            echo '</select></div></div>';
                                        }
                                        break;

                                    case 'checkbox' :
                                        if ($val['options'] != '') {
                                            echo '<div class="sjb-form-group ">'
                                            . '<label class="sjb-label-control" for="' . $key . '">' . ucwords(str_replace('_', ' ', substr($key, 7))) . $is_required_label_asterisk . '</label>'
                                            . '<div id="' . $key . '">';
                                            $options = explode(',', $val['options']);
                                            $i = 0;
                                            foreach ($options as $option) {
                                                echo '<input type="checkbox" name="' . $name . '" class="' . $is_required_class . '" id="' . $id . '" value="' . $option . '"  ' . job_board_is_checked($i) . '><label class="sjb-label-control small">' . $option . ' </label>';
                                                $i++;
                                            }
                                            echo '</div></div>';
                                        }
                                        break;
                                }
                            endif;
                        endforeach;
                    endif;

                    $sjb_attach_resume = '<div class="sjb-form-group">'
                            . '<label class="sjb-label-control" for="applicant_resume">' . apply_filters('sjb_attach_resume_title', __('Attach Resume', 'simple-job-board')) . '<span id="sjb-required">*</span></label>'
                            . '<input type="file" name="applicant_resume" id="applicant_resume">'
                            . ' <span id="file-error-message"></span>'
                            . '</div>';
                    echo apply_filters('sjb_attach_resume', $sjb_attach_resume);

                    do_action('sjb_job_application_form_fields_end');
                    ?>

                    <input type="hidden" name="job_id" value="<?php the_ID(); ?>" >
                    <input type="hidden" name="action" value="process_applicant_form" >
                    <input type="hidden" name="wp_nonce" value="<?php echo wp_create_nonce('the_best_jobpost_security_nonce') ?>" >
                    <div class="sjb-form-group" id="sjb-form-padding-button">
                        <button id="jobpost_submit_button"><?php _e('Submit', 'simple-job-board'); ?></button>
                    </div>
                </div>
            </div>    
        </div>
    </form>
    <?php do_action('sjb_job_application_end'); ?>
</section>
<div id="jobpost_form_status"></div>
<?php do_action('sjb_job_application_after'); ?>