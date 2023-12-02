<!-- Login Modal Start -->
<div class="modal fade" id="Dv_modal_login-bf" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="pull-left">
					<h4 class="modal-title">Subscribe to Standard Account</h4>
				</div>
				<!-- <ul class="list-inline list_sigmod">
					<li>
						<div class="download-img" >
							<i class="fa fa-user fa-lg color-green"></i><b>FREE</b>
						</div>
					</li>
					<li>
						<div class="premium-img color-blue icon-sup">
							<i class="fa fa-user fa-lg"></i>
							<sup>
								<i class="fa fa-star fa-fw"></i>
							</sup>
							<b>STANDARD</b>
						</div>
					</li>
					<li>
						<div class="premium-img">
							<i class="fa fa-building fa-lg"
							style="color: #22558F;"></i><b>CORPORATE</b>
						</div>
					</li>
				</ul> -->
			</div>
			<div class="modal-body">
				<form name="login_frm_ajx" id="login_frm_ajx_" class="signup_frm" action="<?php echo url('/user/login');?>" method="post">
					<input type="hidden" name="_token" value="<?php echo csrf_token();?>">
					<!-- <div class="text-center form-group mychart">
						<p>
							This feature is restricted <b>for logged-in users only.</b> <br> 
							If you are a FREE / STANDARD / CORPORATE account user, please log-in.<br>
						</p>
					</div> -->
					<div class="form-group premium">
						<!-- <p>If you are a STANDARD / CORPORATE account user, please log-in. </p> -->
						<h5 class="mart0 text-center">Register for 30 days free trial</h5>
						<!-- <ul class="list-unstyled li_list">
							<li><i class='fa fa-check'></i>Costs USD 100/month</li>
							<li><i class='fa fa-check'></i>Start with a free trial for 30 days</li>
							<li><i class='fa fa-check'></i>Monthly payments start after the trial period ends.</li>
						</ul> -->
						<div class="text-center">
							<a href="<?php echo url('products');?>" class="btn btn-success">Proceed to free 30-days trial</a>
						</div>
						<br>
						<?php $popup_link_url="href='javascript:JMA.User.showLoginBox(".'"premium","'.url()->current().'"'.");'";
						?>
						<p>If you are already a Standard Account subscriber you can login <a  <?php echo $popup_link_url;?>><b>here</b> </a> </p>
						<p>
							For more details on our products, click <a target="_blank" href="<?php echo url('products');?>"><b>here</b> </a>
						</p>
					</div>
				<!-- 	<div class="text-center form-group download">
						<p>Please log-in to access our <b>data download function.</b><br></p>
					</div> -->
					<!-- <div class="text-center form-group">
						<a href="<?php echo url('user/linkedinProcess');?>" class="linkedIn">
							<img alt="JMA Linkedin Login" src="<?php echo images_path('sign-in-with-linkedin.png');?>" />
						</a>
					</div>
					<div class="sinup_orcon"><p>OR</p></div>
					<p class="login_frm_ajx_login_status text-center text-danger" style="font-size: 12px;display: none;"></p>
					<div class="form-group col-xs-12 col-sm-6 sm-pad padl0"> -->
						<!-- <label for="login_email" class="control-label visible-xs">&nbsp;</label>  -->
						<!-- <input class="form-control" placeholder="Email" name="login_email" id="login_email_">
					</div>
					<div class="form-group col-xs-12 col-sm-6 sm-pad padr0"> -->
						<!-- <label for="login_password" class="control-label visible-xs">&nbsp;</label> -->
						<!-- <input type="password" class="form-control"  placeholder="Password" name="login_password" id="login_password_"  />
						<input type="hidden" name="chart_login_perm_type" id="chart_login_perm_type" >
						<input type="hidden" name="chart_login_chart_index" id="chart_login_chart_index">
						<input type="hidden" name="chart_login_premium_url" id="chart_login_premium_url">
					</div>
					<div class="full-width text-center marb20">
						<button type="button"  class="btn btn-primary btn-sm" name="login_btn" id="pop_login_btn">
							Submit
						</button>
						<a class="btn" id="SubmitForgotPss" href="<?php echo url('user/forgotpassword');?>">
							Forgot Password?
						</a>
					</div> -->
					<!-- <p class="premium-logininfo">
						<a href="<?php echo url('products');?>">Upgrade or Register for </a> STANDARD or CORPORATE account.
					</p> -->
					<!-- <p>
						Not registered?<br/>
						  
						Review our <a target="_blank" href="<?php echo url('products');?>"><b>product page</b> </a> to see what we offer
					</p> -->
					<!-- free existing users -->
					<div class="form-group mychart">
						<h5 class="mart0 text-center">Register for 30 days free trial</h5>
						<!-- <ul class="list-unstyled li_list">
							<li><i class='fa fa-check'></i>Costs USD 100/month</li>
							<li><i class='fa fa-check'></i>Start with a free trial for 30 days</li>
							<li><i class='fa fa-check'></i>Monthly payments start after the trial period ends.</li>
						</ul> -->
						<div class="text-center">
							<a href="<?php echo url('products');?>" class="btn btn-success">Proceed to free 30-days trial</a>
						</div>
						<br>
						<p>If you are already a Standard subscriber you can login <a target="_blank" href="<?php echo url('user/login');?>"><b>here</b> </a> </p>
						<p>For more details on our products, click <a target="_blank" href="<?php echo url('products');?>"><b>here</b> </a></p>
					</div>
				</form>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>
<!-- Login Modal End-->



<!-- Login Modal Start -->
<div class="modal fade" id="Dv_modal_login" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="pull-left">
					<h4 class="modal-title">Login</h4>
				</div>
				<!--  <ul class="list-inline list_sigmod">
					<li>
						<div class="download-img" >
							<i class="fa fa-user fa-lg color-green"></i><b>FREE</b>
						</div>
					</li>
					<li>
						<div class="premium-img color-blue icon-sup">
							<i class="fa fa-user fa-lg"></i>
							<sup>
								<i class="fa fa-star fa-fw"></i>
							</sup>
							<b>STANDARD</b>
						</div>
					</li>
					<li>
						<div class="premium-img">
							<i class="fa fa-building fa-lg"
							style="color: #22558F;"></i><b>CORPORATE</b>
						</div>
					</li>
				</ul>  -->
			</div>
			<div class="modal-body">
				<form name="login_frm_ajx" id="login_frm_ajx" class="signup_frm" action="<?php echo url('/user/login');?>" method="post">
					<input type="hidden" name="_token" value="<?php echo csrf_token();?>">
				 <div class="text-center form-group mychart">
						<p>
							This feature is restricted <b>for logged-in users only.</b> <br> 
							If you are a FREE / STANDARD account user, please log-in.<br>
						</p>
					</div> 
					<div class="form-group premium">
 <p class="text-center"> This feature is restricted to our subscribers. </p> 
						 <p class="text-center"> If you are already a JMA subscriber please login from below. </p> 
						
					</div>
				<div class="text-center form-group download">
						<p>Please log-in to access our <b>data download function.</b><br></p>
					</div> 
				  <div class="text-center form-group">
						<a href="<?php echo url('user/linkedinProcess');?>" class="linkedIn">
							<img alt="JMA Linkedin Login" src="<?php echo images_path('sign-in-with-linkedin.png');?>" />
						</a>
					</div>
					<div class="sinup_orcon"><p>OR</p></div>
					<p class="login_frm_ajx_login_status text-center text-danger" style="font-size: 12px;display: none;"></p>
					<div class="form-group col-xs-12 col-sm-6 sm-pad padl0"> 
					<label for="login_email" class="control-label visible-xs">&nbsp;</label> 
					 <input class="form-control" type="email" required="" placeholder="Email" name="login_email" id="login_email_">
					</div>
					<div class="form-group col-xs-12 col-sm-6 sm-pad padr0"> 
					 <label for="login_password"  class="control-label visible-xs">&nbsp;</label> 
					 <input type="password" required="" class="form-control"  placeholder="Password" name="login_password" id="login_password_"  />
						<input type="hidden" name="chart_login_perm_type" id="chart_login_perm_type" >
						<input type="hidden" name="chart_login_chart_index" id="chart_login_chart_index">
						<input type="hidden" name="chart_login_premium_url" id="chart_login_premium_url">
					</div>
					<div class="full-width text-center marb20">
						<button type="button"  class="btn btn-primary btn-sm" name="login_btn" id="pop_login_btn">
							Submit
						</button>
						<a class="btn" id="SubmitForgotPss" href="<?php echo url('user/forgotpassword');?>">
							Forgot Password?
						</a>
					</div> 
			<!-- 	<p class="premium-logininfo">
						<a href="<?php echo url('products');?>">Upgrade or Register for </a> STANDARD or CORPORATE account.
					</p>  -->
					 <p>
						Not yet a JMA subscriber ? &nbsp;
						  
						 <a target="_blank" class="btn btn-success" href="<?php echo url('products');?>"><b>Subscribe for free</b> </a> 
					</p> 
					<!-- free existing users -->
					<div class="form-group mychart">
						
					
						<!-- <br>
						<p>If you are already a Standard or Corporate Account subscriber you can login <a target="_blank" href="<?php echo url('user/login');?>"><b>here</b> </a> </p> -->
						
					</div>
				</form>
			</div>
		<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div> 
		</div>
	</div>
</div>
<!-- Login Modal End-->
<!-- Auto Login  Modal Start-->
<?php if(!Session::has('user') && (thisMethod()!='login' && thisMethod()!='premium_login')){?>
	<div class='popup'>
		<div class='cnt223'>
			<div class="POPUser">
				<i class="fa fa-user fa-lg"></i><?php echo 'User Login'; ?>
				<div  class='x' id='x'>
					<i class="fa fa-times" style="color: #EA2635"></i>
				</div>
			</div>
			<div id="Dv_login_wrapper">
				<form name="login_frm" id="login_frm_"
				action="<?php echo url('/user/login');?>" method="post">
				<input type="hidden" name="_token" value="<?php echo csrf_token();?>">
				<div class="login_box_input">
					<input type="text" placeholder="Email"
					class="formPop_textfield" name="login_email"
					id="login_email__" />
				</div>
				<div class="login_box_input">
					<input type="password" placeholder="password"
					class="formPop_textfield" name="login_password"
					id="login_password__" />
				</div>
				<div class="full-widthf">
					<label class="control control--checkbox"><?php echo 'Keep me signed in'; ?>
						<input type="checkbox" value="y" name="login_rememberMe" id="login_rememberMe_" checked/>
						<div class="control__indicator"></div>
					</label>
				</div>
				<div class="full-widthf text-center">
					<input type="submit" value="<?php echo 'Submit';?>" class="btn btn-primary btn-sm" name="login_btn"  />
				</div>
				<div class="ForPassword">
					<a href="<?php echo url('user/forgotpassword');?>"><?php echo 'Forgot your password?';?></a>
					</div>
				 <div class="sinup_orcon"><p>OR</p></div>
					<div class="chat_signlin">
						<a href="<?php echo url('user/linkedinProcess');?>">
							<img alt="JMA Linkedin Login" src="<?php echo images_path('sign-in-with-linkedin.png');?>" />
						</a>
					</div> 	
				</form>
			</div>
		</div>
	</div>
	<?php 
} ?>
<!-- Auto Login Modal End-->
<!-- Upgrade STANDARD Feature Modal Start-->
<div class="modal fade" id="Dv_modal_upgrade_premium_feature" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-warning premium" >Subscribe to Standard Account</h4>
				<h4 class="modal-title text-warning mychart">Upgrade to Standard Account</h4>
			</div>

			<div class="modal-body">
				<!-- <div class="row">
					<div class="col-xs-12 col-sm-3">
						<p class="text-center"><i class="fa fa-warning" style="font-size: 6em;line-height:2em;color: #FFA500;"></i></p>

					</div>
					<div class="col-xs-12 col-sm-9">
						<p><b> If you wish to save more than 4 charts, please review your subscription status in account details <a href="<?php echo url('user/myaccount/subscription');?>">here</a></b>. </p>
						<p>You can visit our <a target="_balnk" href="<?php echo url('product');?>">product page</a> for more details on what we offer</p>
						<p>We welcome any feedback you like to share with us at <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>. </p>
					</div>
				</div> -->
				<div class="form-group mychart">
					<p class="text-center">If you wish to save more than 4 charts, please upgrade to STANDARD account</p>
					<h5 class="mart0 text-center">Register for 30 days free trial</h5>
					<!-- <ul class="list-unstyled stareg_list">
						<li><i class='fa fa-check'></i>Costs USD 100/month</li>
						<li><i class='fa fa-check'></i>Start with a free trial for 30 days</li>
						<li><i class='fa fa-check'></i>Monthly payments start after the trial period ends.</li>
					</ul> -->
					<div class="text-center">
					<?php if(Session::has('user')){  ?>
						<a href="<?php echo url('user/myaccount/subscription');?>" class="btn btn-success">Proceed to free 30-days trial</a>
						<?php }else{ ?> 
							<a href="<?php echo url('products');?>" class="btn btn-success">Proceed to free 30-days trial</a>

							<?php } ?>
					</div>
					<br>
					<p>For more details on our products, click <a target="_blank" href="<?php echo url('products');?>"><b>here</b> </a></p>
				</div>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div> -->
		</div>

	</div>
</div>
<!-- Upgrade STANDARD Feature End-->
<!-- Upgrade STANDARD content Modal Start-->
<div class="modal fade" id="Dv_modal_upgrade_premium_content"  role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-warning premium" style="display:none;">Subscribe to Standard Account</h4>
				<h4 class="modal-title text-warning mychart">Upgrade to Standard Account</h4>
			</div>
			<div class="modal-body">
				<div class="form-group mychart">
					<h5 class="mart0 text-center">Register for 30 days free trial</h5>
					<!-- <ul class="list-unstyled stareg_list">
						<li><i class='fa fa-check'></i>Costs USD 100/month</li>
						<li><i class='fa fa-check'></i>Start with a free trial for 30 days</li>
						<li><i class='fa fa-check'></i>Monthly payments start after the trial period ends.</li>
					</ul> -->
					<div class="text-center">
					<?php if(Session::has('user')){  ?>
						<a href="<?php echo url('user/myaccount/subscription');?>" class="btn btn-success">Proceed to free 30-days trial</a>
						<?php }else{ ?> 
							<a href="<?php echo url('products');?>" class="btn btn-success">Proceed to free 30-days trial</a>

							<?php } ?>
					</div>					
					<br>
					<p>Review our product page for more details, click <a target="_blank" href="<?php echo url('products');?>"><b>here</b> </a></p>
				</div>
				<!-- <div class="row">
					<div class="col-xs-12 col-sm-3">
						<p class="text-center">
							<i class="fa fa-warning" style="font-size: 6em;line-height:1.5em;color: #FFA500;"></i>
						</p>
					</div>
					<div class="col-xs-12 col-sm-9">
						<p><b> Please review your subscription status in account details <a href="<?php echo url('user/myaccount/subscription');?>">here</a></b>. </p>
						<p>You can visit our <a target="_balnk" href="<?php echo url('product');?>">product page</a> for more details on what we offer</p>
						<p>We welcome any feedback you like to share with us at <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>. </p>

					</div>
				</div> -->
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>
<!-- Upgrade STANDARD content End-->
<!-- Createfolder Restricted Modal Start-->
<div class="modal fade" id="Dv_modal_createfolder_restricted" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-warning">Sorry..! Folder Creation - Reached limit</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-3">
						<p class="text-center"><i class="fa fa-warning" style="font-size: 6em;color: #FFA500;"></i></p>
					</div>
					<div class="col-xs-12 col-sm-9 sm-txtcen">
						<br>
						<p><b>Sorry..! you have reached maximum allowed folders.<br>You not allowed to create more folders.</b>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Createfolder Restricted End-->
<!-- Content - Reached limit Modal Start-->
<div class="modal fade" id="Dv_modal_addchart_restricted" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-warning">Sorry..! Add Content - Reached limit</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-3">
						<p class="text-center"><i class="fa fa-warning" style="font-size: 6em;color: #FFA500;"></i></p>
					</div>
					<div class="col-xs-12 col-sm-9 sm-txtcen">
						<br>
						<p><b>Sorry..! you have reached maximum allowed content for this folder.You not allowed to add more content.</b>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Content - Reached limit End-->
<!-- Common Error Start-->
<div class="modal fade" id="Dv_modal_error_common" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-danger">Error...!</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-3">
						<p class="text-center"><i class="fa fa fa-times-circle" style="font-size: 6em;line-height:1.5em;color:red;"></i>
						</p>
					</div>
					<div class="col-xs-12 col-sm-9 sm-txtcen">
						<p>
							Sorry..! Something went wrong while displaying this webpage.<br>To continue, please click on "Refresh" or wait for the page to get refreshed.
							<br><br> <b>Page will refresh in <span id="error_page_refresh_countdown" style="font-weight: bold;"></span> seconds.</b>								
						</p>
						<button class="btn btn-primary btn-sm" id="common_btn_refresh" type="button" onclick="location.reload();"><i class="fa fa-refresh"></i> Refresh</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Common Error End-->
<!-- Common Error with message Start-->
<div class="modal fade" id="Dv_modal_error_common_with_message" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-danger">Error...!</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-3">
						<p class="text-center"><i class="fa fa fa-times-circle" style="font-size: 6em;color:#E60013;"></i></p>
					</div>
					<div class="col-xs-12 col-sm-9 sm-txtcen">
						<br>
						<p><b>Sorry..! Something went wrong and an error occured.
							<br><br><span id="error_page_error_message"></span></b>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Common Error with message End-->
<!-- Mycyhart Floating Menu-->
<div class="myfol_toggle">
	<div class="mtf_content">
		<ul class="menu top notranslate list-unstyled">
			<li class="sub-menu folders mychart-menu-set">
				<ul class="list-unstyled">
					<?php if(!Session::has('user')){ ?>
					<li class="mycha_toglogin">
						Please login to access MyChart function
					</li>
					<?php }else{
						echo isset($menu_items['folders'])?$menu_items['folders']:'';
					} ?>

					<li class="add-folder">

						<?php if(!Session::has('user')){ ?>
						<a data-toggle="modal" data-target="#Dv_modal_login" class="btn btn-primary mtfc_btn">
							<i class="fa fa-sign-in"></i> Login
						</a>
						<?php }else{ ?>
						<a class="btn btn-primary mtfc_btn">
							<i class="fa fa-plus-square"></i> Add Folder
						</a>
						<?php } ?>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="mft_ttl">
		<div class="mftttl_bg"></div>
		<i class="fa fa-angle-right"></i>
	</div>
</div>
<!-- Mycyhart Floating Menu-->
<!-- add folder modal -->
<div class="modal fade" id="modaladd_folder" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<form onsubmit="return false;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" >Add Folder</h4>
				</div>
				<div class="modal-body">
					<div class="full-width">

						<div class="form-group">
							<label for="add-folder-name">Folder Name</label>
							<input type="text" required="" class="form-control" id="add-folder-name" placeholder="Write your folder name here">
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary add-folder-name">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- add folder modal -->
<div class="modal fade" id="modaladd_chaboo" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<form onsubmit="return false;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" >Add Chart Book</h4>
				</div>
				<div class="modal-body">
					<div class="full-width">
						<div class="form-group">
							<label for="add-chartbook-name">Name of chart book</label>
							<input type="text" required="" class="form-control" id="add-chartbook-name" name="add-chartbook-name" placeholder="Write your chart book name here" autofocus>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary add-chartbook-name">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- secure payment -->
<div class="modal fade secpay_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Stripe Information</h4>
			</div>
			<div class="modal-body">
				<p>No credit card information is ever stored on our servers.  We use Stripe.com, one of the most secure and reputable payment processors available. All card numbers are encrypted on disk with AES-256 and decryption keys are stored on separate machines. None of Stripe's internal servers and daemons are able to obtain plaintext card numbers; instead, they can just request that cards be sent to a service provider on a static whitelist. </p>
				<p> Stripe's infrastructure for storing, decrypting, and transmitting card numbers runs in separate hosting infrastructure and doesn't share any credentials with Stripe's primary services (API, website, etc.) For more information, you can visit Stripe's security policy right <a href="https://stripe.com/help/security" target="_blank">here</a>!</p>
				<p> In other words, your credit card details are safe!</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- comodo payment -->
<div class="modal fade compay_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Comodo Information</h4>
			</div>
			<div class="modal-body">
				<p>SSL (Secure Sockets Layer) is a standard security protocol which establishes encrypted links between a web server and a browser, thereby ensuring that all communication that happens between a web server and browser(s) remains encrypted and hence private. SSL Certificate is today an industry standard that is used by millions of websites worldwide to protect all communication and data that's transmitted online through the websites. </p>
				<p> To Know more about comodo SSL please click here <a href="https://ssl.comodo.com/" target="_blank">here</a>!</p>
				<p> In other words, your credit card details are safe!</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- Paypal payment -->
<div class="modal fade paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Paypal Information</h4>
			</div>
			<div class="modal-body">
				<p>When you subscribe with us, we are creating "Recurring Payments Profile" based on this method we would deduct amount directly from you PayPal account. First  month subscripption is "Free" from next each month subscription amount should be deducted .  </p>
				<p> To Know more about PayPal recurring payment please click  <a href="https://developer.paypal.com/docs/classic/express-checkout/ht_ec-recurringPaymentProfile-curl-etc/" target="_blank">here</a>!</p>
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Paypal End -->