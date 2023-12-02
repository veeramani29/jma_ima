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

		<!-- Commemted 04/04/2018 <div class="rb_chart effect2">
			<!-- <div class="color_overlayd"></div> >
			<div class="rvb_logo">
				<img alt="India Macro Advisors" src="<?php echo images_path("logo.png");?>" >
			</div>
			<div class="rb_banner">
				<img alt="Ideas Pitch" src="<?php echo images_path('ima.png');?>" alt="team image">
				<h3>Competition</h3>
				
				<h5>Make your idea<i class="fa fa-lightbulb-o" aria-hidden="true"></i> stand out</h5>
				
				<a class="btn btn-primary" href="<?php echo url('page/ideapitchcompetition');?>">
					Competition Page
				</a>
			</div>
		</div> -->
		<div class="preres_list effect8">
			<?php if(isset($result['rightside']['notice']) && count($result['rightside']['notice'])>0) 
			{ 
				$notice_i = 0;
				foreach($result['rightside']['notice'] as $notice) 
				{ 
					if(empty($notice['media_value_img'])) 
						{ ?>
					<div class="prl_con">
						<div><a class="pc_text" rel="nofollow" href="<?php echo $notice['media_link'];?>" target="_blank"><?php echo $notice['media_value_text'];?></a></div>
						<div><a rel="nofollow" href="<?php echo $notice['media_link'];?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;Indicator&nbsp;Page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></div>
					</div>
					
					<?php }
					if(empty($notice['media_link'])) 
						{ ?>
					
					<div class="prl_con">
						<div><a class="pc_text" rel="nofollow" href="<?php echo 'public/uploads/media/'.$notice['media_value_img'];?>" target="_blank"><?php echo $notice['media_value_text'];?></a></div>
						<div><a rel="nofollow" href="<?php echo $notice['media_value_img'];?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Open&nbsp;PDF&nbsp;File"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></div>
					</div>
					<?php }

				}
				$notice_i++;
			} else { ?>
			<div class="prl_con">
				<div class='text-center text-danger'>News not found.We will update soon</div>
			</div>
			<?php 	} ?>
		</div>
	</div>
	

	<!--<div id="right-news" class="row">
		<div class="sub-title">
			<h5>IMA in the media</h5>
			<div class="sttl-line"></div>
		</div>
		<ul id="dv_right_videos_media" class="list-fontawesome rightection_linksouter list-group">
			<li class="list-group-item">
				<div class="slick_media">
					<div>
						<a href="<?php //echo $media['media_link'];?>" target="_blank">
							<img src="<?php //echo images_path('JNU1.jpg');?>" alt="JMA Banners">
						</a>
					</div>
					<div>
						<a href="<?php //echo $media['media_link'];?>" target="_blank">
							<img src="<?php //echo images_path('JNU2.jpg');?>" alt="JMA Banners">
						</a>
					</div>
				</div>
			</li>
			<li class="list-group-item">
				<i class="fa fa-hand-o-right" aria-hidden="true"></i>
				<a href="<?php //echo url('seminar');?>" target="_blank">
					Our founder and chief economist, Mr Takuji Okubo recently delivered a seminar at CMS-Center of Management Studies, Jain University- On strengthening the economic tie between India and Japan.
				</a>
			</li>
		</ul>
	</div>-->
</div>