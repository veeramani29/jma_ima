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

if($this->resultSet['status']!=1) {

    $signup_error_id = $this->resultSet['result']['signup_error_id'];
    $user_position = $this->resultSet['result']['postdata']['user_position'];
    $user_industry = $this->resultSet['result']['postdata']['user_industry'];
    $user_title = $this->resultSet['result']['postdata']['user_title'];
    $OtherTitle = $this->resultSet['result']['postdata']['OtherTitle'];
    $fname = $this->resultSet['result']['postdata']['fname'];
    $lname = $this->resultSet['result']['postdata']['lname'];
    $email = $this->resultSet['result']['postdata']['email'];
    $country_id = $this->resultSet['result']['postdata']['country_id'];
    $phone = $this->resultSet['result']['postdata']['phone'];
    $phone_code = $this->resultSet['result']['postdata']['phone_code'];
    $country_code = $this->resultSet['result']['postdata']['country_code'];
    
     $product = $this->resultSet['result']['postdata']['product'];
}

if(isset($_REQUEST['pre_info']) || isset($_REQUEST['co_info'])){
if(isset($this->resultSet['result']['request_info'])){

    $carp=$this->resultSet['result']['request_info']['corporate'];
    $premium=$this->resultSet['result']['request_info']['premium'];
    
    $product=(($carp==1)?'corporate':(($premium==1)?'premium':'free'));

}
}
if(isset($_SESSION['signup_ts']))
{
    $signup_ts  = $_SESSION['signup_ts'];
}
if(empty($signup_ts))
{
    $signup_ts  = time();
    $_SESSION['signup_ts'] = $signup_ts;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>India Macro Advisors | Offering New Product</title>

<!-- Mobile Devices Viewport Resset-->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- <meta name="viewport" content="initial-scale=1.0, user-scalable=1" /> -->
<link rel="shortcut icon" href="../favicon.ico" type="image/icon">
<link rel="icon" href="../favicon.ico" type="image/icon">


<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->

<link rel='stylesheet'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A400%2C300%2C400italic%2C700&#038;ver=4.5.3' type='text/css' media='all' />
<link rel='stylesheet'  href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css' type='text/css' media='all' />
<link rel='stylesheet'  href='<?php  echo $this->css."product/css/fullpage.css";?>' type='text/css' media='all' />
<!--<link rel='stylesheet'  href='css/prettyPhoto.css' type='text/css' media='all' />-->
<link rel='stylesheet'   href='<?php  echo $this->css."product/css/style.css";?>' type='text/css' media='all' />

<!--[if lte IE 8]>
<link rel='stylesheet' id='pexeto-ie8-css'  href='css/style_ie8.css?ver=1.8.2' type='text/css' media='all' />
<![endif]-->
<script type='text/javascript' src='<?php  echo $this->css."product/js/jquery.js";?>'></script>
<script type="text/javascript" src="<?php echo $this->javascript."intlTelInput.min.js";?>"></script>
<link rel="stylesheet" href="<?php echo $this->css."intlTelInput.css";?>" />
<script type="text/javascript" src="<?php echo $this->javascript."jquery.validate.js";?>"></script>

</head>

<body class="home page page-id-7 page-template page-template-template-fullscreen-slider page-template-template-fullscreen-slider-php fixed-header no-slider icons-style-light parallax-header">
<div id="main-container" >
	<div  class="page-wrapper" >
		<!--HEADER -->
				<div class="header-wrapper" >

				<header id="header">
			<div class="section-boxed section-header">
						<div id="logo-container">
				<a href="#1"><img src="<?php  echo $this->css."product/img/";?>logo.png" alt="JMA Landing" /></a>
			</div>	

			
			<div class="mobile-nav">
				<span class="mob-nav-btn">Menu</span>
			</div>
	 		<nav class="navigation-container">
				<div id="menu" class="nav-menu">
				<ul id="menu-main-menu" class="menu-ul"><li id="menu-item-206" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-206"><a  href="#1">Home</a></li>
<li id="menu-item-201" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-7 current_page_item menu-item-201"><a  href="#1">Product</a></li>
<li id="menu-item-202" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-202"><a  href="#1">About us</a></li>
<li id="menu-item-203" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-203"><a  href="#1">Contact</a></li>
<li id="menu-item-204" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-204"><a  href="#1">Our Privacy Policy</a></li>
<li id="menu-item-205" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-205"><a  href="#1">Commercial Policy</a></li>
</ul>				</div>
				
				<div class="header-buttons">
								</div>
			</nav>

				
			<div class="clear"></div>       
			<div id="navigation-line"></div>
		</div>
		</header><!-- end #header -->


</div>

<div id="content-container" class=" layout-full">

<div id="full-width" class="content">

<div class="fullpage-wrapper loading">

<div class="section section-text layout-ct" style="background-image:url(<?php  echo $this->css."product/img/";?>hand-drawn_bg.jpg);background-color:#17C5CC;background-position:center center;">
    <div class="section-content anim-el">
        <h2 class="section-title" style="color:#ffffff;font-size:60px;">India focused <br>macroeconomic data solution</h2>
        <div class="section-desc" style="color:#ffffff;font-size:28px;">
            <p>Tailored to the need of all professionals<br />
            tasked with analyzing the Indian Economy.</p>
        </div>
    <a  style="background-color:#F15525;" href="#2" class="button">Read More</a></div>
    <span class="fullpage-scroll-arrow icon-arrow-down-2"></span>
</div>

<div class="section section-textimg layout-left" style="background-color:#17C5CC;background-position:center center;">
    <div class="section-wrapper">
        <div class="section-img anim-el">
            <img src="http://wordpress-16826-36655-131868.cloudwaysapps.com/wp-content/uploads/2015/01/185039-earth-globe-streamline-copy.png" alt=""/>
        </div>
        <div class="section-content anim-el">
            <h2 class="section-title" style="color:#ffffff;font-size:50px;">Macroeconomic data<br> from primary sources</h2>
            <div class="section-desc" style="color:#ffffff;font-size:30px;">
                <p>timely and accurately updated </p>
            </div>
        </div>
    </div>
</div>

<div class="section section-textimg layout-left" style="background-color:#242D3C;background-position:center center;">
    <div class="section-wrapper">
        <div class="section-img anim-el"><img src="<?php  echo $this->css."product/img/";?>report.png" alt=""/></div>
            <div class="section-content anim-el">
                <h2 class="section-title" style="color:#ffffff;font-size:48px;">Timely and concise analysis </h2>
                <div class="section-desc" style="color:#ffffff;font-size:30px;">
                <p>helps you make better decision.</p>
            </div>
        </div>
    </div>
</div>

<div class="section section-textimg layout-left" style="background-color:#17C5CC;background-position:center center;">
    <div class="section-wrapper">
        <div class="section-img anim-el"><img src="<?php  echo $this->css."product/img/";?>desktop_01.png" alt=""/></div>
            <div class="section-content anim-el">
                <h2 class="section-title" style="color:#ffffff;font-size:50px;">Interactive JMA Chart tools</h2>
                <div class="section-desc" style="color:#ffffff;font-size:30px;">
                <p> helps you visualize data and instantly produce presentation materials.</p>
            </div>
        </div>
    </div>
</div>

<div class="section section-textimg layout-right" style="background-color:#242D3C;background-position:center center;">
    <div class="section-wrapper">
        <div class="section-img anim-el"><img src="http://wordpress-16826-36655-131868.cloudwaysapps.com/wp-content/uploads/2015/01/185027-computer-network-streamline-copy.png" alt=""/></div>
            <div class="section-content anim-el">
                <h2 class="section-title" style="color:#ffffff;font-size:50px;">My Chart</h2>
                <div class="section-desc" style="color:#ffffff;font-size:20px;"><p>enabling instant creation of chartbook</p>
            </div>
            <a  style="background-color:#F15525;" target="_blank" href="<?php echo $this->url('/');?>" class="button">Try Free</a>
        </div>
    </div>
</div>

<!--
<div class="section section-textimg layout-right">
    <div class="section-wrapper">
        <div class="section-content anim-el">
            <h2 class="section-title">Premiun Report</h2>
            <div class="section-desc">
                <p>Unrestricted access to <strong>Premium Reports</strong> catering to financial investors.</p>
                <p>3. Access to our <strong>proprietary data</strong> such as JGB duration data.</p>
            </div>
        </div>
    </div>
</div>
-->

<div class="section section-textimg layout-bottom" style="background-color:#17C5CC;">
    <div class="section-wrapper">
        <div class="section-content anim-el">
            <h2 class="section-title">Register 30days Free Trial</h2>
        </div>
        <div class="section-img anim-el">
          <div class="price-table-wrapper">
                
                <div class="cols-wrapper cols-3">
                <div class="col pt-col pt-non-highlight">
                	<div class="pt-title" >Free</div>
                    <div class="pt-price-box pt-position-left"><span class="pt-cur"></span><span class="pt-price">FREE</span><span class="pt-period">per month</span></div>
                    <ul class="pt-features">
                        <li>Our economic analysis</li>
                        <li>Data and charts functions</li>
                        <li>Limited functionality of My Charts</li>
                    </ul>
                	<div class="pt-button"><a class="button" href="#8"  >Register NOW</a></div>
                </div>
                
                <div class="col pt-col pt-highlight">
                    <div class="pt-title" >Premium</div>
                    <div class="pt-price-box pt-position-left"><span class="pt-cur">JPY</span><span class="pt-price">3500</span><span class="pt-period">per month</span></div>
                        <ul class="pt-features">
                            <li>Access to our Premium Reports</li>
                            <li>Data download of our proprietary data</li>
                            <li>Full functionality of My Charts</li>
                        </ul>
                    <div class="pt-button"><a class="button" href="#8"  >30 days Free Trial</a></div>
               </div>
               
               <div class="col pt-col pt-non-highlight">
                   <div class="pt-title" >Corporate</div>
                   <div class="pt-price-box pt-position-left"><span class="pt-cur">USD</span><span class="pt-price">800</span><span class="pt-period">per month</span></div>
                   <ul class="pt-features">
                       <li>10 Premium accounts</li>
                       <li>Research consultation</li>
                       <li>Meetings/seminars with our economists</li>
                   </ul>
                   <div class="pt-button"><a class="button" href="#8"  >Request Info</a></div>
               </div>
               
        </div>
            
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<div class="section section-text layout-cc" style="background-image:url(<?php  echo $this->css."product/img/";?>coverphoto.jpg);background-position:center center;">
    <div class="section-content anim-el">
        <h2 class="section-title" style="color:#ffffff;font-family:&#039;Open Sans&#039;;font-size:50px;">Our solution helps you<br> increase workflow efficiencies </h2>
        <div class="section-desc" style="color:#ffffff;font-family:&#039;Open Sans&#039;;font-size:35px;"><p>and adopt your decisions to<br />
        ever changing economic environment</p>
        </div>
        <a  style="background-color:#F15525;" href="#8" class="button">Register NOW</a>
    </div>
</div>


<div class="section section-textimg layout-bottom ">
    <div class="section-wrapper">
        <div class="section-content anim-el">
            <h2 class="section-title" style="color:#ffffff;font-family:&#039;Open Sans&#039;;font-size:40px;">Sign Up</h2>
            <div class="section-desc" style="color:#ffffff;font-family:&#039;Open Sans&#039;;font-size:20px;">
               
<form class="signup_frm" name="signup_frm" id="signup_frm" action="<?php echo $this->url('user/completeregistration');?>" method="post" autocomplete="off" novalidate="novalidate">
<input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts">
<input type="hidden" value="Offrening" name="pagefrom">

<p>Select Product</p>

<p align="center" class="text-danger"
<?php if($this->resultSet['status']==1) { ?> style="display: none"
<?php } ?>><?php echo $this->resultSet['message']; ?></p>

<div class="cols-3" > 

 
  <div class="col">
    <div class="signup_request_select button <?php echo (!isset($product)) ? 'activepro':'';?><?php echo (isset($product) && $product =='free') ? 'activepro':'';?>">
    <i class="fa fa-user fa-lg" style=""></i>
    <b>Free</b>
    <input type="checkbox" class="signup_product" name="product" <?php echo (isset($product) && $product =='free') ? 'checked': '';?> <?php echo (!isset($product)) ? 'checked': '';?> value="free">
    <i class="fa fa-check" <?php echo (!isset($product)) ? 'style="display:inline-block"': '';?> <?php echo (isset($product) && $product =='free') =='free' ? 'style="display:inline-block"': '';?>></i>
    </div>
        </div>
   
     <div class="col">
<div class="signup_request_select button <?php echo (isset($product) && $product =='premium') ? 'activepro': '';?>">
<i class="fa fa-user fa-lg" style=""></i>
<sup><i style="" class="fa fa-star fa-fw"></i></sup>
<b>Premium</b>
<input type="checkbox" class="signup_product" <?php echo (isset($product) && $product =='premium') ? 'checked': '';?> name="product" value="premium"> 
<i class="fa fa-check" <?php echo (isset($product) && $product =='premium') ? 'style="display:inline-block"': '';?>></i>
</div>
</div>

     <div class="col">
<div class="signup_request_select button <?php echo (isset($product) && $product =='corporate') ? 'activepro': '';?>">
<i class="fa fa-building fa-lg" style=""></i>
<b>Corporate</b>
<input type="checkbox" <?php echo (isset($product) && $product =='corporate') ? 'checked': '';?> class="signup_product" name="product" value="corporate">
<i class="fa fa-check" <?php echo (isset($product) && $product =='corporate') ? 'style="display:inline-block"': '';?>></i>

</div>
    </div>

    </div>


  <div class="cols-1" >
  <div class="col" >
<a class="reg_linkedin"  href="//localhost/jma/indiamacroadvisors.com/user/linkedinProcess/free">
<img alt="Linkedin Signup" src="//localhost/jma/indiamacroadvisors.com/images/linkedin_signup.png"></a>
<p>OR</p>
</div> 

</div> 
 



  
              <div class="cols-1">
<div class="col">
             <select class="" name="user_title" id="user_title_id">
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

  




 <div class="cols-1" id="other" style="display: none;">
<div class="col">
 <input type="text" class="form-control" placeholder="Other Title " name="OtherTitle" id="reg_user_title" value="<?php echo $OtherTitle; ?>">
      </div>
       
            </div>



   
        
            
             <div class="cols-2">
            <div class="col">
            <input type="text" placeholder="Given name *" class="form-control" name="fname" id="reg_first_name" value="<?php echo $fname; ?>" data-rule-required="true" data-msg-required="Please enter given name" />
            </div>
             
            <div class="col">
             <input type="text" class="form-control" placeholder="Surname *" name="lname" id="reg_last_name" value="<?php echo $lname; ?>"  data-rule-required="true" data-msg-required="Please enter Surname"/>
              </div>
             </div>
          

         

   


    
           <div class="cols-1">
            <div class="col">  
           <input class="form-control"  type="text" placeholder="Email  *" name="email" id="reg_email" value="<?php echo $email; ?>" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address">
            </div>
 </div>



   
   
    <div class="cols-1">
            <div class="col">
           <select data-rule-required="true" class="required" name="country_id" id="country_id">
           <option value="">Country  *</option>
           
                        
            <?php
            $res = $this->resultSet['result']['country_list'];
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
  


    <div class="cols-1">
            <div class="col">
         <select class="" name="user_industry" id="user_industry">
         <option value="0">Sector (pick one)</option>
            
                      <?php
            $res = $this->resultSet['result']['user_industry'];
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
  


  
       <div class="cols-1">
            <div class="col">

        <select class="" name="user_position" id="user_position">
          <option value="0">Job function (pick one)</option>
            <?php
            $res = $this->resultSet['result']['user_position'];
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

    

  <div class="cols-1">
            <div class="col">

   
    <div class="form-control" style="padding: 6px 9px;">
     <input type="hidden"   value="<?php echo ($country_code!='')?$country_code:'+81';?>" name="country_code"   id="country_code"   />
    
       <input type="text" class="phonecls "  placeholder="Phone number" value="<?php echo $phone;?>" name="phone"  data-rule-number="true" data-rule-minlength="6" id="reg_phone_number"   />
            </div>
    </div>
</div>





    



    
      <div class="cols-1">
            <div class="col">
<p style="text-align: left;font-size: 14px;">Premium and Corporate subscriptions are our fee based service. For further information please see our <a target="_blank" href="<?php echo $this->url('products');?>">products</a> </p>
  </div>
     </div>
 

    

    
   
      <div class="cols-1">
            <div class="col">
<p style="text-align: left;font-size: 14px;"><small style="color:red;">*</small> Required fields</p>
  </div>
 </div>





   
  <div class="cols-1">
            <div class="col">
    <button type="submit" style="text-align: right;" name="signup_btn" class="btn btn-primary"><i class="fa fa-angle-double-right"></i> Continue</button>

     </div>
  </div>


</form>
            </div>
        </div>
    </div>
</div>




<div class="fullpage-data"><ul class="fullpage-nav"></ul></div>

</div>

</div> <!-- end main content holder (#content/#full-width) -->

<div class="clear"></div>

</div> <!-- end #content-container -->

</div>
</div> <!-- end #main-container -->


<!-- FOOTER ENDS -->

<script type='text/javascript' src='<?php  echo $this->css."product/js/main.js";?>'></script>
<script type='text/javascript' src='<?php  echo $this->css."product/js/fullpage.js";?>'></script>
<script type="text/javascript">var PEXETO = PEXETO || {};jQuery(document).ready(function($){PEXETO.init.initSite();new PEXETO.Fullpage(".section", {"animateElements":true,"autoplay":false,"autoplayInterval":5000,"horizontalAutoplay":false}).init();});</script>


<script type="text/javascript">

 
var $=jQuery;
$(function() { 

$('#signup_frm')
        .find('[name="phone"]')
            .intlTelInput({
                utilsScript: '<?php echo $this->javascript."intlTelInput.min.js";?>',
                autoPlaceholder: true,

                preferredCountries: ['jp', 'us', 'in']
            });


$('div.selected-flag').attr("tabindex",-1);
//$('div.intl-tel-input .selected-flag').removeAttr("tabindex");
$('ul.country-list li.country').on('click', function() {

    var option1 = $(this).data('dial-code');

     $('#country_code').val("+"+option1);

     });



$('#country_id').on('change', function() {

    var option = $('option:selected', this).attr('code').toLowerCase();
    
    var country_code = $('ul.country-list li.country.active').data('country-code');
    var country_name = $('ul.country-list li.country.active span.country-name').text();
    var dial_code = $('ul.country-list li.country.active').data('dial-code');
    $('div.selected-flag div.iti-flag').removeClass(country_code).addClass(option);
    $('ul.country-list li.country').removeClass('highlight');
    $('ul.country-list li.country').removeClass('active');
    $('ul.country-list li.country[data-country-code="'+option+'"]').addClass('highlight active');
    var sel_country_name =$('ul.country-list li.country[data-country-code="'+option+'"] span.country-name').text();
    var sel_dial_code =$('ul.country-list li.country[data-country-code="'+option+'"]').data('dial-code');
    $('div.selected-flag').attr("title",(sel_country_name+': '+"+"+sel_dial_code));
         
      
          $('#country_code').val("+"+sel_dial_code);
          
       
      });


$('.signup_request_select').on('click',function(event){
    var jqO = $(this);
    
    var target = $(event.target);
    $('.signup_request_select').removeClass( "activepro" );
jqO.addClass('activepro');
$('.signup_request_select').find('.signup_product').prop('checked',false);
$('.signup_request_select').find('i.fa-check').hide();
jqO.find('.signup_product').prop('checked',true);
var sub_type=jqO.find('.signup_product').prop('checked',true).val();
var theHref = $('a.reg_linkedin').attr("href");
var last = theHref.substring(theHref.lastIndexOf("/") + 1, theHref.length);
$('a.reg_linkedin').attr("href", (theHref.replace(last,sub_type)));
jqO.find('i.fa-check').show();

    

});



$('.signup_product').on('click',function(event){

    $('.signup_product').parent('div').removeClass( "activepro" );
    $('.signup_product').prop('checked',false);
    $(this).parent('div').addClass('activepro');
    $(this).prop('checked',true);

    

});

    
        if ($('#user_title_id').val() == "Other") {
         $("#other").show();
      }else{$("#other").hide();}

    $('#user_title_id').change(function(){
       if ($(this).val() == "Other") {
          // alert("1");
       $("#other").show();
      }else if ($(this).val() != "Other") {
         // alert("2");
       $("#other").hide();
      }
   
    });

   
        $("#signup_frm").validate({
            
      submitHandler: function(form) {

         $('.payloder').show();
      $('html, body').animate({scrollTop : 0},800);
        form.submit();
      }
    });
    
    
     
     

    

});
</script>

</body>
</html>

