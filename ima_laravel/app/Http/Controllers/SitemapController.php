<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Post;
use Exception;
use Response;
class SitemapController extends Controller {
	public function index() {
		$view = View::make('sitemap.index');
		ob_clean();
		return Response::make($view, '200')->header('Content-Type', 'text/xml');
	}
}
?>