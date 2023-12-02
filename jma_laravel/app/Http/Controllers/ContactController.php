<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use View;
use App\Model\Postcategory;
use App\Model\Media;
use App\Lib\CommonClass;
class ContactController extends Controller {

	 public function __construct ()
        {

        		 parent::__construct();
            View::share ( 'menu_items', $this->populateLeftMenuLinks());
   


        }
	
	public function index() {

		$this->renderResultSet['pageTitle']= "Welcome to Japan macro advisors - Contact us";
  
        $this->renderResultSet['meta']['description']="Japan macro advisors - Contact us";
        $this->renderResultSet['meta']['keywords']='Japan macroadvisors, japan, contact jma';
        $data['renderResultSet']=$this->renderResultSet;

		
		// get all category items
		$postCategory = new postCategory();
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
		 return view('contact.index',$data);	
	}

}


?>