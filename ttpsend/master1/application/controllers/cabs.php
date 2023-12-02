<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cabs extends CI_Controller {

	public function __construct(){
		parent::__construct();
		 $this->load->database();
      
         $this->load->model('Cabs_Model');

	    define('WEB_URL', site_url().'/');
		define('VECHICLE_SMLIMG', WEB_URL.'assets/uploads/vehicles_logo/');
		define('VECHICLE_DOCU', WEB_URL.'assets/uploads/vehicles_documents/');
		
		$this->load->library('form_validation');
	}
	  
	 
	



	
	
			public function index(){

			$data['all_vehicles'] = $this->Cabs_Model->get_allVehicles();
			$data['all_drivers'] = $this->Cabs_Model->get_allDrivers();
			$data['all_cabs'] = $this->Cabs_Model->get_allCabs();
			$data['vehicles_assets'] = $this->Cabs_Model->get_VehicleAsssets();
			#print_r($data['all_drivers']);
			$this->load->view('cabs/index', $data);

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

			$data['cabs_details'] = $this->Cabs_Model->get_Cab($id);
			$this->load->view('cabs/view',$data);

			}
	

	

public function add_cabs($id=''){
	$data['error_msg']='';
	$data['success_msg']='';


$this->form_validation->set_rules('vehicle', 'Vehicle number', 'trim|required|xss_clean');
$this->form_validation->set_rules('driver', 'Driver name', 'trim|required|xss_clean');
	
		if($this->input->post('submit')!=''){
			if($this->form_validation->run() == true){
				if($id!=''){
				$date_text='mod_date';
				}else{
				$date_text='add_date';
				}
			$data=array(
				'vehicle'=>$this->input->post('vehicle'),
				'driver'=>$this->input->post('driver'),
				'notes'=>$this->input->post('notes'),
				'induction_status'=>$this->input->post('induction_status'),
				'ride_status'=>$this->input->post('ride_status'),
				'removed_date'=>$this->input->post('removed_date'),
				'induction_date'=>$this->input->post('induction_date'),
				"$date_text"=>date("Y-m-d H:i:s"),
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);

			$query = $this->db->query("SELECT id FROM cabs_details
                           WHERE vehicle = ".$this->db->escape($this->input->post('vehicle'))." and driver = ".$this->db->escape($this->input->post('driver'))." limit 1");

			if($id!=''){
			
			 if($query->num_rows() == 0){
			 	$this->db->where('id', $id);
			$this->db->update('cabs_details', $data); 
			$cabs_id=$id;
			$data['success_msg']='Successfully updated cabs details';
			 }else{
			 	$data['error_msg']='This vehicle and driver already added to the cabs.';
			 } 
			
			#echo $this->db->last_query();exit;
			
		    }else{

		    	

		    	 $query->num_rows() == 0 ? $this->db->insert('cabs_details', $data) : $this->session->set_flashdata('error_msg','This vehicle and driver already added to the cabs.');	;


				#$this->db->insert('cabs_details', $data);
				#$cabs_id=$this->db->insert_id();
				$data['success_msg']='Successfully added cabs details';
				redirect('/cabs');
			}

	
			}
			}
		


			$data['all_vehicles'] = $this->Cabs_Model->get_allVehicles();
			$data['all_drivers'] = $this->Cabs_Model->get_allDrivers();
				if($id!=''){
			$data['cabs_details'] = $this->Cabs_Model->get_Cab($id);
			}
		    $this->load->view('cabs/add',$data);
}

	public function quick_add(){
			
		    //error_reporting(0);
            #print_r($_POST);die;
			#if($id!=''){
			#$this->form_validation->set_rules('Vnumber', 'Vehicle Number', 'trim|required|min_length[3]|is_unique_edit[vehicles_details.Vnumber.id.'.$id.']|xss_clean');
			#}else{
			$this->form_validation->set_rules('Vnumber', 'Vehicle Number', 'trim|required|min_length[3]|xss_clean|is_unique[vehicles_details.Vnumber]');
			#}
			$this->form_validation->set_rules('state_code', 'State Code', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('rto_code', 'RTO code', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('rto_code_', 'RTO code2', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[2]|xss_clean');
			#$this->form_validation->set_rules('Vnumber', 'Vehicle Number', 'trim|required|min_length[3]|xss_clean');  


			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('middle_name', 'Middle Mame', 'trim|required|min_length[1]|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
          	
        
        	
        	
			if($this->input->post('login_btn')!=''){
			
			if($this->form_validation->run() == true){

				$data=array(
				'state_code'=>$this->input->post('state_code'),
				'rto_code'=>$this->input->post('rto_code'),
				'rto_code_'=>$this->input->post('rto_code'),
				'Vnumber'=>$this->input->post('Vnumber'),
				'type'=>$this->input->post('type'),
				"add_date"=>date("Y-m-d H:i:s"),
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
				$this->db->insert('vehicles_details', $data);

				$vehicle_id=$this->db->insert_id();

				$Driver_data=array(
				'first_name'=>$this->input->post('first_name'),
				'middle_name'=>$this->input->post('middle_name'),
				'last_name'=>$this->input->post('last_name'),
				#'id_code'=>'BST'.$this->input->post('id_code'),
				'number'=>$this->input->post('number'),
				"add_date"=>date("Y-m-d H:i:s"),
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
				$this->db->insert('drivers_details', $Driver_data);
				$driver_id=$this->db->insert_id();

				$Cabs_data=array(
				'vehicle'=>$vehicle_id,
				'driver'=>$driver_id,
				'induction_status'=>$this->input->post('induction_status'),
				"add_date"=>date("Y-m-d H:i:s"),
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
				$this->db->insert('cabs_details', $Cabs_data);
				redirect('/cabs');
			}else{
			

		#$this->load->library('form_validation');
        #$this->load->library('session');
      	 $this->session->set_flashdata('error_msg',validation_errors());
				redirect('/cabs');
			}


			
		}
		
			
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
