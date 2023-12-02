<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;

class Userpermissions extends Model {
	    protected $table = TBL_USER_PERMIT;

	public function getPermissionArrayForThisUserTypeAndStatus($user_type_id,$user_status_id){
		$response = array();

	$data = Userpermissions::select('permission')->where('user_type_id',$user_type_id)->where('user_status_id',$user_status_id)->limit(1)->get();
		$get_Count = $data->count();
		if($get_Count>0) {

			$permissions=$data->toArray();
		
			$response = json_decode($permissions[0]['permission'],true);
		}
		return $response;
	}
}

?>

