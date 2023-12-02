<?php 
?>
<div class="col-xs-12 col-md-3 rightside_con">
	<div class="right_intvid">
		<div class="sub-title">
			<h5>New Tech Videos by <?=SITE_NAME?></h5>
			<div class="sttl-line"></div>
		</div>
		<a data-toggle="modal" href="https://www.youtube.com/embed/LdYLAC19HWc?ecver=2" class="int-ytvideos effect2" data-target=".int-jmamodvid">
			<span class="hidden">New Features by Help Learn</span>
			<img alt="Standard Banner" src="<?php echo images_path('int-JMA.jpg');?>" >
		</a>
	</div>
	
	<?php if(isset($result['rightside']['event']) && count($result['rightside']['event'])>0) { ?>
	<div class="sub-title">
		<h5>Future JMA Events</h5>
		<div class="sttl-line"></div>
	</div>
	<div class="feaeve-slick">
		<?php $notice_i = 0;?>
		<?php foreach($result['rightside']['event'] as $event) { ?>
		<div class="fes_con">
			<b><?php echo ($event['event_date']!='')?$event['event_date']:''?></b>
			<?php if($event['event_title']!=''){ ?>
			<h3><?php echo ($event['event_title']);?></h3>
			<?php 	} ?>

			<?php if($event['event_value_img']!=''){ ?>
			<div class="fcimg-con">
				<img src="<?php echo url('/');?>/public/uploads/media/<?php echo $event['event_value_img'];?>" alt="Jma New Event Image"  />
			</div>
			<?php 	} ?>
			<p><?php echo ($event['event_value_text']!='')?$event['event_value_text']:''?></p>
			<?php if($event['premium_user']=='Yes'){ 
				if(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='free'){ ?>
				<a class="btn btn-primary btn-long"  href="<?php echo url("user/user_type_upgrade");?>">Upgrade Now</a> 
				<?php } elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='individual'){ ?>
				<a class="btn btn-primary btn-long" href="<?php echo $event['event_link'];?>" target="_blank">Register Now</a> 
				<?php }elseif(Session::get('user.user_status')=='trial' && Session::get('user.user_type')=='individual'){ ?>
				<a class="btn btn-primary btn-long" href="<?php echo $event['event_link'];?>" target="_blank">Register Now</a>
				<?php }elseif(Session::get('user.user_status')=='active' && Session::get('user.user_type')=='corporate'){ ?>
				<a class="btn btn-primary btn-long" href="<?php echo $event['event_link'];?>" target="_blank">Register Now</a>         
				<?php }  else{ ?>
				<a class="btn btn-primary btn-long" href="<?php echo url("user/signup?pre_info=y");?>">Register Now</a>
				<?php } 
			} 
			else { ?>
			<a href="<?php echo $event['event_link'];?>" target="_blank"class="btn btn-primary btn-long">View Details</a>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	<?php 
} ?>
<!--Video part Starts-->
<div class="right_vidcon" id="video_link_placeholder_dv">
	<div class="sub-title">
		<h5>Other Videos</h5>
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
		<li>
			<i class="fa fa-youtube-play" aria-hidden="true"></i> 
			<a data-toggle="modal" href="https://www.youtube.com/embed/yXqj5BRf1Fk" class="yt_videos" data-target=".jma_modvid">Closer look at aging in Japan</a>
		</li>
		<li>
			<i class="fa fa-youtube-play" aria-hidden="true"></i> 
			<a data-toggle="modal" href="https://www.youtube.com/embed/yXqj5BRf1Fk" class="yt_videos" data-target=".jma_modvid">Closer look at aging in Japan</a>
		</li>
		<li>
			<i class="fa fa-youtube-play" aria-hidden="true"></i> 
			<a data-toggle="modal" href="https://www.youtube.com/embed/yXqj5BRf1Fk" class="yt_videos" data-target=".jma_modvid">Closer look at aging in Japan</a>
		</li>
		<li>
			<i class="fa fa-youtube-play" aria-hidden="true"></i> 
			<a data-toggle="modal" href="https://www.youtube.com/embed/yXqj5BRf1Fk" class="yt_videos" data-target=".jma_modvid">Closer look at aging in Japan</a>
		</li>
		<li>
			<i class="fa fa-youtube-play" aria-hidden="true"></i> 
			<a data-toggle="modal" href="https://www.youtube.com/embed/yXqj5BRf1Fk" class="yt_videos" data-target=".jma_modvid">Closer look at aging in Japan</a>
		</li>
	</ul>
</div>
<!--Video part ends-->
<?php if(Session::has('user') && Session::get('user.id') > 0) { ?>
	<?php } ?>
	<?php if(isset($result['rightside']['notice']) && count($result['rightside']['notice'])>0) { ?>
	<div id="right-latest">
		<ul class="list-group">
			<?php $notice_i = 0;?>
			<?php foreach($result['rightside']['notice'] as $notice) {
				if(!empty($notice['media_value_img'])) { ?>
				<li class="list-group-item">
					<p><a href="<?php echo $notice['media_link'];?>" target="_blank">
						<img src="public/uploads/media/<?php echo $notice['media_value_img'];?>" alt="Jma Video" width="182" />
					</a></p>
				</li>
				<?php }
				if(!empty($notice['media_value_text'])) {
					?>
					<li class="list-group-item">
						<p <?php if($notice_i > 0) echo "class='latest-more'"; ?>>
							<a href="<?php echo $notice['media_link'];?>" target="_blank">
								<?php echo $notice['media_value_text'];?> 
							</a>
						</p>
						<a class="findoutmore" href="<?php echo $notice['media_link'];?>" target="_blank">Find out more</a>
					</li>
					<?php
				}
				$notice_i++;
			}?>
		</ul>
	</div>
	<?php }?>
	<!--<div id="right-news">-->
		<!-- <div class="sub-title">
			<h5>JMA in the media</h5>
			<div class="sttl-line"></div>
		</div> -->
		<!--<ul id="dv_right_videos_media" class="list-fontawesome rightection_linksouter list-group">
			<?php //$notice_i = 0;?>
			<?php //if(isset($result['rightside']['media'])){ foreach($result['rightside']['media'] as $media) {
				//if(!empty($media['media_value_img'])) { ?>
				<li class="list-group-item">
					<a href="<?php //echo $media['media_link'];?>" target="_blank">
						<img src="public/uploads/media/<?php //echo $media['media_value_img'];?>" alt="Jma Video" width="282" />
					</a>
				</li>
				<?php /*}
				if(!empty($media['media_value_text'])) {*/
					?>
					<li class="list-group-item">
						<i class="fa fa-youtube-play" aria-hidden="true"></i>
						<a href="<?php //echo $media['media_link'];?>" target="_blank">
							<?php //echo $media['media_value_text'];?>
						</a>
					</li>
					<?php
				//}
			//} } ?>
		</ul>
	</div>
</div>-->
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
				<h4 class="modal-title" id="myModalLabel">New Features by JMA</h4>
			</div>
			<div class="modal-body">
				<div class="embed-responsive embed-responsive-16by9">
					<!-- <iframe id="ytplayer" class="embed-responsive-item int-jmaVideo" src="https://www.youtube.com/embed/l6aD6ndRHIU?autoplay=0" allowfullscreen></iframe> -->
					<div id="ytplayer"></div>
					<script type="text/javascript">
					var tag = document.createElement('script');
					tag.src = "https://www.youtube.com/iframe_api";
					var firstScriptTag = document.getElementsByTagName('script')[0];
					firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
					jQuery(".int-jmamodvid").on('shown.bs.modal', function() {
						if(typeof player.playVideo == 'function') {
							player.playVideo();
						} else {
							var fn = function(){
								player.playVideo();
							};
							setTimeout(fn, 200);
						}
					});
					jQuery(".int-jmamodvid").on('hidden.bs.modal', function() {
						player.stopVideo();
					});
					var player;
					function onYouTubeIframeAPIReady() {
						player = new YT.Player('ytplayer', {
							videoId: 'LdYLAC19HWc?ecver=2',
							playerVars: {
								vq: 'hd720',
								rel: 0
							},
							events: {
								'onReady': onPlayerReady
							}
						});
					}
					function onPlayerReady() {
						player.setVolume(10);
					}
					</script>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	/*$('.feaeve-slick').slick({
		autoplay:true,
		speed: 1000,
		autoplaySpeed: 9000,
	});*/
});
</script>
