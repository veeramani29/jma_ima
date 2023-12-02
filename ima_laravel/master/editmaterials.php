<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');
include("lib/wideimage-lib/WideImage.php");
?>
<script language="javascript">
$(document).ready(function() {
    $('#add_materials').submit(function() {
        var ret = true;
        $('#materials_title_error').html('');$('#materials_title_img_error').html('');$('#materials_file_error').html('');$('#materials_date_error').html('');
        var title     =   $('#materials_title').val();
        var img      =   $('#imageFile').val(); 
        var fle      =   $('#materialFile').val();
        var dte		=	$('#materials_date').val();
        if(title == ''){
            $('#materials_title_error').html('Please enter Title.');
            ret =  false;
        }
        if(img != '' && checkImg(img) == false){
               $('#materials_title_img_error').html('Please upload a valid image file.');
              ret =  false;
        }
        if(dte == ''){
            $('#materials_title_error').html('Please enter Date.');
            ret =  false;
        }
                   
        return ret;
 });
});

function checkImg(imagePath) {
var pathLength  = imagePath.length;
var lastDot     = imagePath.lastIndexOf(".");
var fileType    = imagePath.substring(lastDot,pathLength);
if((fileType == ".gif") || (fileType == ".jpg") || (fileType == ".jpeg") || (fileType == ".png") || (fileType == ".GIF") || (fileType == ".JPG") || (fileType == ".PNG")) {
return true;
} else {
return false;
}
}   
</script>

<?php
$id = $_REQUEST['id'];
if($id == ''){
	header('Location:listMaterials.php');
}

$getMaterial = $materialObj->getMaterialDetails($id);
$material_type = $getMaterial[0]['material_type'];
$material_title    = $getMaterial[0]['material_title'];
$material_description = $getMaterial[0]['material_description'];
$material_title_img    = $getMaterial[0]['material_title_img'];
$material_path   = $getMaterial[0]['material_path'];
$material_date  = $getMaterial[0]['material_date'];
$isPremium = $getMaterial[0]['is_premium'];

$errorMsg = '';
$insertArray = array();

if($_POST['addMaterials']){
	try {
	$update_fields = array();
	$files_to_delete = array();
	if($material_title != $_POST['material_title']) {
		if($_POST['material_title'] == '')
			throw new Exception("Enter a Title");
		$update_fields['material_title'] = $_POST['material_title'];
	}
	if($material_date != $_POST['material_date']) {
		if($_POST['material_date'] == '')
			throw new Exception("Enter a date");
		$update_fields['material_date'] = $_POST['material_date'];
	}
	if($isPremium != $_POST['is_premium']) {
		$update_fields['is_premium'] = $_POST['is_premium'];
	}	
	if($material_type == 'general' || $material_type == 'oxford') {
		if($_FILES['imageFile']['name']!='') {
			// image upload
			$file = str_replace(' ','_',$_FILES['imageFile']['name']);
			$imageFile = '';
			$materialFile = '';
			if($_FILES['imageFile']['type'] == 'image/png' || $_FILES['imageFile']['type'] == 'image/gif' || $_FILES['imageFile']['type'] == 'image/jpeg' || $_FILES['imageFile']['type'] == 'image/jpg' || $_FILES['imageFile']['type'] == 'image/pjpeg') {
				$img = WideImage::load('imageFile');
			} else {
				throw new Exception("Error..! selected image is not supported", 9999);
			}
			$filepath = '../public/uploads/materials/'.$file;
			$img->saveToFile($filepath);
			if(file_exists($filepath)) {
				$imageFile = 'public/uploads/materials/'.$file;
			} else {
				throw new Exception("Error..! image write error occured.", 9999);
			}
			$update_fields['material_title_img'] = $imageFile;
			$files_to_delete[] = '../'.$material_title_img;
		}
	}
	if($material_type == 'oxford') {
		$materialDescription = cleanMyCkEditor(trim($_POST['description']));
		if($material_description != $materialDescription) {
			$update_fields['material_description'] = $materialDescription;
		}
	}
	
	if($_FILES['materialFile']['name'] != ''){
		$mFile = str_replace(' ','_',$_FILES['materialFile']['name']);
		$materialFile = 'public/uploads/materials/'.$mFile;
		if(file_exists('../public/uploads/materials/'.$mFile)) {
			unlink('../public/uploads/materials/'.$mFile);
		} else{
			$files_to_delete[] = '../'.$material_path;
		}
		$udfneme = '../public/uploads/materials/'.$mFile;
		if(file_exists($udfneme)) {
			unlink($udfneme);
		}
		if(move_uploaded_file($_FILES['materialFile']['tmp_name'],$udfneme)) {
			$update_fields['material_path'] = $mFile;
		} else {
			throw new Exception("Error in uploading material file");
		}
		
	}	
	
	}catch (Exception $ex) {
		$errorMsg = $ex->getMessage();
	}
	if($errorMsg == '' && !empty($update_fields)) {
		if($materialObj->updateThisMaterial($id,$update_fields)) {
			foreach ($files_to_delete as $fles){
				unlink($fles);
			}
			header('Location:listMaterials.php');
		} else{
			$errorMsg = "DB Error...! Database update failed..";
		}
		
	}
	
}
?>
<script type="text/javascript" src="../public/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../public/plugins/ckeditor/ckfinder.js"></script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Edit Materials</h1></div>


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
                 <form action="" name="add_materials" enctype="multipart/form-data" id="add_materials" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
				<table border="0" cellpadding="0" cellspacing="0" id="id-form">
					<tr>
						<th>Material Type:</th>
						<td><?php echo $material_type;?></td>
					</tr>
					<?php if($material_type == 'general' || $material_type == 'oxford') { ?>
					<tr>
						<th>Title Image:</th>
						<td><input type="file" name="imageFile" id="imageFile"
							class="file_1" /> <label for="imageFile" class="error"
							id="materials_title_img_error"></label></td>
					</tr>
					<?php }?>
					<tr>
						<th valign="top">Material Title:</th>
						<td><input name="material_title" type="text" id="material_title"
							class="inp-form" value="<?php echo htmlspecialchars($material_title,ENT_QUOTES);?>"> <label for="material_title" class="error"
							id="materials_title_error"></label></td>
						<td></td>
					</tr>
					<?php if($material_type == 'general' || $material_type == 'oxford') { ?>
                     <tr>
                            <th valign="top"> Description</th>
                            <td>
                                <textarea  name="description" id="mate_desc" cols="5" rows="5"  ><?php echo $material_description;?></textarea>
						<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'mate_desc',{
										height:100,
										width:600
										} );
							CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
						   }
						  </script>
                                <label for="post" class="error" id="post_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    <?php }?>
					<tr>
						<th>Material File:</th>
						<td><input type="file" name="materialFile" id="materialFile"
							class="file_1" /> <label for="materialFile" class="error"
							id="materials_file_error"></label></td>
					</tr>



					<tr>
						<th>Date:</th>
						<td valign="top"><input type="hidden" name="txt_startDate"
							id="txt_startDate" value="" /> <input name="material_date"
							type="text" class="textBox_style2" id="materials_date"
							value="<?php echo $material_date;?>" readonly="readonly" /> <a
							onclick="showCalendarControl(add_materials.materials_date,'add_materials.txt_startDate');"><img
							src="calendar/calendar.gif" border="0" /></a></td>
						<td></td>
					</tr>
					<tr>
						<th>Is Premium:</th>
						<td valign="top">
							<select name="is_premium" style="width:50px">
								<option value="Y" <?php echo $isPremium == 'Y' ? 'selected' : '';?>>Y</option>
								<option value="N"<?php echo $isPremium == 'N' ? 'selected' : '';?>>N</option>
							</select>
						</td>
						<td></td>
					</tr>					
					<tr>
						<th>&nbsp;</th>
						<td valign="top"><input type="submit" value="Submit"
							name="addMaterials" class="form-submit" /></td>
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
