<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MyClass extends CI_Controller {

	

		public function __construct()
		{
			

		parent::__construct();

		self::__autoload();
		

		}
			public function __autoload()
			{
				require_once APPPATH.'config/'.ENVIRONMENT.'/db_constants.php';

				

			}

			public function check_session()
			{

	#print_r($_COOKIE);die;
				if(isset($_COOKIE['BLUESTAR_USER']) && !empty($_COOKIE['BLUESTAR_USER']) && $this->session->userdata('admin_data')==null)
				{
			
			$rmb = $_COOKIE['BLUESTAR_USER'];
			$remember = explode("|||",$_COOKIE['BLUESTAR_USER']);
			$post_data['user_email'] = base64_decode($remember[0]);
			$post_data['password'] = base64_decode($remember[1]);
			$this->load->model('Login_Model');
			$this->Login_Model->cookie_login($post_data);
			
				
				}

			if($this->router->fetch_class()!='login') {  
			if($this->session->userdata('admin_data')==null){
			$this->session->unset_userdata('admin_data');
			redirect(base_url());
			}
			}
			}

			public function get_global_admin_data()
			{
			if($this->router->fetch_class()!='login') {  
			if($this->session->userdata('admin_data')!=null){
					$this->db->where('user_id',$this->session->userdata('admin_data')['user_id']);
					$this->db->where('user_status','Active');
		 			$status_results = $this->db->get(ADMIN);
		 			if($status_results->num_rows==1){
		 				$admin_fulldetails=$status_results->row_array();
						$this->session->set_userdata('admin_data', $admin_fulldetails);
		 			}else{
		 				$this->session->unset_userdata('admin_data');
						redirect(base_url());	
		 			}
			
			}else{
			$this->session->unset_userdata('admin_data');
			redirect(base_url());	
			}
			}
			}


		public function load_header()
		{
			//$this->router->fetch_class()!='login' && 
	if($this->router->fetch_class()!='login' &&  empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {  
		$this->load->view('header');
		}
		
		}
//strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
		//$this->input->is_ajax_request(),$this->router->fetch_class()!='login' && 
		public function load_footer()
		{
if($this->router->fetch_class()!='login' &&  empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {  
	$this->load->view('footer');
}
		
		}

	
}