<?php
/*

Filename: common.php
Description: common.php loads commonly accessed functions across the Visser Labs suite.

*/

if( is_admin() ) {

	/* Start of: WordPress Administration */

	include_once( 'common-dashboard_widgets.php' );

	/* End of: WordPress Administration */

}
?>