<?php
/**
 * Including CSS  for addmin setting 
 */

if (!class_exists('WbCom_BP_Activity_Filter_Script_Includer')) {
	class WbCom_BP_Activity_Filter_Script_Includer {
		/**
		 * Constructor
		 */
		public function __construct() {
			/**
			 * Adding style for admin settings
			 */
			add_action('admin_enqueue_scripts', array(&$this,'include_admin_css_function'));
			
		}
		
		/**
		 * Adding css files
		 */
		public function include_admin_css_function () {
			// Register and enqueue style
			wp_register_style( 'custom_wp_admin_css', plugins_url('css/bp-activity-filter.css', __FILE__), false, '1.0.0' );
    		
			wp_enqueue_style( 'custom_wp_admin_css' );
        	
		}
		
	}
}
if (class_exists('WbCom_BP_Activity_Filter_Script_Includer')) {
	$script_includer = new WbCom_BP_Activity_Filter_Script_Includer();
}