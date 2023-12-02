<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tariffs extends CI_Controller {

	public function __construct(){
		parent::__construct();
		 $this->load->database();
        $this->load->model('Tourpack_Model');
         $this->load->model('Companies_Model');
		define('WEB_URL', site_url().'/');
		
		define('CMPNY_SMLIMG', WEB_URL.'assets/uploads/companies_logo/');
		$this->load->library('form_validation');
	}
	  
	 
	
			public function index(){

				$data['all_tariffs'] = $this->Companies_Model->get_allTariffs();

				$this->load->view('tariffs/index', $data);

				}

			public function	inactive($id){
			$this->db->where_in('id',$id);
			$result=$this->db->update('tariffs_details',array('status' => 'Inactive' ));
			return $result;
			}
			public function	active($id){

			$this->db->where_in('id',$id);
			$result=$this->db->update('tariffs_details',array('status' => 'Active' ));
			return $result;

			}


			public function	view(){

			$tariffs_details = $this->Companies_Model->get_Tariff($this->input->post('ID'));


			$view='<table class="table table-bordered">
          <tbody>
            <tr>
              <th> Company </th>
              <td>'.$this->Companies_Model->get_companiename($tariffs_details['company_name']).'</td>
            </tr>
            <tr>
              <th> Vehicle Category </th>
              <td>'.$tariffs_details['vehicle_category'].'</td>
            </tr>
            <tr>
              <th> Package Type </th>
              <td>'.$tariffs_details['package_type'].'</td>
            </tr>
            <tr>
              <th> Base Rate </th>
              <td>'.$tariffs_details['combany_base_rate'].'</td>
            </tr>
            <tr>
              <th> Extra hr Rate</th>
              <td>'.$tariffs_details['combany_extra_hr_rate'].'</td>
            </tr>
            <tr>
              <th> Extra KM Rate </th>
              <td>'.$tariffs_details['combany_extra_km_rate'].'</td>
            </tr>
            <tr>
              <th> Outstation KM Rate</th>
              <td>'.$tariffs_details['company_outstn_km_rate'].'</td>
            </tr>
            <tr>
              <th> Night Batta </th>
             <td>'.$tariffs_details['company_batta'].'</td>
            </tr>
            <tr>
              <th> Outstation Batta </th>
             <td>'.$tariffs_details['company_outstation_batta'].'</td>
            </tr>
          </tbody>
        </table>';

        echo json_encode($view);
			#$this->load->view('tariffs/view',$data);

			}
	

	

	public function add_tariff($id=''){
			
		//error_reporting(0);

			
			$data['error_msg']='';
			$data['success_msg']='';
			
		
	
		
			
			/*if($id!=''){
			$this->form_validation->set_rules('name', 'Company Name', 'trim|required|min_length[3]|is_unique_edit[tariffs_details.name.id.'.$id.']|xss_clean');
			}else{
			$this->form_validation->set_rules('name', 'Company Name', 'trim|required|min_length[3]|xss_clean|is_unique[tariffs_details.name]');
			}*/
			
			$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('vehicle_category', 'Vehicle Category', 'trim|required|xss_clean');

			$this->form_validation->set_rules('package_type', 'Package type', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('combany_base_rate', 'Company Base Rate', 'trim|required|xss_clean');        
        	$this->form_validation->set_rules('cab_base_rate', 'Cab Base Rate', 'required|xss_clean');

        	/*$this->form_validation->set_rules('email', 'Email', '|xss_clean|valid_email');
        	$this->form_validation->set_rules('website', 'website', '|xss_clean|valid_url');
        	$this->form_validation->set_rules('map_location', 'Map Location', '|xss_clean|valid_url');
        	$this->form_validation->set_rules('tariffs', 'Tariffs', '|xss_clean|valid_url');*/
        
        	
        	
			if($this->input->post('submit')!=''){
				
			if($this->form_validation->run() == true){
			
			
			
		
			
				if($id!=''){
				$date_text='mod_date';
				}else{
				$date_text='add_date';
				}
					
			
			
				$data=array(
				'company_name'=>$this->input->post('company_name'),
				'vehicle_category'=>$this->input->post('vehicle_category'),
				'package_type'=>$this->input->post('package_type'),
				'combany_base_rate'=>$this->input->post('combany_base_rate'),
				'cab_base_rate'=>$this->input->post('cab_base_rate'),
				'combany_extra_hr_rate'=>$this->input->post('combany_extra_hr_rate'),
				'cab_extra_hr_rate'=>$this->input->post('cab_extra_hr_rate'),
				'combany_extra_km_rate'=>$this->input->post('combany_extra_km_rate'),
				'cab_extra_km_rate'=>$this->input->post('cab_extra_km_rate'),
				'company_outstn_km_rate'=>$this->input->post('company_outstn_km_rate'),
				'cab_outstn_km_rate'=>$this->input->post('cab_outstn_km_rate'),
				'company_batta'=>$this->input->post('company_batta'),
				'cab_batta'=>$this->input->post('cab_batta'),
				'company_outstation_batta'=>$this->input->post('company_outstation_batta'),
				'cab_outstation_batta'=>$this->input->post('cab_outstation_batta'),
				/*'garage_place'=>$this->input->post('garage_place'),
				'garage_location'=>$this->input->post('garage_location'),
				'garage_distance'=>$this->input->post('garage_distance'),*/
				"$date_text"=>date("Y-m-d H:i:s"),
			
				'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
			if($id!=''){
			$this->db->where('id', $id);
			$this->db->update('tariffs_details', $data); 
			$flight_id=$id;
			//echo $this->db->last_query();exit;
			$data['success_msg']='Successfully updated tariffs details';
		    }else{
				$this->db->insert('tariffs_details', $data);
				$flight_id=$this->db->insert_id();
				$data['success_msg']='Successfully added tariffs details';
			}

				
				
				#msg
			}
			
		}
		if($id!=''){
			$data['tariff_details'] = $this->Companies_Model->get_Tariff($id);
			
			
		}

		$data['all_companies'] = $this->Companies_Model->get_allCompanies();
		$data['allVehicle_Categories'] = $this->Companies_Model->get_allVehicle_Categories();

		
		  		
		   #	print_r($data['all_companies']);die;
			$this->load->view('tariffs/add',$data);
			
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
