<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;

class Mailqueue extends Model{
	protected $table = TBL_MAIL_QUEUE;
	public function addToQueue($mail_type,$mail_to,$mail_from,$data){
		try {
				$sql = "INSERT INTO `mail_queue`(`mail_type`,`mail_to`,`mail_from`,`data`) VALUES('{$mail_type}','{$mail_to}','{$mail_from}','{$data}')";
				return DB::insert($sql);
		}catch (Exception $ex){
			throw new Exception('Mail Queue : Database error..', 9999);
		}
		
		
	}
	
	public function getAllMailQueue(){
		try {
			
			$result = array();
			$rs = Mailqueue::limit(100)->get();
			
		
			if($rs->count()>0) {
				
					$result = $rs->toArray();
				
			}
			return $result;
	
		}catch (Exception $ex){
			throw new Exception('Database error..', 9999);
		}
	}
	
	public function getMailQueueByType($mail_type){
		try {
			$result = array();


		$rs = Mailqueue::where('mail_type', $mail_type)->get();
			
		
			if($rs->count()>0) {
				
					$result = $rs->toArray();
				
			}

		
			
			return $result;
				
		}catch (Exception $ex){
			throw new Exception('Database error..', 9999);
		}
	}
	
	public function deleteThisMailQueue($id){
		$response = false;
		try{
			$affectedRows = Mailqueue::where('id', $id)->delete();
		
			if($affectedRows) {
				$response = true;
			}
			else {
				throw new Exception('Database error..', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}		
			return $response;
	}

	
	
}

?>