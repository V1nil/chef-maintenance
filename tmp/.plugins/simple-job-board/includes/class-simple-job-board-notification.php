<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Notification class
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       1.0.0
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 */

/**
 * This is used to define different email templates.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since       1.0.0
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 * @author      PressTigers <support@presstigers.com>
 */
class Simple_Job_Board_Notification {

    /**
     * Admin Notification
     *
     * @since  1.0.0
     * @param  $post_id  Post ID
     * 
     * @return void 
     */
    public static function admin_notification($post_id) {
        // Applied job title
        $job_title = get_the_title($post_id);

        // Admin Email Address
        $to = get_option('admin_email');
        $subject = 'Applicant Resume Received[' . $job_title . ']';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $message = self::job_notification_templates($post_id, 'Admin');
        $attachment = apply_filters( 'sjb_admin_notification_attachment' , '', $post_id );
        wp_mail($to, $subject, $message, $headers , $attachment);
    }

    /**
     * HR Notification
     *
     * @since  1.0.0
     * @param  $post_id  Post ID
     * 
     * @return void 
     */
    public static function hr_notification($post_id) {
        // Applied job title
        $job_title = get_the_title($post_id);
        $to = get_option('settings_hr_email');
        $subject = 'Applicant Resume Received[' . $job_title . ']';
        $message = self::job_notification_templates($post_id, 'HR');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $attachment = apply_filters( 'sjb_hr_notification_attachment' , '' , $post_id );
        if ('' != $to)
            wp_mail($to, $subject, $message, $headers , $attachment);
    }

    /**
     * Applicant Notification
     *
     * @since  1.0.0
     * @param  $post_id  Post ID
     * 
     * @return void 
     */
    public static function applicant_notification($post_id) {
        // Applied job title
        $job_title = get_the_title($post_id);
        $applicant_post_keys = get_post_custom_keys($post_id);
        if (NULL != $applicant_post_keys):
                foreach ( $applicant_post_keys as $key ) {
                    if ('jobapp_' === substr($key, 0, 7)) {
                        $place = strpos( $key, 'email' );
                        if (!empty($place)) {
                           $applicant_email = get_post_meta($post_id, $key , TRUE);
                            break;
                        }
                    }
                }
        endif;
        $subject = 'Your Resume Received for Job [' . $job_title . ']';
        $message = self::job_notification_templates($post_id, 'applicant');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        if (isset($applicant_email) && is_email($applicant_email))
            wp_mail($applicant_email, $subject, $message, $headers);
    }

    /**
     * Email Template
     *
     * @since  1.0.0
     * @param  $post_id  Post ID
     * @param  $notification_receiver  Notification Receiver ( Admin or HR or || Applicant)
     *  
     * @return $message string  Email Template
     */
    public static function job_notification_templates($post_id, $notification_receiver) {
        // Applied job title
        $job_title = get_the_title($post_id);

        // Site URL 
        $site_url = get_option('siteurl');

        $parent_id = wp_get_post_parent_id($post_id);
        $job_post_keys = get_post_custom_keys($parent_id);
        $applicant_post_keys = get_post_custom_keys($post_id);
        $company_name = get_post_meta($parent_id, 'simple_job_board_company_name', TRUE);

        if (NULL != $applicant_post_keys):
            if (in_array('jobapp_name', $applicant_post_keys)):
                $applicant_name = get_post_meta($post_id, 'jobapp_name', TRUE);
            endif;
        endif;

        if ('applicant' != $notification_receiver) {
            $message = '<div style="width:700px; margin:0 auto;  border: 1px solid #95B3D7;font-family:Arial;">'
                    . '<div style="border: 1px solid #95B3D7; background-color:#95B3D7;">'
                    . ' <h2 style="text-align:center;">Job Application </h2>'
                    . ' </div>'
                    . '<div  style="margin:10px;">'
                    . '<p>' . date("Y/m/d") . '</p>'
                    . '<p>';
            if (NULL != $notification_receiver)
                $message .= 'Hi ' . $notification_receiver . ',';

            $message .= '</p>'
                    . '<p>I ';

            if (NULL != $applicant_name):
                $message.= $applicant_name . '';
            endif;
            $message .= ',would like to apply for the post of ' . $job_title . ' at your company ';
            if (isset($company_name) && NULL != $company_name):
                $message .= $company_name . '';
            endif;

            $message .= '.</p>'
                    . '<p>I have gone through the application criterion and requirements for the particular job and have posted my resume at given address  ' . $site_url . '<br/>'
                    . 'I have also filled the detail of the online application form on ' . date("Y/m/d") . '.'
                    . '</p>'
                    . '<p>I sincerely believe that my educational qualifications and extra-curricular activities will be appropriate for the job and the type of applicant it possible requires.'
                    . 'I promiss to devote my heart and soul to the job once selected to serve your company ';
            if (isset($company_name) && NULL != $company_name):
                $message .= $company_name . '';
            endif;
            $message .= '.</p>'
                    . 'I will be extremely grateful if you kindly glance through my application and consider me for the interview and the adjacent processes.'
                    . '</p>'
                    . '<p>I will be eagerly looking forward to your reply mail.</p>'
                    . '<p>Thank you</p>'
                    . '<p>Sincerely,</p>';

            if (NULL != $applicant_name):
                $message.= $applicant_name . '';
            endif;

            $message .= '</div>'
                    . ' </div>';
        }
        else {
            $message = '<div style="width:700px; margin:0 auto;  border: 1px solid #95B3D7;font-family:Arial;">'
                    . '<div style="border: 1px solid #95B3D7; background-color:#95B3D7;">'
                    . ' <h2 style="text-align:center;">Job Application Acknowledgement</h2>'
                    . ' </div>'
                    . '<div  style="margin:10px;">'
                    . '<p>' . date("Y/m/d") . '</p>'
                    . '<p>';
            $message .= 'Hi ';
            if (NULL != $applicant_name):
                $message .= '' . $applicant_name . ',';
            endif;
            $message .= '<p>Thank you for your interest ';

            if (isset($company_name) && NULL != $company_name):
                $message .= 'in' . $company_name . '.';
            else:
                $message .= '.';
            endif;
            $message .= 'We acknowledge receipt of your resume and application for a position ' . $job_title . ' and sincerely appreciate your interest in our company.'
                    . '</p>'
                    . '<p>We will screen all applicants and select candidates whose qualifications seem to meet our needs.'
                    . ' We will carefully consider your application during the initial screening and will contact you if you are selected to continue in the recruitment process. '
                    . 'We wish you every success.</p>'
                    . '<p>Regards,</p>'
                    . '<p>Admin,</p>'
                    . '<p>' . get_bloginfo('name') . '</p>';



            $message .= '</div>'
                    . ' </div>';
        }
        /**
         * Hook-> Notification Template.
         * 
         * @since 2.2.0
         * 
         * @param string $message{
         *     @type string Email Tempalte 
         * } 
         */
         return apply_filters( 'sjb_notifications_template' , $message );
    }

}

new Simple_Job_Board_Notification();