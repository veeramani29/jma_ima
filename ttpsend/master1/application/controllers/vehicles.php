<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicles extends CI_Controller {

	public function __construct(){
		parent::__construct();
		 $this->load->database();
      
         $this->load->model('Vehicles_Model');
		define('WEB_URL', site_url().'/');
		
		define('VECHICLE_SMLIMG', WEB_URL.'assets/uploads/vehicles_logo/');
		define('VECHICLE_DOCU', WEB_URL.'assets/uploads/vehicles_documents/');
		
		$this->load->library('form_validation');
	}
	  
	 
	



	
	
	public function index(){
			
			$data['all_vehicles'] = $this->Vehicles_Model->get_allvehicles();
		
			$this->load->view('vehicles/index', $data);
		
	}

			public function	inactive($id){
			$this->db->where_in('id',$id);
			$result=$this->db->update('vehicles_details',array('status' => 'Inactive' ));
			return $result;
			}
			public function	active($id){

			$this->db->where_in('id',$id);
			$result=$this->db->update('vehicles_details',array('status' => 'Active' ));
			return $result;

			}

			


			public function	view($id){

			$data['vehicles_details'] = $this->Vehicles_Model->get_Vehicle($id);
			$this->load->view('vehicles/view',$data);

			}
	

	

	public function add_vehicles($id=''){
			
		//error_reporting(0);

			
			$data['error_msg']='';
			$data['success_msg']='';
			
		
	#print_r($_POST);die;
		
			
			if($id!=''){
			$this->form_validation->set_rules('Vnumber', 'Vehicle Number', 'trim|required|min_length[3]|is_unique_edit[vehicles_details.Vnumber.id.'.$id.']|xss_clean');
			}else{
		$this->form_validation->set_rules('Vnumber', 'Vehicle Number', 'trim|required|min_length[3]|xss_clean|is_unique[vehicles_details.Vnumber]');
			}
		$this->form_validation->set_rules('state_code', 'State Code', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('rto_code', 'RTO code', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('rto_code_', 'RTO code2', 'trim|required|min_length[2]|xss_clean');
		
        /*	temp $this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[2]|xss_clean');  
        	$this->form_validation->set_rules('model', 'Model', 'trim|required|min_length[2]|xss_clean');
        	$this->form_validation->set_rules('seating', 'Seating', 'trim|required|xss_clean'); 
        	$this->form_validation->set_rules('brand', 'Brand', 'required|xss_clean|min_length[3]');         
        	$this->form_validation->set_rules('exterior_color', 'Exterior Color', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('interior_color', 'Interior Color', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('Fecilities[]', 'Fecilities', 'required|xss_clean');
        	$this->form_validation->set_rules('notes', 'Notes', 'required|xss_clean|min_length[3]');*/


        	/*if($id!=''){
        			$this->form_validation->set_rules('aadaar_number', 'Aadaar  Number', 'trim|required|min_length[12]|xss_clean|is_unique_edit[vehicles_details.aadaar_number.id.'.$id.']');  
				$this->form_validation->set_rules('dl_number', 'DL  Number', 'trim|required|min_length[3]|xss_clean|is_unique_edit[vehicles_details.dl_number.id.'.$id.']');
			
			}else{
				$this->form_validation->set_rules('aadaar_number', 'Aadaar  Number', 'trim|required|min_length[12]|xss_clean|is_unique[vehicles_details.aadaar_number]');  
				$this->form_validation->set_rules('dl_number', 'DL  Number', 'trim|required|min_length[3]|xss_clean|is_unique[vehicles_details.dl_number]'); 
			}*/

        	
        	/*temp $this->form_validation->set_rules('reg_date', 'Registration Date', 'trim|required|min_length[10]|xss_clean');
        	
        	
        	$this->form_validation->set_rules('insurance_exp_date', 'Insurance exp date', 'required|xss_clean|min_length[3]');         
        	$this->form_validation->set_rules('tax_exp_date', 'Road Tax exp date', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('poll_exp_date', 'Pollution exp date', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('permit_exp_date', 'Permit exp date', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('fitness_exp_date', 'Fitness exp date', 'required|xss_clean|min_length[3]');*/
        
        	
        	
			if($this->input->post('submit')!=''){
			
            	
		  if($this->form_validation->run() == true){
			
			
				if(is_array($_FILES) == true && $_FILES['logo']['error'] == 0 && $_FILES['logo']['size'] > 0) {
				$config['upload_path']='./assets/uploads/vehicles_logo';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
							
			
												
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('logo')) {
					$data['error_msg']=$this->upload->display_errors();
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
				// rc certificate	
				if(is_array($_FILES) == true && $_FILES['rccert']['error'] == 0 && $_FILES['rccert']['size'] > 0) {	
					$config['upload_path']='./assets/uploads/vehicles_documents';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
					
				
					$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('rccert')) {
					$data['error_msg']= $this->upload->display_errors();
				}else{
						$image_data =  $this->upload->data();
				
					 $new_rccert=time().date("Y-m-d").$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_rccert);
				
				}
					
					}else{
				$new_rccert=$this->input->post('hdnrccert');
			}
				//taxproof
	if(is_array($_FILES) == true && $_FILES['insurancecert']['error'] == 0 && $_FILES['insurancecert']['size'] > 0) {	
					$config['upload_path']='./assets/uploads/vehicles_documents';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
					
				
					$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('insurancecert')) {
					$data['error_msg']= $this->upload->display_errors();
				}else{
						$image_data =  $this->upload->data();
						
					 $new_insurancecert=time().date("Y-m-d").$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_insurancecert);
				
				}
					
					}else{
						$new_insurancecert=$this->input->post('hdninsurancecert');
			}
				
					
					//taxproof
	if(is_array($_FILES) == true && $_FILES['taxcert']['error'] == 0 && $_FILES['taxcert']['size'] > 0) {	
					$config['upload_path']='./assets/uploads/vehicles_documents';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
					
				
					$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('taxcert')) {
					$data['error_msg']= $this->upload->display_errors();
				}else{
						$image_data =  $this->upload->data();
					
					 $new_taxcert=time().date("Y-m-d").$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_taxcert);
				
				}
					
					}else{
				$new_taxcert=$this->input->post('hdntaxcert');
			}
					
					//fitnessproof
	if(is_array($_FILES) == true && $_FILES['fitnesscert']['error'] == 0 && $_FILES['fitnesscert']['size'] > 0) {	
					$config['upload_path']='./assets/uploads/vehicles_documents';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
					
				
					$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('fitnesscert')) {
					$data['error_msg']= $this->upload->display_errors();
				}else{
						$image_data =  $this->upload->data();
						
					 $new_fitnesscert=time().date("Y-m-d").$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_fitnesscert);
				
				}
					
					}else{
			$new_fitnesscert=$this->input->post('hdnfitnesscert');
			}
						
					
						//Emission Certificate proof
	if(is_array($_FILES) == true && $_FILES['emissioncert']['error'] == 0 && $_FILES['emissioncert']['size'] > 0) {	
					$config['upload_path']='./assets/uploads/vehicles_documents';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
					
				
					$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('emissioncert')) {
					$data['error_msg']= $this->upload->display_errors();
				}else{
						$image_data =  $this->upload->data();
						
					 $new_emissioncert=time().date("Y-m-d").$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_emissioncert);
				
				}
					
					}else{
					$new_emissioncert=$this->input->post('hdnemissioncert');
			}
					
					
					
					//Permit Certificate proof
	if(is_array($_FILES) == true && $_FILES['permitcert']['error'] == 0 && $_FILES['permitcert']['size'] > 0) {	
					$config['upload_path']='./assets/uploads/vehicles_documents';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
					
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('permitcert')) {
					$data['error_msg']= $this->upload->display_errors();
				}else{
						$image_data =  $this->upload->data();
						
					 $new_permitcert=time().date("Y-m-d").$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_permitcert);
				
				}
					
					}else{
			
				$new_permitcert=$this->input->post('hdnpermitcertfile');
			}
					
					
				$data=array(
				'state_code'=>$this->input->post('state_code'),
				'rto_code'=>$this->input->post('rto_code'),
				'rto_code_'=>$this->input->post('rto_code_'),
				'Vnumber'=>$this->input->post('Vnumber'),
				'type'=>$this->input->post('type'),
				'seating'=>$this->input->post('seating'),
				'brand'=>$this->input->post('brand'),
				'exterior_color'=>$this->input->post('exterior_color'),
				'interior_color'=>$this->input->post('interior_color'),
                 'Fecilities'=>@implode(",", $this->input->post('Fecilities')),
				'model'=>$this->input->post('model'),
				'notes'=>$this->input->post('notes'),
				'reg_date'=>$this->input->post('reg_date'),
				'insurance_exp_date'=>$this->input->post('insurance_exp_date'),
				'tax_exp_date'=>$this->input->post('tax_exp_date'),
				'poll_exp_date'=>$this->input->post('poll_exp_date'),
				'permit_exp_date'=>$this->input->post('permit_exp_date'),
				'fitness_exp_date'=>$this->input->post('fitness_exp_date'),
				#'pvc'=>$this->input->post('pvc'),
				#'bgv'=>$this->input->post('bgv'),
				"$date_text"=>date("Y-m-d H:i:s"),
				'logo'=>$new_filename,
				'rc_proof'=>$new_rccert,
				'tax_proof'=>$new_taxcert,
				'insurance_proof'=>$new_insurancecert,
				'fitness_proof'=>$new_fitnesscert,
				'emission_proof'=>$new_emissioncert,
				'permit_proof'=>$new_permitcert,
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
			if($id!=''){
			$this->db->where('id', $id);
			$this->db->update('vehicles_details', $data); 
			$flight_id=$id;
			//echo $this->db->last_query();exit;
			$data['success_msg']='Successfully updated driver details';
		    }else{
				$this->db->insert('vehicles_details', $data);
				$flight_id=$this->db->insert_id();
				$data['success_msg']='Successfully added driver details';
			}

				
				
				#msg
			}
			
		}
		if($id!=''){
			$data['vehicles_details'] = $this->Vehicles_Model->get_Vehicle($id);
			
			
		}
		$data['vehicles_assets'] = $this->Vehicles_Model->get_VehicleAsssets();
		  
		  # echo "<pre>";print_r($data['vehicles_assets']);die;
			$this->load->view('vehicles/add',$data);
			
	}
	

	
	
	
	
	
	
		public function dropzone(){
			#print_r($_FILES);
	if(is_array($_FILES) == true && $_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 0) {	
				$config['upload_path']='./assets/uploads/vehicles_logo';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
					
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('file')) {
					echo $this->upload->display_errors();
				}else{
				$image_data =  $this->upload->data();
				$new_=time().date("Y-m-d").$image_data['file_ext'];
				rename($image_data['full_path'],$image_data['file_path'].$new_);

				$data['image_name']=$new_;
				$data['vehicle_id']=$this->input->post('vehicle_id');
				$this->db->insert('vehicles_images', $data);
				
				}
					
			}
	}


	public function vehicle_category(){
		  $this->load->model('Companies_Model');
			$data['all_vehicles_cat'] = $this->Vehicles_Model->get_allVehicles_Cat();

			$this->load->view('vehicles/vehicle_list', $data);

	}

	public function add_vehicle_category($id=''){
		#vehicle_categories
		$data['error_msg']='';
		$data['success_msg']='';
		if($this->input->post('add_cat')!=null){

		$this->form_validation->set_rules('company', 'Select company name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vehicle_types[]', 'Select vehicle type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cate_name', 'Enter category name', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
			{ 
				if($id!=''){
				$date_text='mod_date';
				$who_did='who_modified';
				}else{
				$date_text='add_date';
				$who_did='who_created';

				}
				$data=array(
				'company'=>$this->input->post('company'),
				'vehicle_types'=>implode(',', $this->input->post('vehicle_types')),
				'cate_name'=>$this->input->post('cate_name'),
				"$date_text"=>date("Y-m-d H:i:s"),
				"$who_did" =>($this->session->userdata('admin_data')['user_id'])
				);
			if($id!=''){
			$this->db->where('id', $id);
			$this->db->update('vehicle_categories', $data); 
			$flight_id=$id;
			//echo $this->db->last_query();exit;
			$data['success_msg']='Successfully updated category details';
			}else{
			$this->db->insert('vehicle_categories', $data);
			$flight_id=$this->db->insert_id();
			$data['success_msg']='Successfully added category details';
			}

			
				
				
			}

		}
				if($id!=''){
					$data['vehicles_cat_details'] = $this->Vehicles_Model->get_Vehicle_Cat($id);
				
				}
					   $this->load->model('Companies_Model');
					   $this->load->model('Cabs_Model');
					$data['all_companies'] = $this->Companies_Model->get_allCompanies();
					$data['vehicles_assets'] = $this->Cabs_Model->get_VehicleAsssets();
			
			$this->load->view('vehicles/add_vehicle_category', $data);
		
	}

	public function	cat_inactive($id){
			$this->db->where_in('id',$id);
			$result=$this->db->update('vehicle_categories',array('status' => 'Inactive' ));
			return $result;
			}
			public function	cat_active($id){

			$this->db->where_in('id',$id);
			$result=$this->db->update('vehicle_categories',array('status' => 'Active' ));
			return $result;

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

	
	
}
?>
