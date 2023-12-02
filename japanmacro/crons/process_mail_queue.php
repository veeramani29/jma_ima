#!/usr/bin/php -q
<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);
require 'cron_class.php';
class ProcessMailQueue extends Cron {
	public $classes = array('alanee_classes/mailer/class.phpmailer.php');
	public function Run() {
			$mailqueue = new Mailqueue();
			$queue = $mailqueue->getAllMailQueue();
			foreach ($queue as $queue_item){
				switch ($queue_item['mail_type']){
					case 'stripe_payment_success':
						if($this->sendStripePaymentSuccess($queue_item)==true){
							$mailqueue->deleteThisMailQueue($queue_item['id']);
						}						
						break;
					case 'stripe_payment_failure':
						if($this->sendStripePaymentFailure($queue_item)==true){
							$mailqueue->deleteThisMailQueue($queue_item['id']);
						}
						break;
					case 'notification':
						
						break;					
				}
			}
	}
	/**
	 * Send stripe payment success notification mail
	 */
	private function sendStripePaymentSuccess($queue_items){
		try {
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->IsHTML(true);
			$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
			$mail->clearAddresses();
			$mail->clearAttachments();
			$data = json_decode($queue_items['data']);
			$subscription = $data->subscription;
			$amount = $subscription->amount_due;
			$currency = $subscription->currency;
			$date = date('M d, Y',$subscription->created);
			$Mailtemplate = new Mailtemplate();
			$mail_data = array(
					'name' => $data->user->fname.' '.$data->user->lname,
					'email' => $data->user->email,
					'currency' => $currency,
					'amount' => $amount,
					'date' => $date
			);			
			if($subscription->is_renewal){
				$template = $Mailtemplate->getTemplateParsed('payment_notify_renewal_success', $mail_data);
			}
			else {
				$template = $Mailtemplate->getTemplateParsed('payment_notify_success', $mail_data);
			}
			$mail->Subject = $template['subject'];
			$mail->Body = $template['message'];
			$mail->AddAddress($mail_data['email'],$mail_data['name']);
			$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
			$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			$mail->Send();
			return true;
		}catch (Exception $ex){
			return false;
		}
	}
	
	
	/**
	 * Send stripe payment failure notification mail
	 */
	private function sendStripePaymentFailure($queue_items){
		try {
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->IsHTML(true);
			$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
			$mail->clearAddresses();
			$mail->clearAttachments();
			$data = json_decode($queue_items['data']);
			$subscription = $data->subscription;
			$amount = $subscription->data->object->amount_due;
			$currency = $subscription->data->object->currency;
			$date = date('M d, Y',$subscription->created);
			$Mailtemplate = new Mailtemplate();
			$mail_data = array(
					'name' => $data->user->fname.' '.$data->user->lname,
					'email' => $data->user->email,
					'currency' => $currency,
					'amount' => $amount,
					'date' => $date
			);			
			$template = $Mailtemplate->getTemplateParsed('payment_notify_error', $mail_data);
			$mail->Subject = $template['subject'];
			$mail->Body = $template['message'];
			$mail->AddAddress($mail_data['email'],$mail_data['name']);
			$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
			$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			$mail->Send();
			return true;
		}catch (Exception $ex){
			return false;
		}
	}
	
}

$obj = new ProcessMailQueue();
$obj->Run();
?>