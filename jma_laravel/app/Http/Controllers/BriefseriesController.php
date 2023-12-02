<?php
namespace App\Http\Controllers;

if (! defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
}
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Briefseries;
use App\Lib\Acl;
use App\Http\Controllers\ErrorController;

class BriefseriesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        View::share('menu_items', $this->populateLeftMenuLinks());
    }

    public function index()
    {
        $this->handleUnpaidUser();
        $this->renderResultSet['pageTitle'] = "Welcome to Japan macro advisors - JMA- Brief series";
        $this->renderResultSet['meta']['description']='Japan macro advisors - JMA- Brief series';
        $this->renderResultSet['meta']['keywords']='japan macroadvisors, japan, brief series';
        $data['renderResultSet']=$this->renderResultSet;
        // get all category items
    
        $acl = new Acl();
        $briefSeriesObj = new Briefseries();
        $briefSeriesPost = $briefSeriesObj->getAllBriefseries();
    
        $data['result']['briefseries'] = $briefSeriesPost;
        $data['result']['isUserLoggedIn'] = $this->isUserLoggedIn();
        $data['result']['isPermitted'] = $acl->isPermitted('content', 'report', 'premiumaccess');
        /*if($this->isUserLoggedIn()==true){
            if($acl->isPermitted('content', 'report', 'premiumaccess')!=true){
                new ErrorController(401);
                
                exit;
            //	exit("Error..! Permission denied.");
            }*/
            
        return view('briefseries.index', $data);
        /*}else{
            return redirect('user/login');
        }*/
    }
}
