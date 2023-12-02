<?php
namespace App\Http\Controllers;

if (! defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
}
use App\Model\Postcategory;
use Illuminate\Support\Facades\DB;
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
use App\Libraries\linkedIn\oauth_client_class;
use Exception;
use App\Libraries\reCaptcha\ReCaptcha;
use App\Http\Controllers\ErrorController;
use App\Libraries\subscription_management\SubscriptionClass;
use Cookie;
use Session;
use Illuminate\Support\Arr;
use App\Libraries\payment\PaypalClass;
use Razorpay\Api\Api;

class UserController extends Controller
{
    public function __construct()
    {
        View::share('menu_items', $this->populateLeftMenuLinks());
		View::share ( 'search_keywords', $this->searchBoxKeyWords());
    }
    public function index()
    {
        new ErrorController(404);
    }
    public function signup()
    {


       if (!empty($_POST) && !isset($_POST['register_email']))
        {
          
          if(isset($_POST['pagefrom'])){
            request()->headers->set('referer',url()->previous()."#4");
          }
        
       
            $messages = [
                'fname.required' => 'First name is required',
                'fname.max' => 'First name maximum 255 characters',
                'lname.required' => 'Last name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Email is not in format',
                'email.unique:user_accounts' => 'Email is already existing one',
                'country_id.required' => 'Country is required',
                'phone.required' => 'Phone number is required',
                'phone.numeric' => 'Phone number should be numeric values',
                'agreeButton.required' => 'Accept terms and conditions',
                'g-recaptcha-response.required' => 'Captcha is required'
            ];
            $validator =$this->validate(request(), [
                'fname' => 'required|max:255',
                'lname' => 'required',
                'email' => 'required|email|unique:user_accounts',
                'country_id' => 'required',
               # 'phone' => 'required|numeric',
                'agreeButton' => 'required',

                'g-recaptcha-response' => 'required',

                'country_code' => 'required',
                'user_industry' => 'required',
                'user_position' => 'required'
            ],$messages);

           # return redirect()->back();
            //return Redirect::back()->with('success');
            /*if ($this->validator()->fails()) {
                console.log("sdasd");
                return redirect('products/offerings#4')
                    ->withErrors($this->validator())
                    ->withInput();
            }*/


        }

             

      
        $this->handleUnpaidUser();
        if (isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null) {
            unset($_SESSION['temp_user']);
        }
        if (isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
            return redirect('/');
            //	$this->redirect('helpdesk/post');
        }
        $user = new User();
        $country = new Country();
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }
        $data['pageTitle'] = "Welcome to India macro advisors - Sign up";
        $data['meta']['description']='India macro advisors - Sign up';
        $data['meta']['keywords']='Sign up, register, subscribe';
        $data['renderResultSet']=$data;
        $user_position = $user->getPositionsDatabase();
        $user_industry = $user->getIndustryDatabase();
        $data['result']['user_position'] = $user_position;
        $data['result']['user_industry'] = $user_industry;
        $data['result']['country_list'] = $country->getCountryDatabase();
        $data['result']['signup_error_id'] = '';
        $data['result']['postdata'] = null;
        $request_info = array(
            'premium' => false,
            'corporate' =>false
        );
        if (isset($_GET['pre_info'])) {
            $request_info['premium'] = true;
        }
        if (isset($_GET['co_info'])) {
            $request_info['corporate'] = true;
        }
        $data['result']['request_info'] = $request_info;
        $error = false;
        if (isset($_POST['signup_btn'])) {
        if (env('APP_ENV') != "development") {
        $response1 = file_get_contents("https://www.google.com/recaptcha/api/siteverify?response=".$_POST['g-recaptcha-response']);
        $response2 = json_decode($response1, true);
        }
            $data['result']['postdata'] = $_POST;
            $signup_ts 		= $_POST['signup_ts'];
            if (!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
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
                if (env('APP_ENV') != "development") {
                $recaptcha = isset($_POST['g-recaptcha-response'])?trim($_POST['g-recaptcha-response']):$_POST['g-recaptcha-response'];
                }
                
                $phone = trim($_POST['phone']);
                $user_position_id = $_POST['user_position'];
                $user_industry_id = $_POST['user_industry'];
                $user_type = $_POST['product'];
                $user_type_id=2;//($user_type=='premium')?2:1;
                $user_status_id=2;
                
                    if ($user_title =="Other") {
                        $user_title = $OtherTitle;
                    }
                    //expiry_on
                    $registered_on = time();
                    $expiry_on=($user_type=='premium')?strtotime("+1 months", time()):0;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $reg_password = $CommonClass->createPassword(8);
                    // User upgrade status
                    if ($user_type=='corporate') {
                        $user_upgrade_status = 'RC';
                    } else {
                        $user_upgrade_status = 'NU';
                    }
                    $defultAlertID = $user->defaultEmailAlert();
                    $defultAlertValue = implode(",", $defultAlertID);
                    $userDetails = array(
                            'user_title' => $user_title,
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
                    if ($user_type_id==2) { //check user_type start
                        $_SESSION['temp_user'] = $userDetails;
                        return redirect('user/dopayment/');
                    } //check user_type end
                    if ($user_type_id!=2) { //check user_type start
                    $u_details = $user->addUserRegistration($userDetails);
                        $user_details = $user->getUserDetailsById($u_details['id']);
                        $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'), '/') : '';
                        if ($evenPath == "production") {
                            $MailGunAPI = new MailGunAPI();
                            $MailGunAPI->addNewUserMailGunListingAddress($email, $fname);
                        }
                        try {
                            $appPath = Config::read('appication_path') != '' ? '/'.trim(Config::read('appication_path'), '/') : '';
                            $activation_link = 'http://'.$_SERVER['HTTP_HOST'].$appPath.'/user/confirmregistration/'.base64_encode($email);
                            $mail = new PHPMailer();
                            if (env('APP_ENV') == "development") {
                                $mail->IsMail();
                            } else {
                                $mail->IsSMTP();
                            }
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
                            $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->Subject = $template['subject'];
                            $mail->Body = $template['message'];
                            $mail->AddAddress($user_details['email'], $user_details['fname'].' '.$user_details['lname']);
                            $mail->Send();
                        } catch (Exception $e) {
                            $data['status'] = 9999;
                            $data['message'] = 'Error...! '.$e->getMessage();
                            $error == true;
                        }
                        $data['result']['user_details'] = $user_details;
                        // Send notification mail
                        try {
                            $notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
                            $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
                            $mail->clearAddresses();
                            $mail->clearAttachments();
                            $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->Subject = $notification_subject;
                            $n_user_type=($user_type!="premium")?"Free":"Premium";
                            $phonedetails=($phone!='')?$phonecode.$phone:'';
                            $notify_body_msg= "A new ".$n_user_type." user signed up with us on.<p>Name : ".ucfirst($fname)." ".ucfirst($lname)."<br><br>Email : ".$email."<br><br>Phone : ".$phonedetails."";
                            if ($user_type=='corporate') {
                                $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
                            }
                            $mail->Body =$notify_body_msg;
                            $mail->AddAddress($notification_to);
                            $mail->Send();
                        } catch (Exception $e) {
                            $data['status'] = 9999;
                            $data['message'] = 'Error...! '.$e->getMessage();
                            $error == true;
                        }
                    }//check user_type end
               
              
                if ($error == true) {
               
                    return view('user.signup', $data);
                } else {
                    if ($user_type_id!=2) { //check user_type start
                        $flash_arr = array('user_id'=>$u_details['id']);
                        $this->setFlashMessage($flash_arr);
                        return redirect('user/completeregistration_success');
                    }//check user_type end
                }
            } else {

                return view('user.signup', $data);
            }
        }

        //dd($data); exit;
        return view('user.signup', $data);
    }
    public function linkedinProcess($product_type=null, $series_code=false)
    {
        if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
            // in case if user cancel the login. redirect back to home page.
            $_SESSION["err_msg"] = $_GET["oauth_problem"];
            return redirect('/user/signup');
            exit;
        }
        $array_Cancel=array('user_cancelled_authorize',"user_cancelled_login");
        if (isset($_GET["error"]) && in_array($_GET["error"], $array_Cancel)) {
            // in case if user cancel the login. redirect back to home page.v2
            $_SESSION['err_msg']=$_GET["error_description"];
             $this->setFlashMessage($_GET["error_description"]);
            return redirect('/user/login');
            exit;
        }
        
        // Get product Type
        $get_product_='';
        if ($product_type==null && $series_code==false) {
            $get_product='';
            if(!isset($_GET['code']) && !isset($_GET['state'])){
                foreach ($_GET as $key => $value) {
                    if ($key!='url') {
                        $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'), '/') : '';
                        if ($evenPath != "development") {
                            $get_product_.=str_replace("_", ".", $key)."=".$value."&";
                        }
                    }
                }
                }
            $get_product_=$get_product_;
        } else {
            // Get product Type
            $get_product=$product_type;
        }
        //$get_product=$product_type[0];
        $client = new oauth_client_class;
        $callbackURL = Config::read('LinkedIn.'.Config::read('environment').'.callbackURL')."/".$get_product;// Conc product Type
        $linkedinApiKey = Config::read('LinkedIn.'.Config::read('environment').'.linkedinApiKey');
        $linkedinApiSecret = Config::read('LinkedIn.'.Config::read('environment').'.linkedinApiSecret');
        $linkedinScope = Config::read('LinkedIn.'.Config::read('environment').'.linkedinScope');
        if (isset($get_product_) && $get_product_!=null) {
            if (strpos($get_product_, '@') !== false) {
                $get_product_ = str_replace("@", "/", $get_product_);
            }
            $get_product_=rtrim($get_product_, "=&");
            $_SESSION['downloadUrl']=rtrim($get_product_, '&');
        }
        /* if (strpos($product_type[0], '@') !== false) {
            $Url = str_replace("@","/",$product_type[0]);
            $split = split("index=",$Url);
        } */
        $client->debug = false;
        $client->debug_http = true;
        $client->redirect_uri = $callbackURL;
        $client->client_id = $linkedinApiKey;
        $application_line = __LINE__;
        $client->client_secret = $linkedinApiSecret;
        if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0) {
            die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
            'create an application, and in the line '.$application_line.
            ' set the client_id to Consumer key and client_secret with Consumer secret. '.
            'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
            'necessary permissions to execute the API calls your application needs.';
        }
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
                          
         
        if ($client->exit) {
            exit;
        }
        if ($success && !empty($user)) {
            $userModel = new User();
            $AlaneeCommon = new CommonClass();
            $password = $AlaneeCommon->createPassword(8);
            $user_type = substr($client->redirect_uri, strrpos($client->redirect_uri, '/') + 1);
            $user_type_id=2;//($user_type=='premium')?2:1;
            if ($user_type_id==2) { //check user_type start
                $country = $userModel->getCountryId($user->country_code);
                $registered_on = time();
                $expiry_on=($user_type=='premium')?strtotime("+3 months", time()):0;
                $defultAlertID = $userModel->defaultEmailAlert();
                $defultAlertValue = implode(",", $defultAlertID);
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
                return redirect('user/dopayment/');
                die;
            } //check user_type end
            if ($user_type_id!=2) { //check user_type start
            $userData = $userModel->checkLinkedInUserExists($user, $password, $user_type_id, $user_type);
                if ($userData) {
                    $defultAlertID = $userModel->defaultEmailAlert();
                    $defultAlertValue = implode(",", $defultAlertID);
                    //$_SESSION['loggedin_user_id'] = $user_id;
                    $userDetails = $userModel->getUserDetailsById($userData['id']);
                    $userDetails['password'] = '********';
                    $userDetails['loginViaLinkedIn'] = 'yes';
                    $userDetails['want_to_email_alert'] = $defultAlertValue;
                    $_SESSION['user'] = $userDetails;
                    if ($userData['res'] == 'insert') {
                        $mailGun = new MailGunAPI();
                        $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'), '/') : '';
                        if ($evenPath == "production") {
                            $mailGun->addNewUserMailGunListingAddress($user->emailAddress, $user->firstName);
                        }
                        $mail = new PHPMailer();
                        if (env('APP_ENV') == "development") {
                            $mail->IsMail();
                        } else {
                            $mail->IsSMTP();
                        }
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
                        $_SESSION['user'] = $userDetails;
                        $corp='';
                        if ($userDetails['user_upgrade_status']=='RC') {
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
                        $mail->AddAddress($userDetails['email'], $userDetails['fname'].' '.$userDetails['lname']);
                        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                        $mail->Send();
                        //Send Notification mail
                        $notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
                        $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
                        $mail->clearAddresses();
                        $mail->clearAttachments();
                        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->Subject = $notification_subject;
                        $n_user_type=($user_type!="premium")?"Free":"Premium";
                        $notify_body_msg = "A new ".ucfirst($n_user_type)." user signed up with us (Using LinkedIn Login).<p>Name : ".ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."<br><br>Email : ".$userDetails['email']."</p><br>";
                        if ($user_type=='corporate') {
                            $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
                        }
                        $notify_body_msg.="<br>Thanks,<br>IMA Team.<br>";
                        $mail->Body =$notify_body_msg;
                        $mail->AddAddress($notification_to);
                        $mail->Send();
                        $render = true;
                        $data['result']['user_details'] = $userDetails;
                        if (isset($_SESSION['downloadUrl']) &&  $_SESSION['downloadUrl']!='') {
                            $redirect = ($_SESSION['downloadUrl']);
                            if (isset($_SESSION['downloadUrl'])) {
                                unset($_SESSION['downloadUrl']);
                            }
                            return redirect()->away($redirect);
                            exit();
                        } else {
                            return redirect('/');
                        }
                        /* if($split[1] != ''){
                            session_start();
                            $_SESSION['chartIndex'] = $split[1];
                        }
                        if($split[0]){
                            header("Location: ".$split[0]);
                            exit();
                        }
                        else{
                            $this->redirect('/');
                        } */
                    } elseif ($userData['res'] == 'update') {
                        $user_row = $userModel->check_linkedin_user_status($user);
                        if (is_bool($user_row)) {
                            $userDetails = $userModel->getUserDetailsById($userData['id']);
                            $userDetails['password'] = '********';
                            $_SESSION['user'] = $userDetails;
                            if (isset($_SESSION['downloadUrl']) &&  $_SESSION['downloadUrl']!='') {
                                $redirect = ($_SESSION['downloadUrl']);
                                if (isset($_SESSION['downloadUrl'])) {
                                    unset($_SESSION['downloadUrl']);
                                }
                                return redirect()->away($redirect);
                                exit();
                            } else {
                                return redirect('/');
                            }
                            /* if($split[1] != ''){
                                session_start();
                                $_SESSION['chartIndex'] = $split[1];
                            }
                            if($split[0]){
                                header("Location: ".$split[0]);
                                exit();
                            }
                            else{
                                $this->redirect('/');
                            } */
                        } else {
                            if (isset($_SESSION['OAUTH_ACCESS_TOKEN'])) {
                                unset($_SESSION['OAUTH_ACCESS_TOKEN']);
                            }
                            $this->setFlashMessage($user_row);
                            return redirect('user/login');
                        }
                    }
                }
            }//check user_type end
        } else {
            $_SESSION["err_msg"] = $client->error;
            $this->setFlashMessage($client->error);
            return redirect('user/login');
        }
        //$this->redirect('/');
    }
    public function editMyProfile()
    {
        try {
            $this->populateLeftMenuLinks();
            if ($this->isUserLoggedIn() == true) {
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
        } catch (Exception $ex) {
        }
        $this->renderView();
    }
    public function completeregistration()
    {
        $user = new User();
        $country = new Country();
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }
        $data['pageTitle'] = "Welcome to India macro advisors - Sign up";
        $data['meta']['description']='India macro advisors - Sign up';
        $data['meta']['keywords']='Sign up, register, subscribe';
        $data['renderResultSet']=$data;
        $user_position = $user->getPositionsDatabase();
        $user_industry = $user->getIndustryDatabase();
        $data['result']['user_position'] = $user_position;
        $data['result']['user_industry'] = $user_industry;
        $data['result']['country_list'] = $country->getCountryDatabase();
        $data['result']['signup_error_id'] = '';
        $data['result']['postdata'] = null;
        $error = false;
        if (isset($_POST['signup_btn'])) {
            $data['result']['postdata'] = $_POST;
            $signup_ts 		= $_POST['signup_ts'];
            if (!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
                unset($_SESSION['signup_ts']);
                $OtherTilteFlag=false;
                $user_title = $_POST['user_title'];
                $OtherTitle=trim($_POST['OtherTitle']);
                $fname = trim($_POST['fname']);
                $lname = trim($_POST['lname']);
                $email = trim($_POST['email']);
                $country_id = $_POST['country_id'];
                $phonecode = trim($_POST['phone_code']);
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
                if ($user_title =="Other" && $OtherTitle == '') {
                    $data['status'] = 3333;
                    $data['message'] = 'Please enter Title';
                    $data['result']['signup_error_id']	= '#user_title_id';
                    $error = true;
                } elseif (empty($fname)) {
                    $data['status'] = 3333;
                    $data['message'] = 'Please enter first name';
                    $data['result']['signup_error_id']	= '#reg_first_name';
                    $error = true;
                } elseif (empty($lname)) {
                    $data['status'] = 3333;
                    $datat['message'] = 'Please enter last name';
                    $data['result']['signup_error_id']	= '#reg_last_name';
                    $error = true;
                } elseif (empty($email)) {
                    $data['status'] = 3333;
                    $data['message']= 'Please enter email';
                    $data['result']['signup_error_id']	= '#reg_email';
                    $error = true;
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data['status'] = 3333;
                    $data['message'] = 'Please enter a valid email';
                    $data['result']['signup_error_id']	= '#reg_email';
                    $error = true;
                } elseif ($user->checkUserExistsByEmail($email)) {
                    $data['status'] = 3333;
                    $data['message'] = 'User already registerd with this email, please try another email. ';
                    $data['result']['signup_error_id']	= '#reg_email';
                    $error = true;
                } elseif (!intval($country_id)) {
                    $data['status'] = 3333;
                    $data['message'] = 'Please select country';
                    $data['result']['signup_error_id']	= '#reg_country';
                    $error = true;
                } else {
                    if ($user_title =="Other") {
                        $user_title = $OtherTitle;
                    }
                    //expiry_on
                    $registered_on = time();
                    $expiry_on=($user_type=='premium')?strtotime("+1 months", time()):0;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $reg_password = $CommonClass->createPassword(8);
                    // User upgrade status
                    if ($user_type=='corporate') {
                        $user_upgrade_status = 'RC';
                    } else {
                        $user_upgrade_status = 'NU';
                    }
                    $defultAlertID = $user->defaultEmailAlert();
                    $defultAlertValue = implode(",", $defultAlertID);
                    $userDetails = array(
                            'user_title' => $user_title,
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
                    if ($user_type_id==2) { //check user_type start
                        $_SESSION['temp_user'] = $userDetails;
                        return redirect('user/dopayment/');
                    } //check user_type end
                    if ($user_type_id!=2) { //check user_type start
                    $u_details = $user->addUserRegistration($userDetails);
                        $user_details = $user->getUserDetailsById($u_details['id']);
                        $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'), '/') : '';
                        if ($evenPath == "production") {
                            $MailGunAPI = new MailGunAPI();
                            $MailGunAPI->addNewUserMailGunListingAddress($email, $fname);
                        }
                        try {
                            $appPath = Config::read('appication_path') != '' ? '/'.trim(Config::read('appication_path'), '/') : '';
                            $activation_link = 'http://'.$_SERVER['HTTP_HOST'].$appPath.'/user/confirmregistration/'.base64_encode($user_details['id']);
                            $mail = new PHPMailer();
                            if (env('APP_ENV') == "development") {
                                $mail->IsMail();
                            } else {
                                $mail->IsSMTP();
                            }
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
                            $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->Subject = $template['subject'];
                            $mail->Body = $template['message'];
                            $mail->AddAddress($user_details['email'], $user_details['fname'].' '.$user_details['lname']);
                            $mail->Send();
                        } catch (Exception $e) {
                            $data['status'] = 9999;
                            $data['message'] = 'Error...! '.$e->getMessage();
                            $error == true;
                        }
                        // Send notification mail
                        try {
                            $notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
                            $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
                            $mail->clearAddresses();
                            $mail->clearAttachments();
                            $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->Subject = $notification_subject;
                            $n_user_type=($user_type!="premium")?"Free":"Premium";
                            $phonedetails=($phone!='')?$phonecode.$phone:'';
                            $notify_body_msg= "A new ".$n_user_type." user signed up with us on.<p>Name : ".ucfirst($fname)." ".ucfirst($lname)."<br><br>Email : ".$email."<br><br>Phone : ".$phonedetails."";
                            if ($user_type=='corporate') {
                                $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
                            }
                            $mail->Body =$notify_body_msg;
                            $mail->AddAddress($notification_to);
                            $mail->Send();
                        } catch (Exception $e) {
                            $data['status'] = 9999;
                            $data['message'] = 'Error...! '.$e->getMessage();
                            $error == true;
                        }
                    }//check user_type end
                }
                $render = true;
                $data['result']['user_details'] = $user_details;
                if ($error == true) {
                    return view('user.signup', $data);
                } else {
                    if ($user_type_id!=2) { //check user_type start
                        $flash_arr = array('user_id'=>$u_details['id']);
                        $this->setFlashMessage($flash_arr);
                        return redirect('user/completeregistration_success');
                    }//check user_type end
                }
            } else {
                return view('user.signup', $data);
            }
        } else {
            return view('user.signup', $data);
        }
    }
    private function send_individual_user_mail($params)
    {
        $user_id = base64_decode($params);
        $user = new User();
        if ($user->validateUserEmail($user_id)) {
            $user_details = $user->getUserDetailsById($user_id);
            $mail = new PHPMailer();
            if (env('APP_ENV') == "development") {
                $mail->IsMail();
            } else {
                $mail->IsSMTP();
            }
            $mail->IsHTML(true);
            $mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                    $mail->WordWrap = 50;
            $Mailtemplate = new Mailtemplate();
            $mail_data = array(
                            'name' => ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']),
                            'title' => (($user_details['user_type'] == 'free') ? 'Free' : 'Premium account'),
                            'username' => $user_details['email'],
                            'password' => $user_details['password'],
                            'accountType' => 'Premium  Account'
                        );
            $template = $Mailtemplate->getTemplateParsed('welcome_accountdetails', $mail_data);
            $mail->Subject = $template['subject'];
            $mail->Body = $template['message'];
            $mail->AddAddress($user_details['email'], $user_details['fname'].' '.$user_details['lname']);
            $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
            $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
            $mail->Send();
            // Send notification mail
            try {
                $notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
                $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
                $mail->clearAddresses();
                $mail->clearAttachments();
                $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->Subject = $notification_subject;
                $notify_body_msg= "A new Premium user signed up with us on.<p>Name : ".ucfirst($user_details['fname'])." ".ucfirst($user_details['lname'])."<br><br>Email : ".$user_details['email']."<br><br>Phone : ".$user_details['country_code'].$user_details['phone']."";
                $mail->Body =$notify_body_msg;
                $mail->AddAddress($notification_to);
                $mail->Send();
            } catch (Exception $e) {
                $this->renderResultSet['status'] = 9999;
                $this->renderResultSet['message'] = 'Error...! '.$e->getMessage();
                $error == true;
            }
        }
    }
    private function send_individual_linkedin_user_mail($params)
    {
        $user_id = base64_decode($params);
        $user = new User();
        if ($user->validateUserEmail($user_id)) {
            $userDetails = $user->getUserDetailsById($user_id);
            $mail = new PHPMailer();
            if (env('APP_ENV') == "development") {
                $mail->IsMail();
            } else {
                $mail->IsSMTP();
            }
            $mail->IsHTML(true);
            $mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                    $mail->WordWrap = 50;
            $Mailtemplate = new Mailtemplate();
            $corp='';
            if ($userDetails['user_upgrade_status']=='RC') {
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
                $mail->AddAddress($userDetails['email'], $userDetails['fname'].' '.$userDetails['lname']);
                $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                $mail->Send();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            //Send Notification mail
            try {
                $notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
                $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
                $mail->clearAddresses();
                $mail->clearAttachments();
                $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->Subject = $notification_subject;
                $n_user_type=($userDetails['user_type']!="premium")?"Free":"Premium";
                $notify_body_msg = "A new ".ucfirst($n_user_type)." user signed up with us (Using LinkedIn Login).<p>Name : ".ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."<br><br>Email : ".$userDetails['email']."</p><br>";
                if ($userDetails['user_type']=='corporate') {
                    $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($userDetails['user_type'])."</p>";
                }
                $notify_body_msg.="<br>Thanks,<br>IMA Team.<br>";
                $mail->Body =$notify_body_msg;
                $mail->AddAddress($notification_to);
                $mail->Send();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
    /**
     * Registration success page
     * @param Int $u_id : user id
     */
    public function completeregistration_success()
    {
        $fl_msg = $this->getFlashMessage();
        if (isset($fl_msg['user_id'])) {
            $u_id = $fl_msg['user_id'];
            $user = new User();
            $country = new Country();
            $media = new Media();
            $check_exits_register_competition = $user->getCompetitionUserById($u_id);
            if (isset($fl_msg['existing'])) {
                $data['result']['competition'] = 'no';
            } else {
                if ($check_exits_register_competition === true) {
                    $data['result']['competition'] = 'yes';
                }
            }
            $data['pageTitle'] = "Welcome to India macro advisors - Sign up";
            $data['meta']['description']='India macro advisors - Sign up';
            $data['meta']['keywords']='Sign up, register, subscribe';
            $data['renderResultSet']=$data;
            // Getting user details by user id
            $user_details = $user->getUserDetailsById($u_id);
            $data['result']['user_details'] = $user_details;
            return view('user.signin_confirm', $data);
        } else {
            return redirect('user/signup');
        }
    }
    /**
     * In products page After login user click on REQUEST INFO button
     * @param Int $u_id : user id
     */
    public function user_request_info()
    {
        if (isset($_SESSION['user'])) {
            $flash_arr = array('user_id'=>$_SESSION['user']['id']);
            $this->setFlashMessage($flash_arr);
            $fl_msg = $this->getFlashMessage();
            if (isset($fl_msg['user_id'])) {
                $u_id = $fl_msg['user_id'];
                $user = new User();
                $data['pageTitle'] = "Welcome to India macro advisors - Sign up";
                $data['meta']['description']='India macro advisors - Sign up';
                $data['meta']['keywords']='Sign up, register, subscribe';
                $data['renderResultSet']=$data;
                $user_details = $user->getUserDetailsById($u_id);
                if ($user_details['user_upgrade_status']=='RP') {
                    $account = 'premium';
                } elseif ($user_details['user_upgrade_status']=='RC') {
                    $account = 'corporate';
                } elseif ($user_details['user_upgrade_status']=='RB') {
                    $account = 'both premium & corporate';
                } else {
                    $account = 'Corporate';
                }
                $user_type=($user_details['user_type']=='individual')?"Premium":ucfirst($user_details['user_type']);
                $update_Rc = array(
                        'id' => $u_id,
                        'user_upgrade_status' => 'RC'
                    );
                $user->update_request_corporate($update_Rc);
                $mail = new PHPMailer();
                if (env('APP_ENV') == "development") {
                    $mail->IsMail();
                } else {
                    $mail->IsSMTP();
                }
                $mail->IsHTML(true);
                $notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
                $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
                $mail->clearAddresses();
                $mail->clearAttachments();
                $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->Subject = $notification_subject;
                $mail->Body = "User with below details have requested for ".$account." account.<p>Name : ".$user_details['fname']." ".$user_details['lname']."<br><br>Email : ".$user_details['email']."<br><br>Subscription Type: ".$user_type."</p><br><br>
					Thanks,<br>
					IMA Team.<br>";
                $mail->AddAddress($notification_to);
                $mail->Send();
                $data['result']['user_details'] = $user_details;
                return view('user.request_info_success', $data);
            } else {
                return redirect('user/signup');
            }
        } else {
            return redirect('user/signup');
        }
    }
    /**
     * Confirm registration - validate email adress
     * @param String $params : base64 encoded user id
     */
    public function confirmregistration($params)
    {
        $user = new User();
        $country = new Country();
        $media = new Media();
        $data['pageTitle']= "Welcome to India macro advisors - Sign up";
        $data['meta']['description']="India macro advisors - Sign up";
        $data['meta']['keywords']='Sign up, register, subscribe';
        $data['renderResultSet']=$data;
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        if ($params!='') {
            if (!filter_var(base64_decode($params), FILTER_VALIDATE_EMAIL)) {
                new ErrorController(404);
            } else {
                $user_email = base64_decode($params);
                $user = new User();
                if ($user->validateUserEmail($user_email)) {
                    $user_details = $user->getUserDetailsByEmail($user_email);
                    $user_id=$user_details[0]['id'];
                    $user_details = $user->getUserDetailsById($user_id);
                    if ($user_details['user_status'] == 'active') {
                        new ErrorController(404);
                    }
                    $data['result']['message'] = "Dear <b>".ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']).",</b><br><br>Thank you for signing up to India Macro Advisors. Your free account is now active.<br>Your access credentials have been mailed to <b><i>".$user_details['email'].".</i></b>";
                    $mail = new PHPMailer();
                    if (env('APP_ENV') == "development") {
                        $mail->IsMail();
                    } else {
                        $mail->IsSMTP();
                    }
                    $mail->IsHTML(true);
                    $mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                        $mail->WordWrap = 50;
                    $Mailtemplate = new Mailtemplate();
                    $corp='';
                    if ($user_details['user_upgrade_status']=='RC') {
                        $corp.=" ( You'r Requested Corporate Account )";
                    }
                    $mail_data = array(
                            'name' => ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']),
                            'title' => isset($user_title['user_title'])?$user_title['user_title']:'',
                            'username' => $user_details['email'],
                            'password' => $user_details['password'],
                            'accountType' => ucfirst($user_details['user_type']).$corp,
                        );
                    $template = $Mailtemplate->getTemplateParsed('welcome_accountdetails', $mail_data);
                    $mail->Subject = $template['subject'];
                    $mail->Body = $template['message'];
                    $mail->AddAddress($user_details['email'], $user_details['fname'].' '.$user_details['lname']);
                    $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                    $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                    $mail->Send();
                    // Activate account - change to trial
                    //	$user->setThisUserStatus($user_details['id'], 'trial');
                    // Activate account - change to active
                    $user->setThisUserStatus($user_details['id'], 'active');
                    $user_details = $user->getUserDetailsById($user_id);
                    $user_details['password'] = '********';
                    $_SESSION['user'] = $user_details;
                    $check_exits_register_competition = $user->getCompetitionUserById($user_details['id']);
                    if ($check_exits_register_competition == true) {
                        return redirect('/page/ideapitchcompetition');
                    } else {
                        return redirect('/');
                    }
                } else {
                    $data['result']['status'] = 9999;
                    $data['result']['message'] = "Error..! Couldn't update user you already activated your account";
                    return view('user.signin_success', $data);
                }
            }
        } else {
            new ErrorController(404);
        }
    }
    public function dopayment()
    {
        if (!isset($_SESSION['temp_user']) && !isset($_SESSION['user'])) {
            return redirect('user/login?r=user/dopayment');
        } else {
            if (isset($_SESSION['temp_user'])) {
                unset($_SESSION['user_type_upgrade']);
            }
            $api = new Api(Config::read('razorpay.'.Config::read('environment').'.api_key'), Config::read('razorpay.'.Config::read('environment').'.api_secret'));
            if (empty($_POST)) {
             date_default_timezone_set('Asia/Kolkata');
#'start_at' =>(time()+ 4*3600),
                # strtotime('+30 days', time());
                $subscription  = $api->subscription->create(array('plan_id' => Config::read('razorpay.'.Config::read('environment').'.api_plan'),'total_count' => 120, 'start_at' =>strtotime('+30 days', time()), 'customer_notify' => 1,   'addons' => array(array('item' => array('name' => 'IMA PREMIUM SUBSCRIPTION', 'amount' => (Config::read('subscription.amount')*100), 'currency' => Config::read('subscription.currency'))))));
                $orderData = [
    'receipt'         => (time()),
    'amount'          => (Config::read('subscription.amount')*100),
    'currency'        => Config::read('subscription.currency'),
    'payment_capture' => 1 // auto capture
];
$country_code=((isset($_SESSION['temp_user']['country_code']) && $_SESSION['temp_user']['country_code']!=null)?$_SESSION['temp_user']['country_code']:(isset($_SESSION['user']['country_code'])?$_SESSION['user']['country_code']:'+91'));
#$country_code=((isset($_SESSION['temp_user']['phone']) && $_SESSION['temp_user']['phone']!=null)?$_SESSION['temp_user']['phone']:(isset($_SESSION['user']['phone'])?$_SESSION['user']['phone']:''));
                $razorpayOrder = $api->order->create($orderData);
                $razorpayOrderId = $razorpayOrder['id'];
                $data = [
    "key"               => Config::read('razorpay.'.Config::read('environment').'.api_key'),
    "amount"            => (Config::read('subscription.amount')*100),
    "subscription_id"   =>$subscription->id,
    "name"              => "India Macro Advisors",
    "description"       => "PREMIUM SUBSCRIPTION",
    "image"             => images_path("logo.png"),
    "prefill"           => [
    "name"              => ((isset($_SESSION['temp_user']['fname']) && $_SESSION['temp_user']['fname']!=null)?$_SESSION['temp_user']['fname'].' '.$_SESSION['temp_user']['lname']:$_SESSION['user']['fname'].' '.$_SESSION['user']['lname']),
    "email"             => ((isset($_SESSION['temp_user']['email']) && $_SESSION['temp_user']['email']!=null)?$_SESSION['temp_user']['email']:$_SESSION['user']['email']),
    "contact"           => ((isset($_SESSION['temp_user']['phone']) && $_SESSION['temp_user']['phone']!=null)?$country_code.$_SESSION['temp_user']['phone']:(isset($_SESSION['user']['phone'])?$country_code.$_SESSION['user']['phone']:'')),
    ],
    "theme"             => [
    "color"             => "#316AB4"
    ],
    "order_id"          => $razorpayOrderId,
];
                $json = json_encode($data);
                $data['json'] = $json;
                $renderResultSet['pageTitle']= "Welcome to India macro advisors - Do payment";
                $renderResultSet['meta']['description']="India macro advisors - Do payment";
                $renderResultSet['meta']['keywords']='Do payment, subscribe';
                $data['renderResultSet']=$renderResultSet;
                return view('user.razorpay', $data);
            } else {
                #echo "<pre>";print_r($_POST);
                //Start
                $user = new User();
                $email = (isset($_SESSION['temp_user']) && $_SESSION['temp_user']['email']!=null)?$_SESSION['temp_user']['email']:$_SESSION['user']['email'];
                if (isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null) {
                    $userDetails=$_SESSION['temp_user'];
                    $checkUserExists = $user->checkUserExistsByEmail($_SESSION['temp_user']['email']);
                    if ($checkUserExists) {
                        if (isset($_SESSION['OAUTH_ACCESS_TOKEN'])) {
                            $u_details = $user->updateLinkedinData($userDetails, 'linkedin');
                        }
                        if (isset($_SESSION['temp_user']['facebook_enabled'])) {
                            $u_details = $user->updateLinkedinData($userDetails, 'facebook');
                        }
                    } else {
                        $u_details = $user->addUserRegistration($userDetails);
                        $update=$user->setThisUserStatus($u_details['id'], 'active');
                        if (env('APP_ENV') == "production") {
                            $MailGunAPI = new MailGunAPI();
                            $MailGunAPI->addNewUserMailGunListingAddress($email, $_SESSION['temp_user']['fname']);
                        }
                        if (isset($_SESSION['OAUTH_ACCESS_TOKEN']) || isset($_SESSION['temp_user']['facebook_enabled'])) {
                            $this->send_individual_linkedin_user_mail(base64_encode($u_details['id']));
                            unset($_SESSION['OAUTH_ACCESS_TOKEN']);
                        } else {
                            $this->send_individual_user_mail(base64_encode($u_details['id']));
                        }
                        if (isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null) {
                            unset($_SESSION['temp_user']);
                        }
                    }
                } else {
                    if (isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']==1) {
                      
                        $this->user_upgrade_mail($_SESSION['user']['id']);
                        $user->setThisUserStatus($_SESSION['user']['id'], 'active');
                        $user->setThisUserToPremium($_SESSION['user']['id']);
                    }
                }
                $id=(isset($u_details['id']) && $u_details['id']!=null)?$u_details['id']:$_SESSION['user']['id'];
                if ($_POST['razorpay_subscription_id']!=null) {

                    /*    $this->user_upgrade_mail($_SESSION['user']['id']);
                        $user->setThisUserStatus($_SESSION['user']['id'], 'active');
                        $user->setThisUserToPremium($_SESSION['user']['id']);*/
                    $subscription  = $api->subscription->fetch($_POST['razorpay_subscription_id']);
                    #echo "<pre>";print_r($subscription);die;
                    $responseData = array(
                        "email" => $email,
                        "customerId" => $subscription->customer_id,
                        "subscriptionId" => $_POST['razorpay_subscription_id'],
                        "startSubscription" => time(),
                        "endSubscription" => strtotime('+1 month', time())
                    );
                    $updateUserDetails = $user->updateStripeCusId($responseData);
                    $transaction_id = 'null';
                    $order_id = '';
                    $action = 'Razorpay - Create Subscription';
                    $data =json_encode($_POST);
                    $createUserStripeLog = $user->addlog($id, $transaction_id, $order_id, $action, $data);
                }
                $user_details = $user->getUserDetailsById($id);
                $_SESSION['user'] = $user_details;
                $this->payment_status_mail($id, 'success');
                $_SESSION['message']='Upgarde';
                return redirect('user/payment_success');
                //End
            }
        }
    }
    public function dopayment_old_stripe()
    {
        if (!isset($_SESSION['temp_user']) && !isset($_SESSION['user'])) {
            return redirect('user/login?r=user/dopayment');
        } else {
            if (isset($_SESSION['temp_user'])) {
                unset($_SESSION['user_type_upgrade']);
            }
            $media = new Media();
            $country = new Country();
            $user = new User();
            $renderResultSet['pageTitle']= "Welcome to India macro advisors - Do payment";
            $renderResultSet['meta']['description']="India macro advisors - Do payment";
            $renderResultSet['meta']['keywords']='Do payment, subscribe';
            $data['renderResultSet']=$renderResultSet;
            $data['result']['country_list'] = $country->getCountryDatabase();
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $datat['result']['rightside']['media'] = $media->getLatestMedia(5);
            $data['status'] = 1;
            $data['result']['stripe_publish_key'] = Config::read('stripe.'.Config::read('environment').'.publish_Key');
            if (isset($_POST['stripeToken'])) {
                $payment = new SubscriptionClass();
                $paymentGateway = 'stripe';
                $stripeToken = $_POST['stripeToken'];
                $email = (isset($_SESSION['temp_user']['email']) && $_SESSION['temp_user']['email']!=null)?$_SESSION['temp_user']['email']:$_SESSION['user']['email'];
                $paymentProcess = $payment->createSubscription($paymentGateway, $stripeToken, $email);
                if (isset($paymentProcess['error'])) {
                    if (isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']!='') {
                        $this->payment_status_mail($_SESSION['user']['id'], 'error');
                    }
                    $data['status'] = 4444;
                    $data['message'] = $paymentProcess['error']['message'];
                } else {
                    if (isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null) {
                        $userDetails=$_SESSION['temp_user'];
                        $checkUserExists = $user->checkUserExistsByEmail($_SESSION['temp_user']['email']);
                        if ($checkUserExists) {
                            if (isset($_SESSION['OAUTH_ACCESS_TOKEN'])) {
                                $u_details = $user->updateLinkedinData($userDetails, 'linkedin');
                            }
                            if (isset($_SESSION['temp_user']['facebook_enabled'])) {
                                $u_details = $user->updateLinkedinData($userDetails, 'facebook');
                            }
                        } else {
                            $u_details = $user->addUserRegistration($userDetails);
                            $update=$user->setThisUserStatus($u_details['id'], 'active');
                            if (isset($_SESSION['OAUTH_ACCESS_TOKEN']) || isset($_SESSION['temp_user']['facebook_enabled'])) {
                                $this->send_individual_linkedin_user_mail(base64_encode($u_details['id']));
                                unset($_SESSION['OAUTH_ACCESS_TOKEN']);
                            } else {
                                $this->send_individual_user_mail(base64_encode($u_details['id']));
                            }
                            if (isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null) {
                                unset($_SESSION['temp_user']);
                            }
                        }
                    } else {
                        if (isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']==1) {
                            $this->user_upgrade_mail($_SESSION['user']['id']);
                            $user->setThisUserStatus($_SESSION['user']['id'], 'trail');
                            $user->setThisUserToPremium($_SESSION['user']['id']);
                        }
                    }
                    $id=(isset($u_details['id']) && $u_details['id']!=null)?$u_details['id']:$_SESSION['user']['id'];
                    if ($paymentProcess!=null) {
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
                    $_SESSION['user'] = $user_details;
                    $this->payment_status_mail($id, 'success');
                    $_SESSION['message']='Upgarde';
                    return redirect('user/payment_success');
                }
            }
            return view('user.dopayment', $data);
        }
    }
    private function payment_status_mail($user_id, $status)
    {
        $appPath = Config::read('appication_path') != '' ? '/' . trim(Config::read('appication_path'), '/') : '';
        $site_link = 'http://' . $_SERVER ['HTTP_HOST'] . $appPath;
        $user = new User();
        $success_msg = '';
        $error_mail_msg = '';
        $user_details = $user->getUserDetailsById($user_id);
        $_SESSION ['user'] = $user_details;
        $CONF_CURRENCY = Config::read('subscription.currency');
        $CONF_AMOUNT = Config::read('subscription.amount');
        $Mailtemplate = new Mailtemplate();
        $mail_data = array(
                        'name' => $user_details ['fname'] . ' ' . $user_details ['lname'],
                        'email' => $user_details ['email'],
                        'currency' => $CONF_CURRENCY,
                        'amount' => $CONF_AMOUNT
                    );
        if ($status == 'success') {
            $template = $Mailtemplate->getTemplateParsed('payment_success', $mail_data);
        } else {
            $template = $Mailtemplate->getTemplateParsed('payment_notify_error', $mail_data);
        }
        $mail = new PHPMailer();
        if (env('APP_ENV') == "development") {
            $mail->IsMail();
        } else {
            $mail->IsSMTP();
        }
        $mail->IsHTML(true);
        $mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
        $mail->WordWrap = 50;
        $Mailtemplate = new Mailtemplate();
        // print_r($template);
        $mail->Subject = $template ['subject'];
        $mail->Body = $template ['message'];
        $mail->AddAddress($user_details ['email'], $user_details ['fname'] . ' ' . $user_details ['lname']);
        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mail->Send();
    }
    public function payment_success()
    {
        $media = new Media();
        $country = new Country();
        $user = new User();
        $id = $_SESSION['user']['id'];
        $user_details = $user->getUserDetailsById($id);
        $_SESSION['user']=$user_details;
        $data['pageTitle']= "Welcome to India macro advisors -  Payment Success";
        $data['meta']['description']="India macro advisors -  Payment Success";
        $data['meta']['keywords']='Payment Success, subscribe';
        $data['renderResultSet']=$data;
        $data['result']['country_list'] = $country->getCountryDatabase();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        return view('user.payment_success', $data);
    }
    public function cancelSubscription()
    {
        if ($_SESSION['user']['user_type_id']==2) {
            $data['pageTitle']= "Welcome to India macro advisors - Cancel Subscription";
            $data['meta']['description']="India macro advisors - Cancel Subscription";
            $data['meta']['keywords']='Payment Success, subscribe';
            $data['renderResultSet']=$data;
            $subscription = new SubscriptionClass();
            $user = new User();
            $media = new Media();
            $id = $_SESSION['user']['id'];
            $user_details = $user->getUserDetailsById($id);
            $_SESSION['user']=$user_details;
            if (isset($_REQUEST['submit']) && $_REQUEST['submit']=='free') {
                if (Config::read('environment')=='production' && ($_SESSION['user']['user_id']==508 || $_SESSION['user']['user_id']==561)) {
                    $cancelSubscriptionProcess = $subscription->cancelSubscription($id);
                    if ($cancelSubscriptionProcess=='Subscription cancelled successfully') {
                        $this->downgrade_success_send_mail($id);
                        $this->setFlashMessage($cancelSubscriptionProcess);
                        $user_details = $user->getUserDetailsById($id);
                        $_SESSION['user']=$user_details;
                        return redirect('user/myaccount');
                    }
                } else {
                    $api = new Api(Config::read('razorpay.'.Config::read('environment').'.api_key'), Config::read('razorpay.'.Config::read('environment').'.api_secret'));
                    try {
                        $subscription_cancel  = $api->subscription->fetch($user_details['stripe_subscription_id'])->cancel();
                        if ($subscription_cancel->status=='cancelled') {
                            $this->downgrade_success_send_mail($id);
                            $this->setFlashMessage('Subscription cancelled successfully');
                            # $updateUserStatus = $user->setThisUserStatus($id,$statusKey);
                            $updateUserType = $user->setThisUserToFree($id);
                            $user_details = $user->getUserDetailsById($id);
                           
                            $_SESSION['user']=$user_details;
                            return redirect('user/myaccount');
                        }
                        #dd($subscription_cancel->status);
                    } catch (Exception $ex) {
                        $cancelSubscriptionProcess= $ex->getMessage();
                    }
                }
                $data['result']['cancelSubscriptionError']= $cancelSubscriptionProcess;
            }
            $data['result']['userdetails']= $user_details;
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);
            return view('user/cancelSubscription', $data);
        }
        return redirect('user/myaccount');
    }
    public function upgradeSubscription()
    {
        $email = $_SESSION['user']['email'];
        $user = new User();
        $getUserDetails = $user->getUserDetailsByEmail($email);
        if ($getUserDetails[0]['stripe_subscription_id'] != null && $getUserDetails[0]['user_type_id'] == 1 && $getUserDetails[0]['user_status_id'] == 4) {
            $subscription = new Subscription();
            $upgradeSubscriptionProcess = $subscription->upgradeSubscription($getUserDetails[0]['stripe_customer_id']);
            if ($upgradeSubscriptionProcess->id) {
                //send success mail
                $this->payment_success_send_mail($_SESSION['user']['id']);
            } else {
                $this->setFlashMessage('Upgrade Failed');
            }
        }
    }
    /*After payment suuccess mail by veera Start*/
    private function payment_success_send_mail($user_id)
    {
        $user = new User();
        $user_details = $user->getUserDetailsById($user_id);
        $mail = new PHPMailer();
        if (env('APP_ENV') == "development") {
            $mail->IsMail();
        } else {
            $mail->IsSMTP();
        }
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
        $mail->AddAddress($user_details['email'], $user_details['fname'].' '.$user_details['lname']);
        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mail->Send();
    }
    /*After payment suuccess mail by veera End*/
    /*After downgrade suuccess mail by veera Start*/
    private function downgrade_success_send_mail($user_id)
    {
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
        $mail->AddAddress($user_details['email'], $user_details['fname'].' '.$user_details['lname']);
        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mail->Send();
        return true;
    }
    /*After downgrade suuccess mail by veera End*/
    public function login($uparam='')
    {
        $this->handleUnpaidUser();
        $data['pageTitle'] = "Welcome to India macro advisors - Client login";
        $data['meta']['description']='India macro advisors - login';
        $data['meta']['keywords']='Sign up, register, subscribe, log in, user';
        $data['renderResultSet']=$data;
        if (!isset($_SESSION['fullredirect_redirecturl']) || $_SESSION['fullredirect_redirecturl'] == '') {
            $_SESSION['fullredirect_redirecturl'] = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : null;
        }
        if ($this->isUserLoggedIn() == true) {
            return redirect('/');
        }
        if (isset($uparam['r']) && $uparam['r']!='') {
            $_SESSION['redirecturl'] = $uparam['r'];
        }
        // get all category items
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }
        if (count($_POST)>0) {
            $user = new User();
            $username = $_POST['login_email'];
            //$password = md5($_POST['login_password']);
            $password = $_POST['login_password'];
            $user_row = $user->check_user_status($username, $password);
            if (is_bool($user_row)) {
                $userDetails = $user->getUserDetailsByUserNameAndPassword($username, $password);
                $userDetails['password'] = '********';
                $userDetails['loginViaLinkedIn'] = 'no';
                if (count($userDetails)>0 && $userDetails['id'] >0) {
                    //$userPermissions = new Userpermissions();
                    if (!empty($_POST['login_rememberMe']) && $_POST['login_rememberMe']=='y') {
                        $path = "/";
                        $salt = "125778rttyyyu";
                        $rm = $salt."_".$username."_".$password."_".$salt;
                        $rm = base64_encode($rm);
                        $rm = base64_encode($rm);
                        //setcookie("jmacrm",$rm,time()+3600 * 24 * 365,$path);
                        Cookie::queue(Cookie::forever('jmacrm', $rm));
                    }
                    # autologin setcookie start
                    $cookie_value=base64_encode($userDetails['email']).'|||'.md5($userDetails['password']);
                    //setcookie("JMA_USER", $cookie_value, time()+3600 * 24 * 365, '/');
                    Cookie::queue(Cookie::forever('JMA_USER', $cookie_value));
                    # autologin setcookie end
                    $_SESSION['user'] = $userDetails;
                    //Session::put('user', $userDetails);
                    if ($userDetails['user_status_id']==7) {
                        return redirect('user/user_pay_downgrade');
                        die;
                    }
                    $beforeLoginUrl = explode("/", $_SESSION['fullredirect_redirecturl']);
                    $findLastParam = (array_pop($beforeLoginUrl));
                    $action = $beforeLoginUrl[count($beforeLoginUrl)-1];
                    if (isset($_SESSION['redirecturl']) && $_SESSION['redirecturl'] != '') {
                        $redirect_url = $_SESSION['redirecturl'];
                        unset($_SESSION['redirecturl']);
                        return redirect($redirect_url);
                        exit;
                    } else {
                        if (isset($_SESSION['fullredirect_redirecturl']) && $_SESSION['fullredirect_redirecturl'] != null) {
                            $full_redirect_url = $_SESSION['fullredirect_redirecturl'];
                            unset($_SESSION['fullredirect_redirecturl']);
                            if (($findLastParam == "withoutlogin" && $action == "registercompetition") || ($findLastParam == "login" && $action == "registercompetition")) {
                                return redirect('/');
                            } else {
                                return redirect($full_redirect_url);
                            }
                            exit;
                        } elseif (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
                            $full_redirect_url = $_SERVER['HTTP_REFERER'];
                            return redirect($full_redirect_url);
                            exit;
                        } else {
                            return redirect('/');
                            exit;
                        }
                    }
                } else {
                    $data['result']['status'] = 3333;
                    $data['result']['message'] = 'Login failed. Please try again';
                }
            } else {
                $data['result']['status'] = 3333;
                $data['result']['message'] = $user_row;
            }
        }
        return view('user.login', $data);
    }
    public function premium_login($uparam='')
    {
        $this->handleUnpaidUser();
        $data['pageTitle'] = "Welcome to India macro advisors - Client login";
        $data['meta']['description']='India macro advisors - login';
        $data['meta']['keywords']='Sign up, register, subscribe, log in, user';
        $data['renderResultSet']=$data;
        if (!isset($_SESSION['fullredirect_redirecturl']) || $_SESSION['fullredirect_redirecturl'] == '') {
            $_SESSION['fullredirect_redirecturl'] = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : null;
        }
        if ($this->isUserLoggedIn() == true) {
            return redirect('user/myaccount');
        }
        if (isset($uparam['r']) && $uparam['r']!='') {
            $_SESSION['redirecturl'] = $uparam['r'];
        }
        // get all category items
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $AlaneeCommon = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
            }
        }
        $this->populateLeftMenuLinks();
        return view('user.login', $data);
    }
    public function loginbyajx($uparam='')
    {
        if ($this->isUserLoggedIn() == true) {
            // Return user details
            $userDetails = $_SESSION['user'];
            $data['status'] = 1;
            $data['message'] = 'OK';
            $data['result'] = array('userdetails'=>$userDetails);
        } elseif (count($_POST)>0) {
            $user = new User();
            $username = $_POST['login_email'];
            //$password = md5($_POST['login_password']);
            $password = $_POST['login_password'];
            $user_row = $user->check_user_status($username, $password);
            if (is_bool($user_row)) {
                $userDetails = $user->getUserDetailsByUserNameAndPassword($username, $password);
                $userDetails['password'] = '********';
                if (count($userDetails)>0 && isset($userDetails['id'])) {
                    //$userPermissions = new Userpermissions();
                    $_SESSION['user'] = $userDetails;
                    $data['status'] = 1;
                    $data['message'] = 'OK';
                    $data['result'] = array('userdetails'=>$userDetails);
                } else {
                    $data['status'] = 3333;
                    $data['message'] = 'Login failed. Please try again';
                }
            } else {
                $datat['status'] = 3333;
                $data['message'] = $user_row;
            }
        } else {
            $data['status'] = 3333;
            $data['message'] = 'Login failed. Please try again';
        }
        echo json_encode($data);
    }
    public function logout()
    {
        $path = "/";
        $rm = "";
        Cookie::queue(Cookie::forever('jmacrm', ''));
        Cookie::forget('jmacrm');
        $_SESSION['user'] = null;
        session_unset();
        session_destroy();
        $_SESSION = array();
        return redirect('/');
    }
    public function profile()
    {
        $this->handleUnpaidUser();
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $_SESSION['redirecturl'] = 'user/profile';
            $this->redirect('user/login');
        }
        $this->pageTitle = "Welcome to India macro advisors - My profile";
        // get all category items
        $media = new Media();
        $this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
        $AlaneeCommon = new Alaneecommon();
        if (count($this->renderResultSet['result']['rightside']['notice'])>0) {
            foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
            }
        }
        if (count($this->renderResultSet['result']['rightside']['media'])>0) {
            foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
            }
        }
        $this->populateLeftMenuLinks();
        $this->renderResultSet['result']['action'] = 'profile';
        $this->renderView();
    }
    public function updateCard()
    {
        $this->handleUnpaidUser();
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id']) && $_SESSION['user']['user_type']== 'individual') {
            return redirect('user/login');
        }
        //$this->pageTitle = "Welcome to India macro advisors - My profile";
        // get all category items
        $media = new Media();
        $renderResultSet['pageTitle']= "Welcome to India macro advisors - Card details";
        $renderResultSet['meta']['description']="India macro advisors - Card details";
        $renderResultSet['meta']['keywords']='Do payment, subscribe';
        $data['renderResultSet']=$renderResultSet;
        //$data['result']['country_list'] = $country->getCountryDatabase();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $datat['result']['rightside']['media'] = $media->getLatestMedia(5);
        $data['result']['stripe_publish_key'] = Config::read('stripe.'.Config::read('environment').'.publish_Key');
        $AlaneeCommon = new CommonClass();
        $this->populateLeftMenuLinks();
        if (isset($_POST['stripeToken'])) {
            $payment = new SubscriptionClass();
            $stripeToken = $_POST['stripeToken'];
            $customerId = $_SESSION['user']['stripe_customer_id'];
            $email = (isset($_SESSION['user']['email']) && $_SESSION['user']['email']!=null)?$_SESSION['user']['email']:$_SESSION['user']['email'];
            $paymentProcess = $payment->updateCustomer($customerId, $stripeToken);
            if (isset($paymentProcess)) {
                $data['result']['status'] = 4444;
                $data['result']['message'] = $paymentProcess;
                $mail = new PHPMailer();
                if (env('APP_ENV') == "development") {
                    $mail->IsMail();
                } else {
                    $mail->IsSMTP();
                }
                $mail->IsHTML(true);
                $notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
                $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
                $mail->clearAddresses();
                $mail->clearAttachments();
                $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->Subject = $notification_subject;
                $mail->Body = "User with below details have updated card details <p>Name : ".$_SESSION['user']['fname']." ".$_SESSION['user']['lname']."<br><br>Email : ".$_SESSION['user']['email']."<br><br>Customer Id: ".$customerId."</p><br><br>
					Thanks,<br>
					IMA Team.<br>";
                $mail->AddAddress($notification_to);
                $mail->Send();
            }
        }
        return view('user.updateCard', $data);
    }
    public function changepassword()
    {
        $this->handleUnpaidUser();
        $data['pageTitle'] = "Welcome to India macro advisors - Change password";
        $data['renderResultSet']=$data;
        // get all category items
        $return_array=array();
        if ($this->isUserLoggedIn() == true && count($_POST)>0) {
            $user_id = $_POST['user_id'];
            $old_password = $_POST['currentpassword'];
            $new_password = $_POST['newpassword'];
            $re_password = $_POST['confirm_newpassword'];
            if (trim($old_password) == '') {
                $return_array['error']='<font color="#ff0000">Current password cannot be empty.</font>';
                echo json_encode($return_array);
            } elseif (trim($new_password) == '') {
                $return_array['error']='<font color="#ff0000">Password cannot be empty.</font>';
                echo json_encode($return_array);
            } elseif (trim($re_password) == '') {
                $return_array['error']='<font color="#ff0000">Re-enter new password password.</font>';
                echo json_encode($return_array);
            } elseif ($new_password != $re_password) {
                $return_array['error']='<font color="#ff0000">Password donot match.</font>';
                echo json_encode($return_array);
            } else {
                $user = new user();
                $userDetails = $user->getUserDetailsByUserNameAndPassword($_SESSION['user']['email'], $old_password);
                if (empty($userDetails)) {
                    $return_array['error']='<font color="#ff0000">Old password is not matching.</font>';
                    echo json_encode($return_array);
                } else {
                    if ($user->updateProfilePassword($user_id, $new_password)) {
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
                        if (env('APP_ENV') == "development") {
                            $mail->IsMail();
                        } else {
                            $mail->IsSMTP();
                        }
                        $mail->IsHTML(true);
                        $mail->AddAddress($_SESSION['user']['email'], $_SESSION['user']['fname'].' '.$_SESSION['user']['lname']);
                        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->Subject = "Your login credentials for indiamacroadvisors";
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
    public function editprofile()
    {
        $this->handleUnpaidUser();
        if ($this->isUserLoggedIn() != true) {
            return redirect('user/login');
        } else {
            if (count($_POST)>0) {
                $signup_ts 		= $_POST['signup_ts'];
                if (!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
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
                    if ($user->updateProfile($userDetails)) {
                        $userprofile = $user->getUserDetailsById($user_id);
                        $userprofile['password'] = '********';
                        $_SESSION['user'] = $userprofile;
                        $this->setFlashMessage("Your profile has been updated.");
                    } else {
                        $this->setFlashMessage("<font color='#ff0000'>Error in updating your profile. Please try again.</font>");
                    }
                    return redirect('user/myaccount');
                } else {
                    return redirect('user/myaccount');
                }
            } else {
                return redirect('/user/login');
            }
        }
    }
    public function updateMyProfile()
    {
        $this->handleUnpaidUser();
        if ($this->isUserLoggedIn() != true) {
            $this->redirect('user/login');
        } else {
            if (count($_POST)>0) {
                $signup_ts 		= $_POST['signup_ts'];
                if (!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
                    $user_id = $_POST['user_id'];
                    $user_industry = $_POST['user_industry'];
                    $user_position = $_POST['user_position'];
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $country_id = $_POST['country_id'];
                    $phone = $_POST['phone'];
                    if (!isset($_POST['request_info'])) {
                        $user_upgrade_status = $_POST['request_info'];
                    } else {
                        if (count($_POST['request_info'])==2) {
                            $user_upgrade_status = 'RB';
                        } else {
                            if (in_array('premium', $_POST['request_info'])) {
                                $user_upgrade_status = 'RP';
                            } elseif (in_array('corporate', $_POST['request_info'])) {
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
                    if ($user->updateMyProfile($userDetails)) {
                        $userprofile = $user->getUserDetailsById($user_id);
                        $userprofile['password'] = '********';
                        $_SESSION['user'] = $userprofile;
                        if (isset($user_upgrade_status)) {
                            if ($user_upgrade_status == 'RP') {
                                $account = 'premium';
                            } elseif ($user_upgrade_status == 'RC') {
                                $account = 'corporate';
                            } elseif ($user_upgrade_status == 'RB') {
                                $account = 'both premium & corporate';
                            } else {
                                $account = '';
                            }
                            $mail = new PHPMailer();
                            if (env('APP_ENV') == "development") {
                                $mail->IsMail();
                            } else {
                                $mail->IsSMTP();
                            }
                            $mail->IsHTML(true);
                            $notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
                            $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
                            $mail->clearAddresses();
                            $mail->clearAttachments();
                            $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                            $mail->Subject = $notification_subject;
                            $mail->Body = "User with below details have requested for ".$account." account.<p>Name : ".$userprofile['fname']." ".$userprofile['lname']."<br><br>Email : ".$userprofile['email']."</p><br><br>
							  Thanks,<br>
								IMA Team.<br>";
                            $mail->AddAddress($notification_to);
                            $mail->Send();
                        }
                        $this->renderResultSet['result']['userdetails'] = $_SESSION['user'];
                        $this->setFlashMessage("Your profile has been updated.");
                    } else {
                        $this->setFlashMessage("<font color='#ff0000'>Error in updating your prifile. Please try again.</font>");
                    }
                    $this->redirect('user/editMyProfile');
                } else {
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
        if (!empty($_POST['alert_value'])) {
            $alertStatus = $user->updateEmailAlert($_SESSION['user']['id'], $_POST['alert_value'], $_POST['is_thematic']);
            return redirect('user/myaccount/update/'.$_POST['alert_type']);
        } elseif ($_POST['alert_value'] == "" &&  $_POST['is_thematic'] == "Y") {
            $alertStatus = $user->updateEmailAlert($_SESSION['user']['id'], $_POST['alert_value'], $_POST['is_thematic']);
            return redirect('user/myaccount/update/'.$_POST['alert_type']);
        } elseif ($_POST['alert_value'] == 0) {
            $alertStatus = $user->updateEmailAlert($_SESSION['user']['id'], $_POST['alert_value'], $_POST['is_thematic']);
            return redirect('user/myaccount/update/'.$_POST['alert_type']);
        }
    }
    public function newsletters()
    {
        $data['pageTitle']= "Client ,User,Economy Forgot Password?";
        $data['meta']['description']='India macro advisors - login';
        $data['meta']['keywords']='Sign up, register, subscribe, log in, user';
        $data['renderResultSet']=$data;
        $viewfile = '';
        // get all category items
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        if (count($_POST)>0) {
            $user = new User();
            $unsubscribe_ts = $_POST['unsubscribe_ts'];
            if (!empty($unsubscribe_ts) && $_SESSION['unsubscribe_ts'] == $unsubscribe_ts) {
                try {
                    $unsubscribe_email 	= $_POST['unsubscribe_email'];
                    if (empty($unsubscribe_email)) {
                        throw new Exception('Please enter your email', 9999);
                    } elseif (!filter_var($unsubscribe_email, FILTER_VALIDATE_EMAIL)) {
                        throw new Exception('Please enter a valid email', 9999);
                    } else {
                        if ($user->checkUserExistsByEmail($unsubscribe_email) == true) {
                            $user->unSubscribeThisUserByEmail($unsubscribe_email);
                            unset($_SESSION['unsubscribe_ts']);
                            $unsubscribe_ts	= '';
                            $viewfile = 'unsubscribe_mail_success';
                        } else {
                            throw new Exception('No matching email address found', 9999);
                        }
                    }
                } catch (Exception $ex) {
                    $data['status'] = 9999;
                    $data['message'] = $ex->getMessage();
                }
            }
        }
        return view('user.'.$viewfile, $data);
    }
    public function confirm_unsubscribe($params)
    {
        try {
            if (count($params) > 0) {
                $code = $params[0];
            } else {
                throw new Exception('Error..! authentication code missing.', 9999);
            }
            $this->pageTitle = "Welcome to India macro advisors - confirm unsubscribe";
            // get all category items
            $media = new Media();
            $this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
            $AlaneeCommon = new Alaneecommon();
            if (count($this->renderResultSet['result']['rightside']['notice'])>0) {
                foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
                    $rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
                }
            }
            if (count($this->renderResultSet['result']['rightside']['media'])>0) {
                foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
                    $rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
                }
            }
            $this->populateLeftMenuLinks();
            $unsubscribe_obj = new Unsubscribe();
            $userDetails = $unsubscribe_obj->getUnsubscribeRequestByCode($code);
            if (count($userDetails)>0 && isset($userDetails['user_id'])) {
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
    public function forgotpassword()
    {
        $data['pageTitle']= "Client ,User,Economy Forgot Password?";
        $data['meta']['description']='India macro advisors - login';
        $data['meta']['keywords']='Sign up, register, subscribe, log in, user';
        $data['renderResultSet']=$data;
        if (count($_POST)>0) {
            $user = new User();
            if (trim($_POST['forgotpasswd_email']) == '') {
                $data['result']['status'] = 404;
                $data['result']['message'] ="Please enter your email address";
            } elseif (!filter_var($_POST['forgotpasswd_email'], FILTER_VALIDATE_EMAIL)) {
                $data['result']['status'] = 404;
                $data['result']['message'] ="Please enter a valid email";
            }
            $userInfo = $user->getClientDetailsByEmail($_POST['forgotpasswd_email']);
            if (count($userInfo)==0) {
                $data['result']['status'] = 404;
                $data['result']['message'] ="No matching email address found";
            }
            if (count($userInfo)>0) {
                $verify = $user->Validate_Email_Verification($userInfo[0]['id']);
                if (!$verify) {
                    $data['result']['status'] = 404;
                    $data['result']['message'] = "Your account has not been activated please check your email for regarding activation. or contact to our admin";
                } else {
                    try {
                        $replace_mail_data=array(
                        'name' => $userInfo[0]['fname']." ".$userInfo[0]['lname'],
                        'email' => $userInfo[0]['email'],
                        'password' => $userInfo[0]['password']);
                        $Mailtemplate = new Mailtemplate();
                        $template = $Mailtemplate->getTemplateParsed('forgot_password', $replace_mail_data);
                        $mail = new PHPMailer();
                        if (env('APP_ENV') == "development") {
                            $mail->IsMail();
                        } else {
                            $mail->IsSMTP();
                        }
                        $mail->IsHTML(true);
                        $mail->AddAddress($_POST['forgotpasswd_email'], $userInfo[0]['fname'].' '.$userInfo[0]['lname']);
                        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->Subject = "Your login credentials for Indiamacroadvisors";
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                        $mail->Body = $template['message'];
                        $mail->WordWrap = 50;
                        $mail->Send();
                        $data['result']['message'] =
                        "Dear ". $userInfo[0]['fname'].",<br><br>We have sent your login credentials to <b>".$_POST['forgotpasswd_email']."</b> .<br><br>
					  If you are still having problem logging into your account, please write to us to <b><i>support@indiamacroadvisors.com</i>.</b><br><br>
					  Thanks,<br>
						IMA Team.<br>";
                    } catch (phpmailerException $e) {
                        throw new Exception($e->getMessage(), $e->getCode());
                    }
                    return view('user.forgotpassword_success', $data);
                }
            }
        }
        return view('user.forgotpassword', $data);
    }
    public function updatepaymentresponse_success_old($params, $kv_params)
    {
        try {
            $this->populateLeftMenuLinks();
            if ($_SESSION['user']['id'] != $kv_params['uid']) {
                throw new Exception("Error..! Un-identified user", 9999);
            } else {
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
                if (strtoupper($paymentDetails['ACK'])=='SUCCESS') {
                    $payer_id = $paymentDetails['PAYERID'];
                    $final_amount = (string)$_SESSION['user']['payment_transaction']['amount'];
                    $new_expiry_date = strtotime("+1 month", time()); //$_SESSION['user']['expiry_on'] + (30 * 24 * 60 * 60);
                    if ($paypal->confirmPaymentAndInitiateSubscription($uid, $order_id, $transaction_id, $payment_paypal_token, $payer_id, $final_amount, $user_email, $user_name, $new_expiry_date) == true) {
                        //$new_expiry_date = strtotime("+1 months");
                        $user = new User();
                        $user->setExpiryOnDate($_SESSION['user']['id'], $new_expiry_date);
                        $_SESSION['user']['expiry_on'] = $new_expiry_date;
                        //$user->setThisUserStatus($_SESSION['user']['id'],'active');
                        $user->setThisUserToPremium($_SESSION['user']['id']); // upgrade to premium
                        $user->setThisUserUpgradeStatus($_SESSION['user']['id'], 'XP'); //Accepted premium
                        $paymentTransaction = new Paymenttransaction();
                        $paymentTransaction->updatePaymentStatus($payment_transaction_id, "OK");
                        $_SESSION['user'] = $user->getUserDetailsById($_SESSION['user']['id']);
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
        $media = new Media();
        $this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
        $this->renderView();
    }
    public function updatepaymentresponse_cancel_old($params, $kv_params)
    {
        try {
            $this->populateLeftMenuLinks();
            if ($_SESSION['user']['id'] != $kv_params['uid']) {
                throw new Exception("Error..! Un-identified user", 9999);
            } else {
                $payment_transaction_id = $kv_params['tid'];
                $paymentTransaction = new Paymenttransaction();
                $paymentTransaction->updatePaymentStatus($payment_transaction_id, "FAILED");
            }
        } catch (Exception $ex) {
        }
        $media = new Media();
        $this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
        $this->renderView();
    }
    public function myaccount11($params)
    {
        $this->handleUnpaidUser();
        //	$subscription = new Subscription();
        //	$subscription->unitTest();
        $user = new User();
        $tabname = isset($params[0]) ? $params[0] : 'profile';
        if ($tabname == 'subscription' && isset($_POST['request_info']) && isset($_POST['signup_ts']) && $_SESSION['signup_ts'] == $_POST['signup_ts']) {
            if (!isset($_POST['request_info'])) {
                $user_upgrade_status = $_POST['request_info'];
            } else {
                if (count($_POST['request_info'])==2) {
                    $user_upgrade_status = 'RB';
                } else {
                    if (in_array('premium', $_POST['request_info'])) {
                        $user_upgrade_status = 'RP';
                    } elseif (in_array('corporate', $_POST['request_info'])) {
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
            if ($user->updateMyProfile($userDetails)) {
                $userDetails = $user->getUserDetailsById($_SESSION['user']['id']);
                $userDetails['password'] = '********';
                $_SESSION['user'] = $userDetails;
                // Send notification mail
                if ($user_upgrade_status == 'RP') {
                    $account = 'premium';
                } elseif ($user_upgrade_status == 'RC') {
                    $account = 'corporate';
                } elseif ($user_upgrade_status == 'RB') {
                    $account = 'both premium & corporate';
                } else {
                    $account = '';
                }
                $mail = new PHPMailer();
                if (env('APP_ENV') == "development") {
                    $mail->IsMail();
                } else {
                    $mail->IsSMTP();
                }
                $mail->IsHTML(true);
                $notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
                $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
                $mail->clearAddresses();
                $mail->clearAttachments();
                $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->Subject = $notification_subject;
                $mail->Body = "User with below details have requested for ".$account." account.<p>Name : ".$userDetails['fname']." ".$userDetails['lname']."<br><br>Email : ".$userDetails['email']."</p><br><br>
							  Thanks,<br>
								IMA Team.<br>";
                $mail->AddAddress($notification_to);
                $mail->Send();
            }
        }
        try {
            $this->populateLeftMenuLinks();
            if ($this->isUserLoggedIn() == true) {
                $country = new Country();
                $this->renderResultSet['result']['userdetails'] = $user->getUserDetailsById($_SESSION['user']['id']);
                $this->renderResultSet['result']['country_list'] = $country->getCountryDatabaseAsArray();
                $this->renderResultSet['result']['country_list1'] = $country->getCountryDatabase();
                $this->renderResultSet['result']['tabname'] = $tabname;
                $payment_history = $user->get_payment_history($_SESSION['user']['id']);
                $this->renderResultSet['result']['payment_history'] = $payment_history;
            } else {
                $this->redirect('user/login?r=user/myaccount/subscription');
            }
        } catch (Exception $ex) {
        }
        $this->renderView();
    }
    public function cancelmysubscription()
    {
        /**
         * Not in use
         * Used for paypal recurrent payment cancellation
         */
        try {
            if ($this->isUserLoggedIn() == true) {
                $recurrent_profile_id = $_SESSION['user']['recurrent_profile_id'];
                if ($recurrent_profile_id != '') {
                    $paypal = new Paypal();
                    if ($paypal->suspendRecurrentProfile($recurrent_profile_id) == true) {
                        $user = new User();
                        $uid = $_SESSION['user']['id'];
                        $user->setThisUserStatus($uid, 'expired');
                        $_SESSION['user'] = $user->getUserDetailsById($uid);
                        $this->setFlashMessage("Your subscription status is changed to Expired.");
                        $this->redirect('/user/myaccount');
                    } else {
                        throw new Exception("Error..!. Couldn't update your subscription status.", 9999);
                    }
                } else {
                    throw new Exception("Error..! Error in identifying subscription payment status.", 9999);
                }
            } else {
                $this->redirect('user/login');
            }
        } catch (Exception $ex) {
            $this->setFlashMessage("<font color='#ff0000'>".$ex->getMessage()."</font>");
            $this->redirect('/user/myaccount');
        }
    }
    public function reactivatemysubscription()
    {
        try {
            if ($this->isUserLoggedIn() == true) {
                $recurrent_profile_id = $_SESSION['user']['recurrent_profile_id'];
                if ($recurrent_profile_id != '') {
                    $paypal = new Paypal();
                    if ($paypal->reactivateRecurrentProfile($recurrent_profile_id) == true) {
                        $user = new User();
                        $uid = $_SESSION['user']['id'];
                        $user->setThisUserStatus($uid, 'active');
                        $_SESSION['user'] = $user->getUserDetailsById($uid);
                        $this->setFlashMessage("Your subscription is activated successfully.");
                        $this->redirect('/user/myaccount');
                    } else {
                        throw new Exception("Error..!. Couldn't activate your subscription.", 9999);
                    }
                } else {
                    throw new Exception("Error..! Error in identifying subscription payment status.", 9999);
                }
            } else {
                $this->redirect('user/login');
            }
        } catch (Exception $ex) {
            $this->setFlashMessage("<font color='#ff0000'>".$ex->getMessage()."</font>");
            $this->redirect('/user/myaccount');
        }
    }
    public function test()
    {
        $Mailtemplate = new Mailtemplate();
        $data = array(
            'name' => 'shijo thomas',
            'username' => 'shijosap',
            'password' => '123@123',
            'activation_link' => 'jma.com'
        );
        $template = $Mailtemplate->getTemplateParsed('reg_confirm_activation', $data);
        //echo '<pre>';
        print_r($template);
        exit;
    }
    /* By veera*/
    /*  User Deactiavate account */
    public function user_deactivate()
    {
        $media = new Media();
        $this->populateLeftMenuLinks();
        $this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
        $user = new User();
        $id = $_SESSION['user']['id'];
        if (isset($_POST['submit'])) {
            if ($_POST['submit']=='individual') {
                $message='We have received your request for cancellation of Premium account subscription.Your Premium Account subscription will discontinue on your next renewal and you will become our Free account user.You could login to our website and access to all free contents';
                $update=$user->user_deactivate(1, $id);
                $this->downgrade_success_send_mail($id);
            } elseif ($_POST['submit']=='corporate') {
                $message='We have received your request for cancellation of Corporate account subscription.Your Corporate Account subscription will discontinue on your next renewal and you will become our Free account user.You could login to our website and access to all free contents';
                $update=$user->user_deactivate(1, $id);
                $update=$user->setThisUserStatus($id, 'active');
                $this->downgrade_success_send_mail($id);
            } else {
                $message='Your account has been permanently deleted from our site';
                $update=$user->user_deactivate(2, $id);
                $this->logout();
            }
            if ($update) {
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
    public function user_pay_downgrade()
    {
        if (isset($_SESSION['user'])) {
            $media = new Media();
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);
            $user = new User();
            $id = $_SESSION['user']['id'];
            if (isset($_POST['submit'])) {
                if ($_POST['submit']=='free') {
                    $message='Successfully you are downgrade to "FREE" user';
                    $update=$user->user_deactivate(1, $id);
                    $update=$user->setThisUserStatus($id, 'active');
                    $this->setFlashMessage($message);
                    header("Refresh:3; url='myaccount'");
                }
            }
            $userDetails = $user->getUserDetailsById($id);
            $userDetails['password'] = '********';
            $_SESSION['user'] = $userDetails;
            $data['result']['userdetails'] = $_SESSION['user'];
            $this->renderView();
        } else {
            $this->logout();
        }
    }
    public function user_type_upgrade()
    {
        /**
         * Handle upgrade
         * @author : Veera
         * Change statuses
         * 1 user type : 2 (individual)
         * status : 7 (unpaid)
         * Forward to do payment
         */
        if (isset($_SESSION['user_type_upgrade'])) {
            unset($_SESSION['user_type_upgrade']);
        }
        if (isset($_SESSION['temp_user'])) {
            unset($_SESSION['temp_user']);
        }
        if (isset($_SESSION['OAUTH_ACCESS_TOKEN'])) {
            unset($_SESSION['temp_user']);
        }
        $user = new User();
        $email = $_SESSION['user']['email'];
        $getUserDetails = $user->getUserDetailsByEmail($email);
        if ($getUserDetails[0]['user_type_id'] == 1 && $getUserDetails[0]['user_status_id'] == 4) {
            if ($getUserDetails[0]['stripe_subscription_id'] != null && Config::read('environment')=='production' && ($_SESSION['user']['user_id']==508 || $_SESSION['user']['user_id']==561)) {
                $id = $_SESSION['user']['id'];
                $update=$user->setThisUserToPremium($id);
                $subscription = new SubscriptionClass();
                $upgradeSubscriptionProcess = $subscription->upgradeSubscription($getUserDetails[0]['stripe_customer_id']);
                if ($upgradeSubscriptionProcess->id) {
                    //send success mail
                    $userDetails = $user->getUserDetailsById($id);
                    $userDetails['password'] = '********';
                    $_SESSION['user'] = $userDetails;
                    $this->payment_success_send_mail($_SESSION['user']['id']);
                    $this->setFlashMessage('Upgarde');
                    return redirect('user/payment_success');
                } else {
                    $this->setFlashMessage('Upgrade Failed');
                    return redirect('user/myaccount');
                }
            } else {
                $id = $_SESSION['user']['id'];
                //$_SESSION['user']=$getUserDetails;
                $_SESSION['user_type_upgrade']=1;
                return redirect('/user/dopayment');
            }
        } else {
            return redirect('user/myaccount');
        }
    }
    private function user_upgrade_mail($id)
    {
        $user = new User();
        $user_details = $user->getUserDetailsById($id);
        $user_type=($user_details['user_type']=='individual')?"Premium":ucfirst($user_details['user_type']);
        $mail = new PHPMailer();
        if (env('APP_ENV') == "development") {
            $mail->IsMail();
        } else {
            $mail->IsSMTP();
        }
        $mail->IsHTML(true);
        $notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
        $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
        $mail->clearAddresses();
        $mail->clearAttachments();
        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
        $mail->Subject = $notification_subject;
        $mail->Body = "User with below details has upgraded to Premium account.<p>Name : ".$user_details['fname']." ".$user_details['lname']."<br><br>Email : ".$user_details['email']."<br><br>Subscription Type: ".$user_type."</p><br><br>
					Thanks,<br>
					JMA Team.<br>";
        $mail->AddAddress($notification_to);
        $mail->Send();
    }
    public function myaccount($params=null, $firstParam=null)
    {
        $this->handleUnpaidUser();
        $data['pageTitle']= "Client ,User,Myaccount";
        $data['meta']['description']='India macro advisors - Myaccount';
        $data['meta']['keywords']='User Myaccount';
        $data['renderResultSet']=$data;
        $user = new User();
        $tabname = ($params!='') ? $params : 'profile';
        $firstParam =($firstParam!='') ? $firstParam : 'profile';
        if ($tabname == 'subscription' && isset($_POST['request_info']) && isset($_POST['signup_ts']) && $_SESSION['signup_ts'] == $_POST['signup_ts']) {
            if (!isset($_POST['request_info'])) {
                $user_upgrade_status = $_POST['request_info'];
            } else {
                if (count($_POST['request_info'])==2) {
                    $user_upgrade_status = 'RB';
                } else {
                    if (in_array('premium', $_POST['request_info'])) {
                        $user_upgrade_status = 'RP';
                    } elseif (in_array('corporate', $_POST['request_info'])) {
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
            if ($user->updateMyProfile($userDetails)) {
                $userDetails = $user->getUserDetailsById($_SESSION['user']['id']);
                $userDetails['password'] = '********';
                $_SESSION['user'] = $userDetails;
                // Send notification mail
                if ($user_upgrade_status == 'RP') {
                    $account = 'premium';
                } elseif ($user_upgrade_status == 'RC') {
                    $account = 'corporate';
                } elseif ($user_upgrade_status == 'RB') {
                    $account = 'both premium & corporate';
                } else {
                    $account = '';
                }
                $mail = new PHPMailer();
                if (env('APP_ENV') == "development") {
                    $mail->IsMail();
                } else {
                    $mail->IsSMTP();
                }
                $mail->IsHTML(true);
                $notification_to = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_to');
                $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.upgradeRequest_notification_subject');
                $mail->clearAddresses();
                $mail->clearAttachments();
                $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                $mail->Subject = $notification_subject;
                $mail->Body = "User with below details have requested for ".$account." account.<p>Name : ".$userDetails['fname']." ".$userDetails['lname']."<br><br>Email : ".$userDetails['email']."</p><br><br>
				Thanks,<br>
				JMA Team.<br>";
                $mail->AddAddress($notification_to);
                $mail->Send();
            }
        }
        try {
            if ($this->isUserLoggedIn() == true) {
                $country = new Country();
                $data['result']['userdetails'] = $user->getUserDetailsById($_SESSION['user']['id']);
                $data['result']['country_list'] = $country->getCountryDatabaseAsArray();
                $data['result']['country_list1'] = $country->getCountryDatabase();
                $data['result']['emailAlert_category'] = $user->emailAlertCategory();
                $data['result']['emailAlert_choiceofUsers'] = $user->emailAlertChoiceofUsers($_SESSION['user']['email']);
                $data['result']['tabname'] = $tabname;
                $data['result']['firstParam'] = $firstParam;
                $data['result']['defaultEmailAlert'] = $user->defaultEmailAlert();
                $payment_history = $user->get_payment_history($_SESSION['user']['id']);
                $data['result']['payment_history'] = $payment_history;
            } else {
                $tabname = ($params!='') ? $params : 'profile';
                if ($tabname == "email-alert") {
                    return redirect('user/login?r=user/myaccount/email-alert');
                } else {
                    return redirect('user/login?r=user/myaccount/subscription');
                }
            }
        } catch (Exception $ex) {
        }
        return view('user.myaccount', $data);
    }
    public function unsubscribe_user($params)
    {
        $firstParam = isset($params) ? base64_decode($params) : '';
        $this->handleUnpaidUser();
        $data['pageTitle'] = "Welcome to India macro advisors";
        $data['meta']['description']='India macro advisors - Sign up';
        $data['meta']['keywords']='Sign up, register, subscribe';
        $data['renderResultSet']=$data;
        $user = new User();
        if (!empty($user->getUserDetailsByEmail($firstParam))) {
            $data['result']['emailAlert_category'] = $user->emailAlertCategory();
            $data['result']['emailAlert_choiceofUsers'] = $user->emailAlertChoiceofUsersWithEmail($firstParam);
            $data['result']['userdetails'] = $user->getUserDetailsByEmail($firstParam);
            $data['result']['firstParam'] = $firstParam;
            $data['result']['defaultEmailAlert'] = $user->defaultEmailAlert();
            return view('user.unsubscribe_user', $data);
        } else {
            //$this->error(404);
            new ErrorController(404);
        }
    }
    public function mailAlertUpdateWithoutLogin()
    {
        $user = new User();
        if (!empty($_POST['alert_value'])) {
            $alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'], $_POST['alert_value'], $_POST['is_thematic']);
            return redirect('user/unsubscribe_update_sccess/');
        } elseif ($_POST['alert_value'] == "" &&  $_POST['is_thematic'] == "Y") {
            $alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'], $_POST['alert_value'], $_POST['is_thematic']);
            return redirect('user/unsubscribe_update_sccess/');
        } elseif ($_POST['alert_value'] == 0) {
            $alertStatus = $user->updateEmailAlertForRepoet($_POST['alert_type'], $_POST['alert_value'], $_POST['is_thematic']);
            return redirect('user/unsubscribe_update_sccess/');
        }
    }
    public function unsubscribe_user_encode($params)
    {
        $firstParam = isset($params) ? $params : '';
        return redirect('user/unsubscribe_user/'.base64_encode($firstParam));
    }
    public function unsubscribe_update_sccess()
    {
        $this->handleUnpaidUser();
        $data['pageTitle'] = "Welcome to India macro advisors";
        $data['meta']['description']='India macro advisors - Sign up';
        $data['meta']['keywords']='Sign up, register, subscribe';
        $data['renderResultSet']=$data;
        return view('user.unsubscribe_update_sccess', $data);
    }
    public function registercompetition($params=null)
    {
        /*  $user = new User();
         if(isset($_SESSION['user']) && is_array($_SESSION['user'])){
             if($user->getCompetitionUserById($_SESSION['user']['id'])){
                 return redirect('/');
             }else{
                 return redirect('user/registercompetition/login');
             }
         } */
        $firstParam = isset($params) ?$params: '';
        $this->handleUnpaidUser();
        if ($firstParam !="login") {
            $country = new Country();
            $media = new Media();
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);
            $data['pageTitle'] = "Welcome to India macro advisors";
            $data['meta']['description']='India macro advisors - Sign up';
            $data['meta']['keywords']='Sign up, register, subscribe';
            $data['renderResultSet']=$this->renderResultSet;
            $CommonClass = new CommonClass();
            $user = new User();
            $country = new Country();
            $media = new Media();
            $user_position = $user->getPositionsDatabase();
            $user_industry = $user->getIndustryDatabase();
            $data['result']['user_position'] = $user_position;
            $data['result']['user_industry'] = $user_industry;
            $data['result']['country_list'] = $country->getCountryDatabase();
            $data['result']['signup_error_id'] = '';
            $data['result']['postdata'] = null;
            $error = false;
            if (isset($_POST['signup_btn'])) {
                //dd($_POST);
                $data['result']['postdata'] = $_POST;
                $signup_ts 		= $_POST['signup_ts'];
                if (!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
                    //unset($_SESSION['signup_ts']);
                    $OtherTilteFlag=false;
                    $user_group = $_POST['user_group'];
                    $no_of_group = isset($_POST['No_of_group'])?trim($_POST['No_of_group']):"0";
                    $groupname = $_POST['groupname'];
                    $collegename = $_POST['Collegename'];
                    $user_title = $_POST['user_title'];
                    $OtherTitle=trim($_POST['OtherTitle']);
                    $fname = trim($_POST['fname']);
                    $lname = trim($_POST['lname']);
                    $email = trim($_POST['email']);
                    $country_id = "101";
                    $phonecode = "+91";
                    $country_code = "+91";
                    $phone = trim($_POST['phone']);
                    $user_position_id = 0;
                    $user_industry_id = 0;
                    $user_type = "free";
                    $user_type_id=($user_type=='premium')?2:1;
                    $user_status_id=2;
                    /*if($user_title == ''){
                        $this->renderResultSet['status'] = 3333;
                        $this->renderResultSet['message'] = 'Please enter Title';
                        $this->renderResultSet['result']['signup_error_id']	= '#user_title_id';
                        $error = true;
                    }*/
                    if ($user_title =="Other" && $OtherTitle == '') {
                        $data['status'] = 3333;
                        $data['message'] = 'Please enter Title';
                        $data['result']['signup_error_id']	= '#user_title_id';
                        $error = true;
                    } elseif (empty($fname)) {
                        $data['status'] = 3333;
                        $data['message'] = 'Please enter first name';
                        $data['result']['signup_error_id']	= '#reg_first_name';
                        $error = true;
                    } elseif (empty($lname)) {
                        $data['status'] = 3333;
                        $datat['message'] = 'Please enter last name';
                        $data['result']['signup_error_id']	= '#reg_last_name';
                        $error = true;
                    } elseif (empty($email)) {
                        $data['status'] = 3333;
                        $data['message']= 'Please enter email';
                        $data['result']['signup_error_id']	= '#reg_email';
                        $error = true;
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $data['status'] = 3333;
                        $data['message'] = 'Please enter a valid email';
                        $data['result']['signup_error_id']	= '#reg_email';
                        $error = true;
                    } elseif ($user->checkUserExistsByEmail($email)) {
                        $data['status'] = 3333;
                        $data['message'] = 'User already registerd with this email, please try another email. ';
                        $data['result']['signup_error_id']	= '#reg_email';
                        $error = true;
                    } else {
                        if ($user_title =="Other") {
                            $user_title = $OtherTitle;
                        }
                        //expiry_on
                        $registered_on = time();
                        $expiry_on=($user_type=='premium')?strtotime("+1 months", time()):0;
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $reg_password = $CommonClass->createPassword(8);
                        // User upgrade status
                        if ($user_type=='corporate') {
                            $user_upgrade_status = 'RC';
                        } else {
                            $user_upgrade_status = 'NU';
                        }
                        $defultAlertID = $user->defaultEmailAlert();
                        $defultAlertValue = implode(",", $defultAlertID);
                        $userDetails = array(
                                    'user_title' => $user_title,
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
                        if ($user_type_id==2) { //check user_type start
                            $_SESSION['temp_user'] = $userDetails;
                            return redirect('user/dopayment/');
                        } //check user_type end
                            if ($user_type_id!=2) { //check user_type start
                            $u_details = $user->addUserRegistration($userDetails);
                                $competitionUserDetails = array(
                            'account_user_id' => $u_details['id'],
                            'group_type' => $user_group,
                            'group_numbers' => ($no_of_group =="")?$no_of_group:"0",
                            'group_name' => $groupname,
                            'college_name' => $collegename,
                            );
                                $cu_details = $user->addCompetitionUserRegistration($competitionUserDetails);
                                $user_details = $user->getUserDetailsById($u_details['id']);
                                $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'), '/') : '';
                                if ($evenPath == "production") {
                                    $MailGunAPI = new MailGunAPI();
                                    $MailGunAPI->addNewUserMailGunListingAddress($email, $fname);
                                }
                                try {
                                    $appPath = Config::read('appication_path') != '' ? '/'.trim(Config::read('appication_path'), '/') : '';
                                    $activation_link = 'http://'.$_SERVER['HTTP_HOST'].$appPath.'/user/confirmregistration/'.base64_encode($email);
                                    $mail = new PHPMailer();
                                    if (env('APP_ENV') == "development") {
                                        $mail->IsMail();
                                    } else {
                                        $mail->IsSMTP();
                                    }
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
                                    $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                                    $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                                    $mail->Subject = $template['subject'];
                                    $mail->Body = $template['message'];
                                    $mail->AddAddress($user_details['email'], $user_details['fname'].' '.$user_details['lname']);
                                    $mail->Send();
                                } catch (Exception $e) {
                                    $data['status'] = 9999;
                                    $data['message'] = 'Error...! '.$e->getMessage();
                                    $error == true;
                                }
                                $data['result']['user_details'] = $user_details;
                                // Send notification mail
                                try {
                                    $notification_to = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_to');
                                    $notification_subject = Config::read('mailconfig.'.Config::read('environment').'.newuser_notification_subject');
                                    $mail->clearAddresses();
                                    $mail->clearAttachments();
                                    $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                                    $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                                    $mail->Subject = $notification_subject;
                                    $n_user_type=($user_type!="premium")?"Free":"Premium";
                                    $phonedetails=($phone!='')?$phonecode.$phone:'';
                                    $notify_body_msg= "A new ".$n_user_type." user signed up with us on.<p>Name : ".ucfirst($fname)." ".ucfirst($lname)."<br><br>Email : ".$email."<br><br>Phone : ".$phonedetails."";
                                    if ($user_type=='corporate') {
                                        $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
                                    }
                                    $mail->Body =$notify_body_msg;
                                    $mail->AddAddress($notification_to);
                                    $mail->Send();
                                } catch (Exception $e) {
                                    $data['status'] = 9999;
                                    $data['message'] = 'Error...! '.$e->getMessage();
                                    $error == true;
                                }
                                try {
                                    $mail = new PHPMailer();
                                    if (env('APP_ENV') == "development") {
                                        $mail->IsMail();
                                    } else {
                                        $mail->IsSMTP();
                                    }
                                    $mail->IsHTML(true);
                                    $mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
                                $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                                $mail->WordWrap = 50;
                                    $Mailtemplate = new Mailtemplate();
                                    if ($user_group == 0) {
                                        $user_groups = "Indiviual";
                                        $no_of_persons = "No";
                                    } else {
                                        $user_groups = "Group";
                                        $no_of_persons = $no_of_group;
                                    }
                                    $mail_data = array(
                                        'type_group' => $user_groups,
                                        'no_of_group' => $no_of_persons,
                                        'group_name' => $groupname,
                                        'college_name' => $collegename
                                );
                                    $template = $Mailtemplate->getTemplateParsed('competition_user_details', $mail_data);
                                    $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                                    $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                                    $mail->Subject = $template['subject'];
                                    $mail->Body = $template['message'];
                                    $mail->AddAddress('erteam@indiamacroadvisors.com', 'IMA Economic Team');
                                    $mail->Send();
                                } catch (Exception $e) {
                                    $data['status'] = 9999;
                                    $data['message'] = 'Error...! '.$e->getMessage();
                                    $error == true;
                                }
                            }//check user_type end
                    }
                    $render = true;
                    if ($error == true) {
                        return view('user.registercompetition', $data);
                    } else {
                        if ($user_type_id!=2) { //check user_type start
                            $flash_arr = array('user_id'=>$u_details['id']);
                            $this->setFlashMessage($flash_arr);
                            return redirect('user/completeregistration_success');
                        }//check user_type end
                    }
                } else {
                    return view('user.registercompetition', $data);
                }
            }
            return view('user.registercompetition', $data);
        } else {
            $user = new User();
            $country = new Country();
            $media = new Media();
            $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
            $data['result']['rightside']['media'] = $media->getLatestMedia(5);
            if (isset($_SESSION['user']) && $_SESSION['user']['id'] >0) {
                $check_exits_register_competition = $user->getCompetitionUserById($_SESSION['user']['id']);
                if ($check_exits_register_competition == true) {
                    return redirect('/page/ideapitchcompetition/');
                    exit;
                }
            } else {
                return redirect('/user/completeregistration_success');
            }
            $data['pageTitle'] = "Welcome to India macro advisors";
            $data['meta']['description']='India macro advisors - Sign up';
            $data['meta']['keywords']='Sign up, register, subscribe';
            $data['renderResultSet']=$this->renderResultSet;
            $CommonClass = new CommonClass();
            $error = false;
            if (isset($_POST['competition_login_btn'])) {
                $signup_ts 		= $_POST['signup_ts'];
                if (!empty($signup_ts) && $_SESSION['signup_ts'] == $signup_ts) {
                    $user_group = $_POST['user_group'];
                    $no_of_group = isset($_POST['No_of_group'])?trim($_POST['No_of_group']):"0";
                    $groupname = $_POST['groupname'];
                    $collegename = $_POST['Collegename'];
                    $competitionUserDetails = array(
                                'account_user_id' => $_SESSION['user']['id'],
                                'group_type' => $user_group,
                                'group_numbers' => ($no_of_group =="")?$no_of_group:"0",
                                'group_name' => $groupname,
                                'college_name' => $collegename,
                                );
                    $cu_details = $user->addCompetitionUserRegistration($competitionUserDetails);
                    try {
                        $mail = new PHPMailer();
                        if (env('APP_ENV') == "development") {
                            $mail->IsMail();
                        } else {
                            $mail->IsSMTP();
                        }
                        $mail->IsHTML(true);
                        $mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
                                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                                    $mail->WordWrap = 50;
                        $Mailtemplate = new Mailtemplate();
                        if ($user_group == 0) {
                            $user_groups = "Indiviual";
                            $no_of_persons = "No";
                        } else {
                            $user_groups = "Group";
                            $no_of_persons = $no_of_group;
                        }
                        $mail_data = array(
                                            'type_group' => $user_groups,
                                            'no_of_group' => $no_of_persons,
                                            'group_name' => $groupname,
                                            'college_name' => $collegename
                                    );
                        $template = $Mailtemplate->getTemplateParsed('competition_user_details', $mail_data);
                        $mail->SetFrom('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->AddReplyTo('info@indiamacroadvisors.com', 'indiamacroadvisors.com');
                        $mail->Subject = $template['subject'];
                        $mail->Body = $template['message'];
                        $mail->AddAddress('erteam@indiamacroadvisors.com', 'IMA Economic Team');
                        $mail->Send();
                    } catch (Exception $e) {
                        $data['status'] = 9999;
                        $data['message'] = 'Error...! '.$e->getMessage();
                        $error == true;
                    }
                }
                if ($error == true) {
                    return view('user.registercompetitionlogin', $data);
                } else {
                    $flash_arr = array('user_id'=>$_SESSION['user']['id'],'existing'=>'no');
                    $this->setFlashMessage($flash_arr);
                    return redirect('user/completeregistration_success');
                }
            } else {
                return view('user.registercompetitionlogin', $data);
            }
        }
        return view('user.registercompetitionlogin', $data);
    }
    /* PayPal */
    public function dopayment_paypal()
    {
        if (!isset($_SESSION['temp_user']) && !isset($_SESSION['user'])) {
            return redirect('user/login?r=user/dopayment');
        }
        $this->clearSessions();
        try {
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
                'EMAIL' => (isset($_SESSION['temp_user']['email']) && $_SESSION['temp_user']['email']!=null)?$_SESSION['temp_user']['email']:$_SESSION['user']['email'],
                'PAYMENTREQUEST_0_SHIPTOPHONENUM' => (isset($_SESSION['temp_user']['phone']) && $_SESSION['temp_user']['phone']!=null)?$_SESSION['temp_user']['phone']:$_SESSION['user']['email']
            );
            $order_id = 'JMA-STD-SUB-'.time();
            $transaction_id = $transaction_params['payment_transaction_id'];
            $_SESSION['payment_transaction']=$transaction_params;
            $payment_token = $paypal->createExpressCheckout($order_id, $transaction_id, $parms);
            $_SESSION['payment_transaction']['payment_token']=$payment_token;
            # print_r($payment_token);die;
            if (!is_array($payment_token) && $payment_token!='') {
                $paypal_url = Config::read('paypal.'.Config::read('environment').'.payment_url').$payment_token;
                return redirect($paypal_url);
            //header("location: ".$paypal_url);
            } else {
                return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $payment_token);
            }
        } catch (Exception $ex) {
            $paymentDetailsErr['MESSAGE']="Error..! Please reload page.".$ex->getMessage();
            return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $paymentDetailsErr);
        }
    }
    public function updatepaymentresponse_success()
    {
        try {
            if (is_array($_REQUEST) && empty($_REQUEST)) {
                return redirect('/');
            }
            $order_id = $_REQUEST['oid'];
            $transaction_id = $_REQUEST['tid'];
            $paypal = new PaypalClass();
            $payment_paypal_token = $_REQUEST['token'];
            $user_email=(isset($_SESSION['temp_user']['email']) && $_SESSION['temp_user']['email']!=null)?$_SESSION['temp_user']['email']:$_SESSION['user']['email'];
            $user_name=(isset($_SESSION['temp_user']['fname']) && $_SESSION['temp_user']['fname']!=null)?$_SESSION['temp_user']['fname'].' '.$_SESSION['temp_user']['lname']:$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'];
            $payment_transaction_id = Session::get('payment_transaction.payment_transaction_id');
            $paymentDetails = $paypal->getPaymentInfoAndStatus($order_id, $transaction_id, $payment_paypal_token);
            #print_r($paymentDetails);
            if (strtoupper($paymentDetails['ACK'])=='SUCCESS') {
                $payer_id = $paymentDetails['PAYERID'];
                $final_amount = (string) Config::read('subscription.amount');
                $new_expiry_date = strtotime("+1 month", time());
                $profile_id=$paypal->confirmPaymentAndInitiateSubscription($uid=0, $order_id, $transaction_id, $payment_paypal_token, $payer_id, $final_amount, $user_email, $user_name, $new_expiry_date);
                if (!is_array($profile_id) && $profile_id!='') {
                    $this->paypal_paid_user_insertion();
                    $user = new User();
                    $user->updatePaypalRecurrentprofileId($_SESSION['user']['id'], $profile_id);
                    $user->setExpiryOnDate($_SESSION['user']['id'], $new_expiry_date);
                    $_SESSION['user']['expiry_on']=$new_expiry_date;
                    $user->setThisUserUpgradeStatus($_SESSION['user']['id'], 'XP'); //Accepted premium
                    $this->payment_status_mail($_SESSION['user']['id'], 'success');
                    $action = 'Paypal - CreateRecurringPaymentsProfile';
                    $data = ($_SERVER['QUERY_STRING']);
                    $transaction_id='null';
                    $createUserStripeLog = $user->addlog($_SESSION['user']['id'], $transaction_id, $order_id, $action, $data);
                    $this->clearSessions();
                    return redirect('user/payment_success');
                } else {
                    if (isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']==1) {
                        $this->payment_status_mail($_SESSION['user']['id'], 'error');
                    }
                    return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $profile_id);
                }
            } else {
                if (isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']==1) {
                    $this->payment_status_mail($_SESSION['user']['id'], 'error');
                }
                return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $paymentDetails);
            }
        } catch (Exception $ex) {
            $paymentDetailsErr['MESSAGE']="Error..! Please reload page.".$ex->getMessage();
            return redirect('user/updatepaymentresponse_cancel?error=true')->with('PaypalError', $paymentDetailsErr);
        }
    }
    private function clearSessions()
    {
        if (isset($_SESSION['payment_transaction']) && !empty($_SESSION['payment_transaction'])) {
            unset($_SESSION['payment_transaction']);
        }
        if (isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null) {
            unset($_SESSION['user_type_upgrade']);
        }
    }
    public function updatepaymentresponse_cancel()
    {
        $this->clearSessions();
        if (is_array($_REQUEST) && empty($_REQUEST)) {
            return redirect('/');
        }
        $data['pageTitle']= "Welcome to Japan macro advisors -  Payment Cancelled";
        $data['meta']['description']="Japan macro advisors -  Payment Cancelled";
        $data['meta']['keywords']='Payment Cancelled, subscribe';
        $data['renderResultSet']=$data;
        return view('user.updatepaymentresponse_cancel', $data);
    }
    private function paypal_paid_user_insertion()
    {
        $user = new User();
        if (Session::has('temp_user') && Session::get('temp_user')!=null) {
            $linkedinUserData = (Session::has('linkedinData'))?Session::get('linkedinData'):'';
            $userDetails=(Session::has('temp_user'))?Session::get('temp_user'):'';
            $checkUserExists = $user->checkUserExistsByEmail(Session::get('temp_user.email'));
            if ($checkUserExists) {
                // Exisiting user by linkedin Start
                //Except linkedin Signup existing user ,we are restricting signup page itself
                if (Session::has('linkedinData') && !empty(Session::get('linkedinData'))) {
                    $u_details = $user->updateLinkedinData($linkedinUserData);
                    $linkedinData = array(
                                'user_id' => $u_details['id'],
                                'oauth_uid' => $linkedinUserData->id,
                                  'industry' => (isset($linkedinUserData->industry) && $linkedinUserData->industry!=null)?$linkedinUserData->industry:'',
               'company_name' => (isset($linkedinUserData->positions->values[0]->company->name) && $linkedinUserData->positions->values[0]->company->name!=null)?$linkedinUserData->positions->values[0]->company->name:'' ,
                        'company_industry' => (isset($linkedinUserData->positions->values[0]->company->industry) && $linkedinUserData->positions->values[0]->company->industry!=null)?$linkedinUserData->positions->values[0]->company->industry:''
                                );
                    $checklinkedinData = $user->linkedinDataExists($u_details['id']);
                    if ($checklinkedinData == 0) {
                        $insertlinkedinData = $user->linkedinDataInsert($linkedinData);
                    } else {
                        $updatelinkedinData = $user->linkedinDataUpdate($linkedinData);
                    }
                }
                // Exisiting user by linkedin End
            } else {
                $u_details = $user->addUserRegistration($userDetails);
                $mailGun = new MailGunAPI();
                $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'), '/') : '';
                if ($evenPath == "production") {
                    $email_=(Session::has('temp_user.email'))?Session::get('temp_user.email'):'';
                    $fname_=(Session::has('temp_user.fname'))?Session::get('temp_user.fname'):'';
                    $mailGun->addNewUserMailGunListingAddress($email_, $fname_);
                }
                //Fresh user linkedin data insert start
                if (Session::has('linkedinData') && !empty(Session::get('linkedinData'))) {
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
            $update=$user->setThisUserStatus($u_details['id'], 'trial');
            if (Session::has('OAUTH_ACCESS_TOKEN') || isset($_SESSION['OAUTH_ACCESS_TOKEN'])) {
                $this->send_individual_linkedin_user_mail(base64_encode($u_details['id']));
                Session::forget('OAUTH_ACCESS_TOKEN');
                unset($_SESSION['OAUTH_ACCESS_TOKEN']);
            } else {
                $this->send_individual_user_mail(base64_encode($u_details['id']));
            }
            if (Session::has('temp_user') && Session::get('temp_user')!=null) {
                Session::forget('temp_user');
                Session::forget('linkedinData');
            }
            $id=(isset($u_details['id']) && $u_details['id']!=null)?$u_details['id']:Session::get('user.id');
            $user_details = $user->getUserDetailsById($id);
            Session::put('user', $user_details);
        } else {
            if (Session::has('user_type_upgrade') && Session::get('user_type_upgrade')==1) {
                $this->user_upgrade_mail(Session::get('user.id'));
                $user->setThisUserStatus(Session::get('user.id'), 'trial');
                $user->setThisUserToPremium(Session::get('user.id'));
            }
        }  // From Request User End
    }
     public function archive($id){
       
        $this->renderResultSet['pageTitle'] = "India Macro Advisors | Unbiased Analysis on India's Economy | Previous Data Trend";
        $this->renderResultSet['meta']['shareTitle']="India Macro Advisors | Unbiased Analysis on India's Economy | Previous Data Trend";
        $this->renderResultSet['meta']['description']="We offer concise and insightful analysis on the Indian Economy through our regularly updated macroeconomic data, commentary  and interactive charts.";
        $this->renderResultSet['meta']['keywords']='India economic data,Current data of Indian economy, India macroeconomic indicators 2017,latest data on Indian economy,India economic indicator statistics';
        $data['renderResultSet']=$this->renderResultSet;
        // get all category items
        $contents=[];
        $result=DB::select('SELECT * FROM archeive_post WHERE post_id='.$id.' AND id != (SELECT MAX(id) FROM archeive_post WHERE post_id='.$id.')' );
        $get_Count =count($result);
        if($result>0) {
        $contents = json_decode(json_encode($result), true);

        }
        
        return view('archive/archive',$data)->with('result',$contents);
    }
    public function archive_pdf($title){
        // $this->Track_Download('archive');
        $CommonClass = new CommonClass();

         $this->renderResultSet['pageTitle'] = "India Macro Advisors | Unbiased Analysis on India's Economy | Previous Data Trend";
        $this->renderResultSet['meta']['shareTitle']="India Macro Advisors | Unbiased Analysis on India's Economy | Previous Data Trend";
        $this->renderResultSet['meta']['description']="We offer concise and insightful analysis on the Indian Economy through our regularly updated macroeconomic data, commentary  and interactive charts,Previous Data Trend";
        $this->renderResultSet['meta']['keywords']='India economic data,Current data of Indian economy, India macroeconomic indicators 2017,latest data on Indian economy,India economic indicator statistics ,Previous Data Trend';

   
        


        
        $contents=[];
      
        $query="SELECT * FROM archeive_post WHERE  slug='".$title."'";
        $result=DB::select($query);
       
        //  var_dump($CommonClass->makeChart($result[0]->post_cms,false));
        // die();
         $get_Count =count($result);
        if($result>0) {
           $contents = json_decode(json_encode($result), true);
           $contents["graph"] = $CommonClass->makeChart($contents[0]['post_cms'],false);
            $this->renderResultSet['pageTitle'] =$contents[0]['meta_title'];
            $this->renderResultSet['meta']['shareTitle'] =$contents[0]['meta_title'];
            if($contents[0]['meta_description']!=''){
            $this->renderResultSet['meta']['description'] =$contents[0]['meta_description'];
            }
            $data['renderResultSet']=$this->renderResultSet;
           if($title!=$contents[0]['slug'])
            $this->error_404();
           
        }
       # dd($contents);
        /*    echo "<pre>";
         var_dump($result[0]);
         die();*/
         return view('archive/archive_content',$data)->with('result',$contents);
        

        
   
    }
    public function error_404(){
        new ErrorController(404);
    }
    

}
