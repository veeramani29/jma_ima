<?php include('header.php');?>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Settings</h1>
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
		<?php
                $id     = '' ;
                $status = '';
                
                if(isset($_REQUEST['id'])){
                    $id  = $_REQUEST['id'];
                }
                
                if(isset($_REQUEST['status'])){
                     $status = $_REQUEST['status'];
                }
                
                if($id != '' && $status !=''){
                    $adminObj->updateSettings($id,$status);
                }
                
                $settings = $adminObj->getSettings();
                
            
                ?>
			<!--  start table-content  -->
			<div id="table-content">
			
				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					
					<th class="table-header-repeat line-left minwidth-1"><a href="">settings Id</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Settings Title</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Setting status</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
                                   
                                    if(count($settings)>0){
                                         for($i=0;$i<count($settings);$i++){
                                             $dispVal = '';
                                             $active = '';
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                           $sId     = $settings[$i]['settings_id'];
                                           $sTitle  = $settings[$i]['settings_title'];
                                           $sStatus = trim($settings[$i]['settings_value']);
                                           
                                           if($sStatus == 'disable'){
                                               $dispVal = 'Enable?';
                                               $active  = 'Y';
                                           } 
                                           else{
                                               $dispVal = 'Disable?';
                                               $active  = 'N';
                                           }
                                           
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $sId;?></td>
					<td><?php echo $sTitle ?></td>
					<td><?php echo $sStatus?></td>
					<td><a href="listSettings.php?id=<?php echo $sId?>&status=<?php echo $active?>"><?php echo $dispVal ?></a></td>
                                        
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