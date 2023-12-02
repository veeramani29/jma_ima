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
class MigrateSubscribersSendMail extends Script {
	public $classes = array('alanee_classes/mailer/class.phpmailer.php','alanee_classes/common/alaneecommon_class.php');
	
	public function Run() {
		$mailTemplate = new Mailtemplate();
		$sql_get_all_subscribers = "SELECT * FROM `tmp_migration_user_mail`";
		$rs = $mailTemplate->executeQuery($sql_get_all_subscribers);
		if($rs->num_rows>0){
			while($row = $rs->fetch_assoc()){
				$mail_data = array(
					'name' => $row['name'],
					'username' => $row['email'],
					'password' => $row['password']
				);
				$template = $mailTemplate->getTemplateParsed('subscribors_to_user_migration',$mail_data);
				
				
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->IsHTML(true);  
				$mail->SMTPDebug  = 2;                // enables SMTP debug information (for testing)
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
				$mail->WordWrap = 50;
				$mail->Subject = $template['subject'];
				$mail->Body = $template['message'];
				$mail->AddAddress($mail_data['username'],$mail_data['name']);
				$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
				$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				$mail->Send();
				$mail->clearAddresses();
    		  	$mail->clearAttachments();
				
	echo "<br>************************** Mail Sent to : ".$mail_data['username']." *********************************<br>";	
			}
		}
	
	}
	
}


$obj = new MigrateSubscribersSendMail();
$obj->Run();

?>