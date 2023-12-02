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
use Session;
class HomeController extends Controller
{
  public function __construct ()
  {
    parent::__construct();
    $CloudinaryClass =new CloudinaryClass();
    $CloudinaryClass->CloudinaryApi();
    View::share ( 'menu_items', $this->populateLeftMenuLinks());
  }
  public function index()
  {
    $data=array();
    $this->handleUnpaidUser();
    $this->renderResultSet['meta']['title']="Japan Macro Advisors | Unbiased Opinion on Japan's Economy";
    $this->renderResultSet['pageTitle']="Japan Macro Advisors | Unbiased Opinion on Japan's Economy";
    $this->renderResultSet['meta']['shareTitle']="Unbiased Opinion on Japan's Economy | JMA offers independent analysis and easy access to economic data";
    $this->renderResultSet['meta']['description']="JMA offers concise and insightful macroeconomic analysis on Japan, providing its users with intuitive analytical and reporting tools to help generate informed decisions.";
    $this->renderResultSet['meta']['keywords']='Abenomics, Japan economy, Japan economic analysis, Japan economic indicator, Japan economic policy, Bank of Japan Monetary policy, Japan GDP';
    $data['renderResultSet']=$this->renderResultSet;
    $media = new Media();
    //$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
    #$data['result']['rightside']['media'] = $media->getLatestMedia(4);
    //$data['result']['rightside']['event'] = $media->getLatestEvent(10);

    //print_r($media->getLatestEvent(10));
#echo "<pre>";print_r($data);die;
    $CommonClass = new CommonClass();
    $acl = new Acl();
    //if(count($data['result']['rightside']['notice'])>0) {
/*foreach ($data['result']['rightside']['notice'] as &$rwn) {
$rwn['media_value_text'] = $rwn['media_value_text']; //$CommonClass->editorfix($rwn['media_value_text']);
}*/
//}
//if(count($data['result']['rightside']['media'])>0) {
/*
foreach ($data['result']['rightside']['media'] as &$rwm) {
$rwm['media_value_text'] = $rwm['media_value_text']; // $CommonClass->editorfix($rwm['media_value_text']);
}*/
//}
$post = new Post();
$postCategory = new postCategory();
$data['result']['news'] = $post->getLatestNewsItems(5);

$count = count($data['result']['news']);
for($i=0;$i<$count;$i++)
{
 # $getCategoryDetails = $postCategory->getThisCategoryById($data['result']['news'][$i]['post_category_id']);
 # $isPremium = $getCategoryDetails['premium_category'] == 'Y' ? true : false;
  /* Commented on 201/03/09 if($isPremium == true) {
    if($this->isUserLoggedIn()==true) {
// check permission
      if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
        $link_url =  url('news/view/'.$data['result']['news'][$i]['post_url']);
      } else {
// show upgrade box
        $link_url='javascript:JMA.User.showUpgradeBox("premium","'. url('news/view/'.$data['result']['news'][$i]['post_url']).'")';
      }
    }else{
// Show login window
      $link_url='javascript:JMA.User.showLoginBox("premium","'. url('news/view/'.$data['result']['news'][$i]['post_url']).'")';
    }
  } else {
    $link_url = url('news/view/'.$data['result']['news'][$i]['post_url']);
  }*/

   $link_url = url('page/category/'.$data['result']['news'][$i]['category_path']);
  array_push($data['result']['news'][$i],$link_url);
}
#dd($data['result']['news']);
$homepagegraph = new Home();
$homepage_graph_details = $homepagegraph->getHomepageGraph();
$homepageGraph_title = $homepage_graph_details['title'];
$homepageGraph_description = $homepage_graph_details['description'];
$homepageGraph_publish_date = $homepage_graph_details['published_date'];
$homepageGraph_report_url = $homepage_graph_details['report_link'];
$homepageGraph_code = $homepage_graph_details['graph_code'];	
$homePageGraphContent = "<div class='dv_home_mn_graph_new_ico_txt'><div class='main-title'><h1><span class='dhmg_whamew'>What's New</span>$homepageGraph_title</h1> <div class='mttl-line'></div> </div> <p>$homepageGraph_description <i>($homepageGraph_publish_date)</i></p> </div>
<div style='padding-bottom:15px;font-size:12px;'><a href='".url($homepageGraph_report_url)."'>Click here to view our chart functions.</a></div>";
$homePageGraphContent .= $CommonClass->makeChart($homepageGraph_code,false);
# $cloudinary = new CloudinaryApi();
$data['result']['homepagegraph'] = $homePageGraphContent;
#print_r($data['result']['homepagegraph']);die;
return view('home.index',$data);
}
}