<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Post;
use Exception;
use Response;
class RssController extends Controller {


	
	public function index() {
		$post = new Post();
		$newsContent = $post->getLatestNewsRssItems();
		$data['result']['news'] = $newsContent;
		$view = View::make('rss.index', $data);
		ob_clean();
return Response::make($view, '200')->header('Content-Type', 'text/xml');
		}
}
?>