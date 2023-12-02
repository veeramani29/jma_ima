<?php

namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use App;
use App\Model\Userpermissions;
class User extends Model
{
    protected $table = TBL_USER;
	
    public function getPositionsDatabase() {
        $response = array();

        $get_Cat = DB::table(TBL_USER_POSITION)->get();
      
        $get_Count = count($get_Cat);
        if($get_Count>0) {
          
            
            $response = $get_Cat;
        
        }

      
        return $response;   
    }
    
    public function getUserTitleDatabase(){
        $response = array();
       
        $get_Cat = DB::table(TBL_USER_TITLE)->get();
        $get_Count = count($get_Cat);
        if($get_Count>0) {
           
            
            $response = $get_Cat;
        
        }

        return $response;           
        
    }
    
    public function getIndustryDatabase() {
        $response = array();


        $get_Cat = DB::table(TBL_USER_INDUSTRY)->get();
      
        $get_Count = count($get_Cat);
        if($get_Count>0) {
          
            $response = $get_Cat;
        
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
        $rs = User::where('email',$reg_email)->get();

      
        if(count($rs)>0) {
            $response = true;
        }
        return $response;   
    }
    
    function checkLinkedInUserExists($userdata,$password,$user_type_id,$user_type){
        $oauth_uid = $userdata->id;
        $email = $userdata->emailAddress;
       # $country = $this->getCountryId($userdata->location->country->code);
         $country ='';
        if ($user_type=='corporate'){
                        $user_upgrade_status = 'RC';
                        }else{
                        $user_upgrade_status = 'NU';
                        }

        $registered_on = time();
        $check =User::where('email',$email)->where('linkedin_enabled','N')->get();

        if($check->count()> 0){
            $result = $check->toArray();
          
            $query = "UPDATE `user_accounts` SET fname = '".$userdata->firstName."', lname = '".$userdata->lastName."', email = '".$userdata->emailAddress."', country_id = '".$country."', oauth_uid = '".$userdata->id."', linkedin_enabled = 'Y' WHERE id = ".$result[0]['id'];
            DB::statement($query);
          
            $userData = array(
                            'id' => $result[0]['id'],
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

            $check =User::where('email',$email)->get();

            if($check->count() == 0){
                $u_details = $this->addUserRegistration($userDetails);
                $userData = array(
                            'id' => $u_details['id'],
                            'res' => 'insert'
                        );
            }
            else {
                $result = $check->toArray();
                
                $userData = array(
                            'id' => $result[0]['id'],
                            'res' => 'update'
                        );
            }
            //$userId = $u_details['id'];
            
        }
        return $userData;
    }
    public function linkedinDataExists($id){
        $users = DB::table(TBL_USER_LINKEDIN)->where('user_id',$id)->count();

        return $users;
    }
    public function updateLinkedinData($linkedinUserData){
        $email = $linkedinUserData->emailAddress;
        $country = $this->getCountryId($linkedinUserData->location->country->code);
           $check =User::where('email',$email)->get();

      
        if($check->count() > 0){
            $result = $check->toArray();
            $query = "UPDATE `user_accounts` SET fname = '".$linkedinUserData->firstName."', lname = '".$linkedinUserData->lastName."', email = '".$linkedinUserData->emailAddress."', country_id = '".$country."', user_type_id = 2, oauth_uid = '".$linkedinUserData->id."', linkedin_enabled = 'Y' WHERE id = ".$result[0]['id'];
             DB::statement($query);
           # $this->executeQuery($query);
            $userData = array(
                            'id' => $result[0]['id'],
                            'res' => 'update'
                        );
            //$userId = $result['id'];
        }
        return $userData;               
    }
    public function getCountryId($countryCode) {
    
         $result =  DB::table(TBL_COUNTRY)->where('country_code',strtoupper($countryCode))->first();
      
         $result_ = ($result['country_id']!=null)?$result['country_id']:$result->country_id;
        return $result_;
    }
    public function addUserRegistration($userDetails) {
    
        $response = array();
        
        $uid =  DB::table(TBL_USER)->insertGetId($userDetails);
 
        if($userDetails['password']) {
            unset($userDetails['password']);
        }
        $response = array_merge(array('id'=>$uid),$userDetails);
        $userPermissions = new Userpermissions();
        $response['user_permissions'] = $userPermissions->getPermissionArrayForThisUserTypeAndStatus($userDetails['user_type_id'], $userDetails['user_status_id']);
        return $response;   
    }



    public function updateEmailAlert($user_id,$mailId,$thematic) {
		
        $response = false;
        $rs=DB::table(TBL_USER)->where('id',$user_id)->update(array('want_to_email_alert' => $mailId,'breaking_News_Alert' => $thematic));
       
        if($rs!=null) {
            $response = true;
        }


        
        return $response;       
    }

public function linkedinDataInsert($userDetails) {

    
      
       $uid =  DB::table(TBL_USER_LINKEDIN)->insertGetId($userDetails);

        return $uid; 
    }
    
    public function linkedinDataUpdate($linkedinData) {
        $query ="UPDATE linkedin_user_account SET industry='".$linkedinData['industry']."',company_name='".$linkedinData['company_name']."', company_industry = '".$linkedinData['company_industry']."' WHERE user_id=".$linkedinData['user_id'];
       DB::statement($query);
        return true; 
    }

    public function check_user_status($username,$password) {
		
   $qry=User::select('id')->where('email',addslashes($username))->where('password',addslashes($password))->limit(1)->get();
       
        if($qry->count()==1){

 $row=User::select('id','last_session','user_type_id')->where('email',addslashes($username))->where('password',addslashes($password))->whereIn('user_status_id',array('4','7','6'))->limit(1);

       

            if($row->count()==1){
             //   $this->oneHourUpdate($row->get()->toArray());
                return true;
            }else{
            return "This account is inactive.Please contact support";
            }

        }else{	
			return "Invalid username and password";
        }
        
	
    }



    public function check_linkedin_user_status($username) {
        
        
         $row=User::select('id','last_session','user_type_id')->where('email',addslashes($username->emailAddress))->where('linkedin_enabled','Y')->whereIn('user_status_id',array('4','7','6'))->limit(1)->get();


            if($row->count()==1){
               # $this->oneHourUpdate($row->toArray());
                return true;
            }else{
            return "This account is inactive.Please contact support";
            }

        
            
    }

    
    public function getUserDetailsByUserNameAndPassword($username,$password) {
        $response = array();
		$sql = "SELECT `user_accounts`.*, `user_statuses`.`status_key` as user_status, `user_types`.`type_key` as user_type FROM `user_accounts`, `user_statuses`, `user_types` WHERE `user_accounts`.`email` = '".addslashes($username)."' AND `user_accounts`.`password` = '".addslashes($password)."' AND `user_accounts`.`user_status_id` IN(4,6,7) AND `user_statuses`.`id` = `user_accounts`.`user_status_id` AND `user_types`.`id` = `user_accounts`.`user_type_id` LIMIT 1";
		$rs = DB::select($sql);      
        $get_Count =count($rs);
        if($get_Count>0) {
              $get_Cat = $rs;
        foreach ($get_Cat as $get_Cats) {
         $response = $get_Cats;
        }
               
                $userPermissions = new Userpermissions();
                $response['user_permissions'] = $userPermissions->getPermissionArrayForThisUserTypeAndStatus($response['user_type_id'], $response['user_status_id']);
        }
        return $response;   
    }
    
    public function getUserDetailsById($profileId) {
	


    $response = array();

  $sql = "SELECT `user_accounts`.*, `user_statuses`.`status_key` as user_status, `user_types`.`type_key` as user_type FROM `user_accounts`, `user_statuses`, `user_types` WHERE `user_accounts`.`id` = $profileId AND `user_statuses`.`id` = `user_accounts`.`user_status_id` AND `user_types`.`id` = `user_accounts`.`user_type_id` LIMIT 1";
	
         $get_Cat = DB::select($sql);
         $get_Count =count($get_Cat);
    
    if($get_Count>0) {
        $response = $get_Cat;
        foreach ($get_Cat as $get_Cats) {
         $response = $get_Cats;
        }
		
     $userPermissions = new Userpermissions();
     $response['user_permissions'] = $userPermissions->getPermissionArrayForThisUserTypeAndStatus($response['user_type_id'], $response['user_status_id']);
	 $sql1 = "SELECT * FROM `user_address_details` WHERE user_id = ".$response['id']." LIMIT 1";
     $get_Cat1 = DB::select($sql1);
     $get_Count1 =count($get_Cat1);
	 if($get_Count>0) {
		$response['address_details'] = $get_Cat1;
	 }	 
       
    }
        
        //echo "<pre>";print_r($response);die;
        return $response;

         
    }
    
    public function updateProfile($userDetails) {
        $response = false;


        $rs=DB::table(TBL_USER)->where('id',$userDetails['id'])->update($userDetails);
       
        if($rs!=null) {
            $response = true;
        }
        return $response;
    }
	
	public function updateUserAddress($userAddressDetails) {
        $response = false;

		$sql = "SELECT * FROM user_address_details WHERE `user_id` = ".$userAddressDetails['user_id'];
       
        $rs = DB::select($sql);
   
        if(count($rs)>0) {
			$rs=DB::table(TBL_USER_ADDRESS)->where('user_id',$userAddressDetails['user_id'])->update($userAddressDetails);
		}
		else {
			 $sql = "INSERT INTO `user_address_details`(`user_id`, `company`, `address`, `zip_code`, `state`, `city`) VALUES(".$userAddressDetails['user_id'].",'".$userAddressDetails['company']."','".$userAddressDetails['address']."','".$userAddressDetails['zip_code']."','". $userAddressDetails['state']."','". $userAddressDetails['city']."')"; 
				$rs =DB::insert($sql);
		}
        if($rs!=null) {
            $response = true;
        }
        return $response;
    }
	
    public function update_request_corporate($userDetails) {
        $response = false;
         $rs=DB::table(TBL_USER)->where('id', $userDetails['id'])->update(array('user_upgrade_status' => addslashes($userDetails['user_upgrade_status'])));

       
    
       if($rs!=null) {
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
        $sql = "SELECT post_category_id,post_category_name,default_premium_email_alert FROM post_category WHERE `post_category_id` IN (SELECT post_category_id FROM post_category WHERE email_alert = 'Y') AND `post_category_status` = 'Y'";
       
        $rs = DB::select($sql);
   
        if(count($rs)>0) {
            foreach ($rs as $rw) {

                $id = $rw['post_category_id'];
                $response[] = array('id'=>$id,'text'=>$rw['post_category_name'],'default_premium_email_alert'=>$rw['default_premium_email_alert']);
            
            }
        }

        return $response;
    }
	
	
	 public function emailAlertCategoryOnlyIndicator() {
        $response = array();
        $sql = "SELECT post_category_id,post_category_name FROM post_category WHERE 
		`post_category_id` IN (SELECT post_category_id FROM post_category WHERE email_alert = 'Y')
		AND `post_category_id` NOT  IN (SELECT DISTINCT p.post_category_id  FROM post_category pcc LEFT JOIN post p ON pcc.`post_category_id` = p.`post_category_id` WHERE pcc.email_alert = 'Y' AND p.`post_publish_status` = 'Y'  AND pcc.`post_category_status` = 'Y'  AND p.post_type ='N' ) AND `post_category_status` = 'Y'";
       
        $rs = DB::select($sql);
   
        if(count($rs)>0) {
            foreach ($rs as $rw) {

                $id = $rw['post_category_id'];
                $response[][$id] = $rw['post_category_name'];
            }
        }

        return $response;
    }
	
	
	 public function defaultEmailAlertOnlyIndicators() {
        $response = array();
        $sql = "SELECT post_category_id,post_category_name FROM post_category WHERE 
		`post_category_id` IN (SELECT post_category_id FROM post_category WHERE default_email_alert = 'Y')
		AND `post_category_id` NOT  IN (SELECT DISTINCT p.post_category_id  FROM post_category pcc LEFT JOIN post p ON pcc.`post_category_id` = p.`post_category_id`  WHERE pcc.default_email_alert = 'Y' AND p.`post_publish_status` = 'Y'  AND pcc.`post_category_status` = 'Y'  AND p.post_type ='N') AND `post_category_status` = 'Y'";
       
        $rs = DB::select($sql);
   
        if(count($rs)>0) {
            foreach ($rs as $rw) {

                $id = $rw['post_category_id'];
                $response[][$id] = $rw['post_category_name'];
            }
        }

        return $response;
    }
    
    
    public function defaultEmailAlert() {
        $response = array();
       $rs= DB::table('post_category')->select('post_category_id')->where('default_email_alert','Y')->where('post_category_status','Y')->get();
      
     
        if(count($rs)>0) {
            $get_Arrs = $rs;
        
            foreach ($get_Arrs as $get_Arr) {
               $response[]= $get_Arr['post_category_id'];
             } 
           
           
        }
        return $response;
    }
    
    
    public function emailAlertChoiceofUsers($uId) {
        $response = array();
        $rs=User::select('want_to_email_alert')->where('email',$uId)->get();
       
        if($rs->count()>0) {
            $rw=$rs->toArray();
            foreach ($rw as $rs) {
               
            
                $id = 'want_to_email_alert';
                $response[][$id] = $rs['want_to_email_alert'];
            }
        }
        return $response;
    }

    public function updateProfilePassword($user_id,$new_password) {
        $response = false;
        $rs=DB::table(TBL_USER)->where('id',$user_id)->update(array('password'=>$new_password));
      
       if($rs!=null) {
            $response = true;
        }
        return $response;       
    }
    
    public function getUserDetailsByEmail($uEmail) {
        $response = array();
	 
        $rs=User::where('email',$uEmail)->get();
      
       
        if($rs->count()>0) {
          
            $response = $rs->toArray();
            
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
        $rs = User::where('email',$emailId)->get();
      
        if($rs->count()>0) {
            $result=$rs->toArray();
            
              $response =$result;
            
               
            
        }
       
        return $response;       
    }
    


    public function Validate_Email_Verification($userId) {
        $response = false;

 $rs = User::where('id',$userId)->where('email_verification','Y')->whereIn('user_status_id',array('4','7','6'))->get();


         if($rs->count()>0) {
            $response = true;
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

if(!is_numeric($userId)){
$where_field='email';
}else{
$where_field='id';
}
  $rs=DB::table(TBL_USER)->where($where_field, $userId)->update(array('email_verification' => 'Y','user_post_alert' => 'Y'));

     
        if($rs!=null) {
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

         $rs=DB::table(TBL_USER)->where('id', $uid)->update(array('expiry_on' => $new_expiry_date));

     
        if($rs!=null) {
            $response = true;
        }

       
        return $response;   
    }


    public function getStatusIdForThisStatus($status){
        $response = '';
          
        $rs=DB::table(TBL_USER_STATUSES)->where('status_key',$status)->get();
    

       
        if(count($rs)>0) {
            $status_arr = $rs;
        
             $response = $status_arr[0]['id'];
        }
        return $response;
    }
    
    public function setThisUserStatus($uid,$status) {
        $response = false;
     
        $status_id = $this->getStatusIdForThisStatus($status);
        if($status_id>0) {
             $rs=DB::table(TBL_USER)->where('id', $uid)->update(array('user_status_id' => $status_id));

     
        if($rs!=null) {
            $response = true;
        }

            
        }
        return $response;
    }
    
    public function setThisUserUpgradeStatus($uid,$status){
        $response = false;
         $rs=DB::table(TBL_USER)->where('id', $uid)->update(array('user_upgrade_status' => $status));
      
        if($rs!=null) {
            $response = true;
        }
        return $response;       
    }
    
    public function setThisUserToPremium($uid){
        $response = false;
              $rs=DB::table(TBL_USER)->where('id', $uid)->update(array('user_type_id' => '2'));

       
        if($rs!=null) {
            $response = true;
        }
        return $response;       
    }
    
    public function setThisUserToFree($uid){
        $response = false;
          $rs=DB::table(TBL_USER)->where('id', $uid)->update(array('user_type_id' => 1));

       
       if($rs!=null) {
            $response = true;
        }

      
        return $response;       
    }
    
    public function updatePaypalRecurrentprofileId($uid,$profile_id){
        $response = false;
         $rs=DB::table(TBL_USER)->where('id', $uid)->update(array('recurrent_profile_id' => $profile_id,'current_payment_method' => 'PayPal'));
    
       if($rs!=null) {
            $response = true;
        }
        return $response;       
        
    }
    
    public function unSubscribeThisUserByEmail($email){
        $response = false;

          $rs=DB::table(TBL_USER)->where('email', $email)->update(array('user_post_alert' => 'N'));

      
       if($rs!=null) {
            $response = true;
        }
        return $response;       
    }
    
    public function updateStripeCusId($data){
        $response = false;



          $rs=DB::table(TBL_USER)->where('email', $data['email'])->update(array('stripe_customer_id' => $data['customerId'],'stripe_subscription_id' => $data['subscriptionId'],'registered_on' => $data['startSubscription'],'expiry_on' => $data['endSubscription'],'current_payment_method' => 'Stripe'));

     
        if($rs!=null) {
            $response = true;
        }
        return $response;
    }
    
    public function updateStripeSubId($data){
        $response = false;
         $rs=DB::table(TBL_USER)->where('stripe_customer_id', $data['customerId'])->update(array('user_type_id' => 2,'stripe_subscription_id' => $data['subscriptionId'],'user_status_id' =>4,'expiry_on' => $data['endSubscription']));
        
       if($rs!=null) {
            $response = true;
        }
        return $response;
    }
    
    public function fetchStripeDetails($id){
        $response = array();
      
        $rs = User::select('id', 'stripe_customer_id', 'stripe_subscription_id')->where('id' ,$id)->get();
        if($rs->count()>0) {
           
           
                $response = $rs->toArray();
          
        }
        return $response;   
    }


 public function getUserDetailsByPayPalprofileId($recurrent_profile_id) {
        $response = array();
        $sql = "SELECT `user_accounts`.*, `user_statuses`.`status_key` as user_status, `user_types`.`type_key` as user_type FROM `user_accounts`, `user_statuses`, `user_types` WHERE `user_accounts`.`recurrent_profile_id` = '$recurrent_profile_id' AND `user_statuses`.`id` = `user_accounts`.`user_status_id` AND `user_types`.`id` = `user_accounts`.`user_type_id` LIMIT 1";

        $rs = DB::select($sql);

        if(count($rs)>0) {

             $response = $rs;
       /* foreach ($get_Cat as $get_Cats) {
         $response[] = $get_Cats;
        }*/
             
        }

       
        return $response;   
    }


    
    public function getUserDetailsByStripeCustomerId($stripe_customer_id) {
        $response = array();
        $sql = "SELECT `user_accounts`.*, `user_statuses`.`status_key` as user_status, `user_types`.`type_key` as user_type FROM `user_accounts`, `user_statuses`, `user_types` WHERE `user_accounts`.`stripe_customer_id` = '$stripe_customer_id' AND `user_statuses`.`id` = `user_accounts`.`user_status_id` AND `user_types`.`id` = `user_accounts`.`user_type_id` LIMIT 1";

        $rs = DB::select($sql);

        if(count($rs)>0) {

             $response = $rs;
       /* foreach ($get_Cat as $get_Cats) {
         $response[] = $get_Cats;
        }*/
             
        }

       
        return $response;   
    }

        public function autoIncrementRenewalCycle($user_id,$renewal_cycle){

        $response = array();
        //SELECT user if status is active
        $sql = "SELECT * FROM `user_accounts` WHERE `user_status_id` = 4 AND `id` = ".$user_id;

        $rs_ = DB::select($sql);
        if(count($rs_)>0) {
        $rs=DB::table(TBL_USER)->where('id', $user_id)->update(array('renewal_cycle' => $renewal_cycle));
        if($rs!=null) {
        $response = true;
        }


        }
        return $response;
        }

    /* By Veera Getting payment history*/

    public function get_payment_history($id){
        $response = array();
         $sql = "SELECT UPA.*,PT.*  FROM `user_payment_log` as UPA left join `payment_transactions` as PT on PT.`id`=UPA.`transaction_id`  WHERE  UPA.`user_id` = ".$id;
        $rs = DB::select($sql);
        if(count($rs)>0) {
             $response = $rs;
        /*foreach ($get_Cat as $get_Cats) {
         $response[] = $get_Cats;
        }*/
             
        }
       // echo "<pre>";print_r($response);
        return $response;   
    }


    public function user_deactivate($status,$id){
        if($status==1){
            $status_field='user_type_id';
        }else{
            $status_field='user_status_id';
        }
            $response = false;

             $rs=DB::table(TBL_USER)->where('email', $id)->update(array($status_field => $status));

       
        
        if($rs!=null) {
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


                public function addlog($uid, $transaction_id, $order_id, $action, $data){
        $response = false;
        $sql = "INSERT INTO `user_payment_log`(`user_id`, `transaction_id`, `order_id`, `action`, `data`) VALUES($uid, $transaction_id, '$order_id', '$action', '$data')"; 
         $rs =DB::insert($sql);
        if($rs) {
            $response = true;
        }
        return $response;
    }
	
	
	public function addSocialMedia($uniqCode, $title, $description, $urlpath, $imagepath){
        $response = false;
        $sql = "INSERT INTO `socialmedia`(`uniqcode`, `title`, `description`, `url`, `imagepath`) VALUES('$uniqCode', '$title', '$description', '$urlpath', '$imagepath')"; 
         $rs =DB::insert($sql);
        if($rs) {
            $response = true;
        }
        return $response;
    }
	
	public function getSocialMedia($uniqCode){
        $response = array();
        $sql = "SELECT id,uniqcode,title,description,url,imagepath FROM socialmedia WHERE uniqcode = '$uniqCode'"; 
         $rs = DB::select($sql);
        if(count($rs)>0) {
             $get_Cat = $rs;
        foreach ($get_Cat as $get_Cats) {
         $response[] = $get_Cats;
        }
             
        }
		
		return $response;
    }


    public function updateEmailAlertForRepoet($email,$mailId,$report) {
        $response = false;

        $rs=DB::table(TBL_USER)->where('email', $email)->update(array('want_to_email_alert' => $mailId,'breaking_News_Alert' => $report));

        
        if($rs!=null) {
            $response = true;
        }
        return $response;       
    }



        public function oneHourUpdate($toArray) {
             $response = false;
           
        if($toArray[0]['user_type_id']==1 && $toArray[0]['last_session']==null) {
        $timeplus=(time()+60*10);
        $rs=DB::table(TBL_USER)->where('id',$toArray[0]['id'])->update(array('last_session' => $timeplus));
        if($rs!=null) {
        $response = true;
        }
        }
        return $response;       
        }
   
}
