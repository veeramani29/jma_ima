@extends('templates.default')
@section('content')
<?php
$resn = $result['posts'];

$category_path = isset($result['category_path'])?$result['category_path']:'';

?>
<div class="col-xs-12">
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
				$resn_date =  strtotime(isset($resn[$i]['post_released'])?$resn[$i]['post_released']:'');
				$news_link_url="href=".url('/reports/view/'.$category_path.$resn[$i]['post_url'])."";
			/*	if($resn[$i]['premium_news']=='Y' && (isset($_SESSION['user']) && $_SESSION['user']['user_type_id']==1 || !isset($_SESSION['user']))){
				if(isset($_SESSION['user']) && $_SESSION['user']['user_type_id']==1){
				$news_link_url="data-toggle='modal' data-target='#Dv_modal_upgrade_premium_content'";  
				}else{
				$news_link_url="href='javascript:JMA.User.showLoginBox(".'"premium","'.url('/reports/view/'.$category_path.$resn[$i]['post_url']).'"'.");'";	
				}

				}else{
				$news_link_url = "href=".url("/reports/view/".$category_path.$resn[$i]['post_url']);
				}*/
				?>
				<div class="<?php if ($i == 0) echo "first-section";?> <?php if ($i == $count - 1) echo "last-section";?>">
					<div class="sec-title sec-date">
						<?php if(!empty($resn[$i]['post_released'])) {?>
						<span class="released <?php if ($resn_date > $today) echo "first"; ?>">
							<?php echo stripslashes($resn[$i]['post_released']);?>
						</span>
						<?php }?>
						<h1>
							<a class="title-link" <?php echo $news_link_url;?>>
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
						<?php echo isset($resn[$i]['post_cms_small'])?$resn[$i]['post_cms_small']:''; // cleanMyCkEditor($resn[$i]['post_cms_small']);?>
					</p>
					<p class="text-right"><a class="readmore" <?php echo $news_link_url;?>> Read more.. </a></p>
				</div>
				<?php
				
			}
		}
		?>
</div>
<?php
//include('view/templates/rightside.php');
?>
<form name="download" id="download" method="post" action="<?php echo url('chart/downloadxls')?>">
	<input type="hidden" name="data" id="data" value="" />
</form>
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
@stop