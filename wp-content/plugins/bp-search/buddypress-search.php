<?php
/*
 Plugin Name: Buddypress Search
Plugin URI:   https://tomas.zhu.bz/buddypress-angularjs-search-plugin/
Description: Buddypress Search is  a fast and light member search plugin to help users search member more quick and do not need click submit button to refresh the BP members page, when users typed members name, we will show related members instantly in a drop-down member list, it drived by AngularJS.
Version: 1.1
Author: Tomas Zhu
Author URI: http://tomas.zhu.bz
Text Domain: tomas-buddypress-search
License: GPLv3 or later
*/
/*  Copyright 2016 Tomas Zhu
 This program comes with ABSOLUTELY NO WARRANTY;
https://www.gnu.org/licenses/gpl-3.0.html
https://www.gnu.org/licenses/quick-guide-gplv3.html
*/

defined( 'ABSPATH' ) || exit;

function tomas_load_angularjs()
{
	wp_register_script('tomas_load_angular', plugins_url('asset/js/angular.min.js', __FILE__));
	wp_register_script('tomas_load_angular_animate', plugins_url('asset/js/angular-animate.min.js', __FILE__));
	wp_register_script('tomas_load_scripts', plugins_url('asset/js/script.js', __FILE__));

	wp_enqueue_script('tomas_load_angular');
	wp_enqueue_script('tomas_load_angular_animate');
	wp_enqueue_script('tomas_load_scripts');
}

add_action('wp_enqueue_scripts', 'tomas_load_angularjs');

function tomas_angularjs_member_search_form()
{
	?>
    <div ng-app="tomas_bp_member_seach_app">
        <div ng-controller="tomas_bp_member_search_controller">
			<form action="" method="get" id="search-members-form">
				<label for="members_search"><input ng-model="members_query" type="text" name="members_search" id="members_search" placeholder="Search Members..." /></label>
				<input type="submit" id="members_search_submit"  name="members_search_submit" value="Search" />
			</form>

            <div id="tomas_bp_member_search_hidden_popup_window" ng-show="members_query" style="    background-color: #f1f1f1;    padding: 16px;    max-height: 200px;    overflow-y: scroll;">
                <div class="tomas_bp_member_search_result">
                    <h5>{{(members|filter:members_query).length}} Members found :</h5>
                    <div ng-animate="'animate'" ng-repeat="member in members | filter:members_query">
                        <div>
                            <a ng-href="{{member.link}}">
                                {{member.title}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
	<?php
}

function tomas_bp_better_search()
{
	$search_form = tomas_angularjs_member_search_form();
	return $search_form;
}


add_filter('bp_directory_members_search_form', 'tomas_bp_better_search');


function tomas_angularjs_member_search_api()
{
	if ($_SERVER[REQUEST_URI] == '/tomasapi/bpmembersearch')
	{
		$tomasApiMmbersArray=array();
		$tomas_bp_member_query = array('per_page' => '2000' ); 
		if ( bp_has_members( $tomas_bp_member_query ) ) :
			while ( bp_members() ) : bp_the_member();
				$memberItem= array();
	            $memberItem['title']=bp_get_member_name();
	            $memberItem['link']=esc_url( bp_get_member_permalink() );
	            $tomasApiMmbersArray[] = $memberItem;
			endwhile;
		endif;	
	
	        header('Content-Type: application/json');
	        print_r(json_encode($tomasApiMmbersArray));
	        die;
	    }	
}

add_action('bp_init','tomas_angularjs_member_search_api');
