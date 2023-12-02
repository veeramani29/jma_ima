<?php include('header.php');?>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Companies</h1>
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
					
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Company Name</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Status</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                    $getCompany = $userObj->getCompanyList();
                                    if(count($getCompany)>0){
                                         for($i=0;$i<count($getCompany);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                           $company_status  = $getCompany[$i]['company_status'];
                                           if($company_status == 'Y'){
                                               $alertStat  = 'Deactivate?';
                                           }
                                           else{
                                                $alertStat  = 'Activate?';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getCompany[$i]['id'];?></td>
					
					<td><?php echo $getCompany[$i]['company_name']?></td>
                    <td><?php if($company_status=='Y') { echo 'Active';} else {echo 'Deactiveted';}?> - <a style="text-decoration:underline" href="changeCompanyStat.php?id=<?php echo $getCompany[$i]['id'] ?>&status=<?php echo $company_status ?>"> <?php echo $alertStat?></a></td>
					<td class="options-width">
					<a href="editCompanies.php?id=<?php echo $getCompany[$i]['id'] ?>" title="Edit client company details" class="icon-1 info-tooltip"></a>
					</td>
				</tr>
                                <?php
                                       }
                                   }
                                   else{
                                ?>
                                <tr>
                                <td colspan="9">No Companies Found</td>
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