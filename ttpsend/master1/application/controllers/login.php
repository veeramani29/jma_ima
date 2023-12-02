<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	

		public function __construct()
		{
		parent::__construct();
		$this->load->model('Login_Model');
		
		}

	public function index()
	{

		$data['error_msg']='';

$this->form_validation->set_rules('user_email', 'Username', 'trim|required|valid_email|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$post_data=$this->input->post();
			$get_results=$this->Login_Model->check_login($post_data);
			if(is_string($get_results)){
				$data['error_msg']=$get_results;
			}
			
		}


		$this->load->view('index',$data);
	}

	public function forgotpassword(){
$data['error_msg']='';$data['success_msg']='';


$this->form_validation->set_rules('user_email', 'User Email', 'trim|required|valid_email|xss_clean');


		if ($this->form_validation->run() == TRUE)
		{
			$post_data=$this->input->post();
			
			$get_results=$this->Login_Model->forgotpassword($post_data);

			if($get_results==0){
				$data['error_msg']="Your email address could not found our database";
			}else{
				$this->load->model('Email_Model');
				$this->Email_Model->send_forgot_pswd_mail($post_data);
				$data['success_msg']="Please check you email";
			}
		}
		$this->load->view('forgotpassword',$data);
	}

public function signout(){

if($this->session->userdata('admin_data')!=null){


	if(isset($_COOKIE['BLUESTAR_USER']) && !empty($_COOKIE['BLUESTAR_USER']))
				{ 
					
					unset($_COOKIE['BLUESTAR_USER']);
		
				     setcookie('BLUESTAR_USER', null, -1, '/');

				}
					$this->session->unset_userdata('admin_data');
	}
redirect(base_url());
}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */