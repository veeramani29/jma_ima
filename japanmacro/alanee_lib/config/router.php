<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Router {
	public static $controllerFile;
	public static $controllerClass;
	public static $controllerName;
	public static $error_controllerFile;
	public static $error_controllerClass;
	public static $error_controllerName;
	public static $action;
	public static $params;
	public static $query_array;
	public static $viewPath;
	public static $view;
	public static $prefix;
	
	public static function execute(){
		 $controllerCls = Router::$controllerClass;
		$action = Router::$action;
		$params = Router::$params;
		$query = Router::$query_array;
		$controller = new $controllerCls(Router::$controllerName, $action, $params);
		$controller->$action($params,$query);
	}
	
	public static function doRoute($in_request) {
		 $routes = Config::$routes;
		 $prefixes = Config::$prefixes;
		parse_str($in_request,$request);
		//list($param , $url) = split('=' , $request);
		$url = trim($request['url'],'/');
		unset($request['url']);
		$parsed = explode('/' , $url);
		$page_prefix = '';		
		$page = array_shift($parsed);
		if(in_array($page, $prefixes)) {
			$page_prefix = $page;
			$page = array_shift($parsed);
		}
		$action = array_shift($parsed);
		if($action =='') {
			$action = 'index';
		}
		if($page_prefix != '') {
			$action = $page_prefix.'_'.$action;
		}
		if(array_key_exists($page, $routes)) {
			if(array_key_exists($action, $routes[$page])) {
				$action = $routes[$page][$action]['action'];
				$page = $routes[$page][$action]['controller'];
			}elseif(array_key_exists('*', $routes[$page])) {
				$action = $routes[$page]['*']['action'];
				$page = $routes[$page]['*']['controller'];
			}
		}
		if(array_key_exists($url,$routes['redirect'])){
			$page = $routes['redirect'][$url]['controller'];
			$action = $routes['redirect'][$url]['action'];
			$parsed = $routes['redirect'][$url]['param'];
		}
		if($page =='') {
			$page = 'home';
		}
		self::$controllerFile = SERVER_ROOT . '/controller/'.$page. '_controller.php';
		self::$controllerClass = ucfirst($page).'Controller';
		self::$controllerName = $page;
		self::$action = $action;
		self::$params = $parsed;
		self::$query_array = $request;
		self::$viewPath = strtolower($page);
		self::$view = $action;
		self::$prefix = $page_prefix;
	// execute...
		if (file_exists(Router::$controllerFile))
		{
			include_once(Router::$controllerFile);
			$controllerCls = Router::$controllerClass;
			if (class_exists($controllerCls))
			{
				Router::execute();
			}
			else
			{
				//did we name our class correctly?
				die('Error..! Page does not exist!');
			}
		}
		else
		{
			// 404 error
			$request = 'url=error/error_404';
			Router::doRoute($request);
		}	
	}
	public static function redirect($routeParams) {
		
	}
	
}

$request = $_SERVER['QUERY_STRING'];
if(empty($request)) {
	$request = 'url=home/index';
}

Router::doRoute($request);

//once we have the controller instantiated, execute the default function
//pass any GET varaibles to the main method

//$controller->$action($params,$query);
?>