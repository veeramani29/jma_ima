<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta name="description" content="<?php echo $renderResultSet['meta']['description'];?>">
	<meta name="keywords" content="<?php echo $renderResultSet['meta']['keywords'];?>">
	<meta name="google-translate-customization" content="1fea04e055fb6965-35248e5248638537-g6177b01b3439e3b2-16"></meta>
	<meta property="og:type" content="article" />
	<meta property="og:image" content="http://content.indiamacroadvisors.com/images/japan-macro-advisors.png" />
	<meta property="og:site_name" content="indiamacroadvisors.com" />
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" />
	<meta property="og:title" content="<?php echo !isset($renderResultSet['meta']['shareTitle']) ? 'India economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo' : $renderResultSet['meta']['shareTitle']; ?>" />
	<meta property="og:description" content="<?php echo $renderResultSet['meta']['description'];?>" />
	<meta property="fb:app_id" content="1597539907147636" />
	<base href="<?php echo url('/'); ?>">
	<title><?php echo !isset($renderResultSet['pageTitle']) ? 'Indian economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo' : $renderResultSet['pageTitle']; ?></title>
	<link rel="shortcut icon" href="<?php echo url('/favicon.ico'); ?>" type="image/icon">
	<link rel="icon" href="<?php echo url('/favicon.ico'); ?>" type="image/icon">
	
	<?php if(app()->environment()=='development') { ?>
	<link rel="stylesheet" href="<?php  echo asset("assets/plugins/font-awesome/css/font-awesome.css");?>">
	<link rel="stylesheet" href="<?php  echo asset("assets/plugins/bootstrap/css/bootstrap.css");?>">
	<link rel="stylesheet" type="text/css" href="<?php  echo asset("assets/plugins/slick/slick.css");?>" >
	<link rel="stylesheet" type="text/css" href="<?php  echo asset("assets/plugins/slick/slick-theme.css");?>" >
	<!-- spectrum color picker -->	
	<link rel="stylesheet" type="text/css" href="<?php  echo asset("assets/plugins/spectrum/spectrum.css");?>" >
	<link href="<?php  echo css_path("jquery.alerts.css");?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo css_path("intlTelInput.css");?>" />
	<link rel="stylesheet" media="print" href="<?php echo css_path("print_page.css");?>" />
	<link rel="stylesheet" type="text/css"  href="<?php echo asset("assets/plugins/animate/animate.min.css");?>">
	<link rel="stylesheet" type="text/css" href="<?php echo css_path("ken-burns.css");?>" />
	<link rel="stylesheet" href="<?php echo css_path("custom-styles.css");?>" />
	<link rel="stylesheet" href="<?php echo css_path("media.css");?>" />
	<script type="text/javascript" src="<?php echo js_path("jquery.min.js");?>"></script>
	<script type="text/javascript" src="<?php echo js_path("handlebars-v2.0.0.js");?>"></script>
	<?php }else { ?>
	<script type="text/javascript" src="<?php echo asset("assets/builds/bundle.js");?>" ></script>
	<?php } ?>
	
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N6WS2GV');</script>
<!-- End Google Tag Manager -->
</head>
<body>
	<?php
	$ENV = app()->environment();
	if($ENV == 'production') {
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6WS2GV"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		adsbygoogle = window.adsbygoogle || [].push({
			google_ad_client: "ca-pub-5696744143542482",
			enable_page_level_ads: true
		});
		</script>
		<?php
	} elseif ($ENV == 'test'){ ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6WS2GV"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
} else{
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="http://www.googletagmanager.com/ns.html?id=GTM-N6WS2GV"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	adsbygoogle = window.adsbygoogle || [].push({
		google_ad_client: "ca-pub-5696744143542482",
		enable_page_level_ads: true
	});
	</script>
	<?php
}

?>
<!-- <div class="container"> -->
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
<?php  $highstock_src_=array('page','news','reports','mycharts','home');
if(in_array(thisController(), $highstock_src_)){ ?>
<?php echo $__env->make('templates.script_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php } ?>
<header>
	<nav class="navbar navbar-default">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo url('/');?>">
					<img alt="Indian GDP Economy" src="<?php echo images_path("logo.png");?>" >
				</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="mainNav">
				<ul class="nav navbar-nav navbar-right">
					<li class="<?php echo (thisController()=='home')?'active':'';?>"><a href="<?php echo url('/');?>" class="top_link_common">Home</a></li>
					<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='index')?'active':'';?>"><a href="<?php echo url('aboutus');?>" class="top_link_common">About IMA</a></li>
					<li class="<?php echo (thisController()=='products')?'active':'';?>"><a href="<?php echo url('products');?>" class="top_link_common">Products</a></li>
					<li class="<?php echo (thisMethod()=='career')?'active':'';?>"><a href="<?php echo url('aboutus/career');?>"class="top_link_common">Careers</a></li>
					<li class="<?php echo (thisController()=='contact')?'active':'';?>"><a href="<?php echo url('contact');?>" class="top_link_common">Contact</a></li>
					<li class="<?php echo (thisMethod()=='offerings')?'active':'';?>"><a href="<?php echo url('products/offerings');?>" class="top_link_common">What We Offer</a></li>

					<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {?>
					<li class="jma_username">
						<a href="<?php echo url('user/myaccount');?>" class="top_link_common">
							<?php echo ucfirst($_SESSION['user']['fname']).' '.$_SESSION['user']['lname'];?>
						</a>
					</li>
					<li class="last"><a href="<?php echo url('user/logout');?>" class="top_link_common">Signout</a></li>
					<?php } else {?>
					<li class="last" id="lnk_client_login"><a href="<?php echo url('user/login');?>" class="top_link_client_login">USER LOGIN</a></li>
					<?php }?>
				</ul>
				<?php  //include ('view/templates/responsive_navigation.php');?>
				<ul class="nav navbar-nav mob_navsec">
					<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='index')?'active':'';?>"><a href="<?php echo url('aboutus');?>" class="top_link_common">About IMA</a></li>
					<li class="<?php echo (thisController()=='products')?'active':'';?>"><a href="<?php echo url('products');?>" class="top_link_common">Products</a></li>
					<li class="<?php echo (thisMethod()=='career')?'active':'';?>"><a href="<?php echo url('aboutus/career');?>"class="top_link_common">Careers</a></li>
					<li class="<?php echo (thisController()=='contact')?'active':'';?>"><a href="<?php echo url('contact');?>" class="top_link_common">Contact</a></li>
				</ul>
				<!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
<section>
	<?php if(thisController()=='home'){
		$home_classes = 'kb_elastic animate_text kb_wrapper';	
	} ?>
	<?php if(thisController()!='pressrelease' && thisController()!='mycharts'){ ?>
	<div id="carousel_home" class="carousel slide carousel_home <?php if(isset($home_classes)){ echo $home_classes; } ?>" data-ride="carousel">
		<?php if(thisController()=='home'){ $Bancount=1;$smallBan_Name='slider'; ?>
		<?php }else{
			$Bancount=1;
			$smallBan_Name='smallslider';
		}?>
		<!-- Wrapper for slides -->
		<div class="carousel-inner <?php echo $smallBan_Name;?>" role="listbox">
			<?php for ($b=0; $b <$Bancount ; $b++) { ?>
			<div class="item <?php echo ($b==0)?"active":'';?>">
				<img  src="<?php echo images_path('slider/'.$smallBan_Name.($b+1).'.jpg');?>" alt="IMA Banners">
				<div class="carousel-caption">
					<h4 data-animation="animated flipInX">CONCISE AND INSIGHTFUL ANALYSIS ON THE INDIAN ECONOMY</h4>
					<?php if(isset($_SESSION['user']) && $_SESSION['user']['id']){ ?>
					<a class="btn btn-primary btn-sm btn_carhom" href=<?php echo url('user/myaccount/subscription');?>>
						<?php if($_SESSION['user']['user_type']  == 'individual'){ ?>
						<span class="btn_premium">
							<i class="fa fa-user fa-lg"></i>
							<sup><i class="fa fa-star fa-fw"></i></sup>
							Premium
						</span>
					  <?php } elseif($_SESSION['user']['user_type']  == 'free') { ?> 
						<span>
							<i class="fa fa-user fa-lg"></i>
							&nbsp;<strong>Free</strong>
						</span>
						<?php } ?>
					</a>
					<?php } else { ?>
					<a class="btn btn-primary btn-sm btn_carhom" href="<?php echo url('user/signup');?>">
						<i class="fa fa-play-circle"></i>
						Register for a Free account
					</a>
					 <?php } ?>
					<a class="btn btn-primary btn-sm btn_carhom yt_videos" data-toggle="modal" data-target=".jma_modvid">
						<span class="btn_carporate">
							<i class="fa fa-youtube-play"></i>Introduction to IMA
						</span>
					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
	<!-- press release page banner -->
	<?php if(thisController()=='pressrelease' && thisMethod()=='index'){ ?>
	<div class="carousel carousel_home kb_elastic animate_text kb_wrapper prerel_car">
		<div class="carousel-inner">
			<div class="item active">
				<img src="<?php echo images_path("slider/slider.jpg");?>" alt="IMA Banners">
				<div class="carousel-caption">
					<h4 data-animation="animated flipInX">India Macro Advisors launched on May 12th 2017</h4>
					<a class="btn btn-primary btn-sm btn_carhom yt_videos" data-toggle="modal" href="https://www.youtube.com/embed/_4RA3oRRbho" data-target=".jma_modvid">
						<span class="btn_carporate">
							<i class="fa fa-youtube-play"></i>Introduction to IMA
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if(thisController()=='mycharts'){ ?>
	<div class="mycha_banner">
		<div class="color_overlayd"></div>
		<div class="container">
			<div class="col-xs-12 col-md-6">
				<div class="mc_desktop">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe src="https://www.youtube.com/embed/_4RA3oRRbho?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
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
	<?php echo $__env->make('templates.left_navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->yieldContent('content'); ?>
</section>
<?php echo $__env->make('templates.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('templates.all_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript">
//script
if ( !("placeholder" in document.createElement("input")) ) {
	$("input[placeholder], textarea[placeholder]").each(function() {
		var val = $(this).attr("placeholder");
		if ( this.value == "" ) {
			this.value = val;
		}
		$(this).focus(function() {
			if ( this.value == val ) {
				this.value = "";
			}
		}).blur(function() {
			if ( $.trim(this.value) == "" ) {
				this.value = val;
			}
		});
	});
// Clear default placeholder values on form submit
$('form').submit(function() {
	$(this).find("input[placeholder], textarea[placeholder]").each(function() {
		if ( this.value == $(this).attr("placeholder") ) {
			this.value = "";
		}
	});
});
}
</script>
<script>
window.Laravel = <?php echo json_encode([
	'csrfToken' => csrf_token(),
	]); ?>
</script>
<script type="text/javascript">
$('iframe').load(function(){
var ht=$(this).contents().height(); //alert($('iframe').contents().height() + 'is the height');
//document.getElementById('frame').height= (ht) + "px";
this.style.height = (ht) + "px";
//if(ht>495)
//{
//$(this).css("height",ht);
//}
});
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36471452-1']);
_gaq.push(['_trackPageview']);
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<script>
var objectParams = {
	myChart : {
		folderList : <?php echo isset($menu_items['folderList'])?json_encode($menu_items['folderList']):json_encode(array());?>,
	}
};
var require = {
	config: {
		'main': { 
			baseURLs: '<?php echo url('/'); ?>/',
			controller: '<?php echo thisController(); ?>',
			action: '<?php echo thisMethod(); ?>',
			parameter: '<?php  echo is_array(app('request')->route()->parameters()) ? implode('/', array_values(app('request')->route()->parameters())):'';?>',
			hosts: '<?php echo isset($_SERVER['HTTPS']) ? 'https' : 'http'?>',
			mychartObj: objectParams,
			sessionUser : <?php echo isset($_SESSION['user'])?json_encode($_SESSION['user']):json_encode(array());?>,
			countryCode : '<?php  echo isset($result['userdetails']['country_code'])?$result['userdetails']['country_code']:''; ?>',
			<?php if(thisController()== 'user' || thisController()== 'dopayment'){?>
				StripKeys : '<?php  echo isset($result['stripe_publish_key'])?$result['stripe_publish_key']:''; ?>'
				<?php } ?> 
				
			}
		}
	};
	</script>
	<script src="<?php echo env('APP_URL'); ?>assets/js/require.js"></script>
	<script>
	<?php if(thisController() != 'products' && thisMethod() != 'offerings'){?>
		var fileload = null
		<?php if(thisController()== 'home'){?> fileload = 'home'; <?php } ?>
		<?php if(thisController()== 'user' && thisMethod() != 'dopayment'){?> fileload = 'user'; <?php } ?>
		<?php if(thisController()== 'user' && thisMethod() == 'dopayment'){?>  fileload = 'userdopayment'; <?php } ?>
		<?php if(thisController()== 'contact' || thisController()== 'products'){?> fileload = 'contact'; <?php } ?>
		<?php if(thisController()== 'aboutus'){?> fileload = 'aboutus'; <?php } ?>
		<?php if(thisController()== 'mycharts'){?> fileload = 'mycharts'; <?php } ?>
		<?php if(thisController()== 'page'){?> fileload = 'page'; <?php } ?>
		<?php if(thisController()== 'reports'){?> fileload = 'reports'; <?php } ?>
		<?php if(thisController()== 'offerings' && thisMethod() == 'dopayment'){?> fileload = 'reports'; <?php } ?>
		if(fileload == null) { fileload = 'main'}
			require.config({
				paths: {
					"main": "<?php echo env('APP_URL'); ?>assets/js/"+fileload,
				}
			});
		require(["main"]);

		<?php } ?>	
		</script>
		</html>