<?php
/**
 * Content wrappers
 *
 * @author 	PressTigers
 * @package 	simple-job-board/templates
 * @version     1.0.0
 * @since       2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$template = get_option( 'template' );
switch( $template ) {
	case 'twentyeleven' :
		echo '</div></div></div>';
		break;
	case 'twentytwelve' :
		echo '</div></div>';
		break;
	case 'twentythirteen' :
		echo '</div></div>';
		break;
	case 'twentyfourteen' :
		echo '</div></div></div></div>';
		get_sidebar( 'content' );
		break;
	case 'twentyfifteen' :
		echo '</div></div></div>';
		break;
	case 'twentysixteen' :
		echo '</div></main></div>';
		break;
	default :
		echo '</div></div></div>';
		break;
}
