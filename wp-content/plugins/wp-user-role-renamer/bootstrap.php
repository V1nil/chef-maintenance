<?php 
/**
 * Plugin Main File
 *
 * @link https://wordpress.org/plugins/wp-user-role-renamer
 * @package WP-User-Role-Renamer
 * @subpackage WP-User-Role-Renamer/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }
 
class wp_user_role_renamer {
	public $version = '1.1';
	public $plugin_vars = array();
	
	protected static $_instance = null; # Required Plugin Class Instance
    protected static $functions = null; # Required Plugin Class Instance
	protected static $admin = null;     # Required Plugin Class Instance
	protected static $settings = null;  # Required Plugin Class Instance

    /**
     * Creates or returns an instance of this class.
     */
    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    
    /**
     * Class Constructor
     */
    public function __construct() {
        $this->define_constant();
        $this->load_required_files();
        $this->init_class();
        add_action('plugins_loaded', array( $this, 'after_plugins_loaded' ));
        add_filter('load_textdomain_mofile',  array( $this, 'load_plugin_mo_files' ), 10, 2);
    }
	
	/**
	 * Throw error on object clone.
	 *
	 * Cloning instances of the class is forbidden.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cloning instances of the class is forbidden.', WP_URR_TXT), WP_URR_V );
	}	

	/**
	 * Disable unserializing of the class
	 *
	 * Unserializing instances of the class is forbidden.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of the class is forbidden.',WP_URR_TXT), WP_URR_V);
	}

    /**
     * Loads Required Plugins For Plugin
     */
    private function load_required_files(){
       $this->load_files(WP_URR_INC.'class-*.php');

        
       if(wp_urr_is_request('admin')){
           $this->load_files(WP_URR_ADMIN.'class-*.php');
       } 

    }
    
    /**
     * Inits loaded Class
     */
    private function init_class(){
        self::$functions = new wp_user_role_renamer_Functions;

        if(wp_urr_is_request('admin')){
            self::$admin = new wp_user_role_renamer_Admin;
        }
    }
    
	# Returns Plugin's Functions Instance
	public function func(){
		return self::$functions;
	}
	
	# Returns Plugin's Settings Instance
	public function settings(){
		return self::$settings;
	}
	
	# Returns Plugin's Admin Instance
	public function admin(){
		return self::$admin;
	}
    
    /**
     * Loads Files Based On Give Path & regex
     */
    protected function load_files($path,$type = 'require'){
        foreach( glob( $path ) as $files ){
            if($type == 'require'){ require_once( $files ); } 
			else if($type == 'include'){ include_once( $files ); }
        } 
    }
    
    /**
     * Set Plugin Text Domain
     */
    public function after_plugins_loaded(){
        load_plugin_textdomain(WP_URR_TXT, false, WP_URR_LANGUAGE_PATH );
    }
    
    /**
     * load translated mo file based on wp settings
     */
    public function load_plugin_mo_files($mofile, $domain) {
        if (WP_URR_TXT === $domain)
            return WP_URR_LANGUAGE_PATH.'/'.get_locale().'.mo';

        return $mofile;
    }
    
    /**
     * Define Required Constant
     */
    private function define_constant(){
        $this->define('WP_URR_NAME', 'WP User Role Renamer'); # Plugin Name
        $this->define('WP_URR_SLUG', 'wp-user-role-renamer'); # Plugin Slug
        $this->define('WP_URR_TXT',  'wp-user-role-renamer'); #plugin lang Domain
		$this->define('WP_URR_DB', 'wp_urr_');
		$this->define('WP_URR_V',$this->version); # Plugin Version
		
		$this->define('WP_URR_LANGUAGE_PATH',WP_URR_PATH.'languages'); # Plugin Language Folder
		$this->define('WP_URR_ADMIN',WP_URR_INC.'admin/'); # Plugin Admin Folder
		$this->define('WP_URR_SETTINGS',WP_URR_ADMIN.'settings/'); # Plugin Settings Folder
		
		$this->define('WP_URR_URL',plugins_url('', __FILE__ ).'/');  # Plugin URL
		$this->define('WP_URR_CSS',WP_URR_URL.'includes/css/'); # Plugin CSS URL
		$this->define('WP_URR_IMG',WP_URR_URL.'includes/img/'); # Plugin IMG URL
		$this->define('WP_URR_JS',WP_URR_URL.'includes/js/'); # Plugin JS URL
    }
	
    /**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
    protected function define($key,$value){
        if(!defined($key)){
            define($key,$value);
        }
    }
    
}