<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class NewsController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	public function index() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Welcome to Japan macro advisors - News";
		// get all category items
		$this->populateLeftMenuLinks();
		//	$this->renderView();
	}
	
	public function admin_index() {
		$this->renderView();
	}
	
	public function view($params) {

		$this->handleUnpaidUser();
		$this->populateLeftMenuLinks();
		$posturl = $params[0];
		if($posturl == 'female-new-grads-more-in-demand-than-male' || $posturl == 'correction--female-new-grads-more-in-demand-than-male') {
			$post_key = 'e64405841fc5df4e0bcf7cec1a5d9e42';
		}else{
			$post_key = md5($posturl);
		}
		$postCategory = new postCategory();
		$navigation = new Navigation();
		$post = new Post();

		  $post_cat_id = $post->getThisPostCategoryIdByKey($post_key);

		$category_array = $postCategory->getAllParentCategoriesByCategoryId($post_cat_id);	
		 $category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
		 $post_full_url = $category_path.$posturl;
		 if($category_path!=null){
			$this->redirect('reports/view/'.$post_full_url);
		 }else{
		 $this->error(404);
		 	
		 }


		 
		/*	$post = new Post();
		$AlaneeCommon = new Alaneecommon();
		$newsContent = $post->getThisPostItemByKey($post_key);
		if(count($newsContent)>0) {
			$newsContent[0]['post_cms']	= $AlaneeCommon->makeChart($AlaneeCommon->cleanMyCkEditor($newsContent[0]['post_cms']));
		}
		$this->renderResultSet['result']['news'] = $newsContent;
		$this->pageTitle = $newsContent[0]['post_meta_title'];
		$this->renderResultSet['meta']['shareTitle'] = $newsContent[0]['post_share_title'];
		$this->renderResultSet['meta']['shareImage']=$newsContent[0]['post_image'];
		$this->renderResultSet['meta']['description']=$newsContent[0]['post_meta_description'];
		$this->renderResultSet['meta']['keywords']=$newsContent[0]['post_meta_keywords'];
		$this->renderView();
		*/
	}
	
	public function category($params) {

		$this->handleUnpaidUser();
		$categoryurl_main = isset($params[0]) ? $params[0] : null;
		$categoryurl_sub = isset($params[1]) ? $params[1] : null;

	}
	
	public function quarterlygraph() {
		$this->renderResultSet['result']['chart'] = $AlaneeCommon->makeChart("{graph_narrow 150-18,150-15|150|2008-4,2013-12}");
		$this->renderResultSet['result']['title'] = "Quarterly Data";
		$this->render('sample_graph');
	}
	
	public function anualgraph() {
		$this->renderResultSet['result']['chart'] = $AlaneeCommon->makeChart("{graph_narrow 150-18,150-15|150|2008-4,2013-12}");
		$this->renderResultSet['result']['title'] = "Anual Data";
		$this->render('sample_graph');
	}	
	
}

?>