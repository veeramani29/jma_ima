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
	<meta name="description" content="<?php echo $this->resultSet['meta']['description'];?>">
	<meta name="keywords" content="<?php echo $this->resultSet['meta']['keywords'];?>">
	<meta name="google-translate-customization" content="1fea04e055fb6965-35248e5248638537-g6177b01b3439e3b2-16">
	<meta property="og:image:width" content="640" />
	<meta property="og:image:height" content="360" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="http://content.japanmacroadvisors.com/images/japan-macro-advisors.png" />
	<meta property="og:site_name" content="japanmacroadvisors.com" />
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" />
	<meta property="og:title" content="<?php echo !isset($this->resultSet['meta']['shareTitle']) ? 'Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $this->resultSet['meta']['shareTitle']; ?>" />
	<meta property="og:description" content="<?php echo $this->resultSet['meta']['description'];?>" />
	<meta property="fb:app_id" content="1597539907147636" />
	<title><?php echo !isset($this->pageTitle) ? 'Japan Economy, Macro economy, Japan GDP, Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : str_replace("|",",",$this->pageTitle); ?></title>
	<base href="<?php echo $this->rootPath; ?>">
	<link rel="shortcut icon" href="favicon.ico" type="image/icon">
	<link rel="icon" href="favicon.ico" type="image/icon">

	<?php if(Config::read('environment')=='development') { ?>

	<!-- fontawesome -->
	<link rel="stylesheet" type="text/css"  href="<?php  echo $this->assets."plugins/font-awesome/css/font-awesome.min.css";?>">
	<!-- bootstrap -->
	<link rel="stylesheet" type="text/css"  href="<?php  echo $this->assets."plugins/bootstrap/css/bootstrap.min.css";?>">
	<!-- jquery ui -->
	<link rel="stylesheet" type="text/css"  href="<?php  echo $this->assets."plugins/jquery-ui/jquery-ui.min.css";?>">
	<!-- animate -->
	<link rel="stylesheet" type="text/css"  href="<?php echo $this->assets."plugins/animate/animate.min.css";?>">
	<!-- plugin or other css -->
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assets."css/intlTelInput.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assets."css/jquery.alerts.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assets."css/ken-burns.css";?>" />
	<!-- custom css files -->
	<link  rel="stylesheet" type="text/css" href="<?php echo $this->assets."css/custom-styles.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assets."css/media.css";?>" />
	<script type="text/javascript" src="<?php echo $this->javascript."jquery.min.js";?>" ></script>


	<?php }else { ?>

	<script type="text/javascript" src="<?php echo $this->assets."builds/bundle.js";?>" ></script>

	<?php } ?>

	
	<?php echo $this->getAllCss(); ?>
	
</head>
<body >
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
	<header>
		<div class="mob_menubgoverlay"></div>
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
					<a class="navbar-brand" href="<?php echo $this->url('/');?>">
						<img alt="Japan GDP Economy" src="<?php echo $this->images;?>logo.png" >
					</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="mainNav">
					<ul class="nav navbar-nav navbar-right">
						<li class="<?php echo ($this->controllername=='home')?'active':'';?>"><a href="<?php echo $this->url('/');?>" class="top_link_common">Home</a></li>
						<li class="<?php echo ($this->controllername=='aboutus' && $this->actionname=='index')?'active':'';?>"><a href="<?php echo $this->url('aboutus');?>" class="top_link_common">About us</a></li>
						<li class="<?php echo ($this->controllername=='products')?'active':'';?>"><a href="<?php echo $this->url('products');?>" class="top_link_common">Products</a></li>
						<!-- <li><a href="<?php // echo $this->url('careers');?>"class="top_link_common">Careers</a></li> -->
						<li class="<?php echo ($this->controllername=='contact')?'active':'';?>"><a href="<?php echo $this->url('contact');?>" class="top_link_common">Contact</a></li>
						<li class="<?php echo ($this->actionname=='privacypolicy')?'active':'';?>"><a href="<?php echo $this->url('aboutus/privacypolicy');?>" class="top_link_common">Our Privacy Policy</a></li>
						<li class="<?php echo ($this->actionname=='commercial_policy')?'active':'';?>"><a href="<?php echo $this->url('aboutus/commercial_policy');?>" class="top_link_common">Commercial Policy </a></li>
						<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {?>
						<li class="jma_username">
							<a href="<?php echo $this->url('user/myaccount');?>" class="top_link_common">
								<font color="red"><?php echo ucfirst($_SESSION['user']['fname']).' '.$_SESSION['user']['lname'];?></font>
							</a>
						</li>
						<li class="last"><a href="<?php echo $this->url('user/logout');?>" class="top_link_common">Signout</a></li>
						<?php } else {?>
						<li class="last" id="lnk_client_login"><a href="<?php echo $this->url('user/login');?>" class="top_link_client_login">USER LOGIN</a></li>
						<?php }?>
					</ul>
					<?php  include ('view/templates/responsive_navigation.php');?>
					<ul class="nav navbar-nav mob_navsec">
						<li class="<?php echo ($this->controllername=='aboutus' && $this->actionname=='index')?'active':'';?>"><a href="<?php echo $this->url('aboutus');?>" class="top_link_common">About us</a></li>
						<li class="<?php echo ($this->controllername=='products')?'active':'';?>"><a href="<?php echo $this->url('products');?>" class="top_link_common">Products</a></li>
						<li class="<?php echo ($this->controllername=='contact')?'active':'';?>"><a href="<?php echo $this->url('contact');?>" class="top_link_common">Contact</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	</header>
	<section>
		<?php if($this->controllername=='home'){
			$home_classes = 'kb_elastic animate_text kb_wrapper';	
		} ?>
		<?php if($this->controllername!='products'){ ?>
		<div id="carousel_home" class="carousel slide carousel_home <?php if($home_classes){ echo $home_classes; } ?>" data-ride="carousel">
			<?php if($this->controllername=='home'){ $Bancount=3;$smallBan_Name='slider'; ?>
			<?php }else{
				$Bancount=1;
				$smallBan_Name='smallslider';
			}?>
			<!-- Wrapper for slides -->
			<div class="carousel-inner <?php echo $smallBan_Name;?>" role="listbox">
				<div class="item active">
					<?php if($this->controllername=='home'){
					//<img alt="Japanese Economy" src="http://res.cloudinary.com/jma-mobile/image/upload/<?php echo $smallBan_Name.($b+1);.jpg" >
						echo cl_image_tag($smallBan_Name.(1).".jpg",
							array( "alt" => "Japanese Economy","secure" => "true" ));
						}else { ?>
						<img alt="Japanese Economy" src="<?php echo $this->images;?>slider/<?php echo $smallBan_Name.(1);?>.jpg" >
						<?php } ?>
						<div class="carousel-caption">
							<h4 data-animation="animated flipInX">CONCISE AND INSIGHTFUL ANALYSIS ON THE JAPANESE ECONOMY</h4>
							<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) { ?>
							<a class="btn btn-primary btn-sm btn_carhom" href=<?php echo $this->url('user/myaccount/subscription');?>>
								<?php if ($_SESSION['user']['user_type'] == 'corporate') { ?>
								<span class="btn_carporate">
									<i class="fa fa-building fa-lg"></i>&nbsp;<strong>Corporate</strong>
								</span>
								<?php } ?>
								<?php if ($_SESSION['user']['user_type'] == 'individual') {?>
								<span class="btn_premium">
									<i class="fa fa-user fa-lg"></i>
									<sup><i class="fa fa-star fa-fw"></i></sup>
									Premium
								</span>
								<?php } ?>
								<?php if ($_SESSION['user']['user_type'] == 'free') {?>
								<span>
									<i class="fa fa-user fa-lg"></i>
									&nbsp;<strong>Free</strong>
								</span>
								<?php } ?>
							</a>
							<?php }else{ ?>
							<a class="btn btn-primary btn-sm btn_carhom" href="<?php echo $this->url('user/signup');?>">
								<i class="fa fa-play-circle"></i>
								Register for a Free account
							</a>
							<?php   } ?>
							<a class="btn btn-primary btn-sm btn_carhom" target="_blank" href=<?php echo $this->url('products/offerings');?>>
								<span class="btn_carporate">
									<i class="fa fa-hand-o-right"></i>What We Offer
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<!-- product page banner -->
			<?php if($this->controllername=='products' && $this->actionname=='index'){ ?>
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
								<a class="btn btn-primary btn-sm btn_carhom" href="<?php echo $this->url('products/offerings');?>">
									Read More <i class="fa fa-arrow-right" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php if($this->controllername=='products' && $this->actionname=='about_premium_user'){ ?>
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
								<h1>JMA Premium $30/month</h1>
								<div class="mttl-line"></div>
							</div>
							<p>Unlimited Chart saving.</p>
							<p>Monthly Chart book.</p>
							<p>Premium Data.</p>
							<p>Premium Report</p>
							<p class="last">Contact us or post any query.</p>
							<div class="text-center">
								<a class="btn btn-primary btn-sm btn_carhom" href="<?php echo $this->url('products/offerings');?>">
									Go Premium <i class="fa fa-arrow-right" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-xs-12 text-center">
						<div class="apu_free">
							<h1>Free Trail</h1>
							<h3>Limited Offer 3 months free trail to experience premium services</h3>
							<a class="btn btn-primary btn-sm" href="">Try Free Now <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
			<?php   } ?>
		</section>
		
		<section class="container">
			<?php  include ('view/templates/left_navigation.php');?>
			<?php $this->view (); ?>
		</section>
		<?php include ('view/templates/footer.php');?>
		<?php  $highstock_src_=array('page','news','reports','mycharts','home');
		if(in_array($this->controllername, $highstock_src_)){
			include ('view/templates/script_template.php');
		}
		?>
		<!-- All Modal Start -->
		<?php include ('view/templates/all_modal.php');?>
		<!-- All Modal End -->
	</body>
	</html>