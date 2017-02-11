<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


class OMCPA_Woo_Change_Product_Author {

	 /**
     * Class Constructor
     *
     * Calls the necessary actions for 
     * the plugin to function.
     *
     * @author Ollie Murphy
     * @since 1.0.0
     *
     */
	function __construct() {
		add_action( 'init', array( $this, 'add_author_support_to_products') );	
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_plugin_assets') );

		if ( !$this->is_notice_dismissed() ) {
			add_action( 'all_admin_notices', array( $this, 'display_admin_notice') );
		}
	
		add_action( 'wp_ajax_dismiss_omcpa_notice', array( $this, 'dismiss_omcpa_notice') );
		add_action( 'wp_ajax_nopriv_dismiss_omcpa_notice', array( $this, 'dismiss_omcpa_notice') );
	}


	/**
	 * Checks whether or not the WooCommerce plugin is active
	 *
	 * @author Ollie Murphy
	 * @since 1.0.0
	 *
	 * @return boolean
	 *
	 */
	function is_woo_active() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return true;
		}
		return false;
	}

	 /**
	 * Displays notice to WP admin area
	 *
	 * @author Ollie Murphy
	 * @since 1.0.0
	 *
	 */
	function display_admin_notice() {
		if ( !$this->is_woo_active() ) {			
				// add text domain to admin notice
				$html = sprintf( 
		    		'%s <strong>%s</strong> %s', 
		    		__( 'WooCommerce needs to be installed and activated for the', 'woo-change-product-author' ), 
		    		__( 'Change Product Author for WooCommerce plugin', 'woo-change-product-author' ), 
		    		__( 'to work', 'woo-change-product-author' )
		    	); 

		    ?>
		    <div class="error is-dismissible notice omcpa-plugin-notice">
		        <p><?php echo $html; ?></p>
		    </div>
			<?php
		}
	}

	/**
	 * Checks whether or not the admin notice has been dismissed
	 *
	 * @author Ollie Murphy
	 * @since 1.0.0
	 *
	 * @return boolean
	 *
	 */
	function is_notice_dismissed() {
		if( get_option( 'omcpa-plugin-notice-dismissed' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Add author support to product post type
	 *
	 * @author Ollie Murphy
	 * @since 1.0.0
	 *
	 */
	function add_author_support_to_products() {
		if ( post_type_exists( 'product' ) ) {
			add_post_type_support( 'product', 'author' );
		}
	}

	/**
	 * Enqueue JS assets
	 *
	 * @author Ollie Murphy
	 * @since 1.0.0
	 *
	 */
	function enqueue_plugin_assets() {
		wp_enqueue_script( 
			'omcpa-plugin', 
			plugins_url( '../js/omcpa-plugin.js', __FILE__ ), 
			array( 'jquery' ), 
			'1.0', 
			true  
		);
	}

	/**
	 * Add value to WP options table via Ajax in 
	 * order to persist the dismiss notice
	 * across all WP admin pages
	 *
	 * @author Ollie Murphy
	 * @since 1.0.0
	 *
	 */
	function dismiss_omcpa_notice() {
	   update_option( 'omcpa-plugin-notice-dismissed', 1 );
	}

}