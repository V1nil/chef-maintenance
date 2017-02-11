<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Job_Board_Post_Type_Jobpost Class
 * 
 * This file is used to define the jobpost custom post type.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.2.0
 * 
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes/posttypes 
 * @author     PressTigers <support@presstigers.com>
 */

if (!class_exists('Simple_Job_Board_Post_Type_Jobpost')) {

    class Simple_Job_Board_Post_Type_Jobpost {

        /**
         * Initialize the class and set its properties.
         *         
         * @since   2.2.0
         */
        public function __construct() {
            
            // Add Hook into the 'init()' action
            add_action( 'init', array( $this, 'simple_job_board_init') );  

            // Add Hook into the 'admin_init()' action
            add_action( 'admin_init', array( $this, 'simple_job_board_admin_init' ) );                        
        }

        /**
         * A function hook that the WordPress core launches at 'init' points
         *          
         * @since   2.2.0
         */
        public function simple_job_board_init() { 
            
            $this->createPostType();

            // Flush Rewrite Rules 
            flush_rewrite_rules();
            
            // Add Filter into the Single Page Template
            add_filter( 'single_template', array( $this, 'get_simple_job_board_single_template' ), 10 , 1 );

            // Add Filter into the Archive Page Template
            add_filter( 'archive_template', array( $this, 'get_simple_job_board_archive_template' ), 10 , 1 );
        }

        /**
         * A function hook that the WordPress core launches at 'admin_init' points
         * 
         * @since   2.2.0
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
         * @since   2.2.0
         */
        public function createPostType() {
            
            if (post_type_exists("jobpost"))
                return;

            /**
             * Post Type -> Jobs
             */
            $singular = __('Job', 'simple-job-board');
            $plural = __('Jobs', 'simple-job-board');
            
            /* Custom Post Type & Taxonomies Slugs */
            $jobpost_slug = get_option('job_board_jobpost_slug') ? get_option('job_board_jobpost_slug') : 'jobs';
            $category_slug = get_option('job_board_job_category_slug') ? get_option('job_board_job_category_slug') : 'job-category';
            $job_type_slug = get_option('job_board_job_type_slug') ? get_option('job_board_job_type_slug') : 'job-type';
            $job_location_slug = get_option('job_board_job_location_slug') ? get_option('job_board_job_location_slug') : 'job-location';
            
            // Post Type -> Jobs -> Labels
            $labels_jobs = array(
                'name'               => $plural,
                'singular_name'      => $singular,
                'menu_name'          => __('Job Board', 'simple-job-board'),
                'all_items'          => sprintf(__('All %s', 'simple-job-board'), $plural),
                'add_new'            => __('Add New', 'simple-job-board'),
                'add_new_item'       => sprintf(__('Add %s', 'simple-job-board'), $singular),
                'edit_item'          => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'new_item'           => sprintf(__('New %s', 'simple-job-board'), $singular),
                'view_item'          => sprintf(__('View %s', 'simple-job-board'), $singular),
                'search_items'       => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'not_found'          => sprintf(__('No %s found', 'simple-job-board'), $plural),
                'not_found_in_trash' => sprintf(__('No %s found in trash', 'simple-job-board'), $plural),
                'parent'             => sprintf(__('Parent %s', 'simple-job-board'), $singular),
            );
            
            // Post Type -> Jobs -> Arguments
            $args_jobs = array(
                'labels'                => $labels_jobs,
                'hierarchical'          => FALSE,
                'description'           => sprintf(__('This is where you can create and manage %s.', 'simple-job-board'), $plural),
                'public'                => TRUE,
                'exclude_from_search'   => FALSE,
                'publicly_queryable'    => TRUE,
                'show_ui'               => TRUE,
                'show_in_nav_menus'     => TRUE,
                'menu_icon'             => 'dashicons-clipboard',
                'capability_type'       => 'post',
                'has_archive'           => TRUE,
                'rewrite'               => array('slug' => $jobpost_slug, 'hierarchical' => TRUE, 'with_front' => FALSE),
                'query_var'             => TRUE,
                'can_export'            => TRUE,
                'supports'              => array(
                                                'title',
                                                'editor',
                                                'excerpt',
                                                'author',
                                                'comments',
                                                'thumbnail',
                                                'page-attributes',                   
                                           ),
            );
            
            // Register Custom Post Type -> Jobpost
            register_post_type( "jobpost", apply_filters( "register_post_type_jobpost", $args_jobs ) );

            /**
             * Post Type -> Jobs
             * Post Type -> Jobs -> Taxonomy -> Job Category
             */
            $singular = __('Job Category', 'simple-job-board');
            $plural = __('Job Categories', 'simple-job-board');
            
            // Post Type -> Jobs -> Taxonomy -> Job Category -> Labels
            $labels_category = array(
                'name'                  => $plural,
                'singular_name'         => $singular,
                'menu_name'             => ucwords($plural),
                'all_items'             => sprintf(__('All %s', 'simple-job-board'), $plural),
                'edit_item'             => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'update_item'           => sprintf(__('Update %s', 'simple-job-board'), $singular),
                'add_new_item'          => sprintf(__('Add New %s', 'simple-job-board'), $singular),
                'new_item_name'         => sprintf(__('New %s Name', 'simple-job-board'), $singular),
                'parent_item'           => sprintf(__('Parent %s', 'simple-job-board'), $singular),
                'parent_item_colon'     => sprintf(__('Parent %s:', 'simple-job-board'), $singular),
                'add_or_remove_items'   => __('Add or remove', 'simple-job-board'),
                'choose_from_most_used' => __('Choose from most used', 'simple-job-board'),
                'search_items'          => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'popular_items'         => sprintf(__('Popular %s', 'simple-job-board'), $plural),
            );
            
            // Post Type -> Jobs -> Taxonomy -> Job Category -> Arguments
            $args_category = array(
                'label'              => $plural,
                'labels'             => $labels_category,
                'public'             => TRUE,
                'show_in_quick_edit' => TRUE,
                'rewrite'            => TRUE,
                'show_admin_column'  => TRUE,
                'hierarchical'       => TRUE,
                'query_var'          => TRUE,
                'rewrite'            => array(
                                            'slug' => $category_slug,
                                            'hierarchical' => TRUE,
                                            'with_front' => FALSE
                                        ),
            );
            
            // Register Job Categry Taxonomy
            register_taxonomy(
                "jobpost_category",
                apply_filters('register_taxonomy_jobpost_category_object_type', array('jobpost') ),
                apply_filters('register_taxonomy_jobpost_category_args', $args_category )
            );

            /**
             * Post Type -> Jobs
             * Post Type -> Jobs -> Taxonomy -> Job Type
             */
            $singular = __('Job Type', 'simple-job-board');
            $plural = __('Job Types', 'simple-job-board');
            
            // Post Type -> Jobs -> Taxonomy -> Job Type -> Labels
            $labels_type = array(
                'name'                  => $plural,
                'singular_name'         => $singular,
                'menu_name'             => ucwords($plural),
                'all_items'             => sprintf(__('All %s', 'simple-job-board'), $plural),
                'edit_item'             => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'update_item'           => sprintf(__('Update %s', 'simple-job-board'), $singular),
                'add_new_item'          => sprintf(__('Add New %s', 'simple-job-board'), $singular),
                'new_item_name'         => sprintf(__('New %s Name', 'simple-job-board'), $singular),
                'parent_item'           => sprintf(__('Parent %s', 'simple-job-board'), $singular),
                'parent_item_colon'     => sprintf(__('Parent %s:', 'simple-job-board'), $singular),
                'add_or_remove_items'   => __('Add or remove', 'simple-job-board'),
                'choose_from_most_used' => __('Choose from most used', 'simple-job-board'),
                'search_items'          => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'popular_items'         => sprintf(__('Popular %s', 'simple-job-board'), $plural),
            );
            
            // Post Type -> Jobs -> Taxonomy -> Job Type -> Arguments
            $args_type = array(
                'label'              => $plural,
                'labels'             => $labels_type,
                'public'             => TRUE,
                'show_in_quick_edit' => TRUE,
                'rewrite'            => TRUE,
                'show_admin_column'  => TRUE,
                'hierarchical'       => TRUE,
                'query_var'          => TRUE,
                'rewrite'            => array(
                                            'slug'          => $job_type_slug,
                                            'hierarchical'  => TRUE,
                                            'with_front'    => FALSE
                ),
            );
            
            // Register Job Type Taxonomy
            register_taxonomy(
                "jobpost_job_type",
                apply_filters( 'register_taxonomy_jobpost_job_type_object_type', array('jobpost') ),
                apply_filters( 'register_taxonomy_jobpost_job_type_args', $args_type )
            );
            
            /**
             * Post Type -> Jobs
             * Post Type -> Jobs -> Taxonomy -> Job Location
             */
            $singular = __('Job Location', 'simple-job-board');
            $plural = __('Job Locations', 'simple-job-board');
            
            // Post Type -> Jobs -> Taxonomy -> Job Location -> Labels
            $labels_location = array(
                'name'                  => $plural,
                'singular_name'         => $singular,
                'menu_name'             => ucwords($plural),
                'all_items'             => sprintf(__('All %s', 'simple-job-board'), $plural),
                'edit_item'             => sprintf(__('Edit %s', 'simple-job-board'), $singular),
                'update_item'           => sprintf(__('Update %s', 'simple-job-board'), $singular),
                'add_new_item'          => sprintf(__('Add New %s', 'simple-job-board'), $singular),
                'new_item_name'         => sprintf(__('New %s Name', 'simple-job-board'), $singular),
                'parent_item'           => sprintf(__('Parent %s', 'simple-job-board'), $singular),
                'parent_item_colon'     => sprintf(__('Parent %s:', 'simple-job-board'), $singular),
                'add_or_remove_items'   => __('Add or remove', 'simple-job-board'),
                'choose_from_most_used' => __('Choose from most used', 'simple-job-board'),
                'search_items'          => sprintf(__('Search %s', 'simple-job-board'), $plural),
                'popular_items'         => sprintf(__('Popular %s', 'simple-job-board'), $plural),
            );
            
            // Post Type -> Jobs -> Taxonomy -> Job Location -> Arguments
            $args_location = array(
                'label'              => $plural,
                'labels'             => $labels_location,
                'public'             => TRUE,
                'show_in_quick_edit' => TRUE,
                'rewrite'            => TRUE,
                'show_admin_column'  => TRUE,
                'hierarchical'       => TRUE,
                'query_var'          => TRUE,
                'rewrite'            => array(
                                            'slug'          => $job_location_slug,
                                            'hierarchical'  => TRUE,
                                            'with_front'    => FALSE,
                                        ),
            );
            
            // Register Job Location Taxonomy
            register_taxonomy(
                "jobpost_location",
                apply_filters('register_taxonomy_jobpost_location_object_type', array('jobpost') ),
                apply_filters( 'register_taxonomy_jobpost_location_args', $args_location )
            );
        }        
        
        /**
         * Taxonomy -> Job Category ->  Add New Column.
         *
         * @since   2.0.0
         * 
         * @param   Array   $columns    Category Taxonomy Columns.  
         * @return  Array   $columns    Shortcode Column.
         */
        public function job_board_category_column($columns) {
            
            $columns['category_column'] = __('Shortcode', 'simple-job-board');
            return $columns;
        }

        /**
         * Taxonomy -> Job Category ->  Add Value to New Column.
         *
         * @since   2.0.0
         * 
         * @param   string  $content        Column Value.
         * @param   string  $column_name    Column Name.
         * @param   int     $term_id        Taxonomy Id.
         * @return  string  $content        Category Shortcode Value.
         */
        public function job_board_category_column_value( $content, $column_name, $term_id) {
            
            $term = get_term_by('id', $term_id, 'jobpost_category');

            if ($column_name == 'category_column') {
                $content = '[jobpost category="' . $term->slug . '"]';
            }
            return $content;
        }

        /**
         * Taxonomy -> Job Type ->  Add New Column.
         *
         * @since   2.0.0
         * 
         * @param   Array   $columns    Job Type Taxonomy Columns.  
         * @return  Array   $columns    Shortcode Column.
         */
        public function job_board_job_type_column($columns) {
            
            $columns['job_type_column'] = __('Shortcode', 'simple-job-board');
            return $columns;
        }

        /**
         * Taxonomy -> Job Type ->  Add Value to New Column.
         *
         * @since   2.0.0
         * 
         * @param   string  $content        Column Value.
         * @param   string  $column_name    Column Name.
         * @param   int     $term_id        Taxonomy Id.
         * @return  string  $content        Job Type Shortcode Value.
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
         * @since   2.0.0
         * 
         * @param   Array   $columns    Job Location Taxonomy Columns.  
         * @return  Array   $columns    Shortcode Column.
         */
        public function job_board_job_location_column($columns) {
            
            $columns['job_location_column'] = __('Shortcode', 'simple-job-board');
            return $columns;
        }

        /**
         * Taxonomy -> Job Location ->  Add Value to New Column
         *
         * @since   2.0.0
         * 
         * @param   string  $content        Column Value.
         * @param   string  $column_name    Column Name.
         * @param   int     $term_id        Taxonomy Id.
         * @return  string  $content        Job Location Shortcode Value.
         */
        public function job_board_job_location_column_value( $content, $column_name, $term_id ) {
            
            $term = get_term_by('id', $term_id, 'jobpost_location');

            if ($column_name == 'job_location_column') {
                $content = '[jobpost location="' . $term->slug . '"]';
            }
            return $content;
        }

        /**
         * To load single job page in frontend.
         *
         * @since   2.2.0
         * 
         * @param   string  $single_template    Default Single Page Path.        	
         * @return  string  $single_template    Plugin Single Page Path.
         */
        function get_simple_job_board_single_template( $single_template ) {
            
            global $post;
            
            if ('jobpost' === $post->post_type) {
                $single_template =  ( !file_exists(get_stylesheet_directory() . '/simple_job_board/single-jobpost.php') ) ?
                                    SIMPLE_JOB_BOARD_PLUGIN_DIR . '/templates/single-jobpost.php' :
                                    get_stylesheet_directory() . '/simple_job_board/single-jobpost.php';
            }
            return $single_template;
        }
        
        /**
         * To load archive job page in frontend.
         *
         * @since   2.2.0
         * 
         * @param   string  $archive_template   Default Archive Page Path.     	
         * @return  string  $archive_template   Plugin Archive Page Path.
         */
        function get_simple_job_board_archive_template( $archive_template ) {
            

            if ( is_post_type_archive( 'jobpost' ) ) {
                $archive_template = ( !file_exists( get_stylesheet_directory() . '/simple_job_board/archive-jobpost.php' ) ) ?
                                    SIMPLE_JOB_BOARD_PLUGIN_DIR . '/templates/archive-jobpost.php' :
                                    get_stylesheet_directory() . '/simple_job_board/archive-jobpost.php';
            }
            return $archive_template;
        }
    }
}