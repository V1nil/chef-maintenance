<?php

function arve_get_options_defaults( $section ) {

	$options['main'] = array(
		'align_maxwidth'      => 400,
		'align'               => 'none',
		'autoplay'            => false,
		'mode'                => 'normal',
		'promote_link'        => false,
		'sandbox'             => false,
		'video_maxwidth'      => '',
		'wp_image_cache_time' => 18000,
		'last_settings_tab'   => '',
		'wp_video_override'   => false,
	);

	$properties = arve_get_host_properties();
	unset( $properties['video'] );

	foreach ( $properties as $provider => $values ) {

		if ( ! empty( $values['embed_url'] ) ) {
			$options['shortcodes'][ $provider ] = $provider;
		}
		if ( isset( $values['default_params'] ) ) {
			$options['params'][ $provider ] = $values['default_params'];
		}
	}

	return $options[ $section ];
}

/**
 * Get options by merging possibly existing options with defaults
 */
function arve_get_options() {

	$options               = wp_parse_args( get_option( 'arve_options_main',       array() ), arve_get_options_defaults( 'main' ) );
	$options['shortcodes'] = wp_parse_args( get_option( 'arve_options_shortcodes', array() ), arve_get_options_defaults( 'shortcodes' ) );
	$options['params']     = wp_parse_args( get_option( 'arve_options_params',     array() ), arve_get_options_defaults( 'params' ) );

	return $options;
}

function arve_get_settings_definitions() {

	$options         = arve_get_options();
	$supported_modes = arve_get_supported_modes();
	$properties      = arve_get_host_properties();

	foreach ( $properties as $provider => $values ) {

		if( ! empty( $values['auto_thumbnail'] ) ) {
			$auto_thumbs[] = $values['name'];
		}
		if( ! empty( $values['auto_title'] ) ) {
			$auto_title[] = $values['name'];
		}
		if( ! empty( $values['requires_src'] ) ) {
			$embed_code_only[] = $values['name'];
		}
	}

	$auto_thumbs      = implode( ', ', $auto_thumbs );
	$auto_title       = implode( ', ', $auto_title );
	$embed_code_only  = implode( ', ', $embed_code_only );

	if ( in_array( $options['mode'], $supported_modes ) ) {
		$current_mode_name = $supported_modes[ $options['mode'] ];
	} else {
		$current_mode_name = $options['mode'];
	}

	return array(
		array(
			'hide_from_settings' => true,
			'attr'  => 'url',
			'label' => esc_html__( 'URL / Embed Code', ARVE_SLUG ),
			'type'  => 'text',
			'meta'  => array(
				'placeholder' => esc_attr__( 'Video URL / iframe Embed Code', ARVE_SLUG ),
			),
			'description' => sprintf(
				__( 'Post the URL of the video here. For %s and any <a href="%s">unlisted</a> video hosts paste their iframe embed codes or its src URL in here (providers embeds need to be responsive).', ARVE_SLUG ),
				$embed_code_only,
				'https://nextgenthemes.com/advanced-responsive-video-embedder-pro/#video-host-support'
			)
		),
		array(
			'attr'    => 'mode',
			'label'   => esc_html__( 'Mode', ARVE_SLUG ),
			'type'    => 'select',
			'options' =>
				array( '' => sprintf( esc_html__( 'Default (current setting: %s)', ARVE_SLUG ), $current_mode_name ) ) +
				arve_get_supported_modes(),
		),
		array(
			'attr'  => 'align',
			'label' => esc_html__('Alignment', ARVE_SLUG ),
			'type'  => 'select',
			'options' => array(
				'' => sprintf( esc_html__( 'Default (current setting: %s)', ARVE_SLUG ), $options['align'] ),
				'none'   => esc_html__( 'None', ARVE_SLUG ),
				'left'   => esc_html__( 'Left', ARVE_SLUG ),
				'right'  => esc_html__( 'Right', ARVE_SLUG ),
				'center' => esc_html__( 'center', ARVE_SLUG ),
			),
		),
		array(
			'attr'  => 'promote_link',
			'label' => esc_html__( 'ARVE Link', ARVE_SLUG ),
			'type'  => 'select',
			'options' => array(
				'' => sprintf(
					__( 'Default (current setting: %s)', ARVE_SLUG ),
					( $options['promote_link'] ) ? esc_html__( 'Yes', ARVE_SLUG ) : esc_html__( 'No', ARVE_SLUG )
				),
				'yes' => esc_html__( 'Yes', ARVE_SLUG ),
				'no'  => esc_html__( 'No', ARVE_SLUG ),
			),
			'description'  => esc_html__( "Shows a small 'ARVE' link below the videos. Be the most awesome person and help promoting this plugin.", ARVE_SLUG ),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'thumbnail',
			'label' => esc_html__( 'Thumbnail', ARVE_SLUG ),
			'type'  => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'shortcode-ui' ),
			'frameTitle'  => esc_html__( 'Select Image', 'shortcode-ui' ),
			'description' => sprintf( esc_html__( 'Preview image for Lazyload modes, always used for SEO. The Pro Addon is able to get them from %s automatically.', ARVE_SLUG ), $auto_thumbs ),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'title',
			'label' => esc_html__('Title', ARVE_SLUG),
			'type'  => 'text',
			'description' => sprintf( esc_html__( 'Used for SEO, is visible on top of thumbnails in Lazyload modes, is used as link text in link-lightbox mode. The Pro Addon is able to get them from %s automatically.', ARVE_SLUG ), $auto_title ),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'description',
			'label' => esc_html__('Description', ARVE_SLUG),
			'type'  => 'text',
			'meta'  => array(
				'placeholder' => __( 'Description for SEO', ARVE_SLUG ),
			)
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'upload_date',
			'label' => esc_html__( 'Upload Date', ARVE_SLUG ),
			'type'  => 'text',
			'meta'  => array(
				'placeholder' => __( 'Upload Date for SEO, ISO 8601 format', ARVE_SLUG ),
			)
		),
		array(
			'attr'  => 'autoplay',
			'label' => esc_html__('Autoplay', ARVE_SLUG ),
			'type'  => 'select',
			'options' => array(
				'' => sprintf(
					__( 'Default (current setting: %s)', ARVE_SLUG ),
					( $options['autoplay'] ) ? esc_html__( 'Yes', ARVE_SLUG ) : esc_html__( 'No', ARVE_SLUG )
				),
				'yes' => esc_html__( 'Yes', ARVE_SLUG ),
				'no'  => esc_html__( 'No', ARVE_SLUG ),
			),
			'description' => esc_html__( 'Autoplay videos in normal mode, has no effect on lazyload modes.', ARVE_SLUG ),
		),
		array(
			'hide_from_sc'   => true,
			'attr'  => 'video_maxwidth',
			'label'       => esc_html__('Maximal Width', ARVE_SLUG),
			'type'        =>  'number',
			'description' => esc_html__( 'Optional, if not set your videos will be the maximum size of the container they are in. If your content area has a big width you might want to set this. Must be 100+ to work.', ARVE_SLUG ),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'maxwidth',
			'label' => esc_html__('Maximal Width', ARVE_SLUG),
			'type'  =>  'number',
			'meta'  => array(
				'placeholder' => esc_attr__( 'in px - leave empty to use settings', ARVE_SLUG),
			),
		),
		array(
			'hide_from_sc'   => true,
			'attr'  => 'align_maxwidth',
			'label' => esc_html__('Align Maximal Width', ARVE_SLUG),
			'type'  => 'number',
			'description' => esc_attr__( 'In px, Needed! Must be 100+ to work.', ARVE_SLUG ),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'aspect_ratio',
			'label' => __('Aspect Ratio', ARVE_SLUG),
			'type'  => 'text',
			'meta'  => array(
				'placeholder' => __( 'Custom aspect ratio like 4:3, 21:9 ... Leave empty for default.', ARVE_SLUG),
			),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'parameters',
			'label' => esc_html__('Parameters', ARVE_SLUG),
			'type'  => 'text',
			'meta'  => array(
				'placeholder' => __( 'provider specific parameters', ARVE_SLUG ),
			),
			'description' => sprintf( __( 'Note there are also general settings for this. This values get merged with the settings values. Example for YouTube <code>fs=0&start=30</code>. For reference: <a target="_blank" href="https://developers.google.com/youtube/player_parameters">Youtube Parameters</a>, <a target="_blank" href="http://www.dailymotion.com/doc/api/player.html#parameters">Dailymotion Parameters</a>, <a target="_blank" href="https://developer.vimeo.com/player/embedding">Vimeo Parameters</a>.', ARVE_SLUG ), 'TODO settings page link' ),
		),
		array(
			'hide_from_sc'   => true,
			'attr'  => 'wp_image_cache_time',
			'label' => esc_html__('Image Cache Time', ARVE_SLUG),
			'type'  => 'number',
			'description' => __( '(seconds) This plugin uses WordPress transients to cache video thumbnail URLS. This setting defines how long image URLs from the media Gallery are being stored before running WPs fuctions again to request them. For example: hour - 3600, day - 86400, week - 604800.', ARVE_SLUG),
		),
		array(
			'hide_from_sc'   => true,
			'attr'  => 'wp_video_override',
			'label' => esc_html__('Take over [video]', ARVE_SLUG ),
			'type'  => 'select',
			'options' => array(
				'yes' => esc_html__( 'Yes', ARVE_SLUG ),
				'no'  => esc_html__( 'No', ARVE_SLUG ),
			),
			'description' => esc_html__( "Take over WP's default [video] shortcode for HTML5 files.", ARVE_SLUG ),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'mp4',
			'label' => esc_html__('mp4', ARVE_SLUG),
			'type'  => 'url',
			'meta'  => array(
				'placeholder' => __( '.mp4 file url for HTML5 video', ARVE_SLUG ),
			),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'webm',
			'label' => esc_html__('webm', ARVE_SLUG),
			'type'  => 'url',
			'meta'  => array(
				'placeholder' => __( '.webm file url for HTML5 video', ARVE_SLUG ),
			),
		),
		array(
			'hide_from_settings' => true,
			'attr'  => 'ogv',
			'label' => esc_html__('ogv', ARVE_SLUG),
			'type'  => 'url',
			'meta'  => array(
				'placeholder' => __( '.ogv file for HTML5 video', ARVE_SLUG ),
			),
		),
	);
}

	/**
	 *
	 *
	 * @since     5.4.0
	 */
function arve_get_mode_options( $selected ) {

	$modes = arve_get_supported_modes();

	$out = '';

	foreach( $modes as $mode => $desc ) {

		$out .= sprintf(
			'<option value="%s" %s>%s</option>',
			esc_attr( $mode ),
			selected( $selected, $mode, false ),
			$desc
		);
	}

	return $out;
}

function arve_get_supported_modes() {
	return apply_filters( 'arve_modes', array( 'normal' => __( 'Normal', ARVE_SLUG ) ) );
}

function arve_get_iframe_providers() {

}

function arve_get_host_properties() {

	$s = 'https?://(?:www\.)?';

	$properties = array(
		'allmyvideos' => array(
			'name'      => 'allmyvideos.net',
			'regex'     => $s . 'allmyvideos\.net/(?:embed-)?([a-z0-9]+)',
			'embed_url' => 'https://allmyvideos.net/embed-%s.html',
			'tests' => array(
				array( 'url' => 'https://allmyvideos.net/1bno5g9il7ha',            'id' => '1bno5g9il7ha' ),
				array( 'url' => 'https://allmyvideos.net/embed-1bno5g9il7ha.html', 'id' => '1bno5g9il7ha' ),
			)
		),
		'alugha' => array(
			'regex'     => $s . 'alugha\.com/(?:1/)?videos/([a-z0-9_\-]+)',
			'embed_url' => 'https://alugha.com/embed/polymer-live/?v=%s',
			'default_params' => 'nologo=1',
			'auto_thumbnail' => true,
			'tests' => array(
				array( 'url' => 'https://alugha.com/1/videos/youtube-54m1YfEuYU8',                'id' => 'youtube-54m1YfEuYU8' ),
				array( 'url' => 'https://alugha.com/videos/7cab9cd7-f64a-11e5-939b-c39074d29b86', 'id' => '7cab9cd7-f64a-11e5-939b-c39074d29b86' ),
			)
		),
		'archiveorg' => array(
			'name'           => 'Archive.org',
			'regex'          => $s . 'archive\.org/(?:details|embed)/([0-9a-z\-]+)',
			'embed_url'      => 'https://www.archive.org/embed/%s/',
			'default_params' => '',
			'auto_thumbnail' => false,
			'tests' => array(
				array( 'url' => 'https://archive.org/details/arashyekt4_gmail_Cat', 'id' => 'arashyekt4' ),
			)
		),
		#<iframe src="http://www.break.com/embed/2542591?embed=1" width="640" height="360" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0"></iframe><div>- Watch More <a href="http://www.break.com">Funny Videos</a>&nbsp;<font size=1><a href="http://view.break.com/2542591" target="_blank">First Person POV of Tornado Strike</a></font></div>
		'break' => array(
			'regex'          => 'https?://(?:www\.|view\.)break\.com/(?:video/|embed/)?[-a-z0-9]*?([0-9]+)',
			'embed_url'      => 'http://break.com/embed/%s',
			'default_params' => 'embed=1',
			'auto_thumbnail' => false,
			'requires_flash' => true,
			'tests' => array(
				array(
					'url' => 'http://www.break.com/video/first-person-pov-of-tornado-strike-2542591-test',
					'id'  =>                                                                2542591,
				),
				array(
					'url' => 'http://view.break.com/2542591-test',
					'id'  =>                        2542591,
				),
				array(
					'url' => 'http://www.break.com/embed/2542591?embed=1',
					'id'  =>                             2542591,
				),
			)
		),
		'brightcove'   => array(
			'regex'          => 'https?://(?:players|link)\.brightcove\.net/(?<account_id>[0-9]+)[.?/a-z_]+videoId=(?<id>[0-9]+)',
			'embed_url'      => 'https://players.brightcove.net/%s/default_default/index.html?videoId=%s',
			'requires_src'   => true,
			'tests' => array(
				array(
					'url' => 'http://players.brightcove.net/1160438696001/default_default/index.html?videoId=4587535845001',
					'id'  =>                                                                                 4587535845001,
					'account_id' =>                         1160438696001,
				),
			),
		),
		'collegehumor' => array(
			'name'           => 'CollegeHumor',
			'regex'          => $s . 'collegehumor\.com/video/([0-9]+)',
			'embed_url'      => 'http://www.collegehumor.com/e/%s',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			'aspect_ratio'   => '600:369',
			'tests' => array(
				array(
					'url'          => 'http://www.collegehumor.com/video/6854928/troopers-holopad',
					'id'           => 6854928,
					'oembed_title' => 'Troopers Holopad',
				),
			)
		),
		'comedycentral' => array(
			'name'           => 'Comedy Central',
			'regex'          => 'https?://media\.mtvnservices\.com/embed/mgid:arc:video:comedycentral\.com:([-a-z0-9]{36})',
			'embed_url'      => 'http://media.mtvnservices.com/embed/mgid:arc:video:comedycentral.com:%s',
			'requires_src'   => true,
			'auto_thumbnail' => false,
			'requires_flash' => true,
			'tests' => array(
				array(
					'url' => 'http://media.mtvnservices.com/embed/mgid:arc:video:comedycentral.com:c80adf02-3e24-437a-8087-d6b77060571c',
					'id'  =>                                                                      'c80adf02-3e24-437a-8087-d6b77060571c',
				),
				array(
					'url' => 'http://media.mtvnservices.com/embed/mgid:arc:video:comedycentral.com:c3c1da76-96c2-48b4-b38d-8bb16fbf7a58',
					'id'  =>                                                                      'c3c1da76-96c2-48b4-b38d-8bb16fbf7a58',
				),
			)
		),
		'dailymotion' => array(
			'regex'          => $s . '(?:dai\.ly|dailymotion\.com/video)/([a-z0-9]+)',
			'embed_url'      => 'https://www.dailymotion.com/embed/video/%s',
			'default_params' => 'logo=0&hideInfos=1&related=0',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			'tests' => array(
				array(
					'url'          => 'http://www.dailymotion.com/video/x41ia79_mass-effect-andromeda-gameplay-alpha_videogames',
					'id'           =>                                  'x41ia79',
					'oembed_title' => 'Mass Effect Andromeda - Gameplay Alpha',
				),
				array(
					'url'          => 'http://dai.ly/x3cwlqz',
					'id'           =>               'x3cwlqz',
					'oembed_title' => 'Mass Effect Andromeda',
				),
			),
			'query_args'     => array(
				'api' => array(
					'name' => __( 'API', ARVE_SLUG ),
					'type' => 'bool',
				),
			),
			'query_argss' => array(
        'api'                => array( 0, 1 ),
        'autoplay'           => array( 0, 1 ),
        'chromeless'         => array( 0, 1 ),
        'highlight'          => array( 0, 1 ),
        'html'               => array( 0, 1 ),
        'id'                 => 'int',
        'info'               => array( 0, 1 ),
        'logo'               => array( 0, 1 ),
        'network'            => array( 'dsl', 'cellular' ),
        'origin'             => array( 0, 1 ),
        'quality'            => array( 240, 380, 480, 720, 1080, 1440, 2160 ),
        'related'            => array( 0, 1 ),
        'start'              => 'int',
        'startscreen'        => array( 0, 1 ),
        'syndication'        => 'int',
        'webkit-playsinline' => array( 0, 1 ),
        'wmode'              => array( 'direct', 'opaque' ),
			),
		),
		'dailymotionlist' => array(
			'regex'           => $s . 'dailymotion\.com/playlist/([a-z0-9]+)',
			'embed_url'       => 'https://www.dailymotion.com/widget/jukebox?list[]=%2Fplaylist%2F%s%2F1',
			'auto_thumbnail'  => false,
			'requires_flash'  => true,
		),
		'facebook' => array(
			# https://www.facebook.com/TheKillingsOfTonyBlair/videos/vb.551089058285349/562955837098671/?type=2&theater
			#<iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FTheKillingsOfTonyBlair%2Fvideos%2Fvb.551089058285349%2F562955837098671%2F%3Ftype%3D2%26theater&width=500&show_text=false&height=280&appId" width="500" height="280" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
			'regex'             => '(' . $s . 'facebook\.com/[-.a-z0-9]+/videos/[a-z.0-9/]+)',
			'url_encode_id'     => true,
			'embed_url'         => 'https://www.facebook.com/plugins/video.php?href=%s',
			#'embed_url'         => 'https://www.facebook.com/video/embed?video_id=%s',
			'auto_thumbnail'    => true,
			'tests' => array(
				array(
					'url'     => 'https://www.facebook.com/TheKillingsOfTonyBlair/videos/vb.551089058285349/562955837098671/?type=2&theater',
					'id'      => 'https://www.facebook.com/TheKillingsOfTonyBlair/videos/vb.551089058285349/562955837098671/',
					'img'     => '',
				),
			),
		),
		'funnyordie' => array(
			'name'           => 'Funny or Die',
			'regex'          => $s . 'funnyordie\.com/videos/([a-z0-9_]+)',
			'embed_url'      => 'https://www.funnyordie.com/embed/%s',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			'aspect_ratio'   => '640:400',
			'tests' => array(
				array(
					'url'          => 'http://www.funnyordie.com/videos/76585438d8/sarah-silverman-s-we-are-miracles-hbo-special',
					'id'           =>                                  '76585438d8',
					'oembed_title' => "Sarah Silverman's - We Are Miracles HBO Special",
				),
			)
		),
		'gametrailers' => array(
			'requires_src'    => true,
			'auto_thumbnail'  => false,
			'test_ids' => array(
				'797121a1-4685-4ecc-9388-72a88b0ef8da',
			)
		),
		'ign' => array(
			'name'           => 'IGN',
			'regex'          => '(' . $s . 'ign\.com/videos/[0-9]{4}/[0-9]{2}/[0-9]{2}/[0-9a-z\-]+)',
			'embed_url'      => 'http://widgets.ign.com/video/embed/content.html?url=%s',
			'auto_thumbnail' => false,
			'tests' => array(
				array(
				 'url' => 'http://www.ign.com/videos/2012/03/06/mass-effect-3-video-review',
				 'id'  => 'http://www.ign.com/videos/2012/03/06/mass-effect-3-video-review',
			 ),
			)
		),
    #https://cdnapisec.kaltura.com/p/243342/sp/24334200/embedIframeJs/uiconf_id/20540612/partner_id/243342?iframeembed=true&playerId=kaltura_player&entry_id=1_sf5ovm7u&flashvars[streamerType]=auto" width="560" height="395" allowfullscreen webkitallowfullscreen mozAllowFullScreen frameborder="0"></iframe>
		'kickstarter' => array(
			'regex'          => $s . 'kickstarter\.com/projects/([0-9a-z\-]+/[-0-9a-z\-]+)',
			'embed_url'      => 'https://www.kickstarter.com/projects/%s/widget/video.html',
			'auto_thumbnail' => false,
			'tests' => array(
				array(
					'url' => 'https://www.kickstarter.com/projects/obsidian/project-eternity?ref=discovery',
					'id'  =>                                      'obsidian/project-eternity' ),
				array(
					'url' => 'https://www.kickstarter.com/projects/trinandtonic/friendship-postcards?ref=category_featured',
					'id'  =>                                      'trinandtonic/friendship-postcards'
				),
			)
		),
		'liveleak' => array(
			'name'           => 'LiveLeak',
		  'regex'          => $s . 'liveleak\.com/(?:view|ll_embed)\?((f|i)=[0-9a-z\_]+)',
			'embed_url'      => 'http://www.liveleak.com/ll_embed?%s',
			'default_params' => 'wmode=transparent',
			'auto_thumbnail' => false,
			'requires_flash' => true,
			'tests' => array(
				array( 'url' => 'http://www.liveleak.com/view?i=703_1385224413', 'id' => 'i=703_1385224413' ), # Page/item 'i=' URL
				array( 'url' => 'http://www.liveleak.com/view?f=c85bdf5e45b2',   'id' => 'f=c85bdf5e45b2' ),     #File f= URL
			),
			'test_ids' => array(
				'f=c85bdf5e45b2',
				'c85bdf5e45b2'
			),
		),
		'livestream' => array(
			# <iframe width="560" height="340" src="http://cdn.livestream.com/embed/telefuturohd?layout=4&amp;height=340&amp;width=560&amp;autoplay=false" style="border:0;outline:0" frameborder="0" scrolling="no"></iframe>
			'regex'          => $s . 'livestream\.com/accounts/([0-9]+/events/[0-9]+(?:/videos/[0-9]+)?)',
			'embed_url'      => 'https://livestream.com/accounts/%s/player',
			'default_params' => 'utm_source=lsplayer&utm_medium=embed&height=720&width=1280',
			'auto_thumbnail' => false,
			'requires_flash' => true,
		),
		'klatv' => array(
			'regex'          => $s . 'kla(?:gemauer)?.tv/([0-9]+)',
			'embed_url'      => 'https://www.kla.tv/index.php?a=showembed&vidid=%s',
			'name'           => 'kla.tv',
			'url'            => true,
			'auto_thumbnail' => false,
			'tests' => array(
				array( 'url' => 'http://www.klagemauer.tv/9106', 'id' =>  9106 ),
				array( 'url' => 'http://www.kla.tv/9122', 'id' =>  9122 ),
			),
		),
		'metacafe' => array(
			'regex'          => $s . 'metacafe\.com/(?:watch|fplayer)/([0-9]+)',
			'embed_url'      => 'http://www.metacafe.com/embed/%s/',
			'auto_thumbnail' => false,
			'tests' => array(
				array( 'url' => 'http://www.metacafe.com/watch/11433151/magical-handheld-fireballs/', 'id' => 11433151 ),
				array( 'url' => 'http://www.metacafe.com/watch/11322264/everything_wrong_with_robocop_in_7_minutes/', 'id' => 11322264 ),
			),
		),
		'movieweb' => array(
			'regex'          => $s . 'movieweb\.com/v/([a-z0-9]{14})',
			'embed_url'      => 'http://movieweb.com/v/%s/embed',
			'auto_thumbnail' => false,
			'requires_src'  => true,
		),
		'mpora' => array(
			'name'           => 'MPORA',
			'regex'          => $s . 'mpora\.(?:com|de)/videos/([a-z0-9]+)',
			'embed_url'      => 'http://mpora.com/videos/%s/embed',
			'auto_thumbnail' => true,
			'tests' => array(
				array( 'url' => 'http://mpora.com/videos/AAdphry14rkn', 'id' => 'AAdphry14rkn' ),
				array( 'url' => 'http://mpora.de/videos/AAdpxhiv6pqd', 'id' => 'AAdpxhiv6pqd' ),
			)
		),
		'myspace' => array(
			#<iframe width="480" height="270" src="//media.myspace.com/play/video/house-of-lies-season-5-premiere-109903807-112606834" frameborder="0" allowtransparency="true" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe><p><a href="https://media.myspace.com/showtime/video/house-of-lies-season-5-premiere/109903807">House of Lies Season 5 Premiere</a> from <a href="https://media.myspace.com/Showtime">Showtime</a> on <a href="https://media.myspace.com">Myspace</a>.</p>
			'regex'          => $s . 'myspace\.com/.+/([0-9]+)',
			'embed_url'      => 'https://media.myspace.com/play/video/%s',
			'auto_thumbnail' => false,
			'tests' => array(
				array( 'url' => 'https://myspace.com/myspace/video/dark-rooms-the-shadow-that-looms-o-er-my-heart-live-/109471212', 'id' => 109471212 ),
			)
		),
		/*
		'myvideo' => array(
			'name'           => 'MyVideo',
			'regex'          => $s . 'myvideo\.de/(?:watch|embed)/([0-9]+)',
			'embed_url'      => 'http://www.myvideo.de/embedded/public/%s',
			'auto_thumbnail' => false,
			'tests' => array(
				'http://www.myvideo.de/watch/8432624/Angeln_mal_anders',
			)
		),
		*/
		'snotr' => array(
			'regex'          => $s . 'snotr\.com/(?:video|embed)/([0-9]+)',
			'embed_url'      => 'http://www.snotr.com/embed/%s',
			'auto_thumbnail' => false,
			'requires_flash' => true,
			'tests' => array(
				array( 'url' => 'http://www.snotr.com/video/12314/How_big_a_truck_blind_spot_really_is', 'id' => 12314 ),
			)
		),
		'spike' => array(
			# <iframe src="http://media.mtvnservices.com/embed/mgid:arc:video:spike.com:6a219882-c412-46ce-a8c9-32e043396621" width="512" height="288" frameborder="0"></iframe><p style="text-align:left;background-color:#FFFFFF;padding:4px;margin-top:4px;margin-bottom:0px;font-family:Arial, Helvetica, sans-serif;font-size:12px;"><b><a href="http://www.spike.com/shows/ink-master">Ink Master</a></b></p></div></div>
			'regex'          => 'https?://media.mtvnservices.com/embed/mgid:arc:video:spike\.com:([a-z0-9\-]{36})',
			'embed_url'      => 'http://media.mtvnservices.com/embed/mgid:arc:video:spike.com:%s',
			'requires_src'   => true,
			'auto_thumbnail' => false,
			'requires_flash' => true,
			'test_ids' => array(
				'5afddf30-31d8-40fb-81e6-bb5c6f45525f',
			)
		),
		'ted' => array(
			'name'           => 'TED Talks',
			'regex'          => $s . 'ted\.com/talks/([a-z0-9_]+)',
			'embed_url'      => 'https://embed-ssl.ted.com/talks/%s.html',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			'requires_flash' => true,
			'tests' => array(
				array( 'url' => 'https://www.ted.com/talks/margaret_stewart_how_youtube_thinks_about_copyright', 'id' => 'margaret_stewart_how_youtube_thinks_about_copyright' ),
			),
		),
		'twitch' => array(
			'regex'          => $s . 'twitch.tv/(?!directory)(?|[a-z0-9_]+/v/([0-9]+)|([a-z0-9_]+))',
			'embed_url'      => 'https://player.twitch.tv/?channel=%s', # if numeric id https://player.twitch.tv/?video=v%s
			'auto_thumbnail' => true,
			'tests' => array(
				array(
					'url'              => 'https://www.twitch.tv/whiskeyexperts',
					'id'               => 'whiskeyexperts',
					'api_img_contains' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/whiskyexperts',
				),
				array(
					'url' => 'https://www.twitch.tv/imaqtpie',
					'id'  =>                       'imaqtpie',
					'api_img' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/imaqtpie',
				),
				array(
					'url' => 'https://www.twitch.tv/imaqtpie/v/95318019',
					'id' =>                                    95318019,
					'api_img' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/imaqtpie',
				),
			),
		),
		'ustream' => array(
			'regex'          => $s . 'ustream\.tv/(?:channel/)?([0-9]{8}|recorded/[0-9]{8}(/highlight/[0-9]+)?)',
			'embed_url'      => 'http://www.ustream.tv/embed/%s',
			'default_params' => 'html5ui',
			'auto_thumbnail' => false,
			'aspect_ratio'   => '480:270',
			'requires_flash' => true,
		),
		'rutube' => array(
			'name'           => 'RuTube.ru',
			'regex'          => $s . 'rutube\.ru/play/embed/([0-9]+)',
			'embed_url'      => 'https://rutube.ru/play/embed/%s',
			'requires_flash' => true,
			'tests' => array(
				array(
					'url' => 'https://rutube.ru/play/embed/9822149',
					'id'  =>                               9822149
				),
			),
		),
		'veoh' => array(
			'regex'          => $s . 'veoh\.com/watch/([a-z0-9]+)',
			'embed_url'      => 'http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1396&permalinkId=%s',
			'default_params' => 'player=videodetailsembedded&id=anonymous',
			'auto_thumbnail' => false,
			#'aspect_ratio' => 60.257,
			'tests' => array(
				array(
					'url' => 'http://www.veoh.com/watch/v19866882CAdjNF9b',
					'id'  =>                           'v19866882CAdjNF9b'
				),
			)
		),
		'vevo' => array(
			'regex'          => $s . 'vevo\.com/watch/(?:[^\/]+/[^\/]+/)?([a-z0-9]+)',
			'embed_url'      => 'https://scache.vevo.com/assets/html/embed.html?video=%s',
			'default_params' => 'playlist=false&playerType=embedded&env=0',
			'auto_thumbnail' => false,
			'requires_flash' => true,
			'tests' => array(
				array(
					'url'  => 'https://www.vevo.com/watch/the-offspring/the-kids-arent-alright/USSM20100649',
					'id'   =>                                                                 'USSM20100649'
				),
				#array( '', '' ),
				#array( '', '' ),
			),
		),
		'viddler' => array(
			'regex'          => $s . 'viddler\.com/(?:embed|v)/([a-z0-9]{8})',
			'embed_url'      => 'https://www.viddler.com/player/%s/',
			'default_params' => 'wmode=transparent&player=full&f=1&disablebranding=1',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			'aspect_ratio'   => '545:349',
			'requires_flash' => true,
			'tests' => array(
				array(
					'url' => 'https://www.viddler.com/v/a695c468',
					'id' =>                            'a695c468'
				),
			),
		),
		'vidspot' => array(
			'name'      => 'vidspot.net',
			'regex'     => $s . 'vidspot\.net/(?:embed-)?([a-z0-9]+)',
			'embed_url' => 'http://vidspot.net/embed-%s.html',
			'requires_flash' => true,
			'tests' => array(
				array( 'url' => 'http://vidspot.net/285wf9uk3rry', 'id' => '285wf9uk3rry' ),
				array( 'url' => 'http://vidspot.net/embed-285wf9uk3rry.html', 'id' => '285wf9uk3rry' ),
			),
		),
		'vine' => array(
			'regex'          => $s . 'vine\.co/v/([a-z0-9]+)',
			'embed_url'      => 'https://vine.co/v/%s/embed/simple',
			'default_params' => '', //* audio=1 supported
			'auto_thumbnail' => false,
			'aspect_ratio'   => '1:1',
			'tests' => array(
				array( 'url' => 'https://vine.co/v/bjAaLxQvOnQ',       'id' => 'bjAaLxQvOnQ' ),
				array( 'url' => 'https://vine.co/v/MbrreglaFrA',       'id' => 'MbrreglaFrA' ),
				array( 'url' => 'https://vine.co/v/bjHh0zHdgZT/embed', 'id' => 'bjHh0zHdgZT' ),
			),
		),
		'vimeo' => array(
			'regex'          => $s . 'vimeo\.com/(?:(?:channels/[a-z]+/)|(?:groups/[a-z]+/videos/))?([0-9]+)',
			'embed_url'      => 'https://player.vimeo.com/video/%s',
			'default_params' => 'html5=1&title=1&byline=0&portrait=0',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			'tests' => array(
				array( 'url' => 'https://vimeo.com/124400795', 'id' => 124400795 ),
			),
			'query_argss' => array(
				'autoplay'  => array( 'bool', __( 'Autoplay', ARVE_SLUG ) ),
				'badge'     => array( 'bool', __( 'Badge', ARVE_SLUG ) ),
				'byline'    => array( 'bool', __( 'Byline', ARVE_SLUG ) ),
				'color'     => 'string',
				'loop'      => array( 0, 1 ),
				'player_id' => 'int',
				'portrait'  => array( 0, 1 ),
				'title'     => array( 0, 1 ),
			),
		),
		'vk' => array(
			'name' => 'VK',
			#https://vk.com/video             162756656_171388096
			#https://vk.com/video_ext.php?oid=162756656&id=171388096&hash=b82cc24232fe7f9f&hd=1
			'regex'          => $s . 'vk\.com/video_ext\.php\?([^ ]+)',
			'embed_url'      => 'https://vk.com/video_ext.php?%s',
			'requires_src'   => true,
			'auto_thumbnail' => false,
			'tests' => array(
				array(
					'url' => 'https://vk.com/video_ext.php?oid=162756656&id=171388096&hash=b82cc24232fe7f9f&hd=1',
					'id' =>                               'oid=162756656&id=171388096&hash=b82cc24232fe7f9f&hd=1'
				),
			),
		),
		'vzaar' => array(
			'regex'     => 'https?://view.vzaar.com/([0-9]+)',
			'embed_url' => 'https://view.vzaar.com/%s/player',
		),
		'wistia' => array(
			# fast.wistia.net/embed/iframe/g5pnf59ala?videoFoam=true
			'regex'          => 'https?://fast\.wistia\.net/embed/iframe/([a-z0-9]+)',
			'embed_url'      => 'https://fast.wistia.net/embed/iframe/%s',
			'default_params' => 'videoFoam=true',
			'tests' => array(
				array(
					'url' => 'https://fast.wistia.net/embed/iframe/g5pnf59ala?videoFoam=true',
					'id' =>                                       'g5pnf59ala'
				),
			),
		),
		'xtube' => array(
			'name'           => 'XTube',
			'regex'          => $s . 'xtube\.com/watch\.php\?v=([a-z0-9_\-]+)',
			'embed_url'      => 'http://www.xtube.com/embedded/user/play.php?v=%s',
			'auto_thumbnail' => false,
			'requires_flash' => true,
		),
		'yahoo' => array(
			'regex'          => '(https?://(?:[a-z.]+)yahoo\.com/[/-a-z0-9öäü]+\.html)',
			'embed_url'      => '%s',
			'default_params' => 'format=embed',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			'requires_flash' => true,
			'tests' => array(
				array(
					'url' => 'https://de.sports.yahoo.com/video/krasse-vorher-nachher-bilder-mann-094957265.html?format=embed&player_autoplay=false',
					'id'  => 'https://de.sports.yahoo.com/video/krasse-vorher-nachher-bilder-mann-094957265.html'
				),
				array(
					'url' => 'https://www.yahoo.com/movies/sully-trailer-4-211012511.html?format=embed',
					'id' => 'https://www.yahoo.com/movies/sully-trailer-4-211012511.html'
				),
			)
		),
		'youku' => array(
			'regex'          => 'https?://(?:[a-z.]+)?\.youku.com/(?:embed/|v_show/id_)([a-z0-9]+)',
			'embed_url'      => 'http://player.youku.com/embed/%s',
			'auto_thumbnail' => false,
			'aspect_ratio'   => '450:292.5',
			'requires_flash' => true,
			# <iframe height=498 width=510 src="http://player.youku.com/embed/XMTUyODYwOTc4OA==" frameborder=0 allowfullscreen></iframe>
			'tests' => array(
				array(
					'url' => 'http://v.youku.com/v_show/id_XMTczMDAxMjIyNA==.html?f=27806190',
					'id'  =>                              'XMTczMDAxMjIyNA',
				),
				array(
					'url' => 'http://player.youku.com/embed/XMTUyODYwOTc4OA==',
					'id'  =>                               'XMTUyODYwOTc4OA',
				),
			),
		),
		'youtube' => array(
			'name'           => 'YouTube',
			'regex'          => $s . '(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\?(?:\S*?&?v\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11}((?:\?|&)list=[a-z0-9_\-]+)?)',
			'embed_url'      => 'https://www.youtube-nocookie.com/embed/%s',
			'default_params' => 'iv_load_policy=3&modestbranding=1&rel=0&autohide=1&playsinline=1',
			'auto_thumbnail' => true,
			'auto_title'     => true,
			#'[youtube id="XQEiv7t1xuQ"]',
			'tests' => array(
				array(
					'url'          => 'https://youtu.be/dqLyB5srdGI',
					'id'           =>                 'dqLyB5srdGI',
				),
				array(
					'url' => 'https://www.youtube.com/watch?v=-fEo3kgHFaw',
					'id'  =>                                 '-fEo3kgHFaw',
				),
				array(
					'url'          => 'http://www.youtube.com/watch?v=vrXgLhkv21Y',
					'id'           =>                                'vrXgLhkv21Y',
					'oembed_title' => 'TerrorStorm Full length version',
				),
				array(
					'url'          => 'https://youtu.be/hRonZ4wP8Ys',
					'id'           =>                  'hRonZ4wP8Ys',
					'oembed_title' => 'One Bright Dot',
				),
				array(
					'url' => 'http://www.youtube.com/watch?v=GjL82KUHVb0&list=PLI46g-I12_9qGBq-4epxOay0hotjys5iA&index=10', # The index part will be ignored
					'id'  =>                                'GjL82KUHVb0&list=PLI46g-I12_9qGBq-4epxOay0hotjys5iA'
				),
				array(
					'url' => 'https://youtu.be/b8m9zhNAgKs?list=PLI_7Mg2Z_-4I-W_lI55D9lBUkC66ftHMg',
					'id'  =>                  'b8m9zhNAgKs?list=PLI_7Mg2Z_-4I-W_lI55D9lBUkC66ftHMg'
				),
			),
			'specific_tests' => array(
				__('URL from youtu.be shortener', ARVE_SLUG),
				'http://youtu.be/3Y8B93r2gKg',
				__('Youtube playlist URL inlusive the video to start at. The index part will be ignored and is not needed', ARVE_SLUG) ,
				'http://www.youtube.com/watch?v=GjL82KUHVb0&list=PLI46g-I12_9qGBq-4epxOay0hotjys5iA&index=10',
				__('Loop a YouTube video', ARVE_SLUG),
				'[youtube id="FKkejo2dMV4" parameters="playlist=FKkejo2dMV4&loop=1"]',
				__('Enable annotations and related video at the end (disable by default with this plugin)', ARVE_SLUG),
				'[youtube id="uCQXKYPiz6M" parameters="iv_load_policy=1"]',
				__('Testing Youtube Starttimes', ARVE_SLUG),
				'http://youtu.be/vrXgLhkv21Y?t=1h19m14s',
				'http://youtu.be/vrXgLhkv21Y?t=19m14s',
				'http://youtu.be/vrXgLhkv21Y?t=1h',
				'http://youtu.be/vrXgLhkv21Y?t=5m',
				'http://youtu.be/vrXgLhkv21Y?t=30s',
				__( 'The Parameter start only takes values in seconds, this will start the video at 1 minute and 1 second', ARVE_SLUG ),
				'[youtube id="uCQXKYPiz6M" parameters="start=61"]',
			),
			'query_args' => array(
				array(
				  'attr' => 'autohide',
					'type' => 'bool',
					'name' => __( 'Autohide', ARVE_SLUG )
				),
				array(
				  'attr' => 'autoplay',
					'type' => 'bool',
					'name' => __( 'Autoplay', ARVE_SLUG )
				),
				array(
				  'attr' => 'cc_load_policy',
					'type' => 'bool',
					'name' => __( 'cc_load_policy', ARVE_SLUG )
				),
				array(
				  'attr' => 'color',
					'type' => array(
						''      => __( 'Default', ARVE_SLUG ),
						'red'   => __( 'Red', ARVE_SLUG ),
						'white' => __( 'White', ARVE_SLUG ),
					),
					'name' => __( 'Color', ARVE_SLUG )
				),
				array(
				  'attr' => 'controls',
					'type' => array(
						'' => __( 'Default', ARVE_SLUG ),
						0  => __( 'None', ARVE_SLUG ),
						1  => __( 'Yes', ARVE_SLUG ),
						2  => __( 'Yes load after click', ARVE_SLUG ),
					),
					'name' => __( 'Controls', ARVE_SLUG )
				),
				array(
				  'attr' => 'disablekb',
					'type' => 'bool',
					'name' => __( 'disablekb', ARVE_SLUG )
				),
				array(
				  'attr' => 'enablejsapi',
					'type' => 'bool',
					'name' => __( 'JavaScript API', ARVE_SLUG )
				),
				array(
				  'attr' => 'end',
					'type' => 'number',
					'name' => __( 'End', ARVE_SLUG )
				),
				array(
				  'attr' => 'fs',
					'type' => 'bool',
					'name' => __( 'Fullscreen', ARVE_SLUG )
				),
				array(
				  'attr' => 'hl',
					'type' => 'text',
					'name' => __( 'Language???', ARVE_SLUG )
				),
				array(
				  'attr' => 'iv_load_policy',
					'type' => array(
						'' => __( 'Default', ARVE_SLUG ),
						1  => __( 'Show annotations', ARVE_SLUG ),
						3  => __( 'Do not show annotations', ARVE_SLUG ),
					),
					'name' => __( 'iv_load_policy', ARVE_SLUG ),
				),
				array(
				  'attr' => 'list',
					'type' => 'medium-text',
					'name' => __( 'Language???', ARVE_SLUG )
				),
				array(
				  'attr' => 'listType',
					'type' => array(
						''             => __( 'Default', ARVE_SLUG ),
						'playlist'     => __( 'Playlist', ARVE_SLUG ),
						'search'       => __( 'Search', ARVE_SLUG ),
						'user_uploads' => __( 'User Uploads', ARVE_SLUG ),
					),
					'name' => __( 'List Type', ARVE_SLUG ),
				),
				array(
				  'attr' => 'loop',
					'type' => 'bool',
					'name' => __( 'Loop', ARVE_SLUG ),
				),
				array(
				  'attr' => 'modestbranding',
					'type' => 'bool',
					'name' => __( 'Modestbranding', ARVE_SLUG ),
				),
				array(
				  'attr' => 'origin',
					'type' => 'bool',
					'name' => __( 'Origin', ARVE_SLUG ),
				),
				array(
				  'attr' => 'playerapiid',
					'type' => 'bool',
					'name' => __( 'playerapiid', ARVE_SLUG ),
				),
				array(
				  'attr' => 'playlist',
					'type' => 'bool',
					'name' => __( 'Playlist', ARVE_SLUG ),
				),
				array(
				  'attr' => 'playsinline',
					'type' => 'bool',
					'name' => __( 'playsinline', ARVE_SLUG ),
				),
				array(
				  'attr' => 'rel',
					'type' => 'bool',
					'name' => __( 'Related Videos at End', ARVE_SLUG ),
				),
				array(
				  'attr' => 'showinfo',
					'type' => 'bool',
					'name' => __( 'Show Info', ARVE_SLUG ),
				),
				array(
				  'attr' => 'start',
					'type' => 'number',
					'name' => __( 'Start', ARVE_SLUG ),
				),
				array(
				  'attr' => 'theme',
					'type' => array(
						''      => __( 'Default', ARVE_SLUG ),
						'dark'  => __( 'Dark', ARVE_SLUG ),
						'light' => __( 'Light', ARVE_SLUG ),
					),
					'name' => __( 'Theme', ARVE_SLUG ),
				),
			),
		),
		'youtubelist' => array(
			'regex'          => $s . 'youtube\.com/(?:embed/videoseries|playlist)\?list=([-a-z0-9]+)',
			'name'           => 'YouTube Playlist',
			'embed_url'      => 'http://www.youtube.com/embed/videoseries?list=%s',
			'auto_thumbnail' => true,
			'tests' => array(
				array(
					'url' => 'https://www.youtube.com/playlist?list=PL3Esg-ZzbiUmeSKBAQ3ej1hQxDSsmnp-7',
					'id'  =>                                       'PL3Esg-ZzbiUmeSKBAQ3ej1hQxDSsmnp-7'
				),
				array(
					'url' => 'https://www.youtube.com/embed/videoseries?list=PLMUvgtCRyn-6obmhiDS4n5vYQN3bJRduk',
					'id'  =>                                                'PLMUvgtCRyn-6obmhiDS4n5vYQN3bJRduk',
				)
			)
		),
		'html5' => array(
			'name' => 'HTML5 Video (in testing)',
		),
		'iframe' => array(
			'embed_url'         => '%s',
			'default_params'    => '',
			'auto_thumbnail'    => false,
			'requires_flash'    => true,
			'tests' => array(
				array(
					'url' => 'http://example.com/',
					'id'  => 'http://example.com/',
				),
			),
		),
	);

	foreach ( $properties as $key => $value ) {

		if( empty( $value['name'] ) ) {
			$properties[ $key ]['name'] = ucfirst( $key );
		}
	}

	return $properties;
}

function arve_attr( $attr = array(), $filter_name = false ) {

	if ( $filter_name ) {
		$attr = apply_filters( 'arve_attr_' . $filter_name, $attr );
	}

	if ( empty( $attr ) ) {
		return '';
	}

	$out = '';

	foreach ( $attr as $key => $value ) {

		if ( false === $value || null === $value ) {
			continue;
		} elseif ( '' === $value || true === $value ) {
			$out .= sprintf( ' %s', esc_html( $key ) );
		} elseif ( in_array( $key, array( 'href', 'data-href', 'src', 'data-src' ) ) ) {
			$out .= sprintf( ' %s="%s"', esc_html( $key ), arve_esc_url( $value ) );
		} else {
			$out .= sprintf( ' %s="%s"', esc_html( $key ), esc_attr( $value ) );
		}
	}

	return $out;
}

function arve_esc_url( $url ) {
	return str_replace( 'jukebox?list%5B0%5D', 'jukebox?list[]', esc_url( $url ) );
}

function arve_starts_with( $haystack, $needle ) {
	// search backwards starting from haystack length characters from the end
	return $needle === "" || strrpos( $haystack, $needle, -strlen( $haystack ) ) !== false;
}

function arve_ends_with( $haystack, $needle ) {
	// search forward starting from end minus needle length characters
	return $needle === "" || ( ( $temp = strlen($haystack) - strlen( $needle ) ) >= 0 && strpos( $haystack, $needle, $temp ) !== false );
}

function arve_contains( $haystack, $needle ) {
  return strpos( $haystack, $needle ) !== false;
}
