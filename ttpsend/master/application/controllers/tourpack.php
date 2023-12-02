<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tourpack extends CI_Controller {

	public function __construct(){
		parent::__construct();
		 $this->load->database();
        $this->load->model('Tourpack_Model');
		define('WEB_URL', site_url().'/');
		define('PACKAGE_LRGIMG', 'assets/uploads/tourpack_banner_image/');
		define('PACKAGE_SMLIMG', 'assets/uploads/tourpack_small_image/');
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
				$data['success_msg']='';
			$data['all_pack'] = $this->Tourpack_Model->get_all_tourpack_details();
			//print_r($data['all_pack']);die;
			$this->load->view('tour_pack/manage_tourpack', $data);
		
	}
	

	

	public function add_new_pack($id=''){
			
		//error_reporting(0);

			
			$data['error_msg']='';
			$data['success_msg']='';
			$Title = $this->input->post('txtTitle');
			$Descriptions = $this->input->post('Descriptions');
			$Offer = $this->input->post('txtOffer');
			$Location = $this->input->post('txtLocation');
			$Category = $this->input->post('Category');
			$Author_Name = $this->input->post('Author_Name');
			$Inclusions = $this->input->post('Inclusions');
			$Exclusions = $this->input->post('Exclusions');
			$old_file = $this->input->post('hdnoldfile');
	
			
			$this->form_validation->set_rules('txtTitle', 'Title', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('Descriptions', 'Descriptions', 'trim|required|min_length[3]|xss_clean');
        	$this->form_validation->set_rules('txtOffer', 'Offer', 'trim|required|min_length[3]|xss_clean');        
        	$this->form_validation->set_rules('txtLocation', 'Location', 'required|xss_clean');
        	$this->form_validation->set_rules('Category', 'Category', 'required|xss_clean');
        	$this->form_validation->set_rules('Author_Name', 'Author Name', 'required|xss_clean');
        	$this->form_validation->set_rules('Inclusions', 'Inclusions', 'required|xss_clean');
        	$this->form_validation->set_rules('Exclusions', 'Exclusions', 'required|xss_clean');
        	
        	
			if($this->input->post('offersub')!='submit'){
				
			if($this->form_validation->run() == true){
			
				
				if(is_array($_FILES) == true && $_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 0) {
				$config['upload_path']='./assets/uploads/tourpack_small_image';
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
						//print_r($image_data);
					 $new_filename=time().$image_data['file_ext'];
					rename($image_data['full_path'],$image_data['file_path'].$new_filename);
				
				}
							
			}else{
				$new_filename=$old_file;
			}
			
			
			if(is_array($_FILES) == true && is_array($_FILES['bannerfile']['error']) && is_array($_FILES['bannerfile']['size'])) {
				
			
				$new_filename1=array();
				$cc=count($_FILES['bannerfile']['name']);
				for($i=0; $i<$cc; $i++) {
  
					$tmpFilePath = $_FILES['bannerfile']['tmp_name'][$i];

					if ($tmpFilePath != ""){

						 $newFilePath = "assets/uploads/tourpack_banner_image/".$_FILES['bannerfile']['name'][$i];

    
						if(move_uploaded_file($tmpFilePath, $newFilePath)) {

                             $banner_new_filename=time().rand(10, 9999999).'.'. pathinfo($newFilePath, PATHINFO_EXTENSION);
                             $new_filename1[] =$banner_new_filename;
							 rename($newFilePath,"assets/uploads/tourpack_banner_image/".$banner_new_filename);

						} 
					}
				}
				
					
			}
			
			if($id!=''){
				   $date_text='mod_date';
					}else{
						$date_text='add_date';
					}
					
			
			
			$data=array(
				  'title'=>$Title,
				   'pack_desc'=>$Descriptions,
				   'offer'=>$Offer,
				   'location'=>$Location,
					'category'=>$Category,
				   'author_name'=>$Author_Name,
				   'inclusions'=>$Inclusions,
				   'exclusions'=>$Exclusions,
					"$date_text"=>date("Y-m-d H:i:s"),
				   'small_image'=>$new_filename,
				   'who_created' =>($this->session->userdata('admin_data')['user_id'])
				);
				if($id!=''){
				$this->db->where('id', $id);
				$this->db->update('tourpack_details', $data); 
				$flight_id=$id;
				//echo $this->db->last_query();exit;
			}else{
				$this->db->insert('tourpack_details', $data);
				$flight_id=$this->db->insert_id();
			}

				
								
				if(is_array($_FILES) == true && is_array($_FILES['bannerfile']['error']) && is_array($_FILES['bannerfile']['size'])) {
					
					foreach($new_filename1 as $v){
						$data=array(
						    'pack_id'=>$flight_id,
						    'image'=>$v,
						    'add_date'=>date("Y-m-d H:i:s")
						);
					$this->db->insert('tourpack_images', $data); 
					}
					
				}
				redirect('tourpack/');
			}
			
		}
		if($id!=''){
			$data['pack_details'] = $this->Tourpack_Model->get_pack_details($id);
			//print_r($data);die;
			$data['pack_images'] = $this->Tourpack_Model->get_pack_images($id);
			
		}
		   	$data['cats'] = $this->Tourpack_Model->get_all_tourpack_categories();
		  // 	print_r($data['cats']);die;
			$this->load->view('tour_pack/add_new_pack',$data);
			
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
