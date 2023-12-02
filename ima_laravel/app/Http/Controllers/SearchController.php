<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use View;
use App\Model\Postcategory;
use App\Model\Post;
use App\Model\Graphvalues;
use App\Model\Media;
use App\Lib\CommonClass;
class SearchController extends Controller {
	public function __construct ()
	{
		View::share ( 'menu_items', $this->populateLeftMenuLinks());
		View::share ( 'search_keywords', $this->searchBoxKeyWords());
	}
	public function index() {
		$this->pageTitle = "Welcome to India macro advisors - Search";
		$this->renderResultSet['meta']['description']='We value your opinion highly. Send us your feedback and suggestions to our data and commentaries.';
		$this->renderResultSet['meta']['keywords']='india macroadvisors, india, IMA';
		$this->renderResultSet['meta']['shareTitle'] = 'Search|India Macro Advisors';
		$data['renderResultSet']=$this->renderResultSet;
		// get all category items
		$postCategory = new postCategory();
		$post = new Post();
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
		$CommonClass = new CommonClass();
		if(count($data['result']['rightside']['notice'])>0) {
			foreach ($data['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
			}
		}
		if(count($data['result']['rightside']['media'])>0) {
			foreach ($data['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
			}
		}
		$myarr = array();
		$series = array();
		$cat = '';
		$var = '';
		$val2 = '';
		$data['result']['search'] = '';
		$data['result']['message'] = '';
/* 		$categor = $post->getIndicatorKeyWords(); 
		foreach($categor as $val){
			$val2 .= $val.',';
			//$val2 .= $val1.',';
			//$cat[] = explode(',',htmlentities($val1));
		}
		$string = str_replace(', ',',',$val2); 
		$string1 = str_replace(',,',',',$string); 
		$string2 = str_replace(' ,',',',$string);
		$fin = explode(',',$string2);
		$unique_array = array_unique($fin);
		$data['result']['category'] = $unique_array; */
		if (@$_POST['searchQuery'] != '')
        {
			$result = $post->getCategoryPostByKeyword($_POST['searchQuery']);
			//print_r($result); 
			$postCatparentUrl ='';
			$newArry = array();
			$i=0;
			$url = '';
			$data['result']['searchKeyword'] = $_POST['searchQuery'];
			if(count($result) > 0) {
			foreach($result as $res){
				if($i==0){
					//echo $i.'<br>';
					if($count = preg_match_all("/{(graph[_a-z]*) ((\d|,|\||-)+)({([a-zA-Z:,\"\'&quot;]*)})*}/", $res->post_cms, $matches))
					{
						$j=0;
						$gid = '';
						//echo '<pre>';print_r($matches);exit;
						foreach($matches[2] as $value) {
							$main = explode('|', $matches[2][$j]);
							$GIDS = explode(',', $main[0]);
							$gid = explode('-',$GIDS[0]);
							$date = explode('|',$main[2]);
							$date1 = explode(',',$date[0]);
							$fromDate = explode('-',$date1[0]);
							//print_r($fromDate); exit;
							$dateMonth = isset($fromDate[1]) ? $fromDate[1] : null;
							$dateYear = isset($fromDate[0]) ? $fromDate[0] : null;
							$fromDate1 = '1-'.$dateMonth.'-'.$dateYear;
							$toDate = explode('-',$date1[1]);
							$toMonth = isset($toDate[1]) ? $toDate[1] : null;
							$toYear = isset($toDate[0]) ? $toDate[0] : null;
							$toDate1 = '1-'.$toMonth.'-'.$toYear; 
							$gtype = '';
							$graphType = explode('graph_',$matches[1][$j]);
							foreach($graphType as $val){
								if($val != 'graph'){
									$gtype = ucfirst($val);
								}
							}
							if(!empty($gid)){
								$y_values = array();
								$graphValues = new Graphvalues();	
								$y_values[] = $graphValues->getGraphAndValuesForThisGid($gid[0]);	
								//echo '<pre>'; print_r($y_values);exit;
								if($j==0){
									
									foreach($y_values as $key => $val5)
									{
										$ysub = '';		
										$k=0;
										$l=0;
										foreach($val5 as $key1){
											if($k == $gid[1]){
												$ysub = $key1['y_sub_value'];
											}
											 if ($ysub == $key1['y_sub_value'])
											{
												//echo 'match'.$gid[0].'<br>';
											  //$newArry[$i][$j] = $gid[0].' - '.$key1['y_value'].' - '.$key1['y_sub_value'];
											  if($l==0){
												  $l++;
												$newArry[$j][$k] = array($gid[0],$k,$key1['title'],$key1['y_sub_value'],$fromDate1,$toDate1);
											  }
											  else{
												$newArry[$j][$k] = array($gid[0],$k,$key1['y_value'].'-'.$res->post_title,$key1['y_sub_value'],$fromDate1,$toDate1);
											  }
											} 
											$k++;	
										}
										
									}
								}
								else{
									foreach($y_values as $key => $val5)
									{
										$k=0;
										$val3='';
										$val4='';
										foreach($val5 as $key1){
											$val3 = trim($_POST['searchQuery']);
											$val4 = trim($key1['y_value']);
											//echo $val4.'<br>';
											//if (strcasecmp($val3,$val4) == 0)
											//{
												//echo 'match'.$gid[0].'<br>';
											  //$newArry[$i][$j] = $gid[0].' - '.$key1['y_value'].' - '.$key1['y_sub_value'];
											  if($k == $gid[1]){
												$newArry[$j][$k] = array($gid[0],$k,$key1['title'],$key1['y_sub_value'],$fromDate1,$toDate1);
											 // }
											  
											} 
											$k++; 
											
										}
									}
								}
							}
							$j++;
						}	
					}
				}	
				//else{
					if($res->post_category_parent_id != 0){
						$postCatparentUrl = $postCategory->getCatUrl($res->post_category_parent_id);
					}
					if($res->post_category_id == 29)
					{
						$url =  url('/').'reports/view/reports/'.$res->post_url;	
						$post_title = $res->post_title.' - Report';
					}
					else {
						$url = url('/').'page/category/economic-indicators/'.$postCatparentUrl.'/'.$res->category_url;
						$post_title = $res->post_title;
					}
				//}
				if($i !=0){
				$series[] = array('title'=>$post_title,'url'=>$url);
				}
				/* echo '<pre>';
				print_r($newArry);
				exit; */
				//echo $url.'<br>';
				foreach($newArry as $key => $val) {
					foreach($val as $k => $v){	
					//print_r($v); exit;
					$series[] = array('title'=>$v[2],'url'=>$url.'?gids='.$v[0].'-'.$v[1].'&graph_index='.$key.'&graph_type=bar&graph_data_from='.$v[4].'&graph_data_to='.$v[5]);
					}
				}
				$newArry = array();
				$i++;
			}
			//exit;
			//echo '<pre>';print_r($newArry); exit;
			$data['result']['search'] = $series;
			}
			else{
				$data['result']['search'] = array();
				$data['result']['message'] = 'No Results found for "'.$_POST['searchQuery'].'"';
			}
			return view('search.search_result',$data);	
		}
		else{
			return redirect('/');
		}
		
	}

}


?>