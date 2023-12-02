<?php
class post {
	public $Mailgun;
	
	function __construct(){
		
		    $this->db	     = new mysql();
	}
	
	
	
	/**
	* Function to get client tickets list
	*/
	
	
	function getPostList(){
		$this->db->open();
                $query_pag_data   = "SELECT * FROM post order by post_datetime desc";            
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	}
        
        function addpost($insertArr){
                if($this->isPostExists($insertArr['post_url_key'],$insertArr['post_category_id'])== false) {
	                $this->db->open();
	                $results = $this->db->insertRecord('post', $insertArr);
	                return $results;
	                $this->db->close();
               }else{
               		throw new Exception('Post already exists', 9999);
               }
          }
		  
		  function addmailTemplate($insertArr){
                
					$this->db->open();
	                $results = $this->db->insertRecord('email_templates', $insertArr);
					$this->db->close();
	                return $results;
				  
          }
        
        
        function getPostDetails($postId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM post WHERE post_id='$postId'";            
		$postDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postDetails;
            
        }
		
		 function getEmailDetails($postId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT `email_templates_id`,`email_templates_code`,`email_templates_subject`,`email_templates_message`,`email_templates_variable` FROM email_templates WHERE email_templates_id='$postId'";            
		$postDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postDetails;
            
        }
        
 		function isPostExists($post_url_key,$post_category_id) {
               $this->db->open();
               $query1 =  "SELECT * FROM  post where post_url_key ='".$post_url_key."' AND post_category_id = ".$post_category_id; 
               $subCatList = $this->db->fetchArray($this->db->query($query1));
               $this->db->close();
               if(count($subCatList) > 0){
               	return true;
               } else {
               	return false;
               }
 		}       
        
        function sendMail($fromName,$fromEmail,$toName,$toMail,$subject,$message){
                    $send = 0;
                      $mail = new PHPMailer();
					  $mail->IsSMTP();
					  $mail->IsHTML(true);  
					//  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
					//  $mail->Debugoutput = 'html';
					//  $mail->SMTPSecure = 'ssl';
					  $mail->AddAddress($toMail,$toName);
					  $mail->SetFrom($fromEmail, $fromName);
					  $mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
					  $mail->Subject = $subject;
					  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					  $mail->Body = $message;
					  $mail->WordWrap = 50;                                 
					  

                    //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
                   // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

                   // $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

                    if(!$mail->Send())
                    {
                       $send = 1;
                    }
                    return $send;
        }
        
        function getPostedUser($userId){
            $userName  ='';
            $this->db->open();
            $query_pag_data   = "SELECT * FROM user_details WHERE id ='$userId'";
            $usertList = $this->db->fetchArray($this->db->query($query_pag_data));
            if(count($usertList)>0){
                $userName = $usertList[0]['first_name'];
            }
	    $this->db->close();
	    return $userName;
            
        }
        
        function updatePostStatus($postId,$status){
            $this->db->open();
            $query_pag_data   = "update post_details set post_status = '$status' where id = '$postId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
        
         function updatePost($updateId,$category,$writer,$postTitle,$shortDesc,$postHead,$subHead,$postReleased,$post,$postType){
            
            $this->db->open();
            $query_pag_data   = "update post set post_category_id = '$category',copywriter_id = '$writer',post_title='$postTitle',
            post_cms_small = '$shortDesc',post_heading = '$postHead',post_subheading = '$subHead',post_released = '$postReleased',post_cms = '$post',post_type = '$postType' where post_id = '$updateId'";
            //echo $query_pag_data;
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
            
        }
         function updatePost2($updateId,$category,$writer,$postTitle,$shortDesc,$postHead,$subHead,$postReleased,$postImage,$post,$postType, $metaTitle, $metaKeywords, $metaDesc,$shareDesc, $post_url, $post_url_key,$post_share_title,$sugPagetitle1,$sugPageDesc1,$sugPageLink1,$sugPageTitle2,$sugPageDesc2,$sugPageLink2,$sugPageTitle3,$sugPageDesc3,$sugPageLink3,$sugPageTitle4,$sugPageDesc4,$sugPageLink4,$premium_news,$vid_desc)
          {
         	$this->db->open();
            $sql_check = "SELECT * FROM  post where post_url_key ='".$post_url_key."' AND post_category_id = ".$category." AND post_id != ".$updateId; 
            $chk_result = $this->db->fetchArray($this->db->query($sql_check));
            $this->db->close(); 
            if(count($chk_result)>0) {
            	throw new Exception('Post already exists', 9999);
            } else {
	            $this->db->open();
	            $query_pag_data   = "update post set post_category_id = '$category',copywriter_id = '$writer',post_title='$postTitle',
	            post_cms_small = '$shortDesc',post_heading = '$postHead',post_subheading = '$subHead',post_released = '$postReleased',post_image = '$postImage',post_cms = '$post',post_type = '$postType', post_meta_title='".addslashes($metaTitle)."', post_meta_keywords='".addslashes($metaKeywords)."', post_meta_description='".addslashes($metaDesc)."', post_share_description='".addslashes($shareDesc)."',post_share_title='$post_share_title',sugPageTitle1 = '".addslashes($sugPagetitle1)."',sugPageDesc1= '".addslashes($sugPageDesc1)."',sugPageLink1= '".addslashes($sugPageLink1)."', sugPageTitle2= '".addslashes($sugPageTitle2)."',sugPageDesc2= '".addslashes($sugPageDesc2)."' ,sugPageLink2= '".addslashes($sugPageLink2)."',sugPageTitle3= '".addslashes($sugPageTitle3)."' ,sugPageDesc3= '".	addslashes($sugPageDesc3)."',sugPageLink3= '".addslashes($sugPageLink3)."',sugPageTitle4= '".addslashes($sugPageTitle4)."' , sugPageDesc4= '".addslashes($sugPageDesc4)."' ,sugPageLink4='".addslashes($sugPageLink4)."', premium_news='".addslashes($premium_news)."' where post_id = '$updateId'";
				$results = $this->db->query($query_pag_data );
		    	$this->db->close();

		    	//Vigneswaran Code for Archeive posts

		    	$this->db->open();
		    	$current_date=str_replace('/','-',date("Y/m/d"));
		    	$query_pag_data   = "SELECT id,SUBSTRING_INDEX(post_datetime,' ',1) AS column_date FROM `archeive_post` WHERE  post_title='$postTitle' HAVING DATEDIFF('$current_date',column_date) < '15'";
		    	$result1=$this->db->query($query_pag_data );
		    	$result = $this->db->fetchArray($this->db->query($query_pag_data));

		    	$query_match   = "SELECT id,post_cms FROM `archeive_post` WHERE  post_title='$postTitle' ORDER BY id DESC LIMIT 1";
		    	$result_match=$this->db->query($query_match);
		    	$query_match_result = $this->db->fetchArray($this->db->query($query_match));

		    	$this->db->close();
				$regex = "#" . preg_quote("{", "#") 
									. '(.*?)' 
									. preg_quote("}}", "#") 
									. "#" 
									. 's';
				preg_match($regex,$post,$graph);
				$graph_code ='<p class="hide">'.$graph[0]."</p>";

				$delimiter = '#';
				$startTag = 'Recent Data Trend';
				$endTag = 'Brief';
				$regex = $delimiter . preg_quote($startTag, $delimiter) 
									. '(.*?)' 
									. preg_quote($endTag, $delimiter) 
									. $delimiter 
									. 's';
				preg_match($regex,$post,$matches);
				
				
				$variables = array("Recent Data Trend :", "Brief","Recent Data Trend:","Recent Data Trend","http://","https://");
				$replacements   = array("","","","","","");
				$post = strip_tags(str_ireplace($variables, $replacements, $matches[0]));
				$post_cms = str_ireplace($variables, $replacements, $matches[0]);
				$post_cms = $graph_code.$post_cms;
				
				//getting updated date
				$value=strip_tags($vid_desc);
				$delimiter = '#';
				$startTag = 'Updated till';
				$endTag = '(';
				$regex = $delimiter . preg_quote($startTag, $delimiter) 
									. '(.*?)' 
									. preg_quote($endTag, $delimiter) 
									. $delimiter 
									. 's';
				preg_match($regex,$value,$updated_date);
				
            	if(empty($updated_date)){
            		$updated_date="";
            	} else {
            		$updated_date=$updated_date[1];
            	}
				if(stripslashes($post) != stripslashes($query_match_result[0]["post_cms"]) || $query_match_result[0]["updated_date"] != $updated_date){
			    	if(mysqli_num_rows($result1) == 0){
			    		$this->db->open();
			            $query_pag_data   = "INSERT INTO archeive_post set post_title='$postTitle',post_id='$updateId',post_released = '$postReleased',post_cms = '$post_cms',post_heading = '$postHead',updated_date = '$updated_date'";
						$results = $this->db->query($query_pag_data);
				    	$this->db->close();
			    	} else {
			    		$this->db->open();
			    		$archeive_post_id=$result[0]["id"];
			            $query_pag_data   = "UPDATE archeive_post set post_title='$postTitle',
			            post_released = '$postReleased',post_cms = '$post_cms',post_heading = '$postHead',updated_date = '$updated_date' where id = '$archeive_post_id'";
						$results = $this->db->query($query_pag_data);
				    	$this->db->close();
			    	}
		   		}	
	            return $results;
         	}
        }
        
         function changeStatus($postId,$status){
            if($status == 'N'){
                $status = 'Y';
            }
            else{
                $status = 'N';
            }
            $this->db->open();
            $query   = "update  post set post_publish_status  = '$status' where post_id = '$postId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;
            
        }
		
		function updateMailTemplate($updateId,$code,$subj,$message,$varia)
		{
			$this->db->open();
			$query   = "update  email_templates  set   email_templates_code = '$code' , email_templates_subject = '$subj' , email_templates_message = '$message' , email_templates_variable = '$varia'  where email_templates_id = '$updateId'";
			$results = $this->db->query($query);
			$this->db->close();
		}
		
		function selectEmailAlertMembers($catId)
		{
           
            $this->db->open();
            $query   = "SELECT u.fname AS name ,u.email AS address FROM user_accounts AS  u  WHERE ((FIND_IN_SET('$catId',want_to_email_alert)>0) AND breaking_News_Alert = 'Y') AND u.user_status_id = 4 ORDER BY u.id DESC";
			$usertList = $this->db->fetchArray($this->db->query($query));
	        $this->db->close();
            return $usertList;
            
        }
		
		function selectEmailAlertMembersForReports()
		{
            $this->db->open();
            $query   = "SELECT u.fname AS name ,u.email AS address FROM user_accounts AS  u  WHERE u.user_status_id = 4 ORDER BY u.id DESC";
			$usertList = $this->db->fetchArray($this->db->query($query));
	        $this->db->close();
            return $usertList;
        }
		
		function selectEmailAlertMembersForReportsByLimits($start,$end)
		{
            $this->db->open();
            $query   = "SELECT u.fname AS name ,u.email AS address FROM user_accounts AS  u  WHERE u.user_status_id = 4 ORDER BY u.id DESC LIMIT $start,$end";
			$usertList = $this->db->fetchArray($this->db->query($query));
	        $this->db->close();
            return $usertList;
        }
		
		function selectEmailAlertMembersByLimits($catId,$start,$end)
		{
           
            $this->db->open();
            $query   = "SELECT u.fname AS name ,u.email AS address FROM user_accounts AS  u  WHERE FIND_IN_SET('$catId',want_to_email_alert)>0 AND u.id != '1680' AND u.user_status_id = 4 ORDER BY u.id DESC  LIMIT $start,$end";
			
			$usertList = $this->db->fetchArray($this->db->query($query));
	        $this->db->close();
			
            return $usertList;
            
        }
        
		
		function selectMailTemplate($mId)
		{
           
            $this->db->open();
            $query   = "SELECT `email_templates_id`,`email_templates_code`,`email_templates_subject`,`email_templates_message`,`email_templates_variable` FROM email_templates WHERE email_templates_id=$mId";
			$usertList = $this->db->fetchArray($this->db->query($query));
	        $this->db->close();
            return $usertList;
            
        }
		
		
		function selectMailTemplateByCode($code)
		{
           
            $this->db->open();
            $query   = "SELECT `email_templates_id`,`email_templates_code`,`email_templates_subject`,`email_templates_message`,`email_templates_variable` FROM email_templates WHERE email_templates_code='".$code."'";
			$usertList = $this->db->fetchArray($this->db->query($query));
	        $this->db->close();
            return $usertList;
            
        }
        
        
        function deletePost($postId){
            
            $this->db->open();
            $query_pag_data   = "delete from post_details  where id = '$postId'";
            $results = $this->db->query($query_pag_data );
            if($results == 1){
                $query   = "delete from comment_details  where post_id = '$postId'";
                $results = $this->db->query($query);
            }
	    $this->db->close();
            return $results;
            
        }
	
	
	function getmaxId()
	{
	  $this->db->open();
	    $sql1 = "select max(id) from `post_details`";
		$idPost=$this->db->fetchArray($this->db->query($sql1));
		$idPost=$idPost[0]['max(id)'];
		$this->db->close();
		return $idPost;
	}
        
        
        function deleteJmaPost($postId){
            
                $this->db->open();		
                $query   = "DELETE FROM post WHERE post_id='$postId'";            
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;
            
        }
        
        function deleteJmaPostQue($postId){
            
                $this->db->open();		
                $query   = "DELETE FROM post_email_queue WHERE post_id='$postId'";            
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;
            
        }
        
        function getThisPostCategoryId($pId) {
	        $this->db->open();
		    $sql1 = "select `post_category_id` from `post` where `post_id`=$pId";
			$idPost=$this->db->fetchArray($this->db->query($sql1));
			$idPost=$idPost[0]['post_category_id'];
			$this->db->close();
			return $idPost;
        }
        
        function getAllPostTitlesForThisCategory($catId){
            $this->db->open();
		    $sql1 = "select `post_id`,`post_title` from `post` where `post_category_id`=$catId AND `post_publish_status` = 'Y'";
			$posts=$this->db->fetchArray($this->db->query($sql1));
			$this->db->close();
			return $posts;
        }
		
		function deletePostImage($pId){
			$this->db->open();
		    $sql1 = "select `post_image` from `post` where `post_id`=$pId";
			$idPost=$this->db->fetchArray($this->db->query($sql1));
			if($idPost){
				$query   = "update  post set post_image  = DEFAULT where post_id = $pId";
				$results = $this->db->query($query);
			}
			else{
				$results = 'No records found.';
			}
			$this->db->close();
			return $results;
		}

		
		
		public function getAllParentCategoriesByCategoryId($post_cat_id)
		{
			$this->db->open();	
			$result_arr = array();
			$sql = "CALL getAllParentCategoriesByCategoryId(".$post_cat_id.")";
			$rs = $this->db->query($sql);
			if($this->db->numRows($rs)>0) {
				while ($rw = $this->db->fetchArray($rs)) {
					$result_arr = $rw;
				}
			}
			$this->db->close();
			/* echo "<pre>";
			print_r($result_arr); */
			return $result_arr;		
	    }
		
		public function getCategotyArrayParsedIntoPath($cat_array) 
		{
			$response = '';
			if(is_array($cat_array)) {
				foreach ($cat_array as $rw_cat) {
					$response.=$rw_cat['category_url'].'/';
				}
			}
			return $response;
	    }
} 

?>
