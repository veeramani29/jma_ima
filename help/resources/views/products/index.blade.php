@extends('templates.default')
@section('content')
<?php 
$user_details=$result['request']['info'];
#echo '<pre>';
#print_r($result);
?>

<div class="col-xs-12 col-md-10">
	<div class="row">
		<div class="col-xs-12">
			<div class="main-title">
				<h1>JMA Subscription Package</h1>
				<div class="mttl-line"></div>
			</div>
		</div>
		<!-- <div class="col-md-4 col-sm-6 col-xs-12">
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
						<li class="price_innttl">
							Published research
						</li>
						<li>
							<div class='fa fa-check'></div>
							Indicator commentaries ( limited<sup> *2</sup> )
						</li>
						<li>
							<div class='fa fa-close'></div>
							Thematic reports/Economic forecasts
						</li>
						<li>
							<div class='fa fa-close'></div>
							Monthly Chartbook 
						</li>
						<li>
							<div class='fa fa-close'></div>
							Yield Curve scenario projection
						</li>						
						<li class="price_innttl">
							Data and chartbook creation
						</li>
						<li>
							<div class='fa fa-close'></div>
							Download of government statistics
						</li>
						<li>
							<div class='fa fa-close'></div>
							Download of proprietary statistics
						</li>
						<li>
							<div class='fa fa-check'></div>
						 	Save your charts/tables ( limited<sup> *3</sup> )
						</li>
						<li>
							<div class='fa fa-close'></div>
						 	Save your charts/tables
						</li>
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-close'></div>
							Data inquiry <sup>*4</sup>
						</li>
						<li>
							<div class='fa fa-close'></div>
							Monthly webinar
						</li>
						<li>
							<div class='fa fa-close'></div>
						 	Research consultation
						</li>
						<li>
							<div class='fa fa-close'></div>
							Meetings with our economists
						</li>
					</ul>					
					<?php if(Session::has('user')){ 
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
		</div> -->
		<div class="col-sm-6 col-xs-12">
			<div class='pricing pricing_premium'>
				<div class='thumbnail'>
					<span>
						<i class="fa fa-user" ></i>
						<sup><i class="fa fa-star fa-fw"></i></sup>
					</span>
				</div>
				<div class='title'>
					Standard Subscription
				</div>
				<div class='content'>
					<div class='sub-title'>
						USD 100
						/ month <sup>*1</sup>
						<span>(One month free trial)</span>
					</div>
					<ul>						
						<li class="price_innttl">
							Published research
						</li>
						<li>
							<div class='fa fa-check'></div>
							Indicator commentaries
						</li>
						<li>
							<div class='fa fa-check'></div>
							Thematic reports
						</li>
						<!-- <li>
							<div class='fa fa-check'></div>
							Monthly Chartbook
						</li> -->
					<!-- 	<li>
							<div class='fa fa-close'></div>
							Yield Curve scenario projection 
						</li> -->
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
						<!-- <li>
							<div class='fa fa-check'></div>
							Save your charts/tables
						</li> -->
						<li class="price_innttl">
							Support and consulting services
						</li>
						<li>
							<div class='fa fa-check'></div>
							Data inquiry <!-- <sup>*2</sup> -->
						</li>
						<!-- <li>
							<div class='fa fa-check'></div>
							Monthly webinar
						</li> -->
						<li>
							<div class='fa fa-close'></div>
							Research consultation
						</li>
						<li>
							<div class='fa fa-close'></div>
							Meetings with our economists
						</li>
						<!-- <li class="price_innsubs">
							Monthly <span>Auto-Renewable</span>
						</li> -->
					</ul>
					<?php if(Session::has('user')){ 
						if($user_details['user_status']=='active' && $user_details['user_type']=='free'){ ?>
						<button class="form_submit btn btn-primary"  onclick="location.href='<?php echo url("user/user_type_upgrade");?>';">UPGRADE</button> 
						<?php } elseif($user_details['user_status']=='active' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button> 
						<?php }elseif($user_details['user_status']=='trial' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" disabled="disabled">REGISTERED</button>
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='corporate'){ ?>
						<?php } } else{ ?>
						<button class="form_submit btn btn-primary" onclick="location.href='<?php echo url("user/signup?pre_info=y")?>';">REGISTER</button>
						<?php 
					} ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-xs-12">
			<div class='pricing pricing_corporate'>
				<div class='thumbnail'>
					<i class="fa fa-building" aria-hidden="true"></i>
				</div>
				<div class='title'>
					Corporate Subscription
				</div>
				<div class='content'>
					<div class='sub-title'>
						USD 1000
						/ month <sup>*1</sup>
					</div>
					<ul>						
						<li class="price_innttl">
							Published research
						</li>
						<li>
							<div class='fa fa-check'></div>
							Indicator commentaries
						</li>
						<li>
							<div class='fa fa-check'></div>
							Thematic reports
						</li>
						<!-- <li>
							<div class='fa fa-check'></div>
							Monthly Chartbook
						</li> -->
						<!-- <li>
							<div class='fa fa-check'></div>
							Yield Curve scenario projection 
						</li> -->
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
						<!-- <li>
							<div class='fa fa-check'></div>
							Save your charts/tables
						</li> -->
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
						<!-- <li>
							<div class='fa fa-check'></div>
							Monthly webinar
						</li> -->
						<li>
							<div class='fa fa-check'></div>
							Research consultation
						</li>
						<li>
							<div class='fa fa-check'></div>
							Meetings with our economists
						</li>
						<!-- <li class="price_innsubs">
							Quarterly <span>Renewable</span>
						</li> -->
					</ul>
					<?php if(Session::has('user')){
						if($user_details['user_status']=='active' && $user_details['user_type']=='free'){ ?>
						<button class="form_submit btn btn-primary" <?php echo (Session::has('user') && $user_details['user_upgrade_status'] == 'RC')?"disabled":"";?> onclick="location.href='<?php echo url("user/user_request_info/");?>';">REQUEST INFO</button> 
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" <?php echo (Session::has('user') && $user_details['user_upgrade_status'] == 'RC')?"disabled":"";?>  onclick="location.href='<?php echo url("user/user_request_info/");?>';">REQUEST INFO</button> 
						<?php }elseif($user_details['user_status']=='trial' && $user_details['user_type']=='individual'){ ?>
						<button class="form_submit btn btn-primary" <?php echo (Session::has('user') && $user_details['user_upgrade_status'] == 'RC')?"disabled":"";?> onclick="location.href='<?php echo url("user/user_request_info/");?>';">REQUEST INFO</button> 
						<?php }elseif($user_details['user_status']=='active' && $user_details['user_type']=='corporate'){ ?>
						<?php } } else{ ?>
						<button class="form_submit btn btn-primary"  onclick="location.href='<?php echo url("user/signup?co_info=y")?>';">REQUEST INFO</button> 
						<?php 
					} ?>
				</div>
			</div>
		</div>
		<div class="col-xs-12 pripag_infocon">
			<div class="alert alert-info" role="alert">
				<ul class="list-unstyled">
					<li>*1: Including VAT if you reside in Japan.</li>
					<li>*2: Our research assistants are happy to help our Standard account users where to find data they are looking for.</li>
					<li>*3: Our research assistants can help locate and prepare data for our Corporate clients.</li>
				</ul>
			</div>
		</div>
	</div>

</div>
@stop