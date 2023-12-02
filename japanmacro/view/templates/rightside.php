<div class="col-xs-12 col-md-3 rightside_con">
	<div class="right_intvid">
		<div class="sub-title">
			<h5>Introduction to JMA</h5>
			<div class="sttl-line"></div>
		</div>
		<a data-toggle="modal" href="https://www.youtube.com/embed/l6aD6ndRHIU" class="int-ytvideos effect2" data-target=".int-jmamodvid">
			<span class="hidden">Introduction to JMA</span>
			<img alt="Premium Banner" src="<?php echo $this->images;?>int-JMA.png" >
		</a>
	</div>
	<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) { ?>
	<ul class="list-group" id="dv_client_sp_links">
		<?php if(isset($_SESSION['user']['user_permissions']['user']['profile']['allowedit']) && $_SESSION['user']['user_permissions']['user']['profile']['allowedit'] == 'Y') {?>
		<li class="list-group-item" >
			<i class="fa fa-pencil-square" style="color:#e60013;font-size:14px;"></i>&nbsp;
			<a href="<?php echo $this->url('/user/myaccount');?>" class="<?php if($this->controllername == 'user' && isset($this->resultSet['result']['action']) && $this->resultSet['result']['action'] == 'profile') { echo "selected"; } else { ""; }?>">Edit my Profile</a>
		</li>
		<?php }?>
		<li class="list-group-item" ><i class="fa fa-envelope-o" style="color:#e60013;font-size:14px;"></i>&nbsp;
			<a href="<?php echo $this->url('/helpdesk/post');?>" class="<?php if($this->controllername == 'helpdesk' && isset($this->resultSet['result']['action']) && $this->resultSet['result']['action'] == 'post') { echo "selected"; } else { ""; }?>">Help Desk</a>
		</li>
	</ul>
	<?php }?>
	<div class="right_banners">
		<div class="rv_banner effect2">
			<!-- <div class="rvb_logo">
				<img alt="Japan GDP Economy" src="<?php echo $this->images;?>logo-w.png" >
			</div> -->
			<h3>My Chart</h3>
			<h5>You can now create chartbooks and download it as Powerpoint in a few clicks. Take a look how.</h5>
			<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $this->url('mycharts/about_my_chart');?>>
				Read More
			</a>
		</div>
		<!-- <div class="prelef_banner effect2">
			<a href="<?php echo $this->url('briefseries');?>">
				<img alt="Premium Banner" src="<?php echo $this->images;?>int-JMA.png" >
			</a>
			<div class="rvp_logo">
				<img alt="Japan GDP Economy" src="<?php echo $this->images;?>logo-w.png" >
			</div>
		</div> -->
	</div>
	<!--Video part Starts-->
	<div class="right_vidcon" id="video_link_placeholder_dv">
		<div class="sub-title">
			<h5>Videos</h5>
			<div class="sttl-line"></div>
		</div>
		<ul class="list-fontawesome">
			<li>
				<i class="fa fa-youtube-play" aria-hidden="true"></i> 
				<a data-toggle="modal" href="https://www.youtube.com/embed/mgrkC8fC_Os" class="yt_videos" data-target=".jma_modvid">Will wages in Japan ever rise?</a>
			</li>
			<li>
				<i class="fa fa-youtube-play" aria-hidden="true"></i> 
				<a data-toggle="modal" href="https://www.youtube.com/embed/yXqj5BRf1Fk" class="yt_videos" data-target=".jma_modvid">Closer look at aging in Japan</a>
			</li>
		</ul>
	</div>
	<!--Video part ends-->
	<?php
	if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
		?>
		<?php } ?>
		<?php if(isset($this->resultSet['result']['rightside']['notice']) && count($this->resultSet['result']['rightside']['notice'])>0) { ?>
		<div id="right-latest">
			<ul class="list-group">
				<?php $notice_i = 0;?>
				<?php foreach($this->resultSet['result']['rightside']['notice'] as $notice) {
					if(!empty($notice['media_value_img'])) { ?>
					<li class="list-group-item"><p> <a href="<?php echo $notice['media_link'];?>" target="_blank">
						<img src="public/uploads/media/<?php echo $notice['media_value_img'];?>" alt="Jma Video" width="182" />
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
	<div id="right-news">
		<div class="sub-title">
			<h5>JMA in the media</h5>
			<div class="sttl-line"></div>
		</div>
		<!-- <div class="embed-responsive embed-responsive-16by9">
			<iframe class="embed-responsive-item" src="//www.youtube.com/embed/pVy6wWVj214"></iframe>
		</div> -->
		<ul id="dv_right_videos_media" class="list-fontawesome rightection_linksouter list-group">
			<?php $notice_i = 0;?>
			<?php foreach($this->resultSet['result']['rightside']['media'] as $media) {
				if(!empty($media['media_value_img'])) { ?>
				<li class="list-group-item">
					<!-- <i class="fa fa-youtube-play" aria-hidden="true"></i> -->
					<a href="<?php echo $media['media_link'];?>" target="_blank">
						<img src="public/uploads/media/<?php echo $media['media_value_img'];?>" alt="Jma Video" width="282" />
					</a>
				</li>
				<?php
			}
			if(!empty($media['media_value_text'])) {
				?>
				<li class="list-group-item">
					<i class="fa fa-youtube-play" aria-hidden="true"></i>
					<a href="<?php echo $media['media_link'];?>" target="_blank">
						<?php echo $media['media_value_text'];?>
					</a>
				</li>
				<?php
			}
		} ?>
	</ul>
</div>
</div>
<!-- Modal -->
<div class="modal fade jma_modvid"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Will wages in Japan ever rise?</h4>
			</div>
			<div class="modal-body">
				<iframe class="jmaVideo" width="560" height="315" src="https://www.youtube.com/embed/mgrkC8fC_Os?autoplay=0" ></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade int-jmamodvid"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body">

		<div class="embed-responsive embed-responsive-16by9">
			<iframe class="embed-responsive-item int-jmaVideo" src="https://www.youtube.com/embed/l6aD6ndRHIU?autoplay=0"></iframe>
		</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
