<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
/**
 * 
 * Paypal payment class
 * @author Shijo Thomas : shijo@alanee.com
 *
 */
$autoLoad = new Autoloader();
$autoLoad->loadThisClass('libraries/stripe/stripe-php-3.2.0/init.php');

class StripePayment {
	private $api_key;
	public function StripePayment() {
		$api_configurations = Config::read('stripe.'.Config::read('environment'));
		$this->api_key = $api_configurations['api_key'];
	}
	
	public function createSubscription($stripeToken, $email){


		try{
				\Stripe\Stripe::setApiKey($this->api_key);
				$error = '';
				$success = '';
				try {
					if (!isset($stripeToken))
						//throw new Exception("The Stripe Token was not generated correctly");
						throw new Exception("Sorry! Something went wrong. Please try again later.");
						 $token = $stripeToken;
						$email = strip_tags($email);
						$company = strip_tags($_POST['company']);
						$phone = strip_tags($_POST['isd_code']).'-'.strip_tags($_POST['phone_number']);
						$metadata = array("company"=>$company, "Phone number"=>$phone);
						 $plan=(isset($_POST['plan'])?$_POST['plan']:"premium_monthly");
						$customer = \Stripe\Customer::create(array(
								"source" => $token,
								"plan" => $plan,
								"email" => $email,
								"metadata" => $metadata)
						);
						
						return $customer;
				}
				catch(\Stripe\Error\Card $e) {
					    // Since it's a decline, \Stripe\Error\Card will be caught
					    $body = $e->getJsonBody();
					    //$err  = $body['error'];
						$body['error']['message'] = 'Your card is declined. Please verify your card.';
						return $body;		
				} catch (\Stripe\Error\RateLimit $e) {
				    // Too many requests made to the API too quickly
				    $body = $e->getJsonBody();
				    $body['error']['message'] = 'Sorry! Something went wrong. Please try again later.';
				    return $body;
				} catch (\Stripe\Error\InvalidRequest $e) {
				    // Invalid parameters were supplied to Stripe's API
				    $body = $e->getJsonBody();
				    $body['error']['message'] = "Sorry! Something went wrong. Please try again later.";
				    return $body;
				} catch (\Stripe\Error\Authentication $e) {
				    // Authentication with Stripe's API failed
				    // (maybe you changed API keys recently)
					$body = $e->getJsonBody();
				    $body['error']['message'] = "Sorry! Something went wrong. Please try again later.";
				    return $body;
				} catch (\Stripe\Error\ApiConnection $e) {
				  // Network communication with Stripe failed
					$body = $e->getJsonBody();
				    $body['error']['message'] = "Sorry! Something went wrong. Please try again later.";
				    return $body;
				} catch (\Stripe\Error\Base $e) {
				  // Display a very generic error to the user, and maybe send
				  // yourself an email
						$body = $e->getJsonBody();
						$body['error']['message'] = "Error occurred during payment process. Please try again later or contact us at support@japanmacroadvisors.com";
						return $body;
				} catch (Exception $e) {
				  // Something else happened, completely unrelated to Stripe
						$body = $e->getJsonBody();
						$body['error']['message'] = 'Sorry! Something went wrong. Please try again later.';
						return $body;
				}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
			$error = $ex->getMessage();
			return $error;
		}
	}
	
	public function cancelStripeSubscription($cus_id,$sub_id){
		try{
			\Stripe\Stripe::setApiKey($this->api_key);

			$customer = \Stripe\Customer::retrieve($cus_id);
			$subscription = $customer->subscriptions->retrieve($sub_id);
			$cancelResponse = $subscription->cancel();
			return $cancelResponse;
		}catch (Exception $ex) {
			//throw new Exception($ex->getMessage(), $ex->getCode());
			return $ex->getMessage();
		}
	}
	
	Public function upgradeStripeSubscription($cus_id){
		try{
			\Stripe\Stripe::setApiKey($this->api_key);
			$customer = \Stripe\Customer::retrieve($cus_id);
			$upgrade = $customer->subscriptions->create(array("plan" => 'premium_no_trial'));
			return $upgrade;
		}catch (Exception $ex) {
			//throw new Exception($ex->getMessage(), $ex->getCode());
			return $ex->getMessage();
		}
	
	}
	
	private function getEndpointPostedJSON(){
		try {
			\Stripe\Stripe::setApiKey($this->api_key);
			$input = @file_get_contents("php://input");
			$event_json = json_decode($input);
			return $event_json;			
		} catch (Exception $ex) {
			throw new Exception($ex->getCode(),$ex->getMessage());
		}
	}
	public function getEventObject(){
		try {
			\Stripe\Stripe::setApiKey($this->api_key);
			$event_json = $this->getEndpointPostedJSON();
			$event = \Stripe\Event::retrieve($event_json->id);
			return $event;
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	public function getCustomerFromEvent($event_customer){
		try {
			\Stripe\Stripe::setApiKey($this->api_key);
			$customer = \Stripe\Customer::retrieve($event_customer);
			return $customer;
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
}

?>