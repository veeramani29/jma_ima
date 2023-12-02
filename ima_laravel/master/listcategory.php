<?php include('header.php');?>

<style>
    .order_select{
        margin: 0 0 0 7px;
    }
 </style>
<!-- start content --> 
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Categories</h1>
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
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Parent Name</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Order</a></th>
                                        <th class="table-header-repeat line-left"><a href="">Status</a></th>
					<th class="table-header-repeat line-left"><a href="">Icon display</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                   $getCatsOrder = $catObj->getAllCatSubCat();
                                    
                                    if(count($getCatsOrder)>0){
                                         for($i=0;$i<count($getCatsOrder);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                          $getCats  = $catObj->getCategoryByOrder($getCatsOrder[$i]);
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getCats[0]['post_category_id'];?></td>
					<td><?php echo $getCats[0]['post_category_name']?></td>
					<td><?php echo $catObj->getParent($getCats[0]['post_category_parent_id'])?></td>
                                        
                                        <td>
                                            
                                            <?php 
                                                   // if($getCats[$0]['post_category_parent_id']!=0){
                                                      echo $getCats[0]['post_category_parent_id']." . ";
                                                    //}
                                                 $getOrderlist =  $catObj->getOrder($getCats[0]['post_category_parent_id'],$getCats[0]['post_category_id']);
                                                 echo $getCats[0]['category_order']." ".$getOrderlist;
                                             ?>
                                        </td>
                                        <td><?php echo $getCats[0]['post_category_status']?></td>
                                        
                                        
					<td align="center">
                    <?php if($getCats[0]['new_icon_display'] == 'Y'){?><A HREF="categoryiconStatus.php?Id=<?php echo $getCats[0]['post_category_id'];?>&status=N" title="Deactivate icon display"><img src="../images/active.gif" border="0" width="10" height="10" alt='Deactivate  icon display' /></A><?php }else{?><A HREF="categoryiconStatus.php?Id=<?php echo $getCats[0]['post_category_id'];?>&status=Y" title="Activate icon display"><img src="../images/inactive.gif" border="0" width="10" height="10" alt='Activate icon display' /></A><?php }?>
                    </td>
					
					<td class="options-width">
					<a href="editCategory.php?id=<?php echo $getCats[0]['post_category_id'] ?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="deletecategory.php?id=<?php echo $getCats[0]['post_category_id'] ?>" title="Delete" class="icon-2 info-tooltip"></a>
					<a href="categoryStatus.php?id=<?php echo $getCats[0]['post_category_id'] ?>&status=<?php echo $getCats[0]['post_category_status'] ?>" title="Status" class="icon-5 info-tooltip"></a>
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

<script>
   $(document).ready(function() {
       
       $('select').change(function() {
           var selId  = $(this).attr('id');
           var selIdArr  = selId.split("_");
           var catId     = selIdArr[1];
           var order     = $('#'+selId).val();
           var loc  = "changeMyOrder.php?catId="+catId+"&order="+order;
           window.location = loc;
       });
 
   });
 </script>
    
<?php include('footer.php');?>