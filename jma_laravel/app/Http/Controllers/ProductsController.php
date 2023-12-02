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
   


        }

	public function index() {
		
		 $this->renderResultSet['pageTitle']= "Welcome to Japan macro advisors - Products";
  		 $this->renderResultSet['meta']['description']="Japan macro advisors - Products and subscriptions";
        $this->renderResultSet['meta']['keywords']='Products, subscription, payment';
        $data['renderResultSet']=$this->renderResultSet;

		// get all category items
		$media = new Media();
		$user = new User();
		$country = new Country();
		$user_position = $user->getPositionsDatabase();
		$user_industry = $user->getIndustryDatabase();
		$data['result']['user_position'] = $user_position;
		$data['result']['user_industry'] = $user_industry;
		$data['result']['country_list'] = $country->getCountryDatabase();
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

		$id =(Session::has('user'))?Session::get('user.id'):0;
		$user_details = $user->getUserDetailsById($id);
	
		$data['result']['request']['info'] =$user_details;
		 return view('products.offerings',$data);	
	}

	public function offerings() {

		$user = new User();
		$country = new Country();
		$user_position = $user->getPositionsDatabase();
		$user_industry = $user->getIndustryDatabase();
		$data['result']['user_position'] = $user_position;
		$data['result']['user_industry'] = $user_industry;
		$data['result']['country_list'] = $country->getCountryDatabase();

		 return view('products.offerings',$data);
		
	}


	public function about_premium_user(){
		$this->handleUnpaidUser();
		 $this->renderResultSet['pageTitle']= "Welcome to Japan macro advisors - Products";
  		 $this->renderResultSet['meta']['description']="Japan macro advisors - Products and subscriptions";
        $this->renderResultSet['meta']['keywords']='Products, subscription, payment';
        $data['renderResultSet']=$this->renderResultSet;
		
		 return view('products.about_premium_user',$data);
		
	}

}


?>