<?php $__env->startSection('content'); ?>
<?php 
$user_details=$result['request']['info'];
?>
<div class="col-xs-12 col-md-10">
	<div class="row">
		<div class="col-xs-12">
			<div class="main-title">
				<h1>IMA Subscription Package</h1>
				<div class="mttl-line"></div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="subsfree_container">
				<h4>To enjoy our services free of cost please register with us</h4>
				<a class="btn btn-primary form_submit" href="user/signup"><i class="fa fa-play-circle"></i>&nbsp;REGISTER FREE</a>
			</div>
		</div>
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
						No fees at all!
					</div>
					<ul>
						<li>
							<div class='fa fa-check'></div>
							Regularly updated economic data
						</li>
						<li>
							<div class='fa fa-check'></div>
							Timely commentary on economic data
						</li>
						<li>
							<div class='fa fa-check'></div>
							Interactive charts and free unlimited data download
						</li>
						<li class="price_innttl">
							Data and charts functions
						</li>
						<li>
							<div class='fa fa-check'></div>
							Export charts in different formats for upto 3 times
						</li>
						<li>
							<div class='fa fa-check'></div>
							Save up to 4 folders in "My Charts"
						</li>
						<li>
							<div class='fa fa-check'></div>
							Store up to 4 charts each in “My Charts” folders
						</li>
						<li>
							<div class='fa fa-check'></div>
							Download your created Chartbook as PowerPoint up to One time
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
					<button class="btn btn-primary form_submit" onclick="location.href='user/signup';">REGISTER</button> 
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
						Monthly fees of USD 5/ INR 300
					</div>
					<ul>
						<li>
							<div class='fa fa-check'></div>
							Regularly updated economic data
						</li>
						<li>
							<div class='fa fa-check'></div>
							Timely commentary on economic data
						</li>
						<li>
							<div class='fa fa-check'></div>
							Interactive charts and free unlimited data download
						</li>
						<li class="price_innttl">
							Data and charts functions
						</li>
						<li>
							<div class='fa fa-check'></div>
							Unlimited export of charts in all formats
						</li>
						<li>
							<div class='fa fa-check'></div>
							Save unlimited folders in “My Charts” folder
						</li>
						<li>
							<div class='fa fa-check'></div>
							Store unlimited charts in the “My Charts” folder
						</li>
						<li>
							<div class='fa fa-check'></div>
							Download your created chartbook as PowerPoint unlimited times
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
					<button class="form_submit btn btn-primary" onclick="location.href='user/signup?pre_info=y';">REGISTER</button>
					<?php } ?>
				</div>
			</div>
		</div>
		<!-- <div class="col-xs-12 pripag_infocon">
			<div class="alert alert-info" role="alert">*Including VAT if you reside in India</div>
		</div> -->
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>