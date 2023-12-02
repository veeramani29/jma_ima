<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

class MainatenaceController extends Controller {
	

	

	public function index() {
		
			 return view('errors.under_maintenance');	
		
	}

}


?>