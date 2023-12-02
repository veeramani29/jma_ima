<?php include('header.php');?>

<script>

function callPostStatus(id,status,Stype)
{
   document.getElementById("divProgressLayer").style.display = "block";
   window.location.href = "postStatus.php?id="+id+"&status="+status+"&postType="+Stype;
  
}


</script>

<script>
function deletePost(id){
   var agree=confirm("Are you sure you want to delete this post?");
  if(agree){
      var url = 'deletePost.php?id='+id;
      window.location = url;
  }
  else{
      return false;
  }
}

</script>
<style type="text/css">
        #imgContainer
        {
            height: 100%;
            width: 100%;
            position: absolute;
        }
        #divProgressLayer
        {
            z-index: 999;
    position: fixed;
    background-color: rgba(255,255,255,0.8);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
        }
		#divProgressLayer > img{
			position: absolute;
    top: calc(50% - 120px);
    left: calc(50% - 120px);
		}
</style>
<!-- start content -->


<div id="content">
     <div id="divProgressLayer" style="display: none;">
	  <img src="../images/loader.gif" />
    </div>
	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Posts</h1>
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
					<th class="table-header-repeat line-left minwidth-1"><a href="">Category Name</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Copy Writer</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Post Title</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Post Type</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Copy writer status</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Post publish status</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getPost = $postObj->getPostList();
                                    if(count($getPost)>0){
                                         for($i=0;$i<count($getPost);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getPost[$i]['post_id']; if($getPost[$i]['post_copywriter_status']=='N' || $getPost[$i]['post_publish_status']=='N') { ?> <img src="new_red.png" alt="New" title="New"   /><?php }?></td>
					<td><?php echo $catObj->getIndividualCategory($getPost[$i]['post_category_id'])?></td>
					<td><?php echo $copywriterObj->getsingleCopyWriter($getPost[$i]['copywriter_id'])?></td>
					<td><?php echo stripslashes($getPost[$i]['post_title'])?></td>
                                         <td>
                                             <?php 
                                                    $postType = $getPost[$i]['post_type'];
                                                    
                                                    if($postType == "N"){
                                                        echo "News";
                                                    }
                                                    else{
                                                        echo "Page"; 
                                                    }
                                             ?>
                                        </td>
                                        <td><?php echo $getPost[$i]['post_copywriter_status']?></td>
                                        <td><?php echo $getPost[$i]['post_publish_status']?></td>
					
					<td class="options-width">
					<a href="../reports/preview/<?php echo $getPost[$i]['post_url'] ?>" title="Preview"  target="_blank">Preview</a>
					<a href="editpost.php?id=<?php echo $getPost[$i]['post_id'] ?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="javascript:void(0);" onclick="return callPostStatus('<?php echo $getPost[$i]['post_id'] ?>','<?php echo $getPost[$i]['post_publish_status'] ?>','<?php echo $getPost[$i]['post_type'] ?>');" title="Status" class="icon-5 info-tooltip"></a>
					<!--<a href="postStatus.php?id=<?php echo $getPost[$i]['post_id'] ?>&status=<?php echo $getPost[$i]['post_publish_status'] ?>&postType=<?php echo $getPost[$i]['post_type'] ?>" title="Status" class="icon-5 info-tooltip"></a>--->
                                        <a href="#" style="margin: 0 8px 0 8px" onclick="deletePost('<?php echo $getPost[$i]['post_id'];?>')" title="Delete" id="post_del" class="icon-2 info-tooltip"></a>
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