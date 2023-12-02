<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class CustomController extends AlaneeController {

		

	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/recaptchalib.php','alanee_classes/mailer/class.phpmailer.php','alanee_classes/common/navigation_class.php','alanee_classes/payment/paypal_class.php','alanee_classes/linkedIn/http.php','alanee_classes/linkedIn/oauth_client.php','alanee_classes/subscription_management/subscription_class.php');

	public function index() {
		$media = new Media();
		$this->pageTitle = "Welcome to Japan macro advisors";
		// get all category items
		$this->populateLeftMenuLinks();
		$this->renderView();
	}

	
	public function dopayment() {
		if(!isset($_SESSION['temp_user']) && !isset($_SESSION['user'])){
			$this->redirect('user/login?r=custom/dopayment');
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
				//print_r($paymentProcess);die;
				if(isset($paymentProcess['error'])){
					//$this->payment_status_mail($_SESSION['user']['id'],'error');
					$this->renderResultSet['status'] = 4444;
					$this->renderResultSet['message'] = $paymentProcess['error']['message'];
				}
				else {
					
					$id=$_SESSION['user']['id'];
					if($paymentProcess!=null){
						
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
					$userpaymentlog = new Userpaymentlog();
					$createUserStripeLog = $userpaymentlog->addlog($id, $transaction_id, $order_id, $action, $data);
					$user->setThisUserStatus($_SESSION['user']['id'],'active');
					$user->setThisUserToPremium($_SESSION['user']['id']);
					}

					$user_details = $user->getUserDetailsById($id);
					$_SESSION['user'] = $user_details;
					
					$this->redirect('user/payment_success');
				}
			}
			$this->renderView();
		}
	}

	

	public function do_payment() {
		if(!isset($_SESSION['temp_user']) && !isset($_SESSION['user'])){
			$this->redirect('user/login?r=custom/dopayment');
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
				//print_r($paymentProcess);die;
				if(isset($paymentProcess['error'])){
					//$this->payment_status_mail($_SESSION['user']['id'],'error');
					$this->renderResultSet['status'] = 4444;
					$this->renderResultSet['message'] = $paymentProcess['error']['message'];
				}
				else {
					
					$id=$_SESSION['user']['id'];
					if($paymentProcess!=null){
						
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
					$userpaymentlog = new Userpaymentlog();
					$createUserStripeLog = $userpaymentlog->addlog($id, $transaction_id, $order_id, $action, $data);
					$user->setThisUserStatus($_SESSION['user']['id'],'active');
					$user->setThisUserToPremium($_SESSION['user']['id']);
					}

					$user_details = $user->getUserDetailsById($id);
					$_SESSION['user'] = $user_details;
					
					$this->redirect('user/payment_success');
				}
			}
			$this->renderView();
		}
	}

	
					
	
}
?>

