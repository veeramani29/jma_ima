<?php
    
class admin {
	function __construct(){
			$this->db	     = new mysql();
	}
    function isLogged(){
		if(isset($_SESSION['jma_admin_id'])){
			if($_SESSION['jma_admin_id']>0)
				return true;
			else
				return false;
		}else{
			return false;
		}
	}    
    function terminateLoggin(){
	
		$userId = $_SESSION['jma_admin_id'];
		$_SESSION['jma_admin_id'] ='';
        unset($_SESSION['jma_admin_id']);
    }  
	/**
	 * Function to check login details are currect or not
	 * If yes register user session
	 */ 
	function isLogginDetailsCurrect($userName,$password){
		$password = md5($password);
		$sql = "select * from admin where user  = '$userName' and password  = '$password'";
		$this->db->open();
		$results = $this->db->fetchArray($this->db->query($sql));
		$this->db->close();
		if(count($results)>0){			
			$userId = $results[0]['admin_id'];
			$_SESSION['jma_admin_id'] = $results[0]['admin_id'];
			$_SESSION['jma_admin_name'] = $results[0]['user'];				
			$returnResult['code']=1;
		}else{
			$returnResult['msg']='In correct login.';
		}
		return 	$returnResult;
	} 
	
	/**
	 * Function to get user details
	 */ 
	function getAdminDetails($admin_id){
		$sql = "select * from admin_details where admin_id = '$admin_id'";
		$this->db->open();
		$results = $this->db->fetchArray($this->db->query($sql));
		$this->db->close();
		return $results;
	}
	 function isPasswordExist($password)
        {
             $sql = "select * from admin where admin_id = '".$_SESSION['jma_admin_id']."' AND password ='".$password."'";
             echo $sql;
		$this->db->open();
		$results = $this->db->fetchArray($this->db->query($sql));

		$this->db->close();
		if(count($results)>0){
			return true;
		}else{
			return false;
		}
        }
    
   function updatePassword($password)
   {
   		$this->db->open();
  	        $updateQuery = "update admin set password = '$password' where admin_id = '".$_SESSION['jma_admin_id']."'";
		$this->db->query($updateQuery);
   }
   
    function getSettings(){
               $sql = "select * from settings";
		$this->db->open();
		$results = $this->db->fetchArray($this->db->query($sql));
		$this->db->close();
		return $results;
       
   }
   
   function updateSettings($id,$status){
                 if($status == 'Y'){
                     $status = 'enable';
                 }
                 else{
                      $status = 'disable';
                 }
                 $this->db->open();
  	        $updateQuery = "update  settings set settings_value = '$status' where settings_id  = '$id'";
		$this->db->query($updateQuery);
   }
    
    
}
?>
