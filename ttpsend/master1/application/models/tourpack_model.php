<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tourpack_Model extends CI_Model {
	
	public function __construct()
    {
	
      parent::__construct();
    }
    
    public function get_all_tourpack_details(){
		
		if($this->session->userdata('admin_data')['user_id']!=1){
			$this->db->where('who_created',$this->session->userdata('admin_data')['user_id']);
		}
		
		$get_results = $this->db->get('tourpack_details');
			$admin_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
				$admin_alldetails['results']=$get_results->result_array();
			}
			
			return $admin_alldetails;

		
	}
	

	 public function get_all_tourpack_enquiry(){
		
		$f_results=$this->db->get('tourpack_enquiry');
		return $f_results->result();
	}
	
	public function get_pack_details($id){
		$this->db->where('id', $id);
		$f_results=$this->db->get('tourpack_details')->row();
		return $f_results;
	}


	
	
	public function get_pack_images($id){
		$this->db->where('pack_id', $id);
		$f_results=$this->db->get('tourpack_images');
		return $f_results->result();
	}


	public function get_pack_day_details($id){
		$this->db->where('pack_id', $id);
		$f_results=$this->db->get('tourpack_days_details');
		return $f_results->result();
	}
	
	
			public function get_all_tourpack_categories()
	{				
			$admin_alldetails=array();
			//debug($this->session->userdata('admin_data'),1);
		if($this->session->userdata('admin_data')['user_id']!=1){
		//	$this->db->where('user_id',$this->session->userdata('admin_data')['user_id']);
		}
		

			$get_results = $this->db->get('tourpack_category');
			$admin_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
				$admin_alldetails['results']=$get_results->result_array();
			}
			
			return $admin_alldetails;
	}
			public function	insert_category($post_data){


			$this->db->insert('tourpack_category',$post_data);

			}

			public function	update_category($post_data,$edit_id){

			$this->db->where('id',$edit_id);
			$this->db->update('tourpack_category',$post_data);

			}

			public function get_edit_category($edit_id)
			{
			$this->db->where('id',$edit_id);
			$get_results = $this->db->get('tourpack_category')->row_array();


			return $get_results;
			}

	
	
	
	
	public function updateStatus($id,$status){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('tourpack_details', $status); 
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	public function delete($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('tourpack_details'); 
		$this->db->where('pack_id', $id);
		$this->db->delete('tourpack_images');
		
		$this->db->trans_complete();
		return $this->db->trans_status();	
	}

	
	
	public function delete_tourpack_img($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('tourpack_images'); 
		$this->db->trans_complete();
		return $this->db->trans_status();	
	}
	
	public function isDetailsExists($date){
		$this->db->select('*');
		$this->db->where('exp_date',$date);
		$query = $this->db->get('tourpack_details');
		if ( $query->num_rows > 0 ) {
         		return true;
      		}
      		return false;
	}



	
	
	
}
	
