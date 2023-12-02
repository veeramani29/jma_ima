<?php
include('header.php');
require SERVER_ROOT.'/vendor/vendor_mailgun/autoload.php';
use \Mailgun\Mailgun; ?>
<style   type="text/css">
        #imgContainer
        {
            height: 100%;
            width: 100%;
            position: absolute;
        }
        #divProgressLayer
        {
            z-index: 999;
    position: fixed;
    background-color: rgba(255,255,255,0.8);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
        }
		#divProgressLayer > img{
			position: absolute;
    top: calc(50% - 120px);
    left: calc(50% - 120px);
		}
</style>
<script language="javascript">
var href = window.location.href.split('/');
if(href[2] == "localhost")
{
	var pathName = href[0]+'//'+href[2]+'/'+href[3];
}
else
{
	var pathName = href[0]+'//'+href[2];
}

    $(document).ready(function() {
		$('#post_type').change(function() {
    	 	if($(this).val()=='P'){
    	 		$('#premium_news_').hide();
    	 	}else{
				$('#premium_news_').show();
    	 	}
    	 });
		/* tinymce.init({
			selector: "textarea#vid_desc",
			theme: "modern",
			paste_data_images: true,
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak lineheight",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview media | forecolor backcolor emoticons | sizeselect | fontselect |  fontsizeselect | lineheightselect",
			fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
			lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
			image_advtab: true,
			relative_urls : false,
			remove_script_host : false,
			link_assume_external_targets: true,
			file_picker_callback: function(callback, value, meta) {
				if (meta.filetype == 'image') {
					$('#upload').trigger('click');
					$('#upload').on('change', function() {
						var file = this.files[0];
						var reader = new FileReader();
						reader.onload = function(e) {
							callback(e.target.result, {
								alt: ''
							});
						};
						reader.readAsDataURL(file);
					});
				}
			},
			external_plugins: {
				'lineheight': pathName+'/js/tinymce-line-height-plugin-master/lineheight/plugin.min.js'
			},
			templates: [{
				title: 'Test template 1',
				content: 'Test 1'
			}, 
			{
				title: 'Test template 2',
				content: 'Test 2'
			}]
		}); */
		//fontselect
		tinymce.init({
            selector: "textarea#vid_desc",
            theme: "modern",
            paste_data_images: true,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak lineheight",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons | sizeselect  |  fontsizeselect | lineheightselect",
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
            image_advtab: true,
			relative_urls : false,
			remove_script_host : false,
			link_assume_external_targets: true,
			automatic_uploads: true,
			image_title: true, 
			images_upload_url: 'postAcceptor.php',
			file_picker_types: 'image', 
            external_plugins: {
                'lineheight': pathName+'/admin/js/tinymce-line-height-plugin-master/lineheight/plugin.min.js'
            },
            templates: [{
                title: 'Test template 1',
                content: 'Test 1'
            }, 
            {
                title: 'Test template 2',
                content: 'Test 2'
            }]
        });
		
		
		
		
		
        $('#add_post').submit(function() {
            var ret = true;
            $('#writer_error').html('');  $('#desc_error').html('');$('#mainCat_error').html(''); $('#desc_error').html('');$('#title_error').html('');$('#post_error').html('');
           // $('#post_head_error').html('');$('#sub_head_error').html('');
            var mainCat  = $('#main_cat').val();
            var writer      =   $('#copy_writer').val();  
            var title      =  $('#post_title').val();  
            var shortdesc  =  $('#short_desc').val();
            var subHead     = $('#sub_head').val();
            var postHead    = $('#post_head').val();
            var post       =  $('#vid_desc').val();  
            
            if(mainCat == ''){
                $('#mainCat_error').html('Please select category.');
                ret =  false;
            }
            
             if(writer == ''){
                $('#writer_error').html('Please select a copy writer.');
                ret =  false;
            }
            
             if(title == ''){
                $('#title_error').html('Please enter post title.');
                ret =  false;
            }
            
             if(shortdesc == ''){
                $('#desc_error').html('Please enter short Description.');
                ret =  false;
            }
            
            /* if(postHead == ''){
                $('#post_head_error').html('Please enter post heading.');
                ret =  false;
            }
            
            if(subHead == ''){
                $('#sub_head_error').html('Please enter sub heading.');
                ret =  false;
            }*/
            
           var editorcontent = tinymce.get('vid_desc').getContent().replace(/<[^>]*>/gi, '');
             
            if(editorcontent.length){}
            else{
            $('#post_error').html('Please enter post');
            ret =  false;
            }
             if(ret == false){
                $('#writer_error').focus();
                ret =  false;
            }
			
			ckeboxStatus = document.getElementById("txt_user_sent_alert").checked;
			if(ckeboxStatus == true)
			{
				document.getElementById("divProgressLayer").style.display = "block";
			}
			
			
			
			var suggesPageTitle1 = 	$('#sugPageTitle1').val();
            var suggesPageDesc1 = 	$('#sugPageDesc1').val();
			var suggesPageLink1 = 	$('#sugPageLink1').val();
            
             if(suggesPageTitle1 !="")
			 {
				 if(suggesPageDesc1 == "")
				 {
					 alert("Please enter page 1 description");
					 $('#sugPageDesc1').focus();
					 return false;
				 }
				 
				 if(suggesPageLink1 == "")
				 {
					 alert("Please enter page 1 link");
					 $('#sugPageLink1').focus();
					  return false;
				 }
			 }
			 
			 
			 
			var suggesPageTitle2 = 	$('#sugPageTitle2').val();
            var suggesPageDesc2 = 	$('#sugPageDesc2').val();
			var suggesPageLink2 = 	$('#sugPageLink2').val();
            
             if(suggesPageTitle2 !="")
			 {
				 if(suggesPageDesc2 == "")
				 {
					 alert("Please enter page 2 description");
					 $('#sugPageDesc2').focus();
					 return false;
				 }
				 
				 if(suggesPageLink2 == "")
				 {
					 alert("Please enter page 2 link");
					 $('#sugPageLink2').focus();
					  return false;
				 }
			 } 
			 
			 
			var suggesPageTitle3 = 	$('#sugPageTitle3').val();
            var suggesPageDesc3 = 	$('#sugPageDesc3').val();
			var suggesPageLink3 = 	$('#sugPageLink3').val();
            
             if(suggesPageTitle3 !="")
			 {
				 if(suggesPageDesc3 == "")
				 {
					 alert("Please enter page 3 description");
					 $('#sugPageDesc3').focus();
					 return false;
				 }
				 
				 if(suggesPageLink3 == "")
				 {
					 alert("Please enter page 3 link");
					 $('#sugPageLink3').focus();
					  return false;
				 }
			 }
			
			var suggesPageTitle4 = 	$('#sugPageTitle4').val();
            var suggesPageDesc4 = 	$('#sugPageDesc4').val();
			var suggesPageLink4 = 	$('#sugPageLink4').val();
            
             if(suggesPageTitle4 !="")
			 {
				 if(suggesPageDesc4 == "")
				 {
					 alert("Please enter page 4 description");
					 $('#sugPageDesc4').focus();
					 return false;
				 }
				 
				 if(suggesPageLink4 == "")
				 {
					 alert("Please enter page 4 link");
					 $('#sugPageLink4').focus();
					  return false;
				 }
			 }


            
            return ret;
     });
    });
    function Checkfiles()
	{
		var fup = document.getElementById('postImageUpload');
		var fileName = fup.value;
		var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
		var size = fup.files[0].size;
		if(ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG")
		{
			return true;
		} 
		else
		{
			$('#postImage_error').html('Upload Jpg or png images only');
			fup.focus();
			return false;
		}
		if(size > MAX_SIZE){
			$('#postImage_error').html("Maximum file size exceeds");
			fup.focus();
			return false;

		}else{
			return true;
		}	
	}
    
</script>

<?php
$errorMsg = '';
$insertArray = array();

$postTypeArr  = array("N"=>"News","P"=>"Page");
 
$id = $_REQUEST['id'];

if($id == ''){
    header("Location:listpost.php");
}

$myPosts = $postObj->getPostDetails($id);
$insertArray['post_category_id'] = $myPosts[0]['post_category_id'];
$insertArray['copywriter_id'] = stripslashes($myPosts[0]['copywriter_id']);
$insertArray['post_title'] = stripslashes($myPosts[0]['post_title']);
$insertArray['post_cms_small'] = stripslashes($myPosts[0]['post_cms_small']);
$insertArray['post_heading'] = stripslashes($myPosts[0]['post_heading']);
$insertArray['post_subheading'] = stripslashes($myPosts[0]['post_subheading']);
$insertArray['post_released'] = stripslashes($myPosts[0]['post_released']);
$insertArray['post_image'] = stripslashes($myPosts[0]['post_image']);
$insertArray['post_cms'] = stripslashes(cleanMyCkEditor($myPosts[0]['post_cms']));
$insertArray['post_meta_title'] = stripslashes($myPosts[0]['post_meta_title']);
$insertArray['post_share_title'] = stripslashes($myPosts[0]['post_share_title']);
$insertArray['post_share_description'] = stripslashes($myPosts[0]['post_share_description']);
$insertArray['post_meta_keywords'] = stripslashes($myPosts[0]['post_meta_keywords']);
$insertArray['post_meta_description'] = stripslashes($myPosts[0]['post_meta_description']);
$insertArray['post_url'] = $myPosts[0]['post_url'];
$insertArray['post_url_key'] = $myPosts[0]['post_url_key'];
$insertArray['premium_news'] = $myPosts[0]['premium_news'];

$insertArray['sugPageTitle1'] = $myPosts[0]['sugPageTitle1'];
$insertArray['sugPageDesc1'] = $myPosts[0]['sugPageDesc1'];
$insertArray['sugPageLink1'] = $myPosts[0]['sugPageLink1'];

$insertArray['sugPageTitle2'] = $myPosts[0]['sugPageTitle2'];
$insertArray['sugPageDesc2'] = $myPosts[0]['sugPageDesc2'];
$insertArray['sugPageLink2'] = $myPosts[0]['sugPageLink2'];

$insertArray['sugPageTitle3'] = $myPosts[0]['sugPageTitle3'];
$insertArray['sugPageDesc3'] = $myPosts[0]['sugPageDesc3'];
$insertArray['sugPageLink3'] = $myPosts[0]['sugPageLink3'];

$insertArray['sugPageTitle4'] = $myPosts[0]['sugPageTitle4'];
$insertArray['sugPageDesc4'] = $myPosts[0]['sugPageDesc4'];
$insertArray['sugPageLink4'] = $myPosts[0]['sugPageLink4'];


$postType = stripslashes($myPosts[0]['post_type']);

//echo "post is ;".$insertArray['post_cms'];

//echo "insertArry " .$insertArray['post_category_id'];

if(isset($_POST['delImage'])){
	$deleteImageRes = $postObj->deletePostImage($id);
	if($deleteImageRes == 1){
		$file = "../public/uploads/ckImages/".$insertArray['post_image'];
		unlink($file);
		header('Location:editpost.php?id='.$id);
		exit();
	}
}

function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
}

if(isset($_POST['postAdd'])){
	
	
      
	if($_POST['postAdd']){
				if(!empty($_FILES['postImageUpload']['name'])){
					$errors= array();
					$file_name = $_FILES['postImageUpload']['name'];
					$file_size = $_FILES['postImageUpload']['size'];
					$file_tmp = $_FILES['postImageUpload']['tmp_name'];
					$file_type = $_FILES['postImageUpload']['type'];
					$extension = explode('.',$_FILES['postImageUpload']['name']);
					$file_ext = $extension[1];

					$extensions = array("jpeg","jpg","png");

					if(in_array($file_ext,$extensions)=== false){
						$errors[]="extension not allowed, please choose a JPEG or PNG file.";
					}

					if($file_size > 2097152) {
						$errors[]='File size must not exceed 2 MB';
					}

										if(empty($errors)==true) {
					if($file_ext=="jpg" || $file_ext=="jpeg" )
					{
						$uploadedfile = $_FILES['postImageUpload']['tmp_name'];
						$src = imagecreatefromjpeg($uploadedfile);
					}
					else if($file_ext=="png")
					{
						$uploadedfile = $_FILES['postImageUpload']['tmp_name'];
						$src = imagecreatefrompng($uploadedfile);
					}
					else 
					{
						$src = imagecreatefromgif($uploadedfile);
					}
					list($width,$height)=getimagesize($uploadedfile);

					$newwidth=640;
					$newheight=360;
					$tmp=imagecreatetruecolor($newwidth,$newheight);

					//$newwidth1=180;
					//$newheight1=110;
					//$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
					//imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

					$filename = "../public/uploads/ckImages/". $_FILES['postImageUpload']['name'];
					//$filename1 = "../public/uploads/postImages/small". $_FILES['postImageUpload']['name'];

					imagejpeg($tmp,$filename,100);
					//imagejpeg($tmp1,$filename1,100);

					imagedestroy($src);
					imagedestroy($tmp);
					//imagedestroy($tmp1);

					//if(empty($errors)==true) {
						//move_uploaded_file($file_tmp,"../public/uploads/postImages/".$file_name);
					}else{
						$errors[] = "File upload failed.";
						print_r($errors);
						exit();
					}
				}
				else{
					$file_name = $insertArray['post_image'];
				}
				
				$updateId = $id;
                $category   = $_POST['main_cat'];
                $writer     = $_POST['copy_writer'];
                $postTitle  = trim($_POST['post_title']);
                $shortDesc  = $_POST['short_desc'];
                $postHead   = addslashes($_POST['post_head']);
                $subHead    = $_POST['sub_head'];
                $postReleased = $_POST['post_released'];
				$postImage = $file_name;
                $post       = $_POST['vid_desc'];
                $postType   = $_POST['post_type'];

				$meta_title = $_POST['meta_title'];	
				$share_title = $_POST['share_title'];
				$meta_keywords = $_POST['meta_keywords'];
				$meta_description = $_POST['meta_description'];
				$share_description = $_POST['share_description'];
				
				
				$sugPagetitle1 =  isset($_POST['sugPageTitle1']) ? $_POST['sugPageTitle1'] : "";
				$sugPageDesc1 = isset($_POST['sugPageDesc1']) ? $_POST['sugPageDesc1'] : "";
				$sugPageLink1 = isset($_POST['sugPageLink1']) ? $_POST['sugPageLink1'] : "";

				$sugPageTitle2 = isset($_POST['sugPageTitle2']) ? $_POST['sugPageTitle2'] : "";
				$sugPageDesc2 = isset($_POST['sugPageDesc2']) ? $_POST['sugPageDesc2'] : "";
				$sugPageLink2 = isset($_POST['sugPageLink2']) ? $_POST['sugPageLink2'] : "";

				$sugPageTitle3 = isset($_POST['sugPageTitle3']) ? $_POST['sugPageTitle3'] : "";
				$sugPageDesc3 = isset($_POST['sugPageDesc3']) ? $_POST['sugPageDesc3'] : "";
				$sugPageLink3 = isset($_POST['sugPageLink3']) ? $_POST['sugPageLink3'] : "";

				$sugPageTitle4 = isset($_POST['sugPageTitle4']) ? $_POST['sugPageTitle4'] : "";
				$sugPageDesc4 = isset($_POST['sugPageDesc4']) ? $_POST['sugPageDesc4'] : "";
				$sugPageLink4 = isset($_POST['sugPageLink4']) ? $_POST['sugPageLink4'] : "";
				
				
				
				
				 
                
                $postTitle  = addslashes(cleanInputField($postTitle));
                $post       = addslashes(cleanMyCkEditor($post));
                $shortDesc  = addslashes(clearTextArea($shortDesc));
                $postHead   = trim(cleanInputField($postHead));
                $subHead    = trim(cleanInputField($subHead));
                $postReleased = cleanInputField($postReleased);
				$postImage = cleanInputField($file_name);
		   
            $get_title = $_POST['post_url'];
			$key = md5($get_title);
			
                
                $category  = cleanInputField($category);
                $writer    = cleanInputField($writer);
            
                $post      = cleanInputField($post);          
                $insertArray['post_category_id'] = $category;
                $insertArray['copywriter_id'] = $writer;
                $insertArray['post_title'] = $postTitle;
                $insertArray['post_cms'] = $post;
                $insertArray['post_url'] = $get_title;
				$insertArray['post_url_key'] = $key;
				$premium_news =$insertArray['premium_news'] = $_POST['premium_news'];
                $insertArray = cleanInputArray($insertArray);
                
                if($category == '' || $writer == '' || $postTitle == '' || $shortDesc == ''  || $post == ''){
			$errorMsg ='Please enter all mandatory fields<br/>';
                       
		} else{
			   //$postObj->updatePost($updateId,$category,$writer,$postTitle,$shortDesc,$postHead,$subHead,$postReleased, $post,$postType);
		        try {
					
					
					
					$postCategory = new post();
					$postCategory_id = $_POST['main_cat'];
					$category_array = $postCategory->getAllParentCategoriesByCategoryId($postCategory_id);
					$category_path = $postCategory->getCategotyArrayParsedIntoPath($category_array);
					$posrURL = $category_path;
					$indicatorName = $category_array[2][1];
					
					
					$value = $_POST['vid_desc'];
					$script_chart = "";
					/* 
					//preg_match('/Recent(.*?)Brief overview of/', $value, $match);
					
					//preg_match_all("/{(Recent data trend[_a-z]*) ((\d|,|\||-)+)({([a-zA-Z:,\"\'&quot;]*)})*}/", $value, $matches);
					
					//$value = preg_replace('/'.preg_quote($matches[0][0]).'/', $script_chart, $value);
					
					//preg_match('#\\{Recent\\}(.+)\\{/overview\\}#s',$value,$matches);; */
					
					$delimiter = '#';
					$startTag = 'Recent Data Trend';
					$endTag = 'Brief';
					$regex = $delimiter . preg_quote($startTag, $delimiter) 
										. '(.*?)' 
										. preg_quote($endTag, $delimiter) 
										. $delimiter 
										. 's';
					preg_match($regex,$value,$matches);
					
					$variables = array("Recent Data Trend :", "Brief","Recent Data Trend:","Recent Data Trend","http://","https://");
					$replacements   = array("","","","","","");

					$resent_data = str_ireplace($variables, $replacements, $matches[0]);
					
						if($_POST['post_type'] == "N")
						{
							$indicatorName = $category_array[1][1];
							
							if($_POST['main_cat'] == "58")
							{
								$indicatorName = $_POST['post_title'];
							}
							
							$resent_data = $_POST['short_desc'];
						}
						
						
					
						if($_POST['txt_user_sent_alert'] == 1)
						{
							
							
							$mgClient= $mgObject = new MailGun(env('MailGunAPI'));
							$domain = 'mg.indiamacroadvisors.net';
							
							
							    //$usersList = $postObj->selectEmailAlertMembers($_POST['main_cat']);
								$usersList = $postObj->selectEmailAlertMembersForReports();
								
								
								
								if($_POST['post_type'] == "N")
								{
									 $usersList = $postObj->selectEmailAlertMembersForReports();
								}
								
								
								//print_r($usersList); exit;
							  
							  $numberOfUserCount = ceil(count($usersList)/1000); 
							  
							  if(!empty($usersList))
							  {
								 
								  
								if(env('APP_ENV')=="development" || env('APP_ENV')=="test")
								{
									
									$listName = 'indicator'.md5(rand());

									$listAddress = 'indicator_'.rand().'@mg.indiamacroadvisors.net';

									$result = $mgClient->post("lists", array(
										'address'     => $listAddress,
										'name' => $listName,
										'description' => 'Indicator Mailgun Dev List - '.$indicatorName
									));
									
									 $result = $mgClient->post("lists/$listAddress/members.json", array(
										'members'    => '[{"name": "Srini", "address": "srinivasan.m@japanmacroadvisors.com"},{"name": "kausani", "address": "kausani.basak@japanmacroadvisors.com"}]',
										'upsert' => true
									 )); 
									
									if(env('APP_ENV')=="development")
									{
										$link = env('APP_URL').'page/category/'.$posrURL;
										if($category_array[0][1]== "Breaking News")
										{
											$link = env('APP_URL').'reports/view/breaking-news/'.$_POST['post_url'];
										}
									}
									else if(env('APP_ENV')=="test")
									{
										$link = env('APP_URL').'page/category/'.$posrURL;
										if($category_array[0][1]== "Breaking News")
										{
											$link = env('APP_URL').'reports/view/breaking-news/'.$_POST['post_url'];
										}
									}
									else
									{
										$link = env('APP_URL').'page/category/'.$posrURL;
										if($category_array[0][1]== "Breaking News")
										{
											$link = env('APP_URL').'reports/view/breaking-news/'.$_POST['post_url'];
										}
									}
								   
								  
								   
								        $mailTemplate = $postObj->selectMailTemplateByCode('Indicator_update_notification');
										if($_POST['post_type'] == "N")
										{
											 $mailTemplate = $postObj->selectMailTemplateByCode('Indicator_update_news');
										}
										
										
										$title = $_POST['post_title'];
										$name = '<b>%recipient%</b>';
										$userEmail = '%recipient_email%';
										$post_head = $_POST['post_head'];
										$phrase  = $mailTemplate[0]['email_templates_message'];
										$variable = array("{post_title}", "{post_heading}", "{recent_data_trend}","{link}","{userEmail}","{name}");
										$replacement   = array($title,$post_head,$resent_data,$link,$userEmail,$name);

										$mailBody = str_replace($variable, $replacement, $phrase);
										
										if($resent_data == "")
										{
											$mailBody = str_replace("Summary:", "", $mailBody);
										}
										
										
										
										
										$mailSubject = str_replace("{indicator_name}",$_POST['post_head'],$mailTemplate[0]['email_templates_subject']); 
										
										$result = $mgClient->sendMessage($domain, array(
												'from'    => 'India Macro Advisors <erteam@indiamacroadvisors.com>',
												'to'      => $listAddress,
												'subject' => $mailSubject,
												'html'    => $mailBody,
												'o:tag'   => array($uniquetime)
										));
								   
								   
								}
								elseif(env('APP_ENV')=="production")
								{
								  
								  for($i=1;$i<=$numberOfUserCount;$i++)
								  {
									  //echo $i."<br>";
									 
									  if($numberOfUserCount==$i)
									  {
										   $maxVal = count($usersList);
										   $order = $i-1;
										   $miniVal = $order*1000; 
										   $endValLimit = (($maxVal)-($miniVal));
										   $start = $miniVal;
												$endLimit = $endValLimit;
										   
									  }
									  else
									  {
											if($i==1)
											{
												$start = 0;
												$endLimit = 1000;
											}	
											else
											{
												 $order = $i-1;
										         $miniVal = $order*1000; 
												$start = $miniVal;
												$endLimit = 1000;						
											}
									  }
									    //$usersListByLimit = $postObj->selectEmailAlertMembersByLimits($_POST['main_cat'],$start,$endLimit);
										$usersListByLimit = $postObj->selectEmailAlertMembersForReportsByLimits($start,$endLimit);
									  
										if($_POST['post_type'] == "N")
										{
										   $usersListByLimit = $postObj->selectEmailAlertMembersForReportsByLimits($start,$endLimit);
										}
								  
								  		$usersListByLimit_=utf8_converter($usersListByLimit);
								        $userListformembers = json_encode($usersListByLimit_,JSON_UNESCAPED_UNICODE);
										//echo json_encode($usersList); exit; JSON_PRETTY_PRINT
									
								        
										
										$listName = 'indicator'.md5(rand());

										$listAddress = 'indicator_'.rand().'@mg.indiamacroadvisors.net';

										$result = $mgClient->post("lists", array(
											'address'     => $listAddress,
											'name' => $listName,
											'description' => 'Indicator Mailgun Dev List - '.$indicatorName
										));
										
										if(env('APP_ENV')=="development")
										{
                                            $result = $mgClient->post("lists/$listAddress/members.json", array(
											'members'    => '[{"name": "Srini", "address": "srinivasan.m@japanmacroadvisors.com"}]',
											'upsert' => true
										    ));
											
											$link = env('APP_URL').'page/category/'.$posrURL;
											if($category_array[0][1]== "Breaking News")
											{
												$link = env('APP_URL').'reports/view/breaking-news/'.$_POST['post_url'];
											}
										}
										elseif(env('APP_ENV')=="test")
										{
											$result = $mgClient->post("lists/$listAddress/members.json", array(
											'members'    => '[{"name": "Srini", "address": "srinivasan.m@japanmacroadvisors.com"}]',
											'upsert' => true
										    ));
											
											$link = env('APP_URL').'page/category/'.$posrURL;
											if($category_array[0][1]== "Breaking News")
											{
												$link = env('APP_URL').'reports/view/breaking-news/'.$_POST['post_url'];
											}
										}
										elseif(env('APP_ENV')=="production")
										{
											//$userListformembers = json_encode($usersList);
											$result = $mgClient->post("lists/$listAddress/members.json", array(
											'members'    => $userListformembers,
											'upsert' => true
										    ));
											
											$link = env('APP_URL').'page/category/'.$posrURL;
											if($category_array[0][1]== "Breaking News")
											{
												$link = env('APP_URL').'reports/view/breaking-news/'.$_POST['post_url'];
											}
										}
											
										
										
										sleep(15);
										
										$mailTemplate = $postObj->selectMailTemplateByCode('Indicator_update_notification');
										if($_POST['post_type'] == "N")
										{
											 $mailTemplate = $postObj->selectMailTemplateByCode('Indicator_update_news');
										}
										
										$title = $_POST['post_title'];
										$name = '<b>%recipient%</b>';
										$userEmail = '%recipient_email%';
										$post_head = $_POST['post_head'];
										$phrase  = $mailTemplate[0]['email_templates_message'];
										$variable = array("{post_title}", "{post_heading}", "{recent_data_trend}","{link}","{userEmail}","{name}");
										$replacement   = array($title,$post_head,$resent_data,$link,$userEmail,$name);
										
										$mailBody = str_replace($variable, $replacement, $phrase);
										
										if($resent_data == "")
										{
											$mailBody = str_replace("Summary:", "", $mailBody);
										}
										
										$mailSubject = str_replace("{indicator_name}",$_POST['post_head'],$mailTemplate[0]['email_templates_subject']); 
										if($_POST['post_type'] == "N")
										{
											 
											 $mailSubject = str_replace("{indicator_name}",$_POST['post_title'],$mailTemplate[0]['email_templates_subject']); 
										}
										
										$result = $mgClient->sendMessage($domain, array(
												'from'    => 'India Macro Advisors <erteam@indiamacroadvisors.com>',
												'to'      => $listAddress,
												'subject' => $mailSubject,
												'html'    => $mailBody,
												'o:tag'   => array($uniquetime)
										));
						
						        }
						   
						   }
						   
					   } 
						   
				    }   
						
					
		        	$postObj->updatePost2($updateId,$category,$writer,$postTitle,$shortDesc,$postHead,$subHead,$postReleased,$postImage,$post,$postType, $meta_title, $meta_keywords, $meta_description,$share_description, $get_title, $key,$share_title,$sugPagetitle1,$sugPageDesc1,$sugPageLink1,$sugPageTitle2,$sugPageDesc2,$sugPageLink2,$sugPageTitle3,$sugPageDesc3,$sugPageLink3,$sugPageTitle4,$sugPageDesc4,$sugPageLink4,$premium_news,$_POST['vid_desc']);
		        	
					$successMsg = "Post added successfully.";
                    $insertArray = array(); 
                    echo $successMsg;
                    header('Location:listPost.php');
		        }catch (Exception $ex) {
		        	echo $ex->getMessage();
		        }
			
		}	
		
		
	}
}
?>
<script type="text/javascript" src="../public/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../public/plugins/ckeditor/ckfinder.js"></script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">
  <div id="divProgressLayer" style="display: none;">
	  <img src="../images/loader.gif" />
    </div>

<div id="page-heading"><h1>Edit Post</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slider images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slider images" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	
		<!-- start id-form -->
                 <form action="" name="add_post" id="add_post" method="post" enctype="multipart/form-data">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                     <tr>
                            <th valign="top"> Main Categories:</th>
                            <td>
                                <?php  $getCats = $catObj->getAllCategories();?>
                                    
                                <select name="main_cat" id="main_cat"  class="styledselect_form_1">
                                    <option value="">Select Category</option>
                                  <?php  
                                    if(count($getCats)>0){
                                         for($i=0;$i<count($getCats);$i++){
                                             $mainCatSelect   = '';
                                             
                                             $mainCatId   = $getCats[$i]['mainCatId'];
                                             $mainCatName =  $getCats[$i]['mainCatName'];
                                             
                                             if($mainCatId == $insertArray['post_category_id'])
                                             {
                                                 $mainCatSelect = 'selected="selected"';
                                             }
                                             
                                         ?>
                                            <option <?php echo $mainCatSelect?> value="<?php echo $getCats[$i]['mainCatId'] ?>"><?php echo $getCats[$i]['mainCatName'] ?></option>
                                            <?php
                                            $getSubCats = $catObj->getSubChildCategory($mainCatId);
                                            if(count($getSubCats)>0){
                                                for($j=0;$j<count($getSubCats);$j++){
                                                     $subCatSelect    = '';
                                                    $subCatId = $getSubCats[$j]['post_category_id'];
                                                    $subCatName = $mainCatName."-".$getSubCats[$j]['post_category_name'];
                                                    
                                                       if($subCatId == $insertArray['post_category_id'])
                                                        {
                                                            $subCatSelect = 'selected="selected"';
                                                        }
                                                    
                                             ?>
                                             <option <?php echo $subCatSelect ?> value="<?php echo $subCatId ?>"><?php echo $subCatName;?></option>
                                            <?php
                                                $getSubSubCats = $catObj->getSubChildCategory($subCatId);
                                                      for($k=0;$k<count($getSubSubCats);$k++){
                                                          $subSubCatSelect = '';
                                                       $subSubCatId   = $getSubSubCats[$k]['post_category_id']; 
                                                       $subSubCatName =  $subCatName."--".$getSubSubCats[$k]['post_category_name']; 
                                                       
                                                        if($subSubCatId == $insertArray['post_category_id'])
                                                        {
                                                            $subSubCatSelect = 'selected="selected"';
                                                        }
                                                      ?>
                                                       <option <?php echo $subSubCatSelect?>  value="<?php echo $subSubCatId ?>"><?php echo $subSubCatName;?></option>
                                                 <?php
                                                      }
                                                }
                                              }
                                            
                                            }
                                    }
                                    ?>
                                    
		           </select>
                                 <label for="mainCat" class="error" id="mainCat_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Copy writers</th>
                            <td>
                                <?php  $getWriters = $copywriterObj->getActiveCopyWriters();?>
                                    
                                <select name="copy_writer" id="copy_writer"  class="styledselect_form_1">
                                    <option value="">Select Copy writer</option>
                                  <?php  
                                    if(count($getWriters)>0){
                                         for($i=0;$i<count($getWriters);$i++){
                                             $copySelected = '';
                                             if($insertArray['copywriter_id'] == $getWriters[$i]['copywriter_id']){
                                                 $copySelected = 'selected = "selected"';
                                             }
                                         ?>
                                            <option <?php echo $copySelected ?> value="<?php echo $getWriters[$i]['copywriter_id'] ?>"><?php echo $getWriters[$i]['copywriter_user'] ?></option>
                                       <?php                                                
                                            }
                                    }
                                    ?>
                                    
		           </select>
                                 <label for="copy" class="error" id="writer_error"></label>
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top"> Post Title:</th>
                            <td>
                                <input type="text" name="post_title" value="<?php echo $insertArray['post_title']?>"  id="post_title" class="inp-form2" />
                                <label for="post_title" class="error" id="title_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top"> Post URL:</th>
                            <td>
                                <input type="text" name="post_url" id="post_url" class="inp-form2" value="<?php echo $insertArray['post_url'];?>" />
                                <br><font color="#ff0000">Note: Existing link won't work if changed.</font>
                                <label for="post_url" class="error" id="post_url_error"></label>
                            </td>
                            <td></td>
                    </tr>                     
                     <tr>
                            <th valign="top"> Post Heading:</th>
                            <td>
                                 <input type="text" name="post_head" id="post_head" value="<?php echo $insertArray['post_heading'] ?>" class="inp-form" />
                                <label for="post_head" class="error" id="post_head_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                      
                    
                    
                    <tr>
                            <th valign="top"> Post Sub heading:</th>
                            <td>
                                 <input type="text" name="sub_head" id="sub_head" value="<?php echo $insertArray['post_subheading'] ?>" class="inp-form" />
                                <label for="sub_head" class="error" id="sub_head_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top"> Post Released:</th>
                            <td>
                                 <input type="text" name="post_released" value="<?php echo $insertArray['post_released'] ?>" id="post_released" class="inp-form" />
                                <label for="post_released" class="error" id="post_released"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top"> Short Description:</th>
                            <td>
                                 <textarea name="short_desc" id="short_desc" rows="" cols="" class="form-textarea"><?php echo $insertArray['post_cms_small']?></textarea>
                                <label for="shortDesc" class="error" id="desc_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top"> Post Image:</th>
                            <td>
							<?php if(!empty($insertArray['post_image'])){ ?>
								<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/public/uploads/ckImages/<?php echo $insertArray['post_image']; ?>" target="_blank">Image Preview</a>
								<input type="submit" name="delImage" onchange="Checkfiles()" value="Delete" class="inp-submit" />
							<?php }else { ?>	
                               <input type="file" name="postImageUpload" id="postImageUpload" class="inp-form" />   
							<?php } ?>	
                            </td>
                            <td></td>
                    </tr>
					
                     <!--<tr>
                            <th valign="top"> Post</th>
                            <td>
                                <textarea  name="vid_desc" id="vid_desc" cols="5" rows="8"  ><?php echo $insertArray['post_cms']?></textarea>
						<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'vid_desc',{
										height:"<?php echo CKH;?>", width:"<?php echo CKW;?>"
										} );
							CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
						   }
						  </script>
                                <label for="post" class="error" id="post_error"></label>
                            </td>
                            <td></td>
                    </tr>--->
					
					<tr>
                            <th valign="top"> Post</th>
                            <td>
                                <textarea  name="vid_desc" id="vid_desc" cols="5" rows="8"  ><?php echo $insertArray['post_cms']?></textarea>
						<!--<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'vid_desc',{
										height:"<?php echo CKH;?>", width:"<?php echo CKW;?>"
										} );
							CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
						   }
						  </script>-->
						  <input name="image" type="file" id="upload" class="hidden" onchange="">
                                <label for="post" class="error" id="post_error"></label>
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top">Meta Title:</th>
                            <td>
                                 <input type="text" name="meta_title" id="meta_title" class="inp-form"  value="<?php echo $insertArray['post_meta_title'];?>" />
                            </td>
                            <td></td>
                    </tr>
					 <tr>
                            <th valign="top">Share Title:</th>
                            <td>
                                 <input type="text" name="share_title" id="share_title" class="inp-form"  value="<?php echo $insertArray['post_share_title'];?>" />
							</td>
                            <td></td>
                    </tr>
					<tr>
                            <th valign="top">Share Description:</th>
                            <td>
                                 <input type="text" name="share_description" id="share_description" class="inp-form2" 
								 value="<?php echo $insertArray['post_share_description'];?>" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Keywords:</th>
                            <td>
                                 <input type="text" name="meta_keywords" id="meta_keywords" class="inp-form2"  value="<?php echo $insertArray['post_meta_keywords'];?>" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Description:</th>
                            <td>
                                 <input type="text" name="meta_description" id="meta_description" class="inp-form2"  value="<?php echo $insertArray['post_meta_description'];?>" />
                            </td>
                            <td></td>
                    </tr>
                    
                      <tr>
                    
                     <tr>
                            <th valign="top">Post Type</th>
                            <td>
                                <?php $newPstArray = array_keys($postTypeArr); ?>
                                    
                                <select name="post_type" id="post_type"  class="styledselect_form_1">
                                    
                                  <?php  
                                    if(count($newPstArray)>0){
                                         for($i=0;$i<count($newPstArray);$i++){
                                             $selected = '';
                                             if($postType == $newPstArray[$i] ){
                                                 $selected = 'selected="selected"';
                                             }
                                         ?>
                                            <option value="<?php echo $newPstArray[$i]?>" <?php echo $selected?>><?php echo $postTypeArr[$newPstArray[$i]]; ?></option>
                                       <?php                                                
                                            }
                                    }
                                    ?>
                                    
		           </select>
                                 <label for="copy" class="error" id="writer_error"></label>
                            </td>
                            <td></td>
                    </tr>
					
					<tr id="premium_news_" <?php if($postType=='P'){ ?> style="display:none;" <?php } ?>>   
                    <th>News hide to free user ?:</th>
                    <td >
                            <input type="radio" value="Y" name="premium_news" id="premium_news"   <?php if($insertArray['premium_news'] == 'Y') { echo "checked"; } ?> /> Yes
							<input type="radio" value="N" name="premium_news" id="premium_news"   <?php if($insertArray['premium_news'] == 'N') { echo "checked"; } ?> />  No
							
                    </td>
                    <td></td>
                   </tr>
					<tr>
                  <th colspan="3">
                    <h2>Suggested Pages</h2>
                  </th>
                </tr>
                <tr>
                  <td colspan="3">
				  <?php if($insertArray['sugPageTitle1'] !="" && $insertArray['sugPageDesc1'] !="" && $insertArray['sugPageLink1'] !="") { ?>
                    <div id="suggestion_con" class="suggestion_con">
                      <table border="0" width="100%" cellpadding="10px" cellspacing="10px">
                        <tr>
                          <td colspan="2"><h3 id="pageSeries">Suggestion Page 1 <span style="float:right;" onclick="return callRemovePage(1);">x</span></h3></td>
                        </tr>
                        <tr>
                          <th valign="top">Title:</th>
                          <td>
                            <input type="text" name="sugPageTitle1" id="sugPageTitle1" class="inp-form2" value="<?php echo $insertArray['sugPageTitle1']; ?>" />
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Short Description:</th>
                          <td>
                            <textarea name="sugPageDesc1" id="sugPageDesc1" cols="5" rows="8" class="form-textarea"><?php echo $insertArray['sugPageDesc1']; ?></textarea>
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Link:</th>
                          <td>
                            <input type="text" name="sugPageLink1" id="sugPageLink1" class="inp-form2" value="<?php echo $insertArray['sugPageLink1']; ?>" />
                          </td>
                        </tr>
                      </table>
                    </div>
				  <?php } else { ?> 
				       <div id="suggestion_con" ></div>
				  <?php } ?>
					
					 <?php 
					
						if($insertArray['sugPageTitle2'] !="" && $insertArray['sugPageDesc2'] !="" && $insertArray['sugPageLink2'] !="") { ?>
						<div id="suggestion_con1" class="suggestion_con">
							<table border="0" width="100%" cellpadding="10px" cellspacing="10px">
                        <tr>
                          <td colspan="2"><h3 id="pageSeries">Suggestion Page 2 <span style="float:right;" onclick="return callRemovePage(2);">x</span></h3></td>
                        </tr>
                        <tr>
                          <th valign="top">Title:</th>
                          <td>
                            <input type="text" name="sugPageTitle2" id="sugPageTitle2" class="inp-form2" value="<?php echo $insertArray['sugPageTitle2']; ?>" />
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Short Description:</th>
                          <td>
                            <textarea name="sugPageDesc2" id="sugPageDesc2" cols="5" rows="8" class="form-textarea"><?php echo $insertArray['sugPageDesc2']; ?></textarea>
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Link:</th>
                          <td>
                            <input type="text" name="sugPageLink2" id="sugPageLink2" class="inp-form2" value="<?php echo $insertArray['sugPageLink2']; ?>" />
                          </td>
                        </tr>
                      </table>
					  </div>
						<?php } else { ?>
                           <div id="suggestion_con1" ></div>
						<?php } ?>
						
						
						<?php 
					
						if($insertArray['sugPageTitle3'] !="" && $insertArray['sugPageDesc3'] !="" && $insertArray['sugPageLink3'] !="") { ?>
						<div id="suggestion_con2" class="suggestion_con">
							<table border="0" width="100%" cellpadding="10px" cellspacing="10px">
                        <tr>
                          <td colspan="2"><h3 id="pageSeries">Suggestion Page 3 <span style="float:right;" onclick="return callRemovePage(3);">x</span></h3></td>
                        </tr>
                        <tr>
                          <th valign="top">Title:</th>
                          <td>
                            <input type="text" name="sugPageTitle3" id="sugPageTitle3" class="inp-form2" value="<?php echo $insertArray['sugPageTitle3']; ?>" />
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Short Description:</th>
                          <td>
                            <textarea name="sugPageDesc3" id="sugPageDesc3" cols="5" rows="8" class="form-textarea"><?php echo $insertArray['sugPageDesc3']; ?></textarea>
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Link:</th>
                          <td>
                            <input type="text" name="sugPageLink3" id="sugPageLink3" class="inp-form2" value="<?php echo $insertArray['sugPageLink3']; ?>" />
                          </td>
                        </tr>
                      </table>
					  </div>
						<?php } else { ?>
                           <div id="suggestion_con2" ></div>
						<?php } ?>
						
						
						<?php 
					
						if($insertArray['sugPageTitle4'] !="" && $insertArray['sugPageDesc4'] !="" && $insertArray['sugPageLink4'] !="") { ?>
						<div id="suggestion_con3" class="suggestion_con">
							<table border="0" width="100%" cellpadding="10px" cellspacing="10px">
                        <tr>
                          <td colspan="2"><h3 id="pageSeries">Suggestion Page 4 <span style="float:right;" onclick="return callRemovePage(4);">x</span></h3></td>
                        </tr>
                        <tr>
                          <th valign="top">Title:</th>
                          <td>
                            <input type="text" name="sugPageTitle4" id="sugPageTitle4" class="inp-form2" value="<?php echo $insertArray['sugPageTitle4']; ?>" />
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Short Description:</th>
                          <td>
                            <textarea name="sugPageDesc4" id="sugPageDesc4" cols="5" rows="8" class="form-textarea"><?php echo $insertArray['sugPageDesc4']; ?></textarea>
                          </td>
                        </tr>
                        <tr>
                          <th valign="top">Link:</th>
                          <td>
                            <input type="text" name="sugPageLink4" id="sugPageLink4" class="inp-form2" value="<?php echo $insertArray['sugPageLink4']; ?>" />
                          </td>
                        </tr>
                      </table>
					  </div>
						<?php } else { ?>
                           <div id="suggestion_con3" ></div>
						<?php } ?>
						
						
						
					
					<!--<div id="suggestion_con2"></div>
					<div id="suggestion_con3"></div>-->
                  </td>
                </tr>
                <tr>
                  <td colspan="3" id="btn_addmore" align="right">
				  <!--<a href="javascript:void(0);"  class="sugcon_btn" id="addMoreClass" style="display:none;">Add More +</a>-->
				   <?php if(($insertArray['sugPageTitle4'] =="" && $insertArray['sugPageDesc4'] =="" && $insertArray['sugPageLink4'] =="") || ($insertArray['sugPageTitle3'] =="" && $insertArray['sugPageDesc3'] =="" && $insertArray['sugPageLink3'] =="") || ($insertArray['sugPageTitle2'] =="" && $insertArray['sugPageDesc2'] =="" && $insertArray['sugPageLink2'] =="") || ($insertArray['sugPageTitle1'] =="" && $insertArray['sugPageDesc1'] =="" && $insertArray['sugPageLink1'] =="")) { ?>
                    <a href="javascript:void(0);"  class="sugcon_btn" id="addMoreClass">Add More +</a>
				   <?php } ?>	
                  </td>
                </tr>

                   
                <tr>
				  <th>&nbsp;</th>
				  <th><input type="checkbox" name="txt_user_sent_alert" id="txt_user_sent_alert"  value="0" onclick="return calluserMailAlert(this.value);" /> Alert mail sent to selected indicators users.</th>
				</tr>  
                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="postAdd" class="form-submit" />

                    </td>
                    <td></td>
                </tr>

                </table>
          </form>
	<!-- end id-form  -->

	</td>
	<td>


</td>
</tr>

</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>



<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>

<script type="text/javascript" language="javascript">
        function calluserMailAlert(userVal)
		{
			if(userVal == 0)
			{
				document.getElementById("txt_user_sent_alert").value = 1;
			}
			else
			{
				document.getElementById("txt_user_sent_alert").value = 0;
			}
        }
</script>
<script language="javascript">

function callRemovePage(indexs)
{
	
		if (confirm("Are you sure delete this suggeation page "+indexs) == true) 
		{
			var cloneIndex = $(".suggestion_con").length;
			if(indexs == 1)
			{
				$("#suggestion_con").empty();
			    $("#suggestion_con").removeClass("suggestion_con");
				$("#addMoreClass").show();
			}
			else
			{
				var pageNumNew = indexs-1;
				$("#suggestion_con"+pageNumNew).empty();
				$("#suggestion_con"+pageNumNew).removeClass("suggestion_con");
				if(cloneIndex == 4)
				{
					$("#btn_addmore").html("<a href=javascript:void(0);  class=sugcon_btn id=addMoreClass>Add More +</a>"); 
				}
				else
				{
					$("#addMoreClass").show();  
				}
				
			}
			
			
		}
}

$("#addMoreClass").live("click",clone);
$("#reMoveClass").live("click",remove);

function clone()
{
	var cloneIndex = $(".suggestion_con").length;
	var firstClone = $("#suggestion_con").length;
	
	 var noConditionFirst = $("#suggestion_con").has("table").length? "Yes" : "No";
	 
	 if(noConditionFirst == "No")
	 {
		$("#suggestion_con").addClass("suggestion_con");
		var cloneIndex = $(".suggestion_con").length;
		
		if(cloneIndex == 4)
		{
			$("#addMoreClass").hide();
		}
		$("#suggestion_con").html("<table border=\"0\" width=\"100%\" cellpadding=\"10px\" cellspacing=\"10px\"><tr><td colspan=\"2\"><h3 id=\"pageSeries\">Suggestion Page 1 <span style=\"float:right;\" onclick=\"return callRemovePage(1);\">x</span></h3></td></tr><tr><th valign=\"top\">Title:</th> <td> <input type=\"text\" name=\"sugPageTitle1\" id=\"sugPageTitle1\" class=\"inp-form2\" value=\"\" /></td></tr><tr><th valign=\"top\">Short Description:</th> <td><textarea name=\"sugPageDesc1\" id=\"sugPageDesc1\" cols=\"5\" rows=\"8\" class=\"form-textarea\"></textarea></td></tr><tr><th valign=\"top\">Link:</th><td><input type=\"text\" name=\"sugPageLink1\" id=\"sugPageLink1\" class=\"inp-form2\" value=\"\" /></td> </tr></table>");
		
		
		return false;
		
	 }   
	 
	 
	
	
	var hdttt = cloneIndex-1;
	
	for (i = 1; i <= cloneIndex; i++) { 
	  
	   var noCondition = $("#suggestion_con"+i).has("table").length? "Yes" : "No";
	   if(noCondition == "No")
	   {
		   $('#suggestion_con').clone(true).attr("id", "suggestion_con"+i).appendTo("#suggestion_con"+i);
		    var pageNum = i+1;
			$("#suggestion_con"+i+" h3").html("Suggestion Page "+pageNum);
			$("#suggestion_con"+i+" h3").append("<span style=\"float:right;\" onclick=\"return callRemovePage("+pageNum+");\">x</span>");
			var $target = $("#suggestion_con"+i);
			var i=0;
			$target.find('input').each(function(){
				
				if(i==0)
				{
					var newID = "sugPageTitle"+pageNum;
					var newName = "sugPageTitle"+pageNum;
				}
				else
				{
					var newID = "sugPageLink"+pageNum;
					var newName = "sugPageLink"+pageNum;
				}
			
				$(this).attr('id', newID);
				$(this).attr('name', newName);
				$(this).val("");
				i++;
				
			});
			
			$target.find('textarea').each(function(){
				var newID = "sugPageDesc"+pageNum;
				var newName = "sugPageDesc"+pageNum;
				$(this).attr('id', newID);
				$(this).attr('name', newName);
				$(this).val("");
			}); 
			return false;
	   }
	   
	        if(cloneIndex==3)
		 	{
				$("#addMoreClass").hide();
			}
	   
	}
	
	//return false;
	
	//alert($("#suggestion_con"+hdttt).has("table").length? "Yes" : "No");
	
	/* var pageNum = cloneIndex+1;
	$("#suggestion_con"+cloneIndex+" h3").html("Suggestion Page "+pageNum);
	$("#suggestion_con"+cloneIndex+" h3").append("<span style=\"float:right;\" onclick=\"return callRemovePage("+pageNum+");\">x</span>");
	if(cloneIndex >= 1)
	{
		$("#reMoveClass").show();
	} */
	
	/* var $target = $("#suggestion_con"+cloneIndex);
	var i=0;
	$target.find('input').each(function(){
		if(i==0)
		{
			var newID = "sugPageTitle"+pageNum;
		    var newName = "sugPageTitle"+pageNum;
		}
		else
		{
			var newID = "sugPageLink"+pageNum;
		    var newName = "sugPageLink"+pageNum;
		}
		
		$(this).attr('id', newID);
        $(this).attr('name', newName);
		$(this).val("");
		i++;
	});
	$target.find('textarea').each(function(){
		var newID = "sugPageDesc"+pageNum;
		var newName = "sugPageDesc"+pageNum;
		$(this).attr('id', newID);
        $(this).attr('name', newName);
		$(this).val("");
	}); */
	
}

function remove()
{
	var cloneIndex = $(".suggestion_con").length;
	//alert(cloneIndex);
	var pageNum = cloneIndex-1;
	if(cloneIndex==1)
	{
		$("#sugPageTitle1").val("");
		$("#sugPageDesc1").val("");
		$("#sugPageLink1").val(""); 
		$("#reMoveClass").remove();
	}
	else
	{
		$("#suggestion_con"+pageNum).empty();
	    $("#suggestion_con"+pageNum).removeClass("suggestion_con");
	}
	
	if(cloneIndex == 2)
	{
		$("#reMoveClass").hide();
		
		
	}
}


/* var regex = /^(.+?)(\d+)$/i; 
var cloneIndex = $(".suggestion_con").length; */

</script>
<?php include('footer.php');?>
