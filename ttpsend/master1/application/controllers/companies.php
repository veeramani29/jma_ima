<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends CI_Controller {

	public function __construct(){
		parent::__construct();
		 $this->load->database();
        $this->load->model('Tourpack_Model');
         $this->load->model('Companies_Model');
		define('WEB_URL', site_url().'/');
		
		define('CMPNY_SMLIMG', WEB_URL.'assets/uploads/companies_logo/');
		$this->load->library('form_validation');
	}
	  
	 
	 public function categories(){
			$data['success_msg']='';
			$data['pages'] = $this->Tourpack_Model->get_all_tourpack_categories();
			$this->load->view('tour_pack/manage_categories', $data);
		
	}

	public function add_category($edit_id=''){
		
		$data['error_msg']='';
		$data['success_msg']='';
		if($this->input->post('add_cat')!=null){

		$this->form_validation->set_rules('category_name', 'Enter category name', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
			{ 
				$post_data['category_name']=$this->input->post('category_name');
				if($edit_id!=''){
					$get_pass_results=$this->Tourpack_Model->update_category($post_data,$edit_id);
				if(is_string($get_pass_results)){
					$data['error_msg']=$get_pass_results;
				}else{
					$data['success_msg']='Successfully updated category';
				}
				}else{
					$get_pass_results=$this->Tourpack_Model->insert_category($post_data);
				if(is_string($get_pass_results)){
					$data['error_msg']=$get_pass_results;
				}else{
					$data['success_msg']='Successfully added category';
				}
				}
				
				
			}

		}
			if($edit_id!=''){
				$data['edit_cats'] = $this->Tourpack_Model->get_edit_category($edit_id);
			}
			
			$this->load->view('tour_pack/add_category', $data);
		
	}


	public function	category_delete($id){
			$this->db->where('id',$id);
			$result=$this->db->delete('tourpack_category');
			return $result;
			}

			public function	category_inactive($id){
			$this->db->where_in('id',$id);
			$result=$this->db->update('tourpack_category',array('status' => 'Inactive' ));
			return $result;
			}
			public function	category_active($id){
			
			$this->db->where_in('id',$id);
			$result=$this->db->update('tourpack_category',array('status' => 'Active' ));
			return $result;

			}

	
	
	public function index(){
			
			$data['all_companies'] = $this->Companies_Model->get_allCompanies();
		
			$this->load->view('companies/index', $data);
		
	}

			public function	inactive($id){
			$this->db->where_in('id',$id);
			$result=$this->db->update('companies_details',array('status' => 'Inactive' ));
			return $result;
			}
			public function	active($id){

			$this->db->where_in('id',$id);
			$result=$this->db->update('companies_details',array('status' => 'Active' ));
			return $result;

			}


			public function	view($id){

			$data['company_details'] = $this->Companies_Model->get_Company($id);
			$this->load->view('companies/view',$data);

			}
	

	

	public function add_companies($id=''){
			
		//error_reporting(0);

			
			$data['error_msg']='';
			$data['success_msg']='';
			
		
	
		
			
			if($id!=''){
			$this->form_validation->set_rules('name', 'Company Name', 'trim|required|min_length[3]|is_unique_edit[companies_details.name.id.'.$id.']|xss_clean');
			}else{
			$this->form_validation->set_rules('name', 'Company Name', 'trim|required|min_length[3]|xss_clean|is_unique[companies_details.name]');
			}
			
			$this->form_validation->set_rules('dispaly_name', 'Display Name', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|min_length[3]|xss_clean');

			$this->form_validation->set_rules('person_name', 'Person Name', 'trim|required|min_length[3]|xss_clean');
        	$this->form_validation->set_rules('number', 'Contact Number', 'trim|required|min_length[10]|xss_clean');        
        	$this->form_validation->set_rules('address', 'Address', 'required|xss_clean|min_length[3]');

        	$this->form_validation->set_rules('email', 'Email', '|xss_clean|valid_email');
        	$this->form_validation->set_rules('website', 'website', '|xss_clean|valid_url');
        	$this->form_validation->set_rules('map_location', 'Map Location', '|xss_clean|valid_url');
        	$this->form_validation->set_rules('tariffs', 'Tariffs', '|xss_clean|valid_url');
        
        	
        	
			if($this->input->post('submit')!=''){
				
			if($this->form_validation->run() == true){
			
				
				if(is_array($_FILES) == true && $_FILES['logo']['error'] == 0 && $_FILES['logo']['size'] > 0) {
				$config['upload_path']='./assets/uploads/companies_logo';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
							
			
												
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('logo')) {
					echo $this->upload->display_errors();
				}else{
						$image_data =  $this->upload->data();
						//print_r($image_data);
					 $new_filename=time().$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_filename);
				
				}
							
			}else{
					$old_file = $this->input->post('hdnoldfile');
				$new_filename=$old_file;
			}
			
			
		
			
				if($id!=''){
				$date_text='mod_date';
				}else{
				$date_text='add_date';
				}
					
			
			
				$data=array(
				'name'=>$this->input->post('name'),
				'person_name'=>$this->input->post('person_name'),
				'number'=>$this->input->post('number'),
				'address'=>$this->input->post('address'),
				'short_name'=>$this->input->post('short_name'),
				'dispaly_name'=>$this->input->post('dispaly_name'),
				'notes'=>$this->input->post('notes'),
				#'tariffs'=>$this->input->post('tariffs'),
				'map_location'=>$this->input->post('map_location'),
				'gstin'=>$this->input->post('gstin'),
				'website'=>$this->input->post('website'),
				'email'=>$this->input->post('email'),
				'contract_status'=>$this->input->post('contract_status'),
				'agreement_date'=>$this->input->post('agreement_date'),
				'agreement_exp_date'=>$this->input->post('agreement_exp_date'),
				'garage_place'=>$this->input->post('garage_place'),
				'garage_location'=>$this->input->post('garage_location'),
				'garage_distance'=>$this->input->post('garage_distance'),
				"$date_text"=>date("Y-m-d H:i:s"),
				'logo'=>$new_filename,
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
			if($id!=''){
			$this->db->where('id', $id);
			$this->db->update('companies_details', $data); 
			$flight_id=$id;
			//echo $this->db->last_query();exit;
			$data['success_msg']='Successfully updated companies details';
		    }else{
				$this->db->insert('companies_details', $data);
				$flight_id=$this->db->insert_id();
				$data['success_msg']='Successfully added companies details';
			}

				
				
				#msg
			}
			
		}
		if($id!=''){
			$data['company_details'] = $this->Companies_Model->get_Company($id);
			
			
		}
		  
		   //	print_r($data['company_details']);die;
			$this->load->view('companies/add',$data);
			
	}
	public function delete_tourpack_img($imgid,$offerid){
		$res = $this->Tourpack_Model->delete_tourpack_img($imgid);
		if($res){
			redirect('tourpack/add_new_pack/'.$offerid,'refresh');
		}
	}

	
	
	public function isDetailsExists($date){
		
		
		$exists = $this->Tourpack_Model->isDetailsExists($date);
		if($exists){
			$response = array('s'=>'Sorry Dear, This Flight Details already exists please try anothere','status'=>0);
		}else{
			$response = array('s'=>'Flight Details available','status'=>1);
		}
		echo json_encode($response);
	}
	
	public function isTitleExists(){
		$data=$this->input->post('data');
		
		$exists = $this->Tourpack_Model->isTitleExists($data);
		if($exists){
			$response = array('s'=>'Sorry Dear, This Title already exists please try anothere','status'=>0);
		}else{
			$response = array('s'=>'This Title available','status'=>1);
		}
		echo json_encode($response);
	}
	
	
	public function delete($id){
		$res = $this->Tourpack_Model->delete($id);
		if($res){
			redirect('tourpack/','refresh');
		}
	}
	
	public function updateStatus($id,$value){
		$status = array('status'=>$value);
		$res = $this->Tourpack_Model->updateStatus($id,$status);
		if($res){
			redirect('tourpack/','refresh');
		}
	}

	
	
	public function uniqueLabel($string) {
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}

	public function enquiry(){
		if($this->session->userdata('admin_logged_in')){
			$data['pages'] = $this->Tourpack_Model->get_all_tourpack_enquiry();
			$this->load->view('tour_pack/manage_enquiry', $data);
		}else{
		  redirect('','refresh');
		}	
	}
	
	
}
?>
