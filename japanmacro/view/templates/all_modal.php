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
					<ul class="list-inline list_sigmod">
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
								<b>PREMIUM</b>
							</div>
						</li>
						<li>
							<div class="premium-img">
								<i class="fa fa-building fa-lg"
								style="color: #22558F;"></i><b>CORPORATE</b>
							</div>
						</li>
					</ul>
				</div>
				<div class="modal-body">
					<form name="login_frm_ajx" id="login_frm_ajx" class="signup_frm" action="<?php echo $this->url('/user/login');?>" method="post">
						<div class="text-center form-group mychart">
							<p>This feature is restricted <b>for logged-in users only.</b> <br> If you
								are a FREE / PREMIUM / CORPORATE account user, please log-in.<br>
							</p>
						</div>
						<div class="text-center form-group premium">
							<p>This content is restricted <b>for paying users only.</b> <br> If you
								are a PREMIUM / CORPORATE account user, please log-in.<br>
							</p>
						</div>
						<div class="text-center form-group download">
							<p>Please log-in to access our <b>data download function.</b><br></p>
						</div>
						<div class="text-center form-group">
							<a href="<?php echo $this->url('user/linkedinProcess');?>" class="linkedIn">
								<img alt="JMA Linkedin Login" src="<?php echo $this->images;?>sign-in-with-linkedin.png" />
							</a>
						</div>
						<div class="sinup_orcon"><p>OR</p></div>
						<p class="login_frm_ajx_login_status text-center text-danger" style="font-size: 12px;display: none;"></p>
						<div class="form-group col-xs-12 col-sm-6 sm-pad padl0">
							<!-- <label for="login_email" class="control-label visible-xs">&nbsp;</label>  -->
							<input class="form-control" placeholder="Email" name="login_email" id="login_email">
						</div>
						<div class="form-group col-xs-12 col-sm-6 sm-pad padr0">
							<!-- <label for="login_password" class="control-label visible-xs">&nbsp;</label> -->
							<input type="password" class="form-control"  placeholder="Password" name="login_password" id="login_password"  />
							<input type="hidden" name="chart_login_perm_type" id="chart_login_perm_type" >
							<input type="hidden" name="chart_login_chart_index" id="chart_login_chart_index">
							<input type="hidden" name="chart_login_premium_url" id="chart_login_premium_url">
						</div>
						<div class="full-width text-center marb20">
							<button type="button"  class="btn btn-primary btn-sm" name="login_btn" id="pop_login_btn">
								Submit
							</button>
							<a class="btn" id="SubmitForgotPss" href="<?php echo $this->url('user/forgotpassword');?>">
								Forgot Password?
							</a>
						</div>
						<p class="premium-logininfo">
							<a href="<?php echo $this->url('products');?>">Upgrade or Register for </a> PREMIUM or CORPORATE account.
						</p>
						<p class="download-logininfo">
							Not registered?<br/>
							<i class="fa fa-play-circle" style="color: #F39019; font-size: 20px;padding: 1px 5px 3px 2px;"></i>
							<a href="<?php echo $this->url('products');?>">Setup a <b>Free Account</b></a> to access our services free of charge.
						</p>
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
	<?php if(!isset($_SESSION['user'])){?>
	<div class='popup'>
		<div class='cnt223'>
			<div class="POPUser">
				<i class="fa fa-user fa-lg"></i>User Login
				<div  class='x' id='x'>
					<i class="fa fa-times" style="color: #EA2635"></i>
				</div>
			</div>
			<div id="Dv_login_wrapper">
				<form name="login_frm" id="login_frm"
				action="<?php echo $this->url('/user/login');?>" method="post">
				<div class="login_box_input">
					<input type="text" placeholder="Email"
					class="formPop_textfield" name="login_email"
					id="login_email" />
				</div>
				<div class="login_box_input">
					<input type="password" placeholder="password"
					class="formPop_textfield" name="login_password"
					id="login_password" />
				</div>
				<div class="full-widthf">
					<label class="control control--checkbox">Keep me signed in
						<input type="checkbox" value="y" name="login_rememberMe" id="login_rememberMe" checked/>
						<div class="control__indicator"></div>
					</label>
				</div>
				<div class="full-widthf text-center">
					<input type="submit" value="Submit" class="btn btn-primary btn-sm" name="login_btn"  />
				</div>
				<div class="ForPassword">
					<a href="<?php echo $this->url('user/forgotpassword');?>">Forgot
						your password?</a>
					</div>
					<div class="sinup_orcon"><p>OR</p></div>
					<div class="chat_signlin">
						<a href="<?php echo $this->url('user/linkedinProcess');?>">
							<img alt="JMA Linkedin Login" src="<?php echo $this->images;?>sign-in-with-linkedin.png" />
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php }?>
	<!-- Auto Login Modal End-->
	<!-- Upgrade Premium Feature Modal Start-->
	<div class="modal fade" id="Dv_modal_upgrade_premium_feature" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-warning">Sorry..! This feature restricted</h4>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-3">
							<p class="text-center"><i class="fa fa-warning" style="font-size: 6em;line-height:2em;color: #FFA500;"></i></p>

						</div>
						<div class="col-xs-12 col-sm-9">
							<p><b> Sorry..! With a free account, you can save & edit up to 4 charts & tables in your personal online folder. If you wish to save more than 4 charts, please upgrade to a PREMIUM or CORPORATE account. Otherwise, you can also delete unnecessary charts & tables from your folder. For more details, please check your account details <a href="<?php echo $this->url('user/myaccount/subscription');?>">here</a></b>. </p>
							<p> Thank you again for being a JMA user and we welcome any feedback you like to share with us at <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>. </p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	<!-- Upgrade Premium Feature End-->
	<!-- Upgrade Premium content Modal Start-->
	<div class="modal fade" id="Dv_modal_upgrade_premium_content" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-warning">Sorry! This feature is restricted</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-3">
							<p class="text-center">
								<i class="fa fa-warning" style="font-size: 6em;line-height:1.5em;color: #FFA500;"></i>
							</p>
						</div>
						<div class="col-xs-12 col-sm-9">
							<p>
								<b> 
									Sorry! you do not have permission to view premium ontents. Please review your subscription status 
									<a href="<?php echo $this->url('user/myaccount');?>">Account details</a> . 
								</b>
								<br><br> Thank you again for being a JMA user and we welcome any feedback you like to share with us at 
								<a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>. 
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
	<!-- Upgrade Premium content End-->
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
						<?php if(!isset($_SESSION['user'])){ ?>
						<li class="mycha_toglogin">
							Please login to access MyChart function
						</li>
						<?php }else{
							echo $this->resultSet['result']['category']['folders'];
						} ?>

						<li class="add-folder">
							
							<?php if(!isset($_SESSION['user'])){ ?>
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