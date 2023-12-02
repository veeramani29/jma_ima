@extends('templates.default')
@section('content')
<div class="col-xs-12 col-md-10">

<?php 
if(Session::has('PaypalError')){
	$PaypalError=Session::get('PaypalError');
}

?>
  <div class="main-title">
    <h1>Payment <?php echo (Session::has('PaypalError'))?"Errors":"Cancelled";?></h1>
    <div class="mttl-line"></div>
  </div>
 <?php if(Session::has('PaypalError')){ 
 	if(!empty($PaypalError)){
 		foreach ($PaypalError as $key => $error) {
 			if(!is_array($error)){
 			  if (strpos($key, 'MESSAGE') !== false) {
 			  	echo "<p class='text-danger'>".$error."</p>";
 			  }
 			}else{
 				foreach ($error as $key_ => $error_) {
 					if(!is_array($error_)){
 			  if (strpos($key_, 'MESSAGE') !== false) {
 			  	echo "<p class='text-danger'>".$key_."</p>";
 			  }
 			}
 				}
 			}
 		}
 	}
 }else{ ?>


 						 <p>
        				Hi, <strong><?php echo (Session::has('temp_user.email') && Session::get('temp_user.email')!=null)?Session::get('temp_user.email'):Session::get('user.email');?></strong>, <br>Your payment has been cancelled.<br><br>
	           		  </p>

<?php } ?>
  
</div>
@stop