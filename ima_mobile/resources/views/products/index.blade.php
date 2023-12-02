@extends('templates.default')
@section('content')
<?php 
$user_details=$result['request']['info'];
?>
<div class="col-xs-12">
	<div class="row">
		<div class="col-xs-12">
			<div class="main-title">
				<h1>IMA Subscription Package</h1>
				<div class="mttl-line"></div>
			</div>
		</div>
		<?php if(!isset($_SESSION['user'])) {?>
		<div class="col-xs-12">
			<div class="subsfree_container">
				<h4>To enjoy our services please register with us using the options below</h4>
			</div>
		</div>
		<?php }?>
		<div class="col-md-6 col-xs-12">
			<div class='pricing pricing_free'>
				<div class='thumbnail'>
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class='titlefree'>
					Free Subscription
				</div>
				<div class='content'>
					<div class='sub-title'>
						No fee at all!
					</div>
					<ul>
						<li class="price_innttl">
							Data and Chartbook creation
						</li>
						<li>
							<div class='fa fa-check'></div>
							Download macroeconomic statistics
						</li>
						<li>
							<div class='fa fa-close'></div>
							Download proprietary statistics (example- computed seasonally adjusted series)
						</li>
						<li>
							<div class='fa fa-check'></div>
							Save your charts/tables (*1)
						</li>
						<li class="price_innttl">
							Published Research
						</li>
						<li>
							<div class='fa fa-check'></div>
							Regular commentary on data/policy change
						</li>
						<li>
							<div class='fa fa-close'></div>
							Thematic Reports
						</li>
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-close'></div>
							Data request/inquiry (*2)
						</li>
						<li>
							<div class='fa fa-close'></div>
							Research request (*3)
						</li>
					</ul>
					<?php if(isset($_SESSION['user'])){ 
						if($user_details['user_status']=='active' && $user_details['user_type']=='free'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php }elseif($user_details['user_status']=='trial' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php } 
					} else { ?>
					<button class="btn btn-primary form_submit" onclick="location.href='<?php echo url("user/signup")?>';">REGISTER</button> 
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class='pricing pricing_premium'>
				<div class='thumbnail'>
					<span>
						<i class="fa fa-user" ></i>
						<sup><i class="fa fa-star fa-fw"></i></sup>
					</span>
				</div>
				<div class='title'>
					Premium Subscription
				</div>
				<div class='content'>
					<div class='sub-title'>
						Monthly fee of INR 799
					</div>
					<ul>
						<li class="price_innttl">
							Data and Chartbook creation
						</li>
						<li>
							<div class='fa fa-check'></div>
							Download macroeconomic statistics
						</li>
						<li>
							<div class='fa fa-check'></div>
							Download our proprietary statistics (example- computed seasonally adjusted series)
						</li>
						<li>
							<div class='fa fa-check'></div>
							Save your charts/tables (up to 2000 charts)
						</li>
						<li class="price_innttl">
							Published Research
						</li>
						<li>
							<div class='fa fa-check'></div>
							Regular commentary on data/policy change
						</li>
						<li>
							<div class='fa fa-check'></div>
							Thematic Reports
						</li>
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-check'></div>
							Data request/inquiry (*2)
						</li>
						<li>
							<div class='fa fa-check'></div>
							Research request (*3)
						</li>
					</ul>
					<?php if(isset($_SESSION['user'])){ 
						if($user_details['user_status']=='active' && $user_details['user_type']=='free'){ ?>
						<button class="form_submit btn btn-primary"  onclick="location.href='<?php echo url("user/user_type_upgrade");?>';">UPGRADE</button> 
						<?php } elseif($user_details['user_status']=='active' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button> 
						<?php }elseif($user_details['user_status']=='trial' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php } 
					} else{ ?>
					<button class="form_submit btn btn-primary" onclick="location.href='<?php echo url("user/signup?pre_info=y")?>';">REGISTER</button>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<blockquote class="b-primary pro_blo">
				<small>Note</small>
				<ul class="list-unstyled">
					<li>*1: We currently allow free users to save up to 4 charts/tables</li>
					<li>*2: Our research assistants are happy to help our Premium account users where to find data they are looking for.</li>
					<li>*3: Our research assistants can help locate and prepare data for our Premium account users</li>
				</ul>
			</blockquote>
		</div>
		<!-- <div class="col-xs-12 pripag_infocon">
			<div class="alert alert-info" role="alert">*Including VAT if you reside in India</div>
		</div> -->
	</div>
</div>
@stop