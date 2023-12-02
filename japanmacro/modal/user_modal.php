<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class User extends AlaneeModal {
	
	public function getPositionsDatabase() {
		$response = array();
		$sql = "SELECT * FROM `user_position`";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}
	
	public function getUserTitleDatabase(){
		$response = array();
		$sql = "SELECT * FROM `user_title`";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;			
		
	}
	
	public function getIndustryDatabase() {
		$response = array();
		$sql = "SELECT * FROM `user_industry`";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}	
	
	public function getResponsibilityDatabase() {
		$response = array();
		$sql = "SELECT * FROM `user_responsibility`";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}	
	
	public function checkUserExistsByEmail($reg_email) {
		$response = false;
		$sql = "SELECT * FROM `user_accounts` WHERE email = '$reg_email'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$response = true;
		}
		return $response;	
	}
	
	function checkLinkedInUserExists($userdata,$password,$user_type_id,$user_type,$defultAlertValue=false){
		$oauth_uid = $userdata->id;
		$email = $userdata->emailAddress;
		$country = $this->getCountryId($userdata->location->country->code);
		if ($user_type=='corporate'){
						$user_upgrade_status = 'RC';
						}else{
						$user_upgrade_status = 'NU';
						}

		$registered_on = time();
		$check = $this->executeQuery("SELECT * FROM `user_accounts` WHERE email = '".$email."' AND linkedin_enabled = 'N'");
		if($check->num_rows > 0){
			$result = $check->fetch_array(MYSQLI_ASSOC);
			$query = "UPDATE `user_accounts` SET fname = '".$userdata->firstName."', lname = '".$userdata->lastName."', email = '".$userdata->emailAddress."', country_id = '".$country."', oauth_uid = '".$userdata->id."', linkedin_enabled = 'Y' WHERE id = ".$result['id'];
			$this->executeQuery($query);
			$userData = array(
							'id' => $result['id'],
							'res' => 'update'
						);
			//$userId = $result['id'];
		}else{
			 $user_status_id=($user_type_id==2)?2:4;
			 $expiry_on=($user_type_id==2)?strtotime("+3 months", time()):0;
			 
			 $userDetails = array(
							'fname' => $userdata->firstName,
							'lname' => $userdata->lastName,
							'email' => $userdata->emailAddress,
							'password' => $password,
							'country_id' => $country,
							'user_type_id' => $user_type_id, //Free
							'user_status_id' => $user_status_id, //Active
							'registered_on' => $registered_on,
							'expiry_on' => $expiry_on,
							'email_verification' => 'Y',
							'user_upgrade_status' => $user_upgrade_status,
							'linkedin_enabled' => 'Y',
							'oauth_uid' => $userdata->id
							
					);
			 
				 if($defultAlertValue != false)
				 {
					$userDetails['want_to_email_alert'] = $defultAlertValue;
				 }
			

			$check = $this->executeQuery("SELECT * FROM `user_accounts` WHERE email = '".$email."'");
			if($check->num_rows == 0){
				$u_details = $this->addUserRegistration($userDetails);
				$userData = array(
							'id' => $u_details['id'],
							'res' => 'insert'
						);
			}
			else {
				$result = $check->fetch_array(MYSQLI_ASSOC);
				$userData = array(
							'id' => $result['id'],
							'res' => 'update'
						);
			}
			//$userId = $u_details['id'];
			
		}
		return $userData;
	}
	public function linkedinDataExists($id){
		$query = "SELECT * FROM `linkedin_user_account` WHERE `user_id` = ".$id;
		$getResult = $this->executeQuery($query);
		return $getResult->num_rows;
	}
	public function updateLinkedinData($linkedinUserData){
		$email = $linkedinUserData->emailAddress;
		$country = $this->getCountryId($linkedinUserData->location->country->code);
		$check = $this->executeQuery("SELECT * FROM `user_accounts` WHERE email = '".$email."'");
		if($check->num_rows > 0){
			$result = $check->fetch_array(MYSQLI_ASSOC);
			$query = "UPDATE `user_accounts` SET fname = '".$linkedinUserData->firstName."', lname = '".$linkedinUserData->lastName."', email = '".$linkedinUserData->emailAddress."', country_id = '".$country."', user_type_id = 2, oauth_uid = '".$linkedinUserData->id."', linkedin_enabled = 'Y' WHERE id = ".$result['id'];
			$this->executeQuery($query);
			$userData = array(
							'id' => $result['id'],
							'res' => 'update'
						);
			//$userId = $result['id'];
		}
		return $userData;				
	}
	public function getCountryId($countryCode) {
		$query = "SELECT * FROM `country` WHERE `country_code` = '".strtoupper($countryCode)."'";
		$getResult = $this->executeQuery($query);
		$result = $getResult->fetch_array(MYSQLI_ASSOC);
		return $result['country_id'];
	}
	public function addUserRegistration($userDetails) {
	
		$response = array();
		$user_array = array();
		$fields = '';
		$values = '';
		foreach ($userDetails as $ky => $val) {
			$fields.=',`'.$ky.'`';
			$values.=",'".$val."'";
		}
		//echo($values);
		$query ="INSERT INTO `user_accounts` (".trim($fields,',').")";
		$query.=" VALUES (".trim($values,',').")";
		$uid = $this->insertQuery($query);
		if($userDetails['password']) {
			unset($userDetails['password']);
		}
		$response = array_merge(array('id'=>$uid),$userDetails);
		$userPermissions = new Userpermissions();
		$response['user_permissions'] = $userPermissions->getPermissionArrayForThisUserTypeAndStatus($userDetails['user_type_id'], $userDetails['user_status_id']);
		return $response;	
	}


public function linkedinDataInsert($userDetails) {

	
		$response = array();
		$user_array = array();
		$fields = '';
		$values = '';
		foreach ($userDetails as $ky => $val) {
			$fields.=',`'.$ky.'`';
			$values.=",'".$val."'";
		}
		//echo($values);
		$query ="INSERT INTO `linkedin_user_account` (".trim($fields,',').")";
		$query.=" VALUES (".trim($values,',').")";
		$uid = $this->insertQuery($query);
		return;	
	}
	
	public function linkedinDataUpdate($linkedinData) {
		$query ="UPDATE linkedin_user_account SET industry='".$linkedinData['industry']."',company_name='".$linkedinData['company_name']."', company_industry = '".$linkedinData['company_industry']."' WHERE user_id=".$linkedinData['user_id'];
		$result = $this->executeQuery($query);
		return;	
	}

	public function check_user_status($username,$password) {
		
		
		  $sql = "SELECT `id` FROM `user_accounts` WHERE `email` = '".addslashes($username)."' AND `password` = '".addslashes($password)."'  LIMIT 1";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows==1){

			$sql = "SELECT `id` FROM `user_accounts` WHERE `email` = '".addslashes($username)."' AND `password` = '".addslashes($password)."' AND `user_status_id` IN(4,7,6) LIMIT 1";
			$row = $this->executeQuery($sql);

			if($row->num_rows==1){
				return true;
			}else{
			return "This account is inactive.Please contact support";
			}

		}else{
			return "Invalid username and password";
		}
		
			
	}



	public function check_linkedin_user_status($username) {
		
		
	

			  $sql = "SELECT `id` FROM `user_accounts` WHERE `email` = '".addslashes($username->emailAddress)."' AND `linkedin_enabled` = 'Y' AND `user_status_id` IN(4,7,6) LIMIT 1";
			$row = $this->executeQuery($sql);

			if($row->num_rows==1){
				return true;
			}else{
			return "This account is inactive.Please contact support";
			}

		
			
	}

	
	public function getUserDetailsByUserNameAndPassword($username,$password) {
		$response = array();
		//$sql = "SELECT clients_company.*, clients_accounts.* FROM `clients_company`, `clients_accounts` WHERE clients_accounts.clients_accounts_email = '".$username."' AND clients_accounts.clients_accounts_password = '".$password."' AND clients_company.clients_company_id = clients_accounts.clients_accounts_company_id AND clients_company.clients_company_status = 'Y'";
		$sql = "SELECT `user_accounts`.*, `user_statuses`.`status_key` as user_status, `user_types`.`type_key` as user_type  FROM `user_accounts`, `user_statuses`, `user_types` WHERE `user_accounts`.`email` = '".addslashes($username)."' AND `user_accounts`.`password` = '".addslashes($password)."' AND `user_accounts`.`user_status_id` IN(4,6,7) AND `user_statuses`.`id` = `user_accounts`.`user_status_id` AND `user_types`.`id` = `user_accounts`.`user_type_id` LIMIT 1";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
				$response = $rs->fetch_assoc();
				$userPermissions = new Userpermissions();
				$response['user_permissions'] = $userPermissions->getPermissionArrayForThisUserTypeAndStatus($response['user_type_id'], $response['user_status_id']);
		}
		return $response;	
	}
	
	public function getUserDetailsById($profileId) {

		$response = array();
		$sql = "SELECT `user_accounts`.*, `user_statuses`.`status_key` as user_status, `user_types`.`type_key` as user_type FROM `user_accounts`, `user_statuses`, `user_types` WHERE `user_accounts`.`id` = $profileId AND `user_statuses`.`id` = `user_accounts`.`user_status_id` AND `user_types`.`id` = `user_accounts`.`user_type_id` LIMIT 1";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$response = $rs->fetch_assoc();
			$userPermissions = new Userpermissions();
			$response['user_permissions'] = $userPermissions->getPermissionArrayForThisUserTypeAndStatus($response['user_type_id'], $response['user_status_id']);
		}
		return $response;	
	}
	
	
	
	
	public function updateProfile($userDetails) {
		$response = false;
		$sql = "UPDATE user_accounts SET user_title='".addslashes($userDetails['title'])."', fname='".addslashes($userDetails['fname'])."', lname='".addslashes($userDetails['lname'])."', country_id='".$userDetails['country_id']."',country_code='".$userDetails['country_code']."', phone='".$userDetails['phone']."' WHERE id=".$userDetails['id'];
		//exit($sql);
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}

	public function update_request_corporate($userDetails) {
		$response = false;
		 $sql = "UPDATE user_accounts SET user_upgrade_status='".addslashes($userDetails['user_upgrade_status'])."' WHERE id=".$userDetails['id'];
	
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}


	public function updateMyProfile($userDetails) {
		$response = false;
		if(isset($userDetails['user_upgrade_status'])){
			$query = ", user_upgrade_status = '".addslashes($userDetails['user_upgrade_status'])."'";
		}
			
		$sql = "UPDATE user_accounts SET fname='".addslashes($userDetails['fname'])."', lname='".addslashes($userDetails['lname'])."', country_id='".$userDetails['country_id']."', phone='".$userDetails['phone']."', user_position_id = '".addslashes($userDetails['user_position_id'])."',
						user_industry_id = '".addslashes($userDetails['user_industry_id'])."'".$query."
						WHERE id=".$userDetails['id'];
		//exit($sql);
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
	
	// srinivasan - fetch some category for email alert
	public function emailAlertCategory() {
		$response = array();
		$sql = "SELECT post_category_id,post_category_name FROM post_category WHERE `post_category_id` IN (SELECT post_category_id FROM post_category WHERE email_alert = 'Y') AND `post_category_status` = 'Y'";
		//exit($sql);
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$id = $rw['post_category_id'];
				$response[][$id] = $rw['post_category_name'];
			}
		}
		return $response;
	}
	
	
	public function defaultEmailAlert() {
		$response = array();
		$sql = "SELECT post_category_id FROM post_category WHERE default_email_alert = 'Y' AND `post_category_status` = 'Y'";
		//exit($sql);
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[].= $rw['post_category_id'];
			}
			
			//$response[] = $rs->fetch_assoc();
		}
		return $response;
	}
	
	
	public function emailAlertChoiceofUsers($uId) {
		$response = array();
		$sql = "SELECT want_to_email_alert FROM user_accounts  WHERE (id = '$uId' or email = '$uId') ";
		//exit($sql);
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$id = 'want_to_email_alert';
				$response[][$id] = $rw['want_to_email_alert'];
			}
		}
		return $response;
	}
	
	public function updateProfilePassword($user_id,$new_password) {
		$response = false;
		$sql = "UPDATE user_accounts SET password = '".$new_password."' WHERE id=".$user_id;
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
	}
	
	
	public function updateEmailAlert($user_id,$mailId,$thematic) {
		$response = false;
		$sql = "UPDATE user_accounts SET want_to_email_alert = '".$mailId."',breaking_News_Alert = '".$thematic."' WHERE id=".$user_id;
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
	}
	
	public function updateEmailAlertForRepoet($email,$mailId,$report) {
		$response = false;
		$sql = "UPDATE user_accounts SET want_to_email_alert = '".$mailId."', breaking_News_Alert = '".$report."' WHERE email='".$email."'";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
	}
	
	public function getUserDetailsByEmail($uEmail) {
		$response = array();
		$sql = "SELECT * FROM `user_accounts` WHERE  `email` = '$uEmail'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}
	
	public function getUserIdByEmail($uEmail) {
		$response = array();
		$sql = "SELECT `id` FROM `user_accounts` WHERE `email` = '$uEmail'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}
	
	public function deleteThisUser($userId) {
		$response = false;
		$sql = "DELETE FROM `user_accounts` WHERE  `id` = '$userId'";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;	
	}
	
	public function getClientDetailsByEmail($emailId) {
		$response = array();
		$sql = "SELECT * FROM `user_accounts` WHERE `email` = '$emailId'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;		
	}
	
	public function checkLinkedInUserByEmail($emailId) {
		$response = array();
		$sql = "SELECT * FROM `user_accounts` WHERE `email` = '$emailId' AND linkedin_enabled = 'Y' AND oauth_uid != ''";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;
	}
	
	public function validateUserEmail($userId) {
		$response = false;
		$sql = "UPDATE `user_accounts` SET `email_verification` = 'Y', `user_post_alert` = 'Y' WHERE id = $userId";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
	
	public function activateThisTrialAccount($uid,$new_expiry_date) {
		$response = false;
		$userStatuses = new Userstatuses();
		$status_id = $userStatuses->getStatusIdForThisStatus('active');
		$sql = "UPDATE `user_accounts` SET `user_status_id` = $status_id, `expiry_on` = '$new_expiry_date' WHERE id = $uid";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
	
	public function setExpiryOnDate($uid,$new_expiry_date) {
		$response = false;
		$sql = "UPDATE `user_accounts` SET `expiry_on` = '$new_expiry_date' WHERE id = $uid";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;	
	}
	
	public function setThisUserStatus($uid,$status) {
		$response = false;
		$userStatuses = new Userstatuses();
		$status_id = $userStatuses->getStatusIdForThisStatus($status);
		if($status_id>0) {
			 $sql = "UPDATE `user_accounts` SET `user_status_id` = {$status_id} WHERE `id` = {$uid}";
			if($this->executeQuery($sql)) {
				$response = true;
			}
		}
		return $response;
	}
	
	public function setThisUserUpgradeStatus($uid,$status){
		$response = false;
		$sql = "UPDATE `user_accounts` SET `user_upgrade_status` = '$status' WHERE id = $uid";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
	}
	
	public function setThisUserToPremium($uid){
		$response = false;
		$sql = "UPDATE `user_accounts` SET `user_type_id` = 2 WHERE id = $uid";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
	}
	
	public function setThisUserToFree($uid){
		$response = false;
		$sql = "UPDATE `user_accounts` SET `user_type_id` = 1 WHERE id = $uid";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
	}
	
	public function updatePaypalRecurrentprofileId($uid,$profile_id){
		$response = false;
		$sql = "UPDATE `user_accounts` SET `recurrent_profile_id` = '$profile_id' WHERE id = $uid";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
		
	}
	
	public function unSubscribeThisUserByEmail($email){
		$response = false;
		$sql = "UPDATE `user_accounts` SET `user_post_alert` = 'N' WHERE `email` = '".$email."'";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;		
	}
	
	public function updateStripeCusId($data){
		$response = false;
		$sql = "UPDATE `user_accounts` 
				SET `stripe_customer_id` = '".$data['customerId']."', `stripe_subscription_id` = '".$data['subscriptionId']."', `registered_on` = '".$data['startSubscription']."', `expiry_on` = '".$data['endSubscription']."'  
				WHERE `email` = '".$data['email']."'";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
	
	public function updateStripeSubId($data){
		$response = false;
		$sql = "UPDATE `user_accounts` 
				SET  `stripe_subscription_id` = '".$data['subscriptionId']."', `user_type_id` = 2 , `user_status_id` = 4, `expiry_on` = '".$data['endSubscription']."'
				WHERE `stripe_customer_id` = '".$data['customerId']."'";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
	
	public function fetchStripeDetails($id){
		$response = array();
		$sql = "SELECT `id`, `stripe_customer_id`, `stripe_subscription_id` FROM `user_accounts` WHERE  `id` = ".$id;
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}



	
	public function getUserDetailsByStripeCustomerId($stripe_customer_id) {
		$response = array();
		$sql = "SELECT `user_accounts`.*, `user_statuses`.`status_key` as user_status, `user_types`.`type_key` as user_type FROM `user_accounts`, `user_statuses`, `user_types` WHERE `user_accounts`.`stripe_customer_id` = '$stripe_customer_id' AND `user_statuses`.`id` = `user_accounts`.`user_status_id` AND `user_types`.`id` = `user_accounts`.`user_type_id` LIMIT 1";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}

		public function autoIncrementRenewalCycle($user_id,$renewal_cycle){

		$response = array();
		//SELECT user if status is active
		$sql = "SELECT * FROM `user_accounts` WHERE `user_status_id` = 4 AND `id` = ".$user_id;
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$sql = "UPDATE `user_accounts` set `renewal_cycle` =".$renewal_cycle."  WHERE  `id` = ".$user_id;	
			if($this->executeQuery($sql)) {
					$response = true;
			}
		}
		return $response;
	}

	/* By Veera Getting payment history*/

	public function get_payment_history($id){
		$response = array();
		 $sql = "SELECT UPA.*,PT.*  FROM `user_payment_log` as UPA left join `payment_transactions` as PT on PT.`id`=UPA.`transaction_id`  WHERE  UPA.`user_id` = ".$id;
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}


	public function user_deactivate($status,$id){
		if($status==1){
			$status_field='user_type_id';
		}else{
			$status_field='user_status_id';
		}
			$response = false;
		  $sql = "UPDATE `user_accounts` set `".$status_field."`='".$status."'  WHERE  `id` = ".$id;
		
		if($this->executeQuery($sql)) {
				$response = true;
		}
		return $response;	
	}

			public function find_folder_content(){

					$response = array();
					 $sql = "SELECT * FROM `mychart_user_folders` where (folder_contents!='NULL' AND folder_contents!='[]')";
					$rs = $this->executeQuery($sql);
					if($rs->num_rows>0) {
						//$response = $rs->fetch_all(true);
						while ($rw = $rs->fetch_assoc()) {
							$response[] = $rw;
						}
					}
				return $response;

								}


				public function update_folder_content($folder_content,$id){
				
				$response = false;
			 $sql = "UPDATE `mychart_user_folders` set `folder_contents`='".$folder_content."'  WHERE  `folder_id` = ".$id;

				if($this->executeQuery($sql)) {
				$response = true;
				}
				return $response;	
				}
	 


}

?>