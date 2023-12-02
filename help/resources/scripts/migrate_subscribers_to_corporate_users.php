<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'script_class.php';

/**
 * 
 * Class MigrateSubscribers
 * @author shijosap
 *
 */
class MigrateCorporateUsers extends Script {
	
	public function Run() {
		$user = new User();
		$expiry_date = strtotime("+11 month", time());
		$sql_get_all_subscribers = "SELECT * FROM `clients_accounts`";
		$rs = $user->executeQuery($sql_get_all_subscribers);
		if($rs->num_rows>0){
			while($row = $rs->fetch_assoc()){
				$arr_subscribers = array(
					'company_id' => $row['clients_accounts_company_id'],
					'user_title' => 'Mr',
					'fname' => $row['clients_accounts_fname'],
					'lname' => $row['clients_accounts_lname'],
					'email' => $row['clients_accounts_email'],
					'password' => $row['clients_accounts_password'],
					'country_id' => $row['clients_accounts_country_id'],
					'user_type_id' => 3,
					'user_status_id' => 4,
					'expiry_on' => $expiry_date,
					'email_verification' => 'Y'
				);
				// insert
				$sql_insert = "INSERT INTO `user_accounts`(`company_id`, `user_title`, `fname`, `lname`, `email`, `password`, `country_id`, `user_type_id`, `user_status_id`, `expiry_on`, `email_verification`) VALUES('".$arr_subscribers['company_id']."', '".$arr_subscribers['user_title']."', '".$arr_subscribers['fname']."', '".$arr_subscribers['lname']."', '".$arr_subscribers['email']."', '".$arr_subscribers['password']."', ".$arr_subscribers['country_id'].", ".$arr_subscribers['user_type_id'].", ".$arr_subscribers['user_status_id'].", ".$arr_subscribers['expiry_on'].", '".$arr_subscribers['email_verification']."')";
				if($user->executeQuery($sql_insert)) {
					echo "<br>********* User Migrated : ".$arr_subscribers['email']." ****************<br>";
				}
				
			}
		}
		
	}
	
}


$obj = new MigrateCorporateUsers();
$obj->Run();

?>