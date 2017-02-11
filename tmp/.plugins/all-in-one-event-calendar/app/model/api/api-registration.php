<?php

/**
 * Class for Timely API communication for Registration.
 *
 * @author     Time.ly Network, Inc.
 * @since      2.4
 * @package    Ai1EC
 * @subpackage Ai1EC.Model
 */
class Ai1ec_Api_Registration extends Ai1ec_Api_Abstract {

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
	 * @return object Response body in JSON.
	 */
	public function signin() {
		$body['email']    = $_POST['ai1ec_email'];
		$body['password'] = $_POST['ai1ec_password'];
		$response         = $this->request_api( 'POST', AI1EC_API_URL . 'auth/authenticate', json_encode( $body ), true, array( 'Authorization' => null ) );
		if ( $this->is_response_success( $response ) ) {
			$response_body = (array) $response->body;
			$this->_save_settings( $response_body['message'], true, $response_body['auth_token'], $this->_find_user_calendar() );			
		} else {
			$error_message = $this->save_error_notification( $response, __( 'We were unable to Sign you In for Time.ly Ticketing', AI1EC_PLUGIN_NAME ) );
			$this->_save_settings( $error_message, false, '', 0 );
		}
		return $response;
	}

	/**
	 * @return object Response body in JSON.
	 */
	public function signup() {
		$body['name']                  = $_POST['ai1ec_name'];
		$body['email']                 = $_POST['ai1ec_email'];
		$body['password']              = $_POST['ai1ec_password'];
		$body['password_confirmation'] = $_POST['ai1ec_password_confirmation'];
		$body['phone']                 = $_POST['ai1ec_phone'];
		$body['terms']                 = $_POST['ai1ec_terms'];
		$response                      = $this->request_api( 'POST', AI1EC_API_URL . 'auth/register', json_encode( $body ), true );
		if ( $this->is_response_success( $response ) ) {
			$response_body = (array) $response->body;
			$this->_save_settings( $response_body['Registration'], true, $response_body['auth_token'] , $this->_create_calendar() );			
		} else {
			$error_message = $this->save_error_notification( $response, __( 'We were unable to Sign you Up for Time.ly Ticketing', AI1EC_PLUGIN_NAME ) );
			$this->_save_settings( $error_message, false, '', 0 );
		}
		return $response;
	}
 
 	/**
	 * Clean the ticketing settings on WP database only
	 */
	public function signout() {
		$this->_save_settings( '', false, '', 0 );
		return array( 'message' => '');
	}

}