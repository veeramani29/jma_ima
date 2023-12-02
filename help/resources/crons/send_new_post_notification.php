<?php
namespace resources\crons;
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'Crons.php';
use \App\Libraries\mailer\PHPMailer;
use \Illuminate\Database\Capsule\Manager as Capsule;

class SendNewPostNotification extends Crons {
	
	 public function __construct()
    {
        parent::__construct();
    }

	public function Run() {

			$Capsule=new Capsule;
			
			
			
			$out = '';
			try {
			$out.= "***************** SendNewPostNotification - START"."<br><br>";
			// Crate modal objects 
			$mail = new PHPMailer();
			$mail->IsSMTP();
			//$mail->IsMail();
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

			$rs = Capsule::table(TBL_POST_MAIL_QUEUE)->where('post_email_queue_status','Y')->orderBy('post_email_queue_id','asc')->limit(50)->get();
  			

			
			if(count($rs)>0) {

				$array = json_decode(json_encode($rs), true);
			
				foreach($array as $post_email_queue) {
					$postTitle = '';$postDesc = '';$userEmail = '';$firstName = '';$lastName ='';
				    $queueId = $post_email_queue['post_email_queue_id'];
	          		$postId  = $post_email_queue['post_id'];
	          		$userId  = $post_email_queue['user_id'];
	          		
	          		$postQueryrs = Capsule::table(TBL_POST)->where('post_type','N')->where('post_id',$postId)->where('post_publish_status','Y')->get();

	          		
	          		$rs_rw = array();
	          		if(count($postQueryrs)>0) {
	          				$arrays = json_decode(json_encode($postQueryrs), true);
	          		
	          					foreach($arrays as $rw_pdt) {
	          				$rs_rw[] = $rw_pdt;
	          			}
						
	          			$postCategory_id = $rs_rw[0]['post_category_id'];
	          			$category_array = $this->getAllParentCategoriesByCategoryId($postCategory_id);
	          			
	          			$category_path = $this->getCategotyArrayParsedIntoPath($category_array);
	          			$posrURL = $category_path.$rs_rw[0]['post_url'];
	          			
	          			$postTitle = stripslashes($rs_rw[0]['post_title']);
	          			$out.= '******* New Post identified : '.$postTitle."<br>";          			
	          		
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


						$userQueryrs = Capsule::table(TBL_USER)->where('user_post_alert','Y')->where('id',$userId)->get();

						$userDetails = array();
						if(count($userQueryrs)>0) {
							$user_arrays = json_decode(json_encode($userQueryrs), true);
						
						    	foreach($arrays as $rw_udt) {
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
						Capsule::table(TBL_POST_MAIL_QUEUE)->where('post_email_queue_id',  $queueId)->delete();

			    		  	$delQuery = 'delete from post_email_queue where post_email_queue_id ='.$queueId;
		              		
		              		$out.= "**** Deleted notification queue (id) : ".$queueId."<br>";
						} else {
							$out.= "**** Error..! User does not exists / User not subscribed (Post Id : ".$postId.", User Id : ".$userId.")"."<br>";

						Capsule::table(TBL_POST_MAIL_QUEUE)->where('post_email_queue_id',  $queueId)->update(array('post_email_queue_status' => 'Y' ));

						}
	          		} else {
	          				$out.= "**** Error..! No post exists / Post is not published (Post Id : ".$postId.")"."<br>";
	          			Capsule::table(TBL_POST_MAIL_QUEUE)->where('post_email_queue_id',  $queueId)->delete();
			    		  
		              		
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
		#$mail->AddAddress('anushree.upadhyay@japanmacroadvisors.com','Anushree Upadhyay');
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


	private function getAllParentCategoriesByCategoryId($post_cat_id){
		$result_arr = array();
$Capsule=new Capsule;
		 $get_Cat = Capsule::select("CALL getAllParentCategoriesByCategoryId(".$post_cat_id.")");
		 $get_Count =count($get_Cat);
	
	if($get_Count>0) {
		$get_Cat = json_decode(json_encode($get_Cat), true);
		foreach ($get_Cat as $get_Cats) {
		$result_arr[] = $get_Cats;
		}
		
		
	}
		
		#echo "<pre>";print_r($result_arr);
		return $result_arr;		
	}
	
}

$obj = new SendNewPostNotification();
$obj->Run();
?>