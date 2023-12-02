<?php

/*~ class.user.php
/**
 * Manage users in message board system
 * NOTE: Requires PHP version 5 or later
 * @package Users
 * @author bonie@reowix.in
 * @copyright 2012 reowix
 * @creatd on 6 july 2012
 */

class copywriter{
     function __construct(){
		$this->db	     = new mysql();
	}
        
        /**
        * Check unique email check for user registration
        * @param string $email    
        * @return ret          
        */
        
        function uniqueMailCheck($email){

                        $ret = 0;
                        $this->db->open();
                        $query_pag_data   = "SELECT * FROM copywriter where copywriter_email = '$email'";   
                        $emaiList = $this->db->fetchArray($this->db->query($query_pag_data));
                        if(count($emaiList)>0){
                            $ret= 1;
                        }
                        $this->db->close();
                        return $ret;
        }
        
         function uniqueUserCheck($user){

                        $ret = 0;
                        $this->db->open();
                        $query_pag_data   = "SELECT * FROM copywriter where copywriter_user = '$user'";   
                        $userList = $this->db->fetchArray($this->db->query($query_pag_data));
                        if(count($userList)>0){
                            $ret= 1;
                        }
                        $this->db->close();
                        return $ret;
        }
        
      function addWriter($arrRecord) {
        $this->db->open();
        $results = $this->db->insertRecord('copywriter', $arrRecord);
        return $results;
        $this->db->close();
      }
      
       function changeStatus($userId,$status){
            if($status == 'N'){
                $status = 'Y';
            }
            else{
                $status = 'N';
            }
            $this->db->open();
            $query   = "update  copywriter set copywriter_status  = '$status' where copywriter_id = '$userId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;
            
        }
        
       function  getIndividualCopyWriter($id){
                $this->db->open();		
                $query   = "SELECT * FROM copywriter WHERE copywriter_id='$id'";   
		$userDetails = $this->db->fetchArray($this->db->query($query));
		$this->db->close();
		return $userDetails;
        }
        
      
        
         function  getsingleCopyWriter($id){
                $name = '';
                $this->db->open();		
                $query   = "SELECT * FROM copywriter WHERE copywriter_id='$id'";   
		$userDetails = $this->db->fetchArray($this->db->query($query));
                $name  = $userDetails[0]['copywriter_user'];
		$this->db->close();
		return $name;
        }
        
        function updateWriter($userId,$email,$password){
          
            $this->db->open();
             if($password != ''){
               $password = md5($password);
               $query1   = "update copywriter set copywriter_password='$password' where copywriter_id = '$userId'";
               $results = $this->db->query($query1);
             }
             if($email !=''){
               $query2   = "update copywriter set copywriter_email = '$email' where copywriter_id = '$userId'";
               $results = $this->db->query($query2);
             }
           
	    $this->db->close();
            return $results;
            
        }
   
       
        /**
        * Get all registerd users
        * @return $usersList Arr          
        */
     
        function getCopyWriters(){
            
                $this->db->open();		
                $query   = "SELECT * FROM copywriter";  
		$users = $this->db->fetchArray($this->db->query($query));
		$this->db->close();
		return $users;            
        }
        
        
         function getActiveCopyWriters(){
            
                $this->db->open();		
                $query   = "SELECT * FROM copywriter where copywriter_status = 'Y'";  
		$users = $this->db->fetchArray($this->db->query($query));
		$this->db->close();
		return $users;            
        }
        
        
        /**
        * Delete user,post and comments
        * @param string $userId
        * @return $results          
        */
        
        function deleteUser($userId){
            
            $this->db->open();
            $query   = "delete from user_details  where id = '$userId'";
            $results = $this->db->query($query);
            if($results == 1){
                $query2  = "delete from post_details  where user_id = '$userId'";
                $results = $this->db->query($query2);
                $query3  = "delete from comment_details  where user_id = '$userId'";
                $results = $this->db->query($query3);
               
            }
	    $this->db->close();
            return $results;
            
        }
   
}
?>
