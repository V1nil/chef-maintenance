=== WP Featured Users By Scripty Team  ===
Contributors: scriptyteam
Donate link: http://scriptyteam.com/
Tags: users, user, features, favorites, star,
Requires at least: 3.0.1
Tested up to: 4.6.1
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add featured users option by adding star column in Users list table.

== Description ==

Allows the administrator to make featured users by adding star column in Users list table and checkbox field in Edit User Profile Page.
You can retrieve the featured users using User Meta "wpfui2i_featured_user" or the shortcode [list_featured_users].
Also you can use custome shortcode by add "fileds" and "output" parameters,
i.e. [list_featured_users output="array" fields="ID,user_email"] 
	 [list_featured_users output="table" fields="display_name"]

Shortcode Parameters:

Output:
-table:default   To dispaly the autput as table,We added Classes to customize this table easily by CSS.
-array:			 To display the output as PHP array,this useful for php developers.

fields:
-by default,It will display (ID,user_login,display_name,user_email),you can choose some of them not all

* We added many WP filters to help the developers to add their custom functinallilty without thouching the plugin code
i.e.
	- "wpfui2i_featured_user_img","wpfui2i_not_featured_user_img" filters to customize the star image in the users 			table list.
	-"wpfui2i_get_users_args":To add more args for get_users() function.
	-"wpfui2i_featured_array":To edit the output array.
	-"wpfui2i_print_table":To edit the output table.
	-"wpfui2i_no_featured_message":To edit "No featured Users" meassage.




== Installation ==


1. Upload the plugin files to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Add features users from WP List Users Page in Admin Dashboard.
3. Use [list_featured_users] to display the results.



== Frequently Asked Questions ==


= How Can I assighn user as featured? =

From WP List Users Page in Admin Dashboard.

= How Can I use the shortcode =

You can use "[list_featured_users]" shortcode by pasting it in any page content.
i.e. [list_featured_users output="array" fields="ID,user_email"] 
	 [list_featured_users output="table" fields="display_name"] 

== Screenshots ==

1. WP List Users Table
2. Edit User Page
3. Results as Table