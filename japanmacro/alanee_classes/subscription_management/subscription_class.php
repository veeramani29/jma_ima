<?php
/**
 * Class to handle subscriptions
 * @author  Shijo Thomas (shijo@alanee.com)
 *
 */

class Subscription extends AlaneePlugin {
	public $classes = array('alanee_classes/payment/paypal_class.php','alanee_classes/payment/stripe_class.php');
	
	function createSubscription($paymentGateway, $stripeToken, $email){
		$stripePayment = new StripePayment();
		if($paymentGateway == "stripe"){
			try {
				$response = $stripePayment->createSubscription($stripeToken,$email);

				// Log insertion into database
				$user = new User();
				if($response->id){
					$email = $response->email;
					$stripeCustomerId = $response->id;
					$stripeSubscriptionId = $response->subscriptions->data[0]->id;
					$stripeSubscriptionStatus = $response->subscriptions->data[0]->status;
					if($stripeSubscriptionStatus == 'trialing')
						$userStatusKey = 'trial';
					elseif($stripeSubscriptionStatus == 'active') {
						$userStatusKey = 'active';
					}
					elseif($stripeSubscriptionStatus == 'unpaid'){
						$userStatusKey = 'unpaid';
					}
					$subscriptiontrial_start = $response->subscriptions->data[0]->trial_start;
					$subscriptiontrial_end = $response->subscriptions->data[0]->trial_end;
					$responseData = array(
						"response" => $response,
						"email" => $email,
						"customerId" => $stripeCustomerId,
						"subscriptionId" => $stripeSubscriptionId,
						"startSubscription" => $subscriptiontrial_start,
						"endSubscription" => $subscriptiontrial_end
					);

						return $responseData;
					
				}
				else{
						if($response['error']){
							/*$getUserID = $user->getUserIdByEmail($email);
							$uid = $getUserID[0]["id"];
							$transaction_id = 'null';
							$order_id = '';
							$action = 'Stripe - Create Subscription';
							$data = json_encode($response);
							$userpaymentlog = new Userpaymentlog();
							$createUserStripeLog = $userpaymentlog->addlog($uid, $transaction_id, $order_id, $action, $data);*/
						}
						return $response;
				}
			}
			catch (Exception $e) {
				$error = $e->getMessage();
				return $error;
			}
		}elseif ($paymentGateway == "paypal"){
			
		}
	
	}
	
	function cancelSubscription($id) {
		$user = new User();
		$getStripeDetails = $user->fetchStripeDetails($id);
		if($getStripeDetails){
			$cust_id = $getStripeDetails[0]['stripe_customer_id'];
			$sub_id = $getStripeDetails[0]['stripe_subscription_id'];
			$stripePayment = new StripePayment();
			$cancel = $stripePayment->cancelStripeSubscription($cust_id,$sub_id);
				if(isset($cancel['status']) && $cancel['status'] == 'canceled'){
				$statusKey = 'active';
				$updateUserStatus = $user->setThisUserStatus($id,$statusKey);
				$updateUserType = $user->setThisUserToFree($id);
				$message = 'Subscription cancelled successfully';
			}
			else{
					$message = 'Unable to cancel subscription. or duplicate cancel subscription';
			}
			$transaction_id = 'null';
			$order_id = '';
			$action = 'Stripe - Cancel Subscription';
			$data = json_encode($cancel);
			$userpaymentlog = new Userpaymentlog();
			$createUserStripeLog = $userpaymentlog->addlog($id, $transaction_id, $order_id, $action, $cancel);
			return $message;
		}
		else{
			$message = 'Invalid user';
			return $message;
		}
		
	}
	
	function upgradeSubscription($cus_id) {
		$user = new User();
		$stripePayment = new StripePayment();
		$upgradeSubscription = $stripePayment->upgradeStripeSubscription($cus_id);
		if($upgradeSubscription->id){
			$responseData = array(
						"customerId" => $upgradeSubscription->customer,
						"subscriptionId" => $upgradeSubscription->id,
						"endSubscription" => $upgradeSubscription->current_period_end
					);
			$updateStripeSubId	= $user->updateStripeSubId($responseData);	
		}
		return $upgradeSubscription;
	}
	
	/**
	 * Get subscription details for a user.
	 * @return array : subscription status, expiry date, payment profile id (Stripeid), subscription plan
	 * @param Int $user_id : User Id
	 */
	public function getUserSubscriptionDetails($user_id){
		
		
	}
	
	/**
	 * Activate a inactive subscription profile.
	 * @return array :
	 * @param Int $user_id
	 */
	public function activateSubscription($user_id){
		
	}
	
	/**
	 * Deactivate an active subscription profile.
	 * @return array :
	 * @param Int $user_id
	 */	
	public function deactivateSubscription($user_id){
		
		
		
	}
	
	/**
	 * Initiate and activate a new subscription
	 * @param Array $user_details
	 */
	public function initializeSubscrription($user_details){
		
		
	}
	
	
	public function unitTest(){
		exit("Yes... It works..!");
	}
	
	
}
?>