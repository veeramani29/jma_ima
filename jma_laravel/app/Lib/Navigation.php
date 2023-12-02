<?php
namespace App\Lib;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use App\Model\Postcategory;
use App\Model\Post;
use App\Lib\Mobile_Detect;
use Session;
class Navigation  {
	
	



	public function createLeftNavigation($nValues,$cat_url_param='',$pIsPremium = false) {

		//echo "<pre>";print_r($nValues);die;
		$acl = new Acl();
		$Controller = new Controller();
		$out = '';
		if(is_array($nValues)) {
			$category_group = '';
			$cat_group_li = '';
			foreach ($nValues as $cat_id=>$cat_row) {
				if($category_group != $cat_row['details']['category_group'] && $cat_row['details']['category_group'] != ''){
					$first = true;
					$category_group = $cat_row['details']['category_group'];
					switch ($cat_row['details']['category_group']){
						case 'DATA & EVENTS':
							$out.= '<li class="menu_group_title " role="tab" id="headingOne"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#leftmenu_col1" aria-expanded="true" aria-controls="leftmenu_col1" class="lmc_trigger">
											<i class="fa fa-bar-chart"></i>&nbsp;DATA &amp; EVENTS
									</a></li><li id="leftmenu_col1" class="list_colmaigro collapse in" role="tabpanel" aria-labelledby="headingOne">';
						break;
						case 'JMA REPORTS':
							$out.= '<li class="menu_group_title " role="tab" id="headingTwo"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#leftmenu_col2" aria-expanded="true" aria-controls="leftmenu_col2" class="lmc_trigger"><i class="fa fa-files-o"></i>&nbsp;'.$cat_row['details']['category_group'].'</a></li><li id="leftmenu_col2" class="list_colmaigro collapse in" role="tabpanel" aria-labelledby="headingTwo">';							
						break;
						case 'JMA STANDARD':
							$out.= '<li class="menu_group_title " role="tab" id="headingThree"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#leftmenu_col3" aria-expanded="true" aria-controls="leftmenu_col3" class="lmc_trigger"><i class="fa fa-key"></i>&nbsp;'.$cat_row['details']['category_group'].'</a></li><li id="leftmenu_col3" class="list_colmaigro collapse in" role="tabpanel" aria-labelledby="headingThree">';	
						break;
					}	
				}else{
					$cat_group_li = '';
					$first = false;
				}

				$premium_cat_lnk_cls = '';
				if($pIsPremium == false) {
					$isPremium = $cat_row['details']['premium_category'] == 'Y' ? true : false;
				}else{
					$isPremium = $pIsPremium;
				}
				$cat_url = $cat_url_param.$cat_row['details']['category_url']."/";
				if($cat_row['details']['new_icon_display'] == 'Y') {
					$new_icn_cd = '<span class="sublef_menunew">New</span>';
				} else {
					$new_icn_cd = '';
				}
				switch ($cat_row['details']['category_type']) {
					case 'P':

					$link_url = ('page');
					break;
					case 'N':
					$link_url = ('page');
					break;

					case 'M':
					$link_url = ('materials');
					break;
					case 'L':
					$link_url = ($cat_row['details']['category_link']);
					break;
					default:
					$link_url = ('page');
				}
				$classes = "left_cat_$cat_id";
				$ids = "left_cat_$cat_id";
				if($isPremium == true) {
					$premium_uurl = $cat_row['details']['category_type'] =='L' ? $link_url : $link_url."/category/".$cat_url;
					if($Controller->isUserLoggedIn()==true) {
						// check permission
						if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
							$link_url.= $cat_row['details']['category_type'] !='L' ? "/category/".$cat_url : '';
						}else {
							// show upgrade box
							$premium_cat_lnk_cls = 'lnk_inactive';
							$link_url='javascript:JMA.User.showUpgradeBox("premium","'.url($premium_uurl).'")';
							$classes.= ' menu_premium_locked';
						}
					}else{
						// Show login window
						$premium_cat_lnk_cls = 'lnk_inactive';
						$link_url='javascript:JMA.User.showLoginBox("premium","'.url($premium_uurl).'")';
						$classes.= ' menu_premium_locked';
					}
				} else {
					if($cat_row['details']['post_category_name'] == 'JMA Brief Series'){
						$link_url = $cat_row['details']['category_type'] =='L' ? $link_url : $link_url."/category/".$cat_url;
						$link_url=url($link_url);
					}
					else{
						$link_url=url($link_url."/category/".$cat_url);
					}

				}
				if(count($cat_row['subcategories']) == 0) {
					$classes.=" noparent";
				} 
				if($cat_row['details']['post_category_parent_id'] == 0 && $first ==true){
					$classes.= ' menu_cat_group_first_entry';
				}

				if(count($cat_row['subcategories'])>0) {
					$out.="<ul class='list-unstyled'><li class='list-toggle submenu_leftside list-group-item'><a class='content_leftside_parent' data-toggle='collapse'  href='#$ids'>".$new_icn_cd.stripslashes($cat_row['details']['post_category_name'])."<i></i></a>";
					$out.="<ul id='$ids' class='list-group collapse' style='height: 0px;'>".$this->createLeftNavigation($cat_row['subcategories'],$cat_url)."</ul>";
					$out.="</ul>";
				} else {
					$out.="<ul class='list-unstyled'><li class='$classes submenu_leftside list-group-item'><a  href='$link_url' class='$premium_cat_lnk_cls content_leftside_parent'>".$new_icn_cd.stripslashes($cat_row['details']['post_category_name'])."</a></li>";
					$out.="</ul>";			
				}
			}
		} 
		return $out;
	}
	
	public function getCategoryarrayFromUrlArray($urlArray) {
		$cat_array = array();

		if(is_array($urlArray)) {
			$parent_cat_id = 0;
			$postCategory = new postCategory();
			foreach ($urlArray as $rw_url) {
				if($rw_url != '') {
					$category_details = $postCategory->getThisCategoryDetailsByKeyAndParent(md5($rw_url),$parent_cat_id);
					if(is_array($category_details) && isset($category_details['post_category_id'])) {
					$cat_array[$category_details['post_category_id']] = $category_details;
					$parent_cat_id = $category_details['post_category_id'];
				}
				}
			}
			
		}
		return $cat_array;
	}
	
	public function getCategotyArrayParsedIntoPath($cat_array) {
		$response = '';
		if(is_array($cat_array)) {
			foreach ($cat_array as $rw_cat) {
				$response.=$rw_cat['category_url'].'/';
			}
		}
		return $response;
	}
	
	public function isThisCategoryPremium($cat_id){
		$postCategory = new postCategory();
		$cat_details = $postCategory->getThisCategoryById($cat_id);
		if($cat_details['premium_category'] == 'Y') {
			return true;
		}else if($cat_details['post_category_parent_id'] != 0) {
			return $this->isThisCategoryPremium($cat_details['post_category_parent_id']);
		}else {
			return false;
		}
	}

	public function createFolderNav($folders,$controllerName,$actionName) { 
		$result = '';
		if(is_array($folders)) {
			foreach ($folders as $idx=>$folder ) {
				$fid = $folder['folder_id'];
				$fname = $folder['folder_name'];
				if($idx < Session::get('user.user_permissions.mychart.totalFolders')) {
					if($idx ==0){
						$result .= "<li class='folder'><a href='".url('mycharts')."/#{$fid}'><i class='fa fa-folder'></i> <span data-id='{$fid}' data-folderName='{$fname}' contentEditable='false' class='folder-span-name'>{$fname}</span></a></li>";
					}else{
						$result .= "<li class='folder'><a href='".url('mycharts')."/#{$fid}'><i class='fa fa-folder'></i> <span data-id='{$fid}' data-folderName='{$fname}' contentEditable='false' class='folder-span-name'>{$fname}</span></a><span class='del'><i class='fa fa-trash'></i></span></li>";
					}
				}else{
					$result .= "<li class='folder lnk_inactive'><i class='fa fa-folder'></i> <span data-id='{$fid}' data-folderName='{$fname}' contentEditable='false' class='folder-span-name'>{$fname}</span><span class='del'><i class='fa fa-trash'></i></span></li>";
				}
			}
		}

		return $result;
	} 

### Veera Start ##


	public function createResponsiveNavigation($nValues,$cat_url_param='',$pIsPremium = false) {
		$acl = new Acl();
		$Controller = new Controller();
		$out = '';
		if(is_array($nValues)) {
			$category_group = '';
			$cat_group_li = '';
			foreach ($nValues as $cat_id=>$cat_row) {
				if($category_group != $cat_row['details']['category_group'] && $cat_row['details']['category_group'] != ''){
					$first = true;
					$category_group = $cat_row['details']['category_group'];
					switch ($cat_row['details']['category_group']){
						case 'DATA & EVENTS':
						$cat_group_li = '<li><a href="javascript:;" class="mob_maitit"><i class="fa fa-bar-chart"></i>'.$cat_row['details']['category_group'].'</a><ul class="list-unstyled mob_submen open">';
						break;
						case 'JMA REPORTS':
						$cat_group_li = '</ul></li><li><a href="javascript:;" class="mob_maitit"><i class="fa fa-files-o"></i>'.$cat_row['details']['category_group'].'</a><ul class="list-unstyled mob_submen">';
						break;
						case 'JMA STANDARD':
						$cat_group_li = '</ul></li><li><a href="javascript:;" class="mob_maitit"><i class="fa fa-key"></i>'.$cat_row['details']['category_group'].'</a><ul class="list-unstyled mob_submen">';
						break;
					}
					
				}else{
					$cat_group_li = '';
					$first = false;
				}
				
				$premium_cat_lnk_cls = '';
				if($pIsPremium == false) {
					$isPremium = $cat_row['details']['premium_category'] == 'Y' ? true : false;
				}else{
					$isPremium = $pIsPremium;
				}
				$cat_url = $cat_url_param.$cat_row['details']['category_url']."/";
				if($cat_row['details']['new_icon_display'] == 'Y') {
					$new_icn_cd = '<span class="sublef_menunew">New</span>';
				} else {
					$new_icn_cd = '';
				}
				switch ($cat_row['details']['category_type']) {
					case 'P':
					$link_url = ('page');
					break;
					case 'N':
					$link_url = ('page');
					break;
					case 'M':
					$link_url = ('materials');
					break;
					case 'L':
					$link_url = ($cat_row['details']['category_link']);
					break;
					default:
					$link_url = ('page');
				}
				$classes ="";
				if($isPremium == true) {
					$premium_uurl = $cat_row['details']['category_type'] =='L' ? $link_url : $link_url."/category/".$cat_url;
					if($Controller->isUserLoggedIn()==true) {
						// check permission
						if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
							$link_url.= $cat_row['details']['category_type'] !='L' ? "/category/".$cat_url : '';
						}else {
							// show upgrade box
							$premium_cat_lnk_cls = 'lnk_inactive';
							$link_url='javascript:JMA.User.showUpgradeBox("premium","'.url($premium_uurl).'")';
							$classes.= ' menu_premium_locked';
						}
					}else{
						// Show login window
						$premium_cat_lnk_cls = 'lnk_inactive';
						$link_url='javascript:JMA.User.showLoginBox("premium","'.url($premium_uurl).'")';
						$classes.= ' menu_premium_locked';
					}
				} else {
					if($cat_row['details']['post_category_name'] == 'JMA Brief Series'){
						$link_url = $cat_row['details']['category_type'] =='L' ? $link_url : $link_url."/category/".$cat_url;
						$link_url=url($link_url);
					}
					else{
						$link_url=url($link_url."/category/".$cat_url);
					}
				}
				if(count($cat_row['subcategories']) == 0) {
					$classes.=" noparent";
				} 
				if($cat_row['details']['post_category_parent_id'] == 0 && $first ==true){
					$classes.= ' menu_cat_group_first_entry';
				}
				if(count($cat_row['subcategories'])>0) {
					$out.=$cat_group_li."<li class='$classes dropdown'><a href='javascript:;' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>".stripslashes($cat_row['details']['post_category_name'])."<span class='caret'></span></a>";
					$out.="<ul class='menu sub dropdown-menu' >".$this->createResponsiveNavigation($cat_row['subcategories'],$cat_url)."</ul>";

				} else {
					$out.=$cat_group_li."<li class='$classes dropdown'><a class='content_leftside_parent $premium_cat_lnk_cls' href='$link_url' >".$new_icn_cd.stripslashes($cat_row['details']['post_category_name'])."</a></li>";
				}
			}
		} 
		return $out;
	}
	public function add_more_series($nValues,$cat_url_param='',$pIsPremium = false) {
		$acl = new Acl();
		$Controller = new Controller();
		$out = '';

		if(is_array($nValues)) {
			$category_group = '';
			$cat_group_li = '';
			foreach ($nValues as $cat_id=>$cat_row) {

				if(!in_array($cat_row['details']['post_category_id'], array(13,14,8,10,171))){
				$premium_cat_lnk_cls = '';
				$new_icn_cd = '';
				$link_url='javascript:;';$onClick='';
				if(isset($cat_row['details']['premium_category']) && $cat_row['details']['premium_category']=='Y'){
						$isPremium = true;
				}else{
						$isPremium = false;
				}
				$cat_url = $cat_url_param.$cat_row['details']['category_url']."/";
				if($isPremium == true) {
					$link_url = ('page');
					$premium_uurl = $cat_row['details']['category_type'] =='L' ? $link_url : $link_url."/category/".$cat_url;
					if($Controller->isUserLoggedIn()==true) {
						if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
							$link_url='javascript:;';
						}else {
							$premium_cat_lnk_cls = 'lnk_inactive';
							$link_url='javascript:JMA.User.showUpgradeBox("premium","'.url($premium_uurl).'")';
						}
					}else{
						$premium_cat_lnk_cls = 'lnk_inactive';
						$link_url='javascript:JMA.User.showLoginBox("premium","'.url($premium_uurl).'")';
						
					}
				}

				
				$ids = "{{chart_details.chartIndex}}_right_cat_$cat_id";
				$dropdown="";
				$detect = new Mobile_Detect();
				if($detect->isMobile() || $detect->isTablet()){
					if(count($cat_row['subcategories']) == 0) {
						$post = new Post();
						$posts_graph = $post->get_Graphdetails_BasedOnPage_CategoryId($cat_id);
						if(!empty($posts_graph)){
							$dropdown.="<ul class='dl-submenu'>";
							foreach($posts_graph as $posts_graph_det){
								if($link_url=='javascript:;'){
									$onClick="onClick='JMA.JMAChart.addThisGraphCode({{chartIndex}},this)'";
								}
								$dropdown.="<li><a id='{{chartIndex}}_".rand()."' class='$premium_cat_lnk_cls select_series_addmore-select_{{chartIndex}}' ".$onClick." value='".$posts_graph_det['gid']."' href='$link_url' data-toggle='tooltip' data-placement='top' title='".stripslashes($posts_graph_det['title'])."'>".$posts_graph_det['title']."</a></li>";
							}
							$dropdown.="</ul>";
						}
					}
					if(count($cat_row['subcategories'])>0) {
							$out.="<li><a class='$premium_cat_lnk_cls dropdown-toggle btn-admor' data-toggle='dropdown' data-placement='top' title='".stripslashes($cat_row['details']['post_category_name'])."'>".$new_icn_cd.stripslashes($cat_row['details']['post_category_name'])."<i></i></a>";
						    $out.="<ul id='$ids' class='dl-submenu'>".$this->add_more_series($cat_row['subcategories'],$cat_url)."</ul>";
						    $out.="</li>";
					} else {
						$out.="<li><a data-placement='top' data-toggle='dropdown' class='$premium_cat_lnk_cls dropdown-toggle btn-admor' title='".stripslashes($cat_row['details']['post_category_name'])."'>".$new_icn_cd.stripslashes($cat_row['details']['post_category_name'])."</a>".$dropdown;
						$out.="</li>";
					}
				} else {
					if(count($cat_row['subcategories']) == 0) {
						$post = new Post();
						$posts_graph = $post->get_Graphdetails_BasedOnPage_CategoryId($cat_id);
						if(!empty($posts_graph)){
							$dropdown.="<ul class='dropdown-menu'>";
							foreach($posts_graph as $posts_graph_det){
								if($link_url=='javascript:;'){
									$onClick="onClick='JMA.JMAChart.addThisGraphCode({{chartIndex}},this)'";
								}
								$dropdown.="<li><a id='{{chartIndex}}_".rand()."' class='$premium_cat_lnk_cls select_series_addmore-select_{{chartIndex}}' ".$onClick." value='".$posts_graph_det['gid']."' href='$link_url' data-toggle='tooltip' data-placement='top' title='".stripslashes($posts_graph_det['title'])."'>".$posts_graph_det['title']."</a></li>";
							}
							$dropdown.="</ul>";
						}
					}
					if(count($cat_row['subcategories'])>0) {
							$out.="<li class='dropdown-submenu submenu_addmore'><a class='$premium_cat_lnk_cls dropdown-toggle btn-admor' data-toggle='dropdown' data-toggle='tooltip' data-placement='top' title='".stripslashes($cat_row['details']['post_category_name'])."'>".$new_icn_cd.stripslashes($cat_row['details']['post_category_name'])."<i></i></a>";
						    $out.="<ul id='$ids' class='dropdown-menu'>".$this->add_more_series($cat_row['subcategories'],$cat_url)."</ul>";
						    $out.="</li>";
					} else {
						$out.="<li class='dropdown-submenu submenu_addmore'><a data-toggle='tooltip' data-placement='top' data-toggle='dropdown' class='$premium_cat_lnk_cls dropdown-toggle btn-admor' title='".stripslashes($cat_row['details']['post_category_name'])."'>".$new_icn_cd.stripslashes($cat_row['details']['post_category_name'])."</a>".$dropdown;
						$out.="</li>";
					}
				}
			}
		}
		}
		return $out;
	}
}
?>