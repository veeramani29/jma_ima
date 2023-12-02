<?php
use Dotenv\Dotenv;
$dotenv = new Dotenv(SERVER_ROOT);
$dotenv->load();
/**
 *
* Class file for handling all Memcached functionalities.
* @author Shijo Thomas : shijo@alanee.com
*
*/

class Alaneememcached {
	private $memcached_server;
	private $memcached_port;
	
	public function Alaneememcached(){
		//Configure Memcached server details
		/* $config_file = '../config/conf.ini';
		$confVals = parse_ini_file($config_file,true);
		$conf_env = $confVals['environment']; */
		$this->memcached_server = env('memcached_server');
		$this->memcached_port = env('memcached_port');
	}
	
public function getServer(){
		try {
			if(class_exists('Memcached')){
				$m = new Memcached();
				$m->addServer($this->memcached_server,$this->memcached_port);
				
				return $m;
			}elseif(class_exists('Memcache')){
				$m = new Memcache();
				$m->addServer($this->memcached_server,$this->memcached_port);
				
				return $m;
			}else{
				throw new Exception('No Memcached configuration exists', 9999);
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
			
			
			if(class_exists('Memcached')){
		    $keys = $this->getAllKeys();
		}else{
			$keys = $m->getAllKeys();
		}

		
		    if ($prefix !== false) {
		        foreach ($keys as $index => $key) {
		            if (strpos($key,$prefix) == 0) {

		                $m->delete(trim("$key"));
		               
		                $result = true;
		            }
		        }
		    }
		}catch (Exception $ex){
			
		}
		return $result;
	}

	
	public function set($key,$data,$expiry_seconds=0){
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
	
	public function getAllKeys(){
	$memcache = $this->getServer();

    $list = array();
if(class_exists('Memcached')){
   	$keys = $memcache->getAllKeys();
}else{
	 $allSlabs = $memcache->getExtendedStats('slabs');
    $items = $memcache->getExtendedStats('items'); 
				
    if(!empty($allSlabs)){
    foreach($allSlabs as $server => $slabs) {
        foreach($slabs AS $slabId => $slabMeta) {
            @$cdump = $memcache->getExtendedStats('cachedump',(int)$slabId);
            foreach($cdump AS $keys => $arrVal) {
                if (!is_array($arrVal)) continue;
                foreach($arrVal AS $k => $v) {                   
                     $list[]=$k;
                    // echo $k .'<br>';
                }
            }
        }
    }   
}
    $keys = $list;


}
		
		return $keys;
	}
	
	public function flushCache(){
		$m = $this->getServer();
		if($m->flush()){
			return true;
		}else{
			return false;
		}
	}
	
	public function test(){
		return "alanee memcached...";
	}
	
}


?>