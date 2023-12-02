<?php
define('SERVER_ROOT' , dirname(dirname(__FILE__)));
define('SITE_URL' , $_SERVER['HTTP_HOST'].'/');
require SERVER_ROOT.'/alanee_lib/config/conf.php';

class Cron {
	public $notificationMailTo;
	protected $modal;
	public $classes = array();
	
	public function Cron() {
		if(Config::read('environment') == 'production' && PHP_SAPI != 'cli'){
			exit ("Error... Direct script execution is prohibited");
		}
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
}