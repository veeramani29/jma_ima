<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use View;
use App\Model\Media;
use App\Lib\CommonClass;

class ErrorController extends Controller{
	
	public function __construct($error_code){
		 parent::__construct();
  View::share ( 'menu_items', $this->populateLeftMenuLinks());

		switch ($error_code){
			case 404 :

				$this->error_404();
				break;
				case 401 :
					$this->error_401();
					break;				
			default:
				$this->error_404();
				break;
		}
		
	}


	public function error_404(){

		//http_response_code(404);
		//header('X-PHP-Response-Code: 404', true, 404);
		
		
		  $data['pageTitle']= "404 - Sorry..! page not found";
         $data['meta']['description']="";
        $data['meta']['keywords']='';
        $data['renderResultSet']=$data;
		// get all category items
	
		$media = new Media();


		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $AlaneeCommon = new CommonClass();
        if(count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
            }
        }
        if(count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
            }
        }

      

         $view = View::make('errors.error_404', $data);
        
		echo $contents = $view->render();
     
	}
	
	public function error_401(){
		//http_response_code(404);
		//header('X-PHP-Response-Code: 401', true, 401);
	
		  $data['pageTitle']= "401 - Access denied!";
         $data['meta']['description']="";
        $data['meta']['keywords']='';
        $data['renderResultSet']=$data;
		// get all category items
	
		$media = new Media();


		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $AlaneeCommon = new CommonClass();
        if(count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
            }
        }
        if(count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
            }
        }
         $view = View::make('errors.error_401', $data);
		echo $contents = $view->render();
		
		
	
	}
	
	
}

?>
