<?php
namespace resources\crons;
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'Crons.php';
use \App\Model\Post;
use \App\Model\Postcategory;
use \App\Libraries\mailer\PHPMailer;
class unsetNewPostIcon extends Crons {
	 public function getAllNewCategorysss()
    {
        $post = new Post();
        $postCategory = new Postcategory();
        $result = array();
        $arSubcategories = array();

        #STR_TO_DATE(`post_released`,'%M %d, %Y'),post_datetime
        $rs =Post::select('post_id', 'post_category_id', 'post_datetime')->where('post_publish_status', 'Y')->whereraw("datediff(NOW(), STR_TO_DATE(`post_released`,'%M %d, %Y')) < 7")->get();



        $get_Count =count($rs);


        if ($get_Count>0) {
            $get_Arr = json_decode(json_encode($rs), true);
            foreach ($get_Arr as $get_Arrs) {
                $result[] = $get_Arrs;
            }

            $rs =Postcategory::where('new_icon_display', 'Y')->update(array('new_icon_display'=>'N'));


            $item = array();


            foreach ($result as $item) {
                $rs =Postcategory::where('post_category_id', $item['post_category_id'])->update(array('new_icon_display'=>'Y'));


                $rs1 = Postcategory::select('post_category_parent_id')->where('post_category_id', $item['post_category_id'])->get();


                $get_Arr = json_decode(json_encode($rs1), true);
                do {
                    $rs =Postcategory::where('post_category_id', $get_Arr[0]['post_category_parent_id'])->update(array('new_icon_display'=>'Y'));


                    $rs11 = Postcategory::select('post_category_parent_id')->where('post_category_id', $get_Arr[0]['post_category_parent_id'])->get();


                    $get_Arr = json_decode(json_encode($rs11), true);
                } while ($get_Arr[0]['post_category_parent_id'] != 0);
            }
        }else{
        	  $rs =Postcategory::where('new_icon_display', 'Y')->update(array('new_icon_display'=>'N'));
        }
    }
	public function Run() {
		try {
			$out= "***************** Unset new post icon - START"."<br><br>";
			$postCategory = new Postcategory();
			$post = new Post();
			$categories = $postCategory->getAllCategoriesWithNewIcon();
			$categories_with_posts = array();
			if(count($categories)>0) {
				foreach($categories as $category) {
				$posts = $post->getAllPublishedPostsForThisCategoryIdAndAreOutdated($category['post_category_id']);
					if($category['post_category_parent_id'] == 0) {	
						$categories_with_posts[$category['post_category_id']]['category'] = $category;
						$categories_with_posts[$category['post_category_id']]['posts'] = $posts;
						$categories_with_posts[$category['post_category_id']]['subcategories'] = array();
					}else {
						$categories_with_posts[$category['post_category_parent_id']]['subcategories'][$category['post_category_id']]['category'] = $category;
						$categories_with_posts[$category['post_category_parent_id']]['subcategories'][$category['post_category_id']]['posts'] = $posts;
					}
				}
				foreach ($categories_with_posts as $catg_id => $categories_with_post) {
					if(empty($categories_with_post['posts']) && empty($categories_with_post['subcategories'])){
						// Unset category status of $catg_id
						$postCategory->updateNewIcon($catg_id, 'N');
						$out.= "***>> Unset new icon for category : <strong>".$categories_with_post['category']['post_category_name']."</strong><br><br>";
					}
					elseif(empty($categories_with_post['posts']) && !empty($categories_with_post['subcategories'])){
						foreach($categories_with_post['subcategories'] as $subCat_id => $subCategory) {
							if(!empty($subCategory['posts'])) {
								// Unset category status of $subCat_id
								$postCategory->updateNewIcon($subCat_id, 'N');
								$out.= "***>> Unset new icon for Sub - category : <strong>".$subCategory['category']['post_category_name']."</strong><br><br>";
							}
							else{
								$postCategory->setPostcategoryParent($subCat_id, 'Y');
							}
						}
					}					
				}
			//	print_r($categories_with_posts); exit;
			} else {
				$out.= "***>> No categories with new icon found"."<br><br>";
			}
		} catch (Exception $ex) {
			$out.= "***>> Exception >> ".$ex->getMessage()." ( Err.No. :".$ex->getCode()." )"."<br><br>";
		}
		$out.= "***************** Unset new post icon - END"."<br><br>";
		$mail = new PHPMailer();
		$mail->IsSMTP();
		//$mail->IsMail();
		$mail->IsHTML(true);  
		$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
		$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AddReplyTo('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
		$mail->WordWrap = 50;
		$mail->Subject = 'Unset new icon on post and category - Cron status';
        $mail->Body = $out;
		$mail->AddAddress('dev@japanmacroadvisors.com','JMA DevTeam');
		#$mail->AddAddress('anushree.upadhyay@japanmacroadvisors.com','Anushree Upadhyay');
		#$mail->AddAddress('priyanka.dhar@japanmacroadvisors.com','Priyanka Dhar');
		$mail->Send();
		$mail->clearAddresses();
	    $mail->clearAttachments();
	}
	
}

$obj = new unsetNewPostIcon();
$obj->Run();
$obj->getAllNewCategorysss();