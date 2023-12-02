<?php
namespace App\Http\Controllers;

if (! defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
}
use App\Http\Controllers\Controller;
use View;
use App\Model\Postcategory;
use App\Model\Media;
use App\Lib\CommonClass;

class AboutusController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        View::share('menu_items', $this->populateLeftMenuLinks());
    }

    public function index()
    {
        $this->handleUnpaidUser();

        $this->renderResultSet['pageTitle']= "Welcome to Japan macro advisors - About us";
  
        $this->renderResultSet['meta']['description']="Japan macro advisors - About us";
        $this->renderResultSet['meta']['keywords']='Abenomics, Japan economy, Japan economic analysis, Japan economic indicator, Japan economic policy, Bank of Japan Monetary policy, Japan GDP,japan macroadvisors, japan';
        $data['renderResultSet']=$this->renderResultSet;

        // get all category items
      #  $postCategory = new postCategory();
       # $media = new Media();
    /*    $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(4);
        $data['result']['rightside']['event'] = $media->getLatestEvent(10);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }*/
        
        return view('aboutus.index', $data);
    }
    
    public function privacypolicy()
    {
        $this->handleUnpaidUser();

        $this->renderResultSet['pageTitle']= "Privacy policy";
        $this->renderResultSet['meta']['description']="Japan macro advisors - Privacy policy";
        $this->renderResultSet['meta']['keywords']='Japan macroadvisors, japan';
        $data['renderResultSet']=$this->renderResultSet;

    
        // get all category items
       # $postCategory = new postCategory();
      /*  $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(4);
        $data['result']['rightside']['event'] = $media->getLatestEvent(10);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }*/
        
        return view('aboutus.privacypolicy', $data);
    }
    
    public function termsofuse()
    {
        $this->handleUnpaidUser();

        $this->renderResultSet['pageTitle']= "Terms of Use";
        $this->renderResultSet['meta']['description']="Japan macro advisors - Terms of Use";
        $this->renderResultSet['meta']['keywords']='Japan macroadvisors, japan';

        $data['renderResultSet']=$this->renderResultSet;
        
        // get all category items
        #$postCategory = new postCategory();
       /* $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(4);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }*/

        return view('aboutus.termsofuse', $data);
    }


    

    public function commercial_policy()
    {
        $this->handleUnpaidUser();

        $this->renderResultSet['pageTitle']= "Commercial policy";
        $this->renderResultSet['meta']['description']="Japan macro advisors - Commercial policy";
        $this->renderResultSet['meta']['keywords']='Japan macroadvisors, japan';

        $data['renderResultSet']=$this->renderResultSet;
        // get all category items
      /*  $postCategory = new postCategory();
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(4);
        $data['result']['rightside']['event'] = $media->getLatestEvent(10);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }*/
        
        return view('aboutus.commercial_policy', $data);
    }
    public function search()
    {
        $this->handleUnpaidUser();

        $this->renderResultSet['pageTitle']= "Search Result";
        $this->renderResultSet['meta']['description']="Japan macro advisors - Search Result";
        $this->renderResultSet['meta']['keywords']='Japan macroadvisors, japan';

        $data['renderResultSet']=$this->renderResultSet;
        // get all category items
       /* $postCategory = new postCategory();
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(4);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }*/
        
        return view('aboutus.search', $data);
    }
    public function map_chart()
    {
        $this->handleUnpaidUser();

        $this->renderResultSet['pageTitle']= "Commercial policy";
        $this->renderResultSet['meta']['description']="Japan macro advisors - Commercial policy";
        $this->renderResultSet['meta']['keywords']='Japan macroadvisors, japan';

        $data['renderResultSet']=$this->renderResultSet;
        // get all category items
       /* $postCategory = new postCategory();
        $media = new Media();
        $data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
        $data['result']['rightside']['media'] = $media->getLatestMedia(5);
        $data['result']['rightside']['event'] = $media->getLatestEvent(10);
        $CommonClass = new CommonClass();
        if (count($data['result']['rightside']['notice'])>0) {
            foreach ($data['result']['rightside']['notice'] as &$rwn) {
                $rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
            }
        }
        if (count($data['result']['rightside']['media'])>0) {
            foreach ($data['result']['rightside']['media'] as &$rwm) {
                $rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
            }
        }*/
        
        return view('aboutus.map_chart', $data);
    }
}
