@extends('templates.default')
@section('content')
<?php
$user_position = '';
$user_industry = '';
$user_title = '';
$fname = '';
$lname = '';
$email = (isset($_POST['register_email']))?$_POST['register_email']:'';
$country_id = '';
$phone_code = '';
$phone = '';
$country_code='';
$Subscription ='';
$OtherTitle ='';
if(isset($result['status']) && $result['status']!=1) {
  $signup_error_id = $result['signup_error_id'];
  $user_position = $result['postdata']['user_position'];
  $user_industry = $result['postdata']['user_industry'];
  $user_title = $result['postdata']['user_title'];
  $OtherTitle = $result['postdata']['OtherTitle'];
  $fname = $result['postdata']['fname'];
  $lname = $result['postdata']['lname'];
  $email = $result['postdata']['email'];
  $country_id = $result['postdata']['country_id'];
  $phone = $result['postdata']['phone'];
  $product = $result['postdata']['product'];
  $phone_code = isset($result['postdata']['phone_code'])?$result['postdata']['phone_code']:$result['postdata']['country_code'];
  $country_code = $result['postdata']['country_code'];
}
if(isset($_REQUEST['pre_info']) || isset($_REQUEST['co_info'])){
  if(isset($result['request_info'])){
    $carp=$result['request_info']['corporate'];
    $premium=$result['request_info']['premium'];
    $product=(($carp==1)?'corporate':(($premium==1)?'premium':'free'));
  }
}

if(Session::has('signup_ts'))
{
  $signup_ts  = Session::get('signup_ts');
}
if(empty($signup_ts))
{
  $signup_ts  = time();
  Session::put('signup_ts',$signup_ts);

}

?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
  <?php if(isset($result['status']) && $result['status']!=1) { ?>
    var reg_temp_class = $('<?php echo $signup_error_id; ?>').attr('class');
    $('<?php echo $signup_error_id; ?>').focus().css('border', '1px solid #e60013' );
    $('<?php echo $signup_error_id; ?>').after( '<label for="reg_email" class="error"><?php echo isset($result['message'])?$result['message']:''; ?></label>');
    <?php } ?>
    $(".First_name,.Last_name").hide();
  });
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>


<!--Register section starts here-->   
<div class="col-xs-12 col-md-7">
  <div class="main-title">
    <h1>Sign up</h1>
    <div class="mttl-line"></div>
  </div>
  <p <?php if(isset($result['status'])) { ?> style="display: none" <?php } ?> class="text-center text-danger"><?php echo isset($result['message'])?($result['message']):''; ?></p>
  <form class="form-horizontal cmxform signup_frm" name="signup_frm" id="signup_frm"   method="post" autocomplete="off">
    <input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h4>Select Product</h4>
    <ul class="list-inline sinup_selpro">
      <li class="ssp_freuse col-xs-12 col-sm-4">
        <div class="form-group">
          <div class="free_user signup_request_select <?php echo (!isset($product)) ? 'activepro': '';?> <?php echo (isset($product) && $product =='free') ? 'activepro': '';?>" >
            <span class="fa fa-user fa-lg"></span>
           <?php //if(Session::has('lang') && Session::get('lang')=='jp'){echo '無料'; }else{
			   echo 'Free';//}?>
            <input  type="checkbox" class="signup_product pull-right" name="product" <?php echo (isset($product) && $product =='free') ? 'checked': '';?> <?php echo (!isset($product)) ? 'checked': '';?>  value="free" > 
            <span class="fa fa-check pull-right" <?php echo (!isset($product)) ? 'style="display:block"': '';?> <?php echo (isset($product) && $product =='free') =='free' ? 'style="display:block"': '';?>></span>
          </div>
        </div>     
      </li>
      <!--<li class="ssp_preuse col-xs-12 col-sm-4">
        <div class="signup_request_select <?php //echo (isset($product) && $product =='premium') ? 'activepro': '';?> <?php //echo (isset($product) && $product =='premium') ? 'activepro': '';?>" >
          <span class="fa fa-check pull-right" <?php //echo (isset($product) && $product =='premium') ? 'style="display:block"': '';?>  <?php //echo (isset($product) && $product =='premium') ? 'style="display:block"': 'style="display:none;"';?>></span>
          <span>
            <i class="fa fa-user fa-lg" ></i>
            <sup><i class="fa fa-star fa-fw"></i></sup> 
            Standard
          </span>
          <input type="checkbox" class="signup_product pull-right" name="product" value="premium" <?php //echo (isset($product) && $product =='premium') ? 'checked': '';?> <?php //echo (isset($product) && $product =='premium') ? 'checked': '';?>>
        </div>
      </li>
      <li class="ssp_coruse col-xs-12 col-sm-4">
        <div class="signup_request_select   <?php //echo (isset($product) && $product =='corporate') ? 'activepro': '';?>" >
          <span  class="fa fa-building fa-lg"></span>
          Corporate
          <input type="checkbox" <?php //echo (isset($product) && $product =='corporate') ? 'checked': '';?> class="signup_product pull-right" name="product"  value="corporate" ><span class="fa fa-check pull-right" <?php //echo (isset($product) && $product =='corporate') ? 'style="display:block"': 'style="display:none;"';?>></span>
        </div>
      </li>-->
    </ul>  <!-- Row end -->
  <div class="form-group">
	
      <div class="col-xs-12 text-center">
        <a class="text-center reg_linkedin"   title="Linkedin Signup" href="<?php echo rtrim(url('user/linkedinProcess',isset($product)? $product : 'free'),'/');?>"> 
          <img style="height: 42px;" alt="Linkedin Signup" src="<?php echo images_path('linkedin_signup.png');?>" />
        </a>
      </div>
	
    </div>
    <div class="form-group">
      <div class="col-xs-12 sinup_orcon">
        <p>OR</p>
      </div>
    </div> 
    <div class="form-group">
      <div class="col-xs-12">
        <select class="form-control" name="user_title" id="user_title_id">
         <option value="">Title</option>
		 <option value="Mr" <?php echo $user_title == 'Mr' ? 'selected' : ''?>>Mr</option>
         <option value="Mrs" <?php echo $user_title == 'Mrs' ? 'selected' : ''?>>Mrs</option>
         <option value="Miss" <?php echo $user_title == 'Miss' ? 'selected' : ''?>>Miss</option>
         <option value="Ms" <?php echo $user_title == 'Ms' ? 'selected' : ''?>>Ms</option>
         <option value="Dr" <?php echo $user_title == 'Dr' ? 'selected' : ''?>>Dr</option>
         <option value="Prof" <?php echo $user_title == 'Prof' ? 'selected' : ''?>>Prof</option>
         <option value="Sir" <?php echo $user_title == 'Prof' ? 'selected' : ''?>>Sir</option>
         <option value="Other" <?php echo $user_title == 'Other' ? 'selected' : ''?>>Other</option>
       </select>
     </div>
   </div>
   <div class="form-group" id="other">
    <div class="col-xs-12">
      <input type="text" class="form-control" placeholder="Other Title " name="OtherTitle" id="reg_user_title" value="<?php echo $OtherTitle; ?>"  />
    </div>
  </div>
	<div class="col-xs-12 col-md-6">
    <div class="form-group">
      <input type="text" placeholder="Given name *" class="form-control" name="fname" id="reg_first_name" value="<?php echo $fname; ?>" data-rule-required="true" data-msg-required="Please enter given name" onkeypress="return IsCharacter(event);" />
      <label class="First_name" id="First_name" for="First_name">Please fill only english alphabets.</label>
    </div>
  </div>
  <div class="col-xs-12 col-md-6">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Surname *" name="lname" id="reg_last_name" value="<?php echo $lname; ?>"  data-rule-required="true" data-msg-required="Please enter Surname" onkeypress="return IsCharacter(event);"/>
      <label class="Last_name" id="Last_name" for="Last_name">Please fill only english alphabets</label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-12">
     <input type="text" class="form-control emailunique" placeholder="Email  *" name="email" id="reg_email" value="<?php echo $email; ?>"  data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address"/>
   </div>
 </div>
 <div class="form-group">
  <div class="col-xs-12">
    <select data-rule-required="true" class="form-control required" name="country_id" id="country_id" >
      <option value="">Country  *</option>
      <?php
      $res = $result['country_list'];
      for($i=0;$i<count($res);$i++) {
        $selected = '';
        if($country_id == $res[$i]['country_id']){
          $selected = ' selected="selected" ';
        }
        ?>
        <option code="<?php echo $res[$i]['country_code'];?>" value="<?php echo $res[$i]['country_id'];?>"
          <?php echo $selected;?>><?php echo $res[$i]['country_name'];?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-12">
      <select class="form-control" name="user_industry" id="user_industry" >
        <option value="0">Sector (pick one)</option>
        <?php
        $res = $result['user_industry'];
        for($i=0;$i<count($res);$i++) {
          $selected = '';
          if($user_industry == $res[$i]['user_industry_id']){
            $selected = ' selected="selected" ';
          }
          ?>
          <option <?php echo $selected;?> value="<?php echo $res[$i]['user_industry_id'];?>"><?php echo $res[$i]['user_industry_value'];?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-12">
      <select class="form-control" name="user_position" id="user_position" >
        <option value="0">Job function (pick one)</option>
        <?php
        $res = $result['user_position'];
        for($i=0;$i<count($res);$i++) {
          $selected = '';
          if($user_position == $res[$i]['user_position_id']){
            $selected = ' selected="selected" ';
          }
          ?>
          <option <?php echo $selected;?> value="<?php echo $res[$i]['user_position_id'];?>"><?php echo $res[$i]['user_position_value'];?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>
  <!-- data-rule-number="true" placeholder="Phone number"  -->
  <div class="form-group">
    <div class="col-xs-12">
     <input type="hidden"   value="<?php echo ($country_code!='')?$country_code:'+81';?>" name="country_code"   id="country_code"   />
     <input type="text" class="phonecls form-control"  value="<?php echo $phone;?>" name="phone"  data-rule-number="true" data-rule-minlength="6" data-rule-maxlength="12" id="reg_phone_number"  onkeypress='return IsPhoneNumber(event);' />
   </div>
 </div>
 <div class="form-group">
   <div class="col-xs-12">
    <div class="g-recaptcha" data-sitekey="6LfKEjoUAAAAACC-DoITH7IjwWO5EqKhF-NDUd8q"></div>
  </div>
</div>
<div class="form-group">
  <div class="col-xs-12">
	<p>Standard and Corporate subscriptions are our fee based service. For further information please see our <a href="<?php echo url('products');?>">products</a> </p>
  </div>
</div>
<div class="form-group">
  <div class="col-xs-12">
    <p><small class="text-danger" >*</small> Required fields</p>
  </div>
</div>
<div class="form-group">
  <div class="col-xs-12">
    <button type="submit" name="signup_btn" class="btn btn-primary pull-right"> Continue </button>
  </div>
</div>
</form>
</div>
@include('templates.rightside') 
@stop