<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

class Userpaymentlog extends AlaneeModal {
	
	public function addlog($uid, $transaction_id, $order_id, $action, $data){
		$response = false;
		$sql = "INSERT INTO `user_payment_log`(`user_id`, `transaction_id`, `order_id`, `action`, `data`) VALUES($uid, $transaction_id, '$order_id', '$action', '$data')";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
}

?>

