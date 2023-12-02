<?php
header('content-type: text/html; charset=utf-8');
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
	<meta name="keywords" content="<?php echo isset($renderResultSet['meta']['keywords'])?$renderResultSet['meta']['keywords']:SITE_NAME;?>">
	<meta name="google-translate-customization" content="1fea04e055fb6965-35248e5248638537-g6177b01b3439e3b2-16">
	<meta property="og:image:width" content="640" />
	<meta property="og:image:height" content="360" />
	<meta property="og:type" content="article" />
	<meta name="twitter:image:src" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? "https://content.japanmacroadvisors.com/images/japan-macro-advisors.png" :'https://www.japanmacroadvisors.com/public/uploads/postImages/'.$renderResultSet['meta']['shareImage']; ?>">
	<meta itemprop="name" content="japanmacroadvisors.com">
	<meta itemprop="description" content="<?php echo isset($renderResultSet['meta']['description'])?$renderResultSet['meta']['description']:SITE_NAME;?>">
	<meta itemprop="image" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? "https://content.japanmacroadvisors.com/images/japan-macro-advisors.png" :'https://www.japanmacroadvisors.com/public/uploads/postImages/'.$renderResultSet['meta']['shareImage']; ?>">
	<meta property="og:image" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? "https://content.japanmacroadvisors.com/images/japan-macro-advisors.png" :'https://www.japanmacroadvisors.com/public/uploads/postImages/'.$renderResultSet['meta']['shareImage']; ?>" />
	<meta property="og:site_name" content="japanmacroadvisors.com" />
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" />
	<meta property="og:title" content="<?php echo !isset($renderResultSet['meta']['shareTitle']) ? 'Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $renderResultSet['meta']['shareTitle']; ?>" />
	<meta property="og:description" content="<?php echo isset($renderResultSet['meta']['description'])?$renderResultSet['meta']['description']:SITE_NAME;?>" />
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
	<!-- <link rel="stylesheet" type="text/css"  href="<?php echo asset("assets/plugins/animate/animate.min.css");?>"> -->
	<!-- slick -->
	<!-- <link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/slick/slick.css");?>">
	<link rel="stylesheet" type="text/css"  href="<?php  echo asset("assets/plugins/slick/slick-theme.css");?>"> -->
	<!-- plugin or other css -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo css_path("intlTelInput.css");?>" /> -->
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("jquery.alerts.css");?>" />
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo css_path("ken-burns.css");?>" /> -->
	<!-- color picker -->
<!-- 	<link rel="stylesheet" type="text/css" href="<?php echo css_path("spectrum.css");?>" /> -->
	<!-- ResponsiveMultiLevelMenu -->
	<link rel="stylesheet" type="text/css" href="<?php echo asset("assets/plugins/ResponsiveMultiLevelMenu/css/component.css");?>" />
	<!-- custom css files -->
	<link  rel="stylesheet" type="text/css" href="<?php echo css_path("custom-styles.css");?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("media.css");?>" />
	<script type="text/javascript" src="<?php echo js_path("jquery.min.js");?>" ></script>
	<?php }else { ?>
	<script type="text/javascript" src="<?php echo asset("assets/builds/bundle.js");?>" ></script>
	<style type="text/css">
		.list_socail li.fs_youtube{
background: red;
		}
	</style>
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
						<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='md5')?'active':'';?>"><a href="<?php echo url('md5_encryption');?>" class="top_link_common">MD5 encryption</a></li>
					<!-- 	<li class="<?php echo (thisController()=='products')?'active':'';?>"><a href="<?php echo url('products');?>" class="top_link_common">Products</a></li> -->
						<!-- <li><a href="<?php // echo url('careers');?>"class="top_link_common">Careers</a></li> -->
						<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='password_generator')?'active':'';?>"><a href="<?php echo url('password_generator');?>" class="top_link_common">Password Generator</a></li>
						<li class="<?php echo (thisMethod()=='Base64')?'active':'';?>"><a href="<?php echo url('base64_encryption');?>" class="top_link_common">Base64 Encode</a></li>
						<li class="<?php echo (thisMethod()=='javascript_programes')?'active':'';?>"><a href="<?php echo url('page/category/javascript-programs');?>" class="top_link_common">Javascript Programs </a></li>
						
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
		<?php } ?>
		<!-- product page banner -->
		<?php if(thisController()=='products' && thisMethod()=='index'){ ?>
		<?php } ?>
		<?php if(thisController()=='products' && thisMethod()=='about_premium_user'){ ?>
		
		<?php   } ?>
		<?php if(thisController()=='mycharts'){ ?>
				<?php } ?>
	</section>
	<section class="container">


	<!-- <button class="btn btn-primary" id="spec-colpic">
	change color

</button> -->

@include('templates.left_navigation')
@yield('content')
</section>
@include('templates.footer')
<!-- All Modal Start -->
{{--@include('templates.all_modal')--}}
<!-- All Modal End -->
</body>
</html>
