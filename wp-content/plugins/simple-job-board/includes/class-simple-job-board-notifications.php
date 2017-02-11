<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Job_Board_Notifications Class
 *
 * This is used to define different email templates.
 * 
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       1.0.0
 * @since       2.2.2   Added "sjb_notification_template" filter.
 * @since       2.2.3   Added "sjb_applicant_details_notification" filter.
 * @since       2.3.0   Revised the Admin, HR and Applicant notification templates.
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes 
 * @author      PressTigers <support@presstigers.com>
 */

class Simple_Job_Board_Notification {

    /**
     * Admin Notification
     *
     * @since  1.0.0
     * 
     * @param  $post_id  Post ID
     * @return void 
     */
    public static function admin_notification($post_id) {
        
        // Applied job title
        $job_title = get_the_title($post_id);

        // Admin Email Address
        $to = apply_filters( 'sjb_admin_notification_to', get_option('admin_email') );
        $subject = apply_filters( 'sjb_admin_notification_sjb', 'Applicant Resume Received[' . $job_title . ']', $job_title );
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $message = self::job_notification_templates($post_id, 'Admin');
        $attachment = apply_filters('sjb_admin_notification_attachment', '', $post_id);
        wp_mail($to, $subject, $message, $headers, $attachment);
    }

    /**
     * HR Notification
     *
     * @since  1.0.0
     * 
     * @param  $post_id  Post ID
     * @return void 
     */
    public static function hr_notification($post_id) {
        
        // Applied job title
        $job_title = get_the_title($post_id);
        $to = apply_filters( 'sjb_hr_notification_to', get_option('settings_hr_email') );
        $subject = apply_filters( 'sjb_hr_notification_sbj' , 'Applicant Resume Received[' . $job_title . ']', $job_title );
        $message = self::job_notification_templates($post_id, 'HR');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $attachment = apply_filters( 'sjb_hr_notification_attachment', '', $post_id );
        if ('' != $to)
            wp_mail( $to, $subject, $message, $headers, $attachment );
    }

    /**
     * Applicant Notification
     *
     * @since  1.0.0
     * 
     * @param  $post_id  Post ID
     * @return void 
     */
    public static function applicant_notification( $post_id ) {
        
        // Applied job title
        $job_title = get_the_title($post_id);
        $applicant_post_keys = get_post_custom_keys( $post_id );

        if (NULL != $applicant_post_keys):
            foreach ($applicant_post_keys as $key) {
                if ('jobapp_' === substr($key, 0, 7)) {
                    $place = strpos($key, 'email');
                    if (!empty($place)) {
                        $applicant_email = get_post_meta($post_id, $key, TRUE);
                        break;
                    }
                }
            }
        endif;

        $subject = apply_filters( 'sjb_applicant_notification_sjb', 'Your Resume Received for Job [' . $job_title . ']', $job_title );
        $message = self::job_notification_templates( $post_id, 'applicant' );
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );

        // Validate Applicant Email
        if (isset($applicant_email) && is_email($applicant_email))
            wp_mail( $applicant_email, $subject, $message, $headers );
    }

    /**
     * Email Template
     *
     * @since  1.0.0
     * 
     * @param  int      $post_id                Post ID
     * @param  string   $notification_receiver  Notification Receiver (Admin or HR or || Applicant)
     * @return string   $message                Email Template
     */
    public static function job_notification_templates($post_id, $notification_receiver) {

        // Applied job title
        $job_title = get_the_title($post_id);

        // Site URL 
        $site_url = get_option( 'siteurl' );
        $parent_id = wp_get_post_parent_id( $post_id );
        $job_post_keys = get_post_custom_keys( $parent_id );
        $applicant_post_keys = get_post_custom_keys($post_id);
        $company_name = get_post_meta( $parent_id, 'simple_job_board_company_name', TRUE );

        // Search Applicant Name
        if (NULL != $applicant_post_keys):
            foreach ($applicant_post_keys as $key) {
                if ('jobapp_' === substr($key, 0, 7)) {
                    $place = strpos($key, 'name');
                    if (!empty($place)) {
                        $applicant_name = get_post_meta( $post_id, $key, TRUE );
                        break;
                    }
                }
            }
        endif;
        
        $header_title = ( 'applicant' != $notification_receiver ) ? 'Job Application' : 'Job Application Acknowledgement';
            
        $message = '<div style="width:700px; margin:0 auto;  border: 1px solid #95B3D7;font-family:Arial;">'
                . '<div style="border: 1px solid #95B3D7; background-color:#95B3D7;">'
                . ' <h2 style="text-align:center;">' . $header_title . '</h2>'
                . ' </div>'
                . '<div  style="margin:10px;">'
                . '<p>' . date("Y/m/d") . '</p>'
                . '<p>';
        
        if ( 'HR' === $notification_receiver ) {
            $message .= 'Dear ' . $notification_receiver . ',';
            $message .= '</p>'
                    . '<p>';

            if ( NULL != $applicant_name ):
                $message.= '<b>' . $applicant_name . '</b>';
            else:
                $message.= 'Applicant';
            endif;
            
            $message .= ' has applied against your job opening <b>' . $job_title . '</b> at <a href="' . $site_url . '">' . get_bloginfo('name') . '</a>'
                    . '. Please login to your account to download the CV or check from the applicant\'s list from dashboard.' . '</p>';
            
            /**
             * Hook -> Applicant details.
             * 
             * Add applicant's details in notification template.
             *
             * @since  2.2.3   
             * 
             * @param  int     $post_id                Post Id
             * @param  string  $notification_receiver  Notification Receiver 
             * @return string  $message                Message Template          
             */
            $message = apply_filters('sjb_applicant_details_notification', $message, $post_id, $notification_receiver);

            $message .= '<br>Best Regards,<br>'
                    . 'Admin<br>';          
        } elseif ('Admin' === $notification_receiver) {
            
             /* Admin/HR Email Template */ 
            if (NULL != $notification_receiver)
                $message .= 'Hi ' . $notification_receiver . ',</p>';
            
            $message .= '<p>I am applying for the job post <b>' . $job_title . '</b> with interest. I have attached my resume with job application. I have also filled the required details.</p>';
            
            /**
             * Hook -> Applicant details.
             * 
             * Add applicant's details in notification template.
             *
             * @since  2.2.3   
             * 
             * @param  int     $post_id                Post Id
             * @param  string  $notification_receiver  Notification Receiver 
             * @return string  $message                Message Template          
             */
            $message = apply_filters( 'sjb_applicant_details_notification', $message, $post_id, $notification_receiver );

            $message .= '<p>I look forward to hearing from you.</p>'
                    . 'Warm Regards,<br>';
            
            if (NULL != $applicant_name):
                $message.= $applicant_name . '';
            endif;
            
        } else {

            // Applicant Email Template.            
            $message .= 'Hi ';
            
            if (NULL != $applicant_name):
                $message .= '' . $applicant_name . ',';
            else:
                $message .= 'Applicant,';
            endif;
            
            $message .= '<p>Your application for the position of <b>' . $job_title . '</b> at <a href="' . $site_url . '">' . get_bloginfo('name') . '</a> has been successfully submitted. You will hear back from <a href="' . $site_url . '">' . get_bloginfo('name') . '</a> based on their evaluation of your CV.</p>'
                    .'<p>Good Luck! </p>'
                    . 'Best Regards,<br>'
                    . 'Admin';
        } 
        
        $message .= '</div>'
                 . '</div>';
        
        /**
         * Hook -> Notification Message.
         * 
         * @since  2.2.0
         * @since  2.2.3   Added $post_id and $notification_receiver parameters in filter.
         * 
         * @param  string  $message                Email Template
         * @param  int     $post_id                Post Id
         * @param  string  $notification_receiver  Notification Receiver 
         */
        return apply_filters( 'sjb_notification_template', $message, $post_id, $notification_receiver );
    }

}

new Simple_Job_Board_Notification();