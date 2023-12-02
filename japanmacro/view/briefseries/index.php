<?php
$briefse = $this->resultSet['result']['briefseries'];
$loggedIn = $this->resultSet['result']['isUserLoggedIn'];
$permitted = $this->resultSet['result']['isPermitted'];
?>
<div class="col-xs-12 col-md-10">
	<div class="main-title">
		<h1>JMA brief series</h1>
		<div class="mttl-line"></div>
	</div>
	<?php if(count($briefse)>0){ foreach ($briefse as $briefSeriesRlts) {
		$title = $briefSeriesRlts['briefseries_title'];
		$title_image = $briefSeriesRlts['briefseries_title_img'];
		$briefseries_summery_path = $briefSeriesRlts['briefseries_summary_path'];
		$briefseries_ppt_path = $briefSeriesRlts['briefseries_ppt_path'];
		$date =  $briefSeriesRlts['briefseries_date'];
		$premium =  $briefSeriesRlts['is_premium'];
		$id = $briefSeriesRlts['briefseries_id'];
		if($premium == 'Y') {
			$summary_link_url = $this->url('/').$briefseries_summery_path;
			$ppt_link_url = $this->url('/').$briefseries_ppt_path;
			if($loggedIn==true) {
				// check permission
				if($permitted==true){
					$summary_link = $this->url('/').$briefseries_summery_path;
					$ppt_link = $this->url('/').$briefseries_ppt_path;
				} else {
				// show upgrade box
					$premium_cat_lnk_cls = 'lnk_inactive';
					$summary_link = 'javascript:JMA.User.showUpgradeBox("premium","'.$this->url('/briefseries').'")';
					$ppt_link = 'javascript:JMA.User.showUpgradeBox("premium","'.$this->url('/briefseries').'")';
					$classes.= ' menu_premium_locked';
				}
			}else{
			// Show login window
				$premium_cat_lnk_cls = 'lnk_inactive';
				$summary_link = 'javascript:JMA.User.showLoginBox("premium","'.$this->url('/briefseries').'")';
				$ppt_link = 'javascript:JMA.User.showLoginBox("premium","'.$this->url('/briefseries').'")';
				$classes.= ' menu_premium_locked';
			}
		} else {
			$summary_link = $this->url('/').$briefseries_summery_path;
			$ppt_link = $this->url('/').$briefseries_ppt_path;
		}
		?>
		<div class="jmabrief_container">
			<div class="row">
				<div class="col-xs-12 col-sm-4">
					<img src="<?php echo $title_image;?>" alt="Brief series image" />
				</div>
				<div class="col-xs-12 col-sm-8">
					<h5><?php echo $title; ?></h5>
					<ul class="list-unstyled">
						<li>
							<?php if($briefseries_summery_path !="") { ?>
							<i class="fa fa-file-pdf-o" ></i>
							<a class="<?php echo $premium_cat_lnk_cls; ?>" href='<?php echo $summary_link; ?>'>Summary</a><br>
							<?php } ?>
						</li>
						<li>
							<?php if($briefseries_ppt_path !="") { ?>
							<i class="fa fa-file-powerpoint-o" ></i>
							<a class="<?php echo $premium_cat_lnk_cls; ?>" href='<?php echo $ppt_link; ?>'>Presentation slide</a><br>
							<?php } ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<?php 
	} } else { ?>
	<div class="jmabrief_container">
		<div class="row" >
			<div class="col-sm-12 text-center text-danger">
				<h5>Contents Not Found</h5>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
