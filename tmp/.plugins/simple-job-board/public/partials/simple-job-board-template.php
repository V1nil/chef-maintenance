<?php

/**
 * Template Functions
 *
 * Template functions specifically created for job listings
 *
 * @author 	PressTigers
 * @category 	Core
 * @package 	Simple Job Board/Template
 * @version     1.0.0
 */

/**
 * Get and include template files.
 *
 * @param   mixed   $template_name
 * @param   array   $args (default: array())
 * @param   string  $template_path (default: '')
 * @param   string  $default_path (default: '')
 * @return  void
 */
function get_simple_job_board_template($template_name, $args = array(), $template_path = 'simple_job_board', $default_path = '') {
    if ($args && is_array($args)) {
        extract($args);
    }
    include( locate_simple_job_board_template($template_name, $template_path, $default_path) );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme		/	$template_path	/	$template_name
 * yourtheme		/	$template_name
 * $default_path	/	$template_name
 *
 * @param string $template_name
 * @param string $template_path (default: 'simple_job_board')
 * @param string|bool $default_path (default: '') False to not load a default
 * @return string
 */
function locate_simple_job_board_template($template_name, $template_path = 'simple_job_board', $default_path = '') {
    // Look within passed path within the theme - this is priority
    $template = locate_template(
            array(
                trailingslashit($template_path) . $template_name,
                $template_name
            )
    );

    // Get default template
    if (!$template && $default_path !== false) {
        $default_path = $default_path ? $default_path : SIMPLE_JOB_BOARD_PLUGIN_DIR . '/templates/';
        if (file_exists(trailingslashit($default_path) . $template_name)) {
            $template = trailingslashit($default_path) . $template_name;
        }
    }

    // Return what we found
    return apply_filters('simple_job_board_locate_template', $template, $template_name, $template_path);
}

/**
 * Get template part (for templates in loops).
 *
 * @param string $slug
 * @param string $name (default: '')
 * @param string $template_path (default: 'simple_job_board')
 * @param string|bool $default_path (default: '') False to not load a default
 */
function get_simple_job_board_template_part($slug, $name = '', $template_path = 'simple_job_board', $default_path = '') {
    $template = '';

    if ($name) {
        $template = locate_simple_job_board_template("{$slug}-{$name}.php", $template_path, $default_path);
    }

    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/simple_job_board/slug.php
    if (!$template) {
        $template = locate_simple_job_board_template("{$slug}.php", $template_path, $default_path);
    }

    if ($template) {
        load_template($template, false);
    }
}

/**
 * Add custom body classes
 * @param  array $classes
 * @return array
 */
function simple_job_board_body_class($classes) {
    $classes = (array) $classes;
    $classes[] = sanitize_title(wp_get_theme());

    return array_unique($classes);
}

add_filter('body_class', 'simple_job_board_body_class');

/**
 * sjb_the_job_category function.
 *
 * @access public
 * @return void
 */
function sjb_the_job_category($post = NULL) {
    if ($job_category = sjb_get_the_job_category($post)) {
        foreach ($job_category as $cat) {
            echo $cat->name;
        }
    }
}

/**
 * sjb_get_the_job_category function.
 *
 * @access public
 * @param mixed $post (default: null)
 * @return void
 */
function sjb_get_the_job_category($post = NULL) {
    $post = get_post($post);
    if ($post->post_type !== 'jobpost') {
        return;
    }

    $categories = wp_get_post_terms($post->ID, 'jobpost_category');
    return apply_filters('sjb_the_job_category', $categories, $post);
}

/**
 * sjb_the_job_type function.
 *
 * @access public
 * @return void
 */
function sjb_the_job_type($post = NULL) {
    if ($job_types = sjb_get_the_job_type($post)) {
        $count = sizeof($job_types);
        foreach ($job_types as $job_type) {
            echo $job_type->name;
            if ($count > 1) {
                echo ',&nbsp ';
            }
            $count--;
        }
    }
}

/**
 * sjb_get_the_job_type function.
 *
 * @access public
 * @param mixed $post (default: null)
 * @return void
 */
function sjb_get_the_job_type($post = NULL) {
    $post = get_post($post);
    if ($post->post_type !== 'jobpost') {
        return;
    }

    $types = wp_get_post_terms($post->ID, 'jobpost_job_type');
//    $type = ( $types ) ? current($types) : FALSE;

    return apply_filters('sjb_the_job_type', $types, $post);
}

/**
 * sjb_the_job_location function.
 *
 * @access public
 * @return void
 */
function sjb_the_job_location($post = NULL) {
    $post = get_post($post);
    if ($job_locations = sjb_get_the_job_location($post)) {
        $count = sizeof($job_locations);
        foreach ($job_locations as $location) {
            echo $location->name;
            if ($count > 1) {
                echo ',&nbsp ';
            }
            $count--;
        }
    }
}

/**
 * sjb_get_the_job_location function.
 *
 * @access public
 * @param mixed $post (default: NULL)
 * @return void
 */
function sjb_get_the_job_location($post = NULL) {
    $post = get_post($post);

    if ($post->post_type !== 'jobpost') {
        return;
    }

    $locations = wp_get_post_terms($post->ID, 'jobpost_location');
//    $location = ( $locations ) ? current( $locations ) : FALSE;

    return apply_filters('sjb_the_job_location', $locations, $post);
}

/**
 * Display or retrieve the current company name with optional content.
 *
 * @access public
 * @param mixed $id (default: null)
 * @return void
 */
function sjb_the_company_name($before = '', $after = '', $echo = true, $post = null) {
    $company_name = sjb_get_the_company_name($post);

    if (strlen($company_name) == 0)
        return;

    $company_name = esc_attr(strip_tags($company_name));
    $company_name = $before . $company_name . $after;

    if ($echo)
        echo $company_name;
    else
        return $company_name;
}

/**
 * sjb_get_the_company_name function.
 *
 * @access public
 * @param int $post (default: null)
 * @return string
 */
function sjb_get_the_company_name($post = NULL) {
    $post = get_post($post);
    if ($post->post_type !== 'jobpost') {
        return '';
    }

    return apply_filters('sjb_the_company_name', $post->simple_job_board_company_name, $post);
}

/**
 * Display or retrieve the job posting time.
 *
 * @access public
 * @param mixed $id (default: null)
 * @return void
 */
function sjb_the_job_posting_time($post = null) {
    $job_posting_time = sjb_get_the_job_posting_time($post);

    if (strlen($job_posting_time) == 0)
        return;

    printf(__('Posted %s ago', 'simple-job-board'), $job_posting_time);
}

/**
 * sjb_get_the_job_posting_time function.
 *
 * @access public
 * @param int $post (default: null)
 * @return string
 */
function sjb_get_the_job_posting_time($post = NULL) {
    $post = get_post($post);
    if ($post->post_type !== 'jobpost') {
        return '';
    }

    return apply_filters('sjb_the_job_posting_time', human_time_diff(get_post_time('U'), current_time('timestamp')), $post);
}

/**
 * sjb_get_the_company_website function.
 *
 * @access public
 * @param int $post (default: null)
 * @return void
 */
function sjb_get_the_company_website($post = NULL) {
    $post = get_post($post);

    if ($post->post_type !== 'jobpost')
        return;

    $website = $post->simple_job_board_company_website;

    if ($website && !strstr($website, 'http:') && !strstr($website, 'https:')) {
        $website = 'http://' . $website;
    }

    return apply_filters('sjb_the_company_website', $website, $post);
}

/**
 * Display or retrieve the current company tagline with optional content.
 *
 * @access public
 * @param mixed $id (default: null)
 * @return void
 */
function sjb_the_company_tagline($before = '', $after = '', $echo = TRUE, $post = NULL) {
    $company_tagline = sjb_get_the_company_tagline($post);

    if (strlen($company_tagline) == 0)
        return;

    $company_tagline = esc_attr(strip_tags($company_tagline));
    $company_tagline = $before . $company_tagline . $after;

    if ($echo)
        echo $company_tagline;
    else
        return $company_tagline;
}

/**
 * sjb_get_the_company_tagline function.
 *
 * @access public
 * @param int $post (default: 0)
 * @return void
 */
function sjb_get_the_company_tagline($post = NULL) {
    $post = get_post($post);

    if ($post->post_type !== 'jobpost')
        return;

    return apply_filters('sjb_the_company_tagline', $post->simple_job_board_company_tagline, $post);
}

/**
 * sjb_the_company_logo function.
 *
 * @access public
 * @param string $size (default: 'full')
 * @param mixed $default (default: null)
 * @return void
 */
function sjb_the_company_logo($size = 'full', $default = NULL, $post = NULL) {
    $logo = sjb_get_the_company_logo($post);

    if (!empty($logo) && ( strstr($logo, 'http') || file_exists($logo) )) {
        if ($size !== 'full') {
            $logo = simple_job_board_get_resized_image($logo, $size);
        }
        echo '<img src="' . esc_attr($logo) . '" alt="' . esc_attr(sjb_get_the_company_name($post)) . '" class="sjbp-pt_img-responsive"/>';
    } elseif ($default) {
        echo '<img src="' . esc_attr($default) . '" alt="' . esc_attr(sjb_get_the_company_name($post)) . '" class="sjbp-pt_img-responsive"/>';
    } else {
        echo '<img src="' . esc_attr(apply_filters('simple_job_board_default_company_logo', plugin_dir_url(dirname(__FILE__)) . 'images/company.png')) . '" alt="' . esc_attr(sjb_get_the_company_name($post)) . '" class="sjbp-pt_img-responsive" />';
    }
}

/**
 * sjb_get_the_company_logo function.
 *
 * @access public
 * @param mixed $post (default: null)
 * @return string
 */
function sjb_get_the_company_logo($post = NULL) {
    $post = get_post($post);
    if ($post->post_type !== 'jobpost')
        return;

    return apply_filters('sjb_the_company_logo', $post->simple_job_board_company_logo, $post);
}

/**
 * Resize and get url of the image
 *
 * @param  string $logo
 * @param  string $size
 * @return string
 */
function simple_job_board_get_resized_image($logo, $size) {
    global $_wp_additional_image_sizes;

    if ($size !== 'full' && strstr($logo, WP_CONTENT_URL) && (isset($_wp_additional_image_sizes[$size]) || in_array($size, array('thumbnail', 'medium', 'large'
            )) )) {

        if (in_array($size, array('thumbnail', 'medium', 'large'))) {
            $img_width = get_option($size . '_size_w');
            $img_height = get_option($size . '_size_h');
            $img_crop = get_option($size . '_size_crop');
        } else {
            $img_width = $_wp_additional_image_sizes[$size]['width'];
            $img_height = $_wp_additional_image_sizes[$size]['height'];
            $img_crop = $_wp_additional_image_sizes[$size]['crop'];
        }

        $upload_dir = wp_upload_dir();
        $logo_path = str_replace(array($upload_dir['baseurl'], $upload_dir['url'], WP_CONTENT_URL), array($upload_dir['basedir'], $upload_dir['path'], WP_CONTENT_DIR), $logo);
        $path_parts = pathinfo($logo_path);
        $resized_logo_path = str_replace('.' . $path_parts['extension'], '-' . $size . '.' . $path_parts['extension'], $logo_path);

        if (strstr($resized_logo_path, 'http:') || strstr($resized_logo_path, 'https:')) {
            return $logo;
        }

        if (!file_exists($resized_logo_path)) {
            ob_start();
            $image = wp_get_image_editor($logo_path);
            if (!is_wp_error($image)) {
                $resize = $image->resize($img_width, $img_height, $img_crop);
                if (!is_wp_error($resize)) {
                    $save = $image->save($resized_logo_path);
                    if (!is_wp_error($save)) {
                        $logo = dirname($logo) . '/' . basename($resized_logo_path);
                    }
                }
            }
            ob_get_clean();
        } else {
            $logo = dirname($logo) . '/' . basename($resized_logo_path);
        }
    }

    return $logo;
}

/**
 * Custom Excerpt Function.
 *
 * @since   1.0.0
 * @access  public
 * @param   string  $charlength     Character length.
 * @param   string  $readmore       Read more Enable.
 * @param   string  $readmore_text  Read more Text.
 * 
 * @return  string  $excerpt        Excerpt of Event description
 */
function sjb_get_the_excerpt($charlength = '255', $readmore = '', $readmore_text = '') {
    $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
    if (strlen($excerpt) > $charlength) {

        if ($charlength > 0) {
            $excerpt = substr($excerpt, 0, $charlength);
        } else {
            $excerpt = $excerpt;
        }

        if ('true' === $readmore) {
            $more = '... <a href="' . get_permalink() . '" class="cs-read-more colr"><i class="fa fa-caret-right"></i>' . $readmore_text . '</a>';
        } else {
            $more = '[...]';
        }
        return $excerpt . $more;
    } else {
        return $excerpt;
    }
}

/**
 * Search SQL filter for matching against post title only.
 *
 * @since   2.1.4
 *
 * @param   string      $search
 * @param   WP_Query    $wp_query
 */
function sjb_keywords_search_by_title($search, $wp_query) {
    if (!empty($search) && !empty($wp_query->query_vars['search_terms'])) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = !empty($q['exact']) ? '' : '%';

        $search = array();

        foreach ((array) $q['search_terms'] as $term)
            $search[] = $wpdb->prepare("$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like($term) . $n);

        if (!is_user_logged_in())
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode(' AND ', $search);
    }

    return $search;
}

/* Hook-> Keywords Search By Title */
add_filter('posts_search', 'sjb_keywords_search_by_title', 10, 2);

/**
 * Assign Default Radio button Check
 */
function job_board_is_checked($i) {
    $checked = ( $i == 0 ) ? "checked" :
            NULL;
    return $checked;
}

/**
 * Displays job meta data on the single job page
 */
function sjb_job_listing_meta_display() {
    get_simple_job_board_template('content-single-job-listing-meta.php', array
            ());
}

add_action('sjb_single_job_listing_start', 'sjb_job_listing_meta_display', 20);

/**
 * Displays job features data on the single job page
 */
function sjb_job_listing_features() {
    get_simple_job_board_template('job-features.php', array());
}

add_action('sjb_single_job_listing_end', 'sjb_job_listing_features', 20);

/**
 * Displays job application form on the single job page
 */
function sjb_job_listing_application_form() {
    get_simple_job_board_template('job-application.php', array());
}

add_action('sjb_single_job_listing_end', 'sjb_job_listing_application_form', 30);

/**
 * Output Wrapper start div's
 * @since 2.2.0
 */
function sjb_job_listing_wrapper_start() {
    get_simple_job_board_template('wrapper-start.php');
}

add_action('sjb_before_main_content', 'sjb_job_listing_wrapper_start', 10);

/**
 * Output Wrapper end div's
 * * @since 2.2.0 
 */
function sjb_job_listing_wrapper_end() {
    get_simple_job_board_template('wrapper-end.php');
}

add_action('sjb_after_main_content', 'sjb_job_listing_wrapper_end', 10);

/**
 * Return Job Feaures Count
 * * @since 2.2.0
 */
function sjb_job_features_count() {
    $keys = get_post_custom_keys(get_the_ID());
    $count = 0;
    if ($keys != NULL):
        foreach ($keys as $key):
            if (substr($key, 0, 11) == 'jobfeature_') {
                $count++;
            }
        endforeach;
    endif;
    return $count;
}