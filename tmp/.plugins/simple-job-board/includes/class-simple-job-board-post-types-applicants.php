<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/**
 * Simple_Job_Board_Post_Types_Applicants class
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       1.0.0
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
 * @since       1.0.0
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 * @author      PressTigers <support@presstigers.com>
 */
if (!class_exists('Simple_Job_Board_Post_Types_Applicants')) {

    class Simple_Job_Board_Post_Types_Applicants {

        /**
         * Initialize the class and set its properties.
         *
         * @access  public
         * @since   1.0.0
         */
        public function __construct()
        {            
            // Add Hook into the 'init()' action
            add_action('init', array($this, 'simple_job_board_init'));

            // Add Hook into the 'admin_init()' action
            add_action('admin_init', array($this, 'simple_job_board_admin_init'));
        }

        /**
         * A function hook that the WordPress core launches at 'init' points
         * 
         * @access  public
         * @since   1.0.0
         */
        public function simple_job_board_init()
        {
            $this->createPostType();
        }

        /**
         * A function hook that the WordPress core launches at 'admin_init' points
         * 
         * @access  public
         * @since   1.0.0
         */
        public function simple_job_board_admin_init()
        {            
            // Hook - Delete Uploads on Applicant Deletion
            add_action('before_delete_post', array($this, 'job_board_delete_uploads'));

            // Hook - Post Type -> Applicants ->  Add New Column
            add_filter('manage_edit-jobpost_applicants_columns', array($this, 'job_board_applicant_list_columns'));

            // Hook - Post Type -> Applicants ->  Add Value to New Column
            add_filter('manage_jobpost_applicants_posts_custom_column', array($this, 'job_board_applicant_list_columns_value'), 10, 2);
        }

        /**
         * create_post_type function.
         *
         * @access  public
         * @return  void
         */
        public function createPostType()
        {
            if (post_type_exists("jobpost_applicants"))
                return;

            /**
             * Post Type -> Applicants
             */
            $plural = __('Applicants', 'simple-job-board');

            $labels = array(
                'edit_item' => sprintf(__('Edit %s', 'simple-job-board'), $plural),
            );

            $labels = array(
                'edit_item' => sprintf(__('Edit %s', 'simple-job-board'), $plural),
            );

            $args = array(
                'label'               => $plural,
                'labels'              => $labels,
                'description'         => sprintf(__('List of %s with their resume.', 'simple-job-board'), $plural),
                'public'              => FALSE,
                'exclude_from_search' => FALSE,
                'publicly_queryable'  => TRUE,
                'show_ui'             => TRUE,
                'show_in_menu'        => 'edit.php?post_type=jobpost',
                'show_in_nav_menus'   => TRUE,
                'menu_icon'           => 'dashicons-clipboard',
                'can_export'          => TRUE,
                'capabilities'        => array(
                    'create_posts' => FALSE,
                ),
                'map_meta_cap'        => TRUE,
                'hierarchical'        => FALSE,
                'supports'            => array('editor')
            );

            register_post_type("jobpost_applicants", apply_filters("register_post_type_jobpost_applicants", $args));
        }

        /**
         * Delete Uploads on Applicant Deletion 
         *
         * @param   int     $postId
         * @access  public
         * @return  void
         */
        public function job_board_delete_uploads($postId) 
        {
            global $post_type;
            if ($post_type == 'jobpost_applicants' && '' != get_post_meta($postId, 'resume_path', TRUE))
                unlink( get_post_meta($postId, 'resume_path', TRUE) );
        }

        /**
         * Applicants ->  Add New Column
         *
         * @param   array   $columns
         * @access  public
         * @return  array
         */
        public function job_board_applicant_list_columns($columns)
        {
            $columns = array(
                'cb'        => '<input type="checkbox" />',
                'title'     => __('Job Applied for', 'simple-job-board'),
                'applicant' => __('Applicant', 'simple-job-board'),
                'taxonomy'  => __('Categories', 'simple-job-board'),
                'date'      => __('Date', 'simple-job-board'),
            );
            return $columns;
        }

        /**
         * Applicants ->  Add Value to New Column
         *
         * @param   array   $columns
         * @param   int     $post_id
         * @access  public
         * @return  void
         */         
        public function job_board_applicant_list_columns_value($column, $post_id)
        {
            $keys = get_post_custom_keys($post_id);
            switch ($column) {
                case 'applicant' :
                    $applicant_name = sprintf('<a href="%s">%s</a>', esc_url(add_query_arg(array('post' => $post_id, 'action' => 'edit'), 'post.php')), esc_html(get_post_meta($post_id, $keys[0], TRUE))
                    );
                    echo $applicant_name;
                    break;
                case 'taxonomy' :
                    $parent_id = wp_get_post_parent_id($post_id); // get_post_field ( 'post_parent', $post_id );
                    $terms = get_the_terms($parent_id, 'jobpost_category');
                    if (!empty($terms)) {
                        $out = array();
                        foreach ($terms as $term) {
                            $out[] = sprintf('<a href="%s">%s</a>', esc_url(add_query_arg(array('post_type' => get_post_type($parent_id), 'jobpost_category' => $term->slug), 'edit.php')), esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'jobpost_category', 'display'))
                            );
                        }
                        echo join(', ', $out);
                    }/* If no terms were found, output a default message. */ else {
                        _e('No Categories', 'simple-job-board');
                    }
                    break;
            }
        }

    }

}