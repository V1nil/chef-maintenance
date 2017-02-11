<?php
/**
 * Gator Cache
 *
 * A Factory class for the Cache and its associated components.
 *
 * Copyright(c) Schuyler W Langdon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */ 
class GatorCache
{
    protected static $cache;
    protected static $objectCache;
    protected static $request;
    protected static $config;
    protected static $blogMap;
    protected static $options;
    protected static $notices;
    protected static $mobileDetect;

    public static function getCache(array $options = null)
    {
        if (!isset(self::$cache)) {
            require_once(dirname(__FILE__) . '/CacheWrapper.php');
            self::$cache = new CacheWrapper($options);
        }
        return self::$cache;
    }

    public static function getRequest()
    {
        if (!isset(self::$request)) {
            if(!@class_exists('Reo_Classic_Request', false)){
                require_once(dirname(__FILE__) . '/Reo/Classic/Request.php');
            }
            if ('127.0.0.1' === $_SERVER['REMOTE_ADDR']) {
                //add the proxy
                Reo_Classic_Request::setTrustedProxies((array)'127.0.0.1');
            }
            self::$request = Reo_Classic_Request::createFromGlobals();
        }
        return self::$request;
    }

    public static function getConfig($path, $chkPath = false, $reload = false)
    {
        if (!isset(self::$config) || $reload) {
            if (false === ($config = self::loadConfig($path, $chkPath)) && $chkPath) {
                return false;
            }
            self::$config = $config;
        }
        return self::$config;
    }

    public static function purgeCache($configPath)
    {
        return self::getCache($opts = self::getConfig($configPath)->toArray())->purge($opts['group'], isset($opts['path']) ? $opts['path'] : null);
    }

    public static function getBlogMap()
    {
        if (!isset(self::$blogMap)) {
            require_once(($dir = dirname(__FILE__)) . '/Config/Lite.php');
            require_once($dir . '/GatorBlogMap.php');
            if (false === ($config = self::loadConfig(GatorBlogMap::getPath(), true))) {
                return false;
            }
            self::$blogMap = new GatorBlogMap($config, self::getRequest());
        }
        return self::$blogMap;
    }

    public static function getOptions($key, array $defaults = null)
    {
        if (!isset(self::$options)) {
            if (!class_exists('Config_Wp', false)) {
                require_once(dirname(__FILE__) . '/Config/Wp.php');
            }
            self::$options = new Config_Wp($key, $defaults);
        }
        return self::$options;
    }

    public static function getNotices()
    {
        if (!isset(self::$notices)) {
            require_once(($dir = dirname(__FILE__)) . '/GatorNotice.php');
            require_once($dir . '/Notice/GatorNoticeCollection.php');
            self::$notices = new GatorNoticeCollection();
        }
        return self::$notices;
    }

    public static function getMobileDetect()
    {
        if (isset(self::$mobileDetect)) {
            return self::$mobileDetect;
        }
        if (!@class_exists('Mobile_Detect', false)) {
            // compatiblity with the wp plugin that does not check class exists
            require_once(@file_exists($path = WP_CONTENT_DIR . '/plugins/wp-mobile-detect/mobile-detect.php') ? $path : dirname(__FILE__) . '/MobileDetect.php');
        }
        return self::$mobileDetect = new Mobile_Detect();
    }

    public static function getJsonResponse()
    {
        require_once(($dir = dirname(__FILE__)) . '/JqJsonResponse.php');
        return new JqJsonResponse();
    }

    public static function initObjectCache()
    {
        require_once(dirname(__FILE__) . '/GatorObjectCache.php');
        if (!@class_exists('Reo_Classic_CacheLite', false)) {
            require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Reo/Classic/CacheLite.php');
        }
        // the global is used internally by WordPress
        self::$objectCache = $GLOBALS['wp_object_cache'] = new GatorObjectCache(
            new Reo_Classic_CacheLite(self::$config->get('oc_cache_dir'), array(
                /*'debug'            => true,
                'readControl'      => false,
                'fileNameHashMode' => 'apache',*/
                'hashedDirectoryUmask' => 0755
            ))
        );
    }

    public static function getObjectCache()
    {
        if(!isset(self::$objectCache)){
            self::initObjectCache();
        }
        return self::$objectCache;
    }

    public static function loadObjectCacheFns()
    {
        require_once(dirname(__FILE__) . '/object-wrappers.php');
    }

    protected static function loadConfig($path, $chkPath)
    {
        if (!@class_exists('Config_Lite', false)) {
            require_once(dirname(__FILE__) . '/Config/Lite.php');
        }
        try {
            $config = new Config_Lite($path, array('cache_dir' => '/tmp'), $chkPath);
        } catch (Exception $e) {
            if ($chkPath) {
                return false;
            }
        }
        return $config;
    }
}
