<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class UserController extends AlaneeController {

	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/recaptchalib.php','alanee_classes/mailer/class.phpmailer.php','alanee_classes/common/navigation_class.php','alanee_classes/payment/paypal_class.php','alanee_classes/linkedIn/http.php','alanee_classes/linkedIn/oauth_client.php','alanee_classes/subscription_management/subscription_class.php','alanee_classes/mailer/class.mailgun.php');





	public function index() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Welcome to Japan macro advisors";
		// get all category items
		$this->populateLeftMenuLinks();
		//$this->renderView();
	}

	public function signup() {

	//print_r($_SESSION);
		$this->handleUnpaidUser();
		if(isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null){
			unset($_SESSION['temp_user']);
		}

		if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
			$this->redirect('/');
		//	$this->redirect('helpdesk/post');
		}
		$user = new User();
		$country = new Country();
		$media = new Media();
		$this->populateLeftMenuLinks();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
			}
		}
		if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
			}
		}
		$this->pageTitle = "Welcome to Japan macro advisors - Sign up";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Sign up';
		$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe';
		$user_position = $user->getPositionsDatabase();
		$user_industry = $user->getIndustryDatabase();
		$this->renderResultSet['result']['user_position'] = $user_position;
		$this->renderResultSet['result']['user_industry'] = $user_industry;
		$this->renderResultSet['result']['country_list'] = $country->getCountryDatabase();
		$this->renderResultSet['result']['signup_error_id'] = '';
		$this->renderResultSet['result']['postdata'] = null;
		$request_info = array(
			'premium' => false,
			'corporate' =>false	
			);
		if(isset($_GET['pre_info'])){
			$request_info['premium'] = true;
		}
		if(isset($_GET['co_info'])){
			$request_info['corporate'] = true;
		}
		$this->renderResultSet['result']['request_info'] = $request_info;
		$this->renderView();
	}
	public function linkedinProcess($product_type,$series_code=false) {

		if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
			// in case if user cancel the login. redirect back to home page.
			$_SESSION["err_msg"] = $_GET["oauth_problem"];
			$this->redirect('/user/signup');
			exit;
		}


		// Get product Type
		$get_product=$product_type[0];
		
		$client = new oauth_client_class;
		$callbackURL = Config::read('LinkedIn.'.Config::read('environment').'.callbackURL')."/".$get_product;// Conc product Type
		$linkedinApiKey = Config::read('LinkedIn.'.Config::read('environment').'.linkedinApiKey');
		$linkedinApiSecret = Config::read('LinkedIn.'.Config::read('environment').'.linkedinApiSecret');
		$linkedinScope = Config::read('LinkedIn.'.Config::read('environment').'.linkedinScope');
		
		/*if (strpos($product_type[0], '@') !== false) {
			$Url = str_replace("@","/",$product_type[0]);
			$split = split("index=",$Url);
		}*/
		if (array_search("japanmacroadvisors",$product_type) && $series_code) {
			$series_url = implode("/",$product_type);
			foreach($series_code as $code=>$values){
				$st[] = $code."=".$values;
			}
			$stt = implode("&",$st);
			$stru = $series_url.'/?'.$stt;
			$_SESSION['downloadUrl'] = $stru;
		}

		$client->debug = false;
		$client->debug_http = true;
		$client->redirect_uri = $callbackURL;
		$client->client_id = $linkedinApiKey;
		$application_line = __LINE__;
		$client->client_secret = $linkedinApiSecret;
		
		if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
			die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
				'create an application, and in the line '.$application_line.
				' set the client_id to Consumer key and client_secret with Consumer secret. '.
				'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
		'necessary permissions to execute the API calls your application needs.';

		/* API permissions */
		$client->scope = $linkedinScope;
		if (($success = $client->Initialize())) {
			
			if (($success = $client->Process())) {

				if (strlen($client->authorization_error)) {
					$client->error = $client->authorization_error;
					$success = false;
				} elseif (strlen($client->access_token)) {
					$success = $client->CallAPI(
						'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name,positions,industry)', 
						'GET', array(
							'format'=>'json'
							), array('FailOnAccessError'=>true), $user);
				}
			}
			$success = $client->Finalize($success);
		}
		if ($client->exit) exit;
		if ($success) {
			$userModel = new User();
			$AlaneeCommon = new Alaneecommon();
			$password = $AlaneeCommon->createPassword(8);
			$user_type = substr($client->redirect_uri, strrpos($client->redirect_uri, '/') + 1);
			$user_type_id=($user_type=='premium')?2:1;

			if($user_type_id==2){ //check user_type start
				$country = $userModel->getCountryId($user->location->country->code);
				$registered_on = time();
				$expiry_on = ($user_type=='premium')?strtotime("+3 months", time()):0;
				
				$defultAlertID = $userModel->defaultEmailAlert();	

				$defultAlertValue = implode(",",$defultAlertID);
				
				$temp_userDetails = array(
					'fname' => $user->firstName,
					'lname' => $user->lastName,
					'email' => $user->emailAddress,
					'password' => $password,
					'country_id' => $country,
											'user_type_id' => $user_type_id, //Free
											'user_status_id' => 2, //Active
											'registered_on' => $registered_on,
											'expiry_on' => $expiry_on,
											'email_verification' => 'Y',
											'user_upgrade_status' => 'NU',
											'linkedin_enabled' => 'Y',
											'oauth_uid' => $user->id,
											'want_to_email_alert' => $defultAlertValue
											);
				$_SESSION['temp_user'] = $temp_userDetails;
				$_SESSION['linkedinData'] = $user;
				$this->redirect('user/dopayment/');
				die;
			} //check user_type end

			if($user_type_id!=2){

			    //check user_type start
				$defultAlertID = $userModel->defaultEmailAlert();	
				$defultAlertValue = implode(",",$defultAlertID);
				
				
				$userData = $userModel->checkLinkedInUserExists($user,$password,$user_type_id,$user_type,$defultAlertValue);
				



				if($userData) {
				//$_SESSION['loggedin_user_id'] = $user_id;

					$defultAlertID = $userModel->defaultEmailAlert();	
					
					$defultAlertValue = implode(",",$defultAlertID);
					$linkedinData = array(
						'user_id' => $userData['id'],
						'oauth_uid' => $user->id,
						'industry' => $user->industry,
						'company_name' => $user->positions->values[0]->company->name,
						'company_industry' => $user->positions->values[0]->company->industry,
						'want_to_email_alert' => $defultAlertValue
						);

					$userDetails = $userModel->getUserDetailsById($userData['id']);
					$userDetails['password'] = '********';
					$userDetails['loginViaLinkedIn'] = 'yes';
					$_SESSION['user'] = $userDetails;
					if($userData['res'] == 'insert') {
						$insertlinkedinData = $userModel->linkedinDataInsert($linkedinData);
						$mailGun = new MailGun();

						$evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
						if($evenPath == "production")
						{
							$mailGun->addNewUserMailGunListingAddress($userDetails['email'],$userDetails['fname']);
						}
						
						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->IsHTML(true);
						$mail->SMTPDebug  = 2;                // enables SMTP debug information (for testing)
						$Mailtemplate = new Mailtemplate();

						$userDetails = $userModel->getUserDetailsById($userData['id']);
						# autologin setcookie start
						$cookie_value=base64_encode($userDetails['email']).'|||'.md5($userDetails['password']);
						setcookie("JMA_USER", $cookie_value, time()+3600 * 24 * 365, '/');
						# autologin setcookie end
						$userDetails['password'] = '********';
						$_SESSION['user'] = $userDetails;

						$corp='';
						if($userDetails['user_upgrade_status']=='RC'){
							$corp.=" ( You'r Requested Corporate Account )";
						}


						$mail_data = array(
							'name' => ucfirst($userDetails['fname']).' '.ucfirst($userDetails['lname']),
							'title' => (($userDetails['user_type'] == 'free') ? 'Corporate or Free account' : 'Premium'),
							'username' => $userDetails['email'],
							'password' => $userDetails['password'],
							'accountType' => ucfirst($userDetails['user_type']).$corp,
							);

						$template = $Mailtemplate->getTemplateParsed('welcome_linkedinLogin', $mail_data);
						$mail->Subject = $template['subject'];
						$mail->Body = $template['message'];
						$mail->AddAddress($userDetails['email'],$userDetails['fname'].' '.$userDetails['lname']);
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
						$mail->Send();
					//Send Notification mail
						$notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
						$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
						$mail->clearAddresses();
						$mail->clearAttachments();
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->Subject = $notification_subject;
						$n_user_type=($user_type!="premium")?"Free":"Premium";
						$notify_body_msg = "A new ".ucfirst($n_user_type)." user signed up with us (Using LinkedIn Login).<p>Name : ".ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."<br><br>Email : ".$userDetails['email']."</p><br>";


						if ($user_type=='corporate'){
							$notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
						}
						
						$notify_body_msg.="<br>Thanks,<br>JMA Team.<br>";
						$mail->Body =$notify_body_msg;

						$mail->AddAddress($notification_to);
						$mail->Send();
						$render = true;

						$this->renderResultSet['result']['user_details'] = $userDetails;
					/*if($split[1] != ''){
						session_start();
						$_SESSION['chartIndex'] = $split[1];
						//$_SESSION['datatype'] = $chartCodes[1];
					}*/
					if($_SESSION['downloadUrl']){
						$redirect = parse_url($_SESSION['downloadUrl']);
						if($redirect['query']){
							$queryString = $redirect['query'];
						}
						$seriesUrl = $redirect['path'].'?'.$queryString;
						if(isset($_SESSION['downloadUrl'])){
							unset($_SESSION['downloadUrl']);
						}
						$this->redirect($seriesUrl);
						exit();
					}
					else{
						$this->redirect('/');
					}
				}elseif($userData['res'] == 'update'){
					$checklinkedinData = $userModel->linkedinDataExists($userData['id']);
					if($checklinkedinData == 0){
						$insertlinkedinData = $userModel->linkedinDataInsert($linkedinData);
					}else{
						$updatelinkedinData = $userModel->linkedinDataUpdate($linkedinData); 	
					}
					$user_row = $userModel->check_linkedin_user_status($user);			
					if(is_bool($user_row)){
						$userDetails = $userModel->getUserDetailsById($userData['id']);
						$userDetails['password'] = '********';
						$_SESSION['user'] = $userDetails;
							/*if($split[1] != ''){
								session_start();
								$_SESSION['chartIndex'] = $split[1];
								//$_SESSION['datatype'] = $chartCodes[1];
							}*/
							if($_SESSION['downloadUrl']){
								//header("Location: ".$_SESSION['downloadUrl']);
								$redirect = parse_url($_SESSION['downloadUrl']);
								if($redirect['query']){
									$queryString = $redirect['query'];
								}
								$seriesUrl = $redirect['path'].'?'.$queryString;
								if(isset($_SESSION['downloadUrl'])){
									unset($_SESSION['downloadUrl']);
								}
								$this->redirect($seriesUrl);
								exit();
							}
							else{
								$this->redirect('/');
							}
						} else{
							if(isset($_SESSION['OAUTH_ACCESS_TOKEN'])){
								unset($_SESSION['OAUTH_ACCESS_TOKEN']);
							}
							$this->setFlashMessage($user_row);
							$this->redirect('user/login');
						}
					}
				}
			}//check user_type end

		} else {
			$_SESSION["err_msg"] = $client->error;
		}
		//$this->redirect('/');
	}
	public function editMyProfile() {
		try{
			$this->populateLeftMenuLinks();
			if($this->isUserLoggedIn() == true) {
				$user = new User();
				$country = new Country();
				$this->renderResultSet['result']['userdetails'] = $_SESSION['user'];
				//$this->renderResultSet['result']['country_list'] = $country->getCountryDatabaseAsArray();
				$user_position = $user->getPositionsDatabase();
				$user_industry = $user->getIndustryDatabase();
				$this->renderResultSet['result']['user_position'] = $user_position;
				$this->renderResultSet['result']['user_industry'] = $user_industry;
				$this->renderResultSet['result']['country_list'] = $country->getCountryDatabase();	
			} else {
				$this->redirect('user/login');
			}
			
		}catch (Exception $ex) {
			
		}
		$this->renderView();	
	}	
	public function completeregistration(){
		$user = new User();
		$country = new Country();
		$media = new Media();
		$this->populateLeftMenuLinks();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
			}
		}
		if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
			}
		}
		$this->pageTitle = "Welcome to Japan macro advisors - Sign up";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Sign up';
		$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe';
		$user_position = $user->getPositionsDatabase();
		$user_industry = $user->getIndustryDatabase();
		$this->renderResultSet['result']['user_position'] = $user_position;
		$this->renderResultSet['result']['user_industry'] = $user_industry;
		$this->renderResultSet['result']['country_list'] = $country->getCountryDatabase();
		$this->renderResultSet['result']['signup_error_id'] = '';
		$this->renderResultSet['result']['postdata'] = null;

		$error = false;
		if(isset($_POST['signup_btn']))

		{

			$this->renderResultSet['result']['postdata'] = $_POST;
			$signup_ts 		= $_POST['signup_ts'];
			if(!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts)
			{
				unset($_SESSION['signup_ts']);

				$OtherTilteFlag=false;
				$user_title = $_POST['user_title'];
				$OtherTitle=trim($_POST['OtherTitle']);
				$fname = trim($_POST['fname']);
				$lname = trim($_POST['lname']);
				$email = trim($_POST['email']);
				$country_id = $_POST['country_id'];
				$phonecode = isset($_POST['phone_code'])?trim($_POST['phone_code']):$_POST['country_code'];
				$country_code = trim($_POST['country_code']);
				$phone = trim($_POST['phone']);
				$user_position_id = $_POST['user_position'];
				$user_industry_id = $_POST['user_industry'];
				$user_type = $_POST['product'];

				$user_type_id=($user_type=='premium')?2:1;
				$user_status_id=2;
				/*if($user_title == ''){
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message'] = 'Please enter Title';
					$this->renderResultSet['result']['signup_error_id']	= '#user_title_id';
					$error = true;
				}*/
				if($user_title =="Other" && $OtherTitle == ''){
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message'] = 'Please enter Title';
					$this->renderResultSet['result']['signup_error_id']	= '#user_title_id';
					$error = true;
				}else if(empty($fname)){
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message'] = 'Please enter first name';
					$this->renderResultSet['result']['signup_error_id']	= '#reg_first_name';
					$error = true;
				}
				else if(empty($lname))
				{
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message'] = 'Please enter last name';
					$this->renderResultSet['result']['signup_error_id']	= '#reg_last_name';
					$error = true;
				}
				else if(empty($email))
				{
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message']= 'Please enter email';
					$this->renderResultSet['result']['signup_error_id']	= '#reg_email';
					$error = true;
				}
				else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message'] = 'Please enter a valid email';
					$this->renderResultSet['result']['signup_error_id']	= '#reg_email';
					$error = true;
				}
				else if($user->checkUserExistsByEmail($email))
				{
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message'] = 'User already registerd with this email, please try another email. ';
					$this->renderResultSet['result']['signup_error_id']	= '#reg_email';
					$error = true;
				}
				else if(!intval($country_id))
				{
					$this->renderResultSet['status'] = 3333;
					$this->renderResultSet['message'] = 'Please select country';
					$this->renderResultSet['result']['signup_error_id']	= '#reg_country';
					$error = true;
				}
				else
				{
					if($user_title =="Other"){
						$user_title = $OtherTitle;
					}
					//expiry_on
					$registered_on = time();
					$expiry_on=($user_type=='premium')?strtotime("+1 months", time()):0;
					$ip = $_SERVER['REMOTE_ADDR'];
					$reg_password = $AlaneeCommon->createPassword(8);
					
					// User upgrade status
					if ($user_type=='corporate'){
						$user_upgrade_status = 'RC';
					}else{
						$user_upgrade_status = 'NU';
					}
					
					$defultAlertID = $user->defaultEmailAlert();	
					
					$defultAlertValue = implode(",",$defultAlertID);

					$userDetails = array('user_title' => $user_title,
						'fname' => $fname,
						'lname' => $lname,
						'email' => $email,
						'password' => $reg_password,
						'country_id' => $country_id,
						'country_code' => $country_code,
						'phone' => $phone,
						'user_position_id' => $user_position_id,
						'user_industry_id' => $user_industry_id,
							'user_type_id' => $user_type_id, //Free
							'user_status_id' => $user_status_id, //Inactive
							'registered_on' => $registered_on,
							'expiry_on' => $expiry_on,
							'user_upgrade_status' => $user_upgrade_status,
							'want_to_email_alert' => $defultAlertValue
							);

					if($user_type_id==2){ //check user_type start
						$_SESSION['temp_user'] = $userDetails;
						$this->redirect('user/dopayment/');
					} //check user_type end

					if($user_type_id!=2){ //check user_type start
						$u_details = $user->addUserRegistration($userDetails);
						$user_details = $user->getUserDetailsById($u_details['id']);
						try {

							$mailGun = new MailGun();
							$evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
							if($evenPath == "production")
							{
								$mailGun->addNewUserMailGunListingAddress($email,$fname);
							}
							$appPath = Config::read('appication_path') != '' ? '/'.trim(Config::read('appication_path'),'/') : '';
							$activation_link = 'http://'.$_SERVER['HTTP_HOST'].$appPath.'/user/confirmregistration/'.base64_encode($user_details['id']);
							$mail = new PHPMailer();
							$mail->IsSMTP();
							$mail->IsHTML(true);
						$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
						$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
						$mail->WordWrap = 50;
						$Mailtemplate = new Mailtemplate();
						$mail_data = array(
							'name' => ucfirst($fname).' '.ucfirst($lname),

							'activation_link' => $activation_link
							);
						$template = $Mailtemplate->getTemplateParsed('reg_confirm_activation', $mail_data);
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->Subject = $template['subject'];
						$mail->Body = $template['message'];
						$mail->AddAddress($user_details['email'],$user_details['fname'].' '.$user_details['lname']);
						$mail->Send();
					}catch (Exception $e) {
						$this->renderResultSet['status'] = 9999;
						$this->renderResultSet['message'] = 'Error...! '.$e->getMessage();
						$error == true;
					}

					// Send notification mail
					try {
						$notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
						$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
						$mail->clearAddresses();
						$mail->clearAttachments();
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->Subject = $notification_subject;
						$n_user_type=($user_type!="premium")?"Free":"Premium";
						$phonedetails=($phone!='')?$phonecode.$phone:'';
						$notify_body_msg= "A new ".$n_user_type." user signed up with us on.<p>Name : ".ucfirst($fname)." ".ucfirst($lname)."<br><br>Email : ".$email."<br><br>Phone : ".$phonedetails."";
						if ($user_type=='corporate'){
							$notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
						}
						$mail->Body =$notify_body_msg;
						$mail->AddAddress($notification_to);
						$mail->Send();
					}catch (Exception $e) {
						$this->renderResultSet['status'] = 9999;
						$this->renderResultSet['message'] = 'Error...! '.$e->getMessage();
						$error == true;
					}


					}//check user_type end	
				}
				$render = true;

				if($error == true) {
					$this->renderView('signup');
				}else {
					if($user_type_id!=2){ //check user_type start

						$this->renderResultSet['result']['user_details'] = $user_details;
						$flash_arr = array('user_id'=>$u_details['id']);
						$this->setFlashMessage($flash_arr);
						$this->redirect('user/completeregistration_success');
				}//check user_type end

			}
		}else{
			$this->redirect('user/signup');
		}
	}else{
		$this->redirect('user/signup');
	}

}

private function send_individual_user_mail($params){

	$user_id = base64_decode($params);
	$user = new User();
	if($user->validateUserEmail($user_id)) {
		$user_details = $user->getUserDetailsById($user_id);

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->IsHTML(true);  
					$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					$mail->WordWrap = 50;
					$Mailtemplate = new Mailtemplate();
					$mail_data = array(
						'name' => ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']),
						'title' => (($user_details['user_type'] == 'free') ? 'Free' : 'Premium account'),
						'email' => $user_details['email'],
						'password' => $user_details['password'],
						'accountType' => 'Premium  Account'
						);
					$template = $Mailtemplate->getTemplateParsed('welcome_accountdetails', $mail_data);
					$mail->Subject = $template['subject'];
					$mail->Body = $template['message']; 
					$mail->AddAddress($user_details['email'],$user_details['fname'].' '.$user_details['lname']);
					$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
					$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
					$mail->Send();


					// Send notification mail
					try {
						$notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
						$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
						$mail->clearAddresses();
						$mail->clearAttachments();
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->Subject = $notification_subject;
						
						$notify_body_msg= "A new Premium user signed up with us on.<p>Name : ".ucfirst($user_details['fname'])." ".ucfirst($user_details['lname'])."<br><br>Email : ".$user_details['email']."<br><br>Phone : ".$user_details['country_id'].$user_details['phone']."";
						
						$mail->Body =$notify_body_msg;
						$mail->AddAddress($notification_to);
						$mail->Send();
					}catch (Exception $e) {
						$this->renderResultSet['status'] = 9999;
						$this->renderResultSet['message'] = 'Error...! '.$e->getMessage();
						$error == true;
					}

				} 
			}


			private function send_individual_linkedin_user_mail($params){

				$user_id = base64_decode($params);
				$user = new User();
				if($user->validateUserEmail($user_id)) {
					$userDetails = $user->getUserDetailsById($user_id);
					
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->IsHTML(true);  
					$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					$mail->WordWrap = 50;
					$Mailtemplate = new Mailtemplate();
					$corp='';
					if($userDetails['user_upgrade_status']=='RC'){
						$corp.=" ( You'r Requested Corporate Account )";
					}
					$mail_data = array(
						'name' => ucfirst($userDetails['fname']).' '.ucfirst($userDetails['lname']),
						'title' => (($userDetails['user_type'] == 'free') ? 'Corporate or Free account' : 'Premium'),
						'username' => $userDetails['email'],
						'password' => $userDetails['password'],
						'accountType' => ucfirst($userDetails['user_type']).$corp,
						);
					try {
						$template = $Mailtemplate->getTemplateParsed('welcome_linkedinLogin', $mail_data);
						$mail->Subject = $template['subject'];
						$mail->Body = $template['message'];
						$mail->AddAddress($userDetails['email'],$userDetails['fname'].' '.$userDetails['lname']);
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
						$mail->Send();
					}catch (Exception $e) {
						echo $e->getMessage();
					}

					//Send Notification mail
					try {
						$notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
						$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
						$mail->clearAddresses();
						$mail->clearAttachments();
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->Subject = $notification_subject;
						$n_user_type=($userDetails['user_type']!="premium")?"Free":"Premium";
						$notify_body_msg = "A new ".ucfirst($n_user_type)." user signed up with us (Using LinkedIn Login).<p>Name : ".ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."<br><br>Email : ".$userDetails['email']."</p><br>";

						if ($userDetails['user_type']=='corporate'){
							$notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($userDetails['user_type'])."</p>";
						}
						$notify_body_msg.="<br>Thanks,<br>JMA Team.<br>";
						$mail->Body =$notify_body_msg;
						$mail->AddAddress($notification_to);
						$mail->Send();
					}catch (Exception $e) {
						echo $e->getMessage();
					}
				} 
			}
				/**

	 * Registration success page
	 * @param Int $u_id : user id
	 */
				public function completeregistration_success($u_id){
					$fl_msg = $this->getFlashMessage();
					if(isset($fl_msg['user_id'])){
						$u_id = $fl_msg['user_id'];
						$user = new User();
						$country = new Country();
						$media = new Media();
						$this->populateLeftMenuLinks();
						$AlaneeCommon = new Alaneecommon();
						$this->pageTitle = "Welcome to Japan macro advisors - Sign up";
						$this->renderResultSet['meta']['description']='Japan macro advisors - Sign up';
						$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe';

			// Getting user details by user id
						$user_details = $user->getUserDetailsById($u_id);
						$_SESSION['reg_user_id'] = $user_details['id'];
						$this->renderResultSet['result']['user_details'] = $user_details;

						$this->renderView('signin_confirm');
					}else {
						$this->redirect('user/signup');
					}	
				}

	/**
	 * In products page After login user click on REQUEST INFO button
	 * @param Int $u_id : user id
	 */
	public function user_request_info(){

		
		if(isset($_SESSION['user'])){
			$flash_arr = array('user_id'=>$_SESSION['user']['id']);
			$this->setFlashMessage($flash_arr);
			$fl_msg = $this->getFlashMessage();
			if(isset($fl_msg['user_id'])){
				$u_id = $fl_msg['user_id'];
				$user = new User();
				$country = new Country();
				$media = new Media();
				$this->populateLeftMenuLinks();
				$AlaneeCommon = new Alaneecommon();
				$this->pageTitle = "Welcome to Japan macro advisors - Sign up";
				$this->renderResultSet['meta']['description']='Japan macro advisors - Sign up';
				$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe';
				$user_details = $user->getUserDetailsById($u_id);


				if($user_details['user_upgrade_status']=='RP')
				{
					$account = 'premium';
				}elseif($user_details['user_upgrade_status']=='RC')
				{
					$account = 'corporate';
				}elseif($user_details['user_upgrade_status']=='RB')
				{
					$account = 'both premium & corporate';
				}else{
					$account = 'Corporate';
				}
				$user_type=($user_details['user_type']=='individual')?"Premium":ucfirst($user_details['user_type']);
				$update_Rc = array(
					'id' => $u_id,
					'user_upgrade_status' => 'RC'
					);
				$user->update_request_corporate($update_Rc);


				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->IsHTML(true);  
				$notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
				$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
				$mail->clearAddresses();
				$mail->clearAttachments();
				$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
				$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
				$mail->Subject = $notification_subject;
				$mail->Body = "User with below details have requested for ".$account." account.<p>Name : ".$user_details['fname']." ".$user_details['lname']."<br><br>Email : ".$user_details['email']."<br><br>Subscription Type: ".$user_type."</p><br><br>
				Thanks,<br>
				JMA Team.<br>";
				$mail->AddAddress($notification_to);
				$mail->Send();
					// Getting user details by user id
				$this->renderResultSet['result']['user_details'] = $user_details;


				$this->renderView('request_info_success');
			}else {
				$this->redirect('user/signup');
			}

		}else {
			$this->redirect('user/signup');
		}	
	}
	
	/**
	 * Confirm registration - validate email adress
	 * @param String $params : base64 encoded user id
	 */
	public function confirmregistration($params) {
		try {
			$user = new User();
			$country = new Country();
			$media = new Media();
			$this->populateLeftMenuLinks();
			$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
			$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
			if(count($params)>0) {
				if(!$params[0]) {
					throw new Exception("404",9999);
				} else {
					$user_id = base64_decode($params[0]);
					$user = new User();
					if($user->validateUserEmail($user_id)) {
						$user_details = $user->getUserDetailsById($user_id);
						if($user_details['user_status'] == 'active'){
							throw new Exception("404",9999);
						}
						$this->renderResultSet['message'] = "Dear <b>".ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']).",</b><br><br>Thank you for signing up to Japan Macro Advisors. Your free account is now active.<br>Your access credentials have been mailed to <b><i>".$user_details['email'].".</i></b>";
						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->IsHTML(true);  
						$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
						$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
						$mail->WordWrap = 50;
						$Mailtemplate = new Mailtemplate();
						$corp='';
						if($user_details['user_upgrade_status']=='RC'){
							$corp.=" ( You'r Requested Corporate Account )";
						}
						$mail_data = array(
							'name' => ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']),
							'title' => $user_title['user_title'],
							'email' => $user_details['email'],
							'password' => $user_details['password'],
							'accountType' => ucfirst($user_details['user_type']).$corp,
							);
						$template = $Mailtemplate->getTemplateParsed('welcome_accountdetails', $mail_data);
						$mail->Subject = $template['subject'];
						$mail->Body = $template['message'];
						$mail->AddAddress($user_details['email'],$user_details['fname'].' '.$user_details['lname']);
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
						$mail->Send();
						// Activate account - change to trial
					//	$user->setThisUserStatus($user_details['id'], 'trial');
						// Activate account - change to active
						$user->setThisUserStatus($user_details['id'], 'active');

						$user_details = $user->getUserDetailsById($user_id);


						$user_details['password'] = '********';
						$_SESSION['user'] = $user_details;
						$this->redirect('/');


					} else {
						$this->renderResultSet['status'] = 9999;
						$this->renderResultSet['message'] = "Error..! Couldn't update user";
					}
				}			
			} else {
				throw new Exception("404",9999);
			}
			$this->renderView('signin_success');
		}catch (Exception $ex){
			$this->error(404);
			exit;

		}		
	}


	
	public function dopayment() {
		if(!isset($_SESSION['temp_user']) && !isset($_SESSION['user'])){
			$this->redirect('user/login?r=user/dopayment');
		}else {
			$media = new Media();
			$country = new Country();
			$user = new User ();
			$this->populateLeftMenuLinks();
			$this->renderResultSet['result']['country_list'] = $country->getCountryDatabase();
			$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
			$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
			$this->renderResultSet['status'] = 1;
			$this->renderResultSet['result']['stripe_publish_key'] = Config::read('stripe.'.Config::read('environment').'.publish_Key');

			if (isset($_POST['stripeToken'])) {
				$payment = new Subscription();
				$paymentGateway = 'stripe';
				$stripeToken = $_POST['stripeToken'];
				$email = (isset($_SESSION['temp_user']['email']) && $_SESSION['temp_user']['email']!=null)?$_SESSION['temp_user']['email']:$_SESSION['user']['email'];
				$paymentProcess = $payment->createSubscription($paymentGateway,$stripeToken,$email);
				
				if(isset($paymentProcess['error'])){
					$this->payment_status_mail($_SESSION['user']['id'],'error');
					$this->renderResultSet['status'] = 4444;
					$this->renderResultSet['message'] = $paymentProcess['error']['message'];
				}
				else {
					if(isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null){
						$linkedinUserData = $_SESSION['linkedinData'];

						$userDetails=$_SESSION['temp_user'];
				//$u_details = $user->checkLinkedInUserExists($linkedinUserData,$userDetails['password'],2,'premium');

						$checkUserExists = $user->checkUserExistsByEmail($_SESSION['temp_user']['email']);
						if($checkUserExists){
							$u_details = $user->updateLinkedinData($linkedinUserData);
							$linkedinData = array(
								'user_id' => $u_details['id'],
								'oauth_uid' => $linkedinUserData->id,
								'industry' => $linkedinUserData->industry,
								'company_name' => $linkedinUserData->positions->values[0]->company->name,
								'company_industry' => $linkedinUserData->positions->values[0]->company->industry
								);
							$checklinkedinData = $user->linkedinDataExists($u_details['id']);
							if($checklinkedinData == 0){
								$insertlinkedinData = $user->linkedinDataInsert($linkedinData);
							}else{
								$updatelinkedinData = $user->linkedinDataUpdate($linkedinData); 	
							}
						}
						else{	

							$u_details = $user->addUserRegistration($userDetails);
							
							$mailGun = new MailGun();
							$evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
							if($evenPath == "production")
							{
								$email_=isset($_SESSION['temp_user']['email'])?$_SESSION['temp_user']['email']:'';
								$fname_=isset($_SESSION['temp_user']['fname'])?$_SESSION['temp_user']['fname']:'';
								$mailGun->addNewUserMailGunListingAddress($email_,$fname_);
							}

							$linkedinData = array(
								'user_id' => $u_details['id'],
								'oauth_uid' => $linkedinUserData->id,
								'industry' => $linkedinUserData->industry,
								'company_name' => $linkedinUserData->positions->values[0]->company->name,
								'company_industry' => $linkedinUserData->positions->values[0]->company->industry
								);
							$insertlinkedinData = $user->linkedinDataInsert($linkedinData);				
						}

						$update=$user->setThisUserStatus($u_details['id'],'trial');
						if(isset($_SESSION['OAUTH_ACCESS_TOKEN'])){

							$this->send_individual_linkedin_user_mail(base64_encode($u_details['id']));
							unset($_SESSION['OAUTH_ACCESS_TOKEN']);
						}else{
							$this->send_individual_user_mail(base64_encode($u_details['id']));

						}
						if(isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null){
							unset($_SESSION['temp_user']);
						}

					}else{
						if(isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']==1){
							$this->user_upgrade_mail($_SESSION['user']['id']);
							$user->setThisUserStatus($_SESSION['user']['id'],'trial');
							$user->setThisUserToPremium($_SESSION['user']['id']);
						}
					}
					$id=(isset($u_details['id']) && $u_details['id']!=null)?$u_details['id']:$_SESSION['user']['id'];
					if($paymentProcess!=null){
						$responseData = array(
							"email" => $paymentProcess['email'],
							"customerId" => $paymentProcess['customerId'],
							"subscriptionId" => $paymentProcess['subscriptionId'],
							"startSubscription" => $paymentProcess['startSubscription'],
							"endSubscription" => $paymentProcess['endSubscription']
							);
						$updateUserDetails = $user->updateStripeCusId($responseData);
						$transaction_id = 'null';
						$order_id = '';
						$action = 'Stripe - Create Subscription';
						$data = $paymentProcess['response'];
						$userpaymentlog = new Userpaymentlog();
						$createUserStripeLog = $userpaymentlog->addlog($id, $transaction_id, $order_id, $action, $data);
					}
					$user_details = $user->getUserDetailsById($id);
					$_SESSION['user'] = $user_details;

					$this->payment_status_mail($id,'success');

					$this->redirect('user/payment_success');
				}
			}
			$this->renderView();
		}
	}

	private function payment_status_mail($user_id,$status){
		$appPath = Config::read ( 'appication_path' ) != '' ? '/' . trim ( Config::read ( 'appication_path' ), '/' ) : '';
		$site_link = 'http://' . $_SERVER ['HTTP_HOST'] . $appPath;
		$user = new User ();
		
		$success_msg = '';
		$error_mail_msg = '';
		
		$user_details = $user->getUserDetailsById ( $user_id);
		$_SESSION ['user'] = $user_details;
		$CONF_CURRENCY = Config::read('subscription.currency');
		$CONF_AMOUNT = Config::read('subscription.amount');
		if ($status == 'success') {
			
			$success_msg .= "Dear <b>" . $user_details ['fname'] . ' ' . $user_details ['lname'] . ",</b><br><br>Thank you for choosing Japan Macro Advisors. Your Premium subscription with the email address <b><i>" . $user_details ['email'] . "</i></b> has been successful.Your account is now active.The monthly subscription fee is ".$CONF_CURRENCY." ".$CONF_AMOUNT.".</p>";
			//$success_msg .= '<p>You will receive your login credentials shortly.</p>';
			$success_msg .= '<p>Please note that your 1 month trial period starts (' . date ( 'M d, Y', $user_details ['registered_on'] ) . '). Your first subscription fee will be withdrawn from your credit card at the beginning of the initial service period, which starts the day the trial period ends. Your monthly subscription will renew automatically every month.</p>';
			$success_msg .= '<p>For any assistance, contact our <a target="_blank" href="' . $site_link . '/helpdesk/post/">Help Desk<a> or <a target="_blank" href="' . $site_link . '/contact">Support<a>.</p>';
			$success_msg .= '<p>You can access your account <a target="_blank" href="' . $site_link . '/user/myaccount">here.</a></p>';
			
			$success_msg .= '<p>Thank you,<br>Japan Macro Advisors <br><a target="_blank" href="' . $site_link . '">www.japanmacroadvisors.com</a></p>';
			$success_msg .='<p><br>Follow us on: <br><br>Twitter: <a href="https://twitter.com/JapanMadvisors" target="_blank">@japanMadvisors</a><br>Facebook: <a href="www.facebook.com/japanmacroadvisors" target="_blank">www.facebook.com/japanmacroadvisors</a><br>Linkedin: <a href="www.linkedin.com/company/japan-macro-advisors" target="_blank">www.linkedin.com/company/japan-macro-advisors</a></p>';
			$message = $success_msg;
		} else {
			$error_mail_msg .= "Dear <b>" . $user_details ['fname'] . ' ' . $user_details ['lname'] . ",</b><br><br>We regret to inform you that your payment for monthly Premium subscription with email address <b><i>" . $user_details ['email'] . "</i></b> was unsuccessful. You’re monthly subscription fee is due.";
			$error_mail_msg .= '<p>Amount: '.$CONF_CURRENCY.' '.$CONF_AMOUNT.'.</p>';
			$error_mail_msg .= '<p>Your Premium subscription is inactive. We request you to check with your credit card you paid with. In order to continue with our service, please verify you’re billing information and resend payment.</p>';
			$error_mail_msg .= '<p>You can access your payment details page <a target="_blank" href="' . $site_link . '/user/myaccount">Payment Details</a></p>';
			$error_mail_msg .= '<p>Thank you,<br>Japan Macro Advisors <br><a target="_blank" href="' . $site_link . '">www.japanmacroadvisors.com</a></p>';
			$message = $error_mail_msg;
		}
		
		$mail = new PHPMailer ();
		$mail->IsSMTP ();
		$mail->IsHTML ( true );
		$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		$mail->WordWrap = 50;
		$Mailtemplate = new Mailtemplate ();
		$mail_data = array (
			'name' => $user_details ['fname'] . ' ' . $user_details ['lname'],

				// 'title' => ($user_details['user_title'] == 'Other' || $user_details['user_title'] == '') ? '' : $user_details['user_title'].'. ',
			'username' => $user_details ['email'],
			'msg' => $message 
			)
		;
		$template = $Mailtemplate->getTemplateParsed ( 'payment_status', $mail_data );
		// print_r($template);
		$mail->Subject = $template ['subject'];
		$mail->Body = $template ['message'];
		$mail->AddAddress ( $user_details ['email'], $user_details ['fname'] . ' ' . $user_details ['lname'] );
		$mail->SetFrom ( 'info@japanmacroadvisors.com', 'japanmacroadvisors.com' );
		$mail->AddReplyTo ( 'info@japanmacroadvisors.com', 'japanmacroadvisors.com' );
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		$mail->Send ();
	}
	public function payment_success(){

		$media = new Media();
		$country = new Country();
		$user = new User();
		$id = $_SESSION['user']['id'];
		$user_details = $user->getUserDetailsById($id);
		$_SESSION['user']=$user_details;
		
		$this->populateLeftMenuLinks();
		$this->renderResultSet['result']['country_list'] = $country->getCountryDatabase();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$this->renderView();
	}


	public function cancelSubscription(){		
		if($_SESSION['user']['user_type_id']==2){
			$subscription = new Subscription();
			$user = new User();
			$media = new Media();
			$id = $_SESSION['user']['id'];
			$user_details = $user->getUserDetailsById($id);
			$_SESSION['user']=$user_details;
			if(isset($_REQUEST['submit']) && $_REQUEST['submit']=='free'){
				$cancelSubscriptionProcess = $subscription->cancelSubscription($id);
				if($cancelSubscriptionProcess=='Subscription cancelled successfully'){
					$this->downgrade_success_send_mail($id);
					$this->setFlashMessage($cancelSubscriptionProcess);
					$user_details = $user->getUserDetailsById($id);
					$_SESSION['user']=$user_details;
					$this->redirect('user/myaccount');
				}
				$this->renderResultSet['result']['cancelSubscriptionError']= $cancelSubscriptionProcess;
			}
			$this->populateLeftMenuLinks();
			$this->renderResultSet['result']['userdetails']= $user_details;
			$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
			$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
			$this->renderView();		
		}
		$this->redirect('user/myaccount');
	}
	
	public function upgradeSubscription(){
		$email = $_SESSION['user']['email'];
		$user = new User();
		$getUserDetails = $user->getUserDetailsByEmail($email);
		if($getUserDetails[0]['stripe_subscription_id'] != null && $getUserDetails[0]['user_type_id'] == 1 && $getUserDetails[0]['user_status_id'] == 4){
			$subscription = new Subscription();
			$upgradeSubscriptionProcess = $subscription->upgradeSubscription($getUserDetails[0]['stripe_customer_id']);
			if($upgradeSubscriptionProcess->id){
				//send success mail
				$this->payment_success_send_mail($_SESSION['user']['id']);
			}
			else{
				$this->setFlashMessage('Upgrade Failed');
			}
		}
		
	}

	/*After payment suuccess mail by veera Start*/
	private function payment_success_send_mail($user_id){
		$user = new User();
		$user_details = $user->getUserDetailsById($user_id);
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->IsHTML(true);  
					$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					$mail->WordWrap = 50;
					$Mailtemplate = new Mailtemplate();
					$mail_data = array(
						'name' => ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']),
						'email' => $user_details['email']
						);
					$template = $Mailtemplate->getTemplateParsed('payment_success', $mail_data);
					//print_r($template);
					$mail->Subject = $template['subject'];
					$mail->Body = $template['message'];
					$mail->AddAddress($user_details['email'],$user_details['fname'].' '.$user_details['lname']);
					$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
					$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
					$mail->Send();

				}

				/*After payment suuccess mail by veera End*/



				/*After downgrade suuccess mail by veera Start*/
				private function downgrade_success_send_mail($user_id){
					$CONF_CURRENCY = Config::read('subscription.currency');
					$CONF_AMOUNT = Config::read('subscription.amount');
					$user = new User();
					$user_details = $user->getUserDetailsById($user_id);
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->IsHTML(true);  
					$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					$mail->WordWrap = 50;
					$Mailtemplate = new Mailtemplate();
					$mail_data = array(
						'name' => ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']),
						'email' => $user_details['email'],
						'currency' => $CONF_CURRENCY,
						'amount' => $CONF_AMOUNT
						);
					$template = $Mailtemplate->getTemplateParsed('downgrade_success', $mail_data);
					//print_r($template);
					$mail->Subject = $template['subject'];
					$mail->Body = $template['message'];
					$mail->AddAddress($user_details['email'],$user_details['fname'].' '.$user_details['lname']);
					$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
					$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
					$mail->Send();
					return true;
				}

				/*After downgrade suuccess mail by veera End*/


				public function login($parm,$uparam) {

					$this->handleUnpaidUser();
					$this->pageTitle = "Client login";
					$this->renderResultSet['meta']['description']='Japan macro advisors - login';
					$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe, log in, user';
					if(!isset($_SESSION['fullredirect_redirecturl']) || $_SESSION['fullredirect_redirecturl'] == ''){
						$_SESSION['fullredirect_redirecturl'] = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : null;
					}
					if($this->isUserLoggedIn() == true) {
						$this->redirect('user/myaccount');
					}
					if(isset($uparam['r']) && $uparam['r']!=''){
						$_SESSION['redirecturl'] = $uparam['r'];
					}
		// get all category items
					$media = new Media();
					$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
					$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
					$AlaneeCommon = new Alaneecommon();
					if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
						foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
							$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
						}
					}
					if(count($this->renderResultSet['result']['rightside']['media'])>0) {
						foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
							$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
						}
					}
					$this->populateLeftMenuLinks();		
					if(count($_POST)>0) {
						$user = new User();
						$username = $_POST['login_email'];
			//$password = md5($_POST['login_password']);
						$password = $_POST['login_password'];
						$user_row = $user->check_user_status($username,$password);

						if(is_bool($user_row)){
							$userDetails = $user->getUserDetailsByUserNameAndPassword($username,$password);

							$userDetails['password'] = '********';
							$userDetails['loginViaLinkedIn'] = 'no';
							if(count($userDetails)>0 && $userDetails['id'] >0) {
				//$userPermissions = new Userpermissions();
								if(!empty($_POST['login_rememberMe']) && $_POST['login_rememberMe']=='y')
								{
									$path = "/";
									$salt = "125778rttyyyu";
									$rm = $salt."_".$username."_".$password."_".$salt;
									$rm = base64_encode($rm);
									$rm = base64_encode($rm);				  
									setcookie("jmacrm",$rm,time()+3600 * 24 * 365,$path);				                 		
								}

				# autologin setcookie start
								$cookie_value=base64_encode($userDetails['email']).'|||'.md5($userDetails['password']);
								setcookie("JMA_USER", $cookie_value, time()+3600 * 24 * 365, '/');
					# autologin setcookie end
								$_SESSION['user'] = $userDetails;

								if($userDetails['user_status_id']==7){

									$this->redirect('user/user_pay_downgrade');die;

								}

								if(isset($_SESSION['redirecturl']) && $_SESSION['redirecturl'] != '') {
									$redirect_url = $_SESSION['redirecturl'];
									unset($_SESSION['redirecturl']);
									$this->redirect($redirect_url);
									exit;
								} else {
									if(isset($_SESSION['fullredirect_redirecturl']) && $_SESSION['fullredirect_redirecturl'] != null){
										$full_redirect_url = $_SESSION['fullredirect_redirecturl'];
										unset($_SESSION['fullredirect_redirecturl']);
										$this->fullRedirect($full_redirect_url);
										exit;
									}elseif(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
										$full_redirect_url = $_SERVER['HTTP_REFERER'];
										$this->fullRedirect($full_redirect_url);
										exit;
									}else{
										$this->redirect('/');
										exit;
									}
								}
							} else{
								$this->renderResultSet['status'] = 3333;
								$this->renderResultSet['message'] = 'Login failed. Please try again';
							}


						} else{
							$this->renderResultSet['status'] = 3333;
							$this->renderResultSet['message'] = $user_row;
						}
					}
					$this->renderView();
				} 

				public function premium_login($parm,$uparam){
					$this->handleUnpaidUser();
					$this->pageTitle = "Client login";
					$this->renderResultSet['meta']['description']='Japan macro advisors - login';
					$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe, log in, user';
					if(!isset($_SESSION['fullredirect_redirecturl']) || $_SESSION['fullredirect_redirecturl'] == ''){
						$_SESSION['fullredirect_redirecturl'] = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : null;
					}
					if($this->isUserLoggedIn() == true) {
						$this->redirect('user/myaccount');
					}
					if(isset($uparam['r']) && $uparam['r']!=''){
						$_SESSION['redirecturl'] = $uparam['r'];
					}
		// get all category items
					$media = new Media();
					$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
					$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
					$AlaneeCommon = new Alaneecommon();
					if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
						foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
							$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
						}
					}
					if(count($this->renderResultSet['result']['rightside']['media'])>0) {
						foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
							$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
						}
					}
					$this->populateLeftMenuLinks();
					$this->renderView('login');
				}



				public function loginbyajx($parm,$uparam){
					if($this->isUserLoggedIn() == true) {
			// Return user details
						$userDetails = $_SESSION['user'];
						$this->renderResultSet['status'] = 1;
						$this->renderResultSet['message'] = 'OK';
						$this->renderResultSet['result'] = array('userdetails'=>$userDetails);
					}else if(count($_POST)>0) {
						$user = new User();
						$username = $_POST['login_email'];
			//$password = md5($_POST['login_password']);
						$password = $_POST['login_password'];
						$user_row = $user->check_user_status($username,$password);

						if(is_bool($user_row)){
							$userDetails = $user->getUserDetailsByUserNameAndPassword($username,$password);
							$userDetails['password'] = '********';
							if(count($userDetails)>0 && isset($userDetails['id'])) {
				//$userPermissions = new Userpermissions();
								$_SESSION['user'] = $userDetails;
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array('userdetails'=>$userDetails);
							} else{
								$this->renderResultSet['status'] = 3333;
								$this->renderResultSet['message'] = 'Login failed. Please try again';
							}
						} else{
							$this->renderResultSet['status'] = 3333;
							$this->renderResultSet['message'] = $user_row;
						}
					}else{
						$this->renderResultSet['status'] = 3333;
						$this->renderResultSet['message'] = 'Login failed. Please try again';
					}
					$this->renderAjax('json');
				}

				public function logout() {

					$path = "/";
					$rm = "";
					setcookie("jmacrm",$rm,time() +3600,$path);		
					$_SESSION['user'] = null;
					session_unset();
					session_destroy();
					$_SESSION = array();

					$this->redirect('/');
				}

				public function profile() {
					$this->handleUnpaidUser();
					if(!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
						$_SESSION['redirecturl'] = 'user/profile';
						$this->redirect('user/login');
					}
					$this->pageTitle = "Welcome to Japan macro advisors - My profile";
		// get all category items
					$media = new Media();
					$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
					$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
					$AlaneeCommon = new Alaneecommon();
					if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
						foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
							$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
						}
					}
					if(count($this->renderResultSet['result']['rightside']['media'])>0) {
						foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
							$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
						}
					}
					$this->populateLeftMenuLinks();
					$this->renderResultSet['result']['action'] = 'profile';
					$this->renderView();
				}

				public function changepassword() {
					$this->handleUnpaidUser();
	//	echo '<pre>';
	//	print_r($_SESSION); exit;
					$this->pageTitle = "Welcome to Japan macro advisors - Change password";
		// get all category items
					$return_array=array();
					if($this->isUserLoggedIn() == true && count($_POST)>0) {
						$user_id = $_POST['user_id'];
						$old_password = $_POST['currentpassword'];
						$new_password = $_POST['newpassword'];
						$re_password = $_POST['confirm_newpassword'];
						if(trim($old_password) == '') {

							$return_array['error']='<font color="#ff0000">Current password cannot be empty.</font>';
							echo json_encode($return_array);
						} else if(trim($new_password) == '') {
							$return_array['error']='<font color="#ff0000">Password cannot be empty.</font>';
							echo json_encode($return_array);
						} else if(trim($re_password) == '') {
							$return_array['error']='<font color="#ff0000">Re-enter new password password.</font>';
							echo json_encode($return_array);
						} else if($new_password != $re_password) {
							$return_array['error']='<font color="#ff0000">Password donot match.</font>';
							echo json_encode($return_array);
						} else {
							$user = new user();
							$userDetails = $user->getUserDetailsByUserNameAndPassword($_SESSION['user']['email'],$old_password);
							if(empty($userDetails)) {
								$return_array['error']='<font color="#ff0000">Old password is not matching.</font>';
								echo json_encode($return_array);
							}else{
								if($user->updateProfilePassword($user_id,$new_password)) {
									$userDetails_updt = $user->getUserDetailsById($user_id);
									$pass_fMail = $userDetails_updt['password'];
									$userDetails_updt['password'] = '********';
									$_SESSION['user'] = $userDetails_updt;
									$replace_mail_data=array(
									'name' => $_SESSION['user']['fname'].' '.$_SESSION['user']['lname'],
									'email' => $_SESSION['user']['email'],
									'password' => $pass_fMail);
									$Mailtemplate = new Mailtemplate();
									$template = $Mailtemplate->getTemplateParsed('change_password', $replace_mail_data);

									$mail = new PHPMailer();
									$mail->IsSMTP();
									$mail->IsHTML(true);  
									$mail->AddAddress($_SESSION['user']['email'],$_SESSION['user']['fname'].' '.$_SESSION['user']['lname']);
									$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
									$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
									$mail->Subject = "Your login credentials for Japanmacroadvisors";
						  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
						  $mail->Body = $template['message'];
						  $mail->WordWrap = 50;                                 
						  $mail->Send();
						  $return_array['success']="Hi,<br> Your password has been changed successfully.<br>We sent your login credentials to your registered email address.";
						  echo json_encode($return_array);
						} else {
							$return_array['error']='<font color="#ff0000">Error in updating password.</font>';
							echo json_encode($return_array);
						}
					}
				}

			} else {
				$this->redirect('/user/login');
			}
		}

		public function editprofile() {
			$this->handleUnpaidUser();
			if($this->isUserLoggedIn() != true) {
				$this->redirect('user/login');
			} else {
				if(count($_POST)>0) {

					$signup_ts = $_POST['signup_ts'];

					if(!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
						$user_id = $_POST['user_id'];
					//$title = $_POST['title'];
						$fname = $_POST['fname'];
						$lname = $_POST['lname'];
						$country_id = $_POST['country_id'];
						$phone = $_POST['phone'];
						$country_code = $_POST['isd_code'];

						$user = new User();
						$userDetails = array(
							'id' => $user_id,
						//'title' => $title,
							'fname' => trim(addslashes($fname)),
							'lname' => trim(addslashes($lname)),
							'country_id' => $country_id,
							'country_code' => $country_code,
							'phone' => trim(addslashes($phone))
							);

						unset($_SESSION['signup_ts']);
						if($user->updateProfile($userDetails)) {
							$userprofile = $user->getUserDetailsById($user_id);
							$userprofile['password'] = '********';
							$_SESSION['user'] = $userprofile;
							$this->setFlashMessage("Your profile has been updated.");
						} else {
							$this->setFlashMessage("<font color='#ff0000'>Error in updating your prifile. Please try again.</font>");
						}
						$this->redirect('user/myaccount');
					} else{
						$this->redirect('user/myaccount');
					}

				} else {
					$this->redirect('/user/login');
				}
			}
		}
		public function updateMyProfile() {
			$this->handleUnpaidUser();
			if($this->isUserLoggedIn() != true) {
				$this->redirect('user/login');
			} else {
				if(count($_POST)>0) {
					$signup_ts 		= $_POST['signup_ts'];
					if(!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
						$user_id = $_POST['user_id'];
						$user_industry = $_POST['user_industry'];
						$user_position = $_POST['user_position'];
						$fname = $_POST['fname'];
						$lname = $_POST['lname'];
						$country_id = $_POST['country_id'];
						$phone = $_POST['phone'];
						if(!isset($_POST['request_info'])){
							$user_upgrade_status = $_POST['request_info'];
						}else{
							if(count($_POST['request_info'])==2){
								$user_upgrade_status = 'RB';
							}else{
								if(in_array('premium',$_POST['request_info'])){
									$user_upgrade_status = 'RP';
								}elseif (in_array('corporate',$_POST['request_info'])){
									$user_upgrade_status = 'RC';
								}
							}
						}
						$user = new User();
						$userDetails = array(
							'id' => $user_id,
							'fname' => $fname,
							'lname' => $lname,
							'country_id' => $country_id,
							'phone' => $phone,
							'user_position_id' => $user_position,
							'user_industry_id' => $user_industry,
							'user_upgrade_status' => $user_upgrade_status
							);
						unset($_SESSION['signup_ts']);
						if($user->updateMyProfile($userDetails)) {
							$userprofile = $user->getUserDetailsById($user_id);
							$userprofile['password'] = '********';
							$_SESSION['user'] = $userprofile;
							if(isset($user_upgrade_status)) {
								if($user_upgrade_status == 'RP')
								{
									$account = 'premium';
								}
								elseif($user_upgrade_status == 'RC')
								{
									$account = 'corporate';
								}
								elseif($user_upgrade_status == 'RB')
								{
									$account = 'both premium & corporate';
								}
								else{
									$account = '';
								}
								$mail = new PHPMailer();
								$mail->IsSMTP();
								$mail->IsHTML(true);  
								$notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
								$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
								$mail->clearAddresses();
								$mail->clearAttachments();
								$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
								$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
								$mail->Subject = $notification_subject;
								$mail->Body = "User with below details have requested for ".$account." account.<p>Name : ".$userprofile['fname']." ".$userprofile['lname']."<br><br>Email : ".$userprofile['email']."</p><br><br>
								Thanks,<br>
								JMA Team.<br>";
								$mail->AddAddress($notification_to);
								$mail->Send();
							}
							$this->renderResultSet['result']['userdetails'] = $_SESSION['user'];
							$this->setFlashMessage("Your profile has been updated.");
						} else {
							$this->setFlashMessage("<font color='#ff0000'>Error in updating your prifile. Please try again.</font>");
						}
						$this->redirect('user/editMyProfile');
					} else{
						$this->redirect('user/editMyProfile');
					}

				} else {
					$this->redirect('/user/login');
				}
			}
		}

		public function mailAlertUpdate()
		{

			$user = new User();
			if(!empty($_POST['alert_value']))
			{
				$alertStatus = $user->updateEmailAlert($_SESSION['user']['id'],$_POST['alert_value'],$_POST['is_thematic']);
				$this->redirect('user/myaccount/update/'.$_POST['alert_type']);
			}
			elseif($_POST['alert_value'] == "" &&  $_POST['is_thematic'] == "Y" )
			{
				
				$alertStatus = $user->updateEmailAlert($_SESSION['user']['id'],$_POST['alert_value'],$_POST['is_thematic']);
				$this->redirect('user/myaccount/update/'.$_POST['alert_type']);
			}
			elseif($_POST['alert_value'] == 0)
			{
				$alertStatus = $user->updateEmailAlert($_SESSION['user']['id'],$_POST['alert_value'],$_POST['is_thematic']);
				$this->redirect('user/myaccount/update/'.$_POST['alert_type']);
			}


		}
		public function newsletters() {
			$this->pageTitle = "Newsletters";
			$viewfile = '';
		// get all category items
			$media = new Media();
			$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
			$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
			$AlaneeCommon = new Alaneecommon();
			if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
				foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
					$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
				}
			}
			if(count($this->renderResultSet['result']['rightside']['media'])>0) {
				foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
					$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
				}
			}
			$this->populateLeftMenuLinks();		
			if(count($_POST)>0) {
				$user = new User();
				$unsubscribe_ts = $_POST['unsubscribe_ts'];
				if(!empty($unsubscribe_ts) && $_SESSION['unsubscribe_ts'] == $unsubscribe_ts)
				{
					try{
						$unsubscribe_email 	= $_POST['unsubscribe_email'];
						if(empty($unsubscribe_email))
						{
							throw new Exception('Please enter your email', 9999);
						}
						else if(!filter_var($unsubscribe_email, FILTER_VALIDATE_EMAIL))
						{
							throw new Exception('Please enter a valid email', 9999);
						}
						else
						{
							if($user->checkUserExistsByEmail($unsubscribe_email) == true)
							{
								$user->unSubscribeThisUserByEmail($unsubscribe_email);
								unset($_SESSION['unsubscribe_ts']);
								$unsubscribe_ts	= '';
								$viewfile = 'unsubscribe_mail_success';
							}
							else
							{
								throw new Exception('No matching email address found',9999);
							}
						}
					} catch (Exception $ex) {
						$this->renderResultSet['status'] = 9999;
						$this->renderResultSet['message'] = $ex->getMessage();
					}
				}

			}
			$this->renderView($viewfile);
		}

		public function confirm_unsubscribe($params) {
			try {
				if(count($params) > 0) {
					$code = $params[0];
				} else {
					throw new Exception('Error..! authentication code missing.', 9999);
				}
				$this->pageTitle = "Welcome to Japan macro advisors - confirm unsubscribe";
			// get all category items
				$media = new Media();
				$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
				$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
				$AlaneeCommon = new Alaneecommon();
				if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
					foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
						$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
					}
				}
				if(count($this->renderResultSet['result']['rightside']['media'])>0) {
					foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
						$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
					}
				}
				$this->populateLeftMenuLinks();
				$unsubscribe_obj = new Unsubscribe();
				$userDetails = $unsubscribe_obj->getUnsubscribeRequestByCode($code);
				if(count($userDetails)>0 && isset($userDetails['user_id'])){
					$user_obj = new User();
					$user_obj->deleteThisUser($userDetails['user_id']);
					$unsubscribe_obj->deleteThisEntry($userDetails['unsubscribe_id']);
				}
			} catch (Exception $ex) {
				$this->renderResultSet['status'] = $ex->getCode();
				$this->renderResultSet['message'] = $ex->getMessage();
				$this->renderResultSet['status'] = 9999;
				$this->renderResultSet['message'] = $ex->getMessage();
			}
			$this->renderView();
		}

		public function forgotpassword() {
			$this->handleUnpaidUser();
			try {
				$this->pageTitle = "Forgot Password?";
				$viewfile = '';
		// get all category items
				$media = new Media();
				$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
				$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
				$AlaneeCommon = new Alaneecommon();
				if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
					foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
						$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
					}
				}
				if(count($this->renderResultSet['result']['rightside']['media'])>0) {
					foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
						$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
					}
				}
				$this->populateLeftMenuLinks();		
				if(count($_POST)>0) {
					$user = new User();
					if(trim($_POST['forgotpasswd_email']) == '') {
						throw new Exception("Please enter your email address", 9999);
					} else if(!filter_var($_POST['forgotpasswd_email'], FILTER_VALIDATE_EMAIL)) {
						throw new Exception('Please enter a valid email', 9999);
					} 
					$userInfo = $user->getClientDetailsByEmail($_POST['forgotpasswd_email']);
					if(count($userInfo)==0) {
						throw new Exception("No matching email address found", 9999);
					}
					try {
						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->IsHTML(true);  
						$mail->AddAddress($_POST['forgotpasswd_email'],$userInfo[0]['clients_accounts_fname'].' '.$userInfo[0]['clients_accounts_lname']);
						$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
						$mail->Subject = "Your login credentials for Japanmacroadvisors";
					  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					  $mail->Body = "Dear ". $userInfo[0]['fname'].",<br><br>
					  
					  Thank you for contacting Japan Macro Advisors. <br><br>
					  Your login credentials for Japan Macro Advisors :<br>
					  <hr style='color:#f8f8f8'>
					  E-mail &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; ".$userInfo[0]['email']."<br>
					  Password :&nbsp; ".$userInfo[0]['password']."<br><br>

					  If you feel you have received this message in error, or you are still having problem logging into your account, please write to us to <b><i>support@japanmacroadvisors.com<i></b>.<br><br>
					  You can also login with your Linked-in account with email ".$userInfo[0]['email']."<br><br>
					  Thanks,<br>
					  JMA Team.	<p><br>
					  Follow us on: <br><br>
					  twitter: <a href='https://twitter.com/JapanMadvisors' target='_blank'>@japanMadvisors</a><br>
					  facebook: <a href='www.facebook.com/japanmacroadvisors' target='_blank'>www.facebook.com/japanmacroadvisors</a><br>
					  Linkedin: <a href='www.linkedin.com/company/japan-macro-advisors' target='_blank'>www.linkedin.com/company/japan-macro-advisors</a>
					  </p>";
					  $mail->WordWrap = 50;                                 
					  $mail->Send();
					  $this->renderResultSet['message'] = 

					  "Dear ". $userInfo[0]['fname'].",<br><br>We have sent your login credentials to <b>".$_POST['forgotpasswd_email']."</b> .<br><br>
					  
					  If you are still having problem logging into your account, please write to us to <b><i>support@japanmacroadvisors.com</i>.</b><br><br>
					  Thanks,<br>
					  JMA Team.<br>";

					} catch (phpmailerException $e) {
						throw new Exception($e->getMessage(), $e->getCode());
					} catch (Exception $e) {
						throw new Exception($e->getMessage(), $e->getCode());
					}					  
					$viewfile = 'forgotpassword_success';
				}
			}catch (Exception $ex) {
				$this->renderResultSet['status'] = $ex->getCode();
				$this->renderResultSet['message'] = $ex->getMessage();
			}
			$this->renderView($viewfile);

		}

		public function updatepaymentresponse_success($params,$kv_params) {
			try{
				$this->populateLeftMenuLinks();
				if($_SESSION['user']['id'] != $kv_params['uid']) {
					throw new Exception("Error..! Un-identified user", 9999);
				}else {
					$uid = $kv_params['uid'];
					$order_id = $kv_params['oid'];
					$transaction_id = $kv_params['tid'];
					$paypal = new Paypal();
					$payment_paypal_token = $_SESSION['user']['payment_transaction']['payment_token'];
					$user_email = $_SESSION['user']['email'];
					$user_name = $_SESSION['user']['fname'].' '.$_SESSION['user']['lname'];
					$subscription_start_date = $_SESSION['user']['expiry_on'];
					$payment_transaction_id = $_SESSION['user']['payment_transaction']['payment_transaction_id'];
					$paymentDetails = $paypal->getPaymentInfoAndStatus($uid, $order_id, $transaction_id, $payment_paypal_token);
					if(strtoupper($paymentDetails['ACK'])=='SUCCESS') {
						$payer_id = $paymentDetails['PAYERID'];
						$final_amount = (string)$_SESSION['user']['payment_transaction']['amount'];
					$new_expiry_date = strtotime("+1 month", time()); //$_SESSION['user']['expiry_on'] + (30 * 24 * 60 * 60);
					if($paypal->confirmPaymentAndInitiateSubscription($uid, $order_id, $transaction_id, $payment_paypal_token,$payer_id,$final_amount,$user_email, $user_name, $new_expiry_date) == true) {
						//$new_expiry_date = strtotime("+1 months");
						$user = new User();
						$user->setExpiryOnDate($_SESSION['user']['id'],$new_expiry_date);
						$_SESSION['user']['expiry_on'] = $new_expiry_date;
						//$user->setThisUserStatus($_SESSION['user']['id'],'active');
						$user->setThisUserToPremium($_SESSION['user']['id']); // upgrade to premium
						$user->setThisUserUpgradeStatus($_SESSION['user']['id'],'XP'); //Accepted premium
						$paymentTransaction = new Paymenttransaction();
						$paymentTransaction->updatePaymentStatus($payment_transaction_id, "OK");
						$_SESSION['user'] = $user->getUserDetailsById($_SESSION['user']['id']);
					}
				}
			}
			
		}catch (Exception $ex) {
			echo $ex->getMessage(); 
			exit;
		}
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$this->renderView();
	}
	
	public function updatepaymentresponse_cancel($params,$kv_params) {
		try{
			$this->populateLeftMenuLinks();
			if($_SESSION['user']['id'] != $kv_params['uid']) {
				throw new Exception("Error..! Un-identified user", 9999);
			}else {
				$payment_transaction_id = $kv_params['tid'];
				$paymentTransaction = new Paymenttransaction();
				$paymentTransaction->updatePaymentStatus($payment_transaction_id, "FAILED");
			}
			
		}catch (Exception $ex) {
			
		}
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$this->renderView();		
	}
	
	public function myaccount($params) {
		
		$this->handleUnpaidUser();

	//	$subscription = new Subscription();
	//	$subscription->unitTest();
		$user = new User();
		$tabname = isset($params[0]) ? $params[0] : 'profile';
		$firstParam = isset($params[1]) ? $params[1] : '';
		if($tabname == 'subscription' && isset($_POST['request_info']) && isset($_POST['signup_ts']) && $_SESSION['signup_ts'] == $_POST['signup_ts']){

			if(!isset($_POST['request_info'])){
				$user_upgrade_status = $_POST['request_info'];
			}else{
				if(count($_POST['request_info'])==2){
					$user_upgrade_status = 'RB';
				}else{
					if(in_array('premium',$_POST['request_info'])){
						$user_upgrade_status = 'RP';
					}elseif (in_array('corporate',$_POST['request_info'])){
						$user_upgrade_status = 'RC';
					}
				}

			}

			$userDetails = array(
				'id' => $_SESSION['user']['id'],
				'fname' => $_SESSION['user']['fname'],
				'lname' => $_SESSION['user']['lname'],
				'country_id' => $_SESSION['user']['country_id'],
				'phone' => $_SESSION['user']['phone'],
				'user_position_id' => $_SESSION['user']['user_position_id'],
				'user_industry_id' => $_SESSION['user']['user_industry_id'],
				'user_upgrade_status' => $user_upgrade_status
				);
			unset($_SESSION['signup_ts']);
			if($user->updateMyProfile($userDetails)) {
				$userDetails = $user->getUserDetailsById($_SESSION['user']['id']);
				$userDetails['password'] = '********';
				$_SESSION['user'] = $userDetails;
				
				// Send notification mail
				if($user_upgrade_status == 'RP')
				{
					$account = 'premium';
				}
				elseif($user_upgrade_status == 'RC')
				{
					$account = 'corporate';
				}
				elseif($user_upgrade_status == 'RB')
				{
					$account = 'both premium & corporate';
				}
				else{
					$account = '';
				}
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->IsHTML(true);
				$notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
				$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
				$mail->clearAddresses();
				$mail->clearAttachments();
				$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
				$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
				$mail->Subject = $notification_subject;
				$mail->Body = "User with below details have requested for ".$account." account.<p>Name : ".$userDetails['fname']." ".$userDetails['lname']."<br><br>Email : ".$userDetails['email']."</p><br><br>
				Thanks,<br>
				JMA Team.<br>";
				$mail->AddAddress($notification_to);
				$mail->Send();
			}
		}
		try{
			$this->populateLeftMenuLinks();
			if($this->isUserLoggedIn() == true) {
				$country = new Country();
				$this->renderResultSet['result']['userdetails'] = $user->getUserDetailsById($_SESSION['user']['id']);
				$this->renderResultSet['result']['country_list'] = $country->getCountryDatabaseAsArray();
				$this->renderResultSet['result']['country_list1'] = $country->getCountryDatabase();
				$this->renderResultSet['result']['emailAlert_category'] = $user->emailAlertCategory();
				$this->renderResultSet['result']['emailAlert_choiceofUsers'] = $user->emailAlertChoiceofUsers($_SESSION['user']['id']);
				$this->renderResultSet['result']['tabname'] = $tabname;
				$this->renderResultSet['result']['firstParam'] = $firstParam;
				$this->renderResultSet['result']['defaultEmailAlert'] = $user->defaultEmailAlert();		
				$payment_history = $user->get_payment_history($_SESSION['user']['id']);
				$this->renderResultSet['result']['payment_history'] = $payment_history;
				
			} else {
				$tabname = isset($params[0]) ? $params[0] : 'profile'; 
				if($tabname == "email-alert")
				{
					$this->redirect('user/login?r=user/myaccount/email-alert');
				}
				else
				{
					$this->redirect('user/login?r=user/myaccount/subscription');
				}
				
			}
			
		}catch (Exception $ex) {
			
		}
		
		$this->renderView();
	}
	
	public function cancelmysubscription(){
		/**
		 * Not in use
		 * Used for paypal recurrent payment cancellation
		 */
		
		try{
			if($this->isUserLoggedIn() == true) {
				$recurrent_profile_id = $_SESSION['user']['recurrent_profile_id'];
				if($recurrent_profile_id != '') {
					$paypal = new Paypal();
					if($paypal->suspendRecurrentProfile($recurrent_profile_id) == true) {
						$user = new User();
						$uid = $_SESSION['user']['id'];
						$user->setThisUserStatus($uid, 'expired');
						$_SESSION['user'] = $user->getUserDetailsById($uid);
						$this->setFlashMessage("Your subscription status is changed to Expired.");
						$this->redirect('/user/myaccount');
					}else{
						throw new Exception("Error..!. Couldn't update your subscription status.", 9999);
					}
				}else {
					throw new Exception("Error..! Error in identifying subscription payment status.", 9999);
				}
			} else {
				$this->redirect('user/login');
			}
		}catch (Exception $ex) {
			$this->setFlashMessage("<font color='#ff0000'>".$ex->getMessage()."</font>");
			$this->redirect('/user/myaccount');
		}
	}
	
	public function reactivatemysubscription() {
		try{
			if($this->isUserLoggedIn() == true) {
				$recurrent_profile_id = $_SESSION['user']['recurrent_profile_id'];
				if($recurrent_profile_id != '') {
					$paypal = new Paypal();
					if($paypal->reactivateRecurrentProfile($recurrent_profile_id) == true) {
						$user = new User();
						$uid = $_SESSION['user']['id'];
						$user->setThisUserStatus($uid, 'active');
						$_SESSION['user'] = $user->getUserDetailsById($uid);
						$this->setFlashMessage("Your subscription is activated successfully.");
						$this->redirect('/user/myaccount');
					}else{
						throw new Exception("Error..!. Couldn't activate your subscription.", 9999);
					}
				}else {
					throw new Exception("Error..! Error in identifying subscription payment status.", 9999);
				}
			} else {
				$this->redirect('user/login');
			}
		}catch (Exception $ex) {
			$this->setFlashMessage("<font color='#ff0000'>".$ex->getMessage()."</font>");
			$this->redirect('/user/myaccount');
		}		
	}
	
	public function test(){
		$Mailtemplate = new Mailtemplate();
		$data = array(
			'name' => 'shijo thomas',
			'username' => 'shijosap',
			'password' => '123@123',
			'activation_link' => 'jma.com'
			);
		$template = $Mailtemplate->getTemplateParsed('reg_confirm_activation', $data);
		//echo '<pre>';
		print_r($template); exit;
	}

	/* By veera*/
	/*  User Deactiavate account */
	public function user_deactivate(){
		$media = new Media();
		$this->populateLeftMenuLinks();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$user = new User();
		$id = $_SESSION['user']['id'];
		if(isset($_POST['submit'])){
			if($_POST['submit']=='individual'){
				$message='We have received your request for cancellation of Premium account subscription.Your Premium Account subscription will discontinue on your next renewal and you will become our Free account user.You could login to our website and access to all free contents';
				$update=$user->user_deactivate(1,$id);
				$this->downgrade_success_send_mail($id);
			}elseif($_POST['submit']=='corporate'){
				$message='We have received your request for cancellation of Corporate account subscription.Your Corporate Account subscription will discontinue on your next renewal and you will become our Free account user.You could login to our website and access to all free contents';
				$update=$user->user_deactivate(1,$id);
				$update=$user->setThisUserStatus($id,'active');
				$this->downgrade_success_send_mail($id);
			}else{
				$message='Your account has been permanently deleted from our site';
				$update=$user->user_deactivate(2,$id);
				
				$this->logout();
			}

			if($update){
				$this->setFlashMessage($message);
			}
		}	



		$userDetails = $user->getUserDetailsById($id);
		$userDetails['password'] = '********';
		$_SESSION['user'] = $userDetails;
		$this->renderResultSet['result']['userdetails'] = $_SESSION['user'];
		

		$this->renderView();

	}
	/*  User Deactiavate account */

	/*  User pay or downgrade account */

	public function user_pay_downgrade(){
		

		if(isset($_SESSION['user'])){
			$media = new Media();
			$this->populateLeftMenuLinks();
			$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
			$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
			$user = new User();
			$id = $_SESSION['user']['id'];
			if(isset($_POST['submit'])){
				if($_POST['submit']=='free'){

					$message='Successfully you are downgrade to "FREE" user';
					$update=$user->user_deactivate(1,$id);
					$update=$user->setThisUserStatus($id,'active');
					$this->setFlashMessage($message);
					header("Refresh:3; url='myaccount'");

				}
			}
			$userDetails = $user->getUserDetailsById($id);
			$userDetails['password'] = '********';
			$_SESSION['user'] = $userDetails;
			$this->renderResultSet['result']['userdetails'] = $_SESSION['user'];
			$this->renderView();
		}else{
			$this->logout();
		}

	}

	public function user_type_upgrade(){
  		/**
		 * Handle upgrade
		 * @author : Veera
		 * Change statuses
		 * 1 user type : 2 (individual)
		 * status : 7 (unpaid)
		 * Forward to do payment
		 */
  		$user = new User();
  		$email = $_SESSION['user']['email'];
  		$getUserDetails = $user->getUserDetailsByEmail($email);
  		if($getUserDetails[0]['user_type_id'] == 1 && $getUserDetails[0]['user_status_id'] == 4){
  			if($getUserDetails[0]['stripe_subscription_id'] != null){
  				$id = $_SESSION['user']['id'];
  				$update=$user->setThisUserToPremium($id);
  				$subscription = new Subscription();
  				$upgradeSubscriptionProcess = $subscription->upgradeSubscription($getUserDetails[0]['stripe_customer_id']);


  				if($upgradeSubscriptionProcess->id){
					//send success mail
  					$userDetails = $user->getUserDetailsById($id);
  					$userDetails['password'] = '********';
  					$_SESSION['user'] = $userDetails;

  					$this->payment_success_send_mail($_SESSION['user']['id']);
  					$this->setFlashMessage('Upgarde');
  					$this->redirect('user/payment_success');
  				}else{
  					$this->setFlashMessage('Upgrade Failed');
  					$this->redirect('user/myaccount');
  				}
  			}else{
  				$id = $_SESSION['user']['id'];
				//$_SESSION['user']=$getUserDetails;
  				$_SESSION['user_type_upgrade']=1;

  				$this->redirect('/user/dopayment');
  			}
  		}else{
  			$this->redirect('user/myaccount');
  		}
  	}

  	private function user_upgrade_mail($id){
  		$user = new User();
  		$user_details = $user->getUserDetailsById($id);
  		$user_type=($user_details['user_type']=='individual')?"Premium":ucfirst($user_details['user_type']);
  		$mail = new PHPMailer();
  		$mail->IsSMTP();
  		$mail->IsHTML(true);  
  		$notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
  		$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
  		$mail->clearAddresses();
  		$mail->clearAttachments();
  		$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
  		$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
  		$mail->Subject = $notification_subject;
  		$mail->Body = "User with below details has upgraded to Premium account.<p>Name : ".$user_details['fname']." ".$user_details['lname']."<br><br>Email : ".$user_details['email']."<br><br>Subscription Type: ".$user_type."</p><br><br>
  		Thanks,<br>
  		JMA Team.<br>";
  		$mail->AddAddress($notification_to);
  		$mail->Send();
  	}

  	public function unsubscribe_user($params){
		
		$firstParam = isset($params[0]) ? base64_decode($params[0]) : ''; 
  		$this->handleUnpaidUser();
  		$this->pageTitle = "Welcome to Japan macro advisors";
  		$this->renderResultSet['meta']['description']='Japan macro advisors - Sign up';
  		$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe';
  		$AlaneeCommon = new Alaneecommon();
  		$this->populateLeftMenuLinks();
		$user = new User();
		if(!empty($user->getUserDetailsByEmail($firstParam)))
		{
			$this->renderResultSet['result']['emailAlert_category'] = $user->emailAlertCategory();
			$this->renderResultSet['result']['emailAlert_choiceofUsers'] = $user->emailAlertChoiceofUsers($firstParam);
			$this->renderResultSet['result']['userdetails'] = $user->getUserDetailsByEmail($firstParam);
			$this->renderResultSet['result']['firstParam'] = $firstParam;
			$this->renderResultSet['result']['defaultEmailAlert'] = $user->defaultEmailAlert();	
			$this->renderView();	
		}
		else
		{
			$this->error(404);
		}
		
		
  	}
	
	public function mailAlertUpdateWithoutLogin()
	{
		
		

		$user = new User();
		if(!empty($_POST['alert_value']))
		{
			$alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'],$_POST['alert_value'],$_POST['is_thematic']);
			$this->redirect('user/unsubscribe_update_sccess/');
		}
		elseif($_POST['alert_value'] == "" &&  $_POST['is_thematic'] == "Y" )
		{
			
			$alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'],$_POST['alert_value'],$_POST['is_thematic']);
			$this->redirect('user/unsubscribe_update_sccess/');
		}
		elseif($_POST['alert_value'] == 0)
		{
			$alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'],$_POST['alert_value'],$_POST['is_thematic']);
			$this->redirect('user/unsubscribe_update_sccess/');
		}


	}
	
	public function unsubscribe_user_encode($params)
	{
		$firstParam = isset($params[0]) ? $params[0] : ''; 
		$this->redirect('user/unsubscribe_user/'.base64_encode($firstParam));
	}
	
	
	public function unsubscribe_update_sccess(){
		
  		$this->handleUnpaidUser();
  		$this->pageTitle = "Welcome to Japan macro advisors";
  		$this->renderResultSet['meta']['description']='Japan macro advisors - Sign up';
  		$this->renderResultSet['meta']['keywords']='Sign up, register, subscribe';
  		$AlaneeCommon = new Alaneecommon();
  		$this->populateLeftMenuLinks();
		$this->renderView();	
  	}
	
  }
  ?>

