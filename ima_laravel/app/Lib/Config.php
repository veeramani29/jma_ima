<?php
namespace App\Lib;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

class Config {
	private static $conf;
	
	
	public static function doConfig() {
		$config_file = SERVER_ROOT.'/config/config/conf.ini';
		self::$conf = parse_ini_file($config_file,true);
	
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

Config::doConfig();
//require(SERVER_ROOT.'/alanee_lib/controller/alanee_core.php');
//require(SERVER_ROOT.'/alanee_lib/view/alanee_view.php');








?>