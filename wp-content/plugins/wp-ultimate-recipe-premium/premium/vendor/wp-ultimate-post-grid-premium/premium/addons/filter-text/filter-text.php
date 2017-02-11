<?php

class WPUPG_Filter_Text extends WPUPG_Premium_Addon {

    public function __construct( $name = 'filter-text' ) {
        parent::__construct( $name );

        add_action( 'init', array( $this, 'assets' ) );
        add_action( 'wp_ajax_wpupg_filter_text', array( $this, 'ajax_filter_text' ) );
        add_action( 'wp_ajax_nopriv_wpupg_filter_text', array( $this, 'ajax_filter_text' ) );

        add_filter( 'wpupg_grid_cache_filter', array( $this, 'grid_cache_filter' ), 10, 3 );
        add_filter( 'wpupg_filter_shortcode', array( $this, 'filter_shortcode' ), 10, 2 );
    }

    public function assets() {
        if( !is_admin() ) {
            WPUltimatePostGrid::get()->helper( 'assets' )->add(
                array(
                    'name' => 'filter-text',
                    'file' => $this->addonPath . '/js/filter-text.js',
                    'premium' => true,
                    'public' => true,
                    'deps' => array(
                        'jquery',
                    )
                )
            );
        }
    }

    public function ajax_filter_text()
    {
        if( check_ajax_referer( 'wpupg_grid', 'security', false ) )
        {
            $grid = $_POST['grid'];
            $search = $_POST['search'];

            $post = get_page_by_path( $grid, OBJECT, WPUPG_POST_TYPE );

            if( !is_null( $post ) ) {
                $grid = new WPUPG_Grid($post);

                $grid_posts = $grid->posts();
                $post_ids = $grid_posts['all'];

                $args = array(
                    'post_type' => 'any',
                    'post_status' => 'any',
                    'post__in' => $post_ids,
                    'ignore_sticky_posts' => true,
                    'fields' => 'ids',
                    's' => $search,
                );
                
                $query = new WP_Query( $args );
                $posts = $query->have_posts() ? $query->posts : array();
                $post_ids = array_map( 'intval', $posts );

                echo $grid->draw_posts( 0, $post_ids );
            }
        }
        die();
    }

    public function grid_cache_filter( $filter, $cache, $grid ) {
        if( $grid->filter_type() == 'text' ) {
            $filter = '<input type="text" class="wpupg-filter-text-input"">';
        }

        return $filter;
    }

    public function filter_shortcode( $output, $grid) {
        if( $grid->filter_type() == 'text' ) {
            $output = '<div id="wpupg-grid-' . $grid->slug() . '-filter" class="wpupg-filter wpupg-filter-text" data-grid="' . $grid->slug() . '" data-type="text">';
            $output .= $grid->filter();
            $output .= '</div>';
        }

        return $output;
    }

    public function shortcode( $options )
    {
        $output = '';

        $slug = strtolower( trim( $options['id'] ) );

        if( $slug ) {
            unset( $options['id'] );
            $post = get_page_by_path( $slug, OBJECT, WPUPG_POST_TYPE );

            if( !is_null( $post ) ) {
                $grid = new WPUPG_Grid( $post );

                $filter = '';
                $output = apply_filters( 'wpupg_filter_text_shortcode', $filter, $grid );
            }
        }

        return $output;
    }
}

WPUltimatePostGrid::loaded_addon( 'filter-text', new WPUPG_Filter_Text() );