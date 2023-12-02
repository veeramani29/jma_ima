<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<?php include('header.php');
include("lib/wideimage-lib/WideImage.php");
?>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<script language="javascript">
    $(document).ready(function() {
        $('#add_materials').submit(function() {
            var ret = true;
            $('#materials_title_error').html('');$('#materials_title_img_error').html('');$('#materials_file_error').html('');$('#materials_date_error').html('');
            var title     =   $('#materials_title').val();
            var img      =   $('#imageFile').val(); 
            var fle      =   $('#materialFile').val();
            var dte		=	$('#materials_date').val();
            var tpe = $('#materialType').val();
            if(title == ''){
                $('#materials_title_error').html('Please enter Title.');
                ret =  false;
            }
            if((tpe == 'general' || $materialType == 'oxford') && (img == '' || checkImg(img) == false)){
                   $('#materials_title_img_error').html('Please upload a valid image file.');
                  ret =  false;
            }
            if(dte == ''){
                $('#materials_title_error').html('Please enter Date.');
                ret =  false;
            }
            
            if(fle == ''){
                $('#materials_file_error').html('Please upload a material file');
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
  function setMaterialType() {
	if($('#materialType').val() == 'japanese') {
		$('#tr_material_image').hide();
		$('#tr_material_description').hide();
	}else if($('#materialType').val() == 'oxford'){
		$('#tr_material_image').show();
		$('#tr_material_description').show();
	} else {
		$('#tr_material_image').show();
		$('#tr_material_description').hide();
	}
  }
</script>

<?php
$errorMsg = '';
$insertArray = array();
      
if($_POST['addMaterials']){
	// print_r($_POST); exit('------------------');
	try {
		$doc_path = '';
		
		$materialType = $_POST['materialType'];

		$materialTitle  = trim($_POST['materials_title']);
	//	$materialTitle  = cleanInputField($materialTitle);
	
		$materialDescription = cleanMyCkEditor(trim($_POST['description']));

		$materialDate=trim($_POST['materials_date']);
	//	$materialDate=cleanInputField($materialDate);
	
		$is_premium=$_POST['is_premium'];

		if($materialTitle == ''){
			$errorMsg ='Please enter Title.<br/>';
		}
		if($materialDate == ''){
			$errorMsg = $errorMsg .'Please enter a date.<br/>';
		}
		if(($materialType == 'general' || $materialType == 'oxford') && $_FILES['imageFile']['name'] == '') {
			$errorMsg = $errorMsg .'Please upload media file.<br/>';
		}
		if($materialType == 'general' || $materialType == 'oxford') {
			// image upload
			$file = str_replace(' ','_',$_FILES['imageFile']['name']);
			#$file = time()."_".str_replace(' ','_',$_FILES['imageFile']['name']);
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
		} else {
			$imageFile = '';
		}
	
			// file upload
			if($_FILES['materialFile']['name'] != ''){
				$mFile = str_replace(' ','_',$_FILES['materialFile']['name']);
				$materialFile = 'public/uploads/materials/'.$mFile;
				if(file_exists('../public/uploads/materials/'.$mFile)) {
					throw new Exception("File already exists - use different filename");
				}
				if(!move_uploaded_file($_FILES['materialFile']['tmp_name'],'../public/uploads/materials/'.$mFile)) {
					throw new Exception("Error in uploading material file");
				}
	
			} else {
				$errorMsg = $errorMsg .'Please upload media file.<br/>';
			}

		$insertArray['material_type'] = $materialType;
		$insertArray['material_title'] = $materialTitle;
		$insertArray['material_description'] = $materialDescription;
		$insertArray['material_title_img'] = $imageFile;
		$insertArray['material_path'] = $mFile;
		$insertArray['material_date'] = $materialDate;
		$insertArray['is_premium'] = $is_premium;
		$materialObj->addMaterial($insertArray);
		$successMsg = "Material added successfully.";
	} catch (Exception $ex) {
		$errorMsg = $ex->getMessage();
	}

	$insertArray = array();
	if($errorMsg == '') {
		header('Location:listMaterials.php');
	} 
		
}
?>

<script type="text/javascript" src="../public/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../public/plugins/ckeditor/ckfinder.js"></script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add Materials</h1></div>


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
						<td>
							<select name="materialType" id="materialType" onchange="setMaterialType()">
								<option value="general">General</option>
								<option value="japanese">Japanese</option>
								<option value="oxford">Oxford Economics</option>
							</select>
						</td>
					</tr>

					<tr id="tr_material_image">
						<th>Title Image:</th>
						<td><input type="file" name="imageFile" id="imageFile"
							class="file_1" /> <label for="imageFile" class="error"
							id="materials_title_img_error"></label></td>
					</tr>

					<tr>
						<th valign="top">Material Title:</th>
						<td><input name="materials_title" type="text" id="material_title"
							class="inp-form"> <label for="material_title" class="error"
							id="materials_title_error"></label></td>
						<td></td>
					</tr>
                     <tr id="tr_material_description" style="display: none">
                            <th valign="top"> Description</th>
                            <td>
                                <textarea  name="description" id="mate_desc" cols="5" rows="5"  ></textarea>
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
					<tr>
						<th>Material File:</th>
						<td><input type="file" name="materialFile" id="materialFile"
							class="file_1" /> <label for="materialFile" class="error"
							id="materials_file_error"></label></td>
					</tr>



					<tr>
						<th>Date:</th>
						<td valign="top"><input type="hidden" name="txt_startDate"
							id="txt_startDate" value="" /> <input name="materials_date"
							type="text" class="textBox_style2" id="materials_date"
							value="<?php echo date("Y-m-d");?>" readonly="readonly" /> <a
							onclick="showCalendarControl(add_materials.materials_date,'add_materials.txt_startDate');"><img
							src="calendar/calendar.gif" border="0" /></a></td>
						<td></td>
					</tr>
					<tr>
						<th>Is Premium:</th>
						<td valign="top">
							<select name="is_premium" style="width:50px">
								<option value="Y">Y</option>
								<option value="N">N</option>
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
