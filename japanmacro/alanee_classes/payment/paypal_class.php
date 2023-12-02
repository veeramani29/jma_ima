<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
/**
 * 
 * Paypal payment class
 * @author Shijo Thomas : shijo@alanee.com
 *
 */
$autoLoad = new Autoloader();
$autoLoad->loadThisClass('alanee_classes/common/alaneecurl_class.php');

class Paypal {
	private $api_username;
	private $api_password;
	private $api_signature;
	private $api_url;
	private $api_version;
	
	public function Paypal() {
		$api_configurations = Config::read('paypal.'.Config::read('environment'));
		$this->api_username = $api_configurations['username'];
		$this->api_password = $api_configurations['password'];
		$this->api_signature = $api_configurations['signature'];
		$this->api_url = $api_configurations['api_endpoint'];
		$this->api_version = $api_configurations['api_version'];
	}
	
	public function createExpressCheckout($uid = 0, $order_id, $transaction_id, $iAparams = array()){
		try{
			//$PAYMENTREQUEST_0_AMT = $params['PAYMENTREQUEST_0_AMT'];
			//EMAIL
			$params = array();
			$params['METHOD'] = 'SetExpressCheckout';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['PAYMENTREQUEST_0_AMT'] = $iAparams['PAYMENTREQUEST_0_AMT'];
			$params['PAYMENTREQUEST_0_ITEMAMT'] = $iAparams['PAYMENTREQUEST_0_AMT'];
			$params['EMAIL'] = $iAparams['EMAIL'];
			$params['PAYMENTREQUEST_0_CURRENCYCODE'] = 'USD';
			$params['RETURNURL'] = 'http://japanmacroadvisors.com/user/updatepaymentresponse_success?uid='.$uid.'&oid='.$order_id.'&tid='.$transaction_id;
			$params['CANCELURL'] = 'http://japanmacroadvisors.com/user/updatepaymentresponse_cancel?uid='.$uid.'&oid='.$order_id.'&tid='.$transaction_id;
			$params['NOSHIPPING'] = 1;
			$params['ALLOWNOTE'] = 1;
			$params['ADDROVERRIDE'] = 0;
			$params['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
			$params['SOLUTIONTYPE'] = 'Sole';
			$params['LANDINGPAGE'] = 'Billing';
			$params['PAYMENTREQUEST_0_INVNUM'] = $order_id;
			$params['TOTALTYPE'] = 'Total';
			$params['L_PAYMENTREQUEST_0_NAME0'] = 'JMA Subscription';
			$params['L_PAYMENTREQUEST_0_DESC0'] = 'JMA individual subscription fee.';
			$params['L_PAYMENTREQUEST_0_AMT0'] = $iAparams['PAYMENTREQUEST_0_AMT'];
			$params['PAYMENTREQUEST_0_SHIPTOPHONENUM'] = $iAparams['PAYMENTREQUEST_0_SHIPTOPHONENUM'];
			$params['L_BILLINGTYPE0'] = 'RecurringPayments';
			$params['L_BILLINGAGREEMENTDESCRIPTION0'] = "Subscription fee of $30 will be charged every month.";
			$params['MAXAMT'] = '30.00';
		//	echo '<pre>';
		//	print_r($params); exit;
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new Alaneecurl();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			$userpaymentlog = new Userpaymentlog();
			$log_data = json_encode($response_array);
			$userpaymentlog->addlog($uid, $transaction_id, $order_id, "Paypal - SetExpressCheckout", $log_data);
			$ack = strtoupper($response_array['ACK']);
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return $response_array['TOKEN'];
			} else {
				throw new Exception('API ERROR', 9999);
			}
			
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	
	public function getPaymentInfoAndStatus($uid = 0, $order_id, $transaction_id, $payment_paypal_token){
		try{
			$params = array();
			$params['METHOD'] = 'GetExpressCheckoutDetails';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['TOKEN'] = $payment_paypal_token;
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new Alaneecurl();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			$userpaymentlog = new Userpaymentlog();
			$log_data = json_encode($response_array);
			$userpaymentlog->addlog($uid, $transaction_id, $order_id, "Paypal - GetExpressCheckoutDetails", $log_data);
			$ack = strtoupper($response_array['ACK']);
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return $response_array;
			} else {
				throw new Exception('API ERROR', 9999);
			}
			
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	
	public function confirmPayment($uid, $order_id, $transaction_id, $payment_paypal_token,$payer_id,$final_amount) {
		try{
			$params = array();
			$params['METHOD'] = 'DoExpressCheckoutPayment';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['TOKEN'] = $payment_paypal_token;
			$params['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
			$params['PAYMENTREQUEST_0_AMT'] = $final_amount;
			$params['PAYERID'] = $payer_id;
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new Alaneecurl();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			$userpaymentlog = new Userpaymentlog();
			$log_data = json_encode($response_array);
			$userpaymentlog->addlog($uid, $transaction_id, $order_id, "Paypal - DoExpressCheckoutPayment", $log_data);
			$ack = strtoupper($response_array['ACK']);
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return true;
			} else {
				throw new Exception('API ERROR', 9999);
			}
			
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	
	public function confirmPaymentAndInitiateSubscription($uid, $order_id, $transaction_id, $payment_paypal_token, $payer_id, $final_amount, $user_email, $user_name, $subscription_start_date) {
		if($this->confirmPayment($uid, $order_id, $transaction_id, $payment_paypal_token, $payer_id, $final_amount)) {
			$params = array();
			$params['METHOD'] = 'CreateRecurringPaymentsProfile';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['TOKEN'] = $payment_paypal_token;
			$params['PROFILESTARTDATE']=gmdate("Y-m-d\TH:i:s\Z",$subscription_start_date);
			$params['PROFILEREFERENCE'] = $uid;
			$params['DESC'] = "Subscription fee of $30 will be charged every month.";
			$params['BILLINGPERIOD'] = 'Month';
			$params['BILLINGFREQUENCY'] = 1;
			$params['AMT'] = '30.00';
			$params['CURRENCYCODE'] = 'USD';
			$params['SUBSCRIBERNAME'] = 
			$params['EMAIL'] = $user_email;
			$params['L_PAYMENTREQUEST_0_NAME0'] = 'JMA Monthly Subscription';
			$params['L_PAYMENTREQUEST_0_AMT0'] = '30.00';
			$params['L_PAYMENTREQUEST_0_QTY0'] = 1;
			$params['L_PAYMENTREQUEST_0_ITEMCATEGORY0'] = 'Digital';			
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new Alaneecurl();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			$userpaymentlog = new Userpaymentlog();
			$log_data = json_encode($response_array);
			$userpaymentlog->addlog($uid, $transaction_id, $order_id, "Paypal - CreateRecurringPaymentsProfile", $log_data);
			$ack = strtoupper($response_array['ACK']);
			
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				$profile_status = strtoupper($response_array['PROFILESTATUS']);
				$profile_id = $response_array['PROFILEID'];
				if($profile_status == 'ACTIVEPROFILE') {
					$user = new User();
					$user->updatePaypalRecurrentprofileId($uid,$profile_id);
					return true;
				}else {
					return false;
				}
			} else {
				throw new Exception('API ERROR', 9999);
			}
			
		}
		
	}
	
	public function suspendRecurrentProfile($profile_id) {
			$params = array();
			$params['METHOD'] = 'ManageRecurringPaymentsProfileStatus';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['PROFILEID']=$profile_id;
			$params['ACTION']='Suspend';
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new Alaneecurl();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			$userpaymentlog = new Userpaymentlog();
			$log_data = json_encode($response_array);
			$userpaymentlog->addlog($uid, '', '', "Paypal - SuspendRecurringPaymentsProfile", $log_data);
			$ack = strtoupper($response_array['ACK']);
			
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return true;
			} else {
				throw new Exception('API ERROR', 9999);
			}
	}
	
	public function reactivateRecurrentProfile($profile_id) {
			$params = array();
			$params['METHOD'] = 'ManageRecurringPaymentsProfileStatus';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['PROFILEID']=$profile_id;
			$params['ACTION']='Reactivate';
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new Alaneecurl();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			$userpaymentlog = new Userpaymentlog();
			$log_data = json_encode($response_array);
			$userpaymentlog->addlog($uid, '', '', "Paypal - ReactivateRecurringPaymentsProfile", $log_data);
			$ack = strtoupper($response_array['ACK']);
			
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return true;
			} else {
				throw new Exception('API ERROR', 9999);
			}
	}	
	
	
}

?>