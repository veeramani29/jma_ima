<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Post;
use Exception;
use Response;
class SitemapnewsController extends Controller {
	public function index() {
		$post = new Post();
		$newsContent = $post->getLatestTwoDaysNewsItems(5);
		$data['result']['news'] = $newsContent;
		$view = View::make('sitemapnews.index', $data);
		ob_clean();
		return Response::make($view, '200')->header('Content-Type', 'text/xml');
	}
}
?>


