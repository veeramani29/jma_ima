<?php
$resn = $this->resultSet['result']['materials'];
?>
<div class="col-xs-12 col-md-10">
	<?php
	$count = count($resn);
	if($count==0)
	{
		?>
		<h3>Sorry, <span>No items found</span></h3>
		<?php
	}
	else
	{
		?>
		<div class="main-title">
			<h1>
				<?php
				switch ($resn[0]['material_type']){
					case 'general':
					$material_title = 'Presentation materials';
					break;
					case 'japanese':
					$material_title = 'Materials in Japanese';
					break;
					case 'oxford':
					$material_title = 'Oxford Economicsæ—¥æœ¬èªžãƒ¬ãƒ�ãƒ¼ãƒˆ';
					break;
					default:
					$material_title = 'Presentation materials';
					break;
				}
				echo $material_title ; ?>
			</h1>
			<div class="mttl-line"></div>
		</div>
		<?php if($resn[0]['material_type']=='oxford'){?>
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<p>Oxford Economics ã�¯ã€�ã‚ªãƒƒã‚¯ã‚¹ãƒ•ã‚©ãƒ¼ãƒ‰å¤§å­¦ã�®ãƒ“ã‚¸ãƒ�ã‚¹ã‚«ãƒ¬ãƒƒã‚¸ã�§ã�‚ã‚‹ãƒ†ãƒ³ãƒ—ãƒ«ãƒˆãƒ³ã‚«ãƒ¬ãƒƒã‚¸ã�¨å�”åŠ›ã�—ã�Ÿå•†æ¥­ãƒ™ãƒ¼ã‚¹ã�®ç ”ç©¶æ©Ÿé–¢ã�¨ã�—ã�¦ 1981 å¹´ã�«å‰µæ¥­ã�•ã‚Œã€�å½“åˆ�ã�¯æµ·å¤–é€²å‡ºã‚’ã‚�ã�–ã�™è‹±å›½ã�®ä¼�æ¥­ã�Šã‚ˆã�³é‡‘èž�æ©Ÿé–¢ã�«å¯¾ã�—ã€�çµŒæ¸ˆäºˆæ¸¬ã�¨è¨ˆé‡�çµŒæ¸ˆãƒ¢ãƒ‡ãƒ«æ§‹ç¯‰ã�®ã‚µãƒ¼ãƒ“ã‚¹ã‚’æ��ä¾›ã�—ã�¦ã��ã�¾ã�—ã�Ÿã€‚ã��ã�®å¾Œã€�äº‹æ¥­ã‚’æ‹¡å¤§ã�—ä¸–ç•Œæœ‰æ•°ã�®æœ€ã‚‚å„ªã‚Œã�Ÿæ°‘é–“ãƒ™ãƒ¼ã‚¹ã�®ã‚¢ãƒ‰ãƒ�ã‚¤ã‚¶ãƒªãƒ¼ç ”ç©¶æ©Ÿé–¢ã�¸ã�¨æˆ�é•·ã�—ã€�ç�¾åœ¨ã�§ã�¯å¼Šç¤¾ã�®ã‚«ãƒ�ãƒ¬ãƒƒã‚¸ã�¯200 ãƒ¶å›½ã€�100æ¥­ç¨®ã€� 3000 éƒ½å¸‚ä»¥ä¸Šã�¨ã�ªã�£ã�¦ã�Šã‚Šã€�ã��ã‚Œã‚‰ã�®å›½ã€…ã€�æ¥­ç¨®ã€�éƒ½å¸‚ã‚’å¯¾è±¡ã�¨ã�—ã�Ÿèª¿æŸ»ãƒ¬ãƒ�ãƒ¼ãƒˆã�«åŠ ã�ˆã€�ä¸–ç•ŒçµŒæ¸ˆãƒ¢ãƒ‡ãƒ«ã‚„ç”£æ¥­ãƒ¢ãƒ‡ãƒ«ã�ªã�©äºˆæ¸¬ã�¨åˆ†æž�ã�®ãƒ„ãƒ¼ãƒ«ã‚‚æ��ä¾›ã�—ã�¦ã�„ã�¾ã�™ã€‚å¼Šç¤¾ã�®ã�“ã‚Œã‚‰ã�®åˆ†æž�ãƒ„ãƒ¼ãƒ«ã�¯ä¸–ç•Œæœ€é«˜ãƒ¬ãƒ™ãƒ«ã�¨è‡ªè² ã�—ã�¦ã�Šã‚Šã€�ã�¾ã�Ÿã€�ã��ã‚Œã‚‰ã�®åˆ†æž�ãƒ„ãƒ¼ãƒ«ã‚’ä½¿ã�†ã�“ã�¨ã�«ã‚ˆã‚Šä¸–ç•Œã�®å¸‚å ´å‹•å�‘ã�®äºˆæ¸¬ã�Šã‚ˆã�³å¸‚å ´ã�®å¤‰åŒ–ã�Œã€�çµŒæ¸ˆã€�ç¤¾ä¼šã€�ãƒ“ã‚¸ãƒ�ã‚¹ã�«ä¸Žã�ˆã‚‹å½±éŸ¿ã‚’è©•ä¾¡ã�™ã‚‹ã�“ã�¨ã�Œå�¯èƒ½ã�«ã�ªã�£ã�¦ã�Šã‚Šã�¾ã�™ã€‚</p>
			</div>
			<div class="col-xs-12 col-md-6">
				<img alt="Oxford Economics" src="<?php echo $this->images."image_oxford_material.png";?>">
			</div>
		</div>
		<?php }?>
		<?php
		$i=0;
		foreach ($resn as $materials) {
			$i++;
			$title = $materials['material_title'];
			$title_image = $materials['material_title_img'];
			$material_path = $materials['material_path'];
			$date =  $materials['material_date'];
			$id = $materials['material_id'];
			?>
			<?php if($materials['material_type'] == 'general' || $materials['material_type'] == 'oxford') { ?>
			<div class="row premat_con">
				<div class="col-md-4">
					<!--  <img src="image.php?path=<?php // echo $title_image;?>&w=241&h=153">  -->
					<img src="<?php echo "https://www.japanmacroadvisors.com/".$title_image;?>" alt="title image" class="pmc_imgcon">
				</div>
				<div class="col-md-8">
					<h5><?php echo $title;?>, <?php echo date('F d, Y',strtotime($date));?></h5>
					<?php if($materials['is_premium'] == 'N'){?>
					<!-- <a  href="">Download</a> -->
					<div class="spacer10"></div>
					<a class="btn btn-secondry" href="<?php echo $this->url('materials/download/'.$id.'/'.$material_path);?>" target="_blank">
						<i class="fa fa-download"></i> <?php echo $material_path;?>
					</a>
					<?php }else{
						$premium_cat_lnk_cls = '';
						if($this->resultSet['result']['login_status']==true) {
						// check permission
							if($this->resultSet['result']['access_permission']==true){ ?>
							<div class="spacer10"></div>
							<a class="btn btn-secondry" href="<?php echo $this->url('materials/download/'.$id.'/'.$material_path);?>" target="_blank">
								<i class="fa fa-download"></i> <?php echo $material_path;?>
							</a>
							<?php } else {
							// show upgrade box
								$premium_cat_lnk_cls = 'lnk_inactive'; ?>
								<div class="spacer10"></div>
								<a class="btn btn-secondry <?php echo $premium_cat_lnk_cls;?>" href="javascript:void(0)" onclick="JMA.User.showUpgradeBox('premium','<?php echo $this->url('materials/download/'.$id.'/'.$material_path);?>')" class="<?php echo $premium_cat_lnk_cls;?>">
									<i class="fa fa-download"></i> <?php echo $material_path;?>
								</a>
								<?php }
							}else{
							// Show login window
								$premium_cat_lnk_cls = 'lnk_inactive';?>
								<div class="spacer10"></div>
								<a class="btn btn-secondry <?php echo $premium_cat_lnk_cls;?>" href="javascript:void(0)" onclick="JMA.User.showLoginBox('premium','<?php echo $this->url('materials/download/'.$id.'/'.$material_path);?>')" class="<?php echo $premium_cat_lnk_cls;?>">
									<i class="fa fa-download"></i> <?php echo $material_path;?>
								</a>
								<?php
							}
							?>
							<?php }?>
						</div>
					</div>
					<?php echo $count == $i ? '<hr>' : '<hr>'; ?>
					<?php } else {?>
					<h4 class="matinjap_ttl"><?php echo $title;?></h4>
					<?php if($materials['is_premium'] == 'N'){?>
					<p class="matinjap_con">
						<a href="<?php echo $this->url('materials/download/'.$id.'/'.$material_path);?>" target="_blank"><?php echo $material_path;?></a>
					</p>
					<?php }else{
						$premium_cat_lnk_cls = '';
						if($this->resultSet['result']['login_status']==true) {
						// check permission
							if($this->resultSet['result']['access_permission']==true){ ?>
							<p>
								<a href="<?php echo $this->url('materials/download/'.$id.'/'.$material_path);?>" target="_blank"><?php echo $material_path;?></a>
							</p>
							<?php } else {
							// show upgrade box
								$premium_cat_lnk_cls = 'lnk_inactive'; ?>
								<p>
									<a class="<?php echo $premium_cat_lnk_cls;?>" href="javascript:void(0)" onclick="JMA.User.showUpgradeBox()"><?php echo $material_path;?></a>
								</p>
								<?php
							}
						}else{
							// Show login window
							$premium_cat_lnk_cls = 'lnk_inactive';?>
							<p>
								<a class="<?php echo $premium_cat_lnk_cls;?>" href="javascript:void(0)" onclick="JMA.User.showLoginBox()"><?php echo $material_path;?></a>
							</p>
							<?php
						}
						?>
						<?php }?>
						<?php echo $count == $i ? '<hr>' : '<hr>'; ?>
						<?php }?>
						<?php
					}
				}
				?>
				<?php
 // include('view/templates/rightside.php');
				?>
			</div>
			<form name="download" id="download" method="post" action="<?php echo $this->url('chart/downloadxls')?>">
				<input type="hidden" name="data" id="data" value="" />
			</form>
