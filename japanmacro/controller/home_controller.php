<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class HomeController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php','alanee_classes/cloudinary/cloudinary_class.php');
	public function index() {
		$this->handleUnpaidUser();
		$this->pageTitle = "JAPAN MACRO ADVISORS , Unbiased opinion on Japan's Economy";
		$this->renderResultSet['meta']['shareTitle']="Unbiased Opinion on Japan's Economy | JMA offers independent analysis and easy access to economic data";
		$this->renderResultSet['meta']['description']="JMA offers concise and insightful macroeconomic analysis on Japan, providing its users with intuitive analytical and reporting tools to help generate informed decisions.";
		$this->renderResultSet['meta']['keywords']='Abenomics, Japan economy, Japan economic analysis, Japan economic indicator, Japan economic policy, Bank of Japan Monetary policy, Japan GDP';
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			/*foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $rwn['media_value_text']; //$AlaneeCommon->editorfix($rwn['media_value_text']);
			}*/
		}
		if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			/*
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $rwm['media_value_text']; // $AlaneeCommon->editorfix($rwm['media_value_text']);
			}*/
		}
		$this->populateLeftMenuLinks();
		$acl = new Acl();
		$post = new Post();
		$postCategory = new postCategory();
		$this->renderResultSet['result']['news'] = $post->getLatestNewsItems(5);
		$count = count($this->renderResultSet['result']['news']);
		for($i=0;$i<$count;$i++)
		{
			$getCategoryDetails = $postCategory->getThisCategoryById($this->renderResultSet['result']['news'][$i]['post_category_id']);
			$isPremium = $getCategoryDetails['premium_category'] == 'Y' ? true : false;
			if($isPremium == true) {
					if($this->isUserLoggedIn()==true) {
						// check permission
						if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
							$link_url = $this->url(array('controller'=>'news','action'=>'view','params'=>$this->renderResultSet['result']['news'][$i]['post_url']));
						} else {
							// show upgrade box
							$link_url='javascript:JMA.User.showUpgradeBox("premium","'.$this->url(array('controller'=>'news','action'=>'view','params'=>$this->renderResultSet['result']['news'][$i]['post_url'])).'")';
						}
					}else{
						// Show login window
						$link_url='javascript:JMA.User.showLoginBox("premium","'.$this->url(array('controller'=>'news','action'=>'view','params'=>$this->renderResultSet['result']['news'][$i]['post_url'])).'")';
					}
				} else {
					$link_url = $this->url(array('controller'=>'news','action'=>'view','params'=>$this->renderResultSet['result']['news'][$i]['post_url']));
				}
				array_push($this->renderResultSet['result']['news'][$i],$link_url);
		}	
		//print_r($this->renderResultSet['result']['news'][0]);
		//exit();
		$homepagegraph = new Homepagegraph();
		$homepage_graph_details = $homepagegraph->getHomepageGraph();
		$homepageGraph_title = $homepage_graph_details['title'];
		$homepageGraph_description = $homepage_graph_details['description'];
		$homepageGraph_publish_date = $homepage_graph_details['published_date'];
		$homepageGraph_report_url = $homepage_graph_details['report_link'];
		$homepageGraph_code = $homepage_graph_details['graph_code'];
		$homePageGraphContent = "<div class='dv_home_mn_graph_new_ico_txt'><div class='main-title'><h1><span class='dhmg_whamew'>What's New</span>$homepageGraph_title</h1> <div class='mttl-line'></div> </div> <p>$homepageGraph_description <i>($homepageGraph_publish_date)</i></p> </div>
		<div style='padding-bottom:15px;font-size:12px;'><a href='".$this->url($homepageGraph_report_url)."'>Click here for the full version of comments and chart functions.</a></div>";
		$homePageGraphContent .= $AlaneeCommon->makeChart($homepageGraph_code,false);
		$cloudinary = new CloudinaryApi();
		$this->renderResultSet['result']['homepagegraph'] = $homePageGraphContent;
		$this->renderView();
	}
	
	public function admin_index() {
		$this->renderView();
	}
	
}

?>