<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');?>

<?php 
$form_validate = true;

$name = '';
$status = 'Y';

if($_POST && isset($_POST['Submit'])){
	try{
		$name = trim($_POST['name']);
		$status = $_POST['status'];
		if(empty($name)) throw new Exception("Name cannot be empty.", 9999);
		$postVars = array(
			'company_name' => $name,
			'company_status' => $status
		);
		$userObj->addNewCompany($postVars);
		header('Location:listCompanies.php');
	}catch (Exception $ex){
		$form_validate = false;
		$form_validate_message = $ex->getMessage();
	}

}


?>

<!-- start content -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add New Client Company</h1></div>


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
                 <form name="add_user" id="add_user" method="POST">
                     
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="id-form">
                    <tr>
                    	<td colspan="3"><font color="#ff0000"><?php echo $form_validate == false ? $form_validate_message : '';?></font></td>
                    
                    
                    <tr>
                            <th valign="top">Company Name:</th>
                            <td valign="top">
                               <input type="text" class="inp-form" name="name" value="<?php echo $name;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Company Status:</th>
                            <td valign="top">
                               <select name="status" class="styledselect_form_1">
                               		<option value="Y" <?php echo $status == 'Y' ? 'selected' : '';?>>Active</option>
                               		<option value="N" <?php echo $status == 'N' ? 'selected' : '';?>>Inactive</option>
                               </select>
                            </td>
                    </tr>
                     <tr>
                            <th valign="top"></th>
                            <td valign="top">
                               <input type="Submit" name="Submit" class="form-submit" value="Save Profile">&nbsp;&nbsp;&nbsp;
                               <a href="listCompanies.php"class="form-cancel">Cancel</a>
                            </td>
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