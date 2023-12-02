<?php include('header.php');?>

<script language="javascript">
    $(document).ready(function() {
        $('#add_post').submit(function() {
            var ret = true;
            $('#writer_error').html(''); $('#desc_error').html('');$('#mainCat_error').html('');$('#title_error').html('');$('#post_error').html('');
           // $('#post_head_error').html('');$('#sub_head_error').html('');
            var mainCat  = $('#main_cat').val();
            var writer      =   $('#copy_writer').val();  
            var title      =  $('#post_title').val(); 
            var shortdesc  =  $('#short_desc').val();
            var postHead    = $('#post_head').val();
            var subHead     = $('#sub_head').val();
            var post       =  $('#vid_desc').val();  
            
            if(mainCat == ''){
                $('#mainCat_error').html('Please select category.');
                ret =  false;
            }
            
             if(writer == ''){
                $('#writer_error').html('Please select a copy writer.');
                ret =  false;
            }
            
             if(title == ''){
                $('#title_error').html('Please enter post title.');
                ret =  false;
            }
            if(shortdesc == ''){
                $('#desc_error').html('Please enter short Description.');
                ret =  false;
            }
            
            /*if(postHead == ''){
                $('#post_head_error').html('Please enter post heading.');
                ret =  false;
            }
            
            if(subHead == ''){
                $('#sub_head_error').html('Please enter sub heading.');
                ret =  false;
            }*/
            
            var editorcontent = CKEDITOR.instances['vid_desc'].getData().replace(/<[^>]*>/gi, '');
             
            if(editorcontent.length){}
            else{
            $('#post_error').html('Please enter post');
            ret =  false;
            }
             if(ret == false){
                $('#writer_error').focus();
                ret =  false;
            }
            
            return ret;
     });
    });
    
    
</script>

<?php
$errorMsg = '';
 $insertArray = array();

  if(isset($_POST['postAdd'])){
      
	if($_POST['postAdd']){
		
                $category   = $_POST['main_cat'];
                $writer     = $_POST['copy_writer'];
                $postTitle  = $_POST['post_title'];
                $shortDesc  = $_POST['short_desc'];
                $postHead   = $_POST['post_head'];
                $subHead    = $_POST['sub_head'];
                $postReleased = $_POST['post_released'];
                $post       = $_POST['vid_desc'];
                
                $post       = cleanMyCkEditor($post);
                $shortDesc  = clearTextArea($shortDesc);
                $postHead   = trim(addslashes($postHead));
                $subHead    = trim(addslashes($subHead));
                $postReleased = trim(addslashes($postReleased));
                
                $insertArray['post_category_id'] = $category;
                $insertArray['copywriter_id']    = $writer;
                $insertArray['post_title']       = trim(addslashes($postTitle));
                $insertArray['post_cms']         = addslashes($post);
                $insertArray['post_heading']     = $postHead;
                $insertArray['post_subheading']   = $subHead;
                $insertArray['post_released']    = $postReleased;
                $insertArray['post_cms_small']   = addslashes($shortDesc);
                $insertArray                     = cleanInputArray($insertArray);
                
                if($category == '' || $writer == '' ||  $postTitle == '' || $shortDesc == '' || $post == ''){
			$errorMsg ='Please enter all mandatory fields<br/>';
                       
		}
                 else{
		        $postObj->addPost($insertArray);
                        $copywriterMail= $copywriterObj->getIndividualCopyWriter($writer);
                        $toName  = $copywriterMail[0]['copywriter_user'];
                        $toMail = $copywriterMail[0]['copywriter_email'];
                        $fromName    = 'japanmacroadvisors';
                        $fromEmail    = 'info@indiamacroadvisors.com ';
                        $subject   = 'New post is added';
                        $message   = 'Hi '.$fromName.'<br/>I added a new post.Please verify it and update me asap';
                        
                        $send = $postObj->sendMail($fromName,$fromEmail,$toName,$toMail,$subject,$message);
                        
                        if($send == 1){
                            $errorMsg ='Mail not send';
                        }
                        else{
			$successMsg = "Post added successfully.";
                        $insertArray = array(); 
                        echo $successMsg;
                        header('Location:listPost.php');
                        }
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


<div id="page-heading"><h1>Add Post</h1></div>


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
                 <form action="" name="add_post" id="add_post" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>
                            <th valign="top"> Main Categories:</th>
                            <td>
                                <?php  $getCats = $catObj->getAllCategories();?>
                                    
                                <select name="main_cat" id="main_cat"  class="styledselect_form_1">
                                    <option value="">Select Category</option>
                                  <?php  
                                    if(count($getCats)>0){
                                         for($i=0;$i<count($getCats);$i++){
                                             $mainCatId   = $getCats[$i]['mainCatId'];
                                             $mainCatName =  $getCats[$i]['mainCatName'];
                                         ?>
                                            <option value="<?php echo $getCats[$i]['mainCatId'] ?>"><?php echo $getCats[$i]['mainCatName'] ?></option>
                                            <?php
                                            $getSubCats = $catObj->getSubChildCategory($mainCatId);
                                            if(count($getSubCats)>0){
                                                for($j=0;$j<count($getSubCats);$j++){
                                                    $subCatId = $getSubCats[$j]['post_category_id'];
                                                    $subCatName = $mainCatName."-".$getSubCats[$j]['post_category_name'];
                                             ?>
                                             <option value="<?php echo $subCatId ?>"><?php echo $subCatName;?></option>
                                            <?php
                                                $getSubSubCats = $catObj->getSubChildCategory($subCatId);
                                                      for($k=0;$k<count($getSubSubCats);$k++){
                                                       $subSubCatId   = $getSubSubCats[$k]['post_category_id']; 
                                                       $subSubCatName =  $subCatName."--".$getSubSubCats[$k]['post_category_name']; 
                                                      
                                                     ?>
                                                       <option value="<?php echo $subSubCatId ?>"><?php echo $subSubCatName;?></option>
                                                 <?php
                                                      }
                                                }
                                              }
                                            
                                            }
                                    }
                                    ?>
                                    
		           </select>
                                 <label for="mainCat" class="error" id="mainCat_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Copy writers</th>
                            <td>
                                <?php  $getWriters = $copywriterObj->getActiveCopyWriters();?>
                                    
                                <select name="copy_writer" id="copy_writer"  class="styledselect_form_1">
                                    <option value="">Select Copy writer</option>
                                  <?php  
                                    if(count($getWriters)>0){
                                         for($i=0;$i<count($getWriters);$i++){
                                         ?>
                                            <option value="<?php echo $getWriters[$i]['copywriter_id'] ?>"><?php echo $getWriters[$i]['copywriter_user'] ?></option>
                                       <?php                                                
                                            }
                                    }
                                    ?>
                                    
		           </select>
                                 <label for="copy" class="error" id="writer_error"></label>
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top"> Post Title:</th>
                            <td>
                                <input type="text" name="post_title"  id="post_title" class="inp-form" />
                                <label for="post_title" class="error" id="title_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    <tr>
                            <th valign="top"> Post Heading:</th>
                            <td>
                                 <input type="text" name="post_head" id="post_head" class="inp-form" />
                                <label for="post_head" class="error" id="post_head_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                    <tr>
                            <th valign="top"> Post Sub heading:</th>
                            <td>
                                 <input type="text" name="sub_head" id="sub_head" class="inp-form" />
                                <label for="sub_head" class="error" id="sub_head_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top"> Post Released:</th>
                            <td>
                                 <input type="text" name="post_released" id="post_released" class="inp-form" />
                                <label for="post_released" class="error" id="post_released"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                      <tr>
                            <th valign="top"> Short Description:</th>
                            <td>
                                 <textarea name="short_desc" id="short_desc" rows="" cols="" class="form-textarea"></textarea>
                                <label for="shortDesc" class="error" id="desc_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top"> Post</th>
                            <td>
                                <textarea  name="vid_desc" id="vid_desc" cols="5" rows="8"  ></textarea>
						<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'vid_desc',{
										height:"<?php echo CKH;?>", width:"<?php echo CKW;?>"
										} );
							CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
						   }
						  </script>
                                <label for="post" class="error" id="post_error"></label>
                            </td>
                            <td></td>
                    </tr>

                   

                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="postAdd" class="form-submit" />

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