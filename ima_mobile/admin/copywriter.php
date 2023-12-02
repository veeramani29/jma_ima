<?php include('header.php');?>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Copy Writer</h1>
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
					
					<th class="table-header-repeat line-left minwidth-1"><a href="">Id</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">User Name</a></th>
					<th class="table-header-repeat line-left"><a href="">Email</a></th>
					<th class="table-header-repeat line-left"><a href="">Date</a></th>
					<th class="table-header-repeat line-left"><a href="">Status</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                   $copywriterList = $copywriterObj->getCopyWriters();
                                   if(count($copywriterList)>0){
                                       for($i=0;$i<count($copywriterList);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $copywriterList[$i]['copywriter_id'];?></td>
					<td><?php echo $copywriterList[$i]['copywriter_user'];?></td>
					<td><a href=""><?php echo $copywriterList[$i]['copywriter_email'];?></a></td>
					<td><?php echo $copywriterList[$i]['copywriter_date_created'];?></td>
					<td><?php echo $copywriterList[$i]['copywriter_status'];?></td>
					<td class="options-width">
					<a href="editcopywriter.php?id=<?php echo $copywriterList[$i]['copywriter_id']; ?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="" title="Delete" class="icon-2 info-tooltip"></a>
					<a href="copywriterStatus.php?id=<?php echo $copywriterList[$i]['copywriter_id']; ?>&status=<?php echo $copywriterList[$i]['copywriter_status']; ?>" title="Status" class="icon-5 info-tooltip"></a>
					</td>
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