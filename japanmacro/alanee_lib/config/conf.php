<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
require(SERVER_ROOT.'/config/routes.ini');
class Config {
	private static $conf;
	public static $routes;
	public static $prefixes;
	
	public static function doConfig($routes,$prefixes) {
		$config_file = SERVER_ROOT.'/config/conf.ini';
		self::$conf = parse_ini_file($config_file,true);
		self::$routes = $routes;
		self::$prefixes = $prefixes;
	}
/**
 * 
 * Enter description here ...
 * @param unknown_type $confKey
 * @todo : needs to be refactored ... to allow multilevel configuration.
 */	
	public static function read($confKey) {
		$conf_val = self::$conf;
		$conf_key_arr = explode('.', trim($confKey));
		foreach ($conf_key_arr as $conf_key){
			$conf_val = $conf_val[$conf_key];
		}
		return $conf_val;
	}
	
	public static function write($confKey,$value) {
		$conf_val = &self::$conf;
		$conf_key_arr = explode('.', trim($confKey));
		foreach ($conf_key_arr as $conf_key){
			$conf_val = &$conf_val[$conf_key];
		}
	}
	
}

Config::doConfig($routes,$prefixes);
require(SERVER_ROOT.'/alanee_lib/controller/alanee_core.php');
require(SERVER_ROOT.'/controller/alanee_controller.php');
require(SERVER_ROOT.'/alanee_lib/config/database.php');
require(SERVER_ROOT.'/alanee_lib/modal/alanee_modal.php');
require(SERVER_ROOT.'/alanee_lib/view/alanee_view.php');
require(SERVER_ROOT.'/alanee_lib/plugin/alanee_plugin.php');
require(SERVER_ROOT.'/vendor/autoload.php');
require(SERVER_ROOT.'/alanee_classes/Mobile_Detect.php');


/**
 * Class auto loader
 */
    class Autoloader {
    	private $classFolder = '';
        public function __construct($path='') {
        	$this->classFolder = $path;
            spl_autoload_register(array($this, 'loader'));
        }
        private function loader($className){
        	$classFile = SERVER_ROOT.'/'.$this->classFolder.'/'.strtolower($className).'_modal.php';
        	if (file_exists($classFile) && is_readable($classFile)) {
           		include_once $classFile;
           }
        }
        public function loadThisClass($classFile) {
        	include_once SERVER_ROOT.'/'.$classFile;
        }
    }

?>