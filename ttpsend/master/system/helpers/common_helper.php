<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * getregisteruserdetails - 
 *
 * @access	public
 * @param	none
 * @return	html string
 */
if (!function_exists('getregisteruserdetails')) {
function getregisteruserdetails($reg_user_id) {

    $obj = & get_instance();
    $obj->load->model('Register_Model');
    $session_data = $obj->session->userdata('Session_val');
    
	$result= $obj->Register_Model->getreguserdetails($reg_user_id);
   if($result) {
      return $result;
   } else {
        $result = '';
		return $result;
   }
}

function getsubscriptionemail_cnt($email) {

    $obj = & get_instance();
    $obj->load->model('Usersub_Model');
  
    
	$result= $obj->Usersub_Model->check_emailunique_id($email);
   return $result;
}

function getpricedetails($subscription_id,$product_id) {

    $obj = & get_instance();
    $obj->load->model('Register_Model');
  
    
	$result= $obj->Register_Model->pricedetails($product_id,$subscription_id);
if($result){
   return $result;
}
}

function getdiscountcode_amt($product_id,$subscription_id){
	 $obj = & get_instance();
    $obj->load->model('Register_Model');
		$result= $obj->Register_Model->getdiscountamt($product_id,$subscription_id);
	if($result){
	if($result['discount_code']!=''){
	return $result['discount_code'];
	}else{
		return 0;
	}
	}
}

function getactualamtaftrdiscnt($amt,$disc){
	$discamt=(int)($amt*$disc)/100;
	$act_amt=(int)($amt-$discamt);
	return $act_amt;
}

function getusersubscriptiondetails($sub_id){
	 $obj = & get_instance();
    $obj->load->model('Usersub_Model');
  
    
	$result= $obj->Usersub_Model->get_edit_subscriptions($sub_id);
if($result){
   return $result;
}
		
}

function getsubscriptiondetails($subscription_id){
	 $obj = & get_instance();
    $obj->load->model('Usersub_Model');
  
    
	$result= $obj->Usersub_Model->get_subscriptionduration($subscription_id);
if($result){
   return $result;
}
		
}

//myaccount page
function getbilldetails($reg_user_id){
	 $obj = & get_instance();
    $obj->load->model('Usersub_Model');
  
    
	$result= $obj->Usersub_Model->getallbilldetails($reg_user_id);
if($result){
   return $result;
}
		
}

function getsubscriptiontitle($duration,$product_id){
	
	if($product_id==1){
		if($duration==90){
			
		$title="Yugamiru 3 month Subscription";	
		}else if($duration==180){
				$title="Yugamiru 6 month Subscription";
		}else if($duration==365){
				$title="Yugamiru 1 year Subscription";
		}else if($duration==730){
				$title="Yugamiru 2 year Subscription";
		}else if($duration==1825){
				$title="Yugamiru Permanent Subscription";
		}else{
			$title="YugamiruSubscription";	
		}
		return $title;
		
	}else if($product_id==2){
			if($duration==90){
			
		$title="Yugamiru Pro 3 month Subscription";	
		}else if($duration==180){
				$title="Yugamiru Pro 6 month Subscription";
		}else if($duration==365){
				$title="Yugamiru Pro 1 year Subscription";
		}else if($duration==730){
				$title="Yugamiru Pro 2 year Subscription";
		}else if($duration==1825){
				$title="Yugamiru Pro Permanent Subscription";
		}else{
			$title="Yugamiru Pro Subscription";	
		}
		return $title;
	}
	
}

 function getmultidiscount($num_license) {
  if($num_license >=2 && $num_license<=5){
	  $discount=10;
  }else if($num_license >=6 && $num_license<=10){
	   $discount=20;
  }else if($num_license >=10 && $num_license<=20){
	   $discount=30;
  }
  return $discount;
}




    function getrandom_password($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
	



}
?>
