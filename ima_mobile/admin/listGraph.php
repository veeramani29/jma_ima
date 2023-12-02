<?php include('header.php');?>
<!-- start content -->
<?php
function editorfix($value)
{
// sometimes FCKeditor wants to add \r\n, so replace it with a space 
// sometimes FCKeditor wants to add <p>&nbsp;</p>, so replace it with nothing

$order   = array("\\r\\n", "\\n", "\\r", "rn","<p>&nbsp;</p>");
$replace = array(" ", " ", "", "","");
$value = str_replace($order, $replace, $value); 
return $value;
}
if($_REQUEST['delete'] == 'true'){
    $chartObj->deleteGraphdetails($_REQUEST['gid']);
	$chartObj->deletegraph_values($_REQUEST['gid']);
	$successMsg = "Graph deleted successfully.";
	echo $successMsg;
	header("Location:listGraph.php");
    //deleteGraph($_REQUEST['gid']);
}
?>
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Graph</h1>
	</div>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?php echo $themeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?php echo $themeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
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
					<th class="table-header-repeat line-left minwidth-1"><a href="">Source </a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Link</a></th>
                                        <th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getGraph = $chartObj->getGraphList(); //print_r($getGraph);
                                    if(count($getGraph)>0){
                                         for($i=0;$i<count($getGraph);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                      
                                ?>
                                
				               
                  <tr class="<?php echo $class?>">	 
					<td><?php echo $getGraph[$i]['gid'];?></td>
					<td><?php echo $getGraph[$i]['title'];?></td>
                    <td><?php echo $getGraph[$i]['source'];?></td>
					<td><textarea cols="50" rows="3"><?php echo '<iframe  width="600" height="549" id="frame"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://indiamacroadvisors.com/graph.php?gid='.$getGraph[$i]['gid'].'"></iframe>';//echo '<iframe id="ListFrame" name="ListFrame" style="width:600px; height:900px;border:1px" src="graph.php?gid='.$getGraph[$i]['gid'].'"></iframe>'; ?></textarea></td>
					<td class="options-width">
					<a href="editGraph.php?id=<?php echo $getGraph[$i]['gid'];?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="listGraph.php?delete=true&gid=<?php echo $getGraph[$i]['gid'];?>" title="Delete" class="icon-2 info-tooltip"></a>					
					<a href="viewGraph.php?id=<?php echo $getGraph[$i]['gid'];?>" title="View" class="icon-3 info-tooltip"></a>					</td>
				</tr>
                                <?php
                                       }
                                   }
								   else
								   {
								   ?>
								    <tr class="<?php echo $class?>">
				                  <td colspan="5" align="center">No records found</td>
                  </tr>
								   <?php
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
