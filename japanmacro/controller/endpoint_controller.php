<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class EndpointController extends AlaneeController {
        public $classes = array('alanee_classes/mailer/class.phpmailer.php','alanee_classes/payment/stripe_class.php');

        public function stripe() {
                try {
                        $stripePayment = new StripePayment();
                        $event = $stripePayment->getEventObject();
                        if (isset($event)){
                        	switch ($event->type){
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
                        	throw new Exception("No Event identified",9999);
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
        		$user_details = $user->getUserDetailsByStripeCustomerId($event->data->object->customer);
        		$user_id = $user_details[0]['id'];
        		$new_subscription_expiry = null;
        		$payment_subscription_id = $event->data->object->subscription;
        		if($user_details[0]['stripe_subscription_id'] != $payment_subscription_id){
        			throw new Exception ("Payment subscription ID mismatch with User Database",9999);
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
        		$paymentLog = new Userpaymentlog();
        		$payment_log = array(
        				'gateway' => 'Stripe',
        				'event_id' => $event->id
        		);
        		$paymentLog->addlog($user_id, $payment_transaction_id, $event->data->object->id, $event->type, json_encode($payment_log));
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
        		$user_details_pre = $user->getUserDetailsByStripeCustomerId($event->data->object->customer);
        		$user_id = $user_details_pre[0]['id'];
        		$new_subscription_expiry = null;
        		$payment_subscription_id = $event->data->object->subscription;
        		if($user_details_pre[0]['stripe_subscription_id'] != $payment_subscription_id){
        			throw new Exception ("Payment subscription ID mismatch with User Database",9999);
        		}
        		foreach ($event->data->object->lines->data as $existing_subscriptions){
        			if($existing_subscriptions->id == $payment_subscription_id){
        				$new_subscription_expiry = $existing_subscriptions->period->end;
        				break;
        			}
        		}
        		$amount = $event->data->object->amount_due;
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
        				'currency' => 'JPY',
        				'date_created' => $event->created,
        				'date_fulfilled' => $event->created,
        				'payment_status' => 'A',
        				'payment_method' => 'Stripe'
        		);
        		// insert payment transaction
        		// get transacrion id
        	//	$payment_transaction_id = $payment_transaction->addNewTransaction($transaction_params)['payment_transaction_id'];
        		$transaction_res_arr = $payment_transaction->addNewTransaction($transaction_params);
        		$payment_transaction_id = $transaction_res_arr['payment_transaction_id'];
        		// insert into user_payment_log
        		$paymentLog = new Userpaymentlog();
        		$payment_log = array(
        			'gateway' => 'Stripe',
        			'event_id' => $event->id
        		);
        		$paymentLog->addlog($user_id, $payment_transaction_id, $event->data->object->id, $event->type, json_encode($payment_log));
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
        		$this->sendNotificationMail($message_html,$message_text,"Payment received for Subscription - ".Config::read('environment'));
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
        		$user_details_pre = $user->getUserDetailsByStripeCustomerId($event->data->object->customer);
        		$user_id = $user_details_pre[0]['id'];
        		$payment_subscription_id = $event->data->object->id;
        		if($user_details_pre[0]['stripe_subscription_id'] != $payment_subscription_id){
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
        	$mail->IsHTML(true);
        	$notification_to = Config::read('mailconfig.'.Config::read('environment').'.payment_notification_to');
        	$mail->clearAddresses();
        	$mail->clearAttachments();
        	$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
        	$mail->Subject = $mail_subject;
        	$mail->Body = $mail_message_html;
        	$mail->AltBody = $mail_message_text;
        	$mail->AddAddress($notification_to);
        	$mail->Send();
        }
        
        
        
        
        
        private function unitTest(){
        	$event = json_decode('{
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
        	$this->handlePaymentSuccess($event);
        //	var_dump($event); exit;
        	
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