<?php
/**
 * @package   Gantry 5 Theme
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2016 RocketTheme, LLC
 * @license   GNU/GPLv2 and later
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('ABSPATH') or die;

// Note: This file must be PHP 5.2 compatible.

// Check min. required version of Gantry 5
$requiredGantryVersion = '5.2.0';

// Bootstrap Gantry framework or fail gracefully.
$gantry_include = get_stylesheet_directory() . '/includes/gantry.php';
if (!file_exists($gantry_include)) {
    $gantry_include = get_template_directory() . '/includes/gantry.php';
}
$gantry = include_once $gantry_include;

if (!$gantry) {
    return;
}

if (!$gantry->isCompatible($requiredGantryVersion)) {
    $current_theme = wp_get_theme();
    $error = sprintf(__('Please upgrade Gantry 5 Framework to v%s (or later) before using %s theme!', 'g5_chefSociety'), strtoupper($requiredGantryVersion), $current_theme->get('Name'));

    if(is_admin()) {
        add_action('admin_notices', function () use ($error) {
            echo '<div class="error"><p>' . $error . '</p></div>';
        });
    } else {
        wp_die($error);
    }
}

/** @var \Gantry\Framework\Theme $theme */
$theme = $gantry['theme'];

// Theme helper files that can contain useful methods or filters
$helpers = array(
    'includes/helper.php', // General helper file
);

foreach ($helpers as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'g5_chefSociety'), $file), E_USER_ERROR);
    }

    require $filepath;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
    return $fields;
}
add_action ( 'wp_footer' , 'menu_decoration_url' );

function menu_decoration_url() {
	
	echo '<script>$(function() {
  var loc = window.location.href; // returns the full URL
  if(/que-se-cuece/.test(loc)) {
    $(".g-menu-item-52").addClass("active");
	$(".g-menu-item-87").addClass("active");
  }
  
  if(/taller/.test(loc)) {
    $(".g-menu-item-53").addClass("active");
	$(".g-menu-item-85").addClass("active");
  }
  
  if(/recipe/.test(loc)) {
    $(".g-menu-item-54").addClass("active");
	$(".g-menu-item-86").addClass("active");
  }
  
  if(/promocion/.test(loc)) {
    $(".g-menu-item-55").addClass("active");
	$(".g-menu-item-88").addClass("active");
  }
});</script>';
   
}

function skyverge_empty_cart_notice() {
    
	    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    $count = WC()->cart->cart_contents_count;
     if($count != 0) {
	echo '<style>
	.carrito a .fa-lg {
		color:#be1622 !important;
	}
  </style>';
          } 
    } 
}
// Add to shop archives & product pages
add_action( 'wp_footer', 'skyverge_empty_cart_notice' );
/*function redirect_to_checkout() {
    return WC()->cart->get_checkout_url();
}*/
function mibbp_breadcrumb( $args = array() ) {
	echo bbp_get_breadcrumb2( $args );
}

function bbp_get_breadcrumb2( $args = array() ) {

		// Turn off breadcrumbs
		if ( apply_filters( 'bbp_no_breadcrumb', is_front_page() ) )
			return;

		// Define variables
		$front_id         = $root_id                                 = 0;
		$ancestors        = $crumbs           = $tag_data            = array();
		$pre_root_text    = $pre_front_text   = $pre_current_text    = '';
		$pre_include_root = $pre_include_home = $pre_include_current = true;

		/** Home Text *********************************************************/

		// No custom home text
		if ( empty( $args['home_text'] ) ) {

			$front_id = get_option( 'page_on_front' );

			// Set home text to page title
			if ( !empty( $front_id ) ) {
				$pre_front_text = get_the_title( $front_id );

			// Default to 'Home'
			} else {
				$pre_front_text = __( 'Chef Society', 'bbpress' );
			}
		}

		/** Root Text *********************************************************/

		// No custom root text
		if ( empty( $args['root_text'] ) ) {
			$page = bbp_get_page_by_path( bbp_get_root_slug() );
			if ( !empty( $page ) ) {
				$root_id = $page->ID;
			}
			$pre_root_text = bbp_get_forum_archive_title();
		}

		/** Includes **********************************************************/

		// Root slug is also the front page
		if ( !empty( $front_id ) && ( $front_id === $root_id ) ) {
			$pre_include_root = false;
		}

		// Don't show root if viewing forum archive
		if ( bbp_is_forum_archive() ) {
			$pre_include_root = false;
		}

		// Don't show root if viewing page in place of forum archive
		if ( !empty( $root_id ) && ( ( is_single() || is_page() ) && ( $root_id === get_the_ID() ) ) ) {
			$pre_include_root = false;
		}

		/** Current Text ******************************************************/

		// Search page
		if ( bbp_is_search() ) {
			$pre_current_text = bbp_get_search_title();

		// Forum archive
		} elseif ( bbp_is_forum_archive() ) {
			$pre_current_text = bbp_get_forum_archive_title();

		// Topic archive
		} elseif ( bbp_is_topic_archive() ) {
			$pre_current_text = bbp_get_topic_archive_title();

		// View
		} elseif ( bbp_is_single_view() ) {
			$pre_current_text = bbp_get_view_title();

		// Single Forum
		} elseif ( bbp_is_single_forum() ) {
			$pre_current_text = bbp_get_forum_title();

		// Single Topic
		} elseif ( bbp_is_single_topic() ) {
			$pre_current_text = bbp_get_topic_title();

		// Single Topic
		} elseif ( bbp_is_single_reply() ) {
			$pre_current_text = bbp_get_reply_title();

		// Topic Tag (or theme compat topic tag)
		} elseif ( bbp_is_topic_tag() || ( get_query_var( 'bbp_topic_tag' ) && !bbp_is_topic_tag_edit() ) ) {

			// Always include the tag name
			$tag_data[] = bbp_get_topic_tag_name();

			// If capable, include a link to edit the tag
			if ( current_user_can( 'manage_topic_tags' ) ) {
				$tag_data[] = '<a href="' . esc_url( bbp_get_topic_tag_edit_link() ) . '" class="bbp-edit-topic-tag-link">' . esc_html__( '(Edit)', 'bbpress' ) . '</a>';
			}

			// Implode the results of the tag data
			$pre_current_text = sprintf( __( 'Topic Tag: %s', 'bbpress' ), implode( ' ', $tag_data ) );

		// Edit Topic Tag
		} elseif ( bbp_is_topic_tag_edit() ) {
			$pre_current_text = __( 'Edit', 'bbpress' );

		// Single
		} else {
			$pre_current_text = get_the_title();
		}

		/** Parse Args ********************************************************/

		// Parse args
		$r = bbp_parse_args( $args, array(

			// HTML
			'before'          => '<div class="breadcrumb">',
			'after'           => '</div>',

			// Separator
			'sep'             => is_rtl() ? __( '&lsaquo;', 'bbpress' ) : __( ' » ', 'bbpress' ),
			'pad_sep'         => 1,
			'sep_before'      => '',
			'sep_after'       => '',

			// Crumbs
			'crumb_before'    => '',
			'crumb_after'     => '',

			// Home
			'include_home'    => $pre_include_home,
			'home_text'       => $pre_front_text,

			// Forum root
			'include_root'    => $pre_include_root,
			'root_text'       => $pre_root_text,

			// Current
			'include_current' => $pre_include_current,
			'current_text'    => $pre_current_text,
			'current_before'  => '<span class="bbp-breadcrumb-current">',
			'current_after'   => '</span>',
		), 'get_breadcrumb' );

		/** Ancestors *********************************************************/

		// Get post ancestors
		if ( is_singular() || bbp_is_forum_edit() || bbp_is_topic_edit() || bbp_is_reply_edit() ) {
			$ancestors = array_reverse( (array) get_post_ancestors( get_the_ID() ) );
		}

		// Do we want to include a link to home?
		if ( !empty( $r['include_home'] ) || empty( $r['home_text'] ) ) {
			$crumbs[] = '<a href="' . trailingslashit( home_url() ) . '" class="bbp-breadcrumb-home">' . $r['home_text'] . '</a>';
		}

		// Do we want to include a link to the forum root?
		if ( !empty( $r['include_root'] ) || empty( $r['root_text'] ) ) {

			// Page exists at root slug path, so use its permalink
			$page = bbp_get_page_by_path( bbp_get_root_slug() );
			if ( !empty( $page ) ) {
				$root_url = get_permalink( $page->ID );

			// Use the root slug
			} else {
				$root_url = get_post_type_archive_link( bbp_get_forum_post_type() );
			}

			// Add the breadcrumb
			$crumbs[] = '<a href="' . esc_url( $root_url ) . '" class="bbp-breadcrumb-root">' . $r['root_text'] . '</a>';
		}

		// Ancestors exist
		if ( !empty( $ancestors ) ) {

			// Loop through parents
			foreach ( (array) $ancestors as $parent_id ) {

				// Parents
				$parent = get_post( $parent_id );

				// Skip parent if empty or error
				if ( empty( $parent ) || is_wp_error( $parent ) )
					continue;

				// Switch through post_type to ensure correct filters are applied
				switch ( $parent->post_type ) {

					// Forum
					case bbp_get_forum_post_type() :
						$crumbs[] = '<a href="' . esc_url( bbp_get_forum_permalink( $parent->ID ) ) . '" class="bbp-breadcrumb-forum">' . bbp_get_forum_title( $parent->ID ) . '</a>';
						break;

					// Topic
					case bbp_get_topic_post_type() :
						$crumbs[] = '<a href="' . esc_url( bbp_get_topic_permalink( $parent->ID ) ) . '" class="bbp-breadcrumb-topic">' . bbp_get_topic_title( $parent->ID ) . '</a>';
						break;

					// Reply (Note: not in most themes)
					case bbp_get_reply_post_type() :
						$crumbs[] = '<a href="' . esc_url( bbp_get_reply_permalink( $parent->ID ) ) . '" class="bbp-breadcrumb-reply">' . bbp_get_reply_title( $parent->ID ) . '</a>';
						break;

					// WordPress Post/Page/Other
					default :
						$crumbs[] = '<a href="' . esc_url( get_permalink( $parent->ID ) ) . '" class="bbp-breadcrumb-item">' . get_the_title( $parent->ID ) . '</a>';
						break;
				}
			}

		// Edit topic tag
		} elseif ( bbp_is_topic_tag_edit() ) {
			$crumbs[] = '<a href="' . esc_url( get_term_link( bbp_get_topic_tag_id(), bbp_get_topic_tag_tax_id() ) ) . '" class="bbp-breadcrumb-topic-tag">' . sprintf( __( 'Topic Tag: %s', 'bbpress' ), bbp_get_topic_tag_name() ) . '</a>';

		// Search
		} elseif ( bbp_is_search() && bbp_get_search_terms() ) {
			$crumbs[] = '<a href="' . esc_url( bbp_get_search_url() ) . '" class="bbp-breadcrumb-search">' . esc_html__( 'Search', 'bbpress' ) . '</a>';
		}

		/** Current ***********************************************************/

		// Add current page to breadcrumb
		if ( !empty( $r['include_current'] ) || empty( $r['current_text'] ) ) {
			$crumbs[] = $r['current_before'] . $r['current_text'] . $r['current_after'];
		}

		/** Separator *********************************************************/

		// Wrap the separator in before/after before padding and filter
		if ( ! empty( $r['sep'] ) ) {
			$sep = $r['sep_before'] . $r['sep'] . $r['sep_after'];
		}

		// Pad the separator
		if ( !empty( $r['pad_sep'] ) ) {
			if ( function_exists( 'mb_strlen' ) ) {
				$sep = str_pad( $sep, mb_strlen( $sep ) + ( (int) $r['pad_sep'] * 2 ), ' ', STR_PAD_BOTH );
			} else {
				$sep = str_pad( $sep, strlen( $sep ) + ( (int) $r['pad_sep'] * 2 ), ' ', STR_PAD_BOTH );
			}
		}

		/** Finish Up *********************************************************/

		// Filter the separator and breadcrumb
		$sep    = apply_filters( 'bbp_breadcrumb_separator', $sep    );
		$crumbs = apply_filters( 'bbp_breadcrumbs',          $crumbs );

		// Build the trail
		$trail  = !empty( $crumbs ) ? ( $r['before'] . $r['crumb_before'] . implode( $sep . $r['crumb_after'] . $r['crumb_before'] , $crumbs ) . $r['crumb_after'] . $r['after'] ) : '';

		return apply_filters( 'bbp_get_breadcrumb', $trail, $crumbs, $r );
	}