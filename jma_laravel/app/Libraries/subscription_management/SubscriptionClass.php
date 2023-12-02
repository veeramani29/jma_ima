<?php
namespace App\Libraries\subscription_management;
use Config;
use Exception;
use App\Libraries\payment\StripePayment;
use App\Model\User;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
/**
 * Class to handle subscriptions
 * @author  Shijo Thomas (shijo@alanee.com)
 *
 */

class SubscriptionClass  {
	
	
	function createSubscription($paymentGateway, $stripeToken, $email){

		$stripePayment = new StripePayment();
		if($paymentGateway == "stripe"){
			try {
				$response = $stripePayment->createSubscription($stripeToken,$email);

				// Log insertion into database
				$user = new User(); 
				if($response->id!=null){
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
					
				}else{
					return $response;
						/*if($response['error']){

							
							$getUserID = $user->getUserIdByEmail($email);
							$uid = $getUserID[0]["id"];
							$transaction_id = 'null';
							$order_id = '';
							$action = 'Stripe - Create Subscription';
							$data = json_encode($response);
							$userpaymentlog = new Userpaymentlog();
							$createUserStripeLog = $userpaymentlog->addlog($uid, $transaction_id, $order_id, $action, $data);
						}*/
						
				}
			} catch (Exception $e) {

				return $e;
			}
		}
	
	}
	
	function createCharge($paymentGateway, $stripeToken, $email){

		$stripePayment = new StripePayment();
		if($paymentGateway == "stripe"){
			try {
				$response = $stripePayment->createCharge($stripeToken,$email);
				// Log insertion into database
				$user = new User(); 
				//print_r($response); exit;
				if($response->id!=null){
					$email = $response->email;
					$stripeCustomerId = $response->id;
					$stripeSubscriptionId = '' ;
					$stripeSubscriptionStatus = 'active';
					if($stripeSubscriptionStatus == 'trialing')
						$userStatusKey = 'trial';
					elseif($stripeSubscriptionStatus == 'active') {
						$userStatusKey = 'active';
					}
					elseif($stripeSubscriptionStatus == 'unpaid'){
						$userStatusKey = 'unpaid';
					}
					$subscriptiontrial_start = $response->created ;
					$subscriptiontrial_end = strtotime('+365 day',$response->created);
					$responseData = array(
						"response" => $response,
						"email" => $email,
						"customerId" => $stripeCustomerId,
						"subscriptionId" => $stripeSubscriptionId,
						"startSubscription" => $subscriptiontrial_start,
						"endSubscription" => $subscriptiontrial_end
					);
						return $responseData;
					
				}else{
					return $response;
						/*if($response['error']){

							
							$getUserID = $user->getUserIdByEmail($email);
							$uid = $getUserID[0]["id"];
							$transaction_id = 'null';
							$order_id = '';
							$action = 'Stripe - Create Subscription';
							$data = json_encode($response);
							$userpaymentlog = new Userpaymentlog();
							$createUserStripeLog = $userpaymentlog->addlog($uid, $transaction_id, $order_id, $action, $data);
						}*/
						
				}
			} catch (Exception $e) {
				return $e;
			}
		}
	
	}
	
	function cancelSubscription($id) {
		$user = new User();
		$getStripeDetails = $user->fetchStripeDetails($id);
	
		if(is_array($getStripeDetails)){
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
					$message = 'Unable to cancel subscription. or duplicate cancel subscription'.$cancel;
			}
			$transaction_id = 'null';
			$order_id = '';
			$action = 'Stripe - Cancel Subscription';
			$data = json_encode($cancel);
			
			$createUserStripeLog = $user->addlog($id, $transaction_id, $order_id, $action, $cancel);
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
	public function getUserSubscriptionDetails($cus_id){
	$plan_array=array();
		$stripePayment = new StripePayment();
		$upgradeSubscription = $stripePayment->getCustomerPlan_($cus_id);
		if($upgradeSubscription->subscriptions!=null && $upgradeSubscription->subscriptions->data[0] && $upgradeSubscription->subscriptions->data[0]->plan!=null){
			$plan_detals=$upgradeSubscription->subscriptions->data[0]->plan;
			 $plan_array=array('id' =>$plan_detals['id'],
		 	'amount' => $plan_detals['amount'],
            'created' => $plan_detals['created'],
            'currency' => $plan_detals['currency'],
           'interval' => $plan_detals['interval']);
		}

		return $plan_array;
		 

		
		#echo "<pre>";print_r($plan_array);die;
	}


	public function subscription_plans($cus_id){
	$plan_array=array();
		$stripePayment = new StripePayment();
		$upgradeSubscription = $stripePayment->getCustomerPlan_($cus_id);
		if($upgradeSubscription->subscriptions!=null && $upgradeSubscription->subscriptions->data[0] && $upgradeSubscription->subscriptions->data[0]->plan!=null){
			$plan_detals=$upgradeSubscription->subscriptions->data[0]->plan;
			 $plan_array=array('id' =>$plan_detals['id'],
		 	'amount' => $plan_detals['amount'],
            'created' => $plan_detals['created'],
            'currency' => $plan_detals['currency'],
           'interval' => $plan_detals['interval']);
		}

		return $plan_array;
		 

		
		#echo "<pre>";print_r($plan_array);die;
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