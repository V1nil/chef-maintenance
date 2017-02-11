<?php

/**
 * Class for Timely API communication related to Discover Events and Feeds.
 *
 * @author     Time.ly Network, Inc.
 * @since      2.4
 * @package    Ai1EC
 * @subpackage Ai1EC.Model
 */
class Ai1ec_Api_Feeds extends Ai1ec_Api_Abstract {

	/**
	 * Post construction routine.
	 *
	 * Override this method to perform post-construction tasks.
	 *
	 * @return void Return from this method is ignored.
	 */
	protected function _initialize() {
		parent::_initialize();
	}

	/**
	 * That's currently a mock for getting a suggested events list.
	 * @return object Response body in JSON.
	 */
	public function get_suggested_events( $page = 0, $max = 20 ) {
		$calendar_id = $this->_get_ticket_calendar();
		if ( 0 >= $calendar_id ) {
			return null;
		}
		$request  = array(
			'headers' => $this->_get_headers(),
			'timeout' => parent::DEFAULT_TIMEOUT
			);
		$url           = AI1EC_API_URL . "calendars/$calendar_id/discover/events?page=$page&max=$max";
		$response      = wp_remote_get( $url, $request );
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 === $response_code ) {			
			$result = json_decode( $response['body'] );
			return $result->data;
		} else {
			$error_message = $this->_transform_error_message( 
				  __( 'We were unable to get the Suggested Events from Time.ly Network', AI1EC_PLUGIN_NAME )
				, $response, $url, true );
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( $error_message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return array();
		}
	}

}