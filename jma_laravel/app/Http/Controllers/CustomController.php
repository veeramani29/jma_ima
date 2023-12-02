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
use App\Libraries\linkedIn\oauth_client_class;
use Exception;
use App\Http\Controllers\ErrorController;
use App\Libraries\subscription_management\SubscriptionClass;
use Session;
class CustomController extends Controller {

	  public function __construct ()
        {

        		 parent::__construct();
            View::share ( 'menu_items', $this->populateLeftMenuLinks());
   


        }

	public function index() {
		new ErrorController(404);
	}

	
	public function dopayment() {
		if(!Session::has('temp_user') && !Session::has('user')){
			return redirect('user/login?r=custom/dopayment');
		}else {
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
				$paymentProcess = $payment->createCharge($paymentGateway,$stripeToken,$email);
				//print_r($paymentProcess);die;
				if(is_array($paymentProcess) && isset($paymentProcess['error'])){
					//$this->payment_status_mail(Session::get('user.id'),'error');
					$data['result']['status'] = 4444;
					$data['result']['message'] = $paymentProcess['error']['message'];
				}
				else {
					
					$id=Session::get('user.id');
					if(is_array($paymentProcess) && $paymentProcess!=null){
						
						if(isset($_POST['plan'])){
						$start_time=$paymentProcess['response']->subscriptions->data[0]->current_period_start;
						$end_time=$paymentProcess['response']->subscriptions->data[0]->current_period_end;
						}else{
							$start_time=$paymentProcess['startSubscription'];
							$end_time=$paymentProcess['endSubscription'];
						}
						
					$responseData = array(
						"email" => $email,
						"customerId" => $paymentProcess['customerId'],
						"subscriptionId" => $paymentProcess['subscriptionId'],
						"startSubscription" => $start_time,
						"endSubscription" => $end_time
					);

					
					$updateUserDetails = $user->updateStripeCusId($responseData);
					$transaction_id = 'null';
					$order_id = '';
					$action = 'Stripe - Create Subscription';
					$data = $paymentProcess['response'];
					
					$createUserStripeLog = $user->addlog($id, $transaction_id, $order_id, $action, $data);
					$user->setThisUserStatus(Session::get('user.id'),'active');
					$user->setThisUserToPremium(Session::get('user.id'));
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
       
        $template = $Mailtemplate->getTemplateParsed('payment_success_custom', $mail_data);
          
        } else {
            $error_mail_msg .= "Dear <b>" . $user_details ['fname'] . ' ' . $user_details ['lname'] . ",</b><br><br>We regret to inform you that your payment for monthly Premium subscription with email address <b><i>" . $user_details ['email'] . "</i></b> was unsuccessful. You’re monthly subscription fee is due.";
            $error_mail_msg .= '<p>Amount: '.$CONF_CURRENCY.' '.$CONF_AMOUNT.'.</p>';
            $error_mail_msg .= '<p>Your Premium subscription is inactive. We request you to check with your credit card you paid with. In order to continue with our service, please verify you’re billing information and resend payment.</p>';
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
		
		$message_html = "We have received a subsciption payment of amount : USD 100 from user : ".$user_details['fname']." ".$user_details['lname']."<br><br>".
                                "<br><br>".
                                "Email : ".$user_details['email']."<br><br>".
                                "Payment Method : Stripe"."<br><br>".
                                "Currency : USD<br><br>".
                                "Amount : 100.00<br><br>".
                                "Subscription expiry date : ".date('d, M Y',$user_details['expiry_on'])."<br><br>".
                                "Charge ID : ".$user_details['stripe_customer_id']."<br><br>".
                $message_text = "We have received a subsciption payment of amount : USD 100.00 from user : ".$user_details['fname']." ".$user_details['lname']."\n\n".
                                "\n\n".
                                "Email : ".$user_details['email']."\n\n".
                                "Payment Method : Stripe"."\n\n".
                                "Currency : USD\n\n".
                                "Amount : 100.00\n\n".
                                "Subscription expiry date : ".date('d, M Y',$user_details['expiry_on'])."\n\n".
                                "Charge ID : ".$user_details['stripe_customer_id']."\n\n";
                
                $this->sendNotificationMail($message_html,$message_text,"Payment received for Subscription - ".Config::read('environment'));
    }
	/**
         * Function : Send notification mail to update on payment status
         */
        private function sendNotificationMail($mail_message_html,$mail_message_text,$mail_subject){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            //$mail->IsMail();
            $mail->IsHTML(true);
            if(Config::read('environment')=='production'){
				$notification_to = Config::read('mailconfig.'.Config::read('environment').'.payment_notification_to');
            }else{
               $notification_to = "sadia.siddiqa@japanmacroadvisors.com"; 
            }
            
            $mail->clearAddresses();
            $mail->clearAttachments();
            $mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
            $mail->Subject = $mail_subject;
            $mail->Body = $mail_message_html;
            $mail->AddAddress($notification_to);
            //$mail->AddCC('sadia.siddiqa@japanmacroadvisors.com', 'Sadia');
            $mail->Send();
        }
	public function do_payment() {
			if(!Session::has('temp_user') && !Session::has('user')){
			return redirect('user/login?r=custom/dopayment');
		}else {
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
				$payment = new Subscription();
				$paymentGateway = 'stripe';
				$stripeToken = $_POST['stripeToken'];
				$email = (Session::has('temp_user.email') && Session::get('temp_user.email')!=null)?Session::get('temp_user.email'):Session::get('user.email');
				$paymentProcess = $payment->createSubscription($paymentGateway,$stripeToken,$email);
				//print_r($paymentProcess);die;
				if(is_array($paymentProcess) && isset($paymentProcess['error'])){
					//$this->payment_status_mail(Session::get('user.id'),'error');
					$data['result']['status'] = 4444;
					$data['result']['message'] = $paymentProcess['error']['message'];
				}
				else {
					
					$id=Session::get('user.id');
					if(is_array($paymentProcess) && $paymentProcess!=null){
						
						if(isset($_POST['plan'])){
						$start_time=$paymentProcess['response']->subscriptions->data[0]->current_period_start;
						$end_time=$paymentProcess['response']->subscriptions->data[0]->current_period_end;
						}else{
							$start_time=$paymentProcess['startSubscription'];
							$end_time=$paymentProcess['endSubscription'];
						}
						
					$responseData = array(
						"email" => $paymentProcess['email'],
						"customerId" => $paymentProcess['customerId'],
						"subscriptionId" => $paymentProcess['subscriptionId'],
						"startSubscription" => $start_time,
						"endSubscription" => $end_time
					);

					
					$updateUserDetails = $user->updateStripeCusId($responseData);
					$transaction_id = 'null';
					$order_id = '';
					$action = 'Stripe - Create Subscription';
					$data = $paymentProcess['response'];
					
					$createUserStripeLog = $user->addlog($id, $transaction_id, $order_id, $action, $data);
					$user->setThisUserStatus(Session::get('user.id'),'active');
					$user->setThisUserToPremium(Session::get('user.id'));
					}

					$user_details = $user->getUserDetailsById($id);
						Session::put('user',$user_details);
					
					
					 return redirect('user/payment_success');
				}
			}
			  return view('user.dopayment',$data);
		}
	}

	
					
	
}
?>

