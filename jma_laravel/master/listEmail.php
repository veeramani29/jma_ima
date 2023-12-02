<?php include('header.php');?>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Emails</h1>
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
					
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Email Code</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Subject</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Email Variable</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getUser = $userObj->getAllmailTemplate();
                                    if(count($getUser)>0){
                                         for($i=0;$i<count($getUser);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getUser[$i]['email_templates_id'];?></td>
					
					<td><?php echo $getUser[$i]['email_templates_code']?></td>
					<td><?php echo $getUser[$i]['email_templates_subject']?></td>
                    <td><?php echo $getUser[$i]['email_templates_variable']?></td>
					<td class="options-width">
					<a href="editEmail.php?id=<?php echo $getUser[$i]['email_templates_id'] ?>" title="Edit profile, usertype, status etc." class="icon-1 info-tooltip"></a>
                   <!-- <a style="margin-left:7px;" href="userDelete.php?id=<?php echo $getUser[$i]['email_templates_id']?>" title="Delete" class="icon-2 info-tooltip"></a> --->
                    
					</td>
				</tr>
                                <?php
                                       }
                                   }
                                   else{
                                ?>
                                <tr>
                                <td colspan="9">No Email Templates Found</td>
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