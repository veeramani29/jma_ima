<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

class MailGun {
	
		  public $Mailgun;
		  public $domain;
		  public  $MailListaddress; 

		  public function __construct()
		  {
			
			 $this->Mailgun = new Mailgun\Mailgun(MailGunAPI);
			 $this->domain = MailGunDomain;
			 $this->MailListaddress = MailGunListAddress;
		  }
		  
		  public function addNewUserMailGunListingAddress($addrss,$name)
		  {





			try {

				$result =  $this->Mailgun->post("lists/$this->MailListaddress/members", array(
				'address'     => $addrss,
				'name'        => $name,
				'subscribed'  => true
				));
				}catch (Exception $e) { 
				return true;
	
				
		  }
		}
}
?>
