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
    function deleteMedia(id){
   var agree=confirm("Are you sure you want to delete?");
  if(agree){
      var url = 'deleteMedia.php?id='+id;
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
		<h1>Media</h1>
	</div>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slider image" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slider image" /></th>
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
					<th class="table-header-repeat line-left"><a href="">Notice</a>	</th>
					<th class="table-header-repeat line-left"><a href="">Sort</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Media Text</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Media Image</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Media Link</a></th>
					                    <th class="table-header-options line-left minwidth-1"><a href="">Date</a></th>
                    <th class="table-header-options line-left minwidth-1"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getMedia = $mediaObj->getMediaList();
                                    if(count($getMedia)>0){
                                         for($i=0;$i<count($getMedia);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getMedia[$i]['media_id'];?></td>
					<td><?php if($getMedia[$i]['media_notice']) echo 'Yes';?></td>
					<td><?php echo $getMedia[$i]['media_sort'];?></td>
                                        <td><?php echo $getMedia[$i]['media_value_text']; //editorfix($getMedia[$i]['media_value_text'])?></td>
					<td>
                                            <?php if($getMedia[$i]['media_value_img'] != ''){?>
                                            <img src="../public/uploads/media/<?php echo $getMedia[$i]['media_value_img'] ?>" widht="75" height="75" alt="media image"/>
                                            <br/><a  style="color:#959595" href="deleteMediaImage.php?id=<?php echo $getMedia[$i]['media_id'] ?>">Delete</a>
                                            <?php } ?>                                        </td>
					<td><?php echo $getMedia[$i]['media_link']?></td>
                                       
					
					<td class="options-width"><?php echo date('d-m-Y',strtotime($getMedia[$i]['media_date']))?></td>
					<td class="options-width">
					<a href="editmedia.php?id=<?php echo $getMedia[$i]['media_id'] ?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="#" onclick="deleteMedia('<?php echo $getMedia[$i]['media_id']?>')" title="Delete" class="icon-2 info-tooltip"></a>					</td>
				</tr>
                                <?php
                                       }
                                   }
                                ?>
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
