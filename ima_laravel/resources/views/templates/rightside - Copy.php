<div class="col-xs-12 col-md-3 content_rightside">
	<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) { ?>
	<div class="row rigbar_usehel">
		<ul class="list-group" id="dv_client_sp_links">
			<?php if(isset($_SESSION['user']['user_permissions']['user']['profile']['allowedit']) && $_SESSION['user']['user_permissions']['user']['profile']['allowedit'] == 'Y') {?>
			<li class="list-group-item" >
				<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;
				<a href="<?php echo url('/user/myaccount');?>" class="<?php if(thisController() == 'user' && isset($result['result']['action']) && $result['result']['action'] == 'profile') { echo "selected"; } else { ""; }?>">Edit my Profile</a>
			</li>
			<?php }?>
			<li class="list-group-item" ><i class="fa fa-envelope-o"></i>&nbsp;
				<a href="<?php echo url('/helpdesk/post');?>" class="<?php if(thisController() == 'helpdesk' && isset($result['result']['action']) && $result['result']['action'] == 'post') { echo "selected"; } else { ""; }?>">Help Desk</a>
			</li>
		</ul>
	</div>
	<?php }?>
	<div class="row right_banners">
		<div class="rb_chart effect2">
			<div class="color_overlayd"></div>
			<div class="rvb_logo">
				<img alt="India Macro Advisors" src="<?php echo images_path("logo.png");?>" >
			</div>
			<div class="rb_banner">
				<h3>My Chart</h3>
				<h5>Enabling instant creations of chartbooks</h5>
				<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo url('mycharts/about_my_chart');?>>
					Read More
				</a>
			</div>
		</div>
		<div class="preres_list effect8">
			<div class="prl_con">
				<div><a class="pc_text" href="<?php echo url('pressrelease');?>" target="_blank">India Macro Advisors launched on May 12th 2017.</a></div>
				<div><a href="<?php echo url('pressrelease');?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;PDF&nbsp;File"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div>
			<div class="prl_con">
				<div><a class="pc_text" href="<?php echo url('aboutus/career');?>">We are looking for new people for our economist team. If you are passionate about economics send us your resume.</a></div>
				<div><a href="<?php echo url('aboutus/career');?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;Career&nbsp;Page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div>
			<div class="prl_con">
				<div><a class="pc_text" href="https://www.japanmacroadvisors.com" target="_blank">Japan Macro Advisors-An unbiased opinion on the Japanese economy.</a></div>
				<div><a href="https://www.japanmacroadvisors.com" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;JMA&nbsp;Website"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div>
			<div class="prl_con">
				<div><a class="pc_text" href="<?php echo url('page/category/economic-indicators/gdp-business-activity/index-of-industrial-production/');?>" target="_blank">India's industrial production slows down to 3.1% YoY in April 2017, from 3.8% YoY in the previous month.</a></div>
				<div><a href="<?php echo url('page/category/economic-indicators/gdp-business-activity/index-of-industrial-production/');?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;Indicator&nbsp;Page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div>
			<div class="prl_con">
				<div><a class="pc_text" href="<?php echo url('page/category/economic-indicators/international-balance/balance-of-payment-bop/');?>" target="_blank">During January-March 2017, India's Current Account Deficit (CAD) worsened to USD 3.4 billion from USD 0.3 billion a year ago, reaching 0.6% of GDP.</a></div>
				<div><a href="<?php echo url('page/category/economic-indicators/international-balance/balance-of-payment-bop/');?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;Indicator&nbsp;Page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div>
			<div class="prl_con">
				<div><a class="pc_text" href="<?php echo url('page/category/economic-indicators/inflation-prices/consumer-price-index/');?>" target="_blank">In May 2017, CPI inflation of India fell for the second straight month to a new record low of 2.18% year on year (YoY).</a></div>
				<div><a href="<?php echo url('page/category/economic-indicators/inflation-prices/consumer-price-index/');?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;Indicator&nbsp;Page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div>
			<div class="prl_con">
				<div><a class="pc_text" href="<?php echo url('page/category/reports/');?>" target="_blank">Estimating the economic impact of cattle slaughter ban.</a></div>
				<div><a href="<?php echo url('page/category/reports/');?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;Indicator&nbsp;Page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div>
			<!-- <div class="prl_con">
				<div><a class="pc_text" href="<?php echo url('page');?>" target="_blank">Industrial.</a></div>
				<div><a href="<?php echo url('page');?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;Indicator&nbsp;Page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
			</div> -->
		</div>
	</div>
	<?php
	if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
		?>
		<?php } ?>
		<?php if(isset($result['rightside']['notice']) && count($result['rightside']['notice'])>0) { ?>
		<div id="right-latest" class="row">
			<ul class="list-group">
				<?php $notice_i = 0;?>
				<?php foreach($result['rightside']['notice'] as $notice) {
					if(!empty($notice['media_value_img'])) { ?>
					<li class="list-group-item"><p> <a href="<?php echo $notice['media_link'];?>" target="_blank">
						<img src="public/uploads/media/<?php echo $notice['media_value_img'];?>" alt="" width="182" />
					</a></p></li>
					<?php
				}
				if(!empty($notice['media_value_text'])) {
					?>
					<li class="list-group-item"><p <?php if($notice_i > 0) echo "class='latest-more'"; ?>> <a href="<?php echo $notice['media_link'];?>" target="_blank">
						<?php echo $notice['media_value_text'];?>
					</a></p>
					<a class="findoutmore" href="<?php echo $notice['media_link'];?>" target="_blank">Find out more</a></li>
					<?php
				}
				$notice_i++;
			}?>
		</ul>
	</div>
	<?php }?>
	<div id="right-news" class="row">
		<div class="sub-title">
			<h5>IMA in the media</h5>
			<div class="sttl-line"></div>
		</div>
		<ul id="dv_right_videos_media" class="list-fontawesome rightection_linksouter list-group">
			<li class="list-group-item">
				<div class="slick_media">
					<div>
						<a href="<?php //echo $media['media_link'];?>" target="_blank">
							<img src="<?php echo images_path('JNU1.jpg');?>" alt="JMA Banners">
						</a>
					</div>
					<div>
						<a href="<?php //echo $media['media_link'];?>" target="_blank">
							<img src="<?php echo images_path('JNU2.jpg');?>" alt="JMA Banners">
						</a>
					</div>
				</div>
			</li>
			<li class="list-group-item">
				<i class="fa fa-hand-o-right" aria-hidden="true"></i>
				<a href="<?php echo url('seminar');?>" target="_blank">
					Our founder and chief economist, Mr Takuji Okubo recently delivered a seminar at CMS-Center of Management Studies, Jain University- On strengthening the economic tie between India and Japan.
				</a>
			</li>
		</ul>
	</div>
</div>
