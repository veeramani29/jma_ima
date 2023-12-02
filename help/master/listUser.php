<?php include('header.php');?>
<!-- start content -->

<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Users</h1>
	</div>
	<form name="frm_sort_user" id="frm_sort_user" action="" method = "post">
	<div class="sort-function">
		<ul>
			<li>Sort by User</li>
			<li>
				<select name="sort_by_user" id="sort_by_user" class="styledselect" onchange="return sort_by_users(this.value)">
				    <option  value= "">--Select--</option>
					<option  value= "Login" <?php if(isset($_REQUEST['userType']) && $_REQUEST['userType']=="Login"){ echo "selected"; } ?>>Registed User</option>
					<option  value= "Linked" <?php if(isset($_REQUEST['userType']) && $_REQUEST['userType']=="Linked"){ echo "selected"; } ?>>Linked User</option>
				</select>
			</li>
			<li>
				User Status
			</li>
			<li>
				<select name="user_status" id="user_status" class="styledselect" onchange="return user_statuss(this.value);">
					<option  value= "">--Select--</option>
					<option  value= "4" <?php if(isset($_REQUEST['userStatus']) && $_REQUEST['userStatus']=="4"){ echo "selected"; } ?>>Active</option>
					<option  value= "2" <?php if(isset($_REQUEST['userStatus']) && $_REQUEST['userStatus']=="2"){ echo "selected"; } ?>>Inactive</option>
					<option  value= "1" <?php if(isset($_REQUEST['userStatus']) && $_REQUEST['userStatus']=="1"){ echo "selected"; } ?>>Deleted</option>
					<option  value= "5" <?php if(isset($_REQUEST['userStatus']) && $_REQUEST['userStatus']=="5"){ echo "selected"; } ?>>Expired</option>
					<option  value= "3" <?php if(isset($_REQUEST['userStatus']) && $_REQUEST['userStatus']=="3"){ echo "selected"; } ?>>Blocked</option>
					<option  value= "6" <?php if(isset($_REQUEST['userStatus']) && $_REQUEST['userStatus']=="6"){ echo "selected"; } ?>>Trial</option>
					<option  value= "7" <?php if(isset($_REQUEST['userStatus']) && $_REQUEST['userStatus']=="7"){ echo "selected"; } ?>>Unpaid</option>
				</select>
			</li>
			<!--<li>
				<button type="submit" class="sugcon_btn">submit</button>
			</li> -->
		</ul>
	</div>
	</form>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slider image" /></th>
		<th class="topleft"></th>
		<!--<td id="tbl-border-top">&nbsp;</td>-->
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
					
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">First Name</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Last Name</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Email</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Password</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">New Post Alert</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">User Type</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Status</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Expiry Date</a></th>
					<th class="table-header-options line-left"><a href="">Options</a></th>
				</tr>
                                
                                <?php 
								       
                                    $getUser = $userObj->getAllUserList();
									if(isset($_REQUEST['userType']) && !isset($_REQUEST['userStatus']))
									{
										$getUser = $userObj->getSortUserList($_REQUEST['userType'],null);
									}
									elseif(!isset($_REQUEST['userType']) && isset($_REQUEST['userStatus']))
									{
										$getUser = $userObj->getSortUserList(null,$_REQUEST['userStatus']);
									}
									if(isset($_REQUEST['userType']) && isset($_REQUEST['userStatus']))
									{
										$getUser = $userObj->getSortUserList($_REQUEST['userType'],$_REQUEST['userStatus']);
									}
									
                                    if(count($getUser)>0){
                                         for($i=0;$i<count($getUser);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                           $userPostAlert  = $getUser[$i]['user_post_alert'];
                                           if($userPostAlert == 'Y'){
                                               $alertStat  = 'Deactivate?';
                                           }
                                           else{
                                                $alertStat  = 'Activate?';
                                           }
                                           
                                ?>
                                
				<tr class="<?php echo $class?>">
					
					<td><?php echo $getUser[$i]['id'];?></td>
					
					<td><?php echo $getUser[$i]['fname']?></td>
					<td><?php echo $getUser[$i]['lname']?></td>
                    <td><?php echo $getUser[$i]['email']?></td>
                    <td><?php echo $getUser[$i]['password']?></td>
                    <td><?php if($userPostAlert=='Y') { echo 'Active';} else {echo 'Deactiveted';}?> - <a style="text-decoration:underline" href="userPostAlertStat.php?id=<?php echo $getUser[$i]['id'] ?>&status=<?php echo $userPostAlert ?>"> <?php echo $alertStat?></a></td>
                    <td><?php echo $getUser[$i]['user_type_name'];?><br><i>(<?php echo $getUser[$i]['user_type_desc'];?>)</i></td>
                    <td><?php if($getUser[$i]['user_status_id'] == 1) { $del_fnt_st = '<font color="#ff0000">'; $del_fnt_en = '</font>'; } else { $del_fnt_st = $del_fnt_en = ''; }   echo $del_fnt_st;?><?php echo $getUser[$i]['user_status_name'];?><br><i>(<?php echo $getUser[$i]['user_status_desc'];?>)</i><?php echo $del_fnt_en;?></td>
                    <td><?php if($getUser[$i]['expiry_on'] !=0 )
					{
				        echo date('d M, Y',$getUser[$i]['expiry_on']); 
				    } ?></td>
					<td class="options-width">
					<a href="editUser.php?id=<?php echo $getUser[$i]['id'] ?>" title="Edit profile, usertype, status etc." class="icon-1 info-tooltip"></a>
                    <a style="margin-left:7px;" href="userDelete.php?id=<?php echo $getUser[$i]['id']?>" title="Delete" class="icon-2 info-tooltip"></a>	
                    
					</td>
				</tr>
                                <?php
                                       }
                                   }
                                   else{
                                ?>
                                <tr>
                                <td colspan="9">No User Found</td>
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
<script type="text/javascript" language="javascript">
function sort_by_users(vale)
{
	var param = "";
	if(document.getElementById("user_status").value)
	{
		param = "&userStatus="+document.getElementById("user_status").value;
	}
	window.location.href = 'listUser.php?userType='+vale+param;
}

function user_statuss(vale)
{
	var param = "";
	if(document.getElementById("sort_by_user").value)
	{
		param = "&userType="+document.getElementById("sort_by_user").value;
	}
	window.location.href = 'listUser.php?userStatus='+vale+param;
}
</script>