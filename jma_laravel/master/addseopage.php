<?php include('header.php');?>
<script language="javascript">
    $(document).ready(function() {
        $('#add_post').submit(function() {
            var ret = true;
            $('#error_sent_notification').html(''); $('.error').html('');
            var title      =  $('#post_title').val();
            var post_url_slug = $('#post_url_slug').val();    
            var meta_title = $('#meta_title').val();
            var meta_keywords = $('#meta_keywords').val();
            var meta_description = $('#meta_description').val();
             if(title == ''){
                $('#title_error').html('Please enter post title.');
                ret =  false;
            }
             if(post_url_slug == ''){
                 $('#post_url_slug_error').html('Please enter url slug.');
                 ret =  false;
             }
             if(meta_title == ''){
                 $('#meta_title_error').html('Please enter meta title.');
                 ret =  false;
             }             
             if(meta_keywords == ''){
                 $('#meta_keywords_error').html('Please enter meta keywords.');
                 ret =  false;
             } 
             if(meta_description == ''){
                 $('#meta_description_error').html('Please enter meta description.');
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
            
            
            return ret;
     });
    });
    
    
</script>

<?php
$errorMsg = '';
$insertArray = array();
if(isset($_POST['postAdd'])){
//	echo '<pre>';
//	print_r($_POST); exit;
/*	
	    [main_cat] => 
    [post_title] => sgdfgsdfg
    [post_url_slug] => sgdfgsdfg
    [meta_title] => sdfgsdfg
    [meta_keywords] => sdfgsdfgsdfgsd
    [meta_description] => dsfgdfsgsdfg
    [post_content] => <p>
	sdfgdfg</p>

    [postAdd] => Submit
*/	
	
                $title   = trim($_POST['post_title']);
                $slug     = trim($_POST['post_url_slug']);
                $slug_hash  = sha1($slug);
                $meta_title = trim($_POST['meta_title']);
                $meta_description  = trim($_POST['meta_description']);
                $mata_keywords   = trim($_POST['meta_keywords']);
                $post_id    = isset($_POST['select_selectpost']) ? $_POST['select_selectpost'] : 0;
                $content = $post_id == 0 ? cleanMyCkEditor($_POST['post_content']) : '';
                
                $insertArray['title'] = $title;
                $insertArray['slug'] = $slug;
                $insertArray['slug_hash'] = $slug_hash;
                $insertArray['meta_title'] = $meta_title;
                $insertArray['meta_description'] = $meta_description;
                $insertArray['mata_keywords'] = $mata_keywords;
                $insertArray['post_id'] = $post_id;
                $insertArray['content'] = $content;

                $insertArray = cleanInputArray($insertArray);
                
                if($title == '' || $slug == '' || $meta_title == '' || $meta_description == '' || $mata_keywords == ''){
					$errorMsg ='Please enter all mandatory fields<br/>';
				}else{
                 	try{
		        	$postId = $seopages->addppage($insertArray);
						header('Location:listseopages.php');
                 	} catch (Exception $ex) {
                  		$errorMsg = $ex->getMessage();
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


<div id="page-heading"><h1>Add SEO PAGE</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slide images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slide images" /></th>
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
                                <?php  $getCats = $catObj->getAllCategoriesWothoutFilter();?>
                                    
                                <select name="main_cat" id="main_cat"  class="styledselect_form_1" onchange="JmaAdmin.createPostsDropdown()">
                                    <option value="">Select Category</option>
                                  <?php  
                                    if(count($getCats)>0){
                                         for($i=0;$i<count($getCats);$i++){
                                         ?>
                                            <option value="<?php echo $getCats[$i]['post_category_id'] ?>"><?php echo stripslashes($getCats[$i]['post_category_name']) ?></option>
                                            <?php
                                            }
                                    }
                                    ?>
	          					 </select>
                                 <label for="mainCat" class="error" id="mainCat_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Select Post</th>
                            <td id="select_post">                                    
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top"> Post Title:</th>
                            <td>
                                <input type="text" name="post_title"  id="post_title" class="inp-form2" />
                                <label for="post_title" class="error" id="title_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    <tr>
                            <th valign="top"> Post URL Slug:</th>
                            <td>
                                 <input type="text" name="post_url_slug" id="post_url_slug" class="inp-form2" />
                                <label for="post_url_slug" class="error" id="post_url_slug_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Meta Title:</th>
                            <td>
                                 <input type="text" name="meta_title" id="meta_title" class="inp-form2" maxlength="250" />
                                 <label for="meta_title" class="error" id="meta_title_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Keywords:</th>
                            <td>
                                 <input type="text" name="meta_keywords" id="meta_keywords" class="inp-form2" maxlength="250" />
                                 <label for="meta_keywords" class="error" id="meta_keywords_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Description:</th>
                            <td>
                                 <input type="text" name="meta_description" id="meta_description" class="inp-form2" maxlength="1024" />
                                 <label for="meta_description" class="error" id="meta_description_error"></label>
                            </td>
                            <td></td>
                    </tr>                   

                     <tr class="existing_post">
                            <th valign="top"> Post</th>
                            <td>
                                <textarea  name="post_content" id="post_content" cols="5" rows="8"  ></textarea>
						<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'post_content',{
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
<script>
	$('#post_title').keyup(function(){
		JmaAdmin.createSlug();
	});
</script>
<?php include('footer.php');?>
