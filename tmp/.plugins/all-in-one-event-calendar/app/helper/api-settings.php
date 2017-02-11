<?php

/**
 * Model used for storing/retrieving api settings.
 *
 * @author     Time.ly Network, Inc.
 * @since      2.3
 * @package    Ai1EC
 * @subpackage Ai1EC.Model
 */
class Ai1ec_Api_Settings extends Ai1ec_Settings {

    /**
     * Set new values for the API ticketing variables.
     * Those values are gonna be persisted in the wordpress db
     * in the table wp_options at the column option_name.
     *
     * @param boolean $status the new ticketing status value.
     */

    public function ai1ec_setting_up_api_flags( $status ) {

        $settings = $this->_registry->get( 'helper.api-settings' );
        $settings->set( 'ai1ec_api', $status );
    }

    /**
     * Get the current status of the API ticketing variables.
     *
     * @return boolean with the result combination of the two boolean
     * variables ai1ec_api_ticketing and ai1ec_api.
     */

    public function ai1ec_api_enabled() {

        $settings = $this->_registry->get( 'helper.api-settings' );
        $api      = $settings->get( 'ai1ec_api' );
        return $api;
    }

}
