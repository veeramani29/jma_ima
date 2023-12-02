#!/usr/bin/php -q
<?php
//ini_set('display_errors',1); 
// error_reporting(E_ALL);
require 'cron_class.php';
class SendNewPostNotification extends Cron {
	public $classes = array('alanee_classes/mailer/class.phpmailer.php');
	public function Run() {
			$post = new Post();
			$out = '';
			try {
			$out.= "***************** SendNewPostNotification - START"."<br><br>";
			// Crate modal objects 
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->IsHTML(true);  
			$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
		//	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		//	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		//	$mail->Username   = "info@japanmacroadvisors.co";  // GMAIL username
		//	$mail->Password   = "qB^gXTK5";            // GMAIL password
			$mail->SetFrom('info@indiamacroadvisors.com', 'IMA Info');
			$mail->AddReplyTo('info@indiamacroadvisors.com', 'IMA Info');
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	
			$mail->WordWrap = 50;
			$query = "SELECT * FROM `post_email_queue` WHERE post_email_queue_status = 'Y' ORDER BY `post_email_queue_id` ASC LIMIT 0,50";
			$rs = $post->executeQuery($query);
			if($rs->num_rows>0) {
				while($post_email_queue = $rs->fetch_assoc()) {
					$postTitle = '';$postDesc = '';$userEmail = '';$firstName = '';$lastName ='';
				    $queueId = $post_email_queue['post_email_queue_id'];
	          		$postId  = $post_email_queue['post_id'];
	          		$userId  = $post_email_queue['user_id'];
	          		
	          		$postQuery   = "select * from post where post_id='$postId' and post_type = 'N' and post_publish_status = 'Y'";
	          		$postDetails = $post->executeQuery($postQuery);
	          		$rs_rw = array();
	          		if($postDetails->num_rows>0) {
	          			while($rw_pdt = $postDetails->fetch_assoc()) {
	          				$rs_rw[] = $rw_pdt;
	          			}
	          			$postTitle = stripslashes($rs_rw[0]['post_title']);
	          			$out.= '******* New Post identified : '.$postTitle."<br>";
	          			$posrURL = $rs_rw[0]['post_url'];
	          			$appPath = Config::read('appication_path') != '' ? '/'.trim(Config::read('appication_path'),'/') : '';
	          			$link = 'http://indiamacroadvisors.com/reports/view/'.$posrURL;
	          			$out.= '******* New URL identified : '.$link."<br>";
	              		$postDesc  = stripslashes($rs_rw[0]['post_cms_small']);
	              		$mail->Subject = 'JMA - '.$postTitle;
	              		$mail->Body = $postTitle.'<br/>
								Summary<br/>
								'.$postDesc.'<br/><br/>
								For more: please see<br/><br/>
								<a href="'.$link.'" >'.$link.'</a><br/><br/>
								And www.indiamacroadvisors.com for other reports.<br/><br/>
								
								<a href="'.'http://indiamacroadvisors.com/user/unsubscribe" >click to unsubscribe alert</a><br/><br/>
								
								Takuji Okubo<br/><br/>
								
								Principal and Chief Economist<br/>
								India Macro Advisors<br/><br/>
								
								mail:takuji.okubo@indiamacroadvisors.com<br/>
								www.indiamacroadvisors.com<br/><br/>';
	              		
	          			$userQuery  =  "select * from `user_accounts` where id='$userId' and user_post_alert = 'Y'";
		          	//	$userQuery  =  "select * from user where user_post_alert = 'Y' and user_post_alert_unsubscribe = 'N' and user_status = 'Y'";
						$userDetails_rs = $post->executeQuery($userQuery);
						$userDetails = array();
						if($userDetails_rs->num_rows>0) {
						    while($rw_udt = $userDetails_rs->fetch_assoc()) {
		          				$userDetails[] = $rw_udt;
		          			}
							$userEmail   = $userDetails[0]['email'];
		          			$firstName   = $userDetails[0]['fname'];
		          			$lastName    = $userDetails[0]['lname'];
		          			
		          			$mail->AddAddress(trim($userEmail));
							$mail->Send();
						  	$mail->clearAddresses();
			    		  	$mail->clearAttachments();
			    		  	$out.= "**** Email sent to : ".$userEmail."<br>";
			    		  	$delQuery = 'delete from post_email_queue where post_email_queue_id ='.$queueId;
		              		$post->executeQuery($delQuery);
		              		$out.= "**** Deleted notification queue (id) : ".$queueId."<br>";
						} else {
							$out.= "**** Error..! User does not exists / User not subscribed (Post Id : ".$postId.", User Id : ".$userId.")"."<br>";
		          			$updateQuery = "UPDATE post_email_queue SET post_email_queue_status = 'N' where post_email_queue_id =".$queueId;
		              		$post->executeQuery($updateQuery);
						}
	          		} else {
	          				$out.= "**** Error..! No post exists / Post is not published (Post Id : ".$postId.")"."<br>";
			    		  	$delQuery = 'delete from post_email_queue where post_email_queue_id ='.$queueId;
		              		$post->executeQuery($delQuery);
		              		$out.= "**** Deleted notification queue (id) : ".$queueId."<br>";
	          		}
				}
			} else {
				exit;
				//$out.= "<br><br>"."****** No new post notification to send.";
			}
			$out.= "***************** SendNewPostNotification - END"."<br><br>";
		}catch (Exception $ex) {
			$out.="<br><br>"."ERROR....!".$ex->getMessage()." ( ".$ex->getCode()." )";
		}
		$mail->IsHTML(true);  
		$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		$mail->SetFrom('info@indiamacroadvisors.com', 'IMA Info');
		$mail->AddReplyTo('info@indiamacroadvisors.com', 'IMA Info');
		$mail->Subject = 'Send new post notification - Cron status';
        $mail->Body = $out;
		$mail->AddAddress('dev@indiamacroadvisors.com','JMA DevTeam');
		$mail->AddAddress('anushree.upadhyay@indiamacroadvisors.com','Anushree Upadhyay');
		$mail->AddAddress('priyanka.dhar@indiamacroadvisors.com','Priyanka Dhar');
		$mail->Send();
		$mail->clearAddresses();
	    $mail->clearAttachments();
	}
	
}

$obj = new SendNewPostNotification();
$obj->Run();
?>