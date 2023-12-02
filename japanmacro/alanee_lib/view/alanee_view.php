<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class AlaneeView {
	private $viewPath;
	private $viewFile;
	private $templatePath;
	private $templateFile;
	private $jsfiles;
	private $cssfiles;
	private $pageTitle;
	private $rootPath;
	public function AlaneeView($path,$viewFile) {
		$this->setViewPath($path);
		$this->setViewFile($viewFile);
		$this->setTemplatePath('/templates');
		$this->setTemplateFile('default');
	}
	public function setTemplatePath($path) {
		 $this->templatePath = SERVER_ROOT.'/view/'.$path;
	}
	public function setTemplateFile($template) {
		 $this->templateFile = $template.'.php';
	}
	public function getTemplatePath() {
		return $this->templatePath;
	}
	public function getTemplate() {
		return $this->template;
	}
	public function setViewPath($path) {
		 $this->viewPath = SERVER_ROOT.'/view/'.$path;
	}
	public function setViewFile($viewFile) {
		$this->viewFile = $viewFile.'.php';
	}
	public function getViewPath() {
		return $this->viewPath;
	}
	public function getViewFile() {
		return $this->viewFile;
	}
	public function setPageTitle($pageTitle) {
		$this->pageTitle = $pageTitle;
	}
	public function setJs($js) {
		$this->jsfiles = $js;
	}
	public function setCss($css) {
		$this->cssfiles = $css;
	}
	public function setRootPath($path='') {
		$this->rootPath = $path;
	}
/**
 * 
 * Render ajax viewa ...
 * @param String $type
 * @param Array $resultSet
 * @todo add all ajax types
 */	
	public function renderAjax($type,$resultSet,$controllername,$action,$params) {
		switch ($type) {
			case 'json':
				$this->setTemplateFile('ajax');
				$this->setViewPath('ajax');
				$this->setViewFile('json');
				break;
			case 'text':
				$this->setTemplateFile('ajax');
				$this->setViewPath('ajax');
				$this->setViewFile('text');
				break;				
			
		}
		$this->render($resultSet,$controllername,$action,$params);
	}
	public function render($resultSet,$controllername,$action, $params) {

		$view = $this->viewFile == '' ? '' : $this->viewPath.'/'.$this->viewFile;
		if($action!='offerings')
		 $template = $this->templatePath.'/'.$this->templateFile;
		else
			$template='';

		$renderVW = new renderView($template, $view, $resultSet, $controllername, $action, $params);
		$renderVW->rootPath = $this->rootPath;
		$renderVW->setPageTitle($this->pageTitle);
		if(!empty($this->jsfiles)) {
			$renderVW->setJs($this->jsfiles);
		}
		if(!empty($this->cssfiles)) {
			$renderVW->setCss($this->cssfiles);
		}
		$renderVW->render();
	}
	
	
}

class renderView {
	private $resultSet;
	private $template;
	private $view;
	public $rootPath;
	private $css;
	private $assets;
	
	private $javascript;
	private $images;
	private $jsfiles;
	private $cssfiles;
	private $controllername;
	private $actionname;
	private $params;
	private $pageTitle;
	
	public function renderView($template='',$view='',$result='', $controllername='', $action='', $params='') {
		$this->controllername = $controllername;
		$this->actionname = $action;
		$this->params = $params;
		 $this->template = $template;
		 $this->view = $view;
		$this->resultSet = $result;
	}
	
	public function view() {
		if($this->view != '') {
			require($this->view);
		}
	}
	
	public function render() {
		$imageCDN = Config::read('imageCDN.'.Config::read('environment'));
		$jsCDN = Config::read('jsCDN.'.Config::read('environment'));
		$cssCDN = Config::read('cssCDN.'.Config::read('environment'));
		$assetsCDN = Config::read('assetsCDN.'.Config::read('environment'));

		if(trim($assetsCDN)=='') {
			$this->assets = $this->rootPath.'assets/';
		}else{
			$this->assets = '//'.$assetsCDN.'/';
		}

		if(trim($cssCDN)=='') {
			$this->css = $this->assets.'css/';
		}else{
			$this->css = '//'.$cssCDN.'/';
		}
		if(trim($jsCDN)=='') {
			$this->javascript = $this->assets.'js/';
		}else{
			$this->javascript = '//'.$jsCDN.'/';
		}
		if(trim($imageCDN)=='') {
			$this->images = $this->assets.'images/';
		}else{
			$this->images = '//'.$imageCDN.'/';
		}

		if($this->template!=''){
			require($this->template);
		}else{
			require($this->view);

		}

	}

	public function setPageTitle($pageTitle) {
		$this->pageTitle = $pageTitle;
	}
	
	public function setJs($js) {
		$this->jsfiles = $js;
	}
	public function setCss($css) {
		$this->cssfiles = $css;
	}
	public function setRootPath($pth = '') {
		$this->rootPath = $pth;
	}
	
	private function url($link,$isprefix=false) {
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
	
	private function getAllJavascript() {
		$out = '';
		if(!empty($this->jsfiles)) {
			if(is_array($this->jsfiles)) {
				foreach ($this->jsfiles as $files) {
					$out.= '<script type="text/javascript" language="javascript" src="'.$this->javascript.$files.'"></script>';
				}				
			} else{
					$out = '<script type="text/javascript" language="javascript" src="'.$this->javascript.$this->jsfiles.'"></script>';
			}
		}
		return $out;
	}
	
	private function getAllCss() {
		$out = '';
		if(!empty($this->cssfiles)) {
			if(is_array($this->cssfiles)) {
				foreach ($this->cssfiles as $files) {
					if(file_exists(SERVER_ROOT . '/css/'.$files)) {
						$out.='<link rel="stylesheet" type="text/css" href="'.$this->css.$files.'">';
					}
				}				
			} else{
				if(file_exists(SERVER_ROOT . '/css/'.$this->cssfiles)) {
					$out = '<link rel="stylesheet" type="text/css" href="'.$this->css.$this->cssfiles.'">';
				}
			}
		}
		return $out;		
	}
	
	public function getFlashMessage(){
		$message = isset($_SESSION['alanee_flashmessage']) ? $_SESSION['alanee_flashmessage'] : null;
		unset($_SESSION['alanee_flashmessage']);
		return $message;
	}
}

?>