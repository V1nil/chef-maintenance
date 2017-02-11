<?php

/**
 * Class for Timely API communication for Ticketing.
 *
 * @author     Time.ly Network, Inc.
 * @since      2.4
 * @package    Ai1EC
 * @subpackage Ai1EC.Model
 */
class Ai1ec_Api_Ticketing extends Ai1ec_Api_Abstract {

	const EVENT_ID_METADATA         = '_ai1ec_api_event_id';
	const THUMBNAIL_ID_METADATA     = '_ai1ec_thumbnail_id';
	const ICS_CHECKOUT_URL_METADATA = '_ai1ec_ics_checkout_url';
	const ICS_API_URL_METADATA      = '_ai1ec_ics_api_url';
	const MAX_TICKET_TO_BUY_DEFAULT = 25;

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
	 * Count the valid Tickets Types (not removed) included inside the Ticket Event
	 */
	private function _count_valid_tickets( $post_ticket_types ) {
		if (false === isset( $post_ticket_types ) || 0 === count( $post_ticket_types ) ) {
			return 0;
		} else {
			$count = 0;
			foreach ( $post_ticket_types as $ticket_type_ite ) {
				if ( !isset( $ticket_type_ite['remove'] ) ) {
					$count++;
				}
			}
			return $count;
		}
	}

	/**
	 * Run some validations inside the _POST request to check if the Event 
	 * submmited is a valid event for Tickets
	 * @return NULL in case of success or a Message in case of error
	 */
	private function _is_valid_post( Ai1ec_Event $event ) {
		if ( ( isset( $_POST['ai1ec_rdate'] ) && ! empty( $_POST['ai1ec_rdate'] ) ) || 
			 ( isset( $_POST['ai1ec_repeat'] ) && ! empty( $_POST['ai1ec_repeat'] ) ) 
			 ) {
 			$notification = $this->_registry->get( 'notification.admin' );
			$error        = __( 'The Repeat option was selected but recurrence is not supported by Event with Tickets.', AI1EC_PLUGIN_NAME );
			$notification->store( $error, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return $error;			
		}
		if ( isset( $_POST['ai1ec_tickets_loading_error'] ) ) {
			//do not update tickets because is unsafe. There was a problem to load the tickets,
			//the customer received the same message when the event was loaded.
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( $_POST['ai1ec_tickets_loading_error'], 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return $_POST['ai1ec_tickets_loading_error'];
		}
		if ( $this->is_ticket_event_imported( $event->get( 'post_id' ) ) )  {
			//prevent changes on Ticket Events that were imported
			$error        = __( 'This Event was replicated from another site. Any changes on Tickets were discarded.', AI1EC_PLUGIN_NAME );
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( 
				$error, 
				'error', 
				0, 
				array( Ai1ec_Notification_Admin::RCPT_ADMIN ), 
				false 
			);
			return $error;
		} else if ( false === ai1ec_is_blank( $event->get( 'ical_feed_url' ) ) ) {			
			//prevent ticket creating inside Regular Events that were imported
			$error        = __( 'This Event was replicated from another site. Any changes on Tickets were discarded.', AI1EC_PLUGIN_NAME );
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( 
				$error,  
				'error', 
				0, 
				array( Ai1ec_Notification_Admin::RCPT_ADMIN ), 
				false 
			);
			return $error;			
		}
		if ( 0 === $this->_count_valid_tickets( $_POST['ai1ec_tickets'] ) ) {
			$message      = __( 'The Event has the Cost option Ticket selected but no ticket was added.', AI1EC_PLUGIN_NAME );
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( $message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return $message;
		}
		return null;
	}	

	/**
	*  Create or update a Ticket Event on API server
	 * @return object Response body in JSON.
	 */
	public function store_event( Ai1ec_Event $event, WP_Post $post ) {
		
		$error = $this->_is_valid_post( $event );
		if ( null !== $error ) {
			return $error;
		}		

		$api_event_id = get_post_meta(
					$event->get( 'post_id' ),
					self::EVENT_ID_METADATA,
					true
				);
		$is_new       = ! $api_event_id;
		$fields    = array( 'visibility' => $_POST['visibility'] );
		$body_data = $this->_parse_event_fields_to_api_structure(
			$event,
			$post,
			$_POST['ai1ec_tickets'],
			$fields
		);
		$url = AI1EC_API_URL . 'events';
		if ( $api_event_id ) {
			$url = $url . '/' . $api_event_id;
		}

		//get the thumbnail id saved previously
		$event_thumbnail_id = get_post_meta( $event->get( 'post_id' ), self::THUMBNAIL_ID_METADATA, true );
		if ( false === isset( $event_thumbnail_id ) ) {
			$event_thumbnail_id = 0;
		}
		//get the current thumbnail id
		$post_thumbnail_id  = get_post_thumbnail_id( $event->get( 'post_id' ) );
		if ( false === isset( $post_thumbnail_id ) ) {
			$post_thumbnail_id = 0;
		}
		$update_image   = ( $event_thumbnail_id !== $post_thumbnail_id );
		$payload        = '';
		$custom_headers = null;

		if ( true === $update_image && 0 < $post_thumbnail_id ) {
			$boundary                       = wp_generate_password( 24 );
			$custom_headers['content-type'] = 'multipart/form-data; boundary=' . $boundary;
			$body_data['update_image']      = '1';
			foreach ($body_data as $key => $value) {
	            if ( is_array( $value ) ) {
	            	$index = 0;
	            	foreach ( $value as $ticket_type_ite ) {
		            	foreach ( $ticket_type_ite as $child_key => $child_value ) {
	            			$payload .= '--' . $boundary;
	 						$payload .= "\r\n";
			            	$payload .= 'Content-Disposition: form-data; name="' . $key . '[' . $index . '][' . $child_key . ']"' . "\r\n";
		   		            $payload .= "\r\n";
				            $payload .= $child_value;
				            $payload .= "\r\n";
				        }
				        $index++;
				    }
	            } else {
	            	$payload .= '--' . $boundary;
	 				$payload .= "\r\n";
	            	$payload .= 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n";
   		            $payload .= "\r\n";
		            $payload .= $value;
		            $payload .= "\r\n";
	            }
			}
			$file_path = get_attached_file ( $post_thumbnail_id );
			$file_type = wp_check_filetype ( $file_path );
			$payload  .= '--' . $boundary;
			$payload  .= "\r\n";
			$payload  .= 'Content-Disposition: form-data; name="image_id"; filename="' . basename( $file_path ) . '"' . "\r\n";
			$payload  .= 'Content-Type: ' . $file_type['type'] . "\r\n";
			$payload  .= "\r\n";
			$payload  .= file_get_contents( $file_path );
			$payload  .= "\r\n";
			$payload  .= '--' . $boundary . '--';
		} else {
			$body_data['update_image'] = (true === $update_image) ? '1' : '0';
		 	$payload                   = json_encode( $body_data );
		}
		$response = $this->request_api( 'POST', $url, $payload, 
			true, //true to decode response body
			$custom_headers
			);
		if ( $this->is_response_success( $response ) ) {
			if ( $is_new && isset( $response->body->id ) ) {
				update_post_meta( $event->get( 'post_id' ), self::EVENT_ID_METADATA, $response->body->id );
			}
			if ( $post_thumbnail_id > 0 ) {
				update_post_meta( $event->get( 'post_id' ), self::THUMBNAIL_ID_METADATA, $post_thumbnail_id );
			} else {
				delete_post_meta( $event->get( 'post_id' ), self::THUMBNAIL_ID_METADATA );
			}
			return true;
		} else {
			$error_message = '';
			if ( $is_new ) {
				$error_message = __( 'We were unable to create the Event on Time.ly Ticketing', AI1EC_PLUGIN_NAME );				
			} else {
				$error_message = __( 'We were unable to update the Event on Time.ly Ticketing', AI1EC_PLUGIN_NAME );
			}
			return $this->save_error_notification( $response, $error_message );
		}
	}

	/**
	 * @return object Response body from API.
	 */
	public function save_payment_preferences() {
		$calendar_id = $this->_get_ticket_calendar();
		if ( 0 >= $calendar_id ) {
			return null;
		}
		$settings  = array(
			'payment_method' => $_POST['ai1ec_payment_method'],
			'paypal_email'   => $_POST['ai1ec_paypal_email'],
			'first_name'     => $_POST['ai1ec_first_name'],
			'last_name'      => $_POST['ai1ec_last_name'],
			'street'         => $_POST['ai1ec_street'],
			'city'           => $_POST['ai1ec_city'],
			'state'          => $_POST['ai1ec_state'],
			'country'        => $_POST['ai1ec_country'],
			'postcode'       => $_POST['ai1ec_postcode']
		);
		$custom_headers['content-type'] = 'application/x-www-form-urlencoded';
		$response = $this->request_api( 'PUT', AI1EC_API_URL . 'calendars/' . $calendar_id . '/payment', 
			$settings, 
			true, //decode response body
			$custom_headers 
		);
		if ( $this->is_response_success( $response ) ) {
			$notification  = $this->_registry->get( 'notification.admin' );
			$notification->store( 
				__( 'Payment preferences were saved.', AI1EC_PLUGIN_NAME ), 
				'updated', 
				0, 
				array( Ai1ec_Notification_Admin::RCPT_ADMIN ), 
				false 
			);
			return $response->body;
		} else {
			$this->save_error_notification( $response, 
				__( 'Payment preferences were not saved.', AI1EC_PLUGIN_NAME )
			);
			return false;
		}
	}

	/**
	 * @return object Response from API, or empty defaults
	 */
	public function get_payment_preferences() {
		$calendar_id = $this->_get_ticket_calendar();
		$settings    = null;
		if ( 0 < $calendar_id ) {
			$response = $this->request_api( 'GET', AI1EC_API_URL . "calendars/$calendar_id/payment", 
				null, //no body 
				true //decode response body
			);
			if ( $this->is_response_success( $response ) ) {
				$settings = $response->body;
			}
		}
		if ( is_null( $settings ) ) {
			return (object) array('payment_method'=>'cheque', 'paypal_email'=> '', 'first_name'=>'',  'last_name'=>'', 'street'=> '', 'city'=> '', 'state'=> '', 'postcode'=> '', 'country'=> '');
		} else {
			return $settings;	
		}		
	}

	/**
	 * Parse the fields of an Event to the structure used by API
	 */
	protected function _parse_event_fields_to_api_structure( Ai1ec_Event $event , WP_Post $post, $post_ticket_types, $api_fields_values  ) {

		$calendar_id = $this->_get_ticket_calendar();
		if ( $calendar_id <= 0 ) {
			return null;
		}

		//fields of ai1ec events table used by API
		$body['latitude']         = $event->get( 'latitude' );
		$body['longitude']        = $event->get( 'longitude' );
		$body['post_id']          = $event->get( 'post_id' );
		$body['calendar_id']      = $calendar_id;
		$body['dtstart']          = $event->get( 'start' )->format_to_javascript();
		$body['dtend']            = $event->get( 'end' )->format_to_javascript();
		$body['timezone']         = $event->get( 'timezone_name' );
		$body['venue_name']       = $event->get( 'venue' );
		$body['address']          = $event->get( 'address' );
		$body['city']             = $event->get( 'city' );
		$body['province']         = $event->get( 'province' );
		$body['postal_code']      = $event->get( 'postal_code' );
		$body['country']          = $event->get( 'country' );
		$body['contact_name']     = $event->get( 'contact_name' );
		$body['contact_phone']    = $event->get( 'contact_phone' );
		$body['contact_email']    = $event->get( 'contact_email' );
		$body['contact_website']  = $event->get( 'contact_url' );
		$body['uid']              = $event->get( 'ical_uid' );
		$body['title']            = $post->post_title;
		$body['description']      = $post->post_content;
		$body['url']              = get_permalink( $post->ID );
		$body['status']           = $post->post_status;
		$body['tax_rate']         = 0;

		$utc_current_time         = $this->_registry->get( 'date.time')->format_to_javascript();
		$body['created_at']       = $utc_current_time;
		$body['updated_at']       = $utc_current_time;		

		//removing blank values
		foreach ($body as $key => $value) {
			if ( ai1ec_is_blank( $value ) )	{
				unset( $body[ $key ] );
			}
		}

		if ( null !== $api_fields_values && is_array( $api_fields_values )) {
			foreach ( $api_fields_values as $key => $value ) {
				$body[$key] = $api_fields_values[$key];
				if ( 'visibility' === $key ) {
					if ( 0 === strcasecmp( 'private', $value ) ) {
						$body['status'] = 'private';
					} else if ( 0 === strcasecmp( 'password', $value ) ) {
						$body['status'] = 'password';
					}
				}
			}
		}

		$tickets_types = array();
		if ( isset( $post_ticket_types )) {
			$index         = 0;
			foreach ( $post_ticket_types as $ticket_type_ite ) {
				if ( false === isset( $ticket_type_ite['id'] ) && 
					 isset( $ticket_type_ite['remove'] ) ) {
					//ignoring new tickets that didn't go to api yet
					continue;
				}
				$tickets_types[$index++] = $this->_parse_tickets_type_post_to_api_structure(
					$ticket_type_ite,
					$event
				);
			}
		}
		$body['ticket_types'] = $tickets_types;

        return $body;
	}

	/**
	 * Parse the fields of a Ticket Type to the structure used by API
	 */
	protected function _parse_tickets_type_post_to_api_structure( $ticket_type_ite, $event ) {
		$utc_current_time = $this->_registry->get( 'date.time' )->format_to_javascript();
		if ( isset( $ticket_type_ite['id'] ) ) {
			$ticket_type['id']          = $ticket_type_ite['id'];
			$ticket_type['created_at'] 	= $ticket_type_ite['created_at'];
		} else {
			$ticket_type['created_at'] 	= $utc_current_time;
		}
		if ( isset( $ticket_type_ite['remove'] ) ) {
			$ticket_type['deleted_at'] 	= $utc_current_time;
		}
		$ticket_type['name']        = $ticket_type_ite['ticket_name'];
		$ticket_type['description'] = $ticket_type_ite['description'];
		$ticket_type['price']       = $ticket_type_ite['ticket_price'];
		if ( 0 === strcasecmp( 'on',  $ticket_type_ite['unlimited'] ) ) {
			$ticket_type['quantity'] = null;
		} else {
			$ticket_type['quantity'] = $ticket_type_ite['quantity'];			
		}
		$ticket_type['buy_min_qty']   = $ticket_type_ite['buy_min_limit'];
		if ( ai1ec_is_blank( $ticket_type_ite['buy_max_limit'] ) ) {
			$ticket_type['buy_max_qty'] = null;
		} else {
			$ticket_type['buy_max_qty'] = $ticket_type_ite['buy_max_limit'];
		}		
		if ( 0 === strcasecmp( 'on',  $ticket_type_ite['availibility'] ) ) {
			//immediate availability
			$timezone_start_time            = $this->_registry->get( 'date.time' );
			$timezone_start_time->set_timezone( $event->get('timezone_name') );						
			$ticket_type['sale_start_date'] = $timezone_start_time->format_to_javascript( $event->get('timezone_name') );
			$ticket_type['sale_end_date']   = $event->get( 'end' )->format_to_javascript();
		} else {
			$ticket_type['sale_start_date'] =  $ticket_type_ite['ticket_sale_start_date'];
			$ticket_type['sale_end_date']   =  $ticket_type_ite['ticket_sale_end_date'];
		}
		$ticket_type['updated_at'] = $utc_current_time;
		$ticket_type['status']     = $ticket_type_ite['ticket_status'];
		return $ticket_type;
	}

	/**
	 * Unparse the fields of API structure to the Ticket Type
	 */
	protected function _unparse_tickets_type_from_api_structure( $ticket_type_api ) {
		$ticket_type                         = $ticket_type_api;
		$ticket_type->ticket_name            = $ticket_type_api->name;
		$ticket_type->ticket_price           = $ticket_type_api->price;
		$ticket_type->buy_min_limit          = $ticket_type_api->buy_min_qty;
		if ( null === $ticket_type_api->buy_max_qty ) {
			$ticket_type->buy_max_limit = self::MAX_TICKET_TO_BUY_DEFAULT;
		} else {
			$ticket_type->buy_max_limit = $ticket_type_api->buy_max_qty;
		}		
		$ticket_type->ticket_sale_start_date = $ticket_type_api->sale_start_date; //YYYY-MM-YY HH:NN:SS
		$ticket_type->ticket_sale_end_date   = $ticket_type_api->sale_end_date; //YYYY-MM-YY HH:NN:SS
		$ticket_type->ticket_status 	     = $ticket_type_api->status;
		if ( false === isset( $ticket_type_api->quantity ) ||
			null === $ticket_type_api->quantity ) {
		 	$ticket_type->unlimited          = 'on';
		} else {		
 			$ticket_type->unlimited          = 'off';
		}
		$ticket_type->ticket_type_id = $ticket_type_api->id;
		$ticket_type->available      = $ticket_type_api->available;
		$ticket_type->availability   = $this->_parse_availability_message( $ticket_type_api->availability );

		//derived property to set the max quantity of dropdown
		if ( $ticket_type->available !== null ) {			
			if ( $ticket_type->available > $ticket_type->buy_max_limit ) {
				$ticket_type->buy_max_available = $ticket_type->buy_max_limit;
			} else {
				$ticket_type->buy_max_available = $ticket_type->available;
			}
		} else {
			$ticket_type->buy_max_available = $ticket_type->buy_max_limit;
		}					
		return $ticket_type;
	}

	public function _parse_availability_message( $availability ){
		if ( ai1ec_is_blank ( $availability ) ) {
			return null;
		} else {
			switch ($availability) {
				case 'past_event':
					return __( 'Past Event' );
				case 'event_closed':
					return __( 'Event closed' );		
				case 'not_available_yet':
					return __( 'Not available yet' );					
				case 'sale_closed':
					return __( 'Sale closed' );
				case 'sold_out':
					return __( 'Sold out' );														
				default:
					return __( 'Not available' );
			}
		}
    }


	/**
	 * @return string JSON.
	 */
	public function get_ticket_types( $post_id ) {
		$api_event_id = get_post_meta(
			$post_id,
			self::EVENT_ID_METADATA,
			true
		);
		if ( ! $api_event_id ) {
			return json_encode( array( 'data' => array() ) );
		}
		$response = $this->request_api( 'GET', $this->get_api_url( $post_id ) . 'events/' . $api_event_id . '/ticket_types', null);
		if ( $this->is_response_success( $response ) ) {
			if ( isset( $response->body->ticket_types ) ) {
		 		foreach ( $response->body->ticket_types as $ticket_api ) {
		 			$this->_unparse_tickets_type_from_api_structure( $ticket_api );
				}
				return json_encode( array( 'data' => $response->body->ticket_types ) );
			} else {
				return json_encode( array( 'data' => array() ) );
			}
		} else {
			$error_message = $this->_transform_error_message( 
				__( 'We were unable to get the Tickets Details from Time.ly Ticketing', AI1EC_PLUGIN_NAME ), 
				$response->raw, $response->url, 
				true 
			);
			return json_encode( array( 'data' => array(), 'error' => $error_message ) );
		}
	}

	/**
	 * @return object Response body in JSON.
	 */
	public function get_tickets( $post_id ) {
		$api_event_id = get_post_meta(
			$post_id,
			self::EVENT_ID_METADATA,
			true
		);
		if ( ! $api_event_id ) {
			return json_encode( array( 'data' => array() ) );
		}
		$request  = array(
			'headers' => $this->_get_headers(),
			'timeout' => parent::DEFAULT_TIMEOUT
			);
		$url           = $this->get_api_url( $post_id ) . 'events/' . $api_event_id . '/tickets';
		$response      = wp_remote_get( $url, $request );
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 === $response_code ) {
			return $response['body'];
		} else {
			$error_message = $this->_transform_error_message( 
				__( 'We were unable to get the Tickets Attendees from Time.ly Ticketing', AI1EC_PLUGIN_NAME ),
				$response, $url, 
				true 
			);
			return json_encode( array( 'data' => array(), 'error' => $error_message ) );
		}
	}
	
	public function _order_comparator( $order1, $order2 ) {
		return strcmp( $order1->created_at, $order2->created_at ) * -1;
	}

	/**
	 * @return object Response body in JSON.
	 */
	public function get_purchases() {
		$request  = array(
			'headers' => $this->_get_headers(),
			'timeout' => parent::DEFAULT_TIMEOUT
			);
		$url           = AI1EC_API_URL . 'calendars/' . $this->_get_ticket_calendar() . '/sales';
		$response      = wp_remote_get( $url, $request );
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 === $response_code ) {
			$result = json_decode( $response['body'] );
			if ( isset( $result->orders ) ) {
				usort( $result->orders, array( "Ai1ec_Api_Ticketing", "_order_comparator" ) );
				return $result->orders;
			} else {
				return array();
			}
		} else {
			$error_message = $this->_transform_error_message( 
				__( 'We were unable to get the Sales information from Time.ly Ticketing', AI1EC_PLUGIN_NAME ), 
				$response, 
				$url, 
				true 
			);
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( $error_message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return array();
		}
	}

	public function is_ticket_event_imported( $post_id ) {
		//if the event is imported, the ICS added the api url on metadata information
		$api_url = get_post_meta(
					$post_id,
					self::ICS_API_URL_METADATA,
					true
				);
		return (false === ai1ec_is_blank ( $api_url ));
	}

	protected function get_api_url ( $post_id ) {
		//if the event is imported, the ICS added the api url on metadata informatino
		$api_url = get_post_meta(
					$post_id,
					self::ICS_API_URL_METADATA,
					true
				);
		if ( ai1ec_is_blank ( $api_url ) ) {
			return AI1EC_API_URL;
		} else {
			return $api_url;
		}
	}

	/**
     * Check if the response that came from the API is the event not found
     */
    private function _is_event_notfound_error( $response_code, $response ) {
    	if ( 404 === $response_code ) {
			if ( isset( $response['body'] ) ) {
				$response_body = json_decode( $response['body'], true );
				if ( is_array( $response_body ) &&
					isset( $response_body['message'] ) ) {
					if ( false !== stripos( $response_body['message'], 'event not found') ) {
						return true;
					}
				}
			}
		}
		return false;
    }

	/**
	 * @return NULL in case of success or an error string in case of error
	 */
    public function update_api_event_fields( WP_Post $post, $api_fields_values ) {
    	$post_id      = $post->ID;
   		$api_event_id = get_post_meta(
			$post_id,
			self::EVENT_ID_METADATA,
			true
		);
		if ( ! $api_event_id ) {
			return null;
		}
		if ( $this->is_ticket_event_imported( $post_id ) )  {
			return null;
		}
		//updating the event status
		try {
			$event =  $this->_registry->get(
				'model.event',
				$post_id ? $post_id : null
			);
		} catch ( Ai1ec_Event_Not_Found_Exception $excpt ) {
			$message      = __( 'Event not found inside the database.', AI1EC_PLUGIN_NAME );
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( $message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return $message;
		}
		$headers   = $this->_get_headers();
		$body_data = $this->_parse_event_fields_to_api_structure(
			$event,
			$post,
			null, //does not update ticket types, just chaging the api fields specified
			$api_fields_values
		);
		$url       = AI1EC_API_URL . 'events' . '/' . $api_event_id;
		$request   = array(
			'method'  => 'POST',
			'headers' => $headers,
			'body'    => json_encode( $body_data ),
			'timeout' => parent::DEFAULT_TIMEOUT
		);
		$response      = wp_remote_request( $url, $request );
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $response_code ) {
			if ( $this->_is_event_notfound_error( $response_code, $response ) ) {
				if ( isset( $api_fields_values['status'] ) &&
					'trash' === $api_fields_values['status'] ) {
					//this is an exception, the event was deleted on API server, but for some reason
					//the metada EVENT_ID_METADATA was not unset, in this case leave the event be
					//move to trash
					return null;
				}
			}
			$message      = $this->_transform_error_message( $this->_update_event_error, $response, $url, true );
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( $message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return $message;
        } else {
        	return null;
        }
    }

    /**
     * Deletes the API event
     * @return NULL in case of success or an error string in case of error
     */
    public function delete_api_event( $post_id ) {
    	if ( $this->is_ticket_event_imported( $post_id ) )  {
    		$this->clear_event_metadata( $post_id );
    		return null;
    	}
    	$api_event_id = get_post_meta(
			$post_id,
			self::EVENT_ID_METADATA,
			true
		);
		if ( ! $api_event_id ) {
			return null;
		}
		$request   = array(
			'method'  => 'DELETE',
			'headers' => $this->_get_headers(),
			'timeout' => parent::DEFAULT_TIMEOUT
		);
		$url           = AI1EC_API_URL . 'events/' . $api_event_id;
		$response      = wp_remote_request( $url, $request );
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 === $response_code ) {
			$this->clear_event_metadata( $post_id );
			return null;
        } else {
			if ( $this->_is_event_notfound_error( $response_code, $response ) ) {
				//this is an exception, the event was deleted on API server, but for some reason
				//the metada EVENT_ID_METADATA was not unset, in this case leave the event be
				//move to trash
				return null;
			}
        	$message      = $this->_transform_error_message( 
        		__( 'We were unable to remove the Tickets from Time.ly Ticketing', AI1EC_PLUGIN_NAME ), 
        		$response, 
        		$url, 
        		true 
        	);
			$notification = $this->_registry->get( 'notification.admin' );
			$notification->store( $message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
			return $message;
        }
    }

    /**
     * Clear the event metadata used by Event from the post id
     */
    public function clear_event_metadata( $post_id ) {
		delete_post_meta( $post_id, self::EVENT_ID_METADATA );
		delete_post_meta( $post_id, self::THUMBNAIL_ID_METADATA );
		delete_post_meta( $post_id, self::ICS_CHECKOUT_URL_METADATA );
		delete_post_meta( $post_id, self::ICS_API_URL_METADATA );
    }

    public function create_checkout_url( $api_event_id , $url_checkout = AI1EC_TICKETS_CHECKOUT_URL) {
    	return str_replace( '{event_id}', $api_event_id, $url_checkout );
    }

}