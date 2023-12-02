<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drivers extends CI_Controller {

	public function __construct(){
		parent::__construct();
		 $this->load->database();
      
         $this->load->model('Drivers_Model');
		define('WEB_URL', site_url().'/');
		
		define('DRIVER_SMLIMG', WEB_URL.'assets/uploads/drivers_logo/');
		define('DRIVER_DOCU', WEB_URL.'assets/uploads/drivers_documents/');
		
		$this->load->library('form_validation');
	}
	  
	 
	



	
	
	public function index(){
			
			$data['all_drivers'] = $this->Drivers_Model->get_allDrivers();
		
			$this->load->view('drivers/index', $data);
		
	}

			public function	inactive($id){
			$this->db->where_in('id',$id);
			$result=$this->db->update('drivers_details',array('status' => 'Inactive' ));
			return $result;
			}
			public function	active($id){

			$this->db->where_in('id',$id);
			$result=$this->db->update('drivers_details',array('status' => 'Active' ));
			return $result;

			}


			public function	view($id){

			$data['drivers_details'] = $this->Drivers_Model->get_Driver($id);
			$this->load->view('drivers/view',$data);

			}
	

	

	public function add_drivers($id=''){
			
		#error_reporting(0);

			
			$data['error_msg']='';
			$data['success_msg']='';
			
			
	
		
			
			/*if($id!=''){
			$this->form_validation->set_rules('name', 'Driver Name', 'trim|required|min_length[3]|is_unique_edit[drivers_details.name.id.'.$id.']|xss_clean');
			}else{
			$this->form_validation->set_rules('name', 'Driver Name', 'trim|required|min_length[3]|xss_clean|is_unique[drivers_details.name]');
			}*/
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]|xss_clean');

			$this->form_validation->set_rules('id_code', 'Id Code', 'trim|required|min_length[3]|xss_clean');
			/*$this->form_validation->set_rules('gender', 'Gender', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|min_length[3]|xss_clean');
		
        	$this->form_validation->set_rules('number', 'Mobile  Number', 'trim|required|min_length[10]|xss_clean');  
        	$this->form_validation->set_rules('WhatsAppnumber', 'WhatsAppnumber', 'trim|required|min_length[10]|xss_clean');
        	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean'); 
        	$this->form_validation->set_rules('residing_area', 'Residing Area', 'required|xss_clean|min_length[3]');         
        	$this->form_validation->set_rules('address', 'Residing Address', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('address', 'Residing Address', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('permanent_address', 'Permanent  Address', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('notes', 'Notes', 'required|xss_clean|min_length[3]');*/


        	if($id!=''){
        			$this->form_validation->set_rules('aadaar_number', 'Aadaar  Number', 'trim|min_length[12]|xss_clean|is_unique_edit[drivers_details.aadaar_number.id.'.$id.']');  
				$this->form_validation->set_rules('dl_number', 'DL  Number', 'trim|min_length[3]|xss_clean|is_unique_edit[drivers_details.dl_number.id.'.$id.']');
			
			}else{
				$this->form_validation->set_rules('aadaar_number', 'Aadaar  Number', 'trim|min_length[12]|xss_clean|is_unique[drivers_details.aadaar_number]');  
				$this->form_validation->set_rules('dl_number', 'DL  Number', 'trim|min_length[3]|xss_clean|is_unique[drivers_details.dl_number]'); 
			}

        	
        	/*$this->form_validation->set_rules('badge_number', 'Badge Number', 'trim|required|min_length[10]|xss_clean');
        	
        	
        	$this->form_validation->set_rules('license', 'License exp date', 'required|xss_clean|min_length[3]');         
        	$this->form_validation->set_rules('badge', 'Badge exp date', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('display_card', 'Display exp date', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('pvc', 'PVC exp date', 'required|xss_clean|min_length[3]');
        	$this->form_validation->set_rules('bgv', 'BGV exp date', 'required|xss_clean|min_length[3]');*/
        
        	
        	
			if($this->input->post('submit')!=''){
				
			if($this->form_validation->run() == true){
			
				
				if(is_array($_FILES) == true && $_FILES['logo']['error'] == 0 && $_FILES['logo']['size'] > 0) {
				$config['upload_path']='./assets/uploads/drivers_logo';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '1000';
				$config['max_width']  = '';
				$config['max_height']  = '';
				$config['remove_spaces']  = false;
							
			
												
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (! $this->upload->do_upload('logo')) {
					$data['error_msg']= $this->upload->display_errors();
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







			// ID Card	
if(is_array($_FILES) == true && $_FILES['id_card_proof']['error'] == 0 && $_FILES['id_card_proof']['size'] > 0) {	
$config['upload_path']='./assets/uploads/drivers_documents';
$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
$config['max_size'] = '1000';
$config['max_width']  = '';
$config['max_height']  = '';
$config['remove_spaces']  = false;


$this->load->library('upload', $config);
$this->upload->initialize($config);
if (! $this->upload->do_upload('id_card_proof')) {
$data['error_msg']= $this->upload->display_errors();
}else{
$image_data =  $this->upload->data();

$new_id_card_proof=time().date("Y-m-d").$image_data['file_ext'];
rename($image_data['full_path'],$image_data['file_path'].$new_id_card_proof);

}

}else{
$new_id_card_proof=$this->input->post('hdnid_card_proof');
}
//Driving License
if(is_array($_FILES) == true && $_FILES['license_proof']['error'] == 0 && $_FILES['license_proof']['size'] > 0) {	
$config['upload_path']='./assets/uploads/drivers_documents';
$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
$config['max_size'] = '1000';
$config['max_width']  = '';
$config['max_height']  = '';
$config['remove_spaces']  = false;


$this->load->library('upload', $config);
$this->upload->initialize($config);
if (! $this->upload->do_upload('license_proof')) {
$data['error_msg']= $this->upload->display_errors();
}else{
$image_data =  $this->upload->data();

$new_license_proof=time().date("Y-m-d").$image_data['file_ext'];
rename($image_data['full_path'],$image_data['file_path'].$new_license_proof);

}

}else{
$new_license_proof=$this->input->post('hdnlicense_proof');
}


//Badge
if(is_array($_FILES) == true && $_FILES['badge_proof']['error'] == 0 && $_FILES['badge_proof']['size'] > 0) {	
$config['upload_path']='./assets/uploads/drivers_documents';
$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
$config['max_size'] = '1000';
$config['max_width']  = '';
$config['max_height']  = '';
$config['remove_spaces']  = false;


$this->load->library('upload', $config);
$this->upload->initialize($config);
if (! $this->upload->do_upload('badge_proof')) {
$data['error_msg']= $this->upload->display_errors();
}else{
$image_data =  $this->upload->data();

$new_badge_proof=time().date("Y-m-d").$image_data['file_ext'];
rename($image_data['full_path'],$image_data['file_path'].$new_badge_proof);

}

}else{
$new_badge_proof=$this->input->post('hdnbadge_proof');
}

//Display Card
if(is_array($_FILES) == true && $_FILES['display_card_proof']['error'] == 0 && $_FILES['display_card_proof']['size'] > 0) {	
$config['upload_path']='./assets/uploads/drivers_documents';
$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
$config['max_size'] = '1000';
$config['max_width']  = '';
$config['max_height']  = '';
$config['remove_spaces']  = false;


$this->load->library('upload', $config);
$this->upload->initialize($config);
if (! $this->upload->do_upload('display_card_proof')) {
$data['error_msg']= $this->upload->display_errors();
}else{
$image_data =  $this->upload->data();

$new_display_card_proof=time().date("Y-m-d").$image_data['file_ext'];
rename($image_data['full_path'],$image_data['file_path'].$new_display_card_proof);

}

}else{
$new_display_card_proof=$this->input->post('hdndisplay_card_proof');
}


//Aadhaar
if(is_array($_FILES) == true && $_FILES['aadaar_card_proof']['error'] == 0 && $_FILES['aadaar_card_proof']['size'] > 0) {	
$config['upload_path']='./assets/uploads/drivers_documents';
$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
$config['max_size'] = '1000';
$config['max_width']  = '';
$config['max_height']  = '';
$config['remove_spaces']  = false;


$this->load->library('upload', $config);
$this->upload->initialize($config);
if (! $this->upload->do_upload('aadaar_card_proof')) {
$data['error_msg']= $this->upload->display_errors();
}else{
$image_data =  $this->upload->data();

$new_aadaar_card_proof=time().date("Y-m-d").$image_data['file_ext'];
rename($image_data['full_path'],$image_data['file_path'].$new_aadaar_card_proof);

}

}else{
$new_aadaar_card_proof=$this->input->post('hdnaadaar_card_proof');
}



//PVC
if(is_array($_FILES) == true && $_FILES['pvc_proof']['error'] == 0 && $_FILES['pvc_proof']['size'] > 0) {	
$config['upload_path']='./assets/uploads/drivers_documents';
$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
$config['max_size'] = '1000';
$config['max_width']  = '';
$config['max_height']  = '';
$config['remove_spaces']  = false;


$this->load->library('upload', $config);
$this->upload->initialize($config);
if (! $this->upload->do_upload('pvc_proof')) {
$data['error_msg']= $this->upload->display_errors();
}else{
$image_data =  $this->upload->data();

$new_pvc_proof=time().date("Y-m-d").$image_data['file_ext'];
rename($image_data['full_path'],$image_data['file_path'].$new_pvc_proof);

}

}else{

$new_pvc_proof=$this->input->post('hdnpvc_prooffile');
}


//BGV
if(is_array($_FILES) == true && $_FILES['bgv_proof']['error'] == 0 && $_FILES['bgv_proof']['size'] > 0) {	
$config['upload_path']='./assets/uploads/drivers_documents';
$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
$config['max_size'] = '1000';
$config['max_width']  = '';
$config['max_height']  = '';
$config['remove_spaces']  = false;


$this->load->library('upload', $config);
$this->upload->initialize($config);
if (! $this->upload->do_upload('bgv_proof')) {
$data['error_msg']= $this->upload->display_errors();
}else{
$image_data =  $this->upload->data();

$new_bgv_proof=time().date("Y-m-d").$image_data['file_ext'];
rename($image_data['full_path'],$image_data['file_path'].$new_bgv_proof);

}

}else{
$new_bgv_proof=$this->input->post('hdnbgv_proof');
}
			
			
		
			
				if($id!=''){
				$date_text='mod_date';
				}else{
				$date_text='add_date';
				}
					
			
				



				$data=array(
				'first_name'=>$this->input->post('first_name'),
				'middle_name'=>$this->input->post('middle_name'),
				'last_name'=>$this->input->post('last_name'),
				'id_code'=>'BST'.$this->input->post('id_code'),
				'gender'=>$this->input->post('gender'),
				'dob'=>$this->input->post('dob'),
				'experience'=>$this->input->post('experience'),
				'number'=>$this->input->post('number'),
				'WhatsAppnumber'=>$this->input->post('WhatsAppnumber'),
				'email'=>$this->input->post('email'),
				'residing_area'=>$this->input->post('residing_area'),
                 'address'=>$this->input->post('address'),
				'permanent_address'=>$this->input->post('permanent_address'),
				'notes'=>$this->input->post('notes'),
				'aadaar_number'=>$this->input->post('aadaar_number'),
				'badge_number'=>$this->input->post('badge_number'),
				'dl_number'=>$this->input->post('dl_number'),
				'license'=>$this->input->post('license'),
				'badge'=>$this->input->post('badge'),
				'display_card'=>$this->input->post('display_card'),
				'pvc'=>$this->input->post('pvc'),
				'bgv'=>$this->input->post('bgv'),
				'id_card_proof'=>$new_id_card_proof,
				'license_proof'=>$new_license_proof,
				'badge_proof'=>$new_badge_proof,
				'display_card_proof'=>$new_display_card_proof,
				'aadaar_card_proof'=>$new_aadaar_card_proof,
				'pvc_proof'=>$new_pvc_proof,
				'bgv_proof'=>$new_bgv_proof,
				"$date_text"=>date("Y-m-d H:i:s"),
				'logo'=>$new_filename,
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
			if($id!=''){
			$this->db->where('id', $id);
			$this->db->update('drivers_details', $data); 
			$flight_id=$id;
			//echo $this->db->last_query();exit;
			$data['success_msg']='Successfully updated driver details';
		    }else{
				$this->db->insert('drivers_details', $data);
				$flight_id=$this->db->insert_id();
				$data['success_msg']='Successfully added driver details';
			}

				
				
				#msg
			}
			
		}
		if($id!=''){
			$data['drivers_details'] = $this->Drivers_Model->get_Driver($id);
			
			
		}
		  
		   //	print_r($data['company_details']);die;
			$this->load->view('drivers/add',$data);
			
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
