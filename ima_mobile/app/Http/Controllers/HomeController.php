<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Postcategory;
use App\Model\Post;
use App\Model\Media;
use App\Model\Home;
use App\Lib\CommonClass;
use App\Lib\Acl;
use App\Lib\CloudinaryClass;
use Config;
use Cookie;
class HomeController extends Controller
{
	
	
	public function __construct ()
	{
		//dd(Config::all());
		//Config::set('social.facebook.url', 'meh');
		 parent::__construct();
		/* $CloudinaryClass =new CloudinaryClass();
		$CloudinaryClass->CloudinaryApi(); */

		View::share ( 'menu_items', $this->populateLeftMenuLinks()); 
	}
	
	public function index() {
		$data=array();
		$this->handleUnpaidUser();
		$this->pageTitle = "Unbiased Opinion on Indian Economy | IMA offers independent analysis and easy access to economic data";
		$this->renderResultSet['meta']['shareTitle']="Unbiased Opinion on Indian Economy | IMA offers independent analysis and easy access to economic data";
		$this->renderResultSet['meta']['description']="India Macro Advisors offers an independent and unbiased economic analysis on the indian economy. Through our forecast, regularly updated economic commentaries, over 2000 downloadable economic data and free use of interactive charts, we aim to contribute to an open and evidence-based debate on Indian economic future.";
		$this->renderResultSet['meta']['keywords']='India economic data,Current data of Indian economy, India macroeconomic indicators 2017,latest data on Indian economy,India economic indicator statistics';
		
		$data['renderResultSet']=$this->renderResultSet;
		
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
		$CommonClass = new CommonClass();
	//	if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			/*foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $rwn['media_value_text']; //$AlaneeCommon->editorfix($rwn['media_value_text']);
			}*/
	//	}
	//	if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			/*
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $rwm['media_value_text']; // $AlaneeCommon->editorfix($rwm['media_value_text']);
			}*/
	//	}
		$this->populateLeftMenuLinks();
		$post = new Post();
		$data['result']['news'] = $post->getLatestNewsItems(5);
		foreach ($data['result']['news'] as $key => $part) {
			$sort[$key] = strtotime($part['post_released']);
		}
		array_multisort($sort, SORT_DESC, $data['result']['news']);
	//	echo '<pre>';
	//	print_r($this->renderResultSet['result']['news']);
	//	exit;
		$homepagegraph = new Home();
		$homepage_graph_details = $homepagegraph->getHomepageGraph();
		$homepageGraph_title = $homepage_graph_details['title'];
		$homepageGraph_description = $homepage_graph_details['description'];
		$homepageGraph_publish_date = $homepage_graph_details['published_date'];
		$today =  date('y-m-d');
		$today =  strtotime($today);
		$resn_date1 =  strtotime($homepageGraph_publish_date);
		$resn_date =  strtotime("+10 day",$resn_date1);
		$homepageGraph_report_url = $homepage_graph_details['report_link'];
		$homepageGraph_code = $homepage_graph_details['graph_code'];
		$homePageGraphContent = "<div class='dv_home_mn_graph_new_ico_txt'><div class='main-title'><h1>";
		if($today < $resn_date){
			$homePageGraphContent.="<span class='dhmg_whamew'>What's New</span>";
		}
		$homePageGraphContent.="$homepageGraph_title</h1><div class='mttl-line'></div> </div> <p>$homepageGraph_description <i>($homepageGraph_publish_date)</i></p> </div>
		<div style='padding-bottom:15px;font-size:12px;'><a href='".url($homepageGraph_report_url)."'>Click here for the full version of comments and chart functions.</a></div>";
		$homePageGraphContent .= $CommonClass->makeChart($homepageGraph_code,false);
		$data['result']['homepagegraph'] = $homePageGraphContent;
		//$this->renderView();
		
		//dd($data); exit;
	
		return view('home.index',$data);
	}
	
	/* public function admin_index() {
		$this->renderView();
	} */
	
}

?>