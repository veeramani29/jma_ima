<?php
include('controlPanel.php');
$out = array('status'=>404,'message'=>'no page found','result'=>'');
switch ($_GET['req_action']) {
	
	case 'getSubCategories':
		$cat_id = $_POST['cat_id'];
		//$cat_id = 2;
		$subCategories = $catObj->getSubChildCategory($cat_id);
		// echo '<pre>';
		// print_r($subCategories); exit;
		 $result_arr = array();
		 if(count($subCategories)>0) {
		 	foreach ($subCategories as $rw) {
		 		$result_arr[] = array('post_category_id'=>$rw['post_category_id'], 
		 							  'post_category_name'=>$rw['post_category_name'],
		 							   'post_category_parent_id'=>$rw['post_category_parent_id']);
		 		
		 	}
		 	$out['status']=1;
		 	$out['message'] = 'success';
		 	$out['result'] = $result_arr;
		 } else {
		 	$out['status']=400;
		 	$out['message'] = 'No further sub-categories found';
		 }
		 
		break;
	case 'getAllPostForThisCategory':
	 	$out['status']=1;
	 	$out['message'] = 'success';
		$cat_id = $_POST['cat_id'];
		$posts = $postObj->getAllPostTitlesForThisCategory($cat_id);
		if(count($posts)>0){
			$out_res = '<select name="select_selectpost" id="select_selectpost" class="styledselect_form_1" onchange="JmaAdmin.switchSeoPageContentMethod()"><option value="0">Select Post</option>';
			foreach ($posts as $postDetailsRow){
				$out_res.='<option value="'.$postDetailsRow['post_id'].'">'.(string)stripslashes($postDetailsRow['post_title']).'</option>';
			}
		}else{
			$out_res = '<span style="color:#ff0000">No Posts found for selected category.</span>';
		}
		$out['result'] = $out_res;
		break;		
	default:
		$out['status'] = 500;
		$out['message'] = 'Server Error';	
}
header('Content-Type: application/json');
echo json_encode($out);
?>