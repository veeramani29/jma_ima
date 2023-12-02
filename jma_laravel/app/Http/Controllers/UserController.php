<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use View;
use Config;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Model\User;
use App\Model\Mailtemplate;
use App\Model\Country;
use App\Lib\MailGunAPI;
use App\Libraries\mailer\PHPMailer;
use App\Libraries\reCaptcha\ReCaptcha;
use App\Libraries\linkedIn\oauth_client_class;
use Exception;
use App\Http\Controllers\ErrorController;
use App\Libraries\subscription_management\SubscriptionClass;
use Cookie;
use Session;
use App\Libraries\payment\PaypalClass;
use Illuminate\Support\Arr;
class UserController extends Controller
{

    public function __construct ()
        {
            parent::__construct();

            View::share ( 'menu_items', $this->populateLeftMenuLinks());

        }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function index()
    {       
         new ErrorController(404);
    }



	public function check_email()
    {
        $user = new User();
		$return = $user->checkUserExistsByEmail($_POST['user_email']);
		echo json_encode($return);
	}
    
     public function signup()
    {
 
        //print_r($_SESSION);
        $this->handleUnpaidUser();

        if(Session::has('temp_user') && Session::get('temp_user')!=null){
            Session::forget('temp_user');
          
        }

        if(Session::has('user') && Session::get('user.id') > 0) {
           return redirect('/');
       
        }
        $user = new User();
        $country = new Country();
        $media = new Media();
      
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
       

        $data['pageTitle']= "Welcome to Japan macro advisors - Sign up";
         $data['meta']['description']="Japan macro advisors - Sign up";
        $data['meta']['keywords']='Sign up, register, subscribe';
        $data['renderResultSet']=$data;

        $user_position = $user->getPositionsDatabase();
        $user_industry = $user->getIndustryDatabase();
        $data['result']['user_position'] = $user_position;
        $data['result']['user_industry'] = $user_industry;
        $data['result']['country_list'] = $country->getCountryDatabase();
        $data['result']['signup_error_id'] = '';
        $data['result']['postdata'] = null;
        //* from Product Page
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
        $data['result']['request_info'] = $request_info;
      //* form Product Page
        $secret = "6LfKEjoUAAAAAKmtlf3LzbmISR8922JXwHrRQDvd";

  // empty response
        $response1 = null;


         $error = false;
            if(isset($_POST['signup_btn']))

            {
                $response1 = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST['g-recaptcha-response']);
                $response2 = json_decode($response1, true);

           $error = false;
       
            $data['result']['postdata'] = $_POST;
             $signup_ts  = $_POST['signup_ts'];

            if(!empty($signup_ts) && Session::get('signup_ts')== $signup_ts)
            {
                //unset($_SESSION['signup_ts']);

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
				$user_type = $_POST['product'];				
                $recaptcha = $_POST['g-recaptcha-response'];              
                $user_position_id = $_POST['user_position'];
                $user_industry_id = $_POST['user_industry'];
                $user_type_id=($user_type=='premium')?2:1;
                $user_status_id=2;
                if($user_title =="Other" && $OtherTitle == ''){
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'Please enter Title';
                    $data['result']['signup_error_id'] = '#user_title_id';
                    $error = true;
                }else if(empty($fname)){
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'Please enter first name';
                    $data['result']['signup_error_id'] = '#reg_first_name';
                    $error = true;
                }
                else if(empty($lname))
                {
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'Please enter last name';
                    $data['result']['signup_error_id'] = '#reg_last_name';
                    $error = true;
                }
                else if(empty($email))
                {
                    $data['result']['status'] = 3333;
                    $data['result']['message']= 'Please enter email';
                    $data['result']['signup_error_id'] = '#reg_email';
                    $error = true;
                }
                else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'Please enter a valid email';
                    $data['result']['signup_error_id'] = '#reg_email';
                    $error = true;
                }
                else if($user->checkUserExistsByEmail($email))
                {
                    $data['result']['status'] = 3333;
                       if(strpos(url()->previous(), 'products') !== false){
                    $data['result']['message'] = 'A user already registered with this email id,';

                     # $data['result']['message'] = 'User already registered with this email, If you are already a JMA subscriber please <a href='.url('user/login').'>login</a>';
                }else{
                  $data['result']['message'] = 'A user already registered with this email id, please try another email. ';  
                }
                    $data['result']['signup_error_id'] = '#reg_email';
                    $error = true;
                }
                else if(!intval($country_id))
                {
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'Please select country';
                    $data['result']['signup_error_id'] = '#country_id';
                    $error = true;
                }
                else if(empty($recaptcha)) {
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'Please select captcha';
                    $error = true;
                }
                else if($response2["success"] === false){
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'You are a robot';
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
                    $CommonClass = new CommonClass();
                    $reg_password = $CommonClass->createPassword(8);
                    
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
                        Session::put('temp_user',$userDetails);
                       
                        return redirect('user/dopayment/');
                    } //check user_type end

                    if($user_type_id!=2){ //check user_type start
                      try {
            $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
            $appPath = Config::read('appication_path') != '' ? trim(Config::read('appication_path'),'/') : '';

            $activation_link = 'http://'.$_SERVER['HTTP_HOST'].$appPath.'/user/confirmregistration/'.base64_encode($email);

       
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->IsHTML(true);
                    //$mail->IsMail();
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
                    $mail->AddAddress($userDetails['email'],$userDetails['fname'].' '.$userDetails['lname']);
                       if(!$mail->Send()){

                        $data['result']['status'] = 3333;
                        $data['result']['message'] = 'We could not sent activation mail to you. Please register with alternative email';
                        $data['result']['signup_error_id'] = '#reg_email';
                        $error = true;
                       }else{
                        $u_details = $user->addUserRegistration($userDetails);
                        $user_details = $user->getUserDetailsById($u_details['id']);
                        if($evenPath == "production")
                            {
                            $MailGunAPI = new MailGunAPI();
                                $MailGunAPI->addNewUserMailGunListingAddress($email,$fname);
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
                        $n_user_type=($user_type!="premium")?"Free":"Standard";
                        $phonedetails=($phone!='')?$phonecode.$phone:'';
						$db_language = "JMA EN";
                        $notify_body_msg= "A new ".$n_user_type." user signed up with us on ".$db_language.". <p>Name : ".ucfirst($fname)." ".ucfirst($lname)."<br><br>Email : ".$email."<br><br>Phone : ".$phonedetails."";
                        if ($user_type=='corporate'){
                            $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
                        }
                        $mail->Body =$notify_body_msg;
                        $mail->AddAddress($notification_to);
                        $mail->Send();
                    }catch (Exception $e) {
                        $data['result']['status'] = 9999;
                        $data['result']['message'] = 'Error...! '.$e->getMessage();
                        $error == true;
                    }

                       }
                    }catch (Exception $e) {
                        $data['result']['status'] = 9999;
                        $data['result']['message'] = 'Error...! '.$e->getMessage();
                        $error == true;
                    }

                   


                    }//check user_type end  
                }
                $render = true;

                if($error != true) {


if($user_type_id!=2){ //check user_type start
$data['result']['user_details'] = $user_details;
$flash_arr = array('user_id'=>$u_details['id']);

$this->setFlashMessage($flash_arr);
return redirect('user/completeregistration_success');
}//check user_type end
                
                   
                   
                }
        }
            }

            if(strpos(url()->previous(), 'products') !== false){
            return redirect('products#5')->with('data', $data);
            }
      





        return view('user.signup', $data);
    }


/**

     * Registration success page
     * @param Int $u_id : user id
     */
                public function completeregistration_success(){
                    $fl_msg = $this->getFlashMessage();
                   
                    if(isset($fl_msg['user_id'])){
                        $u_id = $fl_msg['user_id'];
                        $user = new User();
                        $country = new Country();
                        $media = new Media();
                       
                            $data['pageTitle']= "Welcome to Japan macro advisors - Sign up";
                            $data['meta']['description']="Japan macro advisors - Sign up";
                            $data['meta']['keywords']='Sign up, register, subscribe';
                            $data['renderResultSet']=$data;
                            // Getting user details by user id
                        $user_details = $user->getUserDetailsById($u_id);
                        Session::put('reg_user_id',$user_details['id']);
                       
                        $data['result']['user_details'] = $user_details;

                        return view('user.signin_confirm',$data);
                    }else {
                      return redirect('user/signup');
                    }   
                }



/**
     * Confirm registration - validate email adress
     * @param String $params : base64 encoded user id
     */
    public function confirmregistration($params) {
       
      

            $user = new User();
            $country = new Country();
            $media = new Media();
           $data['pageTitle']= "Welcome to Japan macro advisors - Sign up";
                            $data['meta']['description']="Japan macro advisors - Sign up";
                            $data['meta']['keywords']='Sign up, register, subscribe';
                            $data['renderResultSet']=$data;
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);

            if($params!='') {

if(!filter_var(base64_decode($params), FILTER_VALIDATE_EMAIL)) {
     
                     new ErrorController(404);
                } else {
                    
                    $user_email = base64_decode($params);
                    $user = new User();
                    if($user->validateUserEmail($user_email)) {
                   
                        $user_details = $user->getUserDetailsByEmail($user_email); 
                     
                        $user_id=$user_details[0]['id'];  
                        $user_details = $user->getUserDetailsById($user_id);
                        if($user_details['user_status'] == 'active'){
                            
                             new ErrorController(404);
                        }
    
                        $data['result']['message'] = "Dear <b>".ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']).",</b><br><br>Thank you for signing up to Japan Macro Advisors. Your free account is now active.<br>Your access credentials have been mailed to <b><i>".$user_details['email'].".</i></b>";
                        $mail = new PHPMailer();
                        
                        $mail->IsSMTP();
                          //$mail->IsMail();
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
                            'title' => $user_details['user_title'],
                            'email' => $user_details['email'],
                            'password' => $user_details['password'],
                            'accountType' => ucfirst($user_details['user_type']).$corp
                            );

                        $template = $Mailtemplate->getTemplateParsed('welcome_accountdetails', $mail_data);

                        $mail->Subject = $template['subject'];
                        $mail->Body = $template['message'];
                        $mail->AddAddress($user_details['email'],$user_details['fname'].' '.$user_details['lname']);

                        $mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
                        $mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                        $mail->Send();
                       
                       
                        $user->setThisUserStatus($user_details['id'], 'active');

                        $user_details = $user->getUserDetailsById($user_id);


                        $user_details['password'] = '********';
                       Session::put('user',$user_details);
                     
                       return redirect('/');


                    } else {
                       
                        $data['result']['status'] = 9999;
                        $data['result']['message'] = "Error..! Couldn't update user you already activated your account"; 
                         return view('user.signin_success',$data);
                          
                    }
                }           
            } else {
                 
                 new ErrorController(404);
            }
        
           
               
    }



public function login($uparam='') {

                        if(!empty($_GET)){
                        $uparam=$_GET;
                        }
                   

                    $this->handleUnpaidUser();
                  
                     $data['pageTitle']= "Japan Macro Advisors | Economy login";
                    $data['meta']['description']='Japan macro advisors - login';
                    $data['meta']['keywords']='Sign up, register, subscribe, log in, user';
                    $data['renderResultSet']=$data;

                    if(!Session::has('fullredirect_redirecturl') || Session::get('fullredirect_redirecturl') == ''){
                         Session::put('fullredirect_redirecturl',(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : null);
                       
                    }
                        if(!isset($_POST['premium_login'])) {
                         if($this->isUserLoggedIn() == true) {
                        return redirect('user/myaccount');
                        }
                        }
                    if(isset($uparam['r']) && $uparam['r']!=''){
                        Session::put('redirecturl',$uparam['r']);
                        
                      
                    }


        // get all category items
                    $media = new Media();
                   $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $AlaneeCommon = new CommonClass();
        if(count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
            }
        }
        if(count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
            }
        }
                  
                    if(count($_POST)>0) {
                        $user = new User();
                        $username = $_POST['login_email'];
                        $password = $_POST['login_password'];
                        $user_row = $user->check_user_status($username,$password);
                        if(is_bool($user_row)){
							$userDetails = $user->getUserDetailsByUserNameAndPassword($username,$password);
    
                            $userDetails['password'] = '********';
                            $userDetails['loginViaLinkedIn'] = 'no';
                            if(count($userDetails)>0 && $userDetails['id'] >0) {
               
                                if(!empty($_POST['login_rememberMe']) && $_POST['login_rememberMe']=='y')
                                {
                                    $path = "/";
                                    $salt = "125778rttyyyu";
                                    $rm = $salt."_".$username."_".$password."_".$salt;
                                    $rm = base64_encode($rm);
                                    $rm = base64_encode($rm);
                                    Cookie::queue(Cookie::forever('jmacrm', $rm));                 
                                    //setcookie("jmacrm",$rm,time()+3600 * 24 * 365,$path);                                       
                                }

                # autologin setcookie start
                                $cookie_value=base64_encode($userDetails['email']).'|||'.md5($userDetails['password']);
                                 Cookie::queue(Cookie::forever('JMA_USER', $cookie_value));  
                                //setcookie("JMA_USER", $cookie_value, time()+3600 * 24 * 365, '/');
                    # autologin setcookie end
                                 Session::put('user', $userDetails);
                             

                                if($userDetails['user_status_id']==7){

                                  return redirect('user/user_pay_downgrade');die;

                                }



                                if(Session::has('redirecturl') && Session::get('redirecturl') != '') {
                                    $redirect_url = Session::get('redirecturl');
                                    Session::forget('redirecturl');  Session::forget('fullredirect_redirecturl');
                                   
                                  return redirect($redirect_url);
                                    exit;
                                } else {
                                      if(Session::has('fullredirect_redirecturl') && Session::get('fullredirect_redirecturl') != '') {
                                   
                                        $full_redirect_url =  Session::get('fullredirect_redirecturl');;
                                       Session::forget('fullredirect_redirecturl');
                                        Session::forget('redirecturl'); 
                                         return redirect($full_redirect_url);
                                        exit;
                                    }elseif(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
                                        $full_redirect_url = $_SERVER['HTTP_REFERER'];
                                        Session::forget('fullredirect_redirecturl');
                                        Session::forget('redirecturl'); 
                                         return redirect($full_redirect_url);
                                        exit;
                                    }else{
                                        Session::forget('fullredirect_redirecturl');
                                        Session::forget('redirecturl'); 
                                        return redirect('/');
                                        exit;
                                    }
                                }
                            } else{
                                $data['result']['status'] = 3333;
                                $data['result']['message'] = 'Login failed. Please try again';
                            }


                        } else{
                            $data['result']['status'] = 3333;
                            $data['result']['message'] = $user_row;
                        }
                    }
                   return view('user.login',$data);
                } 




                public function premium_login($uparam=''){

                   
                    $this->handleUnpaidUser();
                    $data['pageTitle']= "Japan Macro Advisors | Economy login";
                    $data['meta']['description']='Japan macro advisors - login';
                    $data['meta']['keywords']='Japan Macro Advisors | Sign up | register | subscribe | log in, user';
                    $data['renderResultSet']=$data;
                   if(!Session::has('fullredirect_redirecturl') && Session::get('fullredirect_redirecturl') == '') {
                        Session::put('fullredirect_redirecturl', (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : null);
                    
                    }
                    if(Session::get('user.user_type') == 'individual') {
                        return redirect('user/myaccount');
                    }
                    if(isset($uparam['r']) && $uparam['r']!=''){
                         Session::put('redirecturl', $uparam['r']);
                     
                    }
                  
                   
        // get all category items
                  $media = new Media();
                   $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $AlaneeCommon = new CommonClass();
        if(count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
            }
        }
        if(count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
            }
        }

      

                  return view('user.login',$data);
                }



public function loginbyajx($uparam=''){
                    if($this->isUserLoggedIn() == true) {
            // Return user details
                        $userDetails = Session::get('user');
                        $data['status'] = 1;
                        $data['message'] = 'OK';
                        $data['result'] = array('userdetails'=>$userDetails);
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
                               Session::put('user',$userDetails);
                             
                                $data['status'] = 1;
                                $data['message'] = 'OK';
                                $data['result'] = array('userdetails'=>$userDetails);
                            } else{
                                $data['status'] = 3333;
                                $data['message'] = 'Login failed. Please try again';
                            }
                        } else{
                            $data['status'] = 3333;
                            $data['message'] = $user_row;
                        }
                    }else{
                        $data['status'] = 3333;
                        $data['message'] = 'Login failed. Please try again';
                    }
                    echo json_encode($data);
                }


    public function logout() {

                    $path = "/";
                    $rm = "";
                    Cookie::queue(Cookie::forever('jmacrm', ''));
                    Cookie::forget('jmacrm');
                     Session::flush();
                     Session::regenerate();
                    Session::forget('user');
                    session_unset();
                    session_destroy();
                    $_SESSION = array();

                   return redirect('/');
                }



                public function forgotpassword() {
                    
      

                    $data['pageTitle']= "Japan Macro Advisors | Forgot Password?";
                    $data['meta']['description']='Japan macro advisors - login';
                    $data['meta']['keywords']='Sign up, register, subscribe, log in, user';
                    $data['renderResultSet']=$data;
              
       
                if(count($_POST)>0) {
                    $user = new User();
                    if(trim($_POST['forgotpasswd_email']) == '') {
                         $data['result']['status'] = 404;
                        $data['result']['message'] ="Please enter your email address";
                       
                    } else if(!filter_var($_POST['forgotpasswd_email'], FILTER_VALIDATE_EMAIL)) {
                         $data['result']['status'] = 404;
                        $data['result']['message'] ="Please enter a valid email";
                      
                    } 
                    $userInfo = $user->getClientDetailsByEmail($_POST['forgotpasswd_email']);
                    
                    if(count($userInfo)==0) {
                          $data['result']['status'] = 404;
                        $data['result']['message'] ="No matching email address found";
                    }
                    if(count($userInfo)>0) {
                        $verify = $user->Validate_Email_Verification($userInfo[0]['id']);
                          if(!$verify) {
                              $data['result']['status'] = 404;
                             $data['result']['message'] = "Your account has not been activated please check your email for regarding activation. or contact to our admin";
                            
                          }else{
                            try {
                                $Mailtemplate = new Mailtemplate();
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        //$mail->IsMail();
                        $mail->IsHTML(true);  
                        $mail->AddAddress($_POST['forgotpasswd_email'],$userInfo[0]['fname'].' '.$userInfo[0]['lname']);
                        $mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
                        $mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');


                        $mail_data = array(
                            'name' => ucfirst($userInfo[0]['fname']).' '.ucfirst($userInfo[0]['lname']),
                           'email' => $userInfo[0]['email'],
                            'password' => $userInfo[0]['password']
                           
                            );

                        $template = $Mailtemplate->getTemplateParsed('forgot_password', $mail_data);
                        $mail->Subject = $template['subject'];
                        $mail->Body = $template['message'];
    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                    
                      $mail->WordWrap = 50;                                 
                      $mail->Send();
                      $data['result']['message'] = 

                      "Dear ". $userInfo[0]['fname'].",<br><br>We have sent your login credentials to <b>".$_POST['forgotpasswd_email']."</b> .<br><br>
                      
                      If you are still having problem logging into your account, please write to us to <b><i>support@japanmacroadvisors.com</i>.</b><br><br>
                      Thanks,<br>
                      JMA Team.<br>";

                    } catch (phpmailerException $e) {
                        throw new Exception($e->getMessage(), $e->getCode());
                    }  

                    return view('user.forgotpassword_success',$data);
                          }
                     
                    }

                                       
                     
                }
        

           return view('user.forgotpassword',$data);

        }



        public function newsletters() {

            

             $data['pageTitle']= "Japan Macro Advisors | Economy Forgot Password?";
                    $data['meta']['description']='Japan macro advisors - login';
                    $data['meta']['keywords']='Sign up, register, subscribe, log in, user';
                    $data['renderResultSet']=$data;
           
         
        // get all category items
               $viewfile = 'newsletters';
            if(count($_POST)>0) {
                $user = new User();
                $unsubscribe_ts = $_POST['unsubscribe_ts'];
                if(!empty($unsubscribe_ts) && Session::get('unsubscribe_ts') == $unsubscribe_ts)
                {
                    try{
                        $unsubscribe_email  = $_POST['unsubscribe_email'];
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
                                Session::forget('unsubscribe_ts');
                             
                                $unsubscribe_ts = '';
                                $viewfile = 'unsubscribe_mail_success';
                            }
                            else
                            {
                                throw new Exception('No matching email address found',9999);
                            }
                        }
                    } catch (Exception $ex) {
                        $data['result']['status'] = 9999;
                        $data['result']['message'] = $ex->getMessage();
                    }
                }

            }
             return view('user.'.$viewfile,$data);
           
        }




        public function linkedinProcess($product_type=null,$series_code=false) {

        

        if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
            // in case if user cancel the login. redirect back to home page.
            Session::put('err_msg', $_GET["oauth_problem"]);
            return redirect('/user/signup');
            exit;
        }

        $array_Cancel=array('user_cancelled_authorize',"user_cancelled_login");
        if (isset($_GET["error"]) && in_array($_GET["error"], $array_Cancel)) {
            // in case if user cancel the login. redirect back to home page.v2
            Session::put('err_msg', $_GET["error_description"]);
             $this->setFlashMessage($_GET["error_description"]);
            return redirect('/user/login');
            exit;
        }

        
                
        if(Session::has('linkedinData') && Session::get('linkedinData')!=null){
                Session::forget('linkedinData');
              }
        $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
$get_product_='';
if($product_type==null && $series_code==false){

$get_product='';
if(!isset($_GET['code']) && !isset($_GET['state'])){
if(isset($_SESSION['downloadUrl'])){
unset($_SESSION['downloadUrl']);
}
foreach ($_GET as $key => $value) {
if($key!='url'){

if($evenPath != "development")
{
$get_product_.=str_replace("_", ".", $key)."=".$value."&";
}
}

}
}
$get_product_=$get_product_;  
}else{
 // Get product Type
 $get_product=$product_type;   
}

       
     
        $client = new oauth_client_class;
         $callbackURL = Config::read('LinkedIn.'.Config::read('environment').'.callbackURL')."/".$get_product;// Conc product Type 
   
        $linkedinApiKey = Config::read('LinkedIn.'.Config::read('environment').'.linkedinApiKey');
        $linkedinApiSecret = Config::read('LinkedIn.'.Config::read('environment').'.linkedinApiSecret');
        $linkedinScope = Config::read('LinkedIn.'.Config::read('environment').'.linkedinScope');
        
       
         

        if(isset($get_product_) && $get_product_!=null){

                if (strpos($get_product_, '@') !== false) {
                $get_product_ = str_replace("@","/",$get_product_);
                }
               $get_product_=rtrim($get_product_,"=&");
                $_SESSION['downloadUrl']=rtrim($get_product_,'&');
            
        }else{

            if(isset($_GET['code']) && isset($_GET['state'])){

                if(isset($_SESSION['downloadUrl'])){
                if($evenPath != "development")
                {
                    $parse_url = parse_url($_SESSION['downloadUrl']);
                    $queryString='';
                    if(isset($parse_url['query'])){
                      $queryString = str_replace(".", "_", $parse_url['query']);
                      parse_str($queryString,$output_);
                        $gids_codes=($output_);
                        Session::put('chartIndex',$gids_codes['graph_index']);
                        Session::put('graph_gids',str_replace('|', ',', $gids_codes['gids']));
                         $seriesUrl = $parse_url['path'].'?'.$queryString;
                      
                     }else{
                        Session::put('chartIndex',0);
                        Session::put('graph_gids','');
                          $seriesUrl = $parse_url['path'];
                     }
               
                $_SESSION['downloadUrl']=url($seriesUrl);
                }
                    
                }else{
                  if(Session::has('fullredirect_redirecturl') || Session::has('redirecturl')){
                 $_SESSION['downloadUrl']=(Session::get('fullredirect_redirecturl')!=null)?Session::get('fullredirect_redirecturl'):Session::get('fullredirect_redirecturl');
                }  
                }
            }
             
              
        }


        $client->debug = false;
        $client->debug_http = true;
        $client->redirect_uri = $callbackURL;
         $client->user_cancelled_login = $callbackURL;
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

if (!isset($_GET['code'])) {
 $_SESSION['oauth2state_Linkedin'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
 $client->ProcessV2();
 // Check given state against previously stored one to mitigate CSRF attack
} elseif(empty($_GET['state']) || (isset($_SESSION['oauth2state_Linkedin']) && $_GET['state'] !== $_SESSION['oauth2state_Linkedin'])) { 
if(isset($_SESSION['oauth2state_Linkedin']))
unset($_SESSION['oauth2state_Linkedin']);
 $client->error = 'Invalid state Please try Again'; 
$success = false;
} else {

$token = $client->getAccessToken_(['code' => $_GET['code']]);  
if (strlen($client->authorization_error)) {
$client->error = $client->authorization_error;
$success = false;
}elseif(strlen($client->access_token)) { 
#?projection=(birthDate,countryCode,id,firstName(localized),lastName(localized),educations,countryCode,companyName,profilePicture(displayImage~:playableStreams))  
$user_Data= $client->CallLinkedinApiData(
'https://api.linkedin.com/v2/me',
#   'https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))',
'GET',
array('format'=>'json' ));
$user_Email= $client->CallLinkedinApiData(
'https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))',
'GET',
array('format'=>'json' )); 
if (strlen($client->authorization_error)) {
$client->error = $client->authorization_error;
$success = false;
}else{
    $user=array_merge($user_Data,$user_Email);

$user=array('firstName' => Arr::get($user, 'firstName.localized.en_US'),
'lastName' => Arr::get($user, 'lastName.localized.en_US'),
'localizedFirstName' => Arr::get($user, 'localizedFirstName'),
'localizedLastName' => Arr::get($user, 'localizedLastName'),
'emailAddress' => Arr::get($user, 'elements.0.handle~.emailAddress'),
'id' => $user['id'],'country_code' => 'IN'
);
$user = (object) $user;
$success = $client->Finalize($user);
}


}

if(isset($_SESSION['oauth2state_Linkedin']))
unset($_SESSION['oauth2state_Linkedin']);   
}
        
              
        }   

       if ($client->exit)exit;    
        if ($success && !empty($user)) { 
            $userModel = new User();
            $AlaneeCommon = new CommonClass();
            $password = $AlaneeCommon->createPassword(8);
            $user_type = substr($client->redirect_uri, strrpos($client->redirect_uri, '/') + 1);
            $user_type_id=($user_type=='premium')?2:1;
            if($user_type=='' && !$userModel->checkUserExistsByEmail($user->emailAddress))
                {
                     $user_type='premium';
                     $user_type_id=($user_type=='premium')?2:1;
                }

            if($user_type_id==2  && !$userModel->checkUserExistsByEmail($user->emailAddress)){ //check user_type start
                $country = $userModel->getCountryId($user->country_code);
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
                Session::put('temp_user',$temp_userDetails);
                Session::put('linkedinData',$user);
            
                return redirect('user/dopayment/');
                die;
            } //check user_type end

            if($user_type_id!=''){

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
                        'industry' => (isset($user->industry) && $user->industry!=null)?$user->industry:'',
                        'company_name' => (isset($user->positions->values[0]->company->name) && $user->positions->values[0]->company->name!=null)?$user->positions->values[0]->company->name:'' ,
                        'company_industry' => (isset($user->positions->values[0]->company->industry) && $user->positions->values[0]->company->industry!=null)?$user->positions->values[0]->company->industry:'' ,
                       // 'want_to_email_alert' => $defultAlertValue
                        );

                    $userDetails = $userModel->getUserDetailsById($userData['id']);
                    $userDetails['password'] = '********';
                    $userDetails['loginViaLinkedIn'] = 'yes';
                    #Session::put('user',$userDetails);
                   
                    if($userData['res'] == 'insert') {
                        $insertlinkedinData = $userModel->linkedinDataInsert($linkedinData);
                        $mailGun = new MailGunAPI();

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
                        //setcookie("JMA_USER", $cookie_value, time()+3600 * 24 * 365, '/');
                        Cookie::queue(Cookie::forever('JMA_USER', $cookie_value));
                        # autologin setcookie end
                        $userDetails['password'] = '********';
                      
                        Session::put('user',$userDetails);

                        $corp='';
                        if($userDetails['user_upgrade_status']=='RC'){
                            $corp.=" ( You'r Requested Corporate Account )";
                        }


                        $mail_data = array(
                            'name' => ucfirst($userDetails['fname']).' '.ucfirst($userDetails['lname']),
                            'title' => (($userDetails['user_type'] == 'free') ? 'Corporate or Free account' : 'Standard'),
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
                        $n_user_type=($user_type!="premium")?"Free":"Standard";
                        $notify_body_msg = "A new ".ucfirst($n_user_type)." user signed up with us (Using LinkedIn Login).<p>Name : ".ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."<br><br>Email : ".$userDetails['email']."</p><br>";


                        if ($user_type=='corporate'){
                            $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
                        }
                        
                        $notify_body_msg.="<br>Thanks,<br>JMA Team.<br>";
                        $mail->Body =$notify_body_msg;

                        $mail->AddAddress($notification_to);
                        $mail->Send();
                        $render = true;

                        $data['result']['user_details'] = $userDetails;
                    /*if($split[1] != ''){
                        session_start();
                        $_SESSION['chartIndex'] = $split[1];
                        //$_SESSION['datatype'] = $chartCodes[1];
                    }*/

if(Session::has('linkedinData') && Session::get('linkedinData')!=null){
                Session::forget('linkedinData');
              }
 if(isset($_SESSION['downloadUrl']) &&  $_SESSION['downloadUrl']!=''){
                              $redirect = ($_SESSION['downloadUrl']);
                              if(isset($_SESSION['downloadUrl'])){
                             unset($_SESSION['downloadUrl']);
                             Session::forget('redirecturl');
                         Session::forget('fullredirect_redirecturl');
                              }
                              return redirect()->away($redirect);
                              exit();
                              }else{
                              return redirect('/');
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
                        Session::put('user',$userDetails);
                     
                            /*if($split[1] != ''){
                                session_start();
                                $_SESSION['chartIndex'] = $split[1];
                                //$_SESSION['datatype'] = $chartCodes[1];
                            }*/

                            if(Session::has('linkedinData') && Session::get('linkedinData')!=null){
                Session::forget('linkedinData');
              }
                          if(isset($_SESSION['downloadUrl']) &&  $_SESSION['downloadUrl']!=''){
                          $redirect = ($_SESSION['downloadUrl']);
                          if(isset($_SESSION['downloadUrl'])){
                         unset($_SESSION['downloadUrl']);
                         Session::forget('redirecturl');
                         Session::forget('fullredirect_redirecturl');
                         
                          }
                                   
                              return redirect()->away($redirect); 

                              exit();
                              }else{
                                     if(isset($_SESSION['downloadUrl'])){
                             unset($_SESSION['downloadUrl']);
                             Session::forget('redirecturl');
                             Session::forget('fullredirect_redirecturl');
                             
                              }
                              return redirect('/');
                              }
                          
                        } else{
                            if(Session::has('linkedinData') && Session::get('linkedinData')!=null){
                            Session::forget('linkedinData');
                            }
                            if(isset($_SESSION['OAUTH_ACCESS_TOKEN'])){
                                  unset($_SESSION['OAUTH_ACCESS_TOKEN']);
                            }
                            if(Session::has('OAUTH_ACCESS_TOKEN')){
                              Session::forget('OAUTH_ACCESS_TOKEN');
                              
                            }
                            $this->setFlashMessage($user_row);
                           return redirect('user/login');
                        }
                    }
                }
            }//check user_type end

        } else {
              Session::put('err_msg',$client->error);
            $this->setFlashMessage($client->error);
            return redirect('user/login');
          
        }
        //$this->redirect('/');
    }



    public function myaccount($params=null,$firstParam=null) {
      
        $this->handleUnpaidUser();
 $data['pageTitle']= "Japan Macro Advisors | Myaccount";
                    $data['meta']['description']='Japan macro advisors - Myaccount';
                    $data['meta']['keywords']='User Myaccount';
                    $data['renderResultSet']=$data;
        $user = new User();
         $tabname = ($params!='') ? $params : 'profile';
        $firstParam =($firstParam!='') ? $firstParam : 'profile';
        if($tabname == 'subscription' && isset($_POST['request_info']) && isset($_POST['signup_ts']) && Session::get('signup_ts') == $_POST['signup_ts']){

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
                'id' => Session::get('user.id'),
                'fname' => Session::get('user.fname'),
                'lname' => Session::get('user.lname'),
                'country_id' => Session::get('user.country_id'),
                'phone' => Session::get('user.phone'),
                'user_position_id' => Session::get('user.user_position_id'),
                'user_industry_id' => Session::get('user.user_industry_id'),
                'user_upgrade_status' => $user_upgrade_status
                );
            Session::forget('signup_ts');
          
            if($user->updateMyProfile($userDetails)) {
                $userDetails = $user->getUserDetailsById(Session::get('user.id'));
                $userDetails['password'] = '********';
                Session::put('user',$userDetails);
              
                
                // Send notification mail
                if($user_upgrade_status == 'RP')
                {
                    $account = 'Standard';
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
                 //$mail->IsMail();
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
           
            if($this->isUserLoggedIn() == true) {

                $country = new Country();
                $data['result']['userdetails'] = $user->getUserDetailsById(Session::get('user.id'));
                $data['result']['country_list'] = $country->getCountryDatabaseAsArray();
                $data['result']['country_list1'] = $country->getCountryDatabase();
                $data['result']['emailAlert_category'] = $user->emailAlertCategory();
              //  echo "<pre>";print_r($data['result']['emailAlert_category']);
                $data['result']['emailAlert_OnlyIndicator'] = $user->emailAlertCategoryOnlyIndicator();
                $data['result']['emailAlert_choiceofUsers'] = $user->emailAlertChoiceofUsers(Session::get('user.email'));

                $data['result']['tabname'] = $tabname;
                $data['result']['firstParam'] = $firstParam;
                $data['result']['defaultEmailAlert'] = $user->defaultEmailAlert();
                $data['result']['defaultEmailAlertOnlyIndicator'] = $user->defaultEmailAlertOnlyIndicators();    
                $payment_history = $user->get_payment_history(Session::get('user.id'));
                $data['result']['payment_history'] = $payment_history;
            
                if(Session::get('user.user_type_id')!=1){
                   
                 $subscription = new SubscriptionClass();
        $data['result']['subscription_plans'] = $subscription->subscription_plans(Session::get('user.stripe_customer_id'));   
                }
                
            } else {
                $tabname = ($params!='') ? $params : 'profile'; 
                if($tabname == "email-alert")
                {
                    return redirect('user/login?r=user/myaccount/email-alert');
                }
                else
                {
                    return redirect('user/login?r=user/myaccount/subscription');
                }
                
            }
            
        }catch (Exception $ex) {
            
        }
       
        return view('user.myaccount',$data);
    }


       public function editprofile() {
            $this->handleUnpaidUser();
            if($this->isUserLoggedIn() != true) {
               return redirect('user/login');
            } else {
                if(count($_POST)>0) {

                    $signup_ts = $_POST['signup_ts'];

                    if(!empty($signup_ts) && Session::get('signup_ts')== $signup_ts) {
                        $user_id = $_POST['user_id'];
                    //$title = $_POST['title'];
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $country_id = $_POST['country_id'];
                        $phone = $_POST['phone'];
                        $country_code = $_POST['isd_code'];
						$company_name = $_POST['company_name'];
						$address = $_POST['address'];
						$zip_code = $_POST['zipCode'];
						$state = $_POST['state'];
						$city = $_POST['city'];
						
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
						$userAddressDetails = array(
							'user_id' => $user_id,
                            'company' => trim(addslashes($company_name)),
                            'address' => trim(addslashes($address)),
                            'zip_code' => trim(addslashes($zip_code)),
                            'state' => trim(addslashes($state)),
                            'city' => trim(addslashes($city))
						);	
                        Session::forget('signup_ts');
          
                        if($user->updateProfile($userDetails)) {
                            $this->setFlashMessage("Your profile has been updated.");
                        } else {
							 $add = $user->updateUserAddress($userAddressDetails);
                             $this->setFlashMessage("Your profile has been updated.");
                           # $this->setFlashMessage("<font color='#ff0000'>Error in updating your prifile. Please try again.</font>");
                        }
						 $userprofile = $user->getUserDetailsById($user_id);
                         $userprofile['password'] = '********';
                         Session::put('user',$userprofile);
                        return redirect('user/myaccount');
                    } else{
                        return redirect('user/myaccount');
                    }

                } else {
                    return redirect('/user/login');
                }
            }
        }


    /**
     * In products page After login user click on REQUEST INFO button
     * @param Int $u_id : user id
     */
    public function user_request_info(){

        
        if(Session::has('user')){
            $flash_arr = array('user_id'=>Session::get('user.id'));
            $this->setFlashMessage($flash_arr);
            $fl_msg = $this->getFlashMessage();
            if(isset($fl_msg['user_id'])){
                $u_id = $fl_msg['user_id'];
                $user = new User();
              
              
                $data['pageTitle']= "Japan Macro Advisors | Myaccount";
                    $data['meta']['description']='Japan macro advisors - Myaccount';
                    $data['meta']['keywords']='User Myaccount';
                    $data['renderResultSet']=$data;
                $user_details = $user->getUserDetailsById($u_id);


                if($user_details['user_upgrade_status']=='RP')
                {
                    $account = 'Standard';
                }elseif($user_details['user_upgrade_status']=='RC')
                {
                    $account = 'corporate';
                }elseif($user_details['user_upgrade_status']=='RB')
                {
                    $account = 'both premium & corporate';
                }else{
                    $account = 'Corporate';
                }
                $user_type=($user_details['user_type']=='individual')?"Standard":ucfirst($user_details['user_type']);
                $update_Rc = array(
                    'id' => $u_id,
                    'user_upgrade_status' => 'RC'
                    );
                $user->update_request_corporate($update_Rc);


                $mail = new PHPMailer();
                $mail->IsSMTP();
                 //$mail->IsMail();
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
                $data['result']['user_details'] = $user_details;


               return view('user.request_info_success',$data);
            }else {
                return redirect('user/signup');
            }

        }else {
            return redirect('user/signup');
        }   
    }



public function user_pay_downgrade(){
        

        if(Session::has('user')){
            $media = new Media();
           
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);
            $user = new User();
            $id = Session::get('user.id');
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
            Session::put('user',$userDetails);
           
            $data['result']['userdetails'] = Session::get('user');
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
    Session::forget('user_type_upgrade');
    Session::forget('Upgarde');
       if(Session::has('temp_user') && Session::get('temp_user')!=null){
                Session::forget('temp_user');
              }
               if(Session::has('linkedinData') && Session::get('linkedinData')!=null){
                Session::forget('linkedinData');
              }
        $email = Session::get('user.email');
     
        $getUserDetails = $user->getUserDetailsByEmail($email);
        $id = Session::get('user.id');
        if($getUserDetails[0]['user_type_id'] == 1 && $getUserDetails[0]['user_status_id'] == 4){
            if($getUserDetails[0]['stripe_subscription_id'] != '' && $getUserDetails[0]['current_payment_method']!='PayPal'){
                $subscription = new SubscriptionClass();
                $upgradeSubscriptionProcess = $subscription->upgradeSubscription($getUserDetails[0]['stripe_customer_id']);


                if($upgradeSubscriptionProcess){
                    $update=$user->setThisUserToPremium($id);
                    //send success mail
                    $userDetails = $user->getUserDetailsById($id);
                    $userDetails['password'] = '********';
                    Session::put('user',$userDetails);
                    $this->payment_success_send_mail(Session::get('user.id'));
                    $this->setFlashMessage('Upgarde'); 
                    return redirect('user/payment_success');
                }else{
                    $userDetails = $user->getUserDetailsById($id);
                    $userDetails['password'] = '********';
                    Session::put('user',$userDetails);
                    $this->setFlashMessage('Upgrade Failed');
                    return redirect('user/myaccount');
                }
            }else if($getUserDetails[0]['recurrent_profile_id'] != '' && $getUserDetails[0]['current_payment_method']=='PayPal'){

                $paypal = new PaypalClass();
                 if($paypal->reactivateRecurrentProfile($getUserDetails[0]['recurrent_profile_id']) == true) {
                        $user->setThisUserToPremium($id);
                           $userDetails = $user->getUserDetailsById($id);
                        $userDetails['password'] = '********';
                    Session::put('user',$userDetails);
                    $this->payment_success_send_mail(Session::get('user.id'));
                    $this->setFlashMessage('Upgarde'); 
                    return redirect('user/payment_success');
                    }else{
                    $userDetails = $user->getUserDetailsById($id);
                    $userDetails['password'] = '********';
                    Session::put('user',$userDetails);
                    $this->setFlashMessage('Upgrade Failed');
                    return redirect('user/myaccount');
                    }
            }else{
                $id = Session::get('user.id');
                  $userDetails = $user->getUserDetailsById($id);
                    $userDetails['password'] = '********';
                    Session::put('user',$userDetails);
                    Session::put('user_type_upgrade',1);
                     return redirect('/user/dopayment');
            }
        }else{
            return redirect('user/myaccount');
        }
    }



  public function changepassword() {
                    $this->handleUnpaidUser();
   
                   
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
                            $userDetails = $user->getUserDetailsByUserNameAndPassword(Session::get('user.email'),$old_password);
                            if(empty($userDetails)) {
                                $return_array['error']='<font color="#ff0000">Old password is not matching.</font>';
                                echo json_encode($return_array);
                            }else{
                                if($user->updateProfilePassword($user_id,$new_password)) {
                                    $userDetails_updt = $user->getUserDetailsById($user_id);
                                    $pass_fMail = $userDetails_updt['password'];
                                    $userDetails_updt['password'] = '********';
                                    Session::put('user',$userDetails_updt);
                                   
                                    $replace_mail_data=array(
                                    'name' => Session::get('user.fname').' '.Session::get('user.lname'),
                                    'email' => Session::get('user.email'),
                                    'password' => $pass_fMail);
                                    $Mailtemplate = new Mailtemplate();
                                    $template = $Mailtemplate->getTemplateParsed('change_password', $replace_mail_data);

                                    $mail = new PHPMailer();
                                    $mail->IsSMTP();  //$mail->IsMail();
                                    $mail->IsHTML(true);  
                                    $mail->AddAddress(Session::get('user.email'),Session::get('user.fname').' '.Session::get('user.lname'));
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
               return redirect('/user/login');
            }
        }



        //Payment



    
    public function dopayment() {

        if(!Session::has('temp_user') && !Session::has('user')){
            return redirect('user/login?r=user/dopayment');
        }else {

              if(Session::has('temp_user') && Session::get('temp_user')!=null){
                Session::forget('user_type_upgrade');
              }
            $media = new Media();
            $country = new Country();
            $user = new User ();
           
          $renderResultSet['pageTitle']= "Welcome to Japan macro advisors - Do payment";
$renderResultSet['meta']['description']="Japan macro advisors - Do payment";
$renderResultSet['meta']['keywords']='Do payment, subscribe';
$data['renderResultSet']=$renderResultSet;

            $data['result']['country_list'] = $country->getCountryDatabase();
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);
            $data['result']['status'] = 1;
      $data['result']['stripe_publish_key'] = Config::read('stripe.'.Config::read('environment').'.publish_Key');

            if (isset($_POST['stripeToken'])) {
                $payment = new SubscriptionClass();
                $paymentGateway = 'stripe';
                $stripeToken = $_POST['stripeToken'];
                $email = (Session::has('temp_user.email') && Session::get('temp_user.email')!=null)?Session::get('temp_user.email'):Session::get('user.email');
                $paymentProcess = $payment->createSubscription($paymentGateway,$stripeToken,$email);
              
                if(is_array($paymentProcess) && isset($paymentProcess['error'])){

                     if(Session::has('user_type_upgrade') && Session::get('user_type_upgrade')==1){
                    $this->payment_status_mail(Session::get('user.id'),'error'); 
                         }
                    $data['result']['status'] = 4444;
                    $data['result']['message'] = $paymentProcess['error']['message'];
                }else{
                    //fresh signup User
                    if(Session::has('temp_user') && Session::get('temp_user')!=null){
                        $linkedinUserData = (Session::has('linkedinData'))?Session::get('linkedinData'):'';

                        $userDetails=(Session::has('temp_user'))?Session::get('temp_user'):'';
               
                            #echo "<pre>";print_r($_SESSION);die;
                        $checkUserExists = $user->checkUserExistsByEmail(Session::get('temp_user.email'));
                        if($checkUserExists){
                            // Exisiting user by linkedin Start
                            //Except linkedin Signup existing user ,we are restricting signup page itself
                            if(Session::has('linkedinData') && !empty(Session::get('linkedinData'))){

                            $u_details = $user->updateLinkedinData($linkedinUserData);
                            $linkedinData = array(
                                'user_id' => $u_details['id'],
                                'oauth_uid' => $linkedinUserData->id,
                                  'industry' => (isset($linkedinUserData->industry) && $linkedinUserData->industry!=null)?$linkedinUserData->industry:'',
               'company_name' => (isset($linkedinUserData->positions->values[0]->company->name) && $linkedinUserData->positions->values[0]->company->name!=null)?$linkedinUserData->positions->values[0]->company->name:'' ,
                        'company_industry' => (isset($linkedinUserData->positions->values[0]->company->industry) && $linkedinUserData->positions->values[0]->company->industry!=null)?$linkedinUserData->positions->values[0]->company->industry:'' 
                                );
                            $checklinkedinData = $user->linkedinDataExists($u_details['id']);
                            if($checklinkedinData == 0){
                                $insertlinkedinData = $user->linkedinDataInsert($linkedinData);
                            }else{
                                $updatelinkedinData = $user->linkedinDataUpdate($linkedinData);     
                            }
                        }

                        // Exisiting user by linkedin End
                        }else{   

                            $u_details = $user->addUserRegistration($userDetails);
                            $mailGun = new MailGunAPI();
                     $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
                            if($evenPath == "production")
                            {

                                $email_=(Session::has('temp_user.email'))?Session::get('temp_user.email'):'';
                                $fname_=(Session::has('temp_user.fname'))?Session::get('temp_user.fname'):'';
                                $mailGun->addNewUserMailGunListingAddress($email_,$fname_);
                            }
                        //Fresh user linkedin data insert start
                        if(Session::has('linkedinData') && !empty(Session::get('linkedinData'))){
                       

                        $linkedinData = array(
                        'user_id' => $u_details['id'],
                        'oauth_uid' => $linkedinUserData->id,
                        'industry' => (isset($linkedinUserData->industry) && $linkedinUserData->industry!=null)?$linkedinUserData->industry:'',
               'company_name' => (isset($linkedinUserData->positions->values[0]->company->name) && $linkedinUserData->positions->values[0]->company->name!=null)?$linkedinUserData->positions->values[0]->company->name:'' ,
                        'company_industry' => (isset($linkedinUserData->positions->values[0]->company->industry) && $linkedinUserData->positions->values[0]->company->industry!=null)?$linkedinUserData->positions->values[0]->company->industry:'' 
                        );


                        $insertlinkedinData = $user->linkedinDataInsert($linkedinData); 

                        } 
                        //Fresh user linkedin data insert start

                        }

                        $update=$user->setThisUserStatus($u_details['id'],'trial');
                     
                        if(Session::has('OAUTH_ACCESS_TOKEN') || isset($_SESSION['OAUTH_ACCESS_TOKEN'])){

                            $this->send_individual_linkedin_user_mail(base64_encode($u_details['id']));
                            Session::forget('OAUTH_ACCESS_TOKEN'); unset($_SESSION['OAUTH_ACCESS_TOKEN']);
                       
                        }else{
                            $this->send_individual_user_mail(base64_encode($u_details['id']));

                        }
                        if(Session::has('temp_user') && Session::get('temp_user')!=null){
                             Session::forget('temp_user');
                              Session::forget('linkedinData');
                         
                        }

                    }else{

                         if(Session::has('user_type_upgrade') && Session::get('user_type_upgrade')==1){
                     
                            $this->user_upgrade_mail(Session::get('user.id'));
                            $user->setThisUserStatus(Session::get('user.id'),'trial');
                            $user->setThisUserToPremium(Session::get('user.id'));
                        }
                    }  // From Request User End
                    $id=(isset($u_details['id']) && $u_details['id']!=null)?$u_details['id']:Session::get('user.id');

                   
                 
                
                    if(is_array($paymentProcess) && $paymentProcess!=null){
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
                        
                        $createUserStripeLog = $user->addlog($id, $transaction_id, $order_id, $action, $data);
                    }
                    $user_details = $user->getUserDetailsById($id);
                    Session::put('user',$user_details);
                  
                    $this->payment_status_mail($id,'success');

                    return redirect('user/payment_success');
                }
            }

           return view('user.dopayment',$data);
        }
    }


    private function user_upgrade_mail($id){
        $user = new User();
        $user_details = $user->getUserDetailsById($id);
        $user_type=($user_details['user_type']=='individual')?"Standard":ucfirst($user_details['user_type']);
        $mail = new PHPMailer();
        $mail->IsSMTP();
          //$mail->IsMail();
        $mail->IsHTML(true);  
        $notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
        $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
        $mail->clearAddresses();
        $mail->clearAttachments();
        $mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
        $mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
        $mail->Subject = $notification_subject;
        $mail->Body = "User with below details has upgraded to Standard account.<p>Name : ".$user_details['fname']." ".$user_details['lname']."<br><br>Email : ".$user_details['email']."<br><br>Subscription Type: ".$user_type."</p><br><br>
        Thanks,<br>
        JMA Team.<br>";
        $mail->AddAddress($notification_to);
        $mail->Send();
    }


    private function send_individual_user_mail($params){

    $user_id = base64_decode($params);
    $user = new User();
    if($user->validateUserEmail($user_id)) {
        $user_details = $user->getUserDetailsById($user_id);

        $mail = new PHPMailer();
        $mail->IsSMTP();
          //$mail->IsMail();
        $mail->IsHTML(true);  
                    $mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                    $mail->WordWrap = 50;
                    $Mailtemplate = new Mailtemplate();
                    $mail_data = array(
                        'name' => ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']),
                        'title' => (($user_details['user_type'] == 'free') ? 'Free' : 'Standard account'),
                        'email' => $user_details['email'],
                        'password' => $user_details['password'],
                        'accountType' => 'Standard  Account'
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
                        
                        $notify_body_msg= "A new Standard user signed up with us on.<p>Name : ".ucfirst($user_details['fname'])." ".ucfirst($user_details['lname'])."<br><br>Email : ".$user_details['email']."<br><br>Phone : ".$user_details['country_id'].$user_details['phone']."";
                        
                        $mail->Body =$notify_body_msg;
                        $mail->AddAddress($notification_to);
                        $mail->Send();
                    }catch (Exception $e) {
                        $data['result']['status'] = 9999;
                        $data['result']['message'] = 'Error...! '.$e->getMessage();
                        $error == true;
                    }

                } 
            }


            private function send_individual_linkedin_user_mail($params){

                $user_id = base64_decode($params);
                $user = new User();
                #if($user->validateUserEmail($user_id)) {
                    $userDetails = $user->getUserDetailsById($user_id);
                    
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    //$mail->IsMail();
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
                        'title' => (($userDetails['user_type'] == 'free') ? 'Corporate or Free account' : 'Standard'),
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
                        $n_user_type=($userDetails['user_type']!="individual")?"Free":"Standard";
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
              #  } 
            }

    private function payment_status_mail($user_id,$status){
       
        $appPath = Config::read ( 'appication_path' ) != '' ?  trim ( Config::read ( 'appication_path' ), '/' ) : '';
        $site_link = 'http://' . $_SERVER ['HTTP_HOST'] . $appPath;
        $user = new User ();
        
       
        $error_mail_msg = '';
       
        $user_details = $user->getUserDetailsById($user_id);
        Session::put('user',$user_details);

         $Mailtemplate = new Mailtemplate();
        $CONF_CURRENCY = Config::read('subscription.currency');
        $CONF_AMOUNT = Config::read('subscription.amount');
        if ($status == 'success') {
        $mail_data = array (
            'name' => $user_details['fname'] . ' ' . $user_details['lname'],
            'email' => $user_details['email'],
           );
       
        $template = $Mailtemplate->getTemplateParsed('payment_success', $mail_data);
          
        } else {
            $error_mail_msg .= "Dear <b>" . $user_details ['fname'] . ' ' . $user_details ['lname'] . ",</b><br><br>We regret to inform you that your payment for monthly Standard subscription with email address <b><i>" . $user_details ['email'] . "</i></b> was unsuccessful. You’re monthly subscription fee is due.";
            $error_mail_msg .= '<p>Amount: '.$CONF_CURRENCY.' '.$CONF_AMOUNT.'.</p>';
            $error_mail_msg .= '<p>Your Standard subscription is inactive. We request you to check with your credit card you paid with. In order to continue with our service, please verify you’re billing information and resend payment.</p>';
            $error_mail_msg .= '<p>You can access your payment details page <a target="_blank" href="' . $site_link . '/user/myaccount">Payment Details</a></p>';
          
            $message = $error_mail_msg;

             $mail_data = array (
            'msg' => $message);
        $template = $Mailtemplate->getTemplateParsed( 'payment_error', $mail_data );
        }
        
        $mail = new PHPMailer ();
        $mail->IsSMTP ();
        //$mail->IsMail();
        $mail->IsHTML ( true );
        $mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
        $mail->WordWrap = 50;
        $mail->Subject = $template['subject'];
        $mail->Body = $template['message'];
        $mail->AddAddress ($user_details['email'], $user_details['fname'] . ' ' . $user_details['lname'] );
        $mail->SetFrom ( 'info@japanmacroadvisors.com', 'japanmacroadvisors.com' );
        $mail->AddReplyTo ( 'info@japanmacroadvisors.com', 'japanmacroadvisors.com' );
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mail->Send();
    }
    public function payment_success(){

        $media = new Media();
        $country = new Country();
        $user = new User();
        $id =Session::get('user.id');
        $user_details = $user->getUserDetailsById($id);
        Session::put('user',$user_details);
       
          $data['pageTitle']= "Welcome to Japan macro advisors -  Payment Success";
         $data['meta']['description']="Japan macro advisors -  Payment Success";
        $data['meta']['keywords']='Payment Success, subscribe';
        $data['renderResultSet']=$data;
        
        $data['result']['country_list'] = $country->getCountryDatabase();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
       return view('user.payment_success',$data);
    }


    public function cancelSubscription(){   

        if(Session::get('user.user_type_id')==2){

            $data['pageTitle']= "Welcome to Japan macro advisors - Cancel Subscription";
         $data['meta']['description']="Japan macro advisors - Cancel Subscription";
        $data['meta']['keywords']='Payment Success, subscribe';
        $data['renderResultSet']=$data;

            $subscription = new SubscriptionClass();
            $user = new User();
            $media = new Media();
            $id = Session::get('user.id');
            $user_details = $user->getUserDetailsById($id);
            Session::put('user',$user_details);
       
            if(isset($_REQUEST['submit']) && $_REQUEST['submit']=='free'){
                
               $recurrent_profile_id = Session::get('user.recurrent_profile_id');
                if($recurrent_profile_id != '' && $user_details['current_payment_method']=='PayPal') {
                    $paypal = new PaypalClass();
                    if($paypal->suspendRecurrentProfile($recurrent_profile_id) == true) {
                    $user->setThisUserStatus($id,'active');
                   $user->setThisUserToFree($id);
                       
                        $this->setFlashMessage("Your subscription is cancelled successfully");
                        $user_details = $user->getUserDetailsById($id);
                        Session::put('user',$user_details);
                        $this->redirect('/user/myaccount');
                    }else{
                       $cancelSubscriptionProcess="Error..!  Couldn't able to cancel your subscription status.";
                       $data['result']['cancelSubscriptionError']= $cancelSubscriptionProcess;
                    }
                }else {
                    $cancelSubscriptionProcess = $subscription->cancelSubscription($id);
                    if($cancelSubscriptionProcess=='Subscription cancelled successfully'){
                    $this->downgrade_success_send_mail($id);
                    $this->setFlashMessage($cancelSubscriptionProcess);
                    $user_details = $user->getUserDetailsById($id);
                    Session::put('user',$user_details);
                    return redirect('user/myaccount');
                    }else{
                       $cancelSubscriptionProcess="Error..!  Couldn't able to cancel your subscription status.";
                       $data['result']['cancelSubscriptionError']= $cancelSubscriptionProcess;
                    }
                }

                
            }
          
            $data['result']['userdetails']= $user_details;
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);
             return view('user/cancelSubscription',$data);     
        }
        return redirect('user/myaccount');
    }
    
    public function upgradeSubscription(){

        $email =   Session::get('user.email');
        $user = new User();
        $getUserDetails = $user->getUserDetailsByEmail($email);
        if($getUserDetails[0]['stripe_subscription_id'] != null && $getUserDetails[0]['user_type_id'] == 1 && $getUserDetails[0]['user_status_id'] == 4){
            $subscription = new Subscription();
            $upgradeSubscriptionProcess = $subscription->upgradeSubscription($getUserDetails[0]['stripe_customer_id']);
            if($upgradeSubscriptionProcess->id){
                //send success mail
                $this->payment_success_send_mail(Session::get('user.id'));
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
          //$mail->IsMail();
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
                     //$mail->IsMail();
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


        public function mailAlertUpdate()
        {
           
            $user = new User();
            if(!empty($_POST['alert_value']))
            {
                $alertStatus = $user->updateEmailAlert(Session::get('user.id'),$_POST['alert_value'],$_POST['is_thematic']);
                return redirect('user/myaccount/update/'.$_POST['alert_type']);
            }
            elseif($_POST['alert_value'] == "" &&  $_POST['is_thematic'] == "Y" )
            {
                
                $alertStatus = $user->updateEmailAlert(Session::get('user.id'),$_POST['alert_value'],$_POST['is_thematic']);
                return redirect('user/myaccount/update/'.$_POST['alert_type']);
            }
            elseif($_POST['alert_value'] == 0)
            {
                $alertStatus = $user->updateEmailAlert(Session::get('user.id'),$_POST['alert_value'],$_POST['is_thematic']);
              return redirect('user/myaccount/update/'.$_POST['alert_type']);
            }


        }



        public function unsubscribe_user($params){
        
        $firstParam = isset($params) ? base64_decode($params) : ''; 
        $this->handleUnpaidUser();
         $data['pageTitle']= "Welcome to Japan macro advisors - Unsubscribe Email Alerts";
         $data['meta']['description']="Japan macro advisors - Unsubscribe Email Alerts";
        $data['meta']['keywords']='Sign up, register, subscribe,Unsubscribe Email Alerts';
        $data['renderResultSet']=$data;
      
        $user = new User();
        if(!empty($user->getUserDetailsByEmail($firstParam)))
        {
            $data['result']['emailAlert_category'] = $user->emailAlertCategory();
            $data['result']['emailAlert_choiceofUsers'] = $user->emailAlertChoiceofUsers($firstParam);
            $data['result']['userdetails'] = $user->getUserDetailsByEmail($firstParam);
            $data['result']['firstParam'] = $firstParam;
            $data['result']['defaultEmailAlert'] = $user->defaultEmailAlert(); 
            return view('user.unsubscribe_user',$data);    
        }
        else
        {
            new ErrorController(404);
        }
        
        
    }
    
    public function mailAlertUpdateWithoutLogin()
    {
        
        

        $user = new User();
        if(!empty($_POST['alert_value']))
        {
            $alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'],$_POST['alert_value'],$_POST['is_thematic']);
            return redirect('user/unsubscribe_update_sccess/');
        }
        elseif($_POST['alert_value'] == "" &&  $_POST['is_thematic'] == "Y" )
        {
            
            $alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'],$_POST['alert_value'],$_POST['is_thematic']);
           return redirect('user/unsubscribe_update_sccess/');
        }
        elseif($_POST['alert_value'] == 0)
        {
            $alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'],$_POST['alert_value'],$_POST['is_thematic']);
            return redirect('user/unsubscribe_update_sccess/');
        }


    }
    
    public function unsubscribe_user_encode($params)
    {
        $firstParam = isset($params) ? $params : ''; 
        return redirect('user/unsubscribe_user/'.base64_encode($firstParam));
    }
    
    
    public function unsubscribe_update_sccess(){
        
        $this->handleUnpaidUser();
       $data['pageTitle']= "Welcome to Japan macro advisors - Unsubscribe Email Alerts";
         $data['meta']['description']="Japan macro advisors - Unsubscribe Email Alerts";
        $data['meta']['keywords']='Sign up, register, subscribe,Unsubscribe Email Alerts';
        $data['renderResultSet']=$data;
       
        return view('user.unsubscribe_update_sccess',$data);    
    }




    public function dopayment_paypal() {

            if(!Session::has('temp_user') && !Session::has('user')){
                return redirect('user/login?r=user/dopayment');
            }
            
            $this->clearSessions();

        try{
       
       
        
            $transaction_params = array(

                'currency' =>Config::read('subscription.currency'),
                'date_created' => time(),
                'payment_method' => 'paypal',
                'status' => 'I',
                'payment_transaction_id'=> 'JMA-STD-SUB-'.time()
            );

            $paypal = new PaypalClass();
            $parms = array(
                'PAYMENTREQUEST_0_AMT' => Config::read('subscription.amount'),
                'EMAIL' => (Session::has('temp_user.email') && Session::get('temp_user.email')!=null)?Session::get('temp_user.email'):Session::get('user.email'),
                'PAYMENTREQUEST_0_SHIPTOPHONENUM' => (Session::has('temp_user.phone') && Session::get('temp_user.phone')!=null)?Session::get('temp_user.phone'):Session::get('user.phone')
            );
         
            $order_id = 'JMA-STD-SUB-'.time();
            $transaction_id = $transaction_params['payment_transaction_id'];

            Session::put('payment_transaction',$transaction_params);
            $payment_token = $paypal->createExpressCheckout($order_id, $transaction_id, $parms);

            Session::put('payment_transaction.payment_token',$payment_token);
          
           
            if(!is_array($payment_token) && $payment_token!='') {
                $paypal_url = Config::read('paypal.'.Config::read('environment').'.payment_url').$payment_token;
              
                 return redirect($paypal_url);
               // header("location: ".$paypal_url);
            }else{
                return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $payment_token); 
            }
          
       } catch (Exception $ex) {
      
        $paymentDetailsErr['MESSAGE']="Error..! Please reload page.".$ex->getMessage();
        return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $paymentDetailsErr);
          
        }
    }




public function updatepaymentresponse_success() {
        try{
           
                if(is_array($_REQUEST) && empty($_REQUEST)){
                    return redirect('/');
                }
               
                $order_id = $_REQUEST['oid'];
                $transaction_id = $_REQUEST['tid'];
                $paypal = new PaypalClass();
                $payment_paypal_token = $_REQUEST['token'];
                $user_email = (Session::has('temp_user.email') && Session::get('temp_user.email')!=null)?Session::get('temp_user.email'):Session::get('user.email');
                $user_name = ((Session::has('temp_user.fname') && Session::get('temp_user.fname')!=null)?Session::get('temp_user.fname'):Session::get('user.fname')).' '.((Session::has('temp_user.lname') && Session::get('temp_user.lname')!=null)?Session::get('temp_user.lname'):Session::get('user.lname'));
               
                $payment_transaction_id = Session::get('payment_transaction.payment_transaction_id');
                $paymentDetails = $paypal->getPaymentInfoAndStatus($order_id, $transaction_id, $payment_paypal_token);
                #print_r($paymentDetails);
                if(strtoupper($paymentDetails['ACK'])=='SUCCESS') {
                    $payer_id = $paymentDetails['PAYERID'];
                    $final_amount = (string) Config::read('subscription.amount');
                    $new_expiry_date = strtotime("+1 month", time());
                    $profile_id=$paypal->confirmPaymentAndInitiateSubscription($uid=0, $order_id, $transaction_id, $payment_paypal_token,$payer_id,$final_amount,$user_email, $user_name, $new_expiry_date);
                    if(!is_array($profile_id) && $profile_id!='') {
                        
                        $this->paypal_paid_user_insertion();
                        $user = new User();
                        $user->updatePaypalRecurrentprofileId(Session::get('user.id'),$profile_id);
                        $user->setExpiryOnDate(Session::get('user.id'),$new_expiry_date);
                        Session::put('user.expiry_on',$new_expiry_date);
                        $user->setThisUserUpgradeStatus(Session::get('user.id'),'XP'); //Accepted premium
                         $this->payment_status_mail(Session::get('user.id'),'success');
                        $action = 'Paypal - CreateRecurringPaymentsProfile';
                        $data = ($_SERVER['QUERY_STRING']);
                        $transaction_id='null';
                        $createUserStripeLog = $user->addlog(Session::get('user.id'), $transaction_id, $order_id, $action, $data);
                       
                          $this->clearSessions();
                         return redirect('user/payment_success');
                    }else{
                    if(Session::has('user_type_upgrade') && Session::get('user_type_upgrade')==1){
                    $this->payment_status_mail(Session::get('user.id'),'error'); 
                    }
return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $profile_id);
                   
                    
                }

                   
                }else{
 if(Session::has('user_type_upgrade') && Session::get('user_type_upgrade')==1){
 $this->payment_status_mail(Session::get('user.id'),'error'); 
  }
return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $paymentDetails);
                   
                    
                }
            
            
       }catch (Exception $ex) {
            $paymentDetailsErr['MESSAGE']="Error..! Please reload page.".$ex->getMessage();
       return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $paymentDetailsErr);

          
           
       }
       
    }

    private function clearSessions(){
         if(Session::has('payment_transaction') && !empty(Session::get('payment_transaction'))){
            Session::forget('payment_transaction');
            }
            if(Session::has('temp_user') && Session::get('temp_user')!=null){
            Session::forget('user_type_upgrade');
            }
    }

    public function updatepaymentresponse_cancel() {
      
                $this->clearSessions();
      
            if(is_array($_REQUEST) && empty($_REQUEST)){
                return redirect('/');
            }
           
$data['pageTitle']= "Welcome to Japan macro advisors -  Payment Cancelled";
$data['meta']['description']="Japan macro advisors -  Payment Cancelled";
$data['meta']['keywords']='Payment Cancelled, subscribe';
$data['renderResultSet']=$data;
 return view('user.updatepaymentresponse_cancel',$data);    
    }



    private function paypal_paid_user_insertion(){
         $user = new User ();
         if(Session::has('temp_user') && Session::get('temp_user')!=null)
         {
           $linkedinUserData = (Session::has('linkedinData'))?Session::get('linkedinData'):'';
            $userDetails=(Session::has('temp_user'))?Session::get('temp_user'):'';
               
                          
                        $checkUserExists = $user->checkUserExistsByEmail(Session::get('temp_user.email'));
                        if($checkUserExists){
                            // Exisiting user by linkedin Start
                            //Except linkedin Signup existing user ,we are restricting signup page itself
                            if(Session::has('linkedinData') && !empty(Session::get('linkedinData'))){

                            $u_details = $user->updateLinkedinData($linkedinUserData);
                            $linkedinData = array(
                                'user_id' => $u_details['id'],
                                'oauth_uid' => $linkedinUserData->id,
                                  'industry' => (isset($linkedinUserData->industry) && $linkedinUserData->industry!=null)?$linkedinUserData->industry:'',
               'company_name' => (isset($linkedinUserData->positions->values[0]->company->name) && $linkedinUserData->positions->values[0]->company->name!=null)?$linkedinUserData->positions->values[0]->company->name:'' ,
                        'company_industry' => (isset($linkedinUserData->positions->values[0]->company->industry) && $linkedinUserData->positions->values[0]->company->industry!=null)?$linkedinUserData->positions->values[0]->company->industry:'' 
                                );
                            $checklinkedinData = $user->linkedinDataExists($u_details['id']);
                            if($checklinkedinData == 0){
                                $insertlinkedinData = $user->linkedinDataInsert($linkedinData);
                            }else{
                                $updatelinkedinData = $user->linkedinDataUpdate($linkedinData);     
                            }
                        }

                        // Exisiting user by linkedin End
                        }else{   

                                    $u_details = $user->addUserRegistration($userDetails);
                                    $mailGun = new MailGunAPI();
                             $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
                                    if($evenPath == "production")
                                    {

                                        $email_=(Session::has('temp_user.email'))?Session::get('temp_user.email'):'';
                                        $fname_=(Session::has('temp_user.fname'))?Session::get('temp_user.fname'):'';
                                        $mailGun->addNewUserMailGunListingAddress($email_,$fname_);
                                    }
                                //Fresh user linkedin data insert start
                                if(Session::has('linkedinData') && !empty(Session::get('linkedinData')))
                                {
                               

                                $linkedinData = array(
                                'user_id' => $u_details['id'],
                                'oauth_uid' => $linkedinUserData->id,
                                'industry' => (isset($linkedinUserData->industry) && $linkedinUserData->industry!=null)?$linkedinUserData->industry:'',
                                'company_name' => (isset($linkedinUserData->positions->values[0]->company->name) && $linkedinUserData->positions->values[0]->company->name!=null)?$linkedinUserData->positions->values[0]->company->name:'' ,
                                'company_industry' => (isset($linkedinUserData->positions->values[0]->company->industry) && $linkedinUserData->positions->values[0]->company->industry!=null)?$linkedinUserData->positions->values[0]->company->industry:'' 
                                );


                                $insertlinkedinData = $user->linkedinDataInsert($linkedinData); 

                                } 
                        //Fresh user linkedin data insert start

                           }


                            $update=$user->setThisUserStatus($u_details['id'],'trial');
                     
                        if(Session::has('OAUTH_ACCESS_TOKEN') || isset($_SESSION['OAUTH_ACCESS_TOKEN'])){

                            $this->send_individual_linkedin_user_mail(base64_encode($u_details['id']));
                            Session::forget('OAUTH_ACCESS_TOKEN'); unset($_SESSION['OAUTH_ACCESS_TOKEN']);
                       
                        }else{
                            $this->send_individual_user_mail(base64_encode($u_details['id']));

                        }
                        if(Session::has('temp_user') && Session::get('temp_user')!=null){
                             Session::forget('temp_user');
                              Session::forget('linkedinData');
                         
                        }

                          $id=(isset($u_details['id']) && $u_details['id']!=null)?$u_details['id']:Session::get('user.id');
                          $user_details = $user->getUserDetailsById($id);
                          Session::put('user',$user_details);
         }else{

                         if(Session::has('user_type_upgrade') && Session::get('user_type_upgrade')==1){
                     
                            $this->user_upgrade_mail(Session::get('user.id'));
                            $user->setThisUserStatus(Session::get('user.id'),'trial');
                            $user->setThisUserToPremium(Session::get('user.id'));
                        }
            }  // From Request User End


    }


    

       public function payment_done(){

         $input = @file_get_contents("php://input");
      $event_json = json_encode($input);
     # echo "<pre>";print_r($_REQUEST);
$handler = fopen(storage_path('logs/veera.txt'),'a');
    fwrite($handler,$event_json);
            die;
        echo "<pre>";print_r($_REQUEST);
  return view('user.dopayment11');    
        if(!empty($_REQUEST)){
            $full_details='';
            foreach ($_REQUEST as $key => $value) {
             $full_details.=$key.' => '.$value.", ";
            }
            $log_details=$full_details.PHP_EOL."\r\n";
            $handler = fopen(storage_path('logs/paypal_logs.txt'),'a');
            fwrite($handler,$log_details);
            if($_REQUEST['payment_status']='Pending'){
               echo  $_REQUEST['pending_reason'];die;
            }

            if($_REQUEST['payment_status']='Success'){

            }
        }
       // return view('user.dopayment11');    
    }

}