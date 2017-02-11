<?php
if( is_admin() ) {

	/* Start of: WordPress Administration */

	include_once( WOO_AI_PATH . 'includes/admin.php' );

	function woo_ai_admin_init() {

		add_action( 'add_meta_boxes', 'woo_ai_meta_boxes' );
		if( function_exists( 'aioseop_get_version' ) )
			add_action( 'woocommerce_process_product_meta', 'woo_ai_process_product_meta', 1, 2 );

	}
	add_action( 'admin_init', 'woo_ai_admin_init' );

	function woo_ai_meta_boxes() {

		$post_type = 'product';
		add_meta_box( 'woocommerce-aioseop', __( 'All in One SEO Pack', 'woo_ai' ), 'woo_ai_aioseop_box', $post_type, 'normal', 'default' );

	}

	function woo_ai_aioseop_box() {

		global $post;

		$aioseop_enabled = true;
		if( !function_exists( 'aioseop_get_version' ) ) {
			$aioseop_enabled = false;
			$link = 'http://wordpress.org/extend/plugins/all-in-one-seo-pack/';
			$message = sprintf( __( 'To enter All in One SEO Pack details you must install and activate the <a href="%s" target="_blank">All in One SEO Pack</a> (via WordPres Extend) Plugin.', 'woo_ai' ), $link );
			$output = '<div class="error-message"><p>' . $message . '</p></div>';
			echo $output;
		}

		wp_nonce_field( 'woocommerce_save_data', 'woocommerce_meta_nonce' );

		$keywords = get_post_meta( $post->ID, '_aioseop_keywords', true );
		$description = get_post_meta( $post->ID, '_aioseop_description', true );
		$title = get_post_meta( $post->ID, '_aioseop_title', true );
		$title_atr = get_post_meta( $post->ID, '_aioseop_titleatr', true );
		$menu_label = get_post_meta( $post->ID, '_aioseop_menulabel', true );
		$disable = get_post_meta( $post->ID, '_aioseop_disable', true );

		include_once( WOO_AI_PATH . 'templates/admin/woo-admin_ai_aioseop.php' );

	}

	function woo_ai_process_product_meta( $post_id, $post ) {

		update_post_meta( $post_id, '_aioseop_title', stripslashes( $_POST['aioseop_title'] ) );
		update_post_meta( $post_id, '_aioseop_description', stripslashes( $_POST['aioseop_description'] ) );
		update_post_meta( $post_id, '_aioseop_keywords', stripslashes( $_POST['aioseop_keywords'] ) );
		update_post_meta( $post_id, '_aioseop_titleatr', stripslashes( $_POST['aioseop_titleatr'] ) );
		update_post_meta( $post_id, '_aioseop_menulabel', stripslashes( $_POST['aioseop_menulabel'] ) );
		update_post_meta( $post_id, '_aioseop_disable', ( isset( $_POST['aioseop_disable'] ) ? 'on' : 0 ) );

	}

	/* End of: WordPress Administration */

}
?>