<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class AlaneePlugin {
	private $AddClasses = array();
	public $classes = array();
	public $rootPath;

	
	public function AlaneePlugin() {
		$appPath = Config::read('appication_path') != '' ? trim(Config::read('appication_path'),'/').'/' : '';
		$this->rootPath = '//'.SITE_URL.$appPath;
		if (count($this->classes)>0) {
			foreach ($this->classes as $rwClasses) {
				$this->AddClasses[] = $rwClasses;
			}
		}	
		$autoloader = new Autoloader('modal');
		foreach ($this->AddClasses as $adtClass) {
			$autoloader->loadThisClass($adtClass);
		}
	}

	/**
	 * Setting a value in flash session
	 * @param string, array, int, bool $message
	 */
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