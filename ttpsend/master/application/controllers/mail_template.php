<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_template extends CI_Controller {

	

		public function __construct()
		{
		parent::__construct();
		$this->load->model('Email_Model');
		
		}

	

			public function index()
			{

			$data['error_msg']='';$data['success_msg']='';
			$results=$this->Email_Model->get_allmail_templates();
			$data['all_mails']=$results;

			
			//$data['success_msg']='Successfully sent mail details';
			$this->load->view('manage_mail_template',$data);

			}


public function edit($edit_id='')
{

$data['error_msg']='';
$data['success_msg']='';
if($edit_id!=''){
$edit_id=($edit_id!=null)?$edit_id:$this->session->userdata('admin_data')['user_id'];
$this->form_validation->set_rules('mail_title', 'Mail Title', 'trim|required|is_unique_edit['.MAIL_TEMPLATE.'.mail_title.mail_id.'.$edit_id.']|xss_clean');
$this->form_validation->set_rules('mail_subject', 'Mail Subject', 'trim|required|xss_clean');
$this->form_validation->set_rules('mail_content', 'Mail Content', 'required');




if ($this->form_validation->run() == TRUE)
{ 
$post_data=$this->input->post();

//print_r($post_data);die;
$get_results=$this->Email_Model->update_mails($post_data,$edit_id);
$data['success_msg']='Successfully updated mail template details';

}




$get_all_mails=$this->Email_Model->get_edit_mails($edit_id);
$data['edit_mails']=$get_all_mails;
$this->load->view('edit_mail_template',$data);

}else{
$this->load->view('errors/error_404');
}



}	
	
}
