<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_user extends CI_Controller {

	

		public function __construct()
		{
		parent::__construct();
		$this->load->model('Discount_Model');
		$this->load->model('Subscriptions_Model');
		}

	

public function index()
	{
$this->load->model('Email_Model');

		

$data['error_msg']='';$data['success_msg']='';


		$sender_id=$this->session->userdata('admin_data')['user_id'];
		$this->form_validation->set_rules('send_user_list', 'User List', 'required|xss_clean');
		$this->form_validation->set_rules('send_subject', 'Subject', 'trim|required|xss_clean');
		$this->form_validation->set_rules('send_msg', 'Message', 'trim|required|xss_clean');






		if ($this->form_validation->run() == TRUE)
		{ 


		$config['upload_path'] = '../contact_user_attachment/';
	$config['allowed_types'] = '*';
		/*	$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';*/

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($this->upload->do_upload('attachment'))
		{
			$upload_data =$this->upload->data();
			$post_data['upload_data']=$upload_data['full_path'];
			

		}

		//echo $this->upload->display_errors();
		
			


			$post_data=$this->input->post();
			$post_data['send_other_list']=array();
			$post_data['send_user_list']=array();
		
		if($this->input->post('other_user')!=null){
			
			$others=explode(',',$this->input->post('other_user'));
			$post_data['send_other_list']=$others;

		 

		}
			
			
			$post_data['send_by']=$sender_id;
			$post_data['send_on']=date("Y-m-d");
			if($this->input->post('send_user_list')!=null){ $post_data['send_user_list']=$this->input->post('send_user_list'); }
			$post_data['send_user_list']=json_encode(array_merge($post_data['send_user_list'],$post_data['send_other_list']));
			//print_r($post_data['send_user_list']);die;
			$this->Email_Model->send_contact_mail($post_data);
			$data['success_msg']='Successfully sent mail details';
			
		}


		$this->load->view('contact_user',$data);
		
	}



	
	
}
