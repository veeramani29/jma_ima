<?php
// Enable Cache By Veera
//header("Cache-Control: public, must-revalidate, max-age=2592000");
//header("Pragma: public");
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<?php if(app()->environment()=='production') { ?>
	<meta name="robots" content="Index, Follow, Noodp, Noydir" />
	<?php }else{ ?>
<meta name="robots" content="noindex, nofollow" />
	<?php  } ?>
	
	<meta name="description" content="<?php echo isset($renderResultSet['meta']['description'])?$renderResultSet['meta']['description']:'JMA ';?>">
	<meta name="keywords" content="<?php echo isset($renderResultSet['meta']['keywords'])?$renderResultSet['meta']['keywords']:'JMA';?>">
	<meta name="google-translate-customization" content="1fea04e055fb6965-35248e5248638537-g6177b01b3439e3b2-16">
	<meta property="og:image:width" content="640" />
	<meta property="og:image:height" content="360" />
	<meta property="og:type" content="article" />
	<meta name="twitter:image:src" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? "https://content.japanmacroadvisors.com/images/japan-macro-advisors.png" :'https://www.japanmacroadvisors.com/public/uploads/postImages/'.$renderResultSet['meta']['shareImage']; ?>">
	<meta itemprop="name" content="japanmacroadvisors.com">
	<meta itemprop="description" content="<?php echo isset($renderResultSet['meta']['description'])?$renderResultSet['meta']['description']:'JMA';?>">
	<meta itemprop="image" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? "https://content.japanmacroadvisors.com/images/japan-macro-advisors.png" :'https://www.japanmacroadvisors.com/public/uploads/postImages/'.$renderResultSet['meta']['shareImage']; ?>">
	<meta property="og:image" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? "https://content.japanmacroadvisors.com/images/japan-macro-advisors.png" :'https://www.japanmacroadvisors.com/public/uploads/postImages/'.$renderResultSet['meta']['shareImage']; ?>" />
	<meta property="og:site_name" content="japanmacroadvisors.com" />
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" />
	<meta property="og:title" content="<?php echo !isset($renderResultSet['meta']['shareTitle']) ? 'Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $renderResultSet['meta']['shareTitle']; ?>" />
	<meta property="og:description" content="<?php echo isset($renderResultSet['meta']['description'])?$renderResultSet['meta']['description']:'JMA';?>" />
	<meta property="fb:app_id" content="1597539907147636" />
	<title><?php echo !isset($renderResultSet['pageTitle']) ? 'Japan Economy, Macro economy, Japan GDP, Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $renderResultSet['pageTitle']; ?></title>
	<base href="<?php echo url('/'); ?>">
	<link rel="shortcut icon" href="https://www.japanmacroadvisors.com/favicon.ico" type="image/icon">
	<link rel="icon" href="https://www.japanmacroadvisors.com/favicon.ico" type="image/icon">
	<?php if(app()->environment()=='development') { ?>
	<!-- fontawesome -->
	<link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/font-awesome/css/font-awesome.min.css");?>">
	<!-- bootstrap -->
	<link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/bootstrap/css/bootstrap.min.css");?>">
	<!-- bootstrap select option -->
<link rel="stylesheet" type="text/css"  href="<?php echo asset("assets/plugins/bootstrap-select/css/bootstrap-select.min.css");?>">
	<!-- jquery ui -->
	<link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/jquery-ui/jquery-ui.min.css");?>">
	<!-- animate -->
	<link rel="stylesheet" type="text/css"  href="<?php echo asset("assets/plugins/animate/animate.min.css");?>">
	<!-- slick -->
	<link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/slick/slick.css");?>">
	<link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/slick/slick-theme.css");?>">
	<!-- plugin or other css -->
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("intlTelInput.css");?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("jquery.alerts.css");?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("ken-burns.css");?>" />
	<!-- color picker -->
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("spectrum.css");?>" />
	<!-- ResponsiveMultiLevelMenu -->
	<link rel="stylesheet" type="text/css" href="<?php echo asset("assets/plugins/ResponsiveMultiLevelMenu/css/component.css");?>" />
	<!-- custom css files -->
	<link  rel="stylesheet" type="text/css" href="<?php echo css_path("custom-styles.css");?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("media.css");?>" />
	<script type="text/javascript" src="<?php echo js_path("jquery.min.js");?>" ></script>
	<?php }else { ?>
	<script type="text/javascript" src="<?php echo asset("assets/builds/bundle.js");?>" ></script>
	
<script type="application/ld+json">
{
"@context" : "https://schema.org",
"@type" : "WebSite", 
"name" : "Japan Macro Advisors",
 "url" : "{{url('/')}}"
 }
</script>
<script type="application/ld+json">
{
"@context": "https://schema.org",
 "@type": "Organization",
  "address": {
 "@type": "PostalAddress",
 "addressLocality": "Roppongi Hills North Tower Level 17",
  "addressRegion": "Tokyo",
  "postalCode":"106-0032",
   "streetAddress": "Roppongi 6-2-31, Minato, Tokyo, 106-0032, Japan"
},

  "url" : "{{url('/')}}",
  "logo": "{{images_path('logo.png')}}",
  "name": "Japan Macro Advisors",
  "telephone" : "+81.3.5786.3275",
   "email" : "info@japanmacroadvisors.com",
   "sameAs" : [

  "https://www.facebook.com/Japanmacroadvisors/",
  "https://twitter.com/JapanMadvisors",
  "https://www.linkedin.com/company/japan-macro-advisors/"

  ] 

  } 
</script>
	<?php } ?>
	<style>
	.scroll-svg, .scroll-svg rect {
		width: 100%;
	}
	div[id^="Table_Dv_placeholder_"]{
		overflow-x: auto; overflow-y: auto; 
	}

	

	svg .highcharts-colorAxis-0 > text:last-child,
	svg .highcharts-colorAxis-1 > text:last-child,
	svg .highcharts-colorAxis-2 > text:last-child,
	svg .highcharts-colorAxis-1 > text:nth-child(2),
	svg .highcharts-colorAxis-2 > text:nth-child(2){
		transform: translate(-7px,0px);
		-ms-transform: translate(-7px,0px);
		-webkit-transform: translate(-7px,0px);
		-o-transform: translate(-7px,0px);
		-moz-transform: translate(-7px,0px);
	}
	svg .highcharts-colorAxis-1 > text:first-child,svg .highcharts-colorAxis-2 > text:first-child{
		transform: translate(-14px,0px);
		-ms-transform: translate(-14px,0px);
		-webkit-transform: translate(-14px,0px);
		-o-transform: translate(-14px,0px);
		-moz-transform: translate(-14px,0px);
	}
	</style>
</head>
<body>
 <script>
 function changeLang(){
  document.getElementById('form_lang').submit();
 }
 </script>
	<div id="overlay_loading" style="display:none;">
		<div class="cssload-preloader">
			<div class="cssload-preloader-box">
				<div>L</div>
				<div>o</div>
				<div>a</div>
				<div>d</div>
				<div>i</div>
				<div>n</div>
				<div>g</div>
			</div>
		</div>
	</div>
	<header>
		<div class="mob_menubgoverlay"></div>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo url('/');?>">
						<img alt="Japan GDP Economy" src="<?php echo images_path("logo.png");?>" >
					</a>
				</div>
				<div class="collapse navbar-collapse" id="mainNav">
			
	<ul class="nav navbar-nav navbar-right">
						<li class="<?php echo (thisController()=='home')?'active':'';?>"><a href="<?php echo url('/');?>" class="top_link_common">Home</a></li>
						<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='index')?'active':'';?>"><a href="<?php echo url('aboutus');?>" class="top_link_common">About us</a></li>
					<!-- 	<li class="<?php echo (thisController()=='products')?'active':'';?>"><a href="<?php echo url('products');?>" class="top_link_common">Products</a></li> -->
						<!-- <li><a href="<?php // echo url('careers');?>"class="top_link_common">Careers</a></li> -->
						<li class="<?php echo (thisController()=='contact')?'active':'';?>"><a href="<?php echo url('contact');?>" class="top_link_common">Contact</a></li>
						<li class="<?php echo (thisMethod()=='privacypolicy')?'active':'';?>"><a href="<?php echo url('aboutus/privacypolicy');?>" class="top_link_common">Our Privacy Policy</a></li>
						<li class="<?php echo (thisMethod()=='commercial_policy')?'active':'';?>"><a href="<?php echo url('aboutus/commercial_policy');?>" class="top_link_common">Commercial Policy </a></li>
						@if(Session::has('user') && Session::get('user.id') > 0)
						<li class="jma_username">
							<a href="<?php echo url('user/myaccount');?>" class="top_link_common">
								<font color="red">
									{{ Session::get('user.fname').' '.Session::get('user.lname')  }}
								</font>
							</a>
						</li>
						<li class="last"><a href="<?php echo url('user/logout');?>" class="top_link_common">Signout</a></li>
						@else
						<li class="last" id="lnk_client_login"><a href="<?php echo url('user/login');?>" class="top_link_client_login">User Login</a></li>
						@endif
						<!-- <li class="sea-jmaind"><a class="top_link_common"><i class="fa fa-search" aria-hidden="true"></i></a></li> -->
						<li style="margin-top:10px;">
					</ul>
					@include('templates.responsive_navigation')
					<ul class="nav navbar-nav mob_navsec">
						<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='index')?'active':'';?>"><a href="<?php echo url('aboutus');?>" class="top_link_common">About us</a></li>
						<li class="<?php echo (thisController()=='products')?'active':'';?>"><a href="<?php echo url('products');?>" class="top_link_common">Products</a></li>
						<li class="<?php echo (thisController()=='contact')?'active':'';?>"><a href="<?php echo url('contact');?>" class="top_link_common">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="sea-indinp" style="display:none;">
			<div class="container">
				<div class="col-xs-12 col-sm-6 pull-right">
					<form>
						<div class="input-group">
							<input type="text" class="form-control" id="search-autocomplete" placeholder="Type a  keyword for your search">
							<div class="input-group-addon igd-btn"><a href="<?php echo url('aboutus/search');?>">Search</a></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</header>
	<section>
		<?php $home_classes='';  if(thisController()=='home'){
			$home_classes = 'kb_elastic animate_text kb_wrapper';
		} ?>
		<?php if(thisController()!='products' && thisController()!='mycharts'){ ?>
		<div id="carousel_home" class="carousel slide carousel_home <?php if($home_classes){ echo $home_classes; } ?>" data-ride="carousel">
			<?php if(thisController()=='home'){ $Bancount=3;$smallBan_Name='slider'; ?>
			<?php }else{
				$Bancount=1;
				$smallBan_Name='smallslider';
			}?>
			<!-- Wrapper for slides -->
			<div class="carousel-inner <?php echo $smallBan_Name;?>" role="listbox">
				<div class="item active">

					<?php if(thisController()=='home'){
						//<img alt="Japanese Economy" src="http://res.cloudinary.com/jma-mobile/image/upload/<?php echo $smallBan_Name.($b+1);.jpg" >
						echo cl_image_tag($smallBan_Name.(1).".jpg",
							array( "alt" => "Japanese Economy","secure" => "true" ));
					} else 
					{ ?>
					<img alt="Japanese Economy" src="<?php echo images_path('slider/'.$smallBan_Name.(1).'.jpg');?>" >
					<?php } ?>
					<div class="carousel-caption">
						<h4 data-animation="animated flipInX">Free Access to Japanese Macroeconomic Data</h4>
						<!--<h4 data-animation="animated flipInX">CONCISE AND INSIGHTFUL ANALYSIS ON THE JAPANESE ECONOMY</h4>-->
						@if(Session::has('user') && Session::get('user.id') > 0)
						<a class="btn btn-primary btn-sm btn_carhom" href=<?php echo url('user/myaccount/subscription');?>>
							@if(Session::get('user.user_type') == 'corporate')
							<span class="btn_carporate">
								<i class="fa fa-building fa-lg"></i>&nbsp;<strong><!--Corporate--> My Account</strong>
							</span>
							@endif
							@if(Session::get('user.user_type') == 'individual')
							<span class="btn_premium">
								<i class="fa fa-user fa-lg"></i>
								<sup><i class="fa fa-star fa-fw"></i></sup>
								<!--Premium-->My Account
							</span>
							@endif
							@if(Session::get('user.user_type') == 'free')
							<span>
								<i class="fa fa-user fa-lg"></i>
								&nbsp;<strong><!--Free--> My Account</strong>
							</span>
							@endif
						</a>
						@else
						<a class="btn btn-success btn-sm btn_carhom" href="<?php echo url('user/signup');?>">
							<i class="fa fa-hand-o-right"></i>Sign up, we are free
							<!-- Register for 30-days free trial -->
						</a>
						@endif
						<!-- <a class="btn btn-primary btn-sm btn_carhom" target="_blank" href=<?php echo url('products/offerings');?>>
							<span class="btn_carporate">
								<i class="fa fa-hand-o-right"></i>What We Offer
							</span>
						</a> -->
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<!-- product page banner -->
		<?php if(thisController()=='products' && thisMethod()=='index'){ ?>
		<div class="product_banner">
			<div class="color_overlayd"></div>
			<div class="container">
				<div class="col-xs-12 col-md-6">
					<div class="pb_desktop">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe src="https://www.youtube.com/embed/I829ZTQPBnc?rel=0&autoplay=1&loop=1&playlist=I829ZTQPBnc&iv_load_policy=3&controls=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="pd_rigcon">
						<div class="main-title">
							<h1>WHAT WE OFFER</h1>
							<div class="mttl-line"></div>
						</div>
						<h3>Interactive JMA Chart tools</h3>
						<hr>
						<h3>My Chart</h3>
						<hr>
						<h3>Timely and concise analysis</h3>
						<div class="text-center">
							<div class="spacer10"></div>
							<a class="btn btn-primary btn-sm btn_carhom" href="<?php echo url('products/offerings');?>">
								Read More <i class="fa fa-arrow-right" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if(thisController()=='products' && thisMethod()=='about_premium_user'){ ?>
		<div class="product_banner abtpreuse_banner">
			<div class="color_overlayd"></div>
			<div class="container">
				<div class="col-xs-12 col-md-6">
					<div class="pb_desktop">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe src="https://www.youtube.com/embed/I829ZTQPBnc?rel=0&autoplay=1&loop=1&playlist=I829ZTQPBnc&iv_load_policy=3&controls=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="pd_rigcon">
						<div class="main-title">
							<h1>JMA Standard $100/month</h1>
							<div class="mttl-line"></div>
						</div>
						<p>Unlimited Chart saving.</p>
						<p>Monthly Chart book.</p>
						<p>Standard Data.</p>
						<p>Standard Report</p>
						<p class="last">Contact us or post any query.</p>
						<div class="text-center">
							<a class="btn btn-primary btn-sm btn_carhom" href="<?php echo url('products/offerings');?>">
								Go Standard <i class="fa fa-arrow-right" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 text-center">
					<div class="apu_free">
						<h1>Free Trail</h1>
						<h3>30-days free trail to experience Standard services</h3>
						<a class="btn btn-primary btn-sm" href="<?php echo url('user/signup');?>">Try 30-days free trial <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
		</div>
		<?php   } ?>
		<?php if(thisController()=='mycharts'){ ?>
		<div class="mycha_banner">
			<div class="color_overlayd"></div>
			<div class="container">
				<div class="col-xs-12 col-md-6">
					<div class="mc_desktop">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe src="https://www.youtube.com/embed/l6aD6ndRHIU?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="mc_rigcon">
						<div class="main-title">
							<h1>What you can do in My charts?</h1>
							<div class="mttl-line"></div>
						</div>
						<p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Interactive charts and unlimited data download</p>
						<p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Save any chart in Folders</p>
						<p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Edit the charts-Compare data from different series</p>
						<p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Make a note- Write down a text you want alongside the charts</p>
						<p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Arrange them in "List View" and "Small view" according to your need</p>
						<p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Download the chartbook in Powerpoint</p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</section>
	<section class="container">


	<!-- <button class="btn btn-primary" id="spec-colpic">
	change color

</button> -->
<?php if(thisMethod()!='dopayment' && thisMethod()!='singlePayment'){ ?>
@include('templates.left_navigation')
<?php } ?>

@yield('content')
</section>
@include('templates.footer')
<?php  $highstock_src_=array('page','news','reports','mycharts','home');
if(in_array(thisController(), $highstock_src_)){ ?>
@include('templates.script_template')
<?php } ?>
<!-- All Modal Start -->
@include('templates.all_modal')
<!-- All Modal End -->
</body>
</html>
