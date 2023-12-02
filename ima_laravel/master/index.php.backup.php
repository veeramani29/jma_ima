<?php 
include('include/include.php');
$post_category_id = 0;
if(isset($_REQUEST['cat_id']))
{
	$post_category_id = $_REQUEST['cat_id'];
	$sql = "SELECT * FROM `post_category` WHERE post_category_status ='Y' AND post_category_parent_id <> 0 AND post_category_id ='$post_category_id'";
	$result = $db->selectQuery($sql);
	if(count($result)==0)
	{
			$sql = "SELECT * FROM `post_category` WHERE post_category_status ='Y' AND post_category_parent_id = '$post_category_id'";
			$list_res = $db->selectQuery($sql);
			if(count($list_res)>0)
				$post_category_id = $list_res[0]['post_category_id'];
	}
}
$query = "SELECT * FROM `post` WHERE post_publish_status ='Y' ";
if(intval($post_category_id))
{
	$query.= "AND post_category_id ='$post_category_id' ORDER BY `post_id` DESC";
}
else
{
	//$query.= "AND post_category_id IN (2,3,4,5,6) ORDER BY `post_id` LIMIT 0,5";
	$query.= "AND post_type='N' ORDER BY `post_id` DESC LIMIT 0,5";
}
//echo $query;
$resn = $db->selectQuery($query);


if(isset($_REQUEST['cat_id']) && count($resn) == 1)
{
	if($resn[0]['post_meta_title']) $meta_title = $resn[0]['post_meta_title'];
	else $meta_title = stripslashes($resn[0]['post_title']);
	$meta_keywords = $resn[0]['post_meta_keywords'];
	$meta_description = $resn[0]['post_meta_description'];
}
else if(isset($_REQUEST['cat_id']) && count($resn) > 1 && $result){
	if($result[0]['category_meta_title']) $meta_title = $result[0]['category_meta_title'];
	else $meta_title = stripslashes($result[0]['post_category_name']);
	$meta_keywords = $result[0]['category_meta_keywords'];
	$meta_description = $result[0]['category_meta_description'];
		
}
else if(!isset($_REQUEST['cat_id'])) {
	$meta_result = $db->selectQuery("SELECT * FROM meta where filename like 'index'");
	if(isset($meta_result[0]))
	{
		$meta_title = $meta_result[0]['title'];
		$meta_keywords = $meta_result[0]['keywords'];
		$meta_description = $meta_result[0]['description'];
	}


}


include('include/head.php');
include('include/leftside.php');
?>  

    <div class="content_midsection <?php if(count($resn) == 1) echo "full"; ?>">
	  <?php if(!isset($_REQUEST['cat_id'])) {?>
      <div class="reports">
     <h3 class="recently">Recently published reports</h3>
      </div>
	  <?php } ?>
    <?php 
	if(count($resn)==0)
	{
		?>
      <div class="mid_singlesection">
        <h3>Sorry, <span>No news found</span></h3>
      </div>
        <?php
	}
	else
	{
		$count = count($resn);
		//if($count>1 || !intval($user_id))
		if($count>1)
		{
			for($i=0;$i<$count;$i++)
			{
			$today =  date('y-m-d');
			$today =  strtotime($today);
			$today = strtotime("-10 day", $today);
			$resn_date =  strtotime($resn[$i]['post_released']);
				?>
			  <div class="mid_singlesection <?php if ($i == 0) echo "first-section";?> <?php if ($i == $count - 1) echo "last-section";?>"><?php if ($resn_date > $today) echo '<span class="latest">Latest</span>'; ?>
  <?php if(!empty($resn[$i]['post_released'])) {?><span class="released <?php if ($resn_date > $today) echo "first"; ?>"><?php echo stripslashes($resn[$i]['post_released']);?></span><?php }?>
				<div class="title"><a  class="title-link" href="news.php?id=<?php echo $resn[$i]['post_id'];?>"><h3 class="title"><?php echo stripslashes($resn[$i]['post_title']);?></h3></a></div>
                               
				    <?php if(!empty($resn[$i]['post_heading'])) {?> <h5><?php echo stripslashes($resn[$i]['post_heading']);?></h5><?php }?>
                                
				<?php if(!empty($resn[$i]['post_subheading'])) {?><h3><?php echo stripslashes($resn[$i]['post_subheading']);?></h3><?php }?>
                              
				<p><?php echo cleanMyCkEditor($resn[$i]['post_cms_small']);?><a  class="readmore" href="news.php?id=<?php echo $resn[$i]['post_id'];?>"> Read more.. </a></p>
			  </div>
				<?php
			}
		}
		else
		{
			?>
			  <div class="sample_singlesection">

			  

 <?php if(!empty($resn[0]['post_released'])) {?><time itemprop="datePublished" class="released" datetime="<?php echo stripslashes($resn[0]['post_released']);?>"><?php echo stripslashes($resn[0]['post_released']);?></time><?php }?>


				<h3 class="title <?php if(empty($resn[0]['post_released'])) echo "title-only"; ?>"><?php echo stripslashes($resn[0]['post_title']);?></h3>
                               
				<?php if(!empty($resn[0]['post_heading'])) {?><h5><?php echo stripslashes($resn[0]['post_heading']);?></h5><?php }?>
				<?php if(!empty($resn[0]['post_subheading'])) {?><h3><?php echo stripslashes($resn[0]['post_subheading']);?></h3><?php }?>
				<?php echo makeChart(cleanMyCkEditor($resn[0]['post_cms']));?>
			  </div>
            <?php
		}
	}
	?>
    </div>
<script type="text/javascript">
$(document).ready(function(e) {
	var cat_selected = '.left_cat_'+<?php echo $post_category_id;?>;
	$(cat_selected).addClass('active')
        $(cat_selected).parent().parent().addClass("minus");
	$(cat_selected).parent('ul').css('display','block');
	var cat_parent =$(cat_selected).parent('ul');
	//alert(cat_parent.attr('class'));
});
</script>
<?php 
if(count($resn) != 1) include('include/rightside.php');?>
<form name="download" id="download" method="post" action="downloadxls.php">
<input type="hidden" name="data" id="data" value="" />

</form>
<?php
include('include/footer.php');
?>  
