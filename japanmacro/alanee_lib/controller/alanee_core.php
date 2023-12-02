<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class AlaneeCore {
	private $AddClasses = array();
	public $classes = array();
	protected $viewPath = null;
	protected $renderResultSet = array('pagetitle'=>'',
									   'meta' => array('description'=>'','keywords'=>''),
									   'status'=>1,
									   'message'=>'OK',
									   'result'=>'');
	private $View;
	public $js;
	public $css;
	protected $controllername;
	protected $action;
	private $params;
	protected $pageTitle;
	public $rootPath;
/**
 * 
 * @todo Add resultset assignments and data setting eg(Ok, Error, Set)
 */	
	public function AlaneeCore($controllername='',$action='',$params='') {
		$this->controllername = $controllername;
		$this->action = $action;
		$this->params = $params;
		$appPath = Config::read('appication_path') != '' ? trim(Config::read('appication_path'),'/').'/' : '';
		$this->rootPath = '//'.SITE_URL.$appPath;
		$this->View = new AlaneeView(Router::$viewPath,Router::$view);
		$this->View->setJs($this->js);
		$this->View->setCss($this->css);
		$this->View->setRootPath($this->rootPath);
		if (count($this->classes)>0) {
			foreach ($this->classes as $rwClasses) {
				$this->AddClasses[] = $rwClasses;
			}
		}	
		$autoloader = new Autoloader('modal');
		foreach ($this->AddClasses as $adtClass) {
			$autoloader->loadThisClass($adtClass);
		}
		if ($this->viewPath != null) {
			$this->View->setViewPath($this->viewPath);
		}

	}

	public function __call($method,$params){
		/**
		 * Error page handling 404
		 */
		$this->error(404);
	}
	public function error($errorCode=404){
		$request = 'url=error/error_'.$errorCode;
		Router::doRoute($request);
		//exit(Router::$controllerFile);
		//exit("No handler function exists...");
		//Router::execute();
	
	}
	public function setTemplate($templateFile = null) {
		if($templateFile != null)
			 $this->View->setTemplateFile($templateFile);		
	}
	public function setViewPath($path) {
		$this->View->setViewPath($path);
	}

	

	public function renderView($viewFile = null) { 
		if($viewFile != null)
		$this->View->setViewFile($viewFile);
		$this->View->setPageTitle($this->pageTitle);
	$this->View->render($this->renderResultSet,$this->controllername,$this->action,$this->params);		
	}
	public function renderAjax($type) {
		$this->View->renderAjax($type,$this->renderResultSet,$this->controllername,$this->action,$this->params);
	}
	// Load another url on current path.
	public function loadURL($url){
		$request = 'url='.$url;
		Router::doRoute($request);
	}
	public function redirect($page,$considerPrefix = false){
		$prefix = $considerPrefix == true ? Router::$prefix.'/' : '';
		$appPath = Config::read('appication_path');
		$appPath = $appPath == '' ? '' : $appPath.'/';
		if (is_array($page)) {
			$prefix = array_key_exists('prefix', $page) ? $page['prefix'].'/' : '';
			$controller = array_key_exists('controller', $page) ? $page['controller'].'/' : 'home/';
			$action = array_key_exists('action', $page) ? $page['action'].'/' : 'index/';
			if(array_key_exists('params', $page)) {
				$params = is_array($page['params']) ? implode('/', $page['params']) : $page['params'];
			}else {
				$params = '';
			}
			header("location: /".$appPath.$prefix.$controller.$action.$params);
		} else{
			header("location: /".$appPath.$prefix.ltrim($page,'/'));
		}
	}
	public function fullRedirect($url){
		header("location: ".$url);
	}
	public function url($link,$isprefix=false) {
		$prefix = $isprefix == true ? Router::$prefix!='' ? Router::$prefix.'/' : '' : '';
		$appPath = Config::read('appication_path');
		$appPath = $appPath == '' ? '' : $appPath.'/';
		if(is_array($link)) {
			$prefix = array_key_exists('prefix', $link) ? $link['prefix'].'/' : '';
			$controller = array_key_exists('controller', $link) ? $link['controller'].'/' : 'home/';
			$action = array_key_exists('action', $link) ? $link['action'].'/' : 'index/';
			if(array_key_exists('params', $link)) {
				$params = is_array($link['params']) ? implode('/', $link['params']) : $link['params'];
			}else {
				$params = '';
			}
			return '//'.SITE_URL.$appPath.$prefix.$controller.$action.$params;
		} else{
			return '//'.SITE_URL.$appPath.$prefix.ltrim($link,'/');
		}		
	}
	public function setFlashMessage($message=null) {
		if($message != null) {
			$_SESSION['alanee_flashmessage'] = $message;
		}
	}
	
	/**
	 * Get flash message value
	 * @return message
	 */
	public function getFlashMessage(){
	 	$message = isset($_SESSION['alanee_flashmessage']) ? $_SESSION['alanee_flashmessage'] : null;
		unset($_SESSION['alanee_flashmessage']);
		return $message;
	}
	
}


?>