<?php
class user {
	function __construct(){
		$this->db	     = new mysql();
	}
	/**
	* Function to get client tickets list
	*/
	function getUserList(){
		$this->db->open();
                $query_pag_data   = "SELECT usr.*, usertype.type_name AS user_type_name, usertype.type_description AS user_type_desc, userstatus.status_name AS user_status_name, userstatus.status_description AS user_status_desc FROM `user_accounts` usr, `user_types` usertype, `user_statuses` userstatus WHERE usertype.`id` = usr.`user_type_id` AND userstatus.`id` = usr.`user_status_id` AND userstatus.`status_key` = 'active' AND usr.`email_verification` = 'Y' AND usr.`user_post_alert` = 'Y'  ORDER BY usr.`id` DESC";            
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	}
	
	function getAllUserList(){
		$this->db->open();
		$query_pag_data   = "SELECT usr.*, usertype.type_name AS user_type_name, usertype.type_description AS user_type_desc, userstatus.status_name AS user_status_name, userstatus.status_description AS user_status_desc FROM `user_accounts` usr, `user_types` usertype, `user_statuses` userstatus WHERE usertype.`id` = usr.`user_type_id` AND userstatus.`id` = usr.`user_status_id` ORDER BY usr.`id` DESC";
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	}
	
	function getAllmailTemplate(){
		$this->db->open();
		$query_pag_data   = "SELECT `email_templates_id`,`email_templates_code`,`email_templates_subject`,`email_templates_message`,`email_templates_variable` FROM `email_templates` ORDER BY email_templates_id DESC";
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	}
	
	function getCompanyList(){
		$this->db->open();
        $query_pag_data   = "SELECT * FROM `user_company`";            
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;		
	}
        
               
        
        function getUserDetails($userId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM `user_accounts` WHERE id='$userId'";            
		$userDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userDetails;
            
        }
        
        function getCompanyDetails($companyId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM `user_company` WHERE `id`='$companyId'";            
		$userDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userDetails;
            
        }       
        
        function getAllUserTypes(){
                 $this->db->open();		
                $query_pag_data   = "SELECT * FROM `user_types`";            
		$userTypes = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userTypes;       	
        	
        }
        
        function getAllUserStatus(){
                 $this->db->open();		
                $query_pag_data   = "SELECT * FROM `user_statuses`";            
		$userStatuses = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userStatuses;       	
        	
        }

         function getAllUserCompanies(){
                 $this->db->open();		
                $query_pag_data   = "SELECT * FROM `user_company`";            
		$userCompanies = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userCompanies;       	
        	
        }       

         function getAllUserCountries(){
                 $this->db->open();		
                $query_pag_data   = "SELECT * FROM `country`";            
		$userCountries = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userCountries;
        	
        } 

        function isEmailRegistered($email, $uid){
        	$this->db->open();		
             $query_pag_data   = "SELECT * FROM  `user_accounts` WHERE `email`='".mysqli_real_escape_string($this->db->connection,$email)."'";
            if($uid != 0){
            	 $query_pag_data.=" AND `id` != $uid";
            }
			$details = $this->db->fetchArray($this->db->query($query_pag_data));
			$this->db->close();
			if (isset($details[0]) && count($details)>0){
				return true;
			}else{
				return false;
			}
        	
        }
        
        function updateUserProfile($profile,$uid){
        	$this->db->open();
        	$sql_update = "UPDATE `user_accounts` SET ";
        	foreach ($profile as $field => $postVal){
        		if($field == 'company_id' && $postVal == ''){
        			$sql_update.="`$field` = NULL, ";
        		}else{
        			$sql_update.="`$field` = '".mysql_real_escape_string($postVal)."', ";
        		}
        	}
        	$sql_update = trim($sql_update, ', ');
        	$sql_update.=" WHERE `id` = $uid";
        	$this->db->query($sql_update);
	    	$this->db->close();
        }
        
        function updateCompanyProfile($profile,$uid){
        	$this->db->open();
        	$sql_update = "UPDATE `user_company` SET ";
        	foreach ($profile as $field => $postVal){
				$sql_update.="`$field` = '$postVal', ";
        	}
        	$sql_update = trim($sql_update, ', ');
        	$sql_update.=" WHERE `id` = $uid";
        	$this->db->query($sql_update);
	    	$this->db->close();
        }       
        
        function addNewCompany($profile){
            $this->db->open();
        	$sql_insert_into = "INSERT INTO `user_company`(";
        	$sql_insert_values = "VALUES(";
        	foreach ($profile as $field => $postVal){
        		$sql_insert_into.="`$field`, ";
        		$sql_insert_values.="'$postVal', ";
        	}
        	$sql_insert = trim($sql_insert_into, ', ').") ".trim($sql_insert_values, ', ').")";
        //	exit($sql_insert);
        	$this->db->query($sql_insert);
	    	$this->db->close();
        }
        
        function addNewUserProfile($profile){
        	$this->db->open();
        	$sql_insert_into = "INSERT INTO `user_accounts`(";
        	$sql_insert_values = "VALUES(";
        	foreach ($profile as $field => $postVal){
        		$sql_insert_into.="`$field`, ";
        		if($field == 'company_id' && $postVal == ''){
        			$sql_insert_values.="NULL, ";
        		}else{
        			$sql_insert_values.="'$postVal', ";
        		}
        	}
        	$sql_insert = trim($sql_insert_into, ', ').") ".trim($sql_insert_values, ', ').")";
        //	exit($sql_insert);
        	$this->db->query($sql_insert);
	    	$this->db->close();
        }
        
        
        function getUserTitle($titleId){
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM  user_title WHERE user_title_id='$titleId'";            
		$userTitles = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userTitles[0]['user_title_value'];
        }
        
        
        
        
        function getUserCountry($countryId){
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM  country WHERE country_id='$countryId'";            
		$userCountry = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userCountry[0]['country_name'];
        }
        
        
        function getUserPosition($positionId){
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM  user_position WHERE user_position_id='$positionId'";            
		$userPosition = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userPosition[0]['user_position_value'];
        }
        
        function getUserResponsibility($resId){
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM user_responsibility WHERE user_responsibility_id='$resId'";            
		$userRes = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userRes[0]['user_responsibility_value'];
        }
        
        function getUserIndustry($indsId){
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM  user_industry WHERE user_industry_id='$indsId'";            
		$userInds = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $userInds[0]['user_industry_value'];
        }
        
        
         function changeUserStatus($userId,$status){
            if($status == 'N'){
                $status = 'Y';
            }
            else{
                $status = 'N';
            }
            $this->db->open();
            $query   = "update  user set user_status  = '$status' where user_id = '$userId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;
            
        }
        
        function changeCompanyStatus($companyId, $status){
              if($status == 'N'){
                $status = 'Y';
            }
            else{
                $status = 'N';
            }
            $this->db->open();
            $query   = "update `user_company` set company_status  = '$status' where `id` = '$companyId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;      	
        }
		
		function userDelete($userId){
            
                $this->db->open();		
                $query   = "UPDATE `user_accounts` SET `user_status_id` = 1 WHERE `id`='$userId'";            
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;
            
        }
		
		
        
         function changeUserPostAlertStatus($userId,$status){
            if($status == 'N'){
                $status = 'Y';
            }
            else{
                $status = 'N';
            }
            $this->db->open();
            $query   = "update  `user_accounts` set `user_post_alert`  = '$status' where id = '$userId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;
            
        }
        
        function addCronQueue($postId){
                $this->db->open();
                $sql = "INSERT INTO `post_email_queue`(`post_id`, `user_id`, `post_email_queue_status`) SELECT $postId, id, 'N' FROM `user_accounts`";
                $results = $this->db->query($sql);
                return $results;
                $this->db->close();
        }
        
         function changeMailQuePostStatus($postId){
           
            $this->db->open();
            $query   = "update  post_email_queue  set post_email_queue_status  = 'Y' where post_id = '$postId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;
            
        }
        
        
        
	
}
?>
