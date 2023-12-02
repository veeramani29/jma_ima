<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cabs_Model extends CI_Model  {

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

	


	public function get_Cab($id)
	{
		
		$get_results = $this->db->query("SELECT C.*,V.*,D.*,C.id as cab_id,C.notes as cab_notes FROM cabs_details C ,vehicles_details V,drivers_details D where C.id='$id' and C.driver=D.id and C.vehicle=V.id");
		#$this->db->where('id',$id);
		$get_results = $get_results->row_array();
		
		
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


		public function get_allDrivers()
	{

			$mail_alldetails=array();
			$this->db->select('first_name,id');
			$get_results = $this->db->get('drivers_details');
			$mail_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
			$mail_alldetails['results']=$get_results->result_array();
			}

			return $mail_alldetails;

	}

	public function get_allVehicles()
	{

			$mail_alldetails=array();

$this->db->select('Vnumber,id');
#$this->db->group_by(array("type", "brand","exterior_color","interior_color")); 
$get_results = $this->db->get('vehicles_details');

	
			$mail_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
			$mail_alldetails['results']=$get_results->result_array();
			}

			return $mail_alldetails;

	}	

	public function get_allCabs()
	{

			$mail_alldetails=array();

				$get_results = $this->db->query("SELECT C.*,V.*,D.*,C.id as cab_id,C.notes as cab_notes FROM cabs_details C ,vehicles_details V,drivers_details D where C.driver=D.id and C.vehicle=V.id");

			#$get_results = $this->db->get('cabs_details');
			$mail_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
			$mail_alldetails['results']=$get_results->result_array();
			}

			return $mail_alldetails;

	}	


	

	public function	update_mails($post_data,$edit_id){
			
			$this->db->where('mail_id',$edit_id);
			$this->db->update(MAIL_TEMPLATE,$post_data);

			}
			


	
}
