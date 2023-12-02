<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Paymenttransaction extends AlaneeModal {
	
	public function addNewTransaction($transaction_params) {
		try {
			$response = array();
	
			$query ="INSERT INTO `payment_transactions`(`user_id`,`amount`,`currency`,`date_created`,`date_fulfilled`,`payment_status`,`payment_method`) VALUES(".$transaction_params['user_id'].",".$transaction_params['amount'].",'".$transaction_params['currency']."',".$transaction_params['date_created'].",".$transaction_params['date_fulfilled'].",'".$transaction_params['payment_status']."','".$transaction_params['payment_method']."')";
			if($id = $this->insertQuery($query)) {
				$response['payment_transaction_id'] = $id;
				return array_merge($response,$transaction_params);	
			}else {
				throw new Exception('Error...! DB error', 9999);
			}
			
		}catch (Exception $ex) {
			throw new Exception('Error...! DB error', 9999);
		}
		
	}
	
	public function updatePaymentToken($transaction_id,$order_id,$payment_token) {
		$response = false;
		$sql = "UPDATE `payment_transactions` SET `invoice_number`='".$order_id."', `payment_token`='".$payment_token."' WHERE id=".$transaction_id;
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
	
	public function updatePaymentStatus($id,$Status_text) {
		try {
			$response = false;
			switch (strtoupper($Status_text)) {
				case 'ACCOMPLISHED' :
				case 'SUCCESS':
				case 'OK':
				case 'DONE':
					$status = 'A';
					break;
				case 'FAILED':
					$status = 'F';
					break;
				case 'CANCELLED':
				case 'ERROR':
				case 'NOTOK':
					$status = 'C';
					break;
				case 'STARTED' :
				case 'INITIALIZED':
					$status = 'I';
					break;
					default:
						throw new Exception("Unknown status", 9999);
					
			}
			$sql = "UPDATE `payment_transactions` SET `payment_status`='".$status."' WHERE id=".$id;
			if($this->executeQuery($sql)) {
				$response = true;
			}
			return $response;
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
}

?>