
<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) { ?>
<div class="row">
	<ul class="list-group" id="dv_client_sp_links">
		<?php if(isset($_SESSION['user']['user_permissions']['user']['profile']['allowedit']) && $_SESSION['user']['user_permissions']['user']['profile']['allowedit'] == 'Y') {?>
		<li class="list-group-item" >
			<i class="fa fa-pencil-square" style="color:#EF6F07;font-size:14px;"></i>&nbsp;
			<a href="<?php echo $this->url('/user/myaccount');?>" class="<?php if($this->controllername == 'user' && isset($this->resultSet['result']['action']) && $this->resultSet['result']['action'] == 'profile') { echo "selected"; } else { ""; }?>">Edit my Profile</a>
		</li>
		<?php }?>
		<li class="list-group-item" ><i class="fa fa-envelope-o" style="color:#EF6F07;font-size:14px;"></i>&nbsp;
			<a href="<?php echo $this->url('/helpdesk/post');?>" class="<?php if($this->controllername == 'helpdesk' && isset($this->resultSet['result']['action']) && $this->resultSet['result']['action'] == 'post') { echo "selected"; } else { ""; }?>">Help Desk</a>
		</li>
	</ul>
</div>
<?php }?>
<!--Video part Starts-->
<div class="right_vidcon row" id="video_link_placeholder_dv">
	<div class="sub-title">
		<h5>Videos</h5>
		<div class="sttl-line"></div>
	</div>
	<ul class="list-fontawesome">
		<li>
			<i class="fa fa-youtube-play" aria-hidden="true"></i> 
			<a data-toggle="modal" data-target="#video_1">Will wages in Japan ever rise?</a>
		</li>
		<li>
			<i class="fa fa-youtube-play" aria-hidden="true"></i> 
			<a data-toggle="modal" data-target="#video_2">Closer look at aging in Japan</a>
		</li>
	</ul>
</div>
<!--Video part ends-->
<?php
if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
	?>
	<?php } ?>
	<?php if(isset($this->resultSet['result']['rightside']['notice']) && count($this->resultSet['result']['rightside']['notice'])>0) { ?>
	<div id="right-latest" class="row">
		<ul class="list-group">
			<?php $notice_i = 0;?>
			<?php foreach($this->resultSet['result']['rightside']['notice'] as $notice) {
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
		<h5>Jma in the media</h5>
		<div class="sttl-line"></div>
	</div>
	<div class="embed-responsive embed-responsive-16by9">
		<iframe class="embed-responsive-item" src="//www.youtube.com/embed/pVy6wWVj214"></iframe>
	</div>
	<ul id="dv_right_videos_media" class="list-fontawesome rightection_linksouter list-group">
		<?php $notice_i = 0;?>
		<?php foreach($this->resultSet['result']['rightside']['media'] as $media) {
			if(!empty($media['media_value_img'])) { ?>
			<!-- <li>
				<i class="fa fa-youtube-play" aria-hidden="true"></i>
				<a href="<?php echo $media['media_link'];?>" target="_blank">
					<img src="public/uploads/media/<?php echo $media['media_value_img'];?>" alt="" width="182" />
				</a>
			</li> -->
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
<!-- Modal -->
<div class="modal fade jma_modvid" id="video_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Will wages in Japan ever rise?</h4>
			</div>
			<div class="modal-body">
				<iframe class="jmaVideo" width="560" height="315" src="https://www.youtube.com/embed/mgrkC8fC_Os?autoplay=1" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade jma_modvid" id="video_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Closer look at aging in Japan</h4>
			</div>
			<div class="modal-body">
				<iframe class="jmaVideo" width="560" height="315" src="https://www.youtube.com/embed/yXqj5BRf1Fk?autoplay=1" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    /* Get iframe src attribute value i.e. YouTube video url
    and store it in a variable */
    var url = $(".jmaVideo").attr('src');
    
    /* Remove iframe src attribute on page load to
    prevent autoplay in background */
    $(".jmaVideo").attr('src', '');

	/* Assign the initially stored url back to the iframe src
	attribute when modal is displayed */
	$(".jma_modvid").on('shown.bs.modal', function(){
		$(".jmaVideo").attr('src', url);
	});

    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $(".jma_modvid").on('hide.bs.modal', function(){
    	$(".jmaVideo").attr('src', '');
    });
  });
</script>
<script>
$(".yt_videos").click(function() {
	$.fancybox({
		'padding'		: 0,
		'autoScale'		: false,
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
		'title'			: this.title,
		'width'		: 680,
		'height'		: 495,
		'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
		'type'			: 'swf',
		'swf'			: {
			'wmode'		: 'transparent',
			'allowfullscreen'	: 'true'
		}
	});
	return false;
});
</script>