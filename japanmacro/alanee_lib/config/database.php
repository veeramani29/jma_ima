<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class AlaneeDb {
	private $host;
	private $database;
	private $user;
	private $password;
	public $dbCon;
	public function AlaneeDb() {
		$db_config_file = SERVER_ROOT.'/config/database.ini';
		$dbVals = parse_ini_file($db_config_file,true);
		$config = $dbVals[Config::read('environment')];
		$this->host = $config['host'];
		$this->database = $config['database'];
		$this->user = $config['user'];
		$this->password = $config['password'];
	}
	public function getConnection() {
		$this->dbCon = new mysqli($this->host,$this->user,$this->password,$this->database);
	//	$this->dbCon->set_charset("utf8");
		return $this->dbCon;
	}
	
	public function closeConnection() {
		$this->dbCon->close();		
	}
	
}
?>