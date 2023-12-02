<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Post;
use Exception;
use App\Http\Controllers\ErrorController;
class CareersController extends Controller {
	public function __construct ()
        {

        		 parent::__construct();
            View::share ( 'menu_items', $this->populateLeftMenuLinks());
   


        }
	public function index() {
		new ErrorController(404);
		/*
		$this->pageTitle = "Careers";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Careers';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan, careers';
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
			}
		}
		if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
			}
		}
		$this->populateLeftMenuLinks();
		$this->renderView();		
		*/
	}

}


?>