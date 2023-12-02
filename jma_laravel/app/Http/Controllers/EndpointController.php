<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\User;
use App\Model\Country;
use App\Model\Mailqueue;
use App\Model\Paymenttransaction;
use Exception;
use Config;
use App\Http\Controllers\ErrorController;
use App\Libraries\mailer\PHPMailer;
use App\Libraries\payment\StripePayment;
//use App\Libraries\html2pdf\HTML2PDF;
class EndpointController extends Controller {



        public function index() {
                new ErrorController(404);
                }

        public function stripe() {
                try {
                        $stripePayment = new StripePayment();
                        $event = $stripePayment->getEventObject();

                        if (isset($event) && !empty($event)){
                            switch ($event->type){
                                case 'charge.failed':
                                        $this->handlePaymentFailed($event);
                                    break;
                                case 'invoice.payment_failed':
                                        $this->handlePaymentFailed($event);
                                    break;
                                case 'invoice.payment_succeeded':
                                    $this->handlePaymentSuccess($event);
                                    break;
                                case 'customer.subscription.deleted':
                                    //send subscription cancellation notifications to JMA
                                    $this->handleDeleteSubscription($event);
                                    break;
                            }
                        }else{
                            throw new Exception("No Event identified");
                        }
                } catch (Exception $ex) {
                    $msg_txt = $msg = '';
                    $msg_txt.= "Error...! End-point request error occured."."\n";
                    $msg.="Error...! End-point request error occured."."<br>";
                    $msg_txt.="Request From : ".Config::read('environment') == 'production' ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']."\n";
                    $msg.="Request From : ".Config::read('environment') == 'production' ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']."<br>";
                    $msg_txt.="Error Thrown : ".$ex->getMessage();
                    $msg.="Error Thrown : ".$ex->getMessage();
                    //header('HTTP/1.0 500 Internal Server Error');
                    $this->sendNotificationMail($msg,$msg_txt,"Stripe payment Endpoint ERROR - ".Config::read('environment'));
                    header("HTTP/1.1 200 OK");
                    echo $msg;
                    exit();
                }
                header("HTTP/1.1 200 OK");
                exit("Success");
        }
        
        /**
         * Function - Record payment failed log
         */
        private function handlePaymentFailed($event){
            try {
                $user = new User();
                $mailqueue = new Mailqueue();
                $user_details = $user->getUserDetailsByStripeCustomerId(trim($event->data->object->customer));
                if(is_array($user_details) && empty($user_details)){
                    sleep(10);
                    $user_details = $user->getUserDetailsByStripeCustomerId(trim(
                    $event->data->object->customer));
                    }


                $user_id = isset($user_details[0]['id'])?$user_details[0]['id']:0;
                $new_subscription_expiry = null;
                $payment_subscription_id = ($event->data->object->subscription!=null)?trim($event->data->object->subscription):trim($event->data->object->id);

                $user_stripe_subscription_id =  isset($user_details[0]['stripe_subscription_id'])?$user_details[0]['stripe_subscription_id']:null;

                if(trim($user_stripe_subscription_id)!=trim($payment_subscription_id)){
                      $subscriptioniDD=trim($user_details[0]['stripe_subscription_id'])."=".trim($payment_subscription_id);
                    throw new Exception ($subscriptioniDD."handlePaymentFailed() -> Payment subscription ID mismatch with User Database",9999);
                }
                // Update new Expiry date
                $payment_transaction = new Paymenttransaction();
                //$amount = $event->data->object->amount_due / 100.0;
                $amount = $event->data->object->amount_due;
                $transaction_params = array(
                        'user_id' => $user_id,
                        'amount' => $amount,
                        'currency' => 'USD',
                        'date_created' => $event->created,
                        'date_fulfilled' => $event->created,
                        'payment_status' => 'F',
                        'payment_method' => 'Stripe'
                );
                // insert payment transaction
                // get transacrion id
                $transaction_res_arr = $payment_transaction->addNewTransaction($transaction_params);
                $payment_transaction_id = $transaction_res_arr['payment_transaction_id'];
                //$payment_transaction_id = $payment_transaction->addNewTransaction($transaction_params)['payment_transaction_id'];
                // insert into user_payment_log
            
                $payment_log = array(
                        'gateway' => 'Stripe',
                        'event_id' => $event->id
                );
                $user->addlog($user_id, $payment_transaction_id, $event->data->object->id, $event->type, json_encode($payment_log));

                if(strtolower($event->data->object->currency)=='jpy'){
                    $amount=($amount);
                    }else{
                    $amount=number_format($amount/100,2);
                    }
                    

                // Send Notification mail
                $message_html = "We have received a FAILED payment notification of amount : ".$event->data->object->currency." ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."<br><br>".
                                "<br><br>".
                                "Email : ".$user_details[0]['email']."<br><br>".
                                "Payment Method : Stripe"."<br><br>".
                                "Currency : ".$event->data->object->currency."<br><br>".
                                "Amount : ".$amount."<br><br>".
                                "Next try on : ".date('d, M Y',$event->data->object->next_payment_attempt)."<br><br>".
                                "Charge ID : ".$event->data->object->charge."<br><br>".
                                "Stripe Customer ID : ".$event->data->object->customer."<br><br>".
                                "Stripe Subscription ID : ".$event->data->object->subscription."<br><br>";
                $message_text = "We have received a FAILED payment notification of amount : ".$event->data->object->currency." ".$amount." from user : ".$user_details[0]['fname']." ".$user_details[0]['lname']."\n\n".
                                "\n\n".
                                "Email : ".$user_details[0]['email']."\n\n".
                                "Payment Method : Stripe"."\n\n".
                                "Currency : ".$event->data->object->currency."\n\n".
                                "Amount : ".$amount."\n\n".
                                "Next try on : ".date('d, M Y',$event->data->object->next_payment_attempt)."\n\n".
                                "Charge ID : ".$event->data->object->charge."\n\n".
                                "Stripe Customer ID : ".$event->data->object->customer."\n\n".
                                "Stripe Subscription ID : ".$event->data->object->subscription."\n\n";
                $mail_data = array(
                        'user' => $user_details[0],
                        'subscription' => array(
                        'amount_due' => $event->data->object->amount_due,
                        'currency' => $event->data->object->currency,
                        'created' => $event->created
                    )
                );
                $this->sendNotificationMail($message_html,$message_text,"Payment FAILED for Subscription - ".Config::read('environment'));
                $q_id = $mailqueue->addToQueue('stripe_payment_failure',$user_details[0]['email'],'',json_encode($mail_data));
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage(),9999);
            }
        }
        
        /**
         * Function - Record a asuccessfull payment
         */  
        private function handlePaymentSuccess($event){
         
            try {
                //$customer = $stripePayment->getCustomerFromEvent($event->data->object->customer);
                $user = new User();
                $mailqueue = new Mailqueue();
                $user_details_pre = $user->getUserDetailsByStripeCustomerId(trim(
                    $event->data->object->customer));
                    if(is_array($user_details_pre) && empty($user_details_pre)){
                    sleep(10);
                    $user_details_pre = $user->getUserDetailsByStripeCustomerId(trim(
                    $event->data->object->customer));
                    }

                   
                $user_id = isset($user_details_pre[0]['id'])?$user_details_pre[0]['id']:0;
                
                $new_subscription_expiry = null;
                $payment_subscription_id = trim($event->data->object->subscription);
            $user_stripe_subscription_id =  isset($user_details_pre[0]['stripe_subscription_id'])?$user_details_pre[0]['stripe_subscription_id']:null;
            if(trim($user_stripe_subscription_id)!=trim($payment_subscription_id)){
                $subscriptioniDD=$user_id.trim($user_details_pre[0]['stripe_subscription_id'])."=".trim($payment_subscription_id);
                    throw new Exception ($subscriptioniDD."handlePaymentSuccess() -> Payment subscription ID mismatch with User Database",9999);
                }
                foreach ($event->data->object->lines->data as $existing_subscriptions){
                    if($existing_subscriptions->id == $payment_subscription_id){
                        $new_subscription_expiry = $existing_subscriptions->period->end;
                        break;
                    }
                }
                $amount = $event->data->object->amount_due;
                if($amount==0){
                    $amount = $event->data->object->amount;
                }
                if ($user_details_pre[0]['user_status']=='trial'){
                    // End trial
                    // Update if trial -> to active
                    if((int)$amount !=0){
                        $user->setThisUserStatus($user_id, 'active');
                    }
                }
                // Update new Expiry date
                if($new_subscription_expiry != null) {
                    $user->setExpiryOnDate($user_id,$new_subscription_expiry);
                }

                // Auto increment renewal cycle
                $renewal_cycle = $user_details_pre[0]['renewal_cycle']+1;
                $user->autoIncrementRenewalCycle($user_id,$renewal_cycle);
                
                $user_details = $user->getUserDetailsById($user_id);

                $payment_transaction = new Paymenttransaction();
                //$amount = $event->data->object->amount_due / 100.0;
                $transaction_params = array(
                        'user_id' => $user_id,
                        'amount' => (int)$amount,
                        'currency' => 'USD',
                        'date_created' => $event->created,
                        'date_fulfilled' => $event->created,
                        'payment_status' => 'A',
                        'payment_method' => 'Stripe'
                );
                // insert payment transaction
                // get transacrion id
            //  $payment_transaction_id = $payment_transaction->addNewTransaction($transaction_params)['payment_transaction_id'];
                $transaction_res_arr = $payment_transaction->addNewTransaction($transaction_params);
                $payment_transaction_id = $transaction_res_arr['payment_transaction_id'];
                // insert into user_payment_log
                
                $payment_log = array(
                    'gateway' => 'Stripe',
                    'event_id' => $event->id
                );
                $user->addlog($user_id, $payment_transaction_id, $event->data->object->id, $event->type, json_encode($payment_log));

               
                    if(strtolower($event->data->object->currency)=='jpy'){
                    $amount=($amount);
                    }else{
                    $amount=number_format($amount/100,2);
                    }

                // Send Notification mail
                $message_html = "We have received a subsciption payment of amount : ".$event->data->object->currency." ".$amount." from user : ".$user_details['fname']." ".$user_details['lname']."<br><br>".
                                "<br><br>".
                                "Email : ".$user_details['email']."<br><br>".
                                "Payment Method : Stripe"."<br><br>".
                                "Currency : ".$event->data->object->currency."<br><br>".
                                "Amount : ".$amount."<br><br>".
                                "Subscription expiry date : ".date('d, M Y',$new_subscription_expiry)."<br><br>".
                                "Charge ID : ".$event->data->object->charge."<br><br>".
                                "Stripe Customer ID : ".$event->data->object->customer."<br><br>".
                                "Stripe Subscription ID : ".$event->data->object->subscription."<br><br>";
                $message_text = "We have received a subsciption payment of amount : ".$event->data->object->currency." ".$amount." from user : ".$user_details['fname']." ".$user_details['lname']."\n\n".
                                "\n\n".
                                "Email : ".$user_details['email']."\n\n".
                                "Payment Method : Stripe"."\n\n".
                                "Currency : ".$event->data->object->currency."\n\n".
                                "Amount : ".$amount."\n\n".
                                "Subscription expiry date : ".date('d, M Y',$new_subscription_expiry)."\n\n".
                                "Charge ID : ".$event->data->object->charge."\n\n".
                                "Stripe Customer ID : ".$event->data->object->customer."\n\n".
                                "Stripe Subscription ID : ".$event->data->object->subscription."\n\n";

                if($user_details_pre[0]['renewal_cycle'] == 0){
                    $is_renewal = false;
                }   
                else{
                    $is_renewal = true;
                }
                
                $mail_data = array(
                                                                'user' => $user_details,
                                                                'subscription' => array(
                                                                'amount_due' => $event->data->object->amount_due,
                                                                'currency' => $event->data->object->currency,
                                                                'is_renewal' => $is_renewal,
                                                                'created' => $event->created
                                                                )
                );
                                $country = new Country();
                $data['result']['country_list'] = $country->getCountryDatabaseAsArray();
                                $stripePayment = new StripePayment();
				$end_date = date("F d,Y", strtotime("+30 days",$event->data->object->date));
                $customer = $stripePayment->getCustomerFromEvent($event->data->object->customer);
                                $user_data = array(
                                                                'email' => $user_details['email'],
                                                                'first_name' => $user_details['fname'],
                                                                'last_name' =>  $user_details['lname'],
                                                                'country' => $data['result']['country_list'][$user_details['country_id']],
                                                                'company' => @$user_details['address_details'][0]['company'],
																'address' => @$user_details['address_details'][0]['address'].','.@$user_details['address_details'][0]['city'].','.@$user_details['address_details'][0]['state'].','.@$user_details['address_details'][0]['zip_code'].','.$data['result']['country_list'][$user_details['country_id']],
																'currency' => $event->data->object->currency,
                                                                'amount' => $amount,
                                                                'branding' => $customer->sources->data[0]['brand'],
                                                                'last4' => $customer->sources->data[0]['last4'],
                                                                'date' => date("F d, Y",$event->data->object->date)." To ".$end_date,
                                                                'cc_email'=> (($customer->metadata->cc_email!=null)?$customer->metadata->cc_email:''),
                                                                'in_number' => $event->data->object->number
                                );
                //print_r($customer);exit;
                $this->sendNotificationMail($message_html,$message_text,"Payment received for Subscription - ".Config::read('environment'));
                                $this->sendPaymentInvoice($user_data);
                if((int)$amount !=0){
                    $q_id = $mailqueue->addToQueue('stripe_payment_success',$user_details['email'],'',json_encode($mail_data));
                }

                
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage(),9999);
            }
        }     
        
        /*
         * Handle Delete subscription
         */
        private function handleDeleteSubscription($event){
            // Send notification to JMA
            try {
                //$customer = $stripePayment->getCustomerFromEvent($event->data->object->customer);
                $user = new User();
                $mailqueue = new Mailqueue();
                $user_details_pre = $user->getUserDetailsByStripeCustomerId(trim($event->data->object->customer));
                 if(is_array($user_details_pre) && empty($user_details_pre)){
                    sleep(10);
                    $user_details_pre = $user->getUserDetailsByStripeCustomerId(trim(
                    $event->data->object->customer));
                    }
                    $payment_subscription_id = trim($event->data->object->id);
$user_stripe_subscription_id =  isset($user_details_pre[0]['stripe_subscription_id'])?$user_details_pre[0]['stripe_subscription_id']:null;
          
            if(trim($user_stripe_subscription_id)!=trim($payment_subscription_id)){
                    throw new Exception ("On unsubscribe, Payment subscription ID mismatch with User Database",9999);
                }
                // Send Notification mail
                $message_html = $user_details_pre[0]['fname']." ".$user_details_pre[0]['lname']." has Unsubscribed from Japanmacroadvisors.com<br><br>".
                        "<br><br>".
                        "Email : ".$user_details_pre[0]['email']."<br><br>".
                        "Payment Method : Stripe"."<br><br>".
                        "Currency : ".$event->data->object->plan->currency."<br><br>".
                        "Stripe Customer ID : ".$event->data->object->customer."<br><br>".
                        "Stripe Subscription ID : ".$payment_subscription_id."<br><br>";
                $message_text = $user_details_pre[0]['fname']." ".$user_details_pre[0]['lname']." has Unsubscribed from Japanmacroadvisors.com"."\n\n".
                        "\n\n".
                        "Email : ".$user_details_pre[0]['email']."\n\n".
                        "Payment Method : Stripe"."\n\n".
                        "Currency : ".$event->data->object->plan->currency."\n\n".
                        "Stripe Customer ID : ".$event->data->object->customer."\n\n".
                        "Stripe Subscription ID : ".$payment_subscription_id."\n\n";
                $this->sendNotificationMail($message_html,$message_text,"User Unsubscribed - ".Config::read('environment'));
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage(),9999);
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
               $notification_to = "sadia.siddiqa@japanmacroadvisors.com"; 
            }
            
            $mail->clearAddresses();
            $mail->clearAttachments();
            $mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
            $mail->Subject = $mail_subject;
            $mail->Body = $mail_message_html;
            $mail->AltBody = $mail_message_text;
            $mail->AddAddress($notification_to);
            //$mail->AddCC('sadia.siddiqa@japanmacroadvisors.com', 'Sadia');
            $mail->Send();
        }
        
        private function sendPaymentInvoice($data){
            if($data['currency'] == 'usd'){
				$currency = 'US$';
			}else {
				$currency = '&#165;';
			}      
                        $content = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome to Japan Macro Advisors</title>
</head>
<style type="text/css">
@media only screen and (max-width: 767px){
        .full-width{
                display:block !important;
                width:100% !important;
        }
}
</style>
<body>
        <div>
                <table bgcolor="#f5f5f5" border="0" class="full-width" cellpadding="0" cellspacing="0" width="690" style="font-size:14px; line-height:1.2; margin:auto;font-family:Arial, Helvetica, sans-serif;">
                        <!-- header -->
                        <tr>
                                <td align="center" style="font-size: 15px; padding: 20px;">
                                        <img alt="Japan GDP Economy" src="https://content.japanmacroadvisors.com/images/logo.png" style="padding-bottom:15px;"><br>
                                        Roppongi Hills North Tower Level 17, Roppongi 6-2-31, Minato, Tokyo, 106-0032, Japan
                                </td>
                        </tr>
                        <tr>
                                <td align="center" valign="top" style="background:#dadada;font-size: 15px; padding: 20px;">
                                        <p style="margin: 9px 0;">Standard Subscription</p>
                                        <p style="margin: 9px 0;">'.$data['company'].'</p>
                                        <p style="margin: 9px 0;">'.trim($data['address'],',').'</p>
                                        <p style="font-size: 25px; color: #444444;margin:15px 0;">'.$currency.$data['amount'].' at Japan Macro Advisors</p>
                                        <p style="margin: 9px 0;">'.ucfirst($data['first_name']).' '.ucfirst($data['last_name']).' -- '.strtoupper($data['branding']).' '.$data['last4'].'.</p>
                                </td>
                        </tr>
                        <tr>
                                <td align="center" valign="top" style="background:#c5c5c5; font-size: 19px; padding: 10px 20px;">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                        <td align="left">'.$data['date'].'</td>
                                                        <td align="right">#'.$data['in_number'].'</td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                        <!-- body -->
                        <tr>
                                <td align="center" valign="top" style="padding:45px 20px 29px;">
                                        <table align="left" border="1px" border-color="#dddddd" cellpadding="5" cellspacing="0" width="100%">
                                                <thead>
                                                        <tr>
                                                                <th align="left">Description</th>
                                                                <th align="left">Amount</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                                <td align="left">Subscription to JMA Standard account</td>
                                                                <td align="left">'.$currency.$data['amount'].'</td>
                                                        </tr>
                                                        <tr>
                                                                <td align="left">Total</td>
                                                                <td align="left">'.$currency.$data['amount'].'</td>
                                                        </tr>
                                                        <tr>
                                                                <td align="left">Paid</td>
                                                                <td align="left">'.$currency.$data['amount'].'</td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                </td>
                        </tr>
                        <tr>
                                <td align="left" valign="top" style="padding: 10px 20px 25px;">
                                        <p style="font-size:15px;line-height:1.35;">
                                                Thank you for your payment,
                                                <br>Japan Macro Advisors
                                        </p>
                                </td>
                        </tr>
                        <!-- footer -->
                        <tr>
                                <td align="left" valign="top" style="padding:20px;background:#dddddd;">
                                        <h3>General inquiry</h3>
                                        <p>
                                                For general inquiry, please send e-mail to <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>
                                        </p>
                                        <p>
                                                For technical assistance and subscription inquiry, e-mail us <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a>
                                        </p>
                                </td>
                        </tr>
                        <tr>
                                <td align="center" valign="top" style="background: #c5c5c5; padding: 10px; font-size: 13px; ">
                                        © 2018 All Rights Reserved. Japan Macro Advisors
                                </td>
                        </tr>
                </table>
        </div>
</body>
</html>';
                        $postdata = http_build_query(
                                array(
                                        'apikey' => 'b1df8d9a-c097-43bf-9e41-a7a23531067c',
                                        'value' => $content
                                )
                        );

                        $opts = array('http' =>
                                array(
                                        'method'  => 'POST',
                                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                                        'content' => $postdata
                                )
                        );

                        $context  = stream_context_create($opts);

                        // Convert the HTML string to a PDF using those parameters
                        $result = file_get_contents('http://api.html2pdfrocket.com/pdf', false, $context);

                        // Save to root folder in website
                        file_put_contents('./public/invoice/invoice-'.$data['in_number'].'.pdf', $result);
                        $mail = new PHPMailer();
            $mail->IsSMTP();
            //$mail->IsMail();
            $mail->IsHTML(true);
            $notification_to = $data['email'];

            $mail->clearAddresses();
            $mail->clearAttachments();
            $mail->SetFrom('info@japanmacroadvisors.com', 'Japan Macro Advisors');
            $mail->Subject = 'Subscription Invoice';
            $mail->Body = '<p>Dear '.$data['first_name'].' '.$data['last_name'].',<br/><br/>Thank you for subscribing to Japan Macro Advisors. This is a payment confirmation email.<br/>
                                                        Please find the payment invoice attached below for the record.<br/><br/>In case you have any questions, please let us know, we will be happy to help.<br/><br/>
                                                        Regards,<br/>
                                                        Japan Macro Advisors';
            $mail->addAttachment('./public/invoice/invoice-'.$data['in_number'].'.pdf');
            $mail->AddAddress($notification_to);
            if($data['cc_email']!=''){
                $mail->AddCC($data['cc_email']);
                 $mail->AddCC('veeramani.kamaraj@japanmacroadvisors.com');
            }
            
            $mail->Send();
                }



        public function unitTest(){
            /*$event = json_decode('{
  "id": "evt_17rVL6FXlXWsAuJCnzr4BBn8",
  "object": "event",
  "api_version": "2016-03-07",
  "created": 1458575588,
  "data": {
    "object": {
      "id": "in_17rUGkFXlXWsAuJCyX1unz9U",
      "object": "invoice",
      "amount_due": 100,
      "application_fee": null,
      "attempt_count": 1,
      "attempted": true,
      "charge": "ch_17rVL6FXlXWsAuJCjLXxMVyk",
      "closed": true,
      "currency": "jpy",
      "customer": "cus_86WGYkEkdUeg26",
      "date": 1458571474,
      "description": null,
      "discount": null,
      "ending_balance": 0,
      "forgiven": false,
      "lines": {
        "object": "list",
        "data": [
          {
            "id": "sub_86bxzPfUpNkLor",
            "object": "line_item",
            "amount": 100,
            "currency": "jpy",
            "description": null,
            "discountable": true,
            "livemode": false,
            "metadata": {},
            "period": {
              "start": 1458571096,
              "end": 1458657496
            },
            "plan": {
              "id": "test-subs-daily",
              "object": "plan",
              "amount": 100,
              "created": 1458290728,
              "currency": "jpy",
              "interval": "day",
              "interval_count": 1,
              "livemode": false,
              "metadata": {},
              "name": "Test subscription Daily",
              "statement_descriptor": null,
              "trial_period_days": null
            },
            "proration": false,
            "quantity": 1,
            "subscription": null,
            "type": "subscription"
          }
        ],
        "has_more": false,
        "total_count": 1,
        "url": "/v1/invoices/in_17rUGkFXlXWsAuJCyX1unz9U/lines"
      },
      "livemode": false,
      "metadata": {},
      "next_payment_attempt": null,
      "paid": true,
      "period_end": 1458571096,
      "period_start": 1458484696,
      "receipt_number": null,
      "starting_balance": 0,
      "statement_descriptor": null,
      "subscription": "sub_86bxzPfUpNkLor",
      "subtotal": 100,
      "tax": null,
      "tax_percent": null,
      "total": 100,
      "webhooks_delivered_at": 1458571485
    }
  },
  "livemode": false,
  "pending_webhooks": 1,
  "request": null,
  "type": "invoice.payment_succeeded"
}');
            $this->handlePaymentSuccess($event);*/
        //  var_dump($event); exit;
            
        }
       
}

/** 
 * Unit test
 */
/*
 $fname = "file_".time().".txt";
 $fd = fopen("/var/www/www/temp/".$fname,"wb");
 if(fwrite($fd,json_encode($post_stripe))){
 //      echo "written";
 header("HTTP/1.1 200 OK");
 }else{
 echo "err...";
 }
 fclose($fd);

 exit;
 */
?>




