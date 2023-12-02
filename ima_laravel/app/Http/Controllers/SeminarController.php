<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Config;
use App\Lib\CommonClass;
use App\Lib\Acl;
use App\Lib\Navigation;
use Exception;
use Response;
use Session;
class SeminarController extends Controller {
	public function __construct()
	{
		View::share ( 'menu_items', $this->populateLeftMenuLinks());
	}
	
	public function index() {
		$renderResultSet['pageTitle'] = "Welcome to India macro advisors - Seminar";
		$renderResultSet['meta']['description']='India macro advisors - Seminar';
		$renderResultSet['meta']['keywords']='India macroadvisors, India, Seminar';
		$data['renderResultSet'] = $renderResultSet;
		return view('seminar.index', $data);		
	}

}


?>