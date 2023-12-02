<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model  {

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

		

public function send_discount_mail($get_all_discounts,$post_data)
{	


$Userlist=json_decode($post_data['send_user_list']);
$mail_results=$this->get_mail_templates(2);
$template_msg=$mail_results['mail_content'];

foreach ($Userlist as $to_user) {
$find_strarray=array('##WEB_MAIN_URL##','##LOGO##','##EMAIL##','##MESSAGE##','##SITE_NAME##','##CODE##','##PRODUCT_NAME##','##SUB_NAME##','##END_DATE##','##SEND_DATE##');
$replace_strarray=array(HOST,LOGO,$to_user,$post_data['send_msg'],PROJECT_NAME,$get_all_discounts['discount_code'],(($get_all_discounts['product_id']==1)?'Yugamiru':'Yugamiru-Pro'),
$get_all_discounts['subscription_id'],$get_all_discounts['end_date'],$post_data['send_on']);

$message=str_replace($find_strarray, $replace_strarray, $template_msg);	
$this->email->set_newline("\r\n");
$this->email->from('29veeramani@gmail.com', PROJECT_NAME);
$this->email->to($to_user); 
$this->email->subject($post_data['send_subject']);
$this->email->message($message);	
$this->email->send();

//echo $this->email->print_debugger();die;
}


return true;
}



public function send_contact_mail($post_data)
{	


$Userlist=json_decode($post_data['send_user_list']);
$mail_results=$this->get_mail_templates(3);
$template_msg=$mail_results['mail_content'];

foreach ($Userlist as $to_user) {
$find_strarray=array('##WEB_MAIN_URL##','##LOGO##','##EMAIL##','##MESSAGE##','##SITE_NAME##','##SEND_DATE##');
$replace_strarray=array(HOST,LOGO,$to_user,$post_data['send_msg'],PROJECT_NAME,$post_data['send_on']);

 $message=str_replace($find_strarray, $replace_strarray, $template_msg);
$this->email->set_newline("\r\n");
$this->email->from('29veeramani@gmail.com', PROJECT_NAME);
$this->email->to($to_user); 
$this->email->subject($post_data['send_subject']);
$this->email->message($message);	

if($post_data['send_subject']!=null){
$this->email->attach($post_data['send_subject']);
}

$this->email->send();


//echo $this->email->print_debugger();die;
}


return true;
}




public function send_forgot_pswd_mail($post_data)
{	



		$mail_results=$this->get_mail_templates(1);
		$template_msg=$mail_results['mail_content'];
		$this->db->where($post_data);
		$this->db->where('user_status','Active');
		$get_results = $this->db->get(ADMIN)->row_array();
		//debug($get_results,1);
		$msg='This details are helpful for you please click <a href="'.HOST.'"/>here</a> to login';
		$find_strarray=array('##WEB_MAIN_URL##','##LOGO##','##EMAIL##','##MESSAGE##','##SITE_NAME##','##USER_NAME##','##PASSWORD##','##SEND_DATE##');
		$replace_strarray=array(HOST,LOGO,$post_data['user_email'],$msg,PROJECT_NAME,$get_results['username'],$get_results['password'],date('Y-M-d'));

		$message=str_replace($find_strarray, $replace_strarray, $template_msg);
		$this->email->set_newline("\r\n");
		$this->email->from('29veeramani@gmail.com', PROJECT_NAME);
		$this->email->to($post_data['user_email']); 
		$this->email->subject($mail_results['mail_subject']);
		$this->email->message($message);	
		$this->email->send();
		//echo $this->email->print_debugger();die;
		return true;
}


	public function get_mail_templates($mail_id)
	{
		
		
		$this->db->where('mail_id',$mail_id);
		$get_results = $this->db->get(MAIL_TEMPLATE)->row_array();
		
		
		return $get_results;
	}

	
	public function get_allmail_templates()
	{

			$mail_alldetails=array();
			$get_results = $this->db->get(MAIL_TEMPLATE);
			$mail_alldetails['num_rows']=$get_results->num_rows;
			if($get_results->num_rows>0){
			$mail_alldetails['results']=$get_results->result_array();
			}

			return $mail_alldetails;

	}	


	public function get_edit_mails($edit_id)
	{
		
		
		$this->db->where('mail_id',$edit_id);
		$get_results = $this->db->get(MAIL_TEMPLATE)->row_array();
		
		
		return $get_results;
	}	

	public function	update_mails($post_data,$edit_id){
			
			$this->db->where('mail_id',$edit_id);
			$this->db->update(MAIL_TEMPLATE,$post_data);

			}
			


	
}
