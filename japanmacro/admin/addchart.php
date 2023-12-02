<?php include('header.php');?>



<script language="javascript">
    $(document).ready(function() {
        $('#add_chart').submit(function() {
            var ret = true;
            $('#chart_txt_error').html('');$('#img_error').html(''); $('#img_error1').html(''); $('#chart_title_error').html('');
            var title    =   $('#chart_title').val();
           // var cTxt     =   $('#chart_txt').val(); 
           var editorcontent = CKEDITOR.instances['chart_txt'].getData().replace(/<[^>]*>/gi, '');
            var img      =   $('#imageFile').val(); 
            var bigImg   =   $('#imageFile1').val(); 
            
            if(title == ''){
                $('#chart_title_error').html('Please enter Title.');
                ret =  false;
            }
            
             if(editorcontent.length){}
            else{
                $('#chart_txt_error').html('Please enter Text.');
                ret =  false;
            }
            
            if(img == ''){
                $('#img_error').html('Please upload an image.');
                ret =  false;
            }
            
            if(img != '' && checkImg(img) == false){
                $('#img_error').html('Please upload only image.');
                ret =  false;
            }
            
            if(bigImg != '' && checkImg(bigImg) == false){
                $('#img_error1').html('Please upload only image for big image.');
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
$errorMsg = '';
 $insertArray = array();
  if(isset($_POST['addChart'])){
      
	if($_POST['addChart']){
            
	    $chartTitle	 = trim($_POST['chart_title']);	
            $chartTxt  = trim($_POST['chart_txt']);
            $chartTxt  = cleanMyCkEditor($chartTxt);
            
            if($chartTxt == '' || $chartTitle == '' || $_FILES['imageFile']['name'] == ''){
                $errorMsg ='Please enter all mandatory field<br/>';
            }
            else{
                    // image upload
                     $image1Uploaded  = 0;  $image2Uploaded =0;   
                     $doc_time=date('dmY').date('His');
                     
                     
                     if($_FILES['imageFile']['name'] != ''){                       
                            $imageFile = $_FILES['imageFile']['name'];
                            $fileSize  = $_FILES["imageFile"]["size"];
                            $ext='.';
                            $ext=  explode('.',$_FILES['imageFile']['name']);
                            $ext =  end($ext);
                            $ext = '.'.$ext;
                            
                            $doc_path=$doc_time.$ext;
                            if($ext!='.jpeg' && $ext!='.jpg' && $ext!='.gif' && $ext!='.png'){
                                    $errorMsg = 'File must be JPG, GIF or PNG';
                            }
                            else{
                               if(move_uploaded_file($_FILES['imageFile']['tmp_name'],'../public/uploads/chart/'.$doc_path))
                               {
                                   $image1Uploaded = 1;
                               }
                            }
                     }
                     
                     
                      $doc_path1 = '';
                     
                     if($_FILES['imageFile1']['name'] != ''){                       
                            $imageFile = $_FILES['imageFile1']['name'];
                            $fileSize  = $_FILES["imageFile1"]["size"];
                            $ext='.';
                            $ext=  explode('.',$_FILES['imageFile1']['name']);
                            $ext =  end($ext);
                            $ext = '.'.$ext;
                            
                            $doc_path1=$doc_time.$ext;
                            if($ext!='.jpeg' && $ext!='.jpg' && $ext!='.gif' && $ext!='.png'){
                                    $errorMsg = 'File must be JPG, GIF or PNG';
                            }
                            else{
                               if(move_uploaded_file($_FILES['imageFile1']['tmp_name'],'../public/uploads/chart/big/'.$doc_path1))
                               {
                                   $image2Uploaded = 1;
                               }
                            }
                     }
                           
                                $insertArray['chart_week_title']        = $chartTitle;
                                $insertArray['chart_week_img']          = $doc_path;
                                $insertArray['chart_week_img_big']      = $doc_path1;
                                $insertArray['chart_week_text']         = $chartTxt;
                                $insertArray                            = cleanInputArray($insertArray);
                                $chartObj->addChart($insertArray);
                                $successMsg = "Chart added successfully.";
                                $insertArray = array(); 
                                echo $successMsg;
                                header('Location:listchart.php');
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


<div id="page-heading"><h1>Add Chart</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $themeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slide images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $themeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slide images" /></th>
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
                 <form action="" name="add_chart" enctype="multipart/form-data" id="add_chart" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                           
                          <tr>
                            <th valign="top">Title:</th>
                            <td>
                                <input type="text" name="chart_title" id="chart_title" class="inp-form" />
                                <label for="chart_title" class="error" id="chart_title_error"></label>
                            </td>
                            <td></td>
                          </tr>
                        
                             <tr>
                            <th>Small Chart Image:</th>
                            <td>
                                <input type="file" name="imageFile" id="imageFile" class="file_1" />
                                <label for="image" class="error" id="img_error"></label>
                            </td>
                           
                            </tr>
                            
                            <tr>
                            <th>Chart Image Big:</th>
                            <td>
                                <input type="file" name="imageFile1" id="imageFile1" class="file_1" />
                                <label for="image" class="error" id="img_error1"></label>
                            </td>
                           
                            </tr>

                    <tr>
                            <th valign="top">Text:</th>
                            <td>
                               
                                <textarea  name="chart_txt" id="chart_txt" cols="5" rows="8"  ></textarea>
						<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'chart_txt',{
										height:"<?php echo CKH;?>", width:"<?php echo CKW;?>"
										} );
							CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
						   }
						  </script>
                                                    
                                <label for="chart_txt" class="error" id="chart_txt_error"></label>
                            </td>
                            <td></td>
                    </tr>

                   

                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="addChart" class="form-submit" />

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