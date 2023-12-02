<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/** Sql to be executed before running script
 * 
 * UPDATE user_accounts SET password; 
 */ 


require 'script_class.php';
class AddUsersToMailGunList extends Script {
	
	public $classes = array('alanee_classes/common/alaneecommon_class.php');

		public $Mailgun;

		function __construct( ) {
		$this->Mailgun = new Mailgun\Mailgun('key-f6bbbb9ec22d27fcb7cdff6d9c326a2b');;
		}



	
	
	public function Run() {
		$out = '';
		try {
			//$user = new User();
			
			
			
			/*
			$mgClient = new Mailgun\Mailgun('key-9ff03593f82696cfa7a5e253e6bb8cb8');
			$domain = "mg.japanmacroadvisors.net";
			$result = $mgClient->sendMessage($domain, array(
					'from'    => 'info@mg.japanmacroadvisors.net',
					'to'      => 'shijo.thomas@indiamacroadvisors.com',
					'subject' => 'Hello',
					'text'    => 'Testing some Mailgun awesomness!'
			));
			*/
$domain = "sandboxca579abed711410280120a5a6d11b72e.mailgun.org";
//https://documentation.mailgun.com/api-mailinglists.html#examples
#http://blog.mailgun.com/turnkey-mailing-list-applet-using-the-mailgun-php-sdk/




$mgClient = new Mailgun\Mailgun('key-f6bbbb9ec22d27fcb7cdff6d9c326a2b');
$result = $mgClient->sendMessage("$domain",
                  array('from'    => 'Mailgun Sandbox <postmaster@sandboxca579abed711410280120a5a6d11b72e.mailgun.org>',
                        'to'      => 'veera <veeramani.kamaraj@indiamacroadvisors.com>',
                        'subject' => 'Hey %recipient_email%',
                          'o:tracking' => true,
    'text'    => 'If you wish to unsubscribe,
                          click http://mailgun/unsubscribe/%recipient.id%'
                     
				));


			
		echo "*****************  - START"."<br><br>";
		$result = $mgClient->get("$domain/log");
 print_r($result);die;
		
		} catch (Exception $ex){
			
		}
		echo "*****************  - END"."<br><br>";
	}
	



 public function memberBulkAdd($list='',$json_str='') {  

 /*	$json_upload ='['  
 foreach ($addresses as $i) {
  $json_upload.='{';
    $json_upload.='"name": "'.$i->name.'", ';                  
    $json_upload.='"address": "'.$i->address.'"';                  
    $json_upload.='},';            
  }
$json_upload.=']';*/

     $result = $this->Mailgun->post("lists/".$list.'/members.json',array(
    'members' => $json_str,
     'subscribed' => true,
     'upsert' => 'yes'
     ));
     return $result->http_response_body;    
   }


public function DeleteMailList($listAddress) {
	try {
$result = $this->Mailgun->delete("lists/$listAddress");
return $result->http_response_body;
}catch (Exception $e) { 
	echo $e->getMessage();
		}
}


public function DeleteMailListsMember($listAddress,$listMember) {
	try {
$result = $this->Mailgun->delete("lists/$listAddress/members/$listMember");
return $result->http_response_body;
}catch (Exception $e) { 
	echo $e->getMessage();
		}
}


public function fetchMailLists() {
	try {
$result = $this->Mailgun->get("lists");
return $result->http_response_body;
}catch (Exception $e) { 
	echo $e->getMessage();
		}
}

public function send_message($to='',$subject='',$body='',$from='') {  



if ($from!='') 
  $from="test";
$domain = "test";
$result = $this->Mailgun->sendMessage($domain,array('from' => $from, 'to' => $to, 'subject' => $subject, 'text' => $body, )); 
return $result->http_response_body;  
}

	public function fetchMailListMembers($MailListaddress) {
			try {
	$result = $this->Mailgun->get("lists/$MailListaddress/members");
	print_r($result);die;
	}catch (Exception $e) { 
	echo $e->getMessage();
		}
	}

	public function AddMailListMembers($MailListaddress) {
try {
$result =  $this->Mailgun->post("lists/$MailListaddress/members", array(
'address'     => 'veera@example.com',
'name'        => 'Bob Bar',
'description' => 'Developer',
'subscribed'  => true,
'vars'        => '{"age": 26}'
));
print_r($result);die;
} catch (Exception $e) { 
	echo $e->getMessage();
}

	

	}

	

	public function MailListCreate() {  
		try {
    $result = $this->Mailgun->post("lists",array('address'=>'jma@sandboxca579abed711410280120a5a6d11b72e.mailgun.org','name'=>'name','description' => 'test','access_level' => 'everyone'));
    return $result->http_response_body;  
      } catch (Exception $e) { 
	echo $e->getMessage();
}
  }

    public function MailListUpdate($existing_address,$model) {  
    		try {
    $result = $this->Mailgun->put("lists/".$existing_address,array(
      'address'=>$model->address,
      'name' => $model->name,
      'description' => $model->description,
      'access_level' => $model->access_level
      ));
    return $result->http_response_body; 
    } catch (Exception $e) { 
	echo $e->getMessage();
}   
   }

}
$obj = new AddUsersToMailGunList();
$obj->Run();
//$obj->fetchMailListMembers('postmaster@sandboxca579abed711410280120a5a6d11b72e.mailgun.org');
//







?>