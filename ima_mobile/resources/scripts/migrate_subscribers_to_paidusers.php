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
class MigrateSubscribers extends Script {
	public $classes = array('alanee_classes/mailer/class.phpmailer.php','alanee_classes/common/alaneecommon_class.php');
	
	public function Run() {
		$user = new User();
		//$mailTemplate = new Mailtemplate();
		$res_pos = $user->getUserTitleDatabase();
		$titles = array();
		foreach ($res_pos as $rw){
			$titles[$rw['user_title_id']] = $rw['user_title_value'];
		}
		$expiry_date = strtotime("+6 month", time());
		$sql_get_all_subscribers = "SELECT * FROM `user` WHERE `user_status` = 'Y'";
		$rs = $user->executeQuery($sql_get_all_subscribers);
		if($rs->num_rows>0){
			while($row = $rs->fetch_assoc()){
				$reg_password = $this->createPassword(8);
				/*
				$arr_subscribers[] = array(
					'user_title' => $titles[$row['user_title_id']],
					'fname' => $row['user_first_name'],
					'lname' => $row['user_last_name'],
					'email' => $row['user_email'],
					'password' => $reg_password,
					'country_id' => $row['country_id'],
					'user_position_id' => $row['user_position_id'],
					'user_industry_id' => $row['user_industry_id'],
					'user_type_id' => 2,
					'user_status_id' => 4,
					'registered_on' => strtotime($row['user_created_date']),
					'expiry_on' => $expiry_date,
					'email_verification' => 'Y',
					'user_post_alert' => 'Y'				
				);
				*/
				// insert
				$sql_insert = "INSERT INTO `user_accounts`(`user_title`, `fname`, `lname`, `email`, `password`, `country_id`, `user_position_id`, `user_industry_id`, `user_type_id`, `user_status_id`, `registered_on`, `expiry_on`, `email_verification`, `user_post_alert`) VALUES('".$titles[$row['user_title_id']]."','".$row['user_first_name']."','".$row['user_last_name']."','".$row['user_email']."','".$reg_password."',".$row['country_id'].",".$row['user_position_id'].",".$row['user_industry_id'].",2,4,".strtotime($row['user_created_date']).",".$expiry_date.",'Y','Y')";
				if($user->executeQuery($sql_insert)) {
					echo "<br>********* User Migrated : ".$row['user_email']." ****************<br>";
					if($row['user_email'] != 'bjensen@coca-cola.com' && $row['user_email'] != 'tibrett@coca-cola.com' && $row['user_email'] != 'kojiinoue@coca-cola.com' && $row['user_email'] != 'kakabe@coca-cola.com' && $row['user_email'] != 'timai@coca-cola.com' && $row['user_email'] != 'michael.bidinger@groveinvestors.com'){
						/*$mail_data = array(
							'name' => $row['user_first_name'].' '.$row['user_last_name'],
							'username' => $row['user_email'],
							'password' => $reg_password
						);
						*/
						$sql_mail_insert = "INSERT INTO `tmp_migration_user_mail`(`name`,`email`,`password`) VALUES('".$row['user_first_name'].' '.$row['user_last_name']."','".$row['user_email']."','".$reg_password."')";
						if($user->executeQuery($sql_mail_insert)){
							echo "<br>*********----******** Mail Queue added : ".$row['user_email']." ****************<br><br>";
						}
					}
				}
				
			}
		}
		
	}
	
	public function createPassword($length) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
	}
	
}


$obj = new MigrateSubscribers();
$obj->Run();

?>