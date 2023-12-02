<?php
$resn = $this->resultSet['result']['posts'];
$category_path = $this->resultSet['result']['category_path'];
?>
<div class="col-xs-12 col-md-10">
		<?php
		$count = count($resn);
		if($count==0)
		{
			?>
			<h3>Sorry, No items found</h3>
			<?php
		} else {
			for($i=0;$i<$count;$i++)
			{
				$today =  date('y-m-d');
				$today =  strtotime($today);
				$today = strtotime("-10 day", $today);
				$resn_date =  strtotime($resn[$i]['post_released']);
				$news_link_url = $this->url(array('controller'=>'reports','action'=>'view','params'=>$category_path.$resn[$i]['post_url']));
				?>
				<div class="<?php if ($i == 0) echo "first-section";?> <?php if ($i == $count - 1) echo "last-section";?>">
					<div class="sec-title sec-date">
						<?php if(!empty($resn[$i]['post_released'])) {?>
						<span class="released <?php if ($resn_date > $today) echo "first"; ?>">
							<?php echo stripslashes($resn[$i]['post_released']);?>
						</span>
						<?php }?>
						<h1>
							<a class="title-link" href="<?php echo $news_link_url;?>">
								<?php if ($resn_date > $today) echo '<span class="latest">Latest</span>'; ?>
								<?php echo stripslashes($resn[$i]['post_title']);?>
							</a>
						</h1>
						<div class="sttl-line"></div>
					</div>
					<?php if(!empty($resn[$i]['post_heading'])) {?> 
					<h5><?php echo stripslashes($resn[$i]['post_heading']);?></h5>
					<?php }?>
					<?php if(!empty($resn[$i]['post_subheading'])) {?>
					<h3><?php echo stripslashes($resn[$i]['post_subheading']);?></h3>
					<?php }?>
					<p>
						<?php echo $resn[$i]['post_cms_small']; // cleanMyCkEditor($resn[$i]['post_cms_small']);?>
					</p>
					<p class="text-right"><a class="readmore" href="<?php echo $news_link_url;?>"> Read more.. </a></p>
				</div>
				<?php
			}
		}
		?>
</div>
<?php
//include('view/templates/rightside.php');
?>
<form name="download" id="download" method="post" action="<?php echo $this->url('chart/downloadxls')?>">
	<input type="hidden" name="data" id="data" value="" />
</form>
<script type="text/javascript">
$(document).ready(function(e) {
	<?php $cat_array_og = json_encode($this->resultSet['result']['category_array']); ?>
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