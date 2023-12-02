<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model extends CI_Model  {

	public function __construct()
		{
		 parent::__construct();
		
		}

		

	public function get_all_admins()
	{				
			$admin_alldetails=array();
			//debug($this->session->userdata('admin_data'),1);
		if($this->session->userdata('admin_data')['user_id']!=1){
			$this->db->where('user_id',$this->session->userdata('admin_data')['user_id']);
		}
		

			$get_results = $this->db->get(ADMIN);
			$admin_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
				$admin_alldetails['results']=$get_results->result_array();
			}
			
			return $admin_alldetails;
	}


	public function get_edit_admins($edit_id)
	{
		$this->db->where('user_id',$edit_id);
		$get_results = $this->db->get(ADMIN)->row_array();
		
		
		return $get_results;
	}

			public function	update_admin($post_data,$edit_id){
			
			$this->db->where('user_id',$edit_id);
			$this->db->update(ADMIN,$post_data);

			}

			

			public function	update_admin_password($post_data,$edit_id){
			
			$this->db->where('user_id',$edit_id);
			$this->db->update(ADMIN,$post_data);

			}

			public function	insert_admin($post_data){
			
			
			$this->db->insert(ADMIN,$post_data);

			}




			public function get_about_us($edit_id)
	{
		$this->db->where('user_id',$edit_id);
		$get_results = $this->db->get('about_us')->row_array();
		
		
		return $get_results;
	}

			public function	update_about_us($post_data,$edit_id){
			
			$this->db->where('user_id',$edit_id);
			$this->db->update('about_us',$post_data);

			}

			public function	insert_about_us($post_data){
			
			
			$this->db->insert('about_us',$post_data);

			}

	
}
