<?php include('header.php');
function editorfix($value)
{

$order   = array("\\r\\n", "\\n", "\\r", "rn","<p>&nbsp;</p>","\\","\'");
$replace = array(" ", " ", "", "","","","","'");
$value = str_replace($order, $replace, $value); 
return $value;
}
?>

<script>
    function deletebriefseries(id){
   var agree=confirm("Are you sure you want to delete?");
  if(agree){
      var url = 'deletebriefseries.php?id='+id;
      window.location = url;
  }
  else{
      return false;
  }
}
</script>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Brief Series</h1>
	</div>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
			
				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					
					<th class="table-header-repeat line-left"><a href="">Id</a>	</th>
					<th class="table-header-repeat line-left"><a href="">Type</a></th>
					<th class="table-header-repeat line-left"><a href="">Title</a>	</th>
					<th class="table-header-repeat line-left"><a href="">Title Image</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Smmery Path</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">PPT Path</a></th>
                    <th class="table-header-options line-left minwidth-1"><a href="">Date</a></th>
                    <th class="table-header-options line-left minwidth-1"><a href="">Premium?</a></th>
                    <th class="table-header-options line-left minwidth-1"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getBriefSeries = $briefSeriesObj->getBriefSeries();
                                    if(count($getBriefSeries)>0){
                                         for($i=0;$i<count($getBriefSeries);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getBriefSeries[$i]['briefseries_id'];?></td>
					<td><?php echo $getBriefSeries[$i]['briefseries_type'];?></td>
					<td class="options-width"><?php echo stripslashes($getBriefSeries[$i]['briefseries_title']);?></td>
					<td><?php if($getBriefSeries[$i]['briefseries_type'] == 'general' || $getBriefSeries[$i]['briefseries_type'] == 'oxford') { ?><img src="../<?php echo $getBriefSeries[$i]['briefseries_title_img'];?>" width="100" height="100"><?php } ?></td>
                    <td><?php echo $getBriefSeries[$i]['briefseries_summary_path']?></td>
					<td><?php echo $getBriefSeries[$i]['briefseries_ppt_path']?></td>
					<td><?php echo date('d-m-Y',strtotime($getBriefSeries[$i]['briefseries_date']))?></td>
					<td><?php echo $getBriefSeries[$i]['is_premium']?></td>
					<td class="options-width">
					<a href="editbriefseries.php?id=<?php echo $getBriefSeries[$i]['briefseries_id'] ?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="#" onclick="deletebriefseries('<?php echo $getBriefSeries[$i]['briefseries_id']?>')" title="Delete" class="icon-2 info-tooltip"></a>					</td>
				</tr>
                                <?php
                                       }
                                   } 
								   else { ?>
								   <tr ><td colspan="9" align="center" ><span style="color:red;">Their is no record founds</span></td></tr>
								   <?php } ?>
				</table>
				<!--  end product-table................................... --> 
				</form>
			</div>
			<!--  end content-table  -->
			
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>

</div>
<?php include('footer.php');?>
