<?php include('header.php');?>


<script>
function deleteSeoPost(id){
   var agree=confirm("Are you sure you want to delete this post?");
  if(agree){
      var url = 'deleteseopage.php?id='+id;
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
		<h1>Posts</h1>
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
					<th class="table-header-repeat line-left minwidth-1"><a href="">Id</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Title</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">URL slug</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Meta title</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Meta description</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Mata keywords</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Linked post</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getPost = $seopages->getAllPages();
                                    if(count($getPost)>0){
                                         for($i=0;$i<count($getPost);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getPost[$i]['id'];?></td>
					<td><?php echo $getPost[$i]['title']?></td>
					<td><?php echo $getPost[$i]['slug']?></td>
					<td><?php echo $getPost[$i]['meta_title']?></td>
					<td><?php echo $getPost[$i]['meta_description']?></td>
                    <td><?php echo $getPost[$i]['mata_keywords']?></td>
                    <td><?php echo $getPost[$i]['post_title']?></td>
					<td class="options-width">
						<a href="editseopage.php?id=<?php echo $getPost[$i]['id'] ?>" title="Edit" class="icon-1 info-tooltip"></a>
						<a href="#" style="margin: 0 8px 0 8px" onclick="deleteSeoPost('<?php echo $getPost[$i]['id'];?>')" title="Delete" id="post_del" class="icon-2 info-tooltip"></a>
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