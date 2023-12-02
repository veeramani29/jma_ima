<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downloads_Model extends CI_Model  {

	public function __construct()
		{
		 parent::__construct();
		
		}

		

	public function get_all_downloads($product_id)
	{				
			$downloads_alldetails=array();
			if($product_id!=''){ $this->db->where('product_id',$product_id); }
			$get_results = $this->db->get(DOWNLOADS);
			
			$downloads_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
				$downloads_alldetails['results']=$get_results->result_array();
			}
			
			return $downloads_alldetails;
	}


	public function get_edit_downloads($edit_id)
	{
	
		$this->db->where('download_id',$edit_id);
		$get_results = $this->db->get(DOWNLOADS)->row_array();
		
		
		return $get_results;
	}

			public function	update_downloads($post_data,$edit_id){
			
			$this->db->where('download_id',$edit_id);
			$get_results =$this->db->update(DOWNLOADS,$post_data);

			
			return $get_results;
			}

			

			

			public function	insert_downloads($post_data){
			
			if(!isset($post_data['latest_release'])){
				$post_data['latest_release']='No';

				}

				if(!isset($post_data['downloadable'])){
				$post_data['downloadable']='No';

				}

				
			$this->db->insert(DOWNLOADS,$post_data);

			}

	
}
