#!/usr/bin/php -q
<?php
//ini_set('display_errors',1); 
// error_reporting(E_ALL);
require 'cron_class.php';
class unsetNewPostIcon extends Cron {
	public $classes = array('alanee_classes/mailer/class.phpmailer.php');
	public function Run() {
		try {
			$out= "***************** Unset new post icon - START"."<br><br>";
			$postCategory = new postCategory();
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
					if(count($categories_with_post['posts']) == 0 && count($categories_with_post['subcategories']) == 0 ) {
						// Unset category status of $catg_id
						$postCategory->updateNewIcon($catg_id, 'N');
						$out.= "***>> Unset new icon for category : <strong>".$categories_with_post['category']['post_category_name']."</strong><br><br>";
					} else if(count($categories_with_post['posts']) == 0 && count($categories_with_post['subcategories']) > 0 ) {
						foreach($categories_with_post['subcategories'] as $subCat_id => $subCategory) {
							if(count($subCategory['posts']) == 0) {
								// Unset category status of $subCat_id
								$postCategory->updateNewIcon($subCat_id, 'N');
								$out.= "***>> Unset new icon for Sub - category : <strong>".$subCategory['category']['post_category_name']."</strong><br><br>";
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
		$mail->IsHTML(true);  
		$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
		$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AddReplyTo('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
		$mail->WordWrap = 50;
		$mail->Subject = 'Unset new icon on post and category - Cron status';
        $mail->Body = $out;
		$mail->AddAddress('dev@japanmacroadvisors.com','JMA DevTeam');
		$mail->AddAddress('anushree.upadhyay@japanmacroadvisors.com','Anushree Upadhyay');
		$mail->AddAddress('priyanka.dhar@japanmacroadvisors.com','Priyanka Dhar');
		$mail->Send();
		$mail->clearAddresses();
	    $mail->clearAttachments();
	}
	
}

$obj = new unsetNewPostIcon();
$obj->Run();