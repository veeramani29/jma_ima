<?php
namespace App\Lib;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Mailgun\Mailgun;
use Config;
class MailGunAPI {
	
		  public $Mailgun;
		  public $domain;
		  public  $MailListaddress; 

		  public function __construct()
		  {


define("MailGunAPI", Config::read('MailGunConfig.'.app()->environment().'.MailGunAPI'));
define("MailGunDomain", Config::read('MailGunConfig.'.app()->environment().'.MailGunDomain'));
define("FromInfoMail", Config::read('MailGunConfig.'.app()->environment().'.FromInfoMail'));
define("JmaDevTeam", Config::read('MailGunConfig.'.app()->environment().'.JmaDevTeam'));
define("MailGunListAddress", Config::read('MailGunConfig.'.app()->environment().'.MailGunListAddress'));
			 $this->Mailgun = new Mailgun(MailGunAPI);
			
			 $this->domain = MailGunDomain;
			 $this->MailListaddress = MailGunListAddress;
		  }
		  
		  public function addNewUserMailGunListingAddress($addrss,$name)
		  {


			try {

				$result =  $this->Mailgun->post("lists/$this->MailListaddress/members", array(
				'address'     => $addrss,
				'name'        => $name,
				'subscribed'  => true,
				'upsert'	  => 'yes'
				));
				
				}catch (Exception $e) { 
				return true;
	
				
		  }
		}
}
?>
