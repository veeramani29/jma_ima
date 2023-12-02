<?php $__env->startSection('content'); ?>
<div class="col-xs-12 col-md-10 ckediter_fix">
	<?php
	if(isset($result['status']) &&  $result['status']!= 1) {
		?>
		<h3>Sorry, <?php echo $this->resultSet['message'];?></h3>
		<?php 
	} else {
		$resn = $result['posts'];
		?>
		<?php
		$count = count($resn);
		if($count==0)
		{
			?>
			<h3>Sorry, No news found</h3>
			<?php 
		}
		else { ?>
		<div itemscope itemtype="http://schema.org/Article">
			<div class="sec-date main-title ind_maittl">
				
				<?php /* if(!empty($resn[0]['post_released'])) {?><span class="released"><?php echo stripslashes($resn[0]['post_released']);?></span><?php }*/?> 
					<?php $published = isset($resn[0]['post_datetime'])?date_create($resn[0]['post_datetime']):''; ?>
					<span class="released"><?php echo isset($published)?date_format($published,'F d Y'):'';?></span>
				
				<h1 itemprop="name" class="<?php if(empty($resn[0]['post_released'])) echo "title-only"; ?>">
					<?php echo stripslashes($resn[0]['post_title']);?>
				</h1>
				<div class="folussoc_con fus_indicator">
					<ul class="list_socail">
						<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;facebook">
							<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="facebook">
								<i class="fa fa-facebook" aria-hidden="true"></i>
							</a>
						</li>
						<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;twitter">
							<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="twitter">
								<i class="fa fa-twitter" aria-hidden="true"></i>
							</a>
						</li>
						<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;google+">
							<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="google">
								<i class="fa fa-google-plus" aria-hidden="true"></i>
							</a>
						</li>
						<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;linkedin">
							<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="linkedin">
								<i class="fa fa-linkedin" aria-hidden="true"></i>
							</a>
						</li>
						<input type="hidden" class="graph_share_input form-control" name="common_share_url" id="common_share_url" value="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>">
					</ul>
				</div>
				<div class="mttl-line"></div>
			</div>
			<div class="folussoc_con fus_indicator fusi_mobile">
				<ul class="list_socail">
					<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;facebook">
						<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="facebook">
							<i class="fa fa-facebook" aria-hidden="true"></i>
						</a>
					</li>
					<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;twitter">
						<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="twitter">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</li>
					<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;google+">
						<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="google">
							<i class="fa fa-google-plus" aria-hidden="true"></i>
						</a>
					</li>
					<li data-toggle="tooltip" title="Share&nbsp;on&nbsp;linkedin">
						<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="linkedin">
							<i class="fa fa-linkedin" aria-hidden="true"></i>
						</a>
					</li>
					<input type="hidden" class="graph_share_input form-control" name="common_share_url" id="common_share_url" value="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>">
				</ul>
			</div>
			<?php if(!empty($resn[0]['post_heading'])) {?>
			<h5><?php echo stripslashes($resn[0]['post_heading']);?></h5>
			<?php }?>
			<?php if(!empty($resn[0]['post_subheading'])) {?>
			<h3><?php echo stripslashes($resn[0]['post_subheading']);?></h3>
			<?php }?>
			
			<div class="clearfix"></div>
			<div itemprop="articleBody">
				<?php echo $resn[0]['post_cms']; // makeChart(cleanMyCkEditor($resn[0]['post_cms']));?>
			</div>
			<div class="addthis_sharing_toolbox" style="float: right"></div>
			<meta itemprop="articleSection" content="India Economy">
			<meta itemprop="url" content="http:/<?php echo $_SERVER['REQUEST_URI'];?>">
			<span itemprop="author" itemscope itemtype="http://schema.org/Person">
				<meta itemprop="datePublished" content="<?php //echo  if($resn[0]['post_datetime']!=null)?date_create($resn[0]['post_datetime']):''; ?>">
				<meta itemprop="name" content="Takuji Okubo">
			</span>
			<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<meta itemprop="name" content="Indiamacroadvisors">
			</span>
		</div>
		<?php
	}
	?>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	<?php $cat_array_og = isset($result['category_array'])?json_encode($result['category_array']):''; ?>
	var category_array = JSON.parse('<?php echo $cat_array_og;?>');
	var cat_selected = '';
	$.each(category_array,function(catId,row){
		cat_selected = '.left_cat_'+catId;
		$(cat_selected).addClass("minus");
		$(cat_selected).parent('ul').css('display','block');
	});
	$(cat_selected).removeClass('minus');
	$(cat_selected).addClass('active');
});
</script>
<?php
}
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>