<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/**
 * Simple_Job_Board_Post_Types_Jobpost class
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
if (!class_exists('Simple_Job_Board_Post_Types_Jobpost')) {

    class Simple_Job_Board_Post_Types_Jobpost {

        /**
         * Initialize the class and set its properties.
         *
         * @access  public
         * @since   1.0.0
         */
        public function __construct() {
            // Add Hook into the 'init()' action
            add_action('init', array($this, 'simple_job_board_init'));

            // Add Hook into the 'admin_init()' action
            add_action('admin_init', array($this, 'simple_job_board_admin_init'));

            add_filter('the_content', array($this, 'job_content'));

            // Add Filter into the Single Page Template
            add_filter('single_template', array($this, 'get_simple_job_board_single_template'));

            // Add Filter into the Archive Page Template
            add_filter('archive_template', array($this, 'get_simple_job_board_archive_template'));

            /* WP Text Editor Filters */
            add_filter('sjb_the_job_description', 'wptexturize');
            add_filter('sjb_the_job_description', 'convert_smilies');
            add_filter('sjb_the_job_description', 'convert_chars');
            add_filter('sjb_the_job_description', 'wpautop');
            add_filter('sjb_the_job_description', 'shortcode_unautop');
            add_filter('sjb_the_job_description', 'prepend_attachment');
        }

        /**
         * A function hook that the WordPress core launches at 'init' points
         * 
         * @access  public
         * @since   1.0.0
         */
        public function simple_job_board_init() {
            $this->createPostType();
        }

        /**
         * A function hook that the WordPress core launches at 'admin_init' points
         * 
         * @access  public
         * @since   1.0.0
         */
        public function simple_job_board_admin_init() {

            // Hook - Taxonomy -> Job Category ->  Add New Column
            add_filter('manage_edit-jobpost_category_columns', array($this, 'job_board_category_column'));

            // Hook - Taxonomy -> Job Category ->  Add Value to New Column
            add_filter('manage_jobpost_category_custom_column', array($this, 'job_board_category_column_value'), 10, 3);

            // Hook - Taxonomy -> Job Type ->  Add New Column
            add_filter('manage_edit-jobpost_job_type_columns', array($this, 'job_board_job_type_column'));

            // Hook - Taxonomy -> Job Type ->  Add Value to New Column
            add_filter('manage_jobpost_job_type_custom_column', array($this, 'job_board_job_type_column_value'), 10, 3);

            // Hook - Taxonomy -> Job Location ->  Add New Column
            add_filter('manage_edit-jobpost_location_columns', array($this, 'job_board_job_location_column'));

            // Hook - Taxonomy -> Job Location ->  Add Value to New Column
            add_filter('manage_jobpost_location_custom_column', array($this, 'job_board_job_location_column_value'), 10, 3);
        }

        /**
         * create_post_type function.
         *
         * @access  public
         * @return  void
         */
        public function createPostType() {
            if (post_type_exists("jobpost"))
                return;

            /**
             * Post Type -> Jobs
             */
            $singular = __('Job', 'simple-job-board');
            $plural = __('Jobs', 'simple-job-board');

            if (get_option('job_board_jobpost_slug')) {
                $jobpost_slug = get_option('job_board_jobpost_slug');
            } else {
                $jobpost_slug = 'jobs';
            }

            if (get_option('job_board_job_category_slug')) {
                $category_slug = get_option('job_board_job_category_slug');
            } else {
                $category_slug = 'job-category';
            }

            if (get_option('job_board_job_type_slug')) {
                $job_type_slug = get_option('job_board_job_type_slug');
            } else {
                $job_type_slug = 'job-type';
            }

            if (get_option('job_board_job_location_slug')) {
                $job_location_slug = get_option('job_board_job_location_slug');
            } else {
                $job_location_slug = 'job-location';
            }


            $labels = array(
                'name' => $plural,
                'singular_name' => $singular,
                'menu_name' => __('Job Board', 'simple-job-board'),
                'all_items' => sprintf(__('All %s', 'simple-job-board'), $plural),
                'add_new' => __('Add New', 'simple-job-board'),
                'add_new_item' => sprintf(__('Add %s', 'simple-job-board'), $singular),
                'edit_item' => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'new_item' => sprintf(__('New %s', 'simple-job-board'), $singular),
                'view_item' => sprintf(__('View %s', 'simple-job-board'), $singular),
                'search_items' => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'not_found' => sprintf(__('No %s found', 'simple-job-board'), $plural),
                'not_found_in_trash' => sprintf(__('No %s found in trash', 'simple-job-board'), $plural),
                'parent' => sprintf(__('Parent %s', 'simple-job-board'), $singular),
            );

            $args = array(
                'labels' => $labels,
                'hierarchical' => FALSE,
                'description' => sprintf(__('This is where you can create and manage %s.', 'simple-job-board'), $plural),
                'public' => TRUE,
                'exclude_from_search' => FALSE,
                'publicly_queryable' => TRUE,
                'show_ui' => TRUE,
                'show_in_nav_menus' => TRUE,
                'menu_icon' => 'dashicons-clipboard',
                'capability_type' => 'post',
                'has_archive' => TRUE,
                'rewrite' => array('slug' => $jobpost_slug, 'hierarchical' => TRUE, 'with_front' => FALSE),
                'query_var' => TRUE,
                'can_export' => TRUE,
                'supports' => array(
                    'title',
                    'editor',
                    'excerpt',
                    'author',
                    'comments',
                    'page-attributes',
                    'thumbnail',
                ),
            );
            register_post_type("jobpost", apply_filters("register_post_type_jobpost", $args));

            /**
             * Post Type -> Jobs
             * Post Type -> Jobs -> Taxonomy -> Job Category
             */
            $singular = __('Job Category', 'simple-job-board');
            $plural = __('Job Categories', 'simple-job-board');

            $labels = array(
                'name' => $plural,
                'singular_name' => $singular,
                'menu_name' => ucwords($plural),
                'all_items' => sprintf(__('All %s', 'simple-job-board'), $plural),
                'edit_item' => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'update_item' => sprintf(__('Update %s', 'simple-job-board'), $singular),
                'add_new_item' => sprintf(__('Add New %s', 'simple-job-board'), $singular),
                'new_item_name' => sprintf(__('New %s Name', 'simple-job-board'), $singular),
                'parent_item' => sprintf(__('Parent %s', 'simple-job-board'), $singular),
                'parent_item_colon' => sprintf(__('Parent %s:', 'simple-job-board'), $singular),
                'add_or_remove_items' => __('Add or remove', 'simple-job-board'),
                'choose_from_most_used' => __('Choose from most used', 'simple-job-board'),
                'search_items' => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'popular_items' => sprintf(__('Popular %s', 'simple-job-board'), $plural),
            );

            register_taxonomy(
                    "jobpost_category", apply_filters('register_taxonomy_jobpost_category_object_type', array('jobpost')
                    ), apply_filters('register_taxonomy_jobpost_category_args', array(
                'label' => $plural,
                'labels' => $labels,
                'public' => TRUE,
                'show_in_quick_edit' => TRUE,
                'rewrite' => TRUE,
                'show_admin_column' => TRUE,
                'hierarchical' => TRUE,
                'query_var' => TRUE,
                'rewrite' => array('slug' => $category_slug,
                    'hierarchical' => TRUE,
                    'with_front' => FALSE
                ),
                            )
                    )
            );

            /**
             * Post Type -> Jobs
             * Post Type -> Jobs -> Taxonomy -> Job Type
             */
            $singular = __('Job Type', 'simple-job-board');
            $plural = __('Job Types', 'simple-job-board');

            $labels = array(
                'name' => $plural,
                'singular_name' => $singular,
                'menu_name' => ucwords($plural),
                'all_items' => sprintf(__('All %s', 'simple-job-board'), $plural),
                'edit_item' => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'update_item' => sprintf(__('Update %s', 'simple-job-board'), $singular),
                'add_new_item' => sprintf(__('Add New %s', 'simple-job-board'), $singular),
                'new_item_name' => sprintf(__('New %s Name', 'simple-job-board'), $singular),
                'parent_item' => sprintf(__('Parent %s', 'simple-job-board'), $singular),
                'parent_item_colon' => sprintf(__('Parent %s:', 'simple-job-board'), $singular),
                'add_or_remove_items' => __('Add or remove', 'simple-job-board'),
                'choose_from_most_used' => __('Choose from most used', 'simple-job-board'),
                'search_items' => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'popular_items' => sprintf(__('Popular %s', 'simple-job-board'), $plural),
            );

            register_taxonomy(
                    "jobpost_job_type", apply_filters('register_taxonomy_jobpost_job_type_object_type', array('jobpost')
                    ), apply_filters('register_taxonomy_jobpost_job_type_args', array(
                'label' => $plural,
                'labels' => $labels,
                'public' => TRUE,
                'show_in_quick_edit' => TRUE,
                'rewrite' => TRUE,
                'show_admin_column' => TRUE,
                'hierarchical' => TRUE,
                'query_var' => TRUE,
                'rewrite' => array('slug' => $job_type_slug,
                    'hierarchical' => TRUE,
                    'with_front' => FALSE
                ),
                            )
                    )
            );
            /**
             * Post Type -> Jobs
             * Post Type -> Jobs -> Taxonomy -> Job Location
             */
            $singular = __('Job Location', 'simple-job-board');
            $plural = __('Job Locations', 'simple-job-board');

            $labels = array(
                'name' => $plural,
                'singular_name' => $singular,
                'menu_name' => ucwords($plural),
                'all_items' => sprintf(__('All %s', 'simple-job-board'), $plural),
                'edit_item' => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'update_item' => sprintf(__('Update %s', 'simple-job-board'), $singular),
                'add_new_item' => sprintf(__('Add New %s', 'simple-job-board'), $singular),
                'new_item_name' => sprintf(__('New %s Name', 'simple-job-board'), $singular),
                'parent_item' => sprintf(__('Parent %s', 'simple-job-board'), $singular),
                'parent_item_colon' => sprintf(__('Parent %s:', 'simple-job-board'), $singular),
                'add_or_remove_items' => __('Add or remove', 'simple-job-board'),
                'choose_from_most_used' => __('Choose from most used', 'simple-job-board'),
                'search_items' => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'popular_items' => sprintf(__('Popular %s', 'simple-job-board'), $plural),
            );

            register_taxonomy(
                    "jobpost_location", apply_filters('register_taxonomy_jobpost_location_object_type', array('jobpost')
                    ), apply_filters('register_taxonomy_jobpost_location_args', array(
                'label' => $plural,
                'labels' => $labels,
                'public' => TRUE,
                'show_in_quick_edit' => TRUE,
                'rewrite' => TRUE,
                'show_admin_column' => TRUE,
                'hierarchical' => TRUE,
                'query_var' => TRUE,
                'rewrite' => array(
                    'slug' => $job_location_slug,
                    'hierarchical' => TRUE,
                    'with_front' => FALSE
                ),
                            )
                    )
            );
        }

        /**
         * Taxonomy -> Job Category ->  Add New Column
         *
         * @param unknown $columns
         * @access  public
         * @return multitype:
         */
        public function job_board_category_column($columns) {
            $columns['category_column'] = __('Shortcode', 'simple-job-board');
            return $columns;
        }

        /**
         * Taxonomy -> Job Category ->  Add Value to New Column
         *
         * @param   unknown     $content
         * @param   unknown     $column_name
         * @param   unknown     $term_id
         * @access  public
         */
        public function job_board_category_column_value($content, $column_name, $term_id) {
            $term = get_term_by('id', $term_id, 'jobpost_category');

            if ($column_name == 'category_column') {
                $content = '[jobpost category="' . $term->slug . '"]';
            }
            return $content;
        }

        /**
         * Taxonomy -> Job Type ->  Add New Column
         *
         * @param unknown $columns
         * @access  public
         * @return multitype:
         */
        public function job_board_job_type_column($columns) {
            $columns['job_type_column'] = __('Shortcode', 'simple-job-board');
            return $columns;
        }

        /**
         * Taxonomy -> Job Type ->  Add Value to New Column
         *
         * @param   unknown     $content
         * @param   unknown     $column_name
         * @param   unknown     $term_id
         * @access  public
         */
        public function job_board_job_type_column_value($content, $column_name, $term_id) {
            $term = get_term_by('id', $term_id, 'jobpost_job_type');
            if ($column_name == 'job_type_column') {
                $content = '[jobpost type="' . $term->slug . '"]';
            }
            return $content;
        }

        /**
         * Taxonomy -> Job Location ->  Add New Column
         *
         * @param unknown $columns
         * @access  public
         * @return multitype:
         */
        public function job_board_job_location_column($columns) {
            $columns['job_location_column'] = __('Shortcode', 'simple-job-board');
            return $columns;
        }

        /**
         * Taxonomy -> Job Location ->  Add Value to New Column
         *
         * @param   unknown     $content
         * @param   unknown     $column_name
         * @param   unknown     $term_id
         * @access  public
         */
        public function job_board_job_location_column_value($content, $column_name, $term_id) {
            $term = get_term_by('id', $term_id, 'jobpost_location');

            if ($column_name == 'job_location_column') {
                $content = '[jobpost location="' . $term->slug . '"]';
            }
            return $content;
        }

        /**
         * To load single course page in front end
         *
         * @param string $single_template        	
         * @return string
         */
        function get_simple_job_board_single_template($single_template) {
            global $post;
            
            if ('jobpost' === $post->post_type) {
                if (!file_exists(get_stylesheet_directory() . '/simple_job_board/single-jobpost.php')) {                   
                    
                    $single_template = SIMPLE_JOB_BOARD_PLUGIN_DIR . '/templates/single-jobpost.php';
                } else {
                    $single_template = get_stylesheet_directory() . '/simple_job_board/single-jobpost.php';
                }
            }
            return $single_template;
        }

        /**
         * To load archive course page in front end
         *
         * @param string $archive_template        	
         * @return string
         */
        function get_simple_job_board_archive_template($archive_template) {

            if (is_post_type_archive('jobpost')) {
                if (!file_exists(get_stylesheet_directory() . '/simple_job_board/archive-jobpost.php')) {
                    $archive_template = SIMPLE_JOB_BOARD_PLUGIN_DIR . '/templates/archive-jobpost.php';
                } else {
                    $archive_template = get_stylesheet_directory() . '/simple_job_board/archive-jobpost.php';
                }
            }
            return $archive_template;
        }

        /**
         * Add extra content when showing job content
         */
        public function job_content($content) {
            global $post;

            if (!is_singular('jobpost') || !in_the_loop()) {
                return $content;
            }

            remove_filter('the_content', array($this, 'job_content'));

            if (is_single() and 'jobpost' === $post->post_type) {
                ob_start();
                do_action('job_content_start');
                get_simple_job_board_template_part('content-single', 'job-listing');
                do_action('job_content_end');
                $content = ob_get_clean();
            }

            add_filter('the_content', array($this, 'job_content'));

            return apply_filters('simple_job_board_single_job_content', $content, $post);
        }

    }

}