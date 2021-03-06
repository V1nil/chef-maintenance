<?php

function arve_action_admin_init_setup_messages() {

	if( defined( 'ARVE_PRO_VERSION' ) && version_compare( ARVE_PRO_VERSION_REQUIRED, ARVE_PRO_VERSION, '>' ) ) {

		$msg = sprintf(
			__( 'Your ARVE Pro Addon is outdated, you need version %s or later. If you have setup your license <a href="%s">here</a> semi auto updates (Admin panel notice and auto install on confirmation) should work again. If not please <a href="%s">report it</a> and manually update as <a href="%s">described here.</a> I am sorry for the many manual updates with .zip file you had to do in the past. It came to my attention to late that this was actually not working, partly because customers bravely just did the manual update without saying a word. For beta versions the manual update is still needed but until this is supported by EDD (its in the works)', ARVE_SLUG ),
			ARVE_PRO_VERSION_REQUIRED,
			get_admin_url() . 'admin.php?page=nextgenthemes-licenses',
			'https://nextgenthemes.com/support/',
			'https://nextgenthemes.com/plugins/advanced-responsive-video-embedder-pro/documentation/installing-and-license-management/'
		);
		new ARVE_Admin_Notice_Factory( 'arve-pro-outdated', "<p>$msg</p>", false );
	}

	$pro_ad_message = arve_get_pro_ad();

	if( $pro_ad_message ) {
		new ARVE_Admin_Notice_Factory( 'arve_dismiss_pro_notice', $pro_ad_message, true );
	}
}

function arve_get_pro_ad() {

	$inst = (int) get_option( 'arve_install_date' );

	if ( ! current_user_can( 'update_plugins' ) || ! apply_filters( 'arve_pro_ad', true ) || current_time( 'timestamp' ) < strtotime( '+1 week', $inst ) ) {
		return false;
	}

	$pro_message = __( '<p>This is Nico(las Jonas) the Author of the Advanced Responsive Video Embedder plugin. When you <strong><a href="https://nextgenthemes.com/plugins/advanced-responsive-video-embedder-pro/">buy the Pro Addon</a></strong> for this plugin you will get this:</p>', ARVE_SLUG );

	$pro_message .= file_get_contents( plugin_dir_path( dirname( __FILE__ ) ) . 'readme/description-features-pro.html' );
	$pro_message  = str_replace( '<ul ', '<ul style="list-style: square; padding-left: 20px;" ', $pro_message );

	return $pro_message;
}

function arve_echo_pro_ad() {
	echo arve_get_pro_ad();
}

function arve_add_dashboard_widget() {

	$pro_ad_message = arve_get_pro_ad();

	if( ! $pro_ad_message ) {
		return false;
	}

	wp_add_dashboard_widget(
		'arve_dashboard_widget',              // Widget slug.
		'Advanced Responsive Video Embedder', // Title.
		'arve_echo_pro_ad'                    // Display function.
	);

	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes, $pagenow;

	if( 'index.php' == $pagenow ) {

		// Get the regular dashboard widgets array
		// (which has our new widget already but at the end)
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

		// Backup and delete our new dashboard widget from the end of the array
		$arve_widget_backup = array( 'arve_dashboard_widget' => $normal_dashboard['arve_dashboard_widget'] );
		unset( $normal_dashboard['arve_dashboard_widget'] );

		// Merge the two arrays together so our widget is at the beginning
		$sorted_dashboard = array_merge( $arve_widget_backup, $normal_dashboard );

		// Save the sorted array back into the original metaboxes
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
}

/**
 * Register the administration menu for this plugin into the WordPress Dashboard menu.
 *
 * @since    1.0.0
 */
function arve_add_plugin_admin_menu() {

	add_submenu_page(
		'nextgenthemes',                        # parent_slug
		__( 'Advanced Responsive Video Embedder Settings', ARVE_SLUG ), # Page Title
		__( 'A.R. Video Embedder', ARVE_SLUG ), # Menu Tile
		'manage_options',                       # capability
		ARVE_SLUG,                              # menu-slug
		function() {
			require_once plugin_dir_path( __FILE__ ) . 'html-settings-page.php';
		}
	);
}

/**
 * Add settings action link to the plugins page.
 *
 * @since    1.0.0
 */
function arve_add_action_links( $links ) {

	if( ! is_plugin_active( 'arve-pro/arve-pro.php' ) ) {

		$extra_links['buy_pro_addon'] = sprintf(
			'<a href="%s"><strong style="display: inline;">%s</strong></a>',
			'http://nextgenthemes.com/downloads/advanced-responsive-video-embedder',
			__( 'Buy Pro Addon', ARVE_SLUG )
		);
	}

	$extra_links['donate']   = sprintf( '<a href="https://nextgenthemes.com/donate/"><strong style="display: inline;">%s</strong></a>', __( 'Donate', ARVE_SLUG ) );
	$extra_links['settings'] = sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=' . ARVE_SLUG ), __( 'Settings', ARVE_SLUG ) );

	return array_merge( $extra_links, $links );
}

/**
 * Action to add a custom button to the content editor
 *
 * @since 4.3.0
 */
function arve_add_media_button() {

	$options = arve_get_options();

	add_thickbox();

	$p1 = __( 'This button can open a optional ARVE a Shortcode creation dialog. ARVE needs the <a href="%s">Shortcode UI plugin</a> active for this fuctionality.', ARVE_SLUG );
	$p2 = __( 'The "Shortcake (Shortcode UI)" plugin also adds What You See Is What You Get functionality to WordPress visual post editor.', ARVE_SLUG );
	$p3 = __( 'It is perfectly fine to pass on this and <a href="%s">manually</a> write shortcodes or don\'t use shortcodes at all, but it makes things easier.', ARVE_SLUG );

	printf(
		"<div id='arve-thickbox' style='display:none;'><p>$p1</p><p>$p2</p><p>$p3</p></div>",
		esc_url( 'https://wordpress.org/plugins/shortcode-ui/' ),
		esc_url( 'https://nextgenthemes.com/plugins/advanced-responsive-video-embedder-pro/documentation/' )
	);

	printf(
		'<button id="arve-btn" title="%s" data-arve-mode="%s" class="arve-btn button add_media" type="button"><span class="wp-media-buttons-icon arve-icon"></span> %s</button>',
		esc_attr__( 'ARVE Advanced Responsive Video Embedder', ARVE_SLUG ),
		esc_attr( $options['mode'] ),
		esc_html__( 'Embed Video (ARVE)', ARVE_SLUG )
	);
}

function arve_register_shortcode_ui() {

	$attrs = arve_get_settings_definitions();

	if( function_exists( 'arve_pro_get_settings_definitions' ) ) {
		$attrs = array_merge( $attrs, arve_pro_get_settings_definitions() );
	}

	foreach ( $attrs as $key => $values ) {

		if( isset( $values['hide_from_sc'] ) && $values['hide_from_sc'] ) {
			continue;
		}

		$sc_attrs[] = $values;
	}

	shortcode_ui_register_for_shortcode(
		'arve',
		array(
			'label'         => esc_html( 'ARVE' ),
			'listItemImage' => 'dashicons-format-video',
			'attrs'         => $sc_attrs,
		)
	);

	/*

	foreach ($options['shortcodes'] as $sc_id => $sc) {

		shortcode_ui_register_for_shortcode(
			$sc_id,
			array(
				'label' => esc_html( ucfirst("$sc_id ") ) . esc_html__( '(arve)', ARVE_SLUG),
				'listItemImage' => 'dashicons-format-video',
				'attrs' => $sc_attrs,
			)
		);
	}
	*/
}

function arve_input( $args ) {

	$out = sprintf( '<input%s>', arve_attr( $args['input_attr'] ) );

	if ( ! empty( $args['option_values']['attr'] ) && 'thumbnail_fallback' == $args['option_values']['attr'] ) {

		// jQuery
		wp_enqueue_script('jquery');
		// This will enqueue the Media Uploader script
		wp_enqueue_media();

		$out .= sprintf(
			'<a %s>%s</a>',
			arve_attr(
				array(
					'data-arve-image-upload' => '[name="' . $args['input_attr']['name'] . '"]',
					'class' => 'button-secondary',
				)
			),
			__('Upload Image', 'advanced-responsive-video-embedder' )
		);
	}

	if ( ! empty( $args['description'] ) ) {
		$out = $out . '<p class="description">' . $args['description'] . '</p>';
	}

	echo $out;
}

function arve_textarea( $args ) {

	unset( $args['input_attr']['type'] );

	$out = sprintf( '<textarea%s></textarea>', arve_attr( $args['input_attr'] ) );

	if ( ! empty( $args['description'] ) ) {
		$out = $out . '<p class="description">' . $args['description'] . '</p>';
	}

	echo $out;
}

function arve_select( $args ) {

	unset( $args['input_attr']['type'] );

	foreach ( $args['option_values']['options'] as $key => $value ) {

		if (
			2 === count( $args['option_values']['options'] ) &&
			array_key_exists( 'yes', $args['option_values']['options'] ) &&
			array_key_exists( 'no', $args['option_values']['options'] )
		) {
			$current_option = $args['input_attr']['value'] ? 'yes' : 'no';
		} else {
			$current_option = $args['input_attr']['value'];
		}

		$options[] = sprintf(
			'<option value="%s" %s>%s</option>',
			esc_attr( $key ),
			selected( $current_option, $key, false ),
			esc_html( $value )
		);
	}

	$select_attr = $args['input_attr'];
	unset( $select_attr['value'] );

	$out = sprintf( '<select%s>%s</select>', arve_attr( $select_attr ), implode( '', $options ) );

	if ( ! empty( $args['description'] ) ) {
		$out = $out . '<p class="description">' . $args['description'] . '</p>';
	}

	echo $out;
}

/**
 *
 *
 * @since    2.6.0
 */
function arve_register_settings() {

	$options = arve_get_options();

	// Main
	$main_title = __( 'Main Options', ARVE_SLUG );

	add_settings_section(
		'main_section',
		sprintf( '<span class="arve-settings-section" id="arve-settings-section-main" title="%s"></span>%s', esc_attr( $main_title ), esc_html( $main_title ) ),
		null,
		ARVE_SLUG
	);

	foreach( arve_get_settings_definitions() as $key => $value ) {

		if ( ! empty( $value['hide_from_settings'] ) ) {
			continue;
		};

		if ( empty( $value['meta'] ) ) {
			$value['meta'] = array();
		};

		if ( isset( $value['options'][''] ) ) {
			unset( $value['options'][''] );
		}

		if( in_array( $value['type'], array( 'text', 'number', 'url' ) ) ) {
			$callback_function = 'arve_input';
		} else {
			$callback_function = 'arve_' . $value['type'];
		}

		add_settings_field(
			"arve_options_main[{$value['attr']}]", // ID
			$value['label'],                       // title
			$callback_function,                    // callback
			ARVE_SLUG,                             // page
			'main_section',                    // section
			array(                             // args
				'label_for'   => ( 'radio' === $value['type'] ) ? null : "arve_options_main[{$value['attr']}]",
				'input_attr'  => $value['meta'] + array(
					'type'        => $value['type'],
					'value'       => $options[ $value['attr'] ],
					'id'          => "arve_options_main[{$value['attr']}]",
					'name'        => "arve_options_main[{$value['attr']}]",
				),
				'description'   => ! empty( $value['description'] ) ? $value['description'] : null,
				'option_values' => $value,
			)
		);
	}

	add_settings_field(
		'arve_options_main[reset]',
		null,
		"arve_submit_reset",
		ARVE_SLUG,
		'main_section',
		array(
			'reset_name' => 'arve_options_main[reset]',
		)
	);

	// Params
	$params_title = __( 'URL Parameters', ARVE_SLUG );
	add_settings_section(
		'params_section',
		sprintf( '<span class="arve-settings-section" id="arve-settings-section-params" title="%s"></span>%s', esc_attr( $params_title ), esc_html( $params_title ) ),
		'arve_params_section_description',
		ARVE_SLUG
	);

	// Options
	foreach ( $options['params'] as $provider => $params ) {

		add_settings_field(
			"arve_options_params[$provider]",
			ucfirst ( $provider ),
			'arve_input',
			ARVE_SLUG,
			'params_section',
			array(
				'label_for'   => "arve_options_params[$provider]",
				'input_attr'  => array(
					'type'        => 'text',
					'value'       => $params,
					'id'          => "arve_options_params[$provider]",
					'name'        => "arve_options_params[$provider]",
					'class'       => 'large-text'
				),
			)
		);
	}

	add_settings_field(
		'arve_options_params[reset]',
		null,
		'arve_submit_reset',
		ARVE_SLUG,
		'params_section',
		array(
			'reset_name' => 'arve_options_params[reset]',
		)
	);

	// Shortcode Tags
	$shortcodes_title = __( 'Shortcode Tags', ARVE_SLUG );

	add_settings_section(
		'shortcodes_section',
		sprintf( '<span class="arve-settings-section" id="arve-settings-section-shortcodes" title="%s"></span>%s', esc_attr( $shortcodes_title ), esc_html( $shortcodes_title ) ),
		'arve_shortcodes_section_description',
		ARVE_SLUG
	);

	foreach ( $options['shortcodes'] as $provider => $shortcode ) {

		add_settings_field(
			"arve_options_shortcodes[$provider]",
			ucfirst ( $provider ),
			'arve_input',
			ARVE_SLUG,
			'shortcodes_section',
			array(
				'label_for'   => "arve_options_shortcodes[$provider]",
				'input_attr'  => array(
					'type'        => 'text',
					'value'       => $shortcode,
					'id'          => "arve_options_shortcodes[$provider]",
					'name'        => "arve_options_shortcodes[$provider]",
					'class'       => 'medium-text'
				),
			)
		);
	}

	add_settings_field(
		'arve_options_shortcodes[reset]',
		null,
		'arve_submit_reset',
		ARVE_SLUG,
		'shortcodes_section',
		array(
			'reset_name' => 'arve_options_shortcodes[reset]',
		)
	);

	// register_setting( $option_group, $option_name, $sanitize_callback )
	register_setting( 'arve-settings-group', 'arve_options_main',       'arve_validate_options_main' );
	register_setting( 'arve-settings-group', 'arve_options_params',     'arve_validate_options_params' );
	register_setting( 'arve-settings-group', 'arve_options_shortcodes', 'arve_validate_options_shortcodes' );
}

/**
 *
 *
 * @since    6.0.6
 */
function arve_register_settings_debug() {

	// Debug Information
	$debug_title = __( 'Debug Info', ARVE_SLUG );

	add_settings_section(
		'debug_section',
		sprintf( '<span class="arve-settings-section" id="arve-settings-section-debug" title="%s"></span>%s', esc_attr( $debug_title ), esc_html( $debug_title ) ),
		'arve_debug_section_description',
		ARVE_SLUG
	);
}

function arve_submit_reset( $args ) {

	submit_button( __('Save Changes' ), 'primary','submit', false );
	echo '&nbsp;&nbsp;';
	submit_button( __('Reset This Settings Section', 'advanced-responsive-video-embedder' ), 'secondary', $args['reset_name'], false );
}

function arve_shortcodes_section_description() {
	$desc = __( 'This shortcodes exist for backwards compatiblity only. It is not recommended to use them at all, please use the <code>[arve]</code> shortcode. You can change the old shortcode tags here. You may need this to prevent conflicts with other plugins you want to use.', ARVE_SLUG );
	echo "<p>$desc</p>";
}

function arve_params_section_description() {

	$url  = 'https://nextgenthemes.com/advanced-responsive-video-embedder-pro/documentation';

	$desc = sprintf(
		__( 'Please read <a href="%s" target="_blank">the documentation</a> in how this settings work. Do not remove <code>wmode=transparent</code>, this will make some modes fail to work.',
		ARVE_SLUG ),
		esc_url( $url )
	);

	echo "<p>$desc</p>";

	?>
	<p>
		<?php _e("You may use spaces to seperate them instead of <code>&amp;</code>. They will be transformed to two spaces after save. Resources: ", ARVE_SLUG); ?>
		<a target="_blank" href="https://developers.google.com/youtube/player_parameters">Youtube Parameters</a>,
		<a target="_blank" href="http://www.dailymotion.com/doc/api/player.html#parameters">Dailymotion Parameters</a>,
		<a target="_blank" href="https://developer.vimeo.com/player/embedding">Vimeo Parameters</a>.
		<strong><?php _e("<code>wmode=transparent</code> should not be changed/removed", ARVE_SLUG); ?></strong>
	</p>
	<?php
}

function arve_get_plugin_version_and_status( $folder_and_filename ) {

	$file = WP_PLUGIN_DIR . '/' . $folder_and_filename;

	if( ! is_file( $file ) ) {
		return 'NOT INSTALLED';
	}

	$data = get_plugin_data( $file );
	$out  = $data['Version'];

	if( ! is_plugin_active( $folder_and_filename ) ) {
		$out .= ' INACTIVE';
	}

	return $out;
}


function arve_debug_section_description() {

	global $wp_version;

	$arve_version     = arve_get_plugin_version_and_status( 'advanced-responsive-video-embedder/advanced-responsive-video-embedder.php' );
	$arve_pro_version = arve_get_plugin_version_and_status( 'arve-pro/arve-pro.php' );

	if( ! is_plugin_active( 'arve-pro/arve-pro.php' ) ) {
		$pro_options_dump = '';
	} else {
		$pro_options = get_option( 'arve_options_pro' );
		unset( $pro_options['key'] );
		ob_start();
		var_dump( $pro_options );
		$pro_options_dump = ob_get_clean();
	}

	include_once( plugin_dir_path( __FILE__ ) . 'html-debug-info.php' );
}

/**
 *
 *
 * @since    2.6.0
 */
function arve_validate_options_main( $input ) {

	//* Storing the Options Section as a empty array will cause the plugin to use defaults
	if( isset( $input['reset'] ) ) {
		return array();
	}

	$output = array();

	$output['align']              = sanitize_text_field( $input['align'] );
	$output['mode']               = sanitize_text_field( $input['mode'] );
	$output['last_settings_tab']  = sanitize_text_field( $input['last_settings_tab'] );

	$output['autoplay']          = ( 'yes' == $input['autoplay'] )          ? true : false;
	$output['promote_link']      = ( 'yes' == $input['promote_link'] )      ? true : false;
	$output['wp_video_override'] = ( 'yes' == $input['wp_video_override'] ) ? true : false;

	$output['wp_image_cache_time'] = (int) $input['wp_image_cache_time'];

	if( (int) $input['video_maxwidth'] > 100 ) {
		$output['video_maxwidth'] = (int) $input['video_maxwidth'];
	} else {
		$output['video_maxwidth'] = '';
	}

	if( (int) $input['align_maxwidth'] > 100 ) {
		$output['align_maxwidth'] = (int) $input['align_maxwidth'];
	}

	$options_defaults = arve_get_options_defaults( 'main' );
	//* Store only the options in the database that are different from the defaults.
	return array_diff_assoc( $output, $options_defaults );
}

function arve_validate_options_params( $input ) {

	//* Storing the Options Section as a empty array will cause the plugin to use defaults
	if( isset( $input['reset'] ) ) {
		return array();
	}

	$output = array();

	foreach ( $input as $key => $var ) {
		$output[ $key ] = preg_replace( '!\s+!', '&', trim( $var ) );
		$output[ $key ] = preg_replace( '!\s+!', '&', trim( $var ) );
	}

	$options_defaults = arve_get_options_defaults( 'params' );
	//* Store only the options in the database that are different from the defaults.
	return array_diff_assoc( $output, $options_defaults );
}

function arve_validate_options_shortcodes( $input ) {

	$output = array();

	//* Storing the Options Section as a empty array will cause the plugin to use defaults
	if( isset( $input['reset'] ) ) {
		return array();
	}

	foreach ( $input as $key => $var ) {

		$var = preg_replace( '/[_]+/', '_', $var );	// remove multiple underscores
		$var = preg_replace( '/[^A-Za-z0-9_]/', '', $var );	// strip away everything except a-z,0-9 and underscores

		if ( strlen($var) < 3 ) {
			continue;
		}

		$output[ $key ] = $var;
	}

	$options_defaults = arve_get_options_defaults( 'shortcodes' );
	//* Store only the options in the database that are different from the defaults.
	return array_diff_assoc( $output, $options_defaults );
}


function arve_admin_enqueue_styles() {
	wp_enqueue_style( ARVE_SLUG, plugin_dir_url( __FILE__ ) . 'arve-admin.css', array(), ARVE_VERSION, 'all' );
}

function arve_mce_css( $mce_css ) {

	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$css_file = plugin_dir_url( __DIR__ ) . 'public/arve-public.css';

	$mce_css .= $css_file;

	return $mce_css;
}

/**
 * Register the JavaScript for the dashboard.
 *
 * @since    1.0.0
 */
function arve_admin_enqueue_scripts() {

	wp_enqueue_script( ARVE_SLUG, plugin_dir_url( __FILE__ ) . 'arve-admin.js', array( 'jquery' ), ARVE_VERSION, true );

	if ( is_plugin_active( 'shortcode-ui/shortcode-ui.php' ) ) {
		wp_enqueue_script( ARVE_SLUG . '-sc-ui', plugin_dir_url( __FILE__ ) . 'arve-shortcode-ui.js', array( 'shortcode-ui' ), ARVE_VERSION, true );
	}
}
