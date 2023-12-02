<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;

class Userpermissions extends Model {
	    protected $table = TBL_USER_PERMIT;
		
	public function getPermissionArrayForThisUserTypeAndStatus($user_type_id,$user_status_id){
		$response = array();
		$sql = "SELECT permission FROM `user_permissions` WHERE `user_type_id` = $user_type_id AND user_status_id = $user_status_id LIMIT 1";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			//$permissions = $rs->fetch_assoc();
			
			$permissions = json_decode(json_encode($rs), true);
			$response = json_decode($permissions[0]['permission'],true);
		}
		return $response;
	}
}

?>

