<?php
if(Session::has('data')){
	$result=Session::get('data.result');
}

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
	  $phone_code = isset($result['postdata']['phone_code'])?$result['postdata']['phone_code']:$result['postdata']['country_code'];

	$country_code = $result['postdata']['country_code'];
	$product = $result['postdata']['product'];
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
	$signup_ts  =Session::get('signup_ts');
}
if(empty($signup_ts))
{
	$signup_ts  = time();
	Session::put('signup_ts',$signup_ts);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo !isset($renderResultSet['pageTitle']) ? 'Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $renderResultSet['pageTitle']; ?> | Offreing New Product</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="shortcut icon" href="<?php echo url('/favicon.ico'); ?>" type="image/icon">
	<link rel="icon" href="<?php echo url('/favicon.ico'); ?>" type="image/icon">

	<?php if(app()->environment()=='development') { ?>
	<link rel='stylesheet'  href="<?php  echo asset("assets/plugins/font-awesome/css/font-awesome.min.css");?>" type='text/css' media='all' />
	<link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/bootstrap/css/bootstrap.min.css");?>">
	<link rel='stylesheet'  href='<?php  echo css_path("jquery.fullPage.css");?>' type='text/css' media='all' />
	<link rel="stylesheet" href="<?php echo css_path("intlTelInput.css");?>" />
	<link rel='stylesheet'   href='<?php echo asset("assets/css/style.css");?>' type='text/css' media='all' />
	<link rel='stylesheet' media='all' href='<?php  echo css_path("media-launch.css");?>' type='text/css' />
	<script type="text/javascript" src="<?php echo js_path("jquery.min.js");?>" ></script>
	<?php }else { ?>
	<script type="text/javascript" src="<?php echo asset("assets/builds/offer_pack.js");?>" ></script>
	<?php } ?>



<?php

if(app()->environment() == 'production') { ?>
      <!-- Google Tag Manager -->
      <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NX7MF9" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <script defer="defer">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NX7MF9');</script>
    <!-- End Google Tag Manager -->
    <?php
  
}elseif (app()->environment() == 'test'){
  ?>
  <!-- Google Tag Manager -->
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KGR56S" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <script defer="defer">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KGR56S');</script>
<!-- End Google Tag Manager -->
<?php } ?>

</head>
<body class="home page page-id-7 page-template page-template-template-fullscreen-slider page-template-template-fullscreen-slider-php fixed-header no-slider icons-style-light">
	<div id="main-container" >
		<div  class="page-wrapper" >
			<!--HEADER -->
			<div class="header-wrapper" >
				<header id="header">
					<div class="section-boxed section-header">
						<div id="logo-container">
							<a href="<?php echo url('/');?>"><img src="<?php  echo images_path("product/logo.png");?>" alt="JMA Landing" /></a>
						</div>
						<div class="mobile-nav">
							<span class="mob-nav-btn">Menu</span>
						</div>
						<nav class="navigation-container">
							<div id="menu" class="nav-menu">
								<ul id="menu-main-menu" class="menu-ul">
									<li id="menu-item-206" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-206"><a href="<?php echo url('');?>">Home</a></li>
									<li id="menu-item-201" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-7 current_page_item menu-item-201"><a href="<?php echo url('/products');?>">Product</a></li>
									<li id="menu-item-202" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-202"><a href="<?php echo url('/aboutus');?>">About us</a></li>
									<li id="menu-item-203" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-203"><a href="<?php echo url('/contact');?>">Contact</a></li>
									<li id="menu-item-204" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-204"><a href="<?php echo url('/aboutus/privacypolicy');?>">Our Privacy Policy</a></li>
									<li id="menu-item-205" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-205"><a href="<?php echo url('/aboutus/commercial_policy');?>">Commercial Policy</a></li>
								</ul>
							</div>
						</nav>
						<div class="clear"></div>
						<div id="navigation-line"></div>
					</div>
				</header>
				<!-- end #header -->
			</div>
			<div id="content-container" class=" layout-full">
				<div id="full-width" class="content">
				<div class="section section-textimg layout-left sec_first" style="background-image:url(<?php  echo images_path("product/LandingD.jpg");?>);">
						<div class="bg-coloroverlay"></div>
						<div class="section-wrapper">

							<div class="section-img anim-el"><img src="<?php  echo images_path("product/Dnews.png");?>" style="width:85%" alt="news image"/></div>
							<div class="section-content anim-el">
								<h2 class="section-title">Timely and concise analysis </h2>
								<div class="section-desc">
									<p>Through exclusive reports by Takuji Okubo.</p>
								</div>
								<a href="#2" class="button hide-mob">Read More</a>
								<?php //if(!Session::has('user')){  ?>
								<!--<a href="#4" class="button btn-success anibtn-hide">Try 30-days free trial</a>
								<a href="#pricing-table" class="button btn-success anibtn-show">Try 30-days free trial</a> -->
								<?php //} ?>
							</div>
							<a href="#2" ><span class="fullpage-scroll-arrow icon-arrow-down-2"></span></a>
						</div>
					</div>
					<div class="section section-textimg layout-left sec_two" style="background-image: url(<?php  echo images_path("product/A.jpg");?>); background-color: #17C5CC; background-position: center center;">
						<div class="bg-coloroverlay"></div>
						<div class="section-wrapper">
							<div class="section-img anim-el">
								<div class="desktop-wrapper" style="background-image:url(<?php  echo images_path("product/desktop.png");?>);">
									<div class="youtube2">
										<iframe width="853" height="480" src="https://www.youtube.com/embed/I829ZTQPBnc?rel=0&autoplay=1&loop=1&playlist=I829ZTQPBnc&iv_load_policy=3&controls=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
							</div>
							<div class="section-content anim-el">
								<h2 class="section-title">Interactive JMA Chart tools</h2>
								<div class="section-desc">
									<p> helps you visualize data and instantly produce presentation materials.</p>
								</div>
								<a href="#3" class="button hide-mob">Read More</a>
								<?php if(!Session::has('user')){  ?>
								<!-- <a href="#4" class="button btn-success anibtn-hide">Try 30-days free trial</a>
								<a href="#pricing-table" class="button btn-success anibtn-show">Try 30-days free trial</a>-->
								<?php } ?>
							</div>
							<a href="#3" ><span class="fullpage-scroll-arrow icon-arrow-down-2"></span></a>
						</div>
					</div>
					<div class="section section-textimg layout-right sec_three" style="background-image: url(<?php  echo images_path("product/B.jpg");?>);">
						<div class="bg-coloroverlay"></div>
						<div class="section-wrapper" id="section_analysis">
							<div class="section-img anim-el">
								<div class="desktop-wrapper" style="background-image:url(<?php  echo images_path("product/desktop.png");?>);">
									<div class="youtube2">
										<iframe width="853" height="480" src="https://www.youtube.com/embed/a8-vYFHp6zo?rel=0&autoplay=1&loop=1&playlist=a8-vYFHp6zo&iv_load_policy=3&controls=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
							</div>
							<div class="section-content anim-el">
								<h2 class="section-title">My Chart</h2>
								<div class="section-desc"><p>enabling instant creation of chartbook</p>
								</div>
								<a href="#4" class="button hide-mob">Read More</a>
								<?php if(!Session::has('user')){  ?>
								<a href="#4" class="button btn-success anibtn-hide">Try 30-days free trial</a>
								<a href="#pricing-table" class="button btn-success anibtn-show">Try 30-days free trial</a> 
								<?php } ?>
							</div>
							<a href="#4" ><span class="fullpage-scroll-arrow icon-arrow-down-2"></span></a>
						</div>
					</div>


					<div class="section section-textimg layout-bottom sec_seen-on fp-section fp-table  fp-completely" style="background-color:#ebebeb;">
<div class="fp-tableCell" style="height: 636px;">
<div class="section-wrapper">
<div class="seen-on">
<h2 class="section-title" style="color:#a1a1a1;text-shadow:none">A contributor to</h2>
<div class="row" >
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/bbc-world-1.svg");?>)"></div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/cnbc-1.svg");?>)"></div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/blloomberg.svg");?>)"></div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/cctv.svg");?>)"></div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/aljazeere-tv.svg");?>)"></div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/1200x630bb_g.png");?>)"></div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/cna.svg");?>)"></div>
</div>
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/ft-3.svg");?>)"></div>
</div>
</div>

<div class="row papers" >
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/new-york-times.svg");?>)"></div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="img" style="background-image: url(<?php  echo images_path("product/products_img/wall-street-journal.svg");?>)"></div>
</div>

</div>

</div>

<a href="#5" class="button hide-mob">Read More</a>

</div>

</div>

</div><!---end of media section-->

					
					<div class="section section-textimg layout-bottom pricing-table" style="background-image: url(<?php  echo images_path("product/LandingF.jpg");?>);">
						<div class="section-wrapper" id="pricing-table">
							<div class="section-img anim-el">
								<div class="price-table-wrapper">
									<div class="cols-wrapper cols-2">
                    <!-- <div class="col pt-col pt-non-highlightfree">
                      <div class="pt-titlefree">Free</div>
                      <div class="pt-price-box pt-position-left"><span class="pt-cur"></span><span class="pt-price">FREE</span><span class="pt-period">per month</span></div>
                      <ul class="pt-features">
                        <li>Access to our Standard Reports</li>
                        <li><i class="fa fa-times" aria-hidden="true" style="color:#e74c3c"></i> Data download of our proprietary data</li>
                        <li>Limited functionality of My Charts</li>
                      </ul>
                      <div class="ac_menu1">
                        <label for="navi01"><font color="#7ec238"><i class="fa fa-angle-double-down"></i> More details</font></label>
                        <input type="checkbox" id="navi01" class="bellows" />
                        <ul class="pt-features2">
                          <li><i class="fa fa-check" aria-hidden="true"></i>Limited Indicator commentaries</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Thematic reports/Economic forecasts</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Monthly Chartbook</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Yield Curve scenario projection</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Download of government statistics</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Download of proprietary statistics</li>
                          <li><i class="fa fa-check" aria-hidden="true"></i>Save 4 charts/tables</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Data inquiry</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Monthly webinar</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Research consultation</li>
                          <li><i class="fa fa-times" aria-hidden="true"></i>Meetings with our economists</li>
                        </ul>
                      </div>
                      <?php if(Session::has('user')){ 
                        if(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='free'){ ?>
                        <div class="pt-button"><button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button></div>
                        <?php }elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='individual'){ ?>
                        <div class="pt-button"><button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button></div>
                        <?php }elseif(Session::get('user.user_status')=='trial' && Session::get('user.user_type')=='individual'){ ?>
                        <div class="pt-button"><button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button></div>
                        <?php }elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='corporate'){ ?>
                        <div class="pt-button"><button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button></div>
                        <?php } }else{ ?>
                        <div class="pt-button hide-mob"><a product="free" class="button offer_product" href="#5">Register NOW</a></div>
                        <div class="pt-button show-mob"><a product="free" class="button offer_product" href="#launch-registration">Register NOW</a></div>
                        <?php 
                      } ?>
                    </div> -->
                    <div class="col pt-col pt-green">
                    	<div class="pt-title" >Standard</div>
                    	<div class="pt-price-box pt-position-left">
                    		<span class="pt-cur">USD</span>
                    		<span class="pt-price">100</span>
                    		<br>
                    		<span class="pt-fretra">(One month free trial)</span>
                    		<span class="pt-period">per month</span>
                    	</div>
                    	<ul class="pt-features">
                    		<li>Access to our Standard Reports</li>
                    		<li>Data download of our proprietary data</li>
                    		<li>Full functionality of My Charts</li>
                    	</ul>
                    	<div class="ac_menu2">
                    		<label data-toggle="modal" data-target="#modal_standard">
                    			<font color="#6EB92B">More details</font>
                    		</label>
                    		<!-- <input type="checkbox" id="navi02" class="bellows" />
                    		<ul class="pt-features2">
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Indicator commentaries</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Thematic reports/Economic forecasts</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Monthly Chartbook</li>
                    			<li><i class="fa fa-times" aria-hidden="true"></i>Yield Curve scenario projection</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Download of government statistics</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Download of proprietary statistics</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Save your charts/tables</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Data inquiry</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Monthly webinar</li>
                    			<li><i class="fa fa-times" aria-hidden="true"></i>Research consultation</li>
                    			<li><i class="fa fa-times" aria-hidden="true"></i>Meetings with our economists</li>
                    		</ul> -->
                    	</div>
                    	<?php if(Session::has('user')){ 
                    		if(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='free'){ ?>
                    		<div class="pt-button"><button class="form_submit btn btn-success"  onclick="location.href='<?php echo url("user/user_type_upgrade");?>';">UPGRADE</button></div>
                    		<?php } elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='individual'){ ?>
                    		<div class="pt-button"><button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button></div>
                    		<?php }elseif(Session::get('user.user_status')=='trial' && Session::get('user.user_type')=='individual'){ ?>
                    		<div class="pt-button"><button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button></div>
                    		<?php }elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='corporate'){ ?>
                    		<?php } } else{ ?>
                    		<div class="pt-button hide-mob"><a product="premium" class="button offer_product" href="#6">30 days Free Trial</a></div>
                    		<div class="pt-button show-mob"><a product="premium" class="button offer_product" href="#launch-registration">30-days Free Trial</a></div>
                    		<?php 
                    	} ?>                      
                    </div>
                    <!--<div class="col pt-col pt-non-highlight">
                    	<div class="pt-title" >Corporate</div>
                    	<div class="pt-price-box pt-position-left"><span class="pt-cur">USD</span><span class="pt-price">1000</span><span class="pt-period">per month</span></div>
                    	<ul class="pt-features">
                    		<li>10 Standard accounts</li>
                    		<li>Research consultation</li>
                    		<li>Meetings/seminars with our economists</li>
                    	</ul>
                    	<div class="ac_menu3">
                    		<label data-toggle="modal" data-target="#modal_corporate">
                    			<font color="#22558F">More details</font>
                    		</label>
                    		<!-- <input type="checkbox" id="navi03" class="bellows" />
                    		<ul class="pt-features2">
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Indicator commentaries</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Thematic reports/Economic forecasts</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Monthly Chartbook</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Yield Curve scenario projection</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Download of government statistics</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Download of proprietary statistics</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Save your charts/tables</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Data request</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Monthly webinar</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Research consultation</li>
                    			<li><i class="fa fa-check" aria-hidden="true"></i>Meetings with our economists</li>
                    		</ul> -->
                    	<!--</div>
                    	<?php if(Session::has('user')){
                    		if(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='free'){ ?>
                    		<div class="pt-button"><button class="form_submit btn btn-primary" <?php echo (Session::has('user') && Session::get('user.user_upgrade_status') == 'RC')?"disabled":"";?> onclick="location.href='<?php echo url("user/user_request_info/");?>';">REQUEST INFO</button> </div>
                    		<?php }elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='individual'){ ?>
                    		<div class="pt-button"><button class="form_submit btn btn-primary" <?php echo (Session::has('user') && Session::get('user.user_upgrade_status') == 'RC')?"disabled":"";?>  onclick="location.href='<?php echo url("user/user_request_info/");?>';">REQUEST INFO</button> </div>
                    		<?php }elseif(Session::get('user.user_status')=='trial' && Session::get('user.user_type')=='individual'){ ?>
                    		<div class="pt-button"><button class="form_submit btn btn-primary" <?php echo (Session::has('user') && Session::get('user.user_upgrade_status') == 'RC')?"disabled":"";?> onclick="location.href='<?php echo url("user/user_request_info/");?>';">REQUEST INFO</button> </div>
                    		<?php }elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='corporate'){ ?>
                    		<?php } 
                    	} else { ?>
                    	<div class="pt-button hide-mob"><a product="corporate" class="button offer_product" href="#6"  >Request Info</a></div>
                    	<div class="pt-button show-mob"><a product="corporate" class="button offer_product" href="#launch-registration">Request Info</a></div>
                    	<?php } ?>
                    </div>-->
                  </div>
                  <div class="clear"></div>
                </div>
              </div>
            	</div>
           
          </div>
          <?php if(!Session::has('user') && Session::get('user') ==0){ ?>
          <div class="section section-textimg layout-bottom reg_section" style="background-image: url(<?php  echo images_path("product/LandingE.jpg");?>);">
          	<div class="pos-relative">
          	<div class="bg-coloroverlay" id="launch-registration"></div>
          	<div class="section-wrapper">
          		<div class="section-content anim-el">
          			<!--<h2 class="section-title"> Registration </h2>-->
          			<div class="section-desc">
          				<form class="signup_frm" name="signup_frm" id="signup_frm" action="<?php echo url('user/signup');?>" method="post" autocomplete="off" novalidate="novalidate">
          					<input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts">
          					<input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
          					<input type="hidden" value="Offrening" name="pagefrom">
          					 <!--<p class="">Select Product </p>-->
          					<p align="center" style="color:red;font-size:15px;" class="text-danger seleproduct"
          					<?php if(isset($result['status']) && $result['status']==1) { ?> style="display: none"
          					<?php } ?>><?php //echo isset($result['message'])?$result['message']:''; ?></p>
          					<div class="cols-1 btn_regbtn" >
                     <!-- <div class="col text-right">
                      <p class="">Select Product <i class="fa fa-hand-o-right anibtn-hide" style="color:red"></i></p>
                        <div class="signup_request_select button <?php echo (isset($product) && $product =='free') ? 'activepro': '';?>">
                          <i class="fa fa-user fa-lg" style=""></i>
                          <b>Free</b>
                          <input type="checkbox" class="signup_product" name="product" <?php echo (isset($product) && $product =='free') ? 'checked': '';?>  value="free">
                          <i class="fa fa-check" <?php echo (isset($product) && $product =='free') ? 'style="display:inline-block"': '';?>></i>
                        </div>
                      </div> -->



                      <div class="col text-center middle">
                      	<div class="signup_request_select button <?php echo (!isset($product)) ? 'activepro':'';?><?php echo (isset($product) && $product =='free') ? 'activepro':'';?>">
                      		<i class="fa fa-user fa-lg" style=""></i>
                      		<sup><i style="" class="fa fa-star fa-fw"></i></sup>
                      		<b>Free</b>
                      		<input type="checkbox" class="signup_product"  name="product" <?php echo (isset($product) && $product =='free') ? 'checked': '';?> <?php echo (!isset($product)) ? 'checked': '';?> value="free">
                      		<i class="fa fa-check"  <?php echo (!isset($product)) ? 'style="display:inline-block"': '';?> <?php echo (isset($product) && $product =='premium')  ? 'style="display:inline-block"': '';?>></i>
                      	</div>
                      </div>
                      <!--<div class="col text-left middle">
                      	<div class="signup_request_select corporate button <?php echo (isset($product) && $product =='corporate') ? 'activepro': '';?>">
                      		<i class="fa fa-building fa-lg" style=""></i>
                      		<b>Corporate</b>
                      		<input type="checkbox" <?php echo (isset($product) && $product =='corporate') ? 'checked': '';?> class="signup_product" name="product" value="corporate">
                      		<i class="fa fa-check" <?php echo (isset($product) && $product =='corporate') ? 'style="display:inline-block"': '';?>></i>
                      	</div>
                      </div>-->
                    </div>
                    <div class="cols-1 brb_lininbtn" >
                    	<div class="col" >
                    		<a class="reg_linkedin"  href="<?php echo url('user/linkedinProcess');?>free">
                    			<img alt="Linkedin Signup" src="<?php  echo images_path('linkedin_signup.png');?>" alt="sign up image">
                    		</a>
                    		<p  class="seleproduct">OR</p>

                    	</div>
                    </div>

                    <div class="cols-1">
                    		<div class="col suf_paratxt_">
                    			<p class=""> <?php echo isset($result['message'])?$result['message']:''; ?> <b>If you are already a JMA subscriber please <a target="_blank" href="<?php echo url('user/login');?>">login</a> </b></p>
                    			
                    		</div>
                    	</div>

                    <div class="cols-3">
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
                    	<div class="col">
                    		<input type="text" placeholder="Given name *" class="form-control" name="fname" id="reg_first_name" value="<?php echo $fname; ?>" onkeypress="return IsCharacter(event);" data-rule-required="true" data-msg-required="Please enter given name" />
                    	</div>
                    	<div class="col">
                    		<input type="text" onkeypress="return IsCharacter(event);" class="form-control" placeholder="Surname *" name="lname" id="reg_last_name" value="<?php echo $lname; ?>"  data-rule-required="true" data-msg-required="Please enter Surname"/>
                    	</div>
                    </div>
                    <div class="cols-1" id="other" style="display: none;">
                    	<div class="col">
                    		<input type="text" class="form-control" placeholder="Other Title " name="OtherTitle" id="reg_user_title" value="<?php echo $OtherTitle; ?>">
                    	</div>
                    </div>
                  <!--  <div class="cols-2">
                    	<div class="col">
                    		<input type="text" placeholder="Given name *" class="form-control" name="fname" id="reg_first_name" value="<?php echo $fname; ?>" onkeypress="return IsCharacter(event);" data-rule-required="true" data-msg-required="Please enter given name" />
                    	</div>
                    	<div class="col">
                    		<input type="text" onkeypress="return IsCharacter(event);" class="form-control" placeholder="Surname *" name="lname" id="reg_last_name" value="<?php echo $lname; ?>"  data-rule-required="true" data-msg-required="Please enter Surname"/>
                    	</div>
                    </div>  -->
                    <div class="cols-3">
                    	<div class="col">
                    		<input class="form-control emailunique"  type="text" placeholder="Email  *" name="email" id="reg_email" value="<?php echo $email; ?>" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address">
                    	</div>
                    	<div class="col">
                    		<select data-rule-required="true" class="required" name="country_id" id="country_id">
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
                    		<div class="col">
                    			<select class="" name="user_industry" id="user_industry">
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
                    		<div class="clear"></div>
                    	</div>
                    	<div class="cols-3">
                    		<div class="col">
                    			<select class="" name="user_position" id="user_position">
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
                    		<div class="col">
                    			<div class="form-control su_couinp">
                    				<input type="hidden"   value="<?php echo ($country_code!='')?$country_code:'+81';?>" name="country_code"   id="country_code"   />
                    				<input type="text" class="phonecls " onkeypress="return IsPhoneNumber(event);"  placeholder="Phone number" value="<?php echo $phone;?>" name="phone"  data-rule-number="true" data-rule-minlength="6" id="reg_phone_number"   />
                    			</div>
                    		</div>
                    		<div class="col">
                    		<div class="col-xs-12">
    <div class="g-recaptcha" data-sitekey="6LfKEjoUAAAAACC-DoITH7IjwWO5EqKhF-NDUd8q"></div>
  </div>
  </div>
                    	</div>
                    	<!--<div class="cols-1">
                    		<div class="col suf_paratxt">
                    			<p>Standard and Corporate subscriptions are our fee based service. For further information please see our <a target="_blank" href="<?php echo url('products');?>">products</a> </p>
                    			<p><small style="color:red;">*</small> Required fields</p>
                    		</div>
                    	</div>-->
                    	<div class="cols-1">
                    		<div class="col">
                    			<button type="submit" style="text-align: right;" name="signup_btn" class="btn btn-primary">Continue</button>
                    		</div>
                    	</div>
                    </form>
                  </div>
                </div>
              </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="clear"></div>
      </div> <!-- end #content-container -->
    </div>
  </div> <!-- end #main-container -->
  <!-- FOOTER ENDS -->
  <?php if(app()->environment()=='development') { ?>
  <script type="text/javascript" src="<?php echo js_path("/pack/jquery.validate.js");?>"></script>
  <script type="text/javascript" src="<?php echo js_path("intlTelInput.min.js");?>"></script>
  <script type="text/javascript" src='<?php echo asset("assets/plugins/bootstrap/js/bootstrap.min.js");?>'></script>
  <?php } ?>
  <script type='text/javascript' src='<?php echo js_path("scrolloverflow.min.js");?>'></script>
  <script type='text/javascript' src='<?php echo js_path("jquery.fullPage.min.js");?>'></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

  <script type="text/javascript">


$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN':  "<?php echo csrf_token();?>",
  }
});

  $.validator.addMethod("emailunique", function(value, element) {
    var response;
    
    jQuery.ajax({
      type: "POST",
      url: document.location.origin+"/user/check_email",
      data: {'user_email':value},
      dataType:"json",
      cache: false,
      async:false,
      success: function (data) {
        response=$.trim(data);

      }
    });

    if(response == 'false')
    {
      return true;
    }
    else
    {
      return false;
    }
  }, "A user already registered with this email id, If you are already a JMA subscriber please login above link");

  $(function() {
  	$( ".mobile-nav" ).on( "click", function() {
  		$(".navigation-container" ).slideToggle();
  		$("body").toggleClass("overflow-hide");
  	});
  } );
  </script>
  <script type="text/javascript">
  var isPhoneDevice = "ontouchstart" in document.documentElement;
  var isMobile = window.matchMedia("only screen and (max-width: 1199px)");
  if (isMobile.matches) {
  }
  else {
  	$('#full-width').fullpage({
  		anchors:['#1', '#2', '#3', '#4', '#5','#6'],
  		animateAnchor: true,
  		navigation:true,
  		css3: true,
  		scrollingSpeed: 700,
  		scrollOverflow: true,
  		autoScrolling: true,
  		autoplay:true
  	});
  }
  </script>
  <script type="text/javascript">
  var $=jQuery;
  $(function() {
  	$('[name="country_code"]').intlTelInput({
  		allowDropdown: true,
  		autoHideDialCode: true,
  		autoPlaceholder: true,
  		geoIpLookup: function(callback) {
  			$.get("//ipinfo.io", function() {}, "jsonp").always(function(resp) {
  				var countryCode = (resp && resp.country) ? resp.country : "";
  				callback(countryCode);
  			});
  		},
  		initialCountry: "auto",
  		nationalMode: true,
  		numberType: "MOBILE",
  		preferredCountries: ['jp', 'us', 'in'],
  		separateDialCode: true,
  		utilsScript: '<?php echo js_path("utils.js");?>',
  	});
  	$('div.selected-flag').attr("tabindex",-1);
  	$('ul.country-list li.country').on('click , ontouchstart', function() {
  		var option1 = $(this).data('dial-code');
  		$('#country_code').val("+"+option1);
  	});
  	$('#country_id').on('change , ontouchstart', function() {
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
$('.signup_request_select').on('click , ontouchstart',function(event){
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
$('.offer_product').on('click , ontouchstart',function(event){
	var clickbutn=$(this).attr('product');
	$(".signup_product[value='"+clickbutn+"']").parent('div').trigger( "click" );
});
if ($('#user_title_id').val() == "Other") {
	$("#other").show();
}else{$("#other").hide();}
$('#user_title_id').change(function(){
	if ($(this).val() == "Other") {
		$("#other").show();
	}else if ($(this).val() != "Other") {
		$("#other").hide();
	}
});
$("#signup_frm").validate({
	submitHandler: function(form) {

		var $captcha = $( '#recaptcha' ),
  		response = grecaptcha.getResponse();
  if (response.length === 0) {
    alert( "reCAPTCHA is mandatory" );
    
    return false;
    }else{
    	form.submit();
    }

		
	}
});
});
// allow only character
function IsCharacter(evt)
{
  // For Alaphabets
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 13 && charCode != 32  && charCode != 9 && charCode != 8 && charCode != 127 && (charCode <= 38 || charCode >= 40)) && (evt.keyCode != 46))
  {
  	return false;
  }
  return true;
}
// Allow only for Numbers
function IsPhoneNumber(evt)
{
  // For Number
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (((charCode < 48 || charCode > 57)  && charCode != 32   && charCode != 40 && charCode != 41  && charCode != 43 && charCode != 45 && charCode != 8 && charCode != 127 && charCode != 9 && charCode != 17 && charCode != 18 && (charCode < 37 || charCode > 40)) && (evt.keyCode != 46))
  {
  	return false;
  }
  return true;
}
</script>

<div class="modal fade" id="modal_standard" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Standard Subscription Plan</h4>
			</div>
			<div class="modal-body">
				<ul class="list_subsplan">						
					<li class="price_innttl">
						Published research
					</li>
					<li>
						<i class='fa fa-check'></i>
						Indicator commentaries
					</li>
					<li>
						<i class='fa fa-check'></i>
						Thematic reports
					</li>
					<li class="price_innttl">
						Data and chartbook creation 
					</li>
					<li>
						<i class='fa fa-check'></i>
						Download of government statistics
					</li>
					<li>
						<i class='fa fa-check'></i>
						Download of proprietary statistics
					</li>
					<li>
						<i class='fa fa-check'></i>
						Save your charts/tables
					</li>
					<li class="price_innttl">
						Support and consulting services
					</li>
					<li>
						<i class='fa fa-check'></i>
						Data inquiry
					</li>
					<li>
						<i class='fa fa-close'></i>
						Research consultation
					</li>
					<li>
						<i class='fa fa-close'></i>
						Meetings with our economists
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_corporate" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Corporate Subscription Plan</h4>
			</div>
			<div class="modal-body">
				<ul class="list_subsplan">						
						<li class="price_innttl">
							Published research
						</li>
						<li>
							<div class='fa fa-check'></div>
							Indicator commentaries
						</li>
						<li>
							<div class='fa fa-check'></div>
							Thematic reports/Economic forecasts
						</li>
						<li>
							<div class='fa fa-check'></div>
							Monthly Chartbook
						</li>
						<li>
							<div class='fa fa-check'></div>
							Yield Curve scenario projection 
						</li>
						<li class="price_innttl">
							Data and chartbook creation 
						</li>
						<li>
							<div class='fa fa-check'></div>
							Download of government statistics
						</li>
						<li>
							<div class='fa fa-check'></div>
							Download of proprietary statistics
						</li>
						<li>
							<div class='fa fa-check'></div>
							Save your charts/tables
						</li>
						<li>
							<div class='fa fa-check'></div>
							Save your charts/tables
						</li>
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-check'></div>
							Data request <sup>*3</sup>
						</li>
						<li>
							<div class='fa fa-check'></div>
							Monthly webinar
						</li>
						<li>
							<div class='fa fa-check'></div>
							Research consultation
						</li>
						<li>
							<div class='fa fa-check'></div>
							Meetings with our economists
						</li>
					</ul>
			</div>
		</div>
	</div>
</div>
</body>
</html>
