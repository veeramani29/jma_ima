@extends('templates.default')
@section('content')
<div class="col-xs-12 col-md-10">
	<?php
	if(isset($result['status']) && $result['status'] != 1) {
		?>
		<h3>Sorry, <?php echo isset($result['message'])?$result['message']:'';?></h3>
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
		} else {
			?>
			<div itemscope itemtype="http://schema.org/Article">
				<div class="sec-date main-title">
					<?php /* if(!empty($resn[0]['post_released'])) {?><span class="released"><?php echo stripslashes($resn[0]['post_released']);?></span><?php }*/?> 
					<?php  $published = isset($resn[0]['post_released'])?date_create($resn[0]['post_released']):''; ?>
					<span class="released"><?php echo isset($published)?date_format($published,'F d Y'):'';?></span>
					<h1 itemprop="name" class="<?php if(empty($resn[0]['post_released'])) echo "title-only"; ?>"><?php echo stripslashes($resn[0]['post_title']);?></h1>
					<div class="mttl-line"></div>
				</div>
				<?php if(!empty($resn[0]['post_heading'])) {?><h5 style="margin:0px"><?php echo stripslashes($resn[0]['post_heading']);?></h5><?php }?>
				<?php if(!empty($resn[0]['post_subheading'])) {?><h3><?php echo stripslashes($resn[0]['post_subheading']);?></h3><?php }?>
				<div itemprop="articleBody">
						<?php	if($resn[0]['premium_news']=='Y' && $resn[0]['post_type']=='N' && ((isset($_SESSION['user']) && $_SESSION['user']['user_type_id']==1) || !isset($_SESSION['user']))){
					echo "<p><strong>Summary</strong></p><p class='rdt_readmore'>".$resn[0]['post_cms_small']."</p>";
					if(!isset($_SESSION['user'])){
                    $popup_link_url="href='javascript:JMA.User.showLoginBox(".'"premium","'.url()->current().'"'.");'";
               }else{
           $popup_link_url="data-toggle='modal' data-target='#Dv_modal_upgrade_premium_content'";  
               }
               if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']['user_type_id']==1)){
					if((isset($_SESSION['user']) && $_SESSION['user']['user_type_id']==1)){ 
$text_msg="<p><strong>If you are a Free account user registered before Jan 2018, please upgrade your subscription status from <a href=".url('user/myaccount/subscription').">here</a>. </strong></p>";
}else{

$text_msg="<p><strong>If you are already an IMA subscriber please <a class='subscriber_login' ".$popup_link_url." >login</a></strong></p>";
}
					echo "<div style='padding:20px 20px 11px;background-color: #dddddd;'><p><strong> To read a full report, please become a Premium subscriber.</strong></p><a target='_blank' href='".url('products')."' class='rdt_modal btn btn-primary'>Start a Premium subscription <i class='fa fa-angle-right' aria-hidden='true'></i></a>".$text_msg."</div>";
		?>
			
			   <?php }} else{  ?>
		<?php echo $resn[0]['post_cms']; } ?>
				</div>
				<div class="addthis_sharing_toolbox" style="float: right"></div>
				<meta itemprop="articleSection" content="India Economy">
				<meta itemprop="url" content="http:/<?php echo $_SERVER['REQUEST_URI'];?>">
				<span itemprop="author" itemscope itemtype="http://schema.org/Person">
					<meta itemprop="datePublished" content="<?php //echo isset($resn[0]['post_datetime'])?date_create($resn[0]['post_datetime']):'';?>">
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
	<?php
// include('view/templates/rightside.php');
	?>
	<script type="text/javascript">
	$(document).ready(function(e) {
		<?php $cat_array_og = json_encode(isset($result['category_array'])?$result['category_array']:''); ?>
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
@stop