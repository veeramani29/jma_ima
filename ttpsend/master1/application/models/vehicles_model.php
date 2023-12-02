<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicles_Model extends CI_Model  {

	public function __construct()
		{
		 parent::__construct();
		//ini_set('sendmail_from', 'veeramani.kamaraj@japanmacroadvisors.com');
		  $config = Array(
	 	//'mailpath' => '/usr/bin/sendmail',
        'protocol' => 'smtp',
        'mailtype'  => 'text',
        'smtp_host' => 'ssl://smtp.gmail.com', //'ssl://smtp.googlemail.com',
       	'smtp_user' => '29veeramani@gmail.com',
        'smtp_pass' => 'vimalmani29',
         'smtp_timeout' => '4',
         'smtp_port' => 465,
         'charset'   => 'utf-8',
        'useragent'   => PROJECT_NAME,
        'wordwrap'   => TRUE,
        'newline'   => "\r\n",
        'validation'   => TRUE
    );
		  $this->email->initialize($config);
		}

	


	public function get_Vehicle($id)
	{
		
		
		$this->db->where('id',$id);
		$get_results = $this->db->get('vehicles_details')->row_array();
		
		
		return $get_results;
	}

	public function get_Vehicle_Cat($id)
	{
		
		
		$this->db->where('id',$id);
		$get_results = $this->db->get('vehicle_categories')->row_array();
		
		
		return $get_results;
	}

		

	public function get_VehicleAsssets()
	{
		
		
$this->db->select('type, brand, exterior_color,interior_color');
$this->db->group_by(array("type", "brand","exterior_color","interior_color")); 
$query = $this->db->get('vehicles_details');
		$mail_alldetails['num_rows']=$query->num_rows;
			if($query->num_rows>0){
			$mail_alldetails['results']=$query->result_array();
			}

			return $mail_alldetails;
		
		
	}
	public function get_allVehicles()
	{

			$mail_alldetails=array();
			$get_results = $this->db->get('vehicles_details');
			$mail_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
			$mail_alldetails['results']=$get_results->result_array();
			}

			return $mail_alldetails;

	}	

	public function get_allVehicles_Cat()
	{

			$mail_alldetails=array();
			$get_results = $this->db->get('vehicle_categories');
			$mail_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
			$mail_alldetails['results']=$get_results->result_array();
			}

			return $mail_alldetails;

	}

	public function get_allImages($id)
	{
		$this->db->where('vehicle_id',$id);
	    $get_results=$this->db->get('vehicles_images');
	    return $get_results->result_array();

    }
	

	public function	update_mails($post_data,$edit_id){
			
			$this->db->where('mail_id',$edit_id);
			$this->db->update(MAIL_TEMPLATE,$post_data);

			}
			


	
}
