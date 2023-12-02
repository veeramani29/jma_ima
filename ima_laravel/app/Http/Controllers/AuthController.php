<?php
////Swati Start
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use View;
use Config;
use App\Lib\CommonClass;
use App\Model\User;
use App\Model\Mailtemplate;
use App\Model\Country;
use App\Lib\MailGunAPI;
use App\Libraries\mailer\PHPMailer;
use Exception;

use Cookie;
use Session;
use App;


class AuthController extends Controller
{

    public function __construct ()
        {

           # View::share ( 'menu_items', $this->populateLeftMenuLinks());


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


  public function Close_Window($url){


if(Session::has('fb_user_access_token')){
  Session::forget('fb_user_access_token');
}
if(Session::has('fb_user_type')){
  Session::forget('fb_user_type');
}
  
    echo "<script type='text/javascript'>";
   //cho "alert(1);";
    echo  "opener.location.href='".$url."';close();";
    echo "</script>";exit(";)");



  }
	
	public function login($method='',$producttype=''){

    if(isset($_SESSION['temp_user']) && $_SESSION['temp_user']!=null){
   unset($_SESSION['temp_user']);
  }

  if(isset($_SESSION['OAUTH_ACCESS_TOKEN'])){
     unset($_SESSION['OAUTH_ACCESS_TOKEN']);
    }

     if(isset($_SESSION['downloadUrl']) &&  $_SESSION['downloadUrl']!='')
                     {
                         unset($_SESSION['downloadUrl']);
                     }
  # dd($_SESSION);
if ( strpos(url()->previous(), 'offerings') === false) {
 $_SESSION['downloadUrl']=url()->previous(); 
}
 Session::put('fb_user_type', (string) $producttype);
      
$fb = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');

  $login_url = $fb->getLoginUrl(['email']);
//create one temp sess
return redirect($login_url);
   
	}
	
	public function callback($method=''){
		$fb = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');
        $user = new User();

		 // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }
		

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (! $token) {
        // Get the redirect helper
        $helper = $fb->getRedirectLoginHelper();

        if (! $helper->getError()) {
            abort(403, 'Unauthorized action.');
        }
        

        // User denied the request
        dd(
            $helper->getError(),
            $helper->getErrorCode(),
            $helper->getErrorReason(),
            $helper->getErrorDescription()
        );
    }

    if (! $token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }

    $fb->setDefaultAccessToken($token);

    // Save for later
    Session::put('fb_user_access_token', (string) $token);

    // Get basic info on the user from Facebook.
    try {
        $response = $fb->get('/me?fields=id,name,first_name,last_name,email,link,gender,location{location{country_code}},work');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    } 

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection

    $userModel = new User();
    $AlaneeCommon = new CommonClass();
    $password = $AlaneeCommon->createPassword(8);
   
   
    $registered_on = time();
     $expiry_on=(Session::get('fb_user_type')=='premium')?strtotime("+3 months", time()):0;
    $facebook_user = $response->getGraphUser();
     $user_type=Session::get('fb_user_type');
    $user_type_id=2;//($user_type=='premium')?2:1;
if(!Session::has('fb_user_type')){
     Session::forget('fb_user_type');
   }


      isset($facebook_user['location']) && ($facebook_user['location']['location']['country_code']) !='' ?  $country = $userModel->getCountryId($facebook_user['location']['location']['country_code']) : $country=101;
      $facebook_user['gender']=="male" ? $user_title="Mr" : $user_title="Ms"; 
   
   $defultAlertID = $userModel->defaultEmailAlert(); 
              $defultAlertValue = implode(",",$defultAlertID);
     $fb_userDetails=array(
      'user_title'=>$user_title,
    'fname'=>$facebook_user['first_name'],
    'lname'=>$facebook_user['last_name'],
    'password'=>$password,
    'email'=>$facebook_user['email'],
    'country_id'=>$country,
    'registered_on'=>$registered_on,
    'expiry_on'=>$expiry_on,
    'user_type_id'=>$user_type_id,
    'user_status_id' => 4,
    'email_verification' => 'Y',
    'user_upgrade_status' => 'NU',
    'facebook_enabled' => 'Y',
    'facebook_oauth_id'=>$facebook_user['id'],
    'want_to_email_alert' => $defultAlertValue
    );


     if($user_type_id==2){
     $_SESSION['temp_user'] = $fb_userDetails;
     $this->Close_Window(url('/user/dopayment/'));
  return redirect('user/dopayment/');die;
   } 
       if($user_type_id!=2){
  $userData = $userModel->checkFacebookUserExists($fb_userDetails,$password,$user_type_id,$user_type);

        if($userData) {
                
               
                //$_SESSION['loggedin_user_id'] = $user_id;
                $userDetails = $userModel->getUserDetailsById($userData['id']);
                $userDetails['password'] = '********';
                $userDetails['loginViaLinkedIn'] = 'yes';
               // $_SESSION['user'] = $userDetails;
                if($userData['res'] == 'insert') {
                    $mailGun = new MailGunAPI();
                        $evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
                        if($evenPath == "production")
                        {
                            $mailGun->addNewUserMailGunListingAddress($facebook_user['email'],$facebook_user['first_name']);
                        }

                    $mail = new PHPMailer();
                    if(env('APP_ENV') == "development")
                    {
                        $mail->IsMail();
                    }
                    else
                    {
                        $mail->IsSMTP ();
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
                    $notify_body_msg = "A new ".ucfirst($n_user_type)." user signed up with us (Using Facebook Login).<p>Name : ".ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."<br><br>Email : ".$userDetails['email']."</p><br>";
                        if ($user_type=='corporate'){
                        $notify_body_msg.="<br><br>Upgrade info Requested : ".ucfirst($user_type)."</p>";
                        }
                    $notify_body_msg.="<br>Thanks,<br>IMA Team.<br>";
                    $mail->Body =$notify_body_msg;
                    $mail->AddAddress($notification_to);
                    $mail->Send();
                    $render = true;
                    $data['result']['user_details'] = $userDetails;
                    
                     if(isset($_SESSION['downloadUrl']) &&  $_SESSION['downloadUrl']!='')
                     {
                          $redirect = ($_SESSION['downloadUrl']);
                          if(isset($_SESSION['downloadUrl']))
                          {
                           
                             unset($_SESSION['downloadUrl']);
                          }
                         $this->Close_Window($redirect);
                          //return redirect()->away($redirect);
                          //exit();
                     }
                     else
                     {
                         $this->Close_Window('/');
                         // return redirect('/');
                     }
                    

        
                }elseif($userData['res'] == 'update'){

                    $user_row = $userModel->check_linkedin_user_status($userDetails,true);
            
                    if(is_bool($user_row)){
                    $userDetails = $userModel->getUserDetailsById($userData['id']);
                    $userDetails['password'] = '********';
                    $_SESSION['user'] = $userDetails;

                    if(isset($_SESSION['downloadUrl']) &&  $_SESSION['downloadUrl']!='')
                    {
                              $redirect = ($_SESSION['downloadUrl']);
                              if(isset($_SESSION['downloadUrl']))
                              {
                                 unset($_SESSION['downloadUrl']);
                              }
                             $this->Close_Window($redirect);
                              //return redirect()->away($redirect);
                              exit();
                      }
                      else
                      {

                        $this->Close_Window('/');
                         //return redirect('/');
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
                    } else{
                if(isset($_SESSION['OAUTH_ACCESS_TOKEN'])){
                    unset($_SESSION['OAUTH_ACCESS_TOKEN']);
                }
                    $this->setFlashMessage($user_row);
                    return redirect('user/login');

                    }
                }
                
            }
        }//check user_type end

       
	 //$response = $fb->get('/me?fields=id,name,first_name,last_name,email,link,gender,locale,work');
  //echo  $user_type_id=( Session::get('fb_user_type')=='premium')?2:1;


    //print_r(Session::all());   
     
    




		
	}

   
    
   

}