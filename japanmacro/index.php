<?php
session_start();

/**
 * Define document paths
 */
define('SERVER_ROOT' , dirname(__FILE__));
define('SITE_URL' , $_SERVER['HTTP_HOST'].'/');
require SERVER_ROOT.'/alanee_lib/config/conf.php';


define('ENVIRONMENT', Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '');

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
		error_reporting(E_ALL);
		error_reporting(E_ALL & ~E_NOTICE);
		ini_set("display_errors", 1);
		ini_set('display_startup_errors', 1);
		break;
		case 'test':
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		ini_set('display_startup_errors', 1);
		case 'production':
			error_reporting(E_COMPILE_ERROR);
			ini_set("display_errors", 0);
			ini_set('display_startup_errors', 0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}


require SERVER_ROOT.'/alanee_lib/config/router.php';
?>
