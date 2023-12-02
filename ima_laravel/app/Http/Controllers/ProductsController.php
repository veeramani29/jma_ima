<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use View;
use App\Model\Postcategory;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Model\User;
use App\Model\Country;
use Session;
class ProductsController extends Controller {
	
	
	public function __construct ()
	{
		View::share ( 'menu_items', $this->populateLeftMenuLinks());
		View::share ( 'search_keywords', $this->searchBoxKeyWords());
	}
	
	public function index() {
		$this->renderResultSet['pageTitle'] = "Welcome to India macro advisors - Products";
		$this->renderResultSet['meta']['description']='You can subscribe as a Free user to access all the economic data. Our premium services includes unlimited access to our interactive chart functions and data analysis tools.';
		$this->renderResultSet['meta']['keywords']='Products, subscription, payment';
		$this->renderResultSet['meta']['shareTitle'] = 'Products|Exclusive data and consise analysis on the Indian Economy';
		$data['renderResultSet']=$this->renderResultSet;
		// get all category items
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
		$user = new User();
		$id =isset($_SESSION['user'])?$_SESSION['user']['id']:0;
		$user_details = $user->getUserDetailsById($id);
        $data['result']['request']['info'] =$user_details;
		
		/* $this->populateLeftMenuLinks();		
		$this->renderView(); */	
        return view('products.index',$data);  		
	}

	public function offerings() {
		
		$user = new User();
		$country = new Country();
		$user_position = $user->getPositionsDatabase();
		$user_industry = $user->getIndustryDatabase();
		$this->renderResultSet['pageTitle']  = "Welcome to India macro advisors - Products";
		$this->renderResultSet['meta']['description']='Take a look at the services offered by us. Interactive IMA Chart tools helps you visualize data and instantly produce presentation materials. Our timely and consise analysis helps you make better descision';
		$this->renderResultSet['meta']['keywords']='Products, subscription, payment';
		$this->renderResultSet['meta']['shareTitle'] = 'What we offer|India Macro Advisors';
		$data['renderResultSet']=$this->renderResultSet;
		$data['result']['user_position'] = $user_position;
		$data['result']['user_industry'] = $user_industry;
		$data['result']['country_list'] = $country->getCountryDatabase();
		
		return view('products.offerings',$data);
		
	}

}


?>