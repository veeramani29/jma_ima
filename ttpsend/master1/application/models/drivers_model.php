<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drivers_Model extends CI_Model  {

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

	


	public function get_Driver($id)
	{
		
		
		$this->db->where('id',$id);
		$get_results = $this->db->get('drivers_details')->row_array();
		
		
		return $get_results;
	}

	
	public function get_allDrivers()
	{

			$mail_alldetails=array();
			$get_results = $this->db->get('drivers_details');
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
