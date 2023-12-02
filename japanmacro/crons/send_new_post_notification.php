<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'cron_class.php';
class SendNewPostNotification extends Cron {
	public $classes = array('alanee_classes/mailer/class.phpmailer.php','alanee_classes/common/navigation_class.php');
	public function Run() {
			$post = new Post();
			$postCategory = new postCategory();
			
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
			$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
			$mail->AddReplyTo('info@japanmacroadvisors.com', 'JMA Info');
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
						
	          			$postCategory_id = $rs_rw[0]['post_category_id'];
	          			$category_array = $postCategory->getAllParentCategoriesByCategoryId($postCategory_id);
	          			$category_path = $this->getCategotyArrayParsedIntoPath($category_array);
	          			$posrURL = $category_path.$rs_rw[0]['post_url'];
	          			
	          			$postTitle = stripslashes($rs_rw[0]['post_title']);
	          			$out.= '******* New Post identified : '.$postTitle."<br>";          			
	          			$appPath = Config::read('appication_path') != '' ? '/'.trim(Config::read('appication_path'),'/') : '';
	          			$link = 'https://japanmacroadvisors.com/reports/view/'.$posrURL;
	          			$out.= '******* New URL identified : '.$link."<br>";
	              		$postDesc  = stripslashes($rs_rw[0]['post_cms_small']);
	              		$mail->Subject = 'JMA - '.$postTitle;
	              		$mail->Body = $postTitle.'<br/>
								Summary<br/>
								'.$postDesc.'<br/><br/>
								For more: please see<br/><br/>
								<a href="'.$link.'" >'.$link.'</a><br/><br/>
								And www.japanmacroadvisors.com for other reports.<br/><br/>
								
								<a href="'.'http://japanmacroadvisors.com/user/newsletters" >click to unsubscribe alert</a><br/><br/>
								
								Takuji Okubo<br/><br/>
								
								Principal and Chief Economist<br/>
								Japan Macro Advisors<br/><br/>
								
								mail:takuji.okubo@japanmacroadvisors.com<br/>
								www.japanmacroadvisors.com<br/><br/>';
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
		$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AddReplyTo('info@japanmacroadvisors.com', 'JMA Info');
		$mail->Subject = 'Send new post notification - Cron status';
        $mail->Body = $out;
		$mail->AddAddress('dev@japanmacroadvisors.com','JMA DevTeam');
		$mail->AddAddress('anushree.upadhyay@japanmacroadvisors.com','Anushree Upadhyay');
		$mail->AddAddress('priyanka.dhar@japanmacroadvisors.com','Priyanka Dhar');
		$mail->Send();
		$mail->clearAddresses();
	    $mail->clearAttachments();
	}
	
	private function getCategotyArrayParsedIntoPath($cat_array) {
		$response = '';
		if(is_array($cat_array)) {
			foreach ($cat_array as $rw_cat) {
				$response.=$rw_cat['category_url'].'/';
			}
		}
		return $response;
	}
	
}

$obj = new SendNewPostNotification();
$obj->Run();
?>