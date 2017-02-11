<?php
/**
 * @package Gator Cache
 * @version 2.0.11
 */
/*
Plugin Name: Gator Cache
Plugin URI: http://wordpress.org/plugins/gator-cache/
Description: A Better, Stronger, Faster WordPress Cache Plugin. Easy to install and manage.
Author: GatorDev
Author URI: http://www.gatordev.com/
Text Domain: gatorcache
Domain Path: /lang
Version: 2.0.11
*/
class WpGatorCache
{
    protected static $defaults = array(
        'installed' => false,
        'enabled' => false,
        'oc_enabled' => false,
        'debug' => true,
        'lifetime' => array('value' => '2', 'unit' => 'week', 'sec' => 1209600),
        'post_types' => array('product'),
        'exclude_paths' => array(),
        'refresh_paths' => array('all' => array()),
        'app_support' => array(),
        'roles' => array(),
        'refresh' => array('home' => true, 'archive' => true, 'all' => false),
        'pingback' => false,
        'skip_ssl' => true,
        'version' => false,
        'multisite_paths' => false,
        'enable_hooks' => false,
        'jp_mobile_cache' => false,
        'cache_warm' => false,
        'skip_feeds' => false,
        'sys_load' => 0,
        'mobile' => array('phone' => false, 'tablet' => false, 'mobile' => false, 'ios' => false, 'android' => false),
    );

    protected static $options;
    protected static $path;
    protected static $configPath;
    protected static $post;
    protected static $refresh = false;
    protected static $sslHandler; // specific handler for WordPressHTTPS
    protected static $obHandlers = array(); // array of generic handlers for other ob handlers that have started before GatorCache
    protected static $webUser;
    protected static $multiSiteData;
    const PREFIX = 'gtr_cache';
    const VERSION = '2.0.11';
    const JP_MOBILE_MOD = 'minileven'; // JetPack mobile module slug
    const SUPPORT_LINK = 'https://wordpress.org/support/plugin/gator-cache';

    public static function initBuffer()
    {
        $options = self::getOptions();
        $request = GatorCache::getRequest();
        global $post;
        if (!$options['enabled']
          || '.php' === ($ext = substr($path = $request->getPathInfo(), -4)) || '.txt' === $ext || '.xml' === $ext //uri returns the whole qs
          || (defined('DONOTCACHEPAGE') && DONOTCACHEPAGE)
          || !isset($post)
          || ($options['skip_feeds'] && is_feed())
          || 'GET' !== $request->getMethod()
          || $request->hasQueryString()
          || ('post' !== $post->post_type && 'page' !== $post->post_type && !in_array($post->post_type, self::getCacheTypes()))
          || (defined('DOING_AJAX') && DOING_AJAX) || is_admin()
          || (is_user_logged_in() && (!$options['enable_hooks'] || !self::cacheUserContent()))
          || '' === get_option('permalink_structure')
          || self::hasPathExclusion($path)
          || self::isWooCart()
          || isset($_COOKIE['comment_author_' . COOKIEHASH])
          || (self::isJetPackMobileSite() && !$options['jp_mobile_cache'])
          //|| ($options['enable_hooks'] && apply_filters('gc_skip_cache', false))
          //|| (false !== $options['multisite_paths'] && self::isMultiSubPath($path))
          || (($isSecure = $request->isSecure()) && $options['skip_ssl'])
         ) {
            return;
        }
        // check for compatiblity with plugins that modify output from buffers added before this
        self::checkObHandlers($isSecure);
        ob_start('WpGatorCache::onBuffer');
    }

    public static function onBuffer($buffer, $phase)
    {
        if (empty($buffer) || is_404() || !self::responseOk()) {
            //do not cache
            return $buffer;
        }
        $options = self::getOptions();
        if (false === ($config = GatorCache::getConfig(self::$configPath, true))) {
            //check config is loaded
            return;
        }
        $group = $config->get('group');
        $cache = GatorCache::getCache($opts = $config->toArray());//jpmobile group is set in advanced-cache.php
        if ($options['debug']) {
            global $post;
            $buffer .= ($debugMsg = "\n" . '<!-- Gator Cached ' . $post->post_type . (isset(self::$sslHandler) ? ' via ' . self::$sslHandler : '') . ' on [' . gmdate('Y-m-d H:i:s', time() + (get_option('gmt_offset') * 3600)) . '] -->');
        } else {
            $debugMsg = '';
        }
        $request = GatorCache::getRequest();
        if (!$cache->has($path = $request->getPathInfo(), $opts['group'])) {
            if (isset(self::$sslHandler) && false !== ($replace = self::doHttpsHandler($buffer))) {
                $buffer = $replace;
            }
            if (!empty(self::$obHandlers)) {
                $buffer = self::doObHandlers($buffer, $debugMsg);
            }
            $result = $cache->save($path, $buffer, $request->isSecure() ? 'ssl@' . $opts['group'] : $opts['group']);//return $result;
        }
        return $buffer;
    }

    public static function chkUser($cookie_elements, $user)
    {
        if (!defined('GC_CHK_USER') || is_admin()) {
            return;
        }
        $options = self::getOptions();
        if (!$options['enabled'] || empty($user->roles) || 1 < count($user->roles)) {
            //no cache for mult user roles, this indicates custom role such as bbpress
            return;
        }
        $cacheme = array_intersect($options['roles'], (array)$user->roles);
        if (!empty($cacheme)) {
            //serve the cache
            include(WP_CONTENT_DIR . '/advanced-cache.php');
        }
    }

    public static function Activate()
    {
        $options = self::getOptions();
        if (!$options['installed']) {
            //install will handle this
            return;
        }
        //check config and advance cache
        if (!self::saveWpConfig() || !self::copyAdvCache()) {
            $wpConfig = GatorCache::getOptions(self::PREFIX . '_opts');
            $wpConfig->set('installed', false);
            $wpConfig->set('enabled', false);
            $wpConfig->write();
        }
    }

    public static function Deactivate()
    {
        //purge the cache
        self::getOptions();
        GatorCache::purgeCache(self::$configPath);
        //update wp-cache setting in wp-config.php
        if (self::saveWpConfig(false)) {
            //remove the advanced cache file
            @unlink(WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'advanced-cache.php');
        }
    }

    public static function checkUpgrade()
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }
        $options = self::getOptions();
        if (!$options['installed']) {
            return;
        }
        //1.0 > 1.11 store the version and move the config file
        if (self::VERSION !== $options['version']) {
            $version = (float)$options['version'];
            $wpConfig = GatorCache::getOptions(self::PREFIX . '_opts');
            if (1.56 > $version) {
                self::copyAdvCache();
                $config = GatorCache::getConfig(self::$configPath);
                $config->set('jp_mobile', self::isJetPackMobile(false));
                $config->set('jp_mobile_cache', false);
                $config->write();
            }
            if (1.57 > $version) {
                self::copyAdvCache();
                self::setContentTypes(GatorCache::getConfig(self::$configPath));
            }
            if (1 === version_compare('2.0.8', $options['version'])) {
                //latest version should copy this
                self::copyAdvCache();
            }
            if (1 === version_compare('2.0.9', $options['version'])) {
                //initialize cache warm variable
                $config = GatorCache::getConfig(self::$configPath);
                if (!$config->has('cache_warm')) {
                    $config->save('cache_warm', false);
                }
            }
            //upgrades done or nothing to upgrade, update the version
            $wpConfig->set('version', self::$options['version'] = self::VERSION);
            $wpConfig->write();
        }
        /*if(is_multisite() && !is_subdomain_install() && is_main_site(get_current_blog_id()) && !is_plugin_active_for_network(self::$path, 'gator-cache.php')){
            add_filter('wpmu_signup_blog_notification', 'WpGatorCache::newMpmuSite', 10, 2);
        }*/
    }

/**
 * newMpmuSite
 *
 * If the plugin is not active for the network, add subsite paths not
 * to be cached
 *
 * @note: need the blog id, not sure if it's passed here
 */
    public static function newMpmuSite($domain, $path)
    {
        /*$options = self::getOptions();
        GatorCache::getOptions(self::PREFIX . '_opts', self::$defaults);*/
        return true;
    }

    public static function addOptMenu()
    {
        if (current_user_can('install_plugins')) {
            add_menu_page('Gator Cache', 'Gator Cache', 'edit_posts', self::PREFIX, 'WpGatorCache::renderMenu', 'dashicons-performance', '76.5');
        }
    }

    public static function renderMenu()
    {
        $options = self::getOptions();
        //var_dump($options);
        if (!self::verifyInstall()) {
            //new install or corrupted install
            include self::$path . 'tpl/install.php';
            return;
        }
        $config = GatorCache::getConfig(self::$configPath);
        include  self::$path . 'tpl/options.php';
    }

    public static function settingsLink($links)
    {
        $links[] = '<a href="' . admin_url('admin.php?page=' . self::PREFIX) .'">Settings</a>';
        $links[] = '<a href="' . self::SUPPORT_LINK . '" target="_blank">Support</a>';
        return $links;
    }

    public static function addToolbarButton()
    {
        global $wp_admin_bar;
        if (!isset($wp_admin_bar) || !current_user_can('install_plugins')) {
            return;
        }
        $options = self::getOptions();
        if (!$options['installed']) {
            return;
        }
        $wp_admin_bar->add_node(array(
            'id'    => 'gc-purge',
            'title' => '<span class="ab-icon dashicons-hammer" style="padding-top:5px"></span> <span class="ab-label">Purge Cache</span>',
            'href'  => admin_url() . '?page=' . self::PREFIX . '#tab-debug',
            'meta' => array(
                'class' => 'ab-item purge-cache',
                'title' => 'Gator Cache Purge'
            )
        ));
    }

    public static function loadAdminJs($context)
    {
        if ('toplevel_page_gtr_cache' !== $context) {
            return;
        }
        if (wp_script_is('chosen', 'registered')) {
            //make sure the correct version of chosen is registered
            wp_deregister_script('chosen');
        }
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-selectable');
        wp_enqueue_script('chosen', ($pluginUrl = plugins_url(null, __FILE__)) . '/js/chosen.jquery.min.js', array('jquery'), '0.9.8', true);
        wp_enqueue_script('gator-cache', $pluginUrl . '/js/gator-cache.min.js', array('jquery-ui-tabs'), self::VERSION, true);
        wp_enqueue_style('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/redmond/jquery-ui.css', array(), null);
        wp_enqueue_style('chosen', $pluginUrl . '/css/chosen.css', array(), '0.9.8');
        wp_enqueue_style('gator-cache', $pluginUrl . '/css/gator-cache.css', array(), self::VERSION);
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), null);
        // remove any annoying admin notices that are unrelated to the GatorCache dash
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
        // remove pesky woocommerce notices from our lovely dashboard
        if (defined('WOOCOMMERCE_VERSION') && class_exists('WC_Admin_Notices', false)) {
            global $wp_filter;
            $wp_filter['admin_print_styles'][10] = array_filter($wp_filter['admin_print_styles'][10], 'WpGatorCache::filterNotices');
        }
    }

    public static function filterNotices($callback)
    {//static instead of anonymous function WP still supports php 5.2
        return !is_array($callback['function']) || !($callback['function'][0] instanceof WC_Admin_Notices);
    }

    public static function filterCacheUpdate($v)
    {
        return null !== $v;
    }

    public static function pingSetting($whitelist_options)
    {
        if (isset($_POST['option_page']) && 'discussion' === $_POST['option_page']) {
            $options = self::getOptions();
            $pingback = isset($_POST['default_ping_status']) && 'open' === $_POST['default_ping_status'];
            if ($pingback !== $options['pingback']) {
                GatorCache::getOptions(self::PREFIX . '_opts')->save('pingback', $pingback);
                GatorCache::getConfig(self::$configPath)->save('pingback', $pingback ? get_bloginfo('pingback_url') : false);
            }
        }
        return $whitelist_options;
    }

    public static function getInitDir($inRoot = false)
    {
        if (null === ($dir = GatorCache::getRequest()->getServer('DOCUMENT_ROOT'))
          && null === ($dir = GatorCache::getRequest()->getServer('PWD'))) {
            $dir = defined(ABSPATH) ? ABSPATH : realpath('./../');
        }
        return ($inRoot ? $dir : dirname($dir)) . DIRECTORY_SEPARATOR . 'gator_cache';
    }

    public static function doInstall()
    {
        if (!current_user_can('edit_posts')) {
            die('0');
        }
        $options = self::getOptions();
        //install create cache dir
        if (is_dir($path = self::getInitDir(false)) || is_dir($path = self::getInitDir(true))) {
            //cache dir already exists
            if (!@is_writable($path)) {
                $error = sprintf(__('Error [101]: Cache Directory [%s] is not writable, please change permissions.', 'gatorcache'), $path);
                GatorCache::getJsonResponse()->setParam('error', $error)->setParam('code', '101')->send();
            }
        } else {
            //create
            $path = self::getInitDir(isset($_POST['ndoc_root']) && '1' === $_POST['ndoc_root']);
            if (false === @mkdir($path, 0755) || !@is_writable($path)) {
                //maybe a reinstall in doc root
                $error = __('Error [100]: Cache Directory could not be created', 'gatorcache');
                GatorCache::getJsonResponse()->setParam('error', $error)->setParam('code', '100')->send();
            }
            // make the object cache
            @mkdir($ocPath = str_replace('/gator_cache', '/gator_cache_oc', $path), 0755);
            //put htaccess here to prevent direct access
            @file_put_contents($path . DIRECTORY_SEPARATOR . '.htaccess', "Order Deny,Allow\nDeny from all\nAllow from env=redirect_gc_green\n");
            @file_put_contents($ocPath . DIRECTORY_SEPARATOR . '.htaccess', "Order Deny,Allow\nDeny from all\n");
        }
        //cache dir created or exists - get the group for subdir support or people that put blogs in the doc root
        if (false === ($url = parse_url($siteurl = get_option('siteurl')))) {
            $error = sprintf(__('Error [105]: Could not parse site url setting [%s], please check WordPress configuration.', 'gatorcache'), $siteurl);
            GatorCache::getJsonResponse()->setParam('error', $error)->send();
        }
        //initial config
        if (!self::copyConfigFile()) {
            $error = sprintf(__('Error [106]: Could not copy config file to your WordPress directory [%s], please check permissions.', 'gatorcache'), ABSPATH);
            GatorCache::getJsonResponse()->setParam('error', $error)->send();
        }
        //multisite support
        if (is_multisite() && !self::checkBlogConfig()) {
            $error = sprintf(__('Error [112]: Could not copy multisite config file to your WordPress directory [%s], please check permissions.', 'gatorcache'), ABSPATH);
            GatorCache::getJsonResponse()->setParam('error', $error)->send();
        }
        if (!self::saveCachePath($path, $url)) {
            //1.42 save host
            $error = sprintf(__('Error [102]: Could not write to config file [%s], please check permissions.', 'gatorcache'), self::$configPath);
            GatorCache::getJsonResponse()->setParam('error', $error)->send();
        }
        //intial setup done, copy advance cache and write to wp config
        if (!self::copyAdvCache()) {
            $error = __('Error [103]: could not copy advance cache php file, please copy manually', 'gatorcache');
            GatorCache::getJsonResponse()->setParam('error', $error)->send();
        }
        if (!self::saveWpConfig()) {
            $error = __('Error [104]: Could not write to your wordpress config file, please change permissions or manually insert WP_CACHE', 'gatorcache');
            GatorCache::getJsonResponse()->setParam('error', $error)->send();
        }
        //Installation complete
        $wpConfig = GatorCache::getOptions(self::PREFIX . '_opts');
        $wpConfig->set('installed', true);
        $wpConfig->set('version', self::VERSION);
        if ('open' === get_option('default_ping_status')) {
            $wpConfig->set('pingback', true);
            GatorCache::getConfig(self::$configPath)->save('pingback', get_bloginfo('pingback_url'));
        }
        $wpConfig->write();
        $msg = __('Gator Cache Successfully Installed', 'gatorcache');
        GatorCache::getJsonResponse()->setParam('msg', $msg)->send(true);
    }

    public static function updateSettings()
    {
        if (!current_user_can('manage_options') || !isset($_POST['action'])) {
            die();
        }
        $options = self::getOptions();
        $update = false;
        $cache = array('lifetime' => null, 'enabled' => null, 'oc_enabled' => null, 'skip_user' => null, 'debug' => null, 'skip_ssl' => null, 'cache_warm' => null, 'mobile' => null, 'sys_load' => null);
        switch ($_POST['action']) {
            case 'gci_crf':
            case 'gci_xrf':
                if (empty($_POST['rf_dir']) || '' === ($dir = trim(wp_kses(stripslashes($_POST['rf_dir']), 'strip')))
                  || '' === $dir = trim(preg_replace('~^/+|/+$~', '', $dir))) {
                    $error = __('Please enter a path name', 'gatorcache');
                    GatorCache::getJsonResponse()->setParam('error', $error)->send();
                }
                $validTypes = get_post_types(array('public'   => true, '_builtin' => false));
                if ('gci_crf' ===$_POST['action'] && (empty($_POST['rf_type']) || ('all' !== ($type = $_POST['rf_type']) && 'bbpress' !== $type && !isset($validTypes[$type])))) {
                    $error = __('Please enter a post type', 'gatorcache');
                    GatorCache::getJsonResponse()->setParam('error', $error)->send();
                }
                $dir = '/' . preg_replace('~\s+~', '-', $dir) . '/';
                $dirKey = false;
                foreach ($options['refresh_paths'] as $typeKey => $paths) {
                    if (false !== ($dirKey = array_search($dir, $paths))) {
                        break;
                    }
                }
                if ('gci_xrf' === $_POST['action']) {
                    if (false !== $dirKey) {
                        unset($options['refresh_paths'][$typeKey][$dirKey]);
                        if ('all' !== $typeKey && empty($options['refresh_paths'][$typeKey])) {
                            unset($options['refresh_paths'][$typeKey]);
                        }
                    }
                } else {
                    if (false !== $dirKey) {
                        $error = __('This path is already added to refresh rules', 'gatorcache');
                        GatorCache::getJsonResponse()->setParam('error', $error)->send();
                    }
                    if (isset($options['refresh_paths'][$type])) {
                        $options['refresh_paths'][$type][] = $dir;
                    } else {
                        $options['refresh_paths'][$type] = array($dir);
                    }
                    if ('bbpress' === $type && !isset($options['app_support']['bbpress'])) {
                        $options['app_support']['bbpress'] = self::getBbPressSupport();
                    }
                }
                $update = true;
            break;
            case 'gci_mcd':
                if (!self::moveCache()) {
                    $msg = __('Error [111]: Could not move your cache directory', 'gatorcache');
                    GatorCache::getJsonResponse()->setParam('error', $msg)->send();
                }
                GatorCache::getJsonResponse()->send(true);
            break;
            case 'gci_dir':
            case 'gci_xex':
                if (empty($_POST['ex_dir']) || '' === ($dir = trim(wp_kses(stripslashes($_POST['ex_dir']), 'strip')))
                  || ('/' !== ($dir = trim($dir)) && '' === ($dir = preg_replace('~^/+|/+$~', '', $dir)))) {
                    $error = __('Please enter a path name', 'gatorcache');
                    GatorCache::getJsonResponse()->setParam('error', $error)->send();
                }
                //if(!filter_var(get_option('siteurl') . ($dir = '/' . preg_replace('~\s+~', '-', $dir) . '/'), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)){}
                $key = array_search($dir = ('/' === $dir) ? '/' : '/' . preg_replace('~\s+~', '-', $dir) . '/', $options['exclude_paths']);
                if ('gci_xex' === $_POST['action']) {
                    if (false !== $key) {
                        unset($options['exclude_paths'][$key]);
                    }
                } else {
                    if (false !== $key) {
                        $error = __('This path is already excluded', 'gatorcache');
                        GatorCache::getJsonResponse()->setParam('error', $error)->send();
                    }
                    $options['exclude_paths'][] = $dir;
                }
                $update = true;
            break;
            case 'gci_del':
                $result = GatorCache::purgeCache(self::$configPath);
                if (!$options['skip_ssl']) {
                    //purge the ssl cache
                    GatorCache::getCache($opts = GatorCache::getConfig(self::$configPath)->toArray())->purge('ssl@' . $opts['group']);
                }
                if ($options['jp_mobile_cache']) {
                    GatorCache::getCache($opts = GatorCache::getConfig(self::$configPath)->toArray())->purge($opts['group'] . '-' . 'jpmobile');
                    if (!$options['skip_ssl']) {
                        GatorCache::getCache($opts = GatorCache::getConfig(self::$configPath)->toArray())->purge('ssl@' . $opts['group'] . '-' . 'jpmobile');
                    }
                }
                if (!$result) {
                    $error = __('Cache is empty', 'gatorcache');
                    GatorCache::getJsonResponse()->setParam('error', $error)->send();
                }
                $msg = __('Cache successfully purged', 'gatorcache');
                GatorCache::getJsonResponse()->setParam('msg', $msg)->send(true);
            break;
            case 'gci_ref':
                $refresh = array(
                    'home'    => isset($_POST['rf_home']) && '1' === $_POST['rf_home'],
                    'archive' => isset($_POST['rf_archive']) && '1' === $_POST['rf_archive'],
                    'all'     => isset($_POST['rf_all']) && '1' === $_POST['rf_all']
                );
                $mobile = $mobileCache = array();
                foreach ($options['mobile'] as $key => $val) {
                    if ($mobile[$key] = isset($_POST['mobile_cache'][$key]) && '1' === $_POST['mobile_cache'][$key]) {
                        $mobileCache[] = $key;
                    }
                }
                if (empty($_POST['sys_load']) || '' === trim($_POST['sys_load']) || !ctype_digit($sys_load = $_POST['sys_load'])) {
                    $sys_load = 0;
                }
                $skip_ssl = !isset($_POST['cache_ssl']) || '1' !== $_POST['cache_ssl'];
                $enable_hooks = isset($_POST['enable_hooks']) && '1' === $_POST['enable_hooks'];
                $jp_mobile_cache = isset($_POST['jp_mobile_cache']) && '1' === $_POST['jp_mobile_cache'];
                $cache_warm = isset($_POST['cache_warm']) && '1' === $_POST['cache_warm'];
                $skip_feeds = !isset($_POST['cache_feeds']) || '1' !== $_POST['cache_feeds'];
                if ($refresh !== $options['refresh'] || $skip_ssl !== $options['skip_ssl'] || $enable_hooks !== $options['enable_hooks']
                  || $jp_mobile_cache !== $options['jp_mobile_cache'] || $cache_warm !== $options['cache_warm'] || $skip_feeds !== $options['skip_feeds']
                  || $mobile != $options['mobile'] || $sys_load !== $options['sys_load']) {
                    $update = true;
                    $options['refresh'] = $refresh;
                    $options['enable_hooks'] = $enable_hooks;
                    $options['skip_ssl'] = $cache['skip_ssl'] = $skip_ssl;
                    $options['jp_mobile_cache'] = $cache['jp_mobile_cache'] = $jp_mobile_cache;
                    $options['cache_warm'] = $cache['cache_warm'] = $cache_warm;
                    $options['skip_feeds'] = $skip_feeds;
                    $options['mobile'] = $mobile;
                    $cache['mobile'] = implode(':', $mobileCache);
                    $options['sys_load'] = $cache['sys_load'] = $sys_load;
                }
            break;
            case 'gci_gen':
                $enabled = isset($_POST['enabled']) && '1' === $_POST['enabled'];
                $ocEnabled = isset($_POST['oc_enabled']) && '1' === $_POST['oc_enabled'];
                if (!isset($_POST['lifetime_val']) || !ctype_digit($value = $_POST['lifetime_val'])) {
                    $value = '0';
                }
                $validUnits = array('hr' => false, 'day' => false, 'week' => false, 'month' => false);
                if (!isset($_POST['lifetime_unit']) || !ctype_alpha($unit = $_POST['lifetime_unit']) || !isset($validUnits[$unit])) {
                    $unit = 'hr';
                }
                if ($value !== $options['lifetime']['value'] || $unit !== $options['lifetime']['unit']) {
                    $update = true;
                    $mult = 'hr' === $unit ? 3600 : ('day' === $unit ? 86400: ('week' === $unit ? 604800 : 2629800));
                    $cache['lifetime'] = '0' === $value ? 0 : $mult * $value;
                    $options['lifetime'] = array('value' => $value, 'unit' => $unit, 'sec' => $cache['lifetime']);
                }
                if ($enabled !== $options['enabled']) {
                    $update = true;
                    $options['enabled'] = $cache['enabled'] = $enabled;
                }
                if ($ocEnabled !== $options['oc_enabled']) {
                    $update = true;
                    $options['oc_enabled'] = $cache['oc_enabled'] = $ocEnabled;
                }
            break;
            case 'gci_usr':
                if (!isset($_POST['gci_roles'])) {
                    $error = __('Roles not specified', 'gatorcache');
                    GatorCache::getJsonResponse()->setParam('error', $error)->send();
                }
                $roles = '' === $_POST['gci_roles'] ? array() : explode(',', $_POST['gci_roles']);
                global $wp_roles;
                if (!isset($wp_roles)) {
                    $wp_roles = new WP_Roles();
                }
                $validRoles = $wp_roles->get_names();
                foreach ($roles as $key => $role) {
                    //for php 5.2 compat array filter not used here
                    if (!isset($validRoles[$role])) {
                        unset($roles[$key]);
                    }
                }
                if ($roles !== $options['roles']) {
                    $update = true;
                    $options['roles'] = $roles;
                    $cache['skip_user'] = !empty($roles);
                }
            break;
            case 'gci_cpt':
                if (!isset($_POST['post_types'])) {
                    $error = __('Post Types not specified', 'gatorcache');
                    GatorCache::getJsonResponse()->setParam('error', $error)->send();
                }
                $types = '' === $_POST['post_types'] ? array() : explode(',', $_POST['post_types']);
                $validTypes = get_post_types(array('public'   => true, '_builtin' => false));
                foreach ($types as $key => $type) {
                    //for php 5.2 compat array filter not used here
                    if ('bbpress' === $type) {
                        if (false !== ($app_support = self::getBbPressSupport())) {
                            //!isset($options['app_support']['bbpress'])
                            $options['app_support']['bbpress'] = $app_support;
                            $update = true;
                        }
                    } elseif (!isset($validTypes[$type])) {
                        unset($types[$key]);
                    }
                }
                if ($types !== $options['post_types']) {
                    $update = true;
                    $options['post_types'] = $types;
                }
            break;
            case 'gci_dbg':
                $debug = isset($_POST['debug']) && '1' === $_POST['debug'];
                if ($debug !== $options['debug']) {
                    $update = true;
                    $options['debug'] = $cache['debug'] = $debug;
                }
            break;
            default:
                $error = __('Invalid Action', 'gatorcache');
                GatorCache::getJsonResponse()->setParam('error', $error)->send();
            break;
        }
        
        if (!$update) {
            die('{"success":"0","error":"Settings were not changed"}');
        }
        $wpConfig = GatorCache::getOptions(self::PREFIX . '_opts');
        $wpConfig->write($options);//update with modified options
        //some options have to be saved to file
        $cache = array_filter($cache, 'WpGatorCache::filterCacheUpdate');//php 5.2 compat
        if (!empty($cache)) {
            $config = GatorCache::getConfig(self::$configPath);
            foreach ($cache as $k => $v) {
                $config->set($k, $v);
            }
            $config->write();
        }
        if ('gci_dir' === $_POST['action']) {
            //include payload for added custom dirs
            GatorCache::getJsonResponse()->setParam('xdir', $dir)->send(true);
        }
        if ('gci_crf' === $_POST['action']) {
            //include payload for added custom dirs
            GatorCache::getJsonResponse()->setParam('xdir', $dir)->setParam('xtype', $type)->send(true);
        }
        GatorCache::getJsonResponse()->send(true);
    }

/**
 * savePost
 *
 * Will invalidate the cache when post is updated
 * @note hooked on transition_post_status, which always fires on add or update
 */
    public static function savePost($new_status, $old_status, $post)
    {
        if (((defined('DOING_AJAX') && DOING_AJAX) && (empty($_POST['action']) || 'inline-save' !== $_POST['action'])) // allow quick edit from ajax
          || '' === $post->post_name
          || (($newPost = 'publish' !== $old_status) && 'publish' !== $new_status)
          || '' === get_option('permalink_structure')) {
            return;
        }

        $options = self::getOptions();
        $postTypes = array('post' => 0, 'page' => 0) + array_flip($options['post_types']);
        if ((isset($postTypes['bbpress']) || isset($options['refresh_paths']['bbpress'])) && isset($options['app_support']['bbpress'])) {
            //bbpress supported - perform ops on child types
            $postTypes = $options['app_support']['bbpress'] + $postTypes;
        }
        if (!$options['enabled'] || self::VERSION !== $options['version'] || !isset($postTypes[$post->post_type])) {
            return;
        }
        $cache = GatorCache::getCache($opts = GatorCache::getConfig(self::$configPath)->toArray());
        //remove post from all cache groups
        $groups = self::getCacheGroups($opts);
        if (!$cache->hasCacheGroups($groups)) {
            //the cache appears to be empty Jim
            return;
        }
        //rss feed, custom post type feeds are not cached since they contain a query string
        if ('post' === $post->post_type && false !== ($path = parse_url(get_feed_link(get_default_feed()), PHP_URL_PATH))) {
            $cache->removeGroups($path, $groups);//purge archive
        }
        //return the same refresh checks for new and updated posts
        if ($options['refresh']['all'] && self::hasRecentWidgets()) {
            //purge cache so sidebar widgets refresh @note could refine by post type 'post' === $post->post_type &&
            $cache->purgeGroups($groups);
            return self::$refresh = true;
        }
        //refresh parent posts and the current post
        foreach (($posts = self::getRefreshPosts($post, $newPost)) as $postId) {
            if (false !== ($path = parse_url(get_permalink($postId), PHP_URL_PATH))) {
                $cache->removeGroups($path, $groups, true);
            }
        }
        //refresh home page
        if ($options['refresh']['home']) {
            //refresh the home page
            $options['refresh_paths']['all'][] = DIRECTORY_SEPARATOR;
        }
        //refresh custom paths
        if (!empty($options['refresh_paths'])) {
            if (!empty($options['refresh_paths']['all'])) {
                foreach ($options['refresh_paths']['all'] as $refreshPath) {
                    $cache->removeGroups($refreshPath, $groups);
                }
            }
            if (isset($options['app_support']['bbpress']) && !empty($options['refresh_paths']['bbpress'])
              && isset($options['app_support']['bbpress'][$post->post_type])) {
                foreach ($options['refresh_paths']['bbpress'] as $refreshPath) {
                    $cache->removeGroups($refreshPath, $groups);
                }
            }
            if (!empty($options['refresh_paths'][$post->post_type])) {
                foreach ($options['refresh_paths'][$post->post_type] as $refreshPath) {
                    $cache->removeGroups($refreshPath, $groups);
                }
            }
        }
        //refresh archive pages for this post or the last parent
        if (!$options['refresh']['archive']) {
            return self::$refresh = true;
        }
        if (isset(self::$post)) {
            //bbpress
            if (false !== ($link = get_post_type_archive_link(self::$post->post_type))
              && false !== ($path = parse_url($link, PHP_URL_PATH))) {
                $cache->removeGroups($path, $groups);
            }
            return self::$refresh = true;
        }
        //taxonomy archive
        if (false !== ($terms = self::getArchiveTerms($post))) {
            foreach ($terms as $term) {
                if (is_wp_error($termLink = get_term_link($term, $term->taxonomy))) {
                    continue;
                }
                if (false !== ($path = parse_url($termLink, PHP_URL_PATH))) {
                    $cache->removeGroups($path, $groups);//purge archive
                }
                //this is not necessary since the category feed is under the category directory which has already been removed
                /*if(false !== ($path = parse_url(get_term_feed_link($term->term_id, $term->taxonomy, get_default_feed()), PHP_URL_PATH))){
                    $cache->remove($path, $opts['group']);//purge archive feed, this will purge all feed types since the default is the top level
                }*/
            }
        }
        //woocommerce shop
        if ('product' === $post->post_type && false !== ($link = get_permalink(woocommerce_get_page_id('shop')))
          && false !== ($path = parse_url($link, PHP_URL_PATH))) {
            $cache->removeGroups($path, $groups);
        }
        self::$refresh = true;
    }

    public static function getArchiveTerms($post)
    {
        $taxonomies = array_map('WpGatorCache::mapTaxonomies',
            get_object_taxonomies($post, 'objects')
            //array_filter(get_object_taxonomies($post, 'objects'), 'WpGatorCache::filterTaxonomies')
        );
        if (empty($taxonomies)) {
            return false;
        }
        $terms = wp_get_object_terms(array($post->ID), $taxonomies);//array_values($taxonomies)
        if (empty($terms)) {
            return false;
        }
        return $terms;
    }

    public static function mapTaxonomies($taxonomy)
    {
        return $taxonomy->name;
    }

    public static function filterTaxonomies($taxonomy)
    {
        return $taxonomy->hierarchical;
    }

    public static function savePostContext($location)
    {
        if (self::$refresh) {
            $location = add_query_arg('gtrcached', 1, $location);
        }
        return $location;
    }

    public static function savePostMsg($messages)
    {
        if (isset($_GET['gtrcached'])) {
            $options = self::getOptions();
            if (!$options['enabled']) {
                return $messages;
            }
            $extra = __(' (GatorCache refreshed)', 'gatorcache');
            $messages['post'][1] .=  $extra;
            $messages['page'][1] .= $extra;
            foreach ($options['post_types'] as $type) {
                if (isset($messages[$type])) {
                    $messages[$type][1] .= $extra;
                }
            }
        }
        return $messages;
    }

    public static function postComment($id, $comment = null)
    {
        if (!isset($comment)) {
            $comment = get_comment($id);
        }
        if ($comment->comment_approved) {
            self::saveComment('approved', 'any', $comment);
        }
    }

    public static function saveComment($new_status, $old_status, $comment)
    {
        if ('approved' !== $new_status && 'approved' !== $old_status) {
            //will not change page
            return;
        }
        if (null === ($path =  parse_url(get_permalink($comment->comment_post_ID), PHP_URL_PATH))) {
            return;
        }
        $options = self::getOptions();
        GatorCache::getCache(
            $opts = GatorCache::getConfig(self::$configPath)->toArray()
        )->removeGroups($path, $groups = self::getCacheGroups($opts));
        //purge the feed
        if (!$options['skip_feeds']) {
            GatorCache::getCache($opts)->removeGroups('/comments/feed', $groups);
        }
    }

    public static function filterCookieLifetime($lifetime)
    {
        return 1800;//set to reasonable lifetime, 0 won't work for life of the browser session, see wp_set_comment_cookies
    }

    public static function loadTextDomain()
    {
        load_plugin_textdomain('gatorcache', false, 'gator-cache/lang/');
    }

    public static function filterStatus($header)
    {
        return 0 === strpos($header, 'Location');//the status header is not in the return stack
    }

    public static function responseOk()
    {
        //in 5.4 see http_response_code
        $status = array_filter(headers_list(), 'WpGatorCache::filterStatus');//in 5.3 simply use a lambda
        return empty($status);
    }

    public static function getWebUser($name = true)
    {
        if (!isset(self::$webUser)) {
            if (function_exists('posix_geteuid')) {
                $user = posix_getpwuid(posix_geteuid());
                $group = posix_getgrgid($user['gid']);
                self::$webUser = array('user' => $user['name'], 'group' => $group['name']);
            } else {
                $user = get_current_user();
                self::$webUser =  array('user' => $user, 'group' => $user);
            }
        }
        return $name ? self::$webUser['user'] : self::$webUser['group'];
    }

    public static function getCacheDir()
    {
        self::getOptions();//loads GatorCache and config path
        return GatorCache::getConfig(self::$configPath)->get('cache_dir');
    }

    public static function getCache()
    {
        self::getOptions();
        return GatorCache::getCache(GatorCache::getConfig(self::$configPath)->toArray());
    }

/**
 * purgePath
 *
 * Public access to purging a url path. Will purge in all cache groups.
 *
 * @param $path string | bool the relative url path, false to flush cache
 */
    public static function purgePath($path)
    {
        $options = self::getOptions();
        if (empty($path)) {
            GatorCache::getCache(
                $opts = GatorCache::getConfig(self::$configPath)->toArray()
            )->purgeGroups(self::getCacheGroups($opts));
            return;
        }
        GatorCache::getCache(
            $opts = GatorCache::getConfig(self::$configPath)->toArray()
        )->removeGroups($path, self::getCacheGroups($opts));
    }

    protected static function getOptions()
    {
        if (isset(self::$options)) {
            return self::$options;
        }
        require_once((self::$path = plugin_dir_path(__FILE__)) . 'lib/GatorCache.php');
        self::$configPath = self::getConfigPath();
        //rather than implementing arrayaccess
        return self::$options = GatorCache::getOptions(self::PREFIX . '_opts', self::$defaults)->toArray();
    }

    protected static function getConfigPath()
    {
        return ABSPATH . (is_multisite() ? 'gc-config-' . get_current_blog_id() . '.ini.php' : 'gc-config.ini.php');//has to go here in case if subdir hosts
    }

    protected static function hasPathExclusion($path)
    {
        if ('/' === $path) {
            return in_array('/', self::$options['exclude_paths']);
        }
        foreach (self::$options['exclude_paths'] as $exPath) {
            if ('/' !== $exPath && strstr($path, $exPath)) {
                return true;
                break;
            }
        }
        return false;
    }

    protected static function copyConfigFile()
    {
        $source = self::$path . 'lib' . DIRECTORY_SEPARATOR . 'config.ini.php';
        if (!is_file($configPath = self::getConfigPath())) {
            //|| md5_file($source) !==  md5_file($configPath)
            if (false === @copy($source,  $configPath)) {
                return false;
            }
        }
        return true;
    }

    protected static function checkBlogConfig()
    {
        return (false !== GatorCache::getBlogMap()) || @touch(GatorBlogMap::getPath());
    }

    protected static function saveCachePath($path, $url)
    {
        if (false === ($config = GatorCache::getConfig(self::$configPath, true))) {
            return false;
        }
        global $wp_rewrite;
        //$group = str_replace('.', '-', $url['host']) . (empty($url['path']) || '/' === $url['path'] ? '' : str_replace('/', '-', $url['path']));
        //for easier http rules $group = $url['host']
        $config->set('cache_dir', $path);
        $config->set('group', $url['host']);
        $config->set('host', $url['host']);
        if (false !== ($secureHost = self::setSecureHost(false))) {
            $config->set('secure_host', $secureHost);
        }
        $config->set('dir_slash', isset($wp_rewrite->use_trailing_slashes) && $wp_rewrite->use_trailing_slashes);
        if (is_multisite()) {
            GatorCache::getBlogMap()->saveBlogId(self::getMultiHost($url), get_current_blog_id());
        }
        return $config->write();
    }

    protected static function getMultiHost($url)
    {
        $host = $url['host'];
        if (!is_subdomain_install() && !empty($url['path']) && '/' !== $url['path']) {
            $host .= $url['path'];
        }
        return $host;
    }

    protected static function isMultiSubPath($path)
    {
        foreach (self::$options['multisite_paths'] as $subPath) {
            if (0 === strpos($path, $subPath)) {
                return true;
                break;
            }
        }
        return false;
    }

    protected static function getRefreshPosts($post, $isNew)
    {
        $ids = array();
        if (!$isNew) {
            $ids[] = $post->ID;
        }
        if (isset(self::$options['app_support']['bbpress'])
          && isset(self::$options['app_support']['bbpress'][$post->post_type])
          && in_array('bbpress', self::$options['post_types'])) {
            //get bbpress parent posts
            self::$post = $post;//seeder
            for ($xx=0;$xx<25;$xx++) {
                if (false === $id = self::getParentPost(self::$post)) {
                    break;
                }
                $ids[] = $id;
            }
        }
        return $ids;
    }

    protected static function getParentPost($post)
    {
        if (0 === $post->post_parent) {
            return false;
        }
        if (null !== ($parent = get_post($post->post_parent))) {
            self::$post = $parent;
            return self::$post->ID;
        }
        return false;
    }

    protected static function getCacheTypes()
    {
        if (!isset(self::$options['app_support']['bbpress']) || !in_array('bbpress', self::$options['post_types'])) {
            return self::$options['post_types'];
        }
        $options = self::$options;
        array_shift($options['app_support']['bbpress']);//exclude reply
        return array_merge($options['post_types'], array_keys($options['app_support']['bbpress']));
    }

    protected static function copyAdvCache($copy = true)
    {
        $sourceFile = self::$path . 'lib' . DIRECTORY_SEPARATOR . 'object-cache.php';
        // allow the object cache file to be edited, just check existance
        if (!is_file($cacheFile = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'object-cache.php')) {
            @copy($sourceFile, $cacheFile);
        }
        $sourceFile = self::$path . 'lib' . DIRECTORY_SEPARATOR . 'advanced-cache.php';
        if (is_file($cacheFile = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'advanced-cache.php')
          && md5_file($cacheFile) === md5_file($sourceFile)) {
            return true;
        }
        return $copy ? (false !== @copy($sourceFile, $cacheFile)) : false;
    }

    protected static function saveWpConfig($wp_cache = true)
    {
        if (defined('WP_CACHE') && $wp_cache === WP_CACHE) {
            return true;
        }
        if (!is_file($file = ABSPATH . 'wp-config.php')) {
            $file = dirname(ABSPATH) . DIRECTORY_SEPARATOR . 'wp-config.php';
        }
        //backup the config just in case
        if ($wp_cache) {
            @copy($file, str_replace('wp-config.php', 'wp-config-bu.php'));
        }
        $fh = @fopen($file, 'r+');
        if (false === $fh) {
            return false;
        }
        $lines = array();
        $pos = 0;
        $xx = 0;
        while (false !== ($buffer = fgets($fh))) {
            if (!preg_match('~^define\s*\(\s*("|\')WP_CACHE\\1~', trim($buffer))) {
                $lines[] = $buffer;
                if (preg_match('~^define\s*\(\s*("|\')WP_DEBUG\\1~', trim($buffer))) {
                    $pos = $xx;
                }
                $xx++;
            }
        }
        fclose($fh);
        $pos++;
        $lines = array_merge(
            array_slice($lines, 0, $pos), array('define(\'WP_CACHE\', '. ($wp_cache ? 'true' : 'false') .');' . PHP_EOL), array_slice($lines, $pos)
        );
        return false !== @file_put_contents($file, $lines);
    }

    public static function filterWidgets($name)
    {
        return 0 === strpos($name, 'recent') && false === strpos($name, 'recently') && false === strpos($name, 'comments');
    }

    public static function filterNggBuffer($valid)
    {
        return false;
    }

    
    public static function isMultiSite()
    {
        if (isset(self::$multiSiteData)) {
            return self::$multiSiteData['isMulti'];
        }
        self::$multiSiteData = array();
        return self::$multiSiteData['isMulti'] = is_multisite();
    }

    public static function isMainSite()
    {
        if (!isset(self::$multiSiteData)) {
            self::isMultiSite();
        }
        if (!isset(self::$multiSiteData['isMain'])) {
            self::$multiSiteData['isMain'] = self::$multiSiteData['isMulti'] && is_main_site(get_current_blog_id());
            self::$multiSiteData['isSubDomain'] = self::$multiSiteData['isMulti'] && is_subdomain_install();
        }
        return self::$multiSiteData['isMain'];
    }

    public static function isMultiSubDomain()
    {
        if (!isset(self::$multiSiteData['isSubDomain'])) {
            self::isMainSite();
        }
        return self::$multiSiteData['isSubDomain'];
    }

    protected static function hasRecentWidgets()
    {
        if (false === ($sidebars = get_option('sidebars_widgets')) || empty($sidebars)) {
            //instead of wp_get_sidebars_widgets()
            return false;
        }
        $hasRecent = false;
        foreach ($sidebars as $key => $value) {
            if ('array_version' !== $key && is_array($value) && false === strpos($key, 'orphan') && false === strpos($key, 'inactive')) {
                $recent = array_filter($value, 'WpGatorCache::filterWidgets');
                if (!empty($recent)) {
                    $hasRecent = true;
                    break;
                }
            }
        }
        return $hasRecent;
    }

    protected static function rangeSelect($min, $max, $sel)
    {
        for ($max++, $xx=$min;$xx<$max;$xx++) {
            $opts[] = '<option value="' . $xx . '"' . ($xx == $sel ? ' selected="selected"' : '') . '>' . $xx . '</option>';
        }
        return implode("\n", $opts);
    }

    protected static function getSupportInfo()
    {
        return '<textarea style="background:cyan;width:100%;" rows="6">
WordPress: ' . get_bloginfo('version') . '
PHP: ' . phpversion() . '
Handler: ' . php_sapi_name() . '
System: ' . php_uname() . '
Web User: ' . self::getWebUser() . '
Writable: ' . (is_writable(self::$path . 'lib' . DIRECTORY_SEPARATOR . 'config.ini.php') ? 'Yes' : 'No') . '
</textarea>';
        //Path: ' . $path; echo var_export($options);echo var_export($config->toArray());
    }

    protected static function getBbPressSupport()
    {
        if (is_plugin_active('bbpress/bbpress.php')) {
            $app_support = array();
            $app_support[bbp_get_reply_post_type()] = true;
            $app_support[bbp_get_topic_post_type()] = true;
            $app_support[bbp_get_forum_post_type()] = true;
            return $app_support;
        }
        return false;
    }

    protected static function isWooCart()
    {
        //don't cache the mini-cart, lots of themes php code it
        global $woocommerce;
        return defined('WOOCOMMERCE_VERSION') && isset($woocommerce) && isset($woocommerce->cart) && 0 < $woocommerce->cart->cart_contents_count;
    }

    protected static function verifyInstall()
    {
        //check install flag
        if (!self::$options['installed']) {
            return false;
        }
        //config file missing or corrupted
        if (!is_file(self::$configPath) || false === ($config = GatorCache::getConfig(self::$configPath))) {
            $msg = __('Your Gator Cache configuration file is missing or corrupted.', 'gatorcache');
            GatorCache::getNotices()->add($msg, '107');
            self::disableCache(false);//requires reinstall
            return false;
        }
        //cache directory is missing or set to the default
        if ('/tmp' === ($cacheDir = $config->get('cache_dir')) || !is_dir($cacheDir)) {
            $msg = __('Your Gator Cache directory is missing or no longer set.', 'gatorcache');
            GatorCache::getNotices()->add($msg, '108');
            self::disableCache();//requires reinstall
            return false;
        }
        $isDir = true;
        if ('/tmp' === ($objCacheDir = $config->get('oc_cache_dir')) || empty($objCacheDir) || !($isDir = is_dir($objCacheDir))) {
            $objCacheDir = str_replace('/gator_cache', '/gator_cache_oc', $cacheDir);
            if (!$isDir) {
                @mkdir($objCacheDir, 0755);
                //put htaccess here to prevent direct access
                @file_put_contents($objCacheDir . DIRECTORY_SEPARATOR . '.htaccess', "Order Deny,Allow\nDeny from all\n");
            }
            $config->save('oc_cache_dir', $objCacheDir);
            GatorCache::getOptions(self::PREFIX . '_opts', self::$defaults)->save('oc_cache_dir', $objCacheDir);
        }
        //for apache, make sure htaccess protects the cache dir
        if (!@file_exists($htaccess = $cacheDir . '/.htaccess')) {
            @file_put_contents($htaccess, "Order Deny,Allow\nDeny from all\nAllow from env=redirect_gc_green\n") ;
        }
        if (!@file_exists($htaccess = $objCacheDir . '/.htaccess')) {
            @file_put_contents($htaccess, "Order Deny,Allow\nDeny from all\n") ;
        }
        //check wp cache is set and the right adv cache is present
        if (!(defined('WP_CACHE') && WP_CACHE) || !self::copyAdvCache(false)) {
            //attempt to repair
            if (!($wpCache = self::saveWpConfig()) || !self::copyAdvCache()) {
                if (!$wpCache) {
                    $msg = __('Your WordPress configuration file could not be updated.', 'gatorcache');
                    $code = '109';
                } else {
                    $msg = __('Your advanced cache file is missing or corrupted.', 'gatorcache');
                    $code = '110';
                }
                GatorCache::getNotices()->add($msg, $code);
                self::disableCache();//requires reinstall
                return false;
            }
        }
        //check for the host
        if (!$config->has('host')) {
            if (false === ($url = parse_url(get_option('siteurl')))) {
                $msg = __('Could not reliably set your host name.', 'gatorcache');
                GatorCache::getNotices()->add($msg, '111');
                self::disableCache();//requires reinstall
                return false;
            }
            $config->save('host', $url['host']);
        }
        self::setSecureHost();
        global $wp_rewrite;//make sure these match
        if ($config->get('dir_slash') != ($dirSlash = (isset($wp_rewrite->use_trailing_slashes) && $wp_rewrite->use_trailing_slashes))) {
            $config->save('dir_slash', $dirSlash);
        }
        //url checks
        $url = parse_url(get_option('siteurl'));
        //multisite
        if (is_multisite()) {
            if (!self::checkBlogConfig()) {
                //no file and couldn't create
                $msg = __('Your multisite blog configuration file could not be created.', 'gatorcache');
                GatorCache::getNotices()->add($msg, '112');
                return false;
            }
            //verify the host and reset if not matching
            $host = self::getMultiHost($url);
            if ($host !== GatorCache::getBlogMap()->getHost($blogId = get_current_blog_id())) {
                GatorCache::getBlogMap()->saveBlogId($host, $blogId);
            }
            //refresh sub blog exclusions if applicable
            /*if(!is_subdomain_install() && is_main_site($blogId)){
                //@note more effecient to query db that to use wp_get_sites (wp >= 3.7)
                global $wpdb;
                if(null === ($sites = $wpdb->get_results('select * from ' . $wpdb->prefix . 'blogs where site_id = ' . $blogId . ' and blog_id != ' . $blogId . ' order by blog_id limit 0, 10000', 'ARRAY_A'))){
                    $sites = array();
                }
                $paths = array();
                foreach($sites as $site){
                    if('0' === $site['deleted'] && '' !== $site['path'] && '/' !== $site['path']){
                        $paths[$site['blog_id']] = $site['path'];
                    }
                }
                if(!empty($paths)){
                    if($paths !== $options['multisite_paths']){
                        GatorCache::getOptions()->save('multisite_paths', $paths);
                    }
                }
                elseif(false !== $options['multisite_paths']){
                    GatorCache::getOptions()->save('multisite_paths', false);
                }
            }*/
        }
        //@note an upgrade can move the cache dir
        if ($config->get('group') !== $url['host']) {
            $config->save('group', $url['host']);
        }
        if (!empty($url['path']) && '/' !== $url['path']) {
            if ('/' === substr($url['path'], -1)) {
                $url['path'] = rtrim($url['path'], '/');
            }
            if ($url['path'] !== $config->get('path')) {
                $config->save('path', $url['path']);
            }
        } elseif (false !== $config->get('path')) {
            $config->remove('path');
            $config->write();
        }
        if (self::isJetPackMobile(false) && !$config->get('jp_moblie')) {
            $config->save('jp_mobile', true);
        } elseif ($config->get('jp_moblie')) {
            $config->save('jp_mobile', false);
        }
        self::setContentTypes($config);
        return true;
    }

    protected static function setContentTypes($config)
    {
        if ($config->get('content_type') !== ($contentType = 'Content-Type: ' . get_option('html_type') . '; charset=' . ($charset = get_option('blog_charset')))) {
            $config->save('content_type', $contentType);
        }
        if ($config->get('rss2_type') !== ($contentType = 'Content-Type: text/xml; charset=' . $charset)) {
            $config->save('rss2_type', $contentType);
        }
        if ($config->get('atom_type') !== ($contentType = 'Content-Type: application/atom+xml; charset=' . $charset)) {
            $config->save('atom_type', $contentType);
        }
        if ($config->get('rdf_type') !== ($contentType = 'Content-Type: application/rdf+xml; charset=' . $charset)) {
            $config->save('rdf_type', $contentType);
        }
        if ($config->get('default_feed') !== ($defaultFeed = get_default_feed())) {
            $config->save('default_feed', $defaultFeed);
        }
    }

    protected static function checkObHandlers($isSecure)
    {
        $buffers = ob_list_handlers();
        if (empty($buffers)) {
            return false;
        }
        for ($buffered = false, $ct = count($buffers), $xx = 0; $xx < $ct; $xx++) {
            if (0 === strpos($buffers[$xx], 'WordPressHTTPS') && $isSecure) {
                //look for the https plugin ob handler
                $buffered = true;
                self::$sslHandler = $buffers[$xx];
                // break;
            } elseif ('WPMinify::modify_buffer' === $buffers[$xx] && isset($GLOBALS['wp_minify'])
              && @class_exists('WPMinify', false) && $GLOBALS['wp_minify'] instanceof WPMinify) {
                self::$obHandlers[] = array('handler' => 'wp_minify', 'method' => 'modify_buffer');
                $buffered = true;
            }
            elseif ('autoptimize_end_buffering' === $buffers[$xx]) {
                self::$obHandlers[] = array('handler' => false, 'method' => 'autoptimize_end_buffering');
                $buffered = true;
            }
        }
        if ($buffered) {
            // kill the buffers so the callback handlers are not called twice
            for ($xx = 0; $xx < $ct; $xx++) {
                ob_end_clean();
            }
        }
        return false;
    }

    protected static function doHttpsHandler($buffer)
    {
        global $wordpress_https;
        // recent versions use a module
        $module = false;
        list($class, $method) = explode('::', self::$sslHandler);
        if (strstr($class, 'Module_Parser')) {
            $module = $wordpress_https->getModule('Parser');
        }
        if (isset($wordpress_https) && isset($method) && method_exists(false === $module ? $wordpress_https : $module, $method)) {
            $out = false === $module ? $wordpress_https->{$method}($buffer) : $module->{$method}($buffer);// let WordPressHTTPS parse out theme developers src tag shananigans
            if (!empty($out)) {
                return $out;
            }
        }
        return false;
    }

    protected static function doObHandlers($buffer, $debugMsg)
    {
        foreach (self::$obHandlers as $handler) {
            if (false === $handler['handler']) { //function call
                $output = call_user_func($handler['method'], $buffer);
                if (!empty($output)) {
                    $buffer = $output . ('' === $debugMsg ? '' : str_replace(' on [', ' via Autoptimze on [', $debugMsg));
                }
            }
            elseif (isset($GLOBALS[$handler['handler']])) {
                // this strips the cached on debug msg
                $output = $GLOBALS[$handler['handler']]->{$handler['method']}($buffer);
                if (!empty($output)) {
                    $buffer = $output . ('' === $debugMsg ? '' : str_replace(' on [', ' via WPMinify on [', $debugMsg));
                }
            }
        }
        return $buffer;
    }

    protected static function disableCache($all = true)
    {
        GatorCache::getOptions(self::PREFIX . '_opts')->save('enabled', false);
        if ($all) {
            GatorCache::getConfig(self::$configPath)->save('enabled', false);
        }
    }

    protected static function moveCache($docRoot = true)
    {
        $config = GatorCache::getConfig(self::$configPath);
        if (!is_dir($cacheDir = ABSPATH . 'gator_cache')) {
            if (!@rename($config->get('cache_dir'), $cacheDir)) {
                return false;
            }
        } elseif (!is_writable($cacheDir)) {
            return false;
        }
        return $config->save('cache_dir', $cacheDir);
    }

    protected static function setSecureHost($save = true)
    {
        //wp https comptibility if the secure host does not match the wp host
        if (false !== ($secureUrl = get_option('wordpress-https_ssl_host')) && is_plugin_active('wordpress-https/wordpress-https.php')) {
            $config = GatorCache::getConfig(self::$configPath);
            if (false !== ($url = parse_url($secureUrl)) && $config->get('host') !== $url['host']) {
                if (!$save) {
                    return $url['host'];
                }
                $config->save('secure_host', $url['host']);
            }
        }
        return false;
    }

    protected static function isJetPackMobile($skipSettings = true)
    {
        //jetpack checks settings on frontend
        return defined('JETPACK__VERSION') && false !== ($active = get_option('jetpack_active_modules')) && in_array(self::JP_MOBILE_MOD, $active) && ($skipSettings || '1' !== get_option('wp_mobile_disable'));
    }

    protected static function isJetPackMobileSite()
    {
        return self::isJetPackMobile() && jetpack_check_mobile();
    }

    protected static function cacheUserContent()
    {
        $user = wp_get_current_user();
        $options = self::getOptions();
        $cacheme = array_intersect($options['roles'], (array)$user->roles);
        return !empty($cacheme) && apply_filters('gc_cache_user_content', false, $user);
    }

    protected static function getNoCacheHeaders()
    {
        $headers = array();
        foreach (wp_get_nocache_headers() as $k => $v) {
            if ('Last-Modified' === $k) {
                continue;
            }
            $headers[] = $k . ': ' . $v;
        }
        return empty($headers) ? false : $headers;
    }

    protected static function getCacheGroups($opts)
    {
        $groups = array($opts['group']);
        if ($isJetPackMobile = $opts['jp_mobile_cache']) {
            $groups[] = $opts['group'] . '-jpmobile';
        }
        if (!$opts['skip_ssl']) {
            $groups[] = 'ssl@' . $opts['group'];
            if ($isJetPackMobile) {
                $groups[] = 'ssl@' . $opts['group'] . '-jpmobile';
            }
        }
        return $groups;
    }

    protected static function getHostString($config)
    {
        //for apache rules
        if (!self::isMultiSubDomain() || false === ($blogMap = GatorCache::getBlogMap())) {
            //regular site
            return str_replace('.', '\.', $config->get('host'));
        }
        //special case main site of a subdomain install
        $blogs = $blogMap->all();
        foreach ($blogs as $key =>$blog) {
            $blogs[$key] = str_replace('.', '\.', $config->get('host'));
        }
        return '(' . implode('|', $blogs) . ')';
    }
}
//Hooks
register_activation_hook(__FILE__, 'WpGatorCache::Activate');
register_deactivation_hook(__FILE__, 'WpGatorCache::Deactivate');
add_action('auth_cookie_valid', 'WpGatorCache::chkUser', 5, 2);
add_action('wp', 'WpGatorCache::initBuffer', 5);//after_setup_theme
add_action('init', 'WpGatorCache::loadTextDomain');
//admin settings
if (is_admin()) {
    add_action('admin_menu', 'WpGatorCache::addOptMenu', 8);
    add_action('admin_init', 'WpGatorCache::checkUpgrade');
    add_action('admin_enqueue_scripts', 'WpGatorCache::loadAdminJs', 111);
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'WpGatorCache::settingsLink');
    //installation ajax
    add_action('wp_ajax_gcinstall', 'WpGatorCache::doInstall');
    //settings
    add_action('wp_ajax_gci_gen', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_usr', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_cpt', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_dbg', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_del', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_ref', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_dir', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_xex', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_mcd', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_crf', 'WpGatorCache::updateSettings');
    add_action('wp_ajax_gci_xrf', 'WpGatorCache::updateSettings');
    add_filter('whitelist_options', 'WpGatorCache::pingSetting');
    add_filter('redirect_post_location', 'WpGatorCache::savePostContext');
    add_filter('post_updated_messages', 'WpGatorCache::savePostMsg', 11);
}
add_action('transition_post_status', 'WpGatorCache::savePost', 11111, 3);
add_action('transition_comment_status', 'WpGatorCache::saveComment', 11, 3);
add_action('wp_insert_comment', 'WpGatorCache::postComment', 10, 2);
add_action('edit_comment', 'WpGatorCache::postComment');
add_filter('comment_cookie_lifetime', 'WpGatorCache::filterCookieLifetime', 11111);
add_filter('run_ngg_resource_manager', 'WpGatorCache::filterNggBuffer', 99999);
//by popular demand, a delete button on the toolbar
add_action('wp_before_admin_bar_render', 'WpGatorCache::addToolbarButton');
/**
 * Allow plugins, such as autoptimize to delete cache
 */
if (!function_exists('wp_cache_clear_cache')) {
    function wp_cache_clear_cache($blogId = null)
    {
        if (!empty($blogId) && $blogId != get_current_blog_id()) {// @note when hooked blogId is empty string
            return;
        }
        WpGatorCache::purgePath(false);
    }
    // @note - the autoptimize plugin tries to call wp_cache_clear_cache before it's even loaded!!
    add_action('autoptimize_action_cachepurged', 'wp_cache_clear_cache');
}
