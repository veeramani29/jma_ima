<?php
namespace App\Libraries\payment;
if (!defined('SERVER_ROOT')) exit('No direct script access allowed');
use Config;
use Exception;
use App\Lib\AlaneeCurlClass;
#use App\Model\User;




/**
 * 
 * Paypal payment class

 *
 */


class PaypalClass {
	private $api_username;
	private $api_password;
	private $api_signature;
	private $api_url;
	private $api_version;
	
	public function __construct() {

	
		$api_configurations = Config::read('paypal.'.Config::read('environment'));
		 $this->api_username = $api_configurations['username'];
		$this->api_password = $api_configurations['password'];
		$this->api_signature = $api_configurations['signature'];
		$this->api_url = $api_configurations['api_endpoint'];
		$this->api_version = $api_configurations['api_version'];
			define('TRIALBILLINGPERIOD', 'Month');
			define('TRIALAMOUNT', 0.00);
			define('CURRENCYCODE', Config::read('subscription.currency'));
			
			define('DESC', "Subscription fee of ".Config::read('subscription.currency').Config::read('subscription.amount')." will be charged every month.");
			define('DESC_', "Subscription fee of ".Config::read('subscription.currency')."0.00 will be charged first month.");
			
			
	}
	private function writeLogs($method,$full_details,$type=false){
		if (!$type) {
			$type='logs';
		}
	$log_details=$method.PHP_EOL."\r\n";
	$log_details.=$full_details.PHP_EOL."\r\n";
	$handler = fopen(storage_path('logs/paypal_'.$type.'.txt'),'a');
	fwrite($handler,$log_details);
	}
	
	public function createExpressCheckout($order_id, $transaction_id, $iAparams = array()){
		try{
			
			//EMAIL 
			$params = array();
			$params['METHOD'] = 'SetExpressCheckout';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['EMAIL'] = $iAparams['EMAIL'];
			$params['PAYMENTREQUEST_0_CURRENCYCODE'] = CURRENCYCODE;
			$params['RETURNURL'] = url('user/updatepaymentresponse_success?oid='.$order_id.'&tid='.$transaction_id);
			$params['CANCELURL'] = url('user/updatepaymentresponse_cancel?oid='.$order_id.'&tid='.$transaction_id);
			#$params['PAYMENTREQUEST_0_NOTIFYURL'] = 'https://japanmacroadvisors.com/user/payment_done';
			
		$params['PAYMENTREQUEST_0_AMT'] = $iAparams['PAYMENTREQUEST_0_AMT'];
			$params['PAYMENTREQUEST_0_ITEMAMT'] = $iAparams['PAYMENTREQUEST_0_AMT'];
			$params['NOSHIPPING'] = 1;
			$params['ALLOWNOTE'] = 1;
			$params['ADDROVERRIDE'] = 0;
			$params['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
			$params['SOLUTIONTYPE'] = 'Sole';
			$params['LANDINGPAGE'] = 'Billing';
			$params['PAYMENTREQUEST_0_INVNUM'] = $order_id; 
			$params['TOTALTYPE'] = 'Total';
			$params['L_PAYMENTREQUEST_0_NAME0'] = 'IMA Premium Subscription';
			$params['L_PAYMENTREQUEST_0_DESC0'] =  'IMA Premium Subscription';
			$params['L_PAYMENTREQUEST_0_AMT0'] = $iAparams['PAYMENTREQUEST_0_AMT'];
		/*	$params['L_PAYMENTREQUEST_0_NAME1'] = 'JMA Standard Subscription';
			$params['L_PAYMENTREQUEST_0_DESC1'] = 'From second month subscription fee.';
			$params['L_PAYMENTREQUEST_0_AMT1'] = $iAparams['PAYMENTREQUEST_0_AMT'];*/
			$params['PAYMENTREQUEST_0_SHIPTOPHONENUM'] = ($iAparams['PAYMENTREQUEST_0_SHIPTOPHONENUM']!='')?$iAparams['PAYMENTREQUEST_0_SHIPTOPHONENUM']:0;
			$params['MAXAMT'] = $iAparams['PAYMENTREQUEST_0_AMT'];

			$params['L_BILLINGTYPE0'] = 'RecurringPayments';
			$params['L_BILLINGAGREEMENTDESCRIPTION0'] = DESC;
			$params['LOGOIMG'] = images_path("logo.png");
			$params['HDRIMG'] = images_path("mail_template/jmabanner.jpg");
			$params['PAYFLOWCOLOR'] = "0B327E";#E60013
			$params['HDRBACKCOLOR'] = "E60013";
			$params['HDRBORDERCOLOR'] = "E60013";
			
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new AlaneeCurlClass();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			//echo '<pre>';
		//print_r($response); exit;
			parse_str($response, $response_array);

			$log_data = json_encode($response_array);
			$this->writeLogs("Paypal - SetExpressCheckout", $log_data);
			$ack = strtoupper($response_array['ACK']);
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return $response_array['TOKEN'];
			} else {
				$this->writeLogs("Paypal - SetExpressCheckout", $log_data,'error');
				return $response_array;
			}
			
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}


	
	public function getPaymentInfoAndStatus($order_id, $transaction_id, $payment_paypal_token){

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
			$alaneeCurl = new AlaneeCurlClass();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			 $nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			#dd($response_array);
			$log_data = json_encode($response_array);
			$this->writeLogs("Paypal - GetExpressCheckoutDetails", $log_data);
			$ack = strtoupper($response_array['ACK']);
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return $response_array;
			} else {
				$this->writeLogs("Paypal - GetExpressCheckoutDetails", $log_data,'error');
					return $response_array;
				
				/*$Error='';
				$Error.=(isset($response_array['L_SHORTMESSAGE0'])?$response_array['L_SHORTMESSAGE0']:'');
				$Error.=(isset($response_array['L_LONGMESSAGE0'])?$response_array['L_LONGMESSAGE0']:'');
				throw new Exception('API ERROR -'.$Error, 9999);*/
				
			}
			
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	
	public function confirmPaymentttt($order_id, $transaction_id, $payment_paypal_token,$payer_id,$final_amount) {
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
			$params['PAYMENTREQUEST_0_CURRENCYCODE'] = CURRENCYCODE;
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new AlaneeCurlClass();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			 echo "<pre>";print_r($response_array);die;
			
		
			$log_data = json_encode($response_array);
			$this->writeLogs("Paypal - DoExpressCheckoutPayment", $log_data);
			$ack = strtoupper($response_array['ACK']); 
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return true;
			} else {
					$this->writeLogs("Paypal - DoExpressCheckoutPayment", $log_data,'error');
					return $response_array;
			
			}
			
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	#AUTOBILLOUTAMT=AddToNextBilling MAXFAILEDPAYMENTS
	public function confirmPaymentAndInitiateSubscription($uid, $order_id, $transaction_id, $payment_paypal_token, $payer_id, $final_amount, $user_email, $user_name, $subscription_start_date) {

		#$check=$this->confirmPayment($uid, $order_id, $transaction_id, $payment_paypal_token, $payer_id, $final_amount);
		$check = true;
		
		if($check) {
			$params = array();
			$params['METHOD'] = 'CreateRecurringPaymentsProfile';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['TOKEN'] = $payment_paypal_token;
				$params['PAYERID'] = $payer_id;
					$params['COUNTRYCODE'] = "IN";
			$params['PROFILESTARTDATE']=gmdate("Y-m-d\TH:i:s\Z",time());
			$params['PROFILEREFERENCE'] = $uid.time();
			$params['DESC'] = DESC;
			$params['BILLINGPERIOD'] = TRIALBILLINGPERIOD;
			$params['BILLINGFREQUENCY'] = 1;
			$params['AMT'] = $final_amount;
			$params['CURRENCYCODE'] = CURRENCYCODE;
			$params['SUBSCRIBERNAME'] = $user_name;
			$params['EMAIL'] = $user_email;
			$params['L_PAYMENTREQUEST_0_NAME0'] = 'IMA Standard Monthly Subscription';
			$params['L_PAYMENTREQUEST_0_AMT0'] = $final_amount;
			$params['L_PAYMENTREQUEST_0_QTY0'] = 1;
			$params['L_PAYMENTREQUEST_0_ITEMCATEGORY0'] = 'Digital';	
			$params['L_BILLINGAGREEMENTDESCRIPTION0'] = DESC;
			$params['AUTOBILLOUTAMT']='AddToNextBilling'; 
			
		    //Trails Deatils
			/*$params['TRIALBILLINGPERIOD']=TRIALBILLINGPERIOD;    #Period of time in one trial period
			$params['TRIALBILLINGFREQUENCY']=1;    #Frequency of charges, if any, during the trial period
			$params['TRIALTOTALBILLINGCYCLES']=1;   #Length of trial period
			$params['TRIALAMT']=TRIALAMOUNT; */
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new AlaneeCurlClass();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			#print_r($params);die;
			
			$log_data = json_encode($response_array);
			$this->writeLogs("Paypal - CreateRecurringPaymentsProfile", $log_data);
			
			 $ack = strtoupper($response_array['ACK']);
			
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				$profile_status = strtoupper($response_array['PROFILESTATUS']);
				$profile_id = $response_array['PROFILEID'];
				if($profile_status == 'ACTIVEPROFILE') {
					
					return $profile_id;
				}else {
						$this->writeLogs("Paypal - CreateRecurringPaymentsProfile", $log_data,'error');
					return $response_array;
				}
			} else {
					$this->writeLogs("Paypal - CreateRecurringPaymentsProfile", $log_data,'error');
				return $response_array;
			}
			
		}else {
				return $check;
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
			$alaneeCurl = new AlaneeCurlClass();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			
			$log_data = json_encode($response_array);
			$this->writeLogs("Paypal - SuspendRecurringPaymentsProfile", $log_data);
		   $ack = strtoupper($response_array['ACK']);
			
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return true;
			} else {
				$this->writeLogs("Paypal - SuspendRecurringPaymentsProfile", $log_data,'error');
				return $response_array;
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
			$alaneeCurl = new AlaneeCurlClass();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			
			$log_data = json_encode($response_array);
			$this->writeLogs("Paypal - ReactivateRecurringPaymentsProfile", $log_data);
			
			$ack = strtoupper($response_array['ACK']);
			
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return true;
			} else {
				$this->writeLogs("Paypal - ReactivateRecurringPaymentsProfile", $log_data,'error');
				return $response_array;
			}
	}	


	public function getRecurrentProfile($profile_id) {
			$params = array();
			$params['METHOD'] = 'GetRecurringPaymentsProfileDetails';
			$params['VERSION'] = $this->api_version;
			$params['PWD'] = $this->api_password;
			$params['USER'] = $this->api_username;
			$params['SIGNATURE'] = $this->api_signature;
			$params['PROFILEID']=$profile_id;
			#$params['ACTION']='Reactivate';
			
			$nvpstr = '';
			foreach ($params as $ky => $val) {
				$nvpstr.='&'.$ky.'='.urlencode($val);
			}
			$alaneeCurl = new AlaneeCurlClass();
			$curl_options = array(
				CURLOPT_VERBOSE => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			);
			$nvpstr = trim($nvpstr,'&');
			$response = $alaneeCurl->postData($this->api_url,$nvpstr,$curl_options);
			parse_str($response, $response_array);
			
			$log_data = json_encode($response_array);
			$this->writeLogs("Paypal - GetRecurringPaymentsProfileDetails", $log_data);
			
			$ack = strtoupper($response_array['ACK']);
			
			if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
				return true;
			} else {
				$this->writeLogs("Paypal - GetRecurringPaymentsProfileDetails", $log_data,'error');
				return $response_array;
			}
	}
	
	
}

?>