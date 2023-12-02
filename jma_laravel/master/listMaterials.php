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
    function deletematerial(id){
   var agree=confirm("Are you sure you want to delete?");
  if(agree){
      var url = 'deletematerial.php?id='+id;
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
		<h1>Materials</h1>
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
					<th class="table-header-repeat line-left"><a href="">Type</a></th>
					<th class="table-header-repeat line-left"><a href="">Title</a>	</th>
					<th class="table-header-repeat line-left"><a href="">Title Image</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Material Path</a></th>
                    <th class="table-header-options line-left minwidth-1"><a href="">Date</a></th>
                    <th class="table-header-options line-left minwidth-1"><a href="">Premium?</a></th>
                    <th class="table-header-options line-left minwidth-1"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getMaterial = $materialObj->getMaterialsList();
                                    if(count($getMaterial)>0){
                                         for($i=0;$i<count($getMaterial);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getMaterial[$i]['material_id'];?></td>
					<td><?php echo $getMaterial[$i]['material_type'];?></td>
					<td class="options-width"><?php echo stripslashes($getMaterial[$i]['material_title']);?></td>
					<td><?php if($getMaterial[$i]['material_type'] == 'general' || $getMaterial[$i]['material_type'] == 'oxford') { ?><img src="image.php?path=<?php echo $getMaterial[$i]['material_title_img'];?>&w=100&h=100"><?php } ?></td>
                    <td><?php echo $getMaterial[$i]['material_path']?></td>
					<td><?php echo date('d-m-Y',strtotime($getMaterial[$i]['material_date']))?></td>
					<td><?php echo $getMaterial[$i]['is_premium']?></td>
					<td class="options-width">
					<a href="editmaterials.php?id=<?php echo $getMaterial[$i]['material_id'] ?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="#" onclick="deletematerial('<?php echo $getMaterial[$i]['material_id']?>')" title="Delete" class="icon-2 info-tooltip"></a>					</td>
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
