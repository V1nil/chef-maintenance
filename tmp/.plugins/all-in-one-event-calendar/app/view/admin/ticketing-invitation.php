<?php

/**
 * Tickets page.
 *
 * @author     Time.ly Network Inc.
 * @since      2.3
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_View_Admin_Ticketing_Invitation extends Ai1ec_View_Admin_Abstract {
    /**
     * @var string The id/name of the submit button.
     */
    const SUBMIT_ID = 'ai1ec_ticketing_invitation';
    /**
     * @var string The nonce action
     */
    CONST NONCE_ACTION = 'ai1ec_ticketing_invitation_save';
    /**
     * @var string The nonce name
     */
    CONST NONCE_NAME = 'ai1ec_ticketing_invitation_nonce';

    /**
     * Adds the page to the correct menu.
     */
    public function add_page() {
        $ticketing_invitation_page = add_submenu_page(
            null,
            Ai1ec_I18n::__( 'Invitation' ),
            Ai1ec_I18n::__( 'Invitation' ),
            'manage_ai1ec_options',
            AI1EC_PLUGIN_NAME . '-invitation',
            array( $this, 'display_page' )
        );
        $this->_registry->get( 'model.settings' )
                        ->set( 'enabling_ticket_invitation_page', $ticketing_invitation_page );
    }

    /**
     * Adds the page to the correct menu.
     */
    public function add_meta_box() {
        add_meta_box(
            'ai1ec-ticketing-invitation',
            Ai1ec_I18n::__( 'Ticketing Beta Invitation' ),
            array( $this, 'display_meta_box' ),
            $this->_registry->get( 'model.settings' )->get( 'enabling_ticket_invitation_page' ),
            'left',
            'default'
        );
    }

    /**
     * @param $object
     * @param $box
     *
     * @throws Ai1ec_Bootstrap_Exception
     */
    public function display_meta_box( $object, $box ) {
        $api_settings       = $this->_registry->get( 'helper.api-settings' );
        $invitation_checked = ( $api_settings->ai1ec_api_enabled() ) ? 'checked' : '';
        $args               = array(
            'stacked'               => true,
            'content_class'         => 'ai1ec-form-horizontal',
            'enable_ticketing_text' => Ai1ec_I18n::__( 'Enable Ticketing Beta' ),
            'submit'                => array(
                'id'                => self::SUBMIT_ID,
                'value'             => '<i class="ai1ec-fa ai1ec-fa-save ai1ec-fa-fw"></i> ' .
                                        Ai1ec_I18n::__( 'Save Settings' ),
                'args'              => array(
                    'class'         => 'ai1ec-btn ai1ec-btn-primary ai1ec-btn-lg',
                ),
            ),
            'invitation_chk'        => array(
                'id'                => 'ai1ec_ticketing',
                'name'              => 'ai1ec_ticketing',
                'value'             => '1',
                'checked'           => $invitation_checked,
            ),
        );
        $loader = $this->_registry->get( 'theme.loader' );
        $file   = $loader->get_file( 'ticketing-invitation/manage.twig', $args, true );
        return $file->render();
    }

    /**
     * Display the page html
     */
    public function display_page() {
        $settings = $this->_registry->get( 'model.settings' );
        $args     = array(
            'title'        => Ai1ec_I18n::__( 'Time.ly Ticketing beta' ),
            'nonce'        => array(
                'action'   => self::NONCE_ACTION,
                'name'     => self::NONCE_NAME,
                'referrer' => false,
            ),
            'metabox'    => array(
                'screen' => $settings->get( 'enabling_ticket_invitation_page' ),
                'action' => 'left',
                'object' => null
            ),
            'action'  =>
                ai1ec_admin_url(
                    '?controller=front&action=ai1ec_ticketing_invitation_save&plugin=' .
                    AI1EC_PLUGIN_NAME
                ),
        );
        $loader   = $this->_registry->get( 'theme.loader' );
        $file     = $loader->get_file( 'ticketing-invitation/page.twig', $args, true );
        $this->_registry->get( 'css.admin' )->admin_enqueue_scripts(
            'ai1ec_event_page_all-in-one-event-calendar-settings'
        );
        $this->_registry->get( 'css.admin' )->process_enqueue(
            array(
                array( 'style', 'ticketing.css', ),
            )
        );
        return $file->render();
    }

    /**
     * Handle post, likely to be deprecated to use commands.
     */
    public function handle_post() {
    }
}
