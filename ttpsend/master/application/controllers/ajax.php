<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	

		public function __construct()
		{
		parent::__construct();
		$this->load->model('Subscriptions_Model');
		$this->load->model('Downloads_Model');
		
		}

	

	public function subscription_edit($edit_id='')
	{


		if($edit_id!=null && $this->input->is_ajax_request()==TRUE){

		$get_all_subscriptions=$this->Subscriptions_Model->get_edit_subscriptions($edit_id);
		$data['edit_subscriptions']=$get_all_subscriptions;
		$get_products=$this->Subscriptions_Model->get_products();
		$data['products_all']=$get_products;
		return $this->load->view('ajax/quickedit',$data);
		}else{
		return $this->load->view('errors/error_404');
		}

		
	}

	public function download_edit($edit_id='')
	{

		if($edit_id!=null && $this->input->is_ajax_request()==TRUE){

		$get_all_downloads=$this->Downloads_Model->get_edit_downloads($edit_id);
		$data['edit_downloads']=$get_all_downloads;
		$get_products=$this->Subscriptions_Model->get_products();
		$data['products_all']=$get_products;
		return $this->load->view('ajax/edit_download',$data);
		}else{
		return $this->load->view('errors/error_404');
		}

		
	}


		
	
}
