<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Ajax class.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.1.0
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 */

/**
 * This is used to define custom post types.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since       2.1.0
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 * @author      PressTigers <support@presstigers.com>
 */
class Simple_Job_Board_Ajax {

    /**
     * Constructor
     */
    public function __construct() {
        // Hook - Entertain Applicant Request From Job Apply Form
        add_action('wp_ajax_nopriv_process_applicant_form', array($this, 'process_applicant_form'));
        add_action('wp_ajax_process_applicant_form', array($this, 'process_applicant_form'));
    }

    /**
     * Entertain Applicant Request From Job Apply Form
     *
     * @access public
     * @return void
     */
    public function process_applicant_form() {
        $nonce = $_POST['wp_nonce'];
        if (!wp_verify_nonce($nonce, 'the_best_jobpost_security_nonce'))
            die('Not Working');

        /* Initialixing Variables */
        $error = NULL;
        $error_assignment = NULL;
        $newupload = NULL;
        
        do_action( 'sjb_uploaded_resume_validation_before' );
        
        ob_start();
        
        if (strlen($_FILES['applicant_resume']['name']) > 3) {
            $uploadfiles = $_FILES['applicant_resume'];
            if (is_array($uploadfiles)) {
                $upload_dir = wp_upload_dir();
                $assignment_upload_size = 200;
                $time = (!empty($_SERVER['REQUEST_TIME'])) ? $_SERVER['REQUEST_TIME'] : (time() + (get_option('gmt_offset') * 3600)); // Fallback of now

                $post_type = 'jobpost';
                $date = explode(" ", date('Y m d H i s', $time));
                $timestamp = strtotime(date('Y m d H i s'));
                if ($post_type) {
                    $upload_dir = array(
                        'path' => get_home_path() . 'wp-content/uploads/' . $post_type . '/' . $date[0],
                        'url'     => WP_CONTENT_URL . '/uploads/' . $post_type . '/' . $date[0],
                        'subdir'  => '',
                        'basedir' => WP_CONTENT_DIR . '/uploads',
                        'baseurl' => WP_CONTENT_URL . '/uploads',
                        'error'   => false,
                    );
                }
                if (!is_dir($upload_dir['path'])) {
                    wp_mkdir_p($upload_dir['path']);
                }
                
                $var_cp_assigment_type = 'png';
                
                $uploadfiles = array(
                    'name'     => $_FILES['applicant_resume']['name'],
                    'type'     => $_FILES['applicant_resume']['type'],
                    'tmp_name' => $_FILES['applicant_resume']['tmp_name'],
                    'error'    => $_FILES['applicant_resume']['error'],
                    'size'     => $_FILES['applicant_resume']['size']
                );

                // Look only for uploded files
                if ($uploadfiles['error'] == 0) {

                    $filetmp = $uploadfiles['tmp_name'];
                    $filename = $uploadfiles['name'];
                    $filesize = $uploadfiles['size'];
                    $max_upload_size = $assignment_upload_size * 1048576; //Multiply by KBs

                    if ($max_upload_size < $filesize) {
                        $assignment_error[] = __('Maximum upload File size allowed ' . $assignment_upload_size . 'MB', 'simple-job-board');
                        $error_assignment = 1;
                    }
                    $file_type_match = 0;
                    $var_cp_assigment_type_array = array();

                    if ($var_cp_assigment_type) {
                        $var_cp_assigment_type_array = explode(',', $var_cp_assigment_type);
                    }

                    /** Get file info
                     *   @fixme: wp checks the file extension
                     */
                    $filetype = wp_check_filetype(basename($filename), NULL);
                    $file_ext = strtolower($filetype['ext']);
                    $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));
                    $filename = $filetitle . $timestamp . '.' . $file_ext;

                    /**
                     * Check if the filename already exist in the directory & rename
                     * the file if necessary
                     */
                    $i = 0;

                    while (file_exists($upload_dir['path'] . '/' . $filename)) {
                        $filename = $filetitle . $timestamp . '_' . $i . '.' . $file_ext;
                        $i++;
                    }
                    $filedest = $upload_dir['path'] . '/' . $filename;

                    // Check write permissions
                    if (!is_writeable($upload_dir['path'])) {
                        $assignment_error[] = 'Unable to write to directory %s. Is this directory writable by the server?';
                        $error_assignment = 1;
                    }

                    // Check valid file extensions
                    $allowed_file_exts = get_option('job_board_allowed_extensions');
                    $settings_file_exts = get_option('job_board_upload_file_ext');

                    // Selection of Setting Extension 
                    $file_extension = ( ( 'yes' === get_option('job_board_all_extensions_check') ) || ( NULL == $settings_file_exts ) ) ? $allowed_file_exts : $settings_file_exts;

                    if (!in_array($file_ext, $file_extension)) {
                        $assignment_error[] = __('This is not an allowed file type.', 'simple-job-board');
                        $error_assignment = 1;
                    }

                    // Save Temporary File to Uploads Dir
                    if ($error_assignment <> 1) {
                        if (!@move_uploaded_file($filetmp, $filedest)) {
                            $assignment_error[] = 'Error, the file $filetmp could not moved to : $filedest .';
                            $error_assignment = 1;
                        }
                        $url = $upload_dir['url'];
                        $path = $upload_dir['path'];
                        $newupload = $upload_dir['url'] . '/' . $filename;
                        $uploadpath = $upload_dir['path'] . '/' . $filename;
                    }
                }
            }
        }
        
        $html = ob_get_clean();
        echo apply_filters( 'sjb_uploaded_resume_validation' , $html);
        
        do_action( 'sjb_uploaded_resume_validation_after' );
        
        if ( $error_assignment == 1 ) {

            do_action('sjb_job_submission_validation_error_before');

            $errors = '<div id="uploded-file-error">';
            foreach ($assignment_error as $error_value) {
                $errors .= esc_html__($error_value, 'simple-job-board');
            }

            $response = json_encode(array('success' => FALSE, 'error' => $errors));
            header("Content-Type: application/json");
            echo apply_filters('sjb_job_submit_validation_errors', $response);

            do_action('sjb_job_submission_validation_error_after');

            die();
        }

        do_action('sjb_applicants_insert_post_before');

        $args = apply_filters('sjb_applicant_insert_post_args', array(
            'post_type'    => 'jobpost_applicants',
            'post_content' => '',
            'post_parent'  => $_POST['job_id'],
            'post_title'   => get_the_title($_POST['job_id']),
            'post_status'  => 'publish',
                ));
        $pid = wp_insert_post($args);

        do_action('sjb_applicants_insert_post_start');

        if (!empty($newupload)) {
            $resume_name = $pid . '_' . $filename;
            $resume_url  = $url . '/' . $resume_name;
            $resume_path = $path . '/' . $resume_name;
            rename($uploadpath, $resume_path);
            add_post_meta($pid, 'resume', $resume_url);
            add_post_meta($pid, 'resume_path', $resume_path);
        }

        foreach ($_POST as $key => $val):

            if (substr($key, 0, 7) == 'jobapp_'):
                add_post_meta($pid, $key, $val);
            endif;          
        endforeach;

        do_action('sjb_applicants_insert_post_end');

        if ($pid > 0)
            $response = json_encode(array('success' => TRUE));    // generate the response.
        else
            $response = json_encode(array('success' => FALSE));    // generate the response.


            
        // response output
        header("Content-Type: application/json");
        echo $response;

        do_action('sjb_applicants_insert_post_after');

        // Admin Notification 
        do_action('sjb_admin_notices_before');

        if ('yes' === get_option('job_board_admin_notification'))
            Simple_Job_Board_Notification::admin_notification($pid);

        //  HR Notification
        if (('yes' === get_option('job_board_hr_notification')) && ('' != get_option('settings_hr_email')))
            Simple_Job_Board_Notification::hr_notification($pid);

        // Applicant Notification
        if ('yes' === get_option('job_board_applicant_notification'))
            Simple_Job_Board_Notification::applicant_notification($pid);

        do_action('sjb_admin_notices_after');
        
        exit();
    }

}

new Simple_Job_Board_Ajax();