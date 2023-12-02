<?php include('controlPanel.php');
require SERVER_ROOT.'/vendor/vendor_mailgun/autoload.php';
use \Mailgun\Mailgun;
$id= $_REQUEST['id'];
$status= $_REQUEST['status'];
$postType= $_REQUEST['postType'];
$insertArray = array();
$statusChage  = $postObj->changeStatus($id,$status);
//$getUsers   = $userObj->getUserList();
/*if(count($getUsers)>0){    for($i=0;$i<count($getUsers);$i++){        $userId = $getUsers[$i]['user_id'];        $insertArray['post_id']        = $id;        $insertArray['user_id']        = $userId;        $userObj ->addCronQueue($insertArray);    }}*/
$userObj->changeMailQuePostStatus($id);
/*
$cat_id = $postObj->getThisPostCategoryId($id);
$catObj->updateNewIcon($cat_id, 'N') ;
*/
                        $db	     = new mysql();
						$db->open();
						
						
						
						
						$mgClient = new MailGun(env('MailGunAPI'));
						
						
						// $mgClient = $mgObject->Mailgun;
						// $domain = $mgObject->domain; 

						$domain = 'mg.japanmacroadvisors.net';
						
						require_once('lib/class.post.php');
						$postCategory = new post();
						
						
						// check weather post type is news or page code 
						
						$postDels   = "select * from post where post_id='$id' and post_type = 'N'";
						$postDetailsQuey = $db->query($postDels);
						$postFetchRlts = $db->fetchArray($postDetailsQuey);
						
						

                        if($postType=="N" && $postFetchRlts[0]['post_publish_status'] == "Y" && $postFetchRlts[0]['post_mail_notification'] == "N" )
						{
							
							
							$uniquetime=time();
							
							$out = '';
							
							try
							{
								
								
								$out.= "***************** SendNewPostNotification - START"."<br><br>";
								
								$postQuery   = "select * from post where post_id='$id' and post_type = 'N' and post_publish_status = 'Y'";
								$postDetails = $db->query($postQuery);
								$rs_rw = array();
								if($db->numRows($postDetails)>0)
								{
											while($rw_pdt = $db->fetchArray($postDetails)) {
												$rs_rw = $rw_pdt;
											}



											$postCategory_id = $rs_rw[0]['post_category_id'];

											$category_array = $postCategory->getAllParentCategoriesByCategoryId($postCategory_id);
											$category_path = $postCategory->getCategotyArrayParsedIntoPath($category_array);
											$posrURL = $category_path.$rs_rw[0]['post_url'];

											$postTitle = stripslashes($rs_rw[0]['post_title']);
											$out.= '******* New Post identified : '.$postTitle."<br>";

											$link = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/reports/view/'.$posrURL;
											$out.= '******* New URL identified : '.$link."<br>";
											$postDesc  = stripslashes($rs_rw[0]['post_cms_small']);

											$mailSubject = 'JMA - '.$postTitle;
											
											
										$mailTemplate = $postObj->selectMailTemplate('15');
										
										$name = '<b>%recipient%</b>';
										$userEmail = '%recipient_email%';
										$title = $postTitle;
										$desc = $postDesc;
										$newsLink = $link;
										$phrase  = $mailTemplate[0]['email_templates_message'];
										$variable = array("{{name}}", "{{Title}}", "{{Summary}}","{{Link}}","{userEmail}");
										$replacement   = array($name,$title,$desc,$newsLink,$userEmail);

										$mailBody = str_replace($variable, $replacement, $phrase);
										
										
										$mailSubject = str_replace("{{Title}}",$postTitle,$mailTemplate[0]['email_templates_subject']); 
										
										

											/* $mailBody = '<html>'.'Dear <b>%recipient%</b>,'.'<br/>'.$postTitle.'<br/>
											Summary<br/>
											'.$postDesc.'<br/><br/>
											For more: please see<br/><br/>
											<a href="'.$link.'" >'.$link.'</a><br/><br/>
											And www.japanmacroadvisors.com for other reports.<br/><br/>
											Takuji Okubo<br/><br/>

											Principal and Chief Economist<br/>
											Japan Macro Advisors<br/><br/>

											mail:takuji.okubo@japanmacroadvisors.com<br/>
											www.japanmacroadvisors.com<br/><br/></html>'; */
											
											
											
											// update post mail notification sent updation query
												
										   $updateQuery = "UPDATE post SET post_mail_notification = 'Y' WHERE post_id='$id' and  post_mail_notification= 'N' ";
										   $postNotifinationUpdate = $db->executeQuery($updateQuery);
											
											
											$result = $mgClient->sendMessage($domain, array(
													'from'    => 'Japan Macro Advisors <japanmacroadvisors@gmail.com>',
													'to'      => env('MailGunListAddress'),
													'subject' => $mailSubject,
													'html'    => $mailBody,
													'o:tag'   => array($uniquetime)
											));
											
											
											// Time dellay for 10 seconds after get  failed  mail lists
											sleep(10);
											
											// sent unsubscribe user list to JMA admin
											
											$queryString = array(
												'subject'        => $mailSubject,
												'tags'           => $uniquetime,
												'event'          => 'failed'   
											);

											# Make the call to the client.
											$result = $mgClient->get("$domain/events",$queryString);
										
											$resultResponse = $result->http_response_body;
											
											$numOfunSubs = $resultResponse->items;
											if(count($numOfunSubs) >0)
											{
												
												$UnsubList = '';
												foreach($numOfunSubs as $Lists)
												{
													
													
													$UnsubList.= $Lists->recipient.','.'<br/>';
												}
												$userList =  substr($UnsubList,0,-6);
												
												$mailBody = "";
							
												$mailBody = "<html>Hi Team ,<br/>
												New post notification mail not sent unsubscribe user mail address lists,<br/><br/>";
												$mailBody.=$userList;
												$mailBody.="<br/><br/>
												For more: please see<br/>
												https://mailgun.com<br/>
												</html>";
												
												$mailSubject = "Not send ".$postTitle." post notification - Unsubscribe User Lists";
												$result = $mgClient->sendMessage($domain, array(
														'from'    => 'info@mg.japanmacroadvisors.net',
														'to'      => env('JmaDevTeam'),
														'subject' => $mailSubject,
														'html'    => $mailBody
												));
												
												
											}
											

								}
								else
								{
									$out.= "**** Error..! User does not exists / User not subscribed (Post Id : ".$id.")"."<br>";
									
								}
								
								$out.= "<br>"."***************** SendNewPostNotification - END"."<br><br>";
								
							}
							catch (Exception $ex) 
							{
								$out.="<br><br>"."ERROR....!".$ex->getMessage()." ( ".$ex->getCode()." )";
							}
							
							
							$mailSubject = "Send new post notification - MailGun status";
							$result = $mgClient->sendMessage($domain, array(
									'from'    => 'Japan Macro Advisors <japanmacroadvisors@gmail.com>',
									'to'      => env('JmaDevTeam'),
									'subject' => $mailSubject,
									'html'    => $out
							));
							
							
                            $db->close();
						}
						


$return_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'listPost.php';

//echo $return_url;
header("Location:$return_url");

exit(0);
?>