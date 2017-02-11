<?php

/**
 * Tickets page.
 *
 * @author     Time.ly Network Inc.
 * @since      2.4
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_View_Tickets extends Ai1ec_View_Admin_Abstract {

	/**
	 * @var string The nonce action
	 */
	const NONCE_ACTION = 'ai1ec_api_ticketing_signup';

	/**
	 * @var string The nonce name
	 */
	const NONCE_NAME  = 'ai1ec_api_ticketing_nonce';

	/**
	 * @var string The id/name of the submit button.
	 */
	const SUBMIT_ID = 'ai1ec_api_ticketing_signup';

	/**
	 * Adds the page to the correct menu.
	 */
	public function add_page() {
		if ( $this->_registry->get( 'helper.api-settings' )->ai1ec_api_enabled() ) {
			add_submenu_page(
				AI1EC_ADMIN_BASE_URL,
				__( 'Ticketing', AI1EC_PLUGIN_NAME ),
				__( 'Ticketing<sup>beta</sup>', AI1EC_PLUGIN_NAME ),
				'manage_ai1ec_feeds',
				AI1EC_PLUGIN_NAME . '-tickets',
				array( $this, 'display_page' )
			);
		}
	}

	/**
	 * Add meta box for page.
	 *
	 * @wp_hook admin_init
	 *
	 * @return void
	 */
	public function add_meta_box() {}

	/**
	 * Display the page html
	 */
	public function display_page() {

		$api               = $this->_registry->get( 'model.api.api-ticketing' );
		$ticketing_enabled = $api->is_signed();
		$ticketing_message = $api->get_sign_message();
		$loader            = $this->_registry->get( 'theme.loader' );

		if ( ! $ticketing_enabled ) {

			if ( false === ai1ec_is_blank( $ticketing_message ) ) {
				$api->clear_sign_message();
			}

			$args = array(
				'title' => Ai1ec_I18n::__(
					'Time.ly Ticketing<sup>beta</sup>'
				),
				'sign_up_text' => 'Please, <a href="edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-settings">Sign Up for a Timely Network account</a> to use Ticketing.'

			);
			$file = $loader->get_file( 'ticketing/signup.twig', $args, true );
		} else {
			$response  = $api->get_payment_preferences();
			$purchases = $api->get_purchases();
			$args      = array(
				'title'                             => Ai1ec_I18n::__(
					'Time.ly Ticketing<sup>beta</sup>'
				),
				'settings_text'                     => Ai1ec_I18n::__( 'Settings' ),
				'sales_text'                        => Ai1ec_I18n::__( 'Sales' ),
				'select_payment_text'               => Ai1ec_I18n::__( 'How do you want the tickets revenue to be sent to you?' ),
				'select_payment_description_text'   => Ai1ec_I18n::__( 
					'If no payout method is selected, Time.ly will collect the revenue on behalf of you. Please contact payouts@time.ly for any outstanding payouts.' 
				),
				'cheque_text'                       => Ai1ec_I18n::__( 'Cheque' ),
				'paypal_text'                       => Ai1ec_I18n::__( 'Paypal' ),
				'required_text'                     => Ai1ec_I18n::__( 'This field is required.' ),
				'save_changes_text'                 => Ai1ec_I18n::__( 'Save Changes' ),
				'date_text'                         => Ai1ec_I18n::__( 'Date' ),
				'event_text'                        => Ai1ec_I18n::__( 'Event' ),
				'purchaser_text'                    => Ai1ec_I18n::__( 'Purchaser' ),
				'tickets_text'                      => Ai1ec_I18n::__( 'Tickets' ),
				'email_text'                        => Ai1ec_I18n::__( 'Email' ),
				'status_text'                       => Ai1ec_I18n::__( 'Status' ),
				'total_text'                        => Ai1ec_I18n::__( 'Total' ),
				'sign_out_button_text'              => Ai1ec_I18n::__( 'Sign Out' ),
				'payment_method'                    => $response->payment_method,
				'paypal_email'                      => $response->paypal_email,
				'first_name'                        => $response->first_name,
				'last_name'                         => $response->last_name,
				'street'                            => $response->street,
				'city'                              => $response->city,
				'state'                             => $response->state,
				'postcode'                          => $response->postcode,
				'country'                           => $response->country,
				'nonce'                             => array(
					'action'   => self::NONCE_ACTION,
					'name'     => self::NONCE_NAME,
					'referrer' => false,
				),
				'action'                            =>
					'?controller=front&action=ai1ec_api_ticketing_signup&plugin=' .
					AI1EC_PLUGIN_NAME,
				'purchases'                         => $purchases
			);
			$file = $loader->get_file( 'ticketing/manage.twig', $args, true );
		}

		$this->_registry->get( 'css.admin' )->admin_enqueue_scripts(
			'ai1ec_event_page_all-in-one-event-calendar-settings'
		);
		$this->_registry->get( 'css.admin' )->process_enqueue(
			array(
				array( 'style', 'ticketing.css', ),
			)
		);
		if ( isset( $_POST['ai1ec_save_settings'] ) ) {
			$response = $api->save_payment_preferences();

			// this redirect makes sure that the error messages appear on the screen
			header( "Location: " . $_SERVER['HTTP_REFERER'] );
		}
		return $file->render();
	}

	/**
	 * Handle post, likely to be deprecated to use commands.
	 */
	public function handle_post(){}

}
