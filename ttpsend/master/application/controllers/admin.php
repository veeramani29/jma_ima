<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	

		public function __construct()
		{
		parent::__construct();
		$this->load->model('Admin_Model');
		define('COMPANY_LOGO', 'assets/uploads/agents_logo/');
		
		}

	public function index()
	{
		$data['success_msg']='';
		if($this->input->post('hdnMethod')=='Active'){
			$this->active($this->input->post('Checkall'));
			$data['success_msg']='Selected items are activated';
		}elseif($this->input->post('hdnMethod')=='Inactive'){
			$this->inactive($this->input->post('Checkall'));
			$data['success_msg']='Selected items are inactivated';
		}
		$get_all_admins=$this->Admin_Model->get_all_admins();
		$data['all_admins']=$get_all_admins;
		$this->load->view('manage_admin',$data);
	}

	public function edit($edit_id='')
	{

$data['error_msg']='';
$data['success_msg']='';
$edit_id=($edit_id!=null)?$edit_id:$this->session->userdata('admin_data')['user_id'];

if($this->input->post('change')!=null){
$this->form_validation->set_rules('new_password', 'Current Password', 'trim|matches[hdnpassword]|xss_clean');
$this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[passconf]|xss_clean');
$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean');

	if ($this->form_validation->run() == TRUE)
		{ 
			$post_data['password']=$this->input->post('password');
			$get_pass_results=$this->Admin_Model->update_admin_password($post_data,$edit_id);
			if(is_string($get_pass_results)){
				$data['error_msg']=$get_pass_results;
			}else{
				$data['success_msg']='Successfully changed your password';
			}
			
		}

}else{
$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique_edit['.ADMIN.'.user_email.user_id.'.$edit_id.']|xss_clean');
$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
$this->form_validation->set_rules('access_level', 'Access Level', 'trim|required|xss_clean');	

if ($this->form_validation->run() == TRUE)
		{ 

			$old_file = $this->input->post('hdnoldfile');
				if(is_array($_FILES) == true && $_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 0) {
				$config['upload_path']='./assets/uploads/agents_logo';
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

			$post_data=$this->input->post();
			$post_data['logo']=$new_filename;
				unset($post_data['hdnoldfile']);
				unset($post_data['file']);
				
			$get_results=$this->Admin_Model->update_admin($post_data,$edit_id);
			if(is_string($get_results)){
				$data['error_msg']=$get_results;
			}else{
				$data['success_msg']='Successfully updated admin details';
			}
			
		}


}

		$get_all_admins=$this->Admin_Model->get_edit_admins($edit_id);
		$data['edit_admins']=$get_all_admins;
		$this->load->view('edit_admin',$data);
	}




	public function changepassword($edit_id='')
	{

$data['error_msg']='';
$data['success_msg']='';
$edit_id=($edit_id!=null)?$edit_id:$this->session->userdata('admin_data')['user_id'];

if($this->input->post('change')!=null){
$this->form_validation->set_rules('new_password', 'Current Password', 'trim|matches[hdnpassword]|xss_clean');
$this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[passconf]|xss_clean');
$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean');

	if ($this->form_validation->run() == TRUE)
		{ 
			$post_data['password']=$this->input->post('password');
			$get_pass_results=$this->Admin_Model->update_admin_password($post_data,$edit_id);
			if(is_string($get_pass_results)){
				$data['error_msg']=$get_pass_results;
			}else{
				$data['success_msg']='Successfully changed your password';
			}
			
		}

}

		$get_all_admins=$this->Admin_Model->get_edit_admins($edit_id);
		$data['edit_admins']=$get_all_admins;
		$this->load->view('changepassword',$data);
	}


			public function add()
			{


			$data['error_msg']='';
			$data['success_msg']='';
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique['.ADMIN.'.user_email]|xss_clean');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('access_level', 'Access Level', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|xss_clean');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean');

				
			if ($this->form_validation->run() == TRUE)
			{ 
				$old_file = $this->input->post('hdnoldfile');
				if(is_array($_FILES) == true && $_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 0) {
				$config['upload_path']='./assets/uploads/agents_logo';
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

			$post_data=$this->input->post();
			unset($post_data['passconf']);
				unset($post_data['file']);
			$post_data['logo']=$new_filename;
			$get_results=$this->Admin_Model->insert_admin($post_data);
			if(is_string($get_results)){
			$data['error_msg']=$get_results;
			}else{
			$data['success_msg']='Successfully added admin details';
			}

			}
			$this->load->view('edit_admin',$data);
			}
			public function	delete($id){
			$this->db->where('user_id',$id);
			$result=$this->db->delete(ADMIN);
			return $result;
			}

			public function	inactive($id){
			$this->db->where_in('user_id',$id);
			$result=$this->db->update(ADMIN,array('user_status' => 'Inactive' ));
			return $result;
			}
			public function	active($id){
			
			$this->db->where_in('user_id',$id);
			$result=$this->db->update(ADMIN,array('user_status' => 'Active' ));
			return $result;

			}

			public function	unauthorized(){
				$this->load->view('errors/unauthorized');
			}
	
}
