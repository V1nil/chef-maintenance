<?php

/**
 * Concrete implementation for email notifications.
 *
 * @author       Time.ly Network Inc.
 * @since        2.0
 * @instantiator new
 * @package      AI1EC
 * @subpackage   AI1EC.Notification
 */
class Ai1ec_Email_Notification extends Ai1ec_Notification {

	/**
	 * @var string
	 */
	private $_subject;

	/**
	 * @var array
	 */
	private $_translations = array();

	/**
	 * @param array: $translations
	 */
	public function set_translations( array $translations ) {
		$this->_translations = $translations;
	}

	public function __construct(
		Ai1ec_Registry_Object $registry,
		$message,
		array $recipients,
		$subject
	) {
		parent::__construct( $registry );
		$this->_message    = $message;
		$this->_recipients = $recipients;
		$this->_subject    = $subject;
	}

	public function send( $headers = null ) {
		
		$this->_parse_text();	
		$is_plain_text = true;	
		if ( null !== $headers ) {			
			foreach ( $headers as $key => $value ) {
				if ( 0 === strcasecmp( "content-type", $key ) && 
					0 === strcasecmp( "text/html", $value ) ) {
					$is_plain_text = false;
					break;
				}
			}
		} 
		$is_mandril_active = apply_filters ( 'ai1ec_is_mandril_active', null );
		if ( $is_plain_text ) {			
			$nl2br_handler             = array( $this, 'mandrill_nl2br' );
			add_filter( 'mandrill_nl2br', $nl2br_handler );			
			if ( $is_mandril_active ) {
				$double_line_break_handler = array( $this, 'convert_single_to_double_line_break' );
				add_filter( 'wp_mail', $double_line_break_handler );						
			}		
		}
		$failed_handler = array( $this, 'send_mail_failed' );
		add_filter( 'wp_mail_failed', $failed_handler );

		// Rewrite WordPress "From" Header
		add_filter( 'wp_mail_from_name', 'new_mail_from_name' );
		if ( !function_exists( 'new_mail_from_name' ) ) {
			function new_mail_from_name() {
				return get_bloginfo( 'name' );
			}
		}
		if ( $is_mandril_active ) {
			$new_mail_from_handler = array( $this, 'new_mail_from_mandril' );
			add_filter( 'wp_mail_from', $new_mail_from_handler );
			$phpmailer_init_handler = array( $this, 'phpmailer_init_mandril' );
			add_action( 'phpmailer_init', $phpmailer_init_handler );
		} 

		$result = wp_mail( $this->_recipients, $this->_subject, $this->_message, $headers );

		remove_filter( 'wp_mail_failed', $failed_handler );
		if ( $is_mandril_active ) {
			remove_filter( 'wp_mail_from', $new_mail_from_handler );
			remove_action( 'phpmailer_init', $phpmailer_init_handler );
		}
		if ( $is_plain_text ) {
			remove_filter( 'mandrill_nl2br', $nl2br_handler );
			if ( $is_mandril_active ) {
				remove_filter( 'wp_mail', $double_line_break_handler );	
			}		
		}
		return $result;		
	}

	public function new_mail_from_mandril() {
		return 'no-reply@time.ly';
	}

	public function phpmailer_init_mandril( $phpmailer ) {
		$phpmailer->addReplyTo( get_bloginfo( 'admin_email' ), get_bloginfo( 'name' ) );
	}

	/**
	 * Handle the wp_mail_filter when sending Plain texts emails and Mandril 
	 * is used to send notifications. 
	 */
	public function convert_single_to_double_line_break( $atts = null ) {
		//As MC-AutoHtml is set to true, mandril will convert the text/plain to generate the text/html 
		//this conversion will Ignores the line break (\n) from the text message. The only way to keep 
		//the lines breaks is have double line breaks as instructed by mandril twiter account here:
		//https://twitter.com/mandrillapp/status/397377474541010944
		if ( isset( $atts['message'] ) && false === empty( $atts['message'] ) )  {
			$temp = str_replace( "\n\r", "\n", $atts['message'] );
			$temp = str_replace( "\r\n", "\n", $temp );
			$atts['message'] = str_replace( "\n", "\n\n", $temp );
		}
		return $atts;
	}

	/**
	 * Handle the wp_mail_failed hook to log the error
	 */
	public function send_mail_failed( $error = null) {
		if ( null != $error && is_wp_error( $error ) ) {
			error_log( 'wp_mail failed, code: %d, message: %s', $error->get_error_code(), $error->get_error_message() );
		} else {
			error_log( 'wp_mail failed, unknow error' );
		}
	}

	/**
	 * Handle the mandrill_nl2br hook.
	 * When sending text/plain nl2br should be avoided
	 */
	public function mandrill_nl2br( $nl2br = false, $message = null ) {
		return true;
	}

	private function _parse_text() {
		if ( null !== $this->_translations ) {
			$this->_message = strtr( $this->_message, $this->_translations );
			$this->_subject = strtr( $this->_subject, $this->_translations );
		}
	}

}