<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');?>

<?php 
$companyId = $_REQUEST['id'];
if($companyId == ''){
    header('Location:listCompanies.php');
}
$form_validate = true;
$companyDetails = $userObj->getCompanyDetails($companyId);

$id = $companyDetails[0]['id'];
$name   = $companyDetails[0]['company_name'];
$status = $userDetails[0]['company_status'];

if($_POST && isset($_POST['Submit'])){
	try{
		$status = $_POST['status'];
		$name = trim($_POST['name']);
		if(empty($name)) throw new Exception("Name cannot be empty.", 9999);
		$postVars = array(
			'company_status' => $status,
			'company_name' => $name,
		);
		$userObj->updateCompanyProfile($postVars,$id);
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


<div id="page-heading"><h1>Edit Client Company</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slider images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slider images" /></th>
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
                 <form name="edit_user" id="edit_user" method="POST">
                     
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%">
                    <tr>
                    	<td colspan="2"><font color="#ff0000"><?php echo $form_validate == false ? $form_validate_message : '';?></font></td>
                    </tr>

                    <tr>
                            <th valign="top"> Company Id:</th>
                            <td>
                            	<input type="hidden" class="inp-form" name="id" value="<?php echo $id;?>">
                                <?php  echo $id?>
                            </td>
                    </tr>                
                    
                     <tr>
                            <th valign="top">Company name:</th>
                            <td>
                                <input type="text" class="inp-form" name="name" value="<?php echo $name;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Status:</th>
                            <td>
                               <select name="status" class="styledselect_form_1">
                               		<option value="Y" <?php echo $status == 'Y' ? 'selected' : '';?>>Active</option>
                               		<option value="Y" <?php echo $status == 'n' ? 'selected' : '';?>>Inactive</option>
                               </select>
                            </td>
                    </tr>
                                   
                     <tr>
                            <th valign="top"></th>
                            <td>
                               <input type="Submit" name="Submit" value="Save Profile" class="form-submit">&nbsp;&nbsp;&nbsp;
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