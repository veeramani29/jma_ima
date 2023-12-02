<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
/**
 *
* Class file for handling all Memcached functionalities.
* @author Shijo Thomas : shijo@alanee.com
*
*/

use Illuminate\Database\Eloquent\Model;
use Exception;
use Config;
use Memcached;
use RuntimeException;
class Memcachedclass extends Model {
	private $memcached_server;
	private $memcached_port;
	
	public function Alaneememcached(){
		//Configure Memcached server details
		$memcached_configurations = Config::read('memcached.'.app()->environment());
		$this->memcached_server = $memcached_configurations['server'];
		$this->memcached_port = $memcached_configurations['port'];
	}
	
	public function getServer(){
		try {
			if(env('APP_ENV')!='development'){
				$m = $this->getMemcached();
				$m->addServer($this->memcached_server,$this->memcached_port);
		 		$memcachedStatus = $m->getVersion();
				return $m;
			}
			else
			{
				if(class_exists('Memcached',false)){
				$m = new Memcached();
				$m->addServer($this->memcached_server,$this->memcached_port);
				return $m;
				}else{
					throw new Exception('No Memcached configuration exists', 9999);
				}
			}
		}catch (Exception $ex){
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	
	/* Delete all keys with key prefix */
	public function deletekeysbyindex($prefix = false) {
		$result = false;
		try {
			$m = $this->getServer();
		    $keys = $m->getAllKeys();
		    if ($prefix !== false) {
		        foreach ($keys as $index => $key) {
		            if (strpos($key,$prefix) == 0) {
		                $m->delete($key);
		                $result = true;
		            }
		        }
		    }
		}catch (Exception$ex){
			
		}
		return $result;
	}

	
	public function set($key,$data,$expiry_seconds=86400){
		$result = false;
		$expiry_time = $expiry_seconds == 0 ? 0 : time()+$expiry_seconds;
		try {
			$m = $this->getServer();
			if($m->set($key,$data,$expiry_time)){
				$result = true;
			}else{
				$result = false;
			}
		}catch (Exception $ex){
			$result = false;
		}
		return $result;
	}
	
	public function get($key){
		$result = false;
		try {
			$m = $this->getServer();
			$data = $m->get($key);
			if($data!= false && count($data)>0){
				$result = $data;
			}
		}catch (Exception $ex){
			
		}
		return $result;		
	}


	public function getChartData($alanee_memcached_ky){
		$result = array();
		try {
			$key = 'chartdata_'.$alanee_memcached_ky;
			$result = $this->get($key);
		}catch (Exception $ex){
				
		}
		return $result;
	}
	
	
	public function setChartData($alanee_memcached_ky,$indicator_values){
		$result = false;
		try {
			$key = 'chartdata_'.$alanee_memcached_ky;
			$result = $this->set($key,$indicator_values,0);
		}catch (Exception $ex){
	
		}
		return $result;
	}
	
	public function deleteAllChartData(){
		$prefix = 'chartdata_';
		return $this->deletekeysbyindex($prefix);
	}	
	
	public function test(){
		return "alanee memcached...";
	}
	
}


?>