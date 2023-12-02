<?php include('header.php');?>

<?php 
$userId = $_REQUEST['id'];
if($userId == ''){
    header('Location:listUser.php');
}
$userDetails = $userObj->getUserDetails($userId);
$userId      = $userDetails[0]['user_title_id'];
$title       = $userObj->getUserTitle($userDetails[0]['user_title_id']);
$firstName   = $userDetails[0]['user_first_name'];
$lastName    = $userDetails[0]['user_last_name'];
$userEmail   = $userDetails[0]['user_email'];
$userCountry = $userObj->getUserCountry($userDetails[0]['country_id']);
$userPosition= $userObj->getUserPosition($userDetails[0]['user_position_id']);
$responsible = $userObj->getUserResponsibility($userDetails[0]['user_responsibility_id']);
$industry    = $userObj->getUserIndustry($userDetails[0]['user_industry_id']);
$create_date = $userDetails[0]['user_created_date'];
$status      = $userDetails[0]['user_status'];
?>

<!-- start content -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>View User</h1></div>


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
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	
		<!-- start id-form -->
                 <form action="" name="" id="add_post" method="">
                     
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>
                            <th valign="top"> User Id:</th>
                            <td>
                                <?php  echo $userId?>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">User Title</th>
                            <td>
                                <?php  echo $title?>
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top">First Name:</th>
                            <td>
                               <?php echo $firstName?>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                    <tr>
                            <th valign="top">Last Name:</th>
                            <td>
                               <?php echo $lastName?>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Email:</th>
                            <td>
                               <?php echo $userEmail?>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Country:</th>
                            <td>
                               <?php echo $userCountry?>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Position:</th>
                            <td>
                               <?php echo $userPosition?>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Responsibility:</th>
                            <td>
                               <?php echo $responsible?>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Industry:</th>
                            <td>
                               <?php echo $industry?>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Created On:</th>
                            <td>
                               <?php echo $create_date?>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">User Status:</th>
                            <td>
                               <?php echo $status?>
                            </td>
                            <td></td>
                    </tr>
                   

                </table>
          </form>
	<!-- end id-form  -->

	</td>
	<td>


</td>
</tr>

</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
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
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>


<?php include('footer.php');?>