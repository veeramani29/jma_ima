<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\User;
use App\Model\Mailqueue;
use App\Model\Paymenttransaction;
use Exception;
use Config;
use App\Http\Controllers\ErrorController;
use App\Libraries\mailer\PHPMailer;
use App\Libraries\payment\StripePayment;
class PaypalipnController extends Controller {
      

         private $use_sandbox = false;
         private $use_local_certs = true;
         /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    /** Sandbox Postback URL */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
     const VALID = 'VERIFIED';
     const INVALID = 'INVALID';

     public function useSandbox()
    {
        $this->use_sandbox = true;
    }
    public function usePHPCerts()
    {
        $this->use_local_certs = false;
    }

     public function getPaypalUri()
    {
        if ($this->use_sandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::VERIFY_URI;
        }
    }
    public function index() {
            new ErrorController(404);
     }

        public function stimulate() {
             try {
               if(!empty($_POST)){

                $input = @file_get_contents("php://input");
                $event_json = json_encode($input);
                $handler = fopen(storage_path('logs/paypalipnlog.txt'),'a');
                fwrite($handler,$event_json);

               
                     $response=$input;
             
                parse_str($response, $response_array);
                if($this->verifyIPN()){
                if(isset($response_array['txn_type']) && ($response_array['txn_type']=='recurring_payment' || $response_array['txn_type']=='recurring_payment_profile_created' || $response_array['txn_type']=='recurring_payment_skipped')){
                    $this->handlePaymentSuccsess($response_array['txn_type'],$response_array['recurring_payment_id'],$response_array);
                 }elseif (isset($response_array['txn_type']) && $response_array['txn_type']=='recurring_payment_profile_cancel'){
                      $this->handlePaymentCancelled('recurring_payment_profile_cancel',$response_array['recurring_payment_id'],$response_array);

                }elseif (isset($response_array['txn_type']) && $response_array['txn_type']=='recurring_payment_suspended') {
                      $this->handlePaymentFailed('recurring_payment_suspended',$response_array['recurring_payment_id'],$response_array);
                   
                }
            }
             
               
                header("HTTP/1.1 200 OK");
                exit("Success");
               }else{

                 $msg_txt = $msg = '';
                    $msg_txt.= "Error...! IPN not simulated ."."\n";
                    $msg.="Error...! IPN not simulated ."."<br>";
                    $msg_txt.="Request From : ".Config::read('environment') == 'production' ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']."\n";
                    $msg.="Request From : ".Config::read('environment') == 'production' ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']."<br>";
                   
                    $this->sendNotificationMail($msg,$msg_txt,"PayPal payment IPN ERROR - ".Config::read('environment'));
                header("HTTP/1.1 200 OK");
                exit("IPN not simulated Error");
               }

               }catch(Exception $ex) {
                    
                    $msg_txt = $msg = '';
                    $msg_txt.= "Error...! IPN not simulated ."."\n";
                    $msg.="Error...! IPN not simulated ."."<br>";
                    $msg_txt.="Request From : ".Config::read('environment') == 'production' ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']."\n";
                    $msg.="Request From : ".Config::read('environment') == 'production' ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']."<br>";
                    $msg_txt.="Error Thrown : ".$ex->getMessage();
                    $msg.="Error Thrown : ".$ex->getMessage();
                    $this->sendNotificationMail($msg,$msg_txt,"PayPal payment IPN ERROR - ".Config::read('environment'));
                    header("HTTP/1.1 200 OK");
                    echo $msg;
                    exit();
            }
                
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
               $notification_to = "veeramani.kamaraj@japanmacroadvisors.com"; 
            }
             
            $mail->clearAddresses();
            $mail->clearAttachments();
            $mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
            $mail->Subject = $mail_subject;
            $mail->Body = $mail_message_html;
            $mail->AltBody = $mail_message_text;
            $mail->AddAddress($notification_to);
           # $mail->AddCC('sadia.siddiqa@japanmacroadvisors.com', 'Sadia');
            $mail->Send();
        }





        public function verifyIPN()
    {
        if ( ! count($_POST)) {
            throw new Exception("Missing POST Data");
        }
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
       # $this->useSandbox();
        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getPaypalUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->use_local_certs) {
            curl_setopt($ch, CURLOPT_CAINFO,  storage_path('logs/cacert.pem'));
        }
       
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));
        $res = curl_exec($ch);
        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }
        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        if ($http_code != 200) {
            throw new Exception("PayPal responded with http code $http_code");
        }
        curl_close($ch);
        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == self::VALID) {
            return true;
        } else {
            return false;
        }
    }


      /**
         * Function - Record payment failed log
         */
        private function handlePaymentFailed($event,$profileId,$response){
            try {
                $user = new User();
                $mailqueue = new Mailqueue();
                $user_details = $user->getUserDetailsByPayPalprofileId(trim($profileId));
                $user_id = isset($user_details[0]['id'])?$user_details[0]['id']:0;
               $amount=$response['amount'];
                $message_html = "We have received a ".$event." notification of amount : USD ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."<br><br>".
                                "<br><br>".
                                "Email : ".$profileId.$user_details[0]['email']."<br><br>".
                                "Payment Method : PayPal"."<br><br>".
                                "Currency : USD<br><br>".
                                "Amount : ".$amount."\n\n";
                               
                $message_text = "We have received a ".$event." notification of amount : USD ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."\n\n".
                                "\n\n".
                                "Email : ".$profileId.$user_details[0]['email']."\n\n".
                                "Payment Method : PayPal"."\n\n".
                                 "Currency : USD<br><br>".
                                "Amount : ".$amount."\n\n";
                $mail_data = array(
                        'user' => $user_details[0],
                        'subscription' => array(
                        'amount_due' => $amount,
                        'currency' => 'USD',
                        'created' => date('Y-m-d')
                    )
                );
            $user->setThisUserToFree($user_id);
              $user->setThisUserStatus($user_id,'active');
                $this->sendNotificationMail($message_html,$message_text,"PayPal Payment Suspended for Subscription - ".Config::read('environment'));
                $q_id = $mailqueue->addToQueue('stripe_payment_failure',$user_details[0]['email'],'',json_encode($mail_data));
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage(),9999);
            }
        }

//amount,outstanding_balance,initial_payment_amount,shipping,amount_per_cycle,payment_gross
        /**
         * Function - Record payment failed log
         */
        private function handlePaymentCancelled($event,$profileId,$response){
            try {
                $user = new User();
                $mailqueue = new Mailqueue();
                $user_details = $user->getUserDetailsByPayPalprofileId(trim($profileId));
                $user_id = isset($user_details[0]['id'])?$user_details[0]['id']:0;
                $amount=$response['amount'];
                $message_html = "We have received a ".$event." notification of amount : USD ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."<br><br>".
                                "<br><br>".
                                "Email : ".$profileId.$user_details[0]['email']."<br><br>".
                                "Payment Method : PayPal"."<br><br>".
                                "Currency : USD<br><br>".
                                "Amount : ".$amount."\n\n";
                               
                $message_text = "We have received a ".$event." notification of amount : USD ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."\n\n".
                                "\n\n".
                                "Email : ".$profileId.$user_details[0]['email']."\n\n".
                                "Payment Method : PayPal"."\n\n".
                                 "Currency : USD<br><br>".
                                "Amount : ".$amount."\n\n";
                $mail_data = array(
                        'user' => $user_details[0],
                        'subscription' => array(
                        'amount_due' => $amount,
                        'currency' => 'USD',
                        'created' => date('Y-m-d')
                    )
                );

                $user->setThisUserToFree($user_id);
              $user->setThisUserStatus($user_id,'active');

                $this->sendNotificationMail($message_html,$message_text,"PayPal Payment Cancelled for Subscription - ".Config::read('environment'));
                $q_id = $mailqueue->addToQueue('stripe_payment_failure',$user_details[0]['email'],'',json_encode($mail_data));
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage(),9999);
            }
        }



        /**
         * Function - Record payment failed log
         */
        private function handlePaymentSuccsess($event,$profileId,$response){
            try {
                $user = new User();
                $mailqueue = new Mailqueue();
                $user_details = $user->getUserDetailsByPayPalprofileId(trim($profileId));
                $user_id = isset($user_details[0]['id'])?$user_details[0]['id']:0;
                $amount=$response['amount'];
                $message_html = "We have received a ".$event." notification of amount : USD ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."<br><br>".
                                "<br><br>".
                                "Email : ".$profileId.$user_details[0]['email']."<br><br>".
                                "Payment Method : PayPal"."<br><br>".
                                "Currency : USD<br><br>".
                                "Amount : ".$amount."\n\n";
                               
                $message_text = "We have received a ".$event." notification of amount : USD ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."\n\n".
                                "\n\n".
                                "Email : ".$profileId.$user_details[0]['email']."\n\n".
                                "Payment Method : PayPal"."\n\n".
                                 "Currency : USD<br><br>".
                                "Amount : ".$amount."\n\n";
                $mail_data = array(
                        'user' => $user_details[0],
                        'subscription' => array(
                        'amount_due' => $amount,
                        'currency' => 'USD',
                        'created' => date('Y-m-d')
                    )
                );
                    if((int)$amount !=0){
                    $user->setThisUserToPremium($user_id);
                    $user->setThisUserStatus($user_id,'active');
                    $new_expiry_date = strtotime("+1 month", time());
                    $user->setExpiryOnDate($user_id,$new_expiry_date);
                    }
                $this->sendNotificationMail($message_html,$message_text,"PayPal Payment Success for Subscription - ".Config::read('environment'));
                $q_id = $mailqueue->addToQueue('stripe_payment_success',$user_details[0]['email'],'',json_encode($mail_data));
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage(),9999);
            }
        }
        
        
        
        
       
       
}

?>




