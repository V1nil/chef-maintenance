<?php
/*
  Plugin Name: BuddyPress Activity Filter
  Plugin URI: https://wbcomdesigns.com/plugins/buddypress-activity-filter/
  Description: Admin can set default and customized activities to be listed on front-end
  Version: 1.0.2
  Text Domain: bp-activity-filter
  Author: Wbcom Designs<admin@wbcomdesigns.com>
  Author URI: http://www.wbcomdesigns.com/
  License: GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    wp_die('Direct Access is not Allowed');
}

/**
 *  Checking for buddypress whether it is active or not
 */
function check_required_plugin_is_activated() {
    if (is_multisite()) {
        if (!is_plugin_active_for_network('buddypress/bp-loader.php') && !is_plugin_active('buddypress/bp-loader.php')) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('The <b>BuddyPress Activity Filter</b> plugin requires <b>Buddypress</b> plugin to be installed and active. Return to <a href="' . admin_url('plugins.php') . '">Plugins</a>', 'bp-activity-filter'));
        }
    } else {
        if (!in_array('buddypress/bp-loader.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('The <b>BuddyPress Activity Filter</b> plugin requires <b>Buddypress</b> plugin to be installed and active. Return to <a href="' . admin_url('plugins.php') . '">Plugins</a>', 'bp-activity-filter'));
        }
    }
}

register_activation_hook(__FILE__, 'check_required_plugin_is_activated');
/**
 * Defining class WbCom_BP_Activity_Filter is not exist
 */
if (!class_exists('WbCom_BP_Activity_Filter')) {

    class WbCom_BP_Activity_Filter {

        /**
         * Constructor
         */
        public function __construct() {
            /**
             * Adding text domain
             */
            $this->bp_activity_filter_load_textdomain();

            /**
             * Adding setting link on plugin listing page
             */
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'bp_activity_filter_plugin_actions'), 10, 2);

            /**
             * Including scripts files for admin setting
             */
            require_once plugin_dir_path(__FILE__) . 'admin/class-bp-activity-filter-admin-script-includer.php';

            /**
             * Including file for admin setting
             */
            require_once plugin_dir_path(__FILE__) . 'admin/class-bp-activity-filter-admin-setting.php';

            /**
             * Including file for saving admin setting
             */
            require_once plugin_dir_path(__FILE__) . 'admin/class-bp-activity-filter-admin-setting-save.php';

            /**
             * Including file for dropdown option filter setting on front-end
             */
            require_once plugin_dir_path(__FILE__) . 'templates/class-bp-activity-filter-dropdown.php';

            /**
             * Including file for dropdown option filter setting on front-end
             */
            require_once plugin_dir_path(__FILE__) . 'templates/class-bp-activity-filter-query.php';
        }

        //Load plugin textdomain.
        public function bp_activity_filter_load_textdomain() {
            $domain = "bp-activity-filter";
            $locale = apply_filters('plugin_locale', get_locale(), $domain);
            load_textdomain($domain, 'languages/' . $domain . '-' . $locale . '.pot');
            $var = load_plugin_textdomain($domain, false, plugin_basename(dirname(__FILE__)) . '/languages');
        }

        /**
         * @desc Adds the Settings link to the plugin activate/deactivate page
         */
        public function bp_activity_filter_plugin_actions($links, $file) {
            $settings_link = '<a href="' . admin_url("admin.php?page=bp-settings#bp_activity_filter") . '">' . __('Settings', 'bp-activity-filter') . '</a>';
            array_unshift($links, $settings_link); // before other links
            return $links;
        }

    }

}

if (class_exists('WbCom_BP_Activity_Filter')) {
    $GLOBALS['activity_filter'] = new WbCom_BP_Activity_Filter();
}
