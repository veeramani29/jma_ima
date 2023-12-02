<?php 
$user_details=$this->resultSet['result']['request']['info'];
//echo '<pre>';
//print_r($user_details);
?>

<div class="col-xs-12 col-md-10">
	<div class="row">
		<div class="col-xs-12">
			<div class="main-title">
				<h1>JMA Subscription Package</h1>
				<div class="mttl-line"></div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
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
							Regular commentary on economic data
						</li>
						<li>
							<div class='fa fa-check'></div>
							Timely updates on breaking news
						</li>
						<li>
							<div class='fa fa-check'></div>
							Thematic reports/Economic forecasts
						</li>
						<li class="price_innttl">
							Data and charts functions
						</li>
						<li>
							<div class='fa fa-check'></div>
							Create your own chart folder with up to 4 charts
						</li>
						<li>
							<div class='fa fa-close'></div>
							Create your own chart folder with up to 2000 charts
						</li>
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-close'></div>
							Research consultation
						</li>
						<li>
							<div class='fa fa-close'></div>
							Meetings/seminars with our economists
						</li>
						<li>
							<div class='fa fa-close'></div>
							Corporate plan includes 10 individual accounts
						</li>
						<li class="price_innsubs">
							Unlimited period
						</li>
					</ul>
					<?php if(isset($_SESSION['user'])){ 
						if($user_details['user_status']=='active' && $user_details['user_type']=='free'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php }elseif($user_details['user_status']=='trial' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='corporate'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php } }else{ ?>
						<button class="btn btn-primary form_submit" onclick="location.href='user/signup';">REGISTER</button> 
						<?php 
					} ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
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
						JPY 3500
						<i>month*</i>
						<span>(One Month free trial)</span>
					</div>
					<ul>
						<li>
							<div class='fa fa-check'></div>
							Regular commentary on economic data
						</li>
						<li>
							<div class='fa fa-check'></div>
							Timely updates on breaking news
						</li>
						<li>
							<div class='fa fa-check'></div>
							Thematic reports/Economic forecasts
						</li>
						<li class="price_innttl">
							Data and charts functions
						</li>
						<li>
							<div class='fa fa-check'></div>
							Create your own chart folder with up to 4 charts
						</li>
						<li>
							<div class='fa fa-check'></div>
							Create your own chart folder with up to 2000 charts
						</li>
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-check'></div>
							Research consultation
						</li>
						<li>
							<div class='fa fa-close'></div>
							Meetings/seminars with our economists
						</li>
						<li>
							<div class='fa fa-close'></div>
							Corporate plan includes 10 individual accounts
						</li>
						<li class="price_innsubs">
							Monthly <span>Auto-Renewable</span>
						</li>
					</ul>
					<?php if(isset($_SESSION['user'])){ 
						if($user_details['user_status']=='active' && $user_details['user_type']=='free'){ ?>
						<button class="form_submit btn btn-primary"  onclick="location.href='<?php echo $this->url("user/user_type_upgrade");?>';">UPGRADE</button> 
						<?php } elseif($user_details['user_status']=='active' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button> 
						<?php }elseif($user_details['user_status']=='trial' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='corporate'){ ?>
						<?php } } else{ ?>
						<button class="form_submit btn btn-primary" onclick="location.href='user/signup?pre_info=y';">REGISTER</button>
						<?php 
					} ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class='pricing pricing_corporate'>
				<div class='thumbnail'>
					<i class="fa fa-building" aria-hidden="true"></i>
				</div>
				<div class='title'>
					Corporate Subscription
				</div>
				<div class='content'>
					<div class='sub-title'>
						USD 800
						<i>month*</i>
						<span>(10 Premium Accounts)</span>
					</div>
					<ul>
						<li>
							<div class='fa fa-check'></div>
							Regular commentary on economic data
						</li>
						<li>
							<div class='fa fa-check'></div>
							Timely updates on breaking news
						</li>
						<li>
							<div class='fa fa-check'></div>
							Thematic reports/Economic forecasts
						</li>
						<li class="price_innttl">
							Data and charts functions
						</li>
						<li>
							<div class='fa fa-check'></div>
							Create your own chart folder with up to 4 charts
						</li>
						<li>
							<div class='fa fa-check'></div>
							Create your own chart folder with up to 2000 charts
						</li>
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-check'></div>
							Research consultation
						</li>
						<li>
							<div class='fa fa-check'></div>
							Meetings/seminars with our economists
						</li>
						<li>
							<div class='fa fa-check'></div>
							Corporate plan includes 10 individual accounts
						</li>
						<li class="price_innsubs">
							Quarterly <span>Renewable</span>
						</li>
					</ul>

					<?php if(isset($_SESSION['user'])){
						if($user_details['user_status']=='active' && $user_details['user_type']=='free'){ ?>
						<button class="form_submit btn btn-primary" <?php echo (isset($_SESSION['user']) && $user_details['user_upgrade_status'] == 'RC')?"disabled":"";?> onclick="location.href='<?php echo $this->url("user/user_request_info/");?>';">REQUEST INFO</button> 
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" <?php echo (isset($_SESSION['user']) && $user_details['user_upgrade_status'] == 'RC')?"disabled":"";?>  onclick="location.href='<?php echo $this->url("user/user_request_info/");?>';">REQUEST INFO</button> 
						<?php }elseif($user_details['user_status']=='trial' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" <?php echo (isset($_SESSION['user']) && $user_details['user_upgrade_status'] == 'RC')?"disabled":"";?> onclick="location.href='<?php echo $this->url("user/user_request_info/");?>';">REQUEST INFO</button> 

						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='corporate'){ ?>
						<?php } } else{ ?>
						<button class="form_submit btn btn-primary"  onclick="location.href='user/signup?co_info=y';">REQUEST INFO</button> 
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 pripag_infocon">
				<div class="alert alert-info" role="alert">*Including VAT if you reside in Japan</div>
			</div>
		</div>

	</div>