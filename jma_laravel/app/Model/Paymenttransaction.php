<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use Exception;
class Paymenttransaction extends Model {
	protected $table = TBL_PAYMENTTXN;
	public function addNewTransaction($transaction_params) {
		try {
				$response = array();

				$id = Paymenttransaction::insertGetId(
				array('user_id' => $transaction_params['user_id'], 'amount' => $transaction_params['amount'], 'currency' => $transaction_params['currency'], 'date_created' => $transaction_params['date_created'], 'date_fulfilled' => $transaction_params['date_fulfilled'], 'payment_status' => $transaction_params['payment_status'], 'payment_method' => $transaction_params['payment_method'])
				);

				if($id) {
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
		 $rs=DB::table(TBL_PAYMENTTXN)->where('id',$transaction_id)->update(array('invoice_number' => $order_id,'payment_token' => $payment_token));

		 if($rs!=null) {
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

			  $rs=DB::table(TBL_PAYMENTTXN)->where('id',$id)->update(array('payment_status' => $status));

			
			 if($rs!=null) {
				$response = true;
			}
			return $response;
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
}

?>