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
class CareersController extends AlaneeController {
	public function __construct ()
	{
		View::share ( 'menu_items', $this->populateLeftMenuLinks());
	}
	public function index() {
		$this->error(404);
		/*
		$this->pageTitle = "Careers";
		$this->renderResultSet['meta']['description']='India macro advisors - Careers';
		$this->renderResultSet['meta']['keywords']='India macro advisors, india, careers';
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