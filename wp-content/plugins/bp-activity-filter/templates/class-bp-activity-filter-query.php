<?php
/**
 * Defining class for Filtering activity stream
 */
if (!class_exists('WbCom_BP_Activity_Filter_Activity_Stream')) {
	class WbCom_BP_Activity_Filter_Activity_Stream {	
		/**
		 * Constructor
		 */
		public function __construct() { 
			/**
			 * Filtering activity stream
			 */			
			add_filter('bp_ajax_querystring', array(&$this, 'filtering_activity_default'), 999, 1);
		}
		/**
		 * Modyfying activity loop for default acitvity
		 * @param $retval
		 */
		public function filtering_activity_default($query) {
		
			if (empty($_POST)) {
				$defult_activity_stream = bp_get_option('bp-default-filter-name');	
					
				if ($defult_activity_stream != -1)					
					$query = 'action=' . $defult_activity_stream;
			 }
			 return $query;
		}
	}
}
if (class_exists('WbCom_BP_Activity_Filter_Activity_Stream')) {
	$filter_query_obj = new WbCom_BP_Activity_Filter_Activity_Stream();
}