<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Model extends CI_Model  {

	public function __construct()
		{

			
		 parent::__construct();
		
		}

		

	public function check_login($post_data)
	{				$this->db->select('user_id');
					$this->db->where($post_data);
					$get_results = $this->db->get(ADMIN);
		 if($get_results->num_rows==1){
		 			$this->db->where($post_data);
					$this->db->where('user_status','Active');
		 			$status_results = $this->db->get(ADMIN);
		 			//echo $this->db->last_query();
		 			if($status_results->num_rows==1){
		 				$admin_fulldetails=$status_results->row_array();

		 				$this->session->set_userdata('admin_data', $admin_fulldetails);

		 				//debug($this->session->all_userdata(),1);
						redirect('dashboard');
		 				
		 			}else{
		 				return "Your Account is inactive please contact admin";
		 			}
		
		 }else{

		 	return "Do not match username and password";
		 }
		 

		
		
	}


	public function forgotpassword($post_data)
	{
		$this->db->where($post_data);
		$this->db->where('user_status','Active');
		$get_results = $this->db->get(ADMIN);
		 if($get_results->num_rows==1){

			return 1;
		 }else{

		 	return 0;
		 }
		
		
	}

	
}
