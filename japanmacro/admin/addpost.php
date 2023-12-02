<?php include('header.php');?>

<script language="javascript">
    $(document).ready(function() {
        $('#add_post').submit(function() {
            var ret = true;
            $('#writer_error').html(''); $('#desc_error').html('');$('#mainCat_error').html('');$('#title_error').html('');$('#post_error').html('');
           // $('#post_head_error').html('');$('#sub_head_error').html('');
           $('#user_error').html('');
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

        //Slug creation
        $('#post_title').keyup(function(){
            var category_name = $(this).val();
            var url_slug = JmaAdmin.convertToSlug(category_name);
            $('#post_url').val(url_slug);
        });
    });
    
    function Checkfiles()
    {
        var fup = document.getElementById('postImageUpload');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
        var size = fup.files[0].size;
        if(ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG")
        {
            return true;
        } 
        else
        {
            $('#postImage_error').html('Upload Jpg or png images only');
            fup.focus();
            return false;
        }
        if(size > MAX_SIZE){
            $('#postImage_error').html("Maximum file size exceeds");
            fup.focus();
            return false;

        }else{
            return true;
        }   
    }

</script>

<?php
$errorMsg = '';
 $insertArray = array();
 
 $postTypeArr  = array("N"=>"News","P"=>"Page");
 
 $usersList =  $userObj->getUserList();

  if(isset($_POST['postAdd'])){
                $file_name = '';
                if(!empty($_FILES['postImageUpload']['name'])){
                    $errors= array();
                    $file_name = $_FILES['postImageUpload']['name'];
                    $file_size = $_FILES['postImageUpload']['size'];
                    $file_tmp = $_FILES['postImageUpload']['tmp_name'];
                    $file_type = $_FILES['postImageUpload']['type'];
                    $extension = explode('.',$_FILES['postImageUpload']['name']);
                    $file_ext = $extension[1];

                    $extensions = array("jpeg","jpg","png","gif");

                    if(in_array($file_ext,$extensions)=== false){
                        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                    }

                    if($file_size > 2097152) {
                        $errors[]='File size must not exceed 2 MB';
                    }
                    if(empty($errors)==true) {
                    if($file_ext=="jpg" || $file_ext=="jpeg" )
                    {
                        $uploadedfile = $_FILES['postImageUpload']['tmp_name'];
                        $src = imagecreatefromjpeg($uploadedfile);
                    }
                    else if($file_ext=="png")
                    {
                        $uploadedfile = $_FILES['postImageUpload']['tmp_name'];
                        $src = imagecreatefrompng($uploadedfile);
                    }
                    else 
                    {
                        $src = imagecreatefromgif($uploadedfile);
                    }
                    list($width,$height)=getimagesize($uploadedfile);

                    $newwidth=640;
                    $newheight=360;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                    //$newwidth1=180;
                    //$newheight1=110;
                    //$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    //imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

                    $filename = "../public/uploads/postImages/". $_FILES['postImageUpload']['name'];
                    //$filename1 = "../public/uploads/postImages/small". $_FILES['postImageUpload']['name'];

                    imagejpeg($tmp,$filename,100);
                    //imagejpeg($tmp1,$filename1,100);

                    imagedestroy($src);
                    imagedestroy($tmp);
                    //imagedestroy($tmp1);

                    //if(empty($errors)==true) {
                        //move_uploaded_file($file_tmp,"../public/uploads/postImages/".$file_name);
                    }else{
                        $errors[] = "File upload failed.";
                        print_r($errors);
                        exit();
                    }
                }
                $category   = $_POST['parent_category_id'];
             //   $writer     = $_POST['copy_writer'];
                $postTitle  = trim($_POST['post_title']);
                $shortDesc  = $_POST['short_desc'];
                $postHead   = $_POST['post_head'];
                $subHead    = $_POST['sub_head'];
                $postReleased = $_POST['post_released'];
                $post_image = $file_name;
                $post       = $_POST['vid_desc'];
                $postType   = $_POST['post_type'];
                $meta_title = $_POST['meta_title'];
                $share_title = $_POST['share_title'];
                $meta_keywords = $_POST['meta_keywords'];
                $meta_description = $_POST['meta_description'];
                $share_description = $_POST['share_description'];
                $post       = cleanMyCkEditor($post);
                $shortDesc  = clearTextArea($shortDesc);
                $postHead   = trim($postHead);
                $subHead    = trim($subHead);
                $postReleased = trim($postReleased);
               /*     
                $get_title = str_replace(array(' ', "'",':','/','\\'), '-', $postTitle);
                $get_title = str_replace(array(',','?','(',')',), '', $get_title);
                $get_title = str_replace(array('%',), 'per', $get_title);
                $get_title = trim(strtolower($get_title),'-');
                */
                $get_title = $_POST['post_url'];
                $key = md5($get_title);

                
                $insertArray['post_category_id'] = $category;
                $insertArray['copywriter_id'] = 1;
                $insertArray['post_title'] = trim(stripslashes($postTitle));
                $insertArray['post_cms'] = $post;
                $insertArray['post_image'] = trim(stripslashes($post_image));
                $insertArray['post_heading'] = stripslashes($postHead);
                $insertArray['post_subheading'] = stripslashes($subHead);
                $insertArray['post_released'] = stripslashes($postReleased);
                $insertArray['post_cms_small'] = $shortDesc;
                $insertArray['post_type'] = $postType;
                $insertArray['post_meta_title'] = $meta_title;
                $insertArray['post_share_title'] = $share_title;
                $insertArray['post_meta_keywords'] = $meta_keywords;
                $insertArray['post_meta_description'] = $meta_description;
                $insertArray['post_share_description'] = $share_description;
                $insertArray['post_url'] = $get_title;
                $insertArray['post_url_key'] = $key;


                $insertArray = cleanInputArray($insertArray);
                
                if($category == '' ||  $postTitle == '' || $shortDesc == '' || $post == ''){
                    $errorMsg ='Please enter all mandatory fields<br/>';              
                }
                 else{

                    try{
                        $postId = $postObj->addPost($insertArray);
                        if($postType == 'N'){
                            //$userObj->addCronQueue($postId);
                        }
                        /* 
                        $copywriterMail= $copywriterObj->getIndividualCopyWriter($writer);
                        $toName  = $copywriterMail[0]['copywriter_user'];
                        $toMail = $copywriterMail[0]['copywriter_email'];
                        $fromName    = 'japanmacroadvisors';
                        $fromEmail    = 'info@japanmacroadvisors.com ';
                        $subject   = 'New post is added';
                        $message   = 'Hi '.$fromName.'<br/>I added a new post.Please verify it and update me asap';
                        
                        $send = $postObj->sendMail($fromName,$fromEmail,$toName,$toMail,$subject,$message);
                        */

                        if($postId > 1){
                            $successMsg = "Post added successfully.";
                            $insertArray = array();
                            echo $successMsg;
                            header('Location:listPost.php');
                        }
                        else{
                            $errorMsg ="Error. Couldn't create post";
                       }
                    } catch (Exception $ex) {
                        $errorMsg = $ex->getMessage();
                    }
                if($errorMsg != '') {
                    echo $errorMsg;
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
                 <form action="" name="add_post" id="add_post" method="post" enctype="multipart/form-data">
                     <?php if($errorMsg !='') { ?>
                <div class="error_sent_notification"><?php echo $errorMsg;?></div>
                 <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>
                            <th valign="top"> Main Categories:</th>
                            <td>
                                <?php  $getCats = $catObj->getAllCategories();?>
                                    
                                <select name="main_cat" id="main_cat"  class="styledselect_form_1" onchange="JmaAdmin.createSubcategoryDropdown('main_cat',true,'addPost','Dv_select_subcategory_0')">
                                    <option value="">Select Category</option>
                                  <?php  
                                    if(count($getCats)>0){
                                         for($i=0;$i<count($getCats);$i++){
                                             $mainCatId   = $getCats[$i]['mainCatId'];
                                             $mainCatName =  $getCats[$i]['mainCatName'];
                                         ?>
                                            <option value="<?php echo $getCats[$i]['mainCatId'] ?>"><?php echo $getCats[$i]['mainCatName'] ?></option>
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
                        <th valign="top"> Sub-categories </th>
                            <td id="TD_select_subcategory">
                                <div id="Dv_select_subcategory_0"></div>
                            </td>
                             <td><input type="hidden" name="parent_category_id" id="parent_category_id" value="0"></td>
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
                            <th valign="top"> Post URL:</th>
                            <td>
                                <input type="text" name="post_url" id="post_url" class="inp-form2" />
                                <br><font color="#ff0000">Note: Automatically generated. Change only if required.</font>
                                <label for="post_url" class="error" id="post_url_error"></label>
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
                            <th valign="top"> Post Image:</th>
                            <td>
                               <input type="file" name="postImageUpload" id="postImageUpload" onchange="Checkfiles()" class="inp-form" />                            <label for="shortDesc" class="error" id="desc_error"></label>
                                <label for="post" class="error" id="postImage_error"></label>
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
                            <th valign="top">Meta Title:</th>
                            <td>
                                 <input type="text" name="meta_title" id="meta_title" class="inp-form" maxlength="250" />
                            </td>
                            <td></td>
                    </tr>
                      <tr>
                            <th valign="top">Share Title:</th>
                            <td>
                                 <input type="text" name="share_title" id="share_title" class="inp-form" maxlength="250" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Share Description:</th>
                            <td>
                                 <input type="text" name="share_description" id="share_description" class="inp-form2" maxlength="1024" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Keywords:</th>
                            <td>
                                 <input type="text" name="meta_keywords" id="meta_keywords" class="inp-form2" maxlength="250" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Description:</th>
                            <td>
                                 <input type="text" name="meta_description" id="meta_description" class="inp-form2" maxlength="1024" />
                            </td>
                            <td></td>
                    </tr>
                    
                      <tr>
                            <th valign="top">Post Type</th>
                            <td>
                                <?php $newPstArray = array_keys($postTypeArr); ?>
                                    
                                <select name="post_type" id="post_type"  class="styledselect_form_1">
                                    
                                  <?php  
                                    if(count($newPstArray)>0){
                                         for($i=0;$i<count($newPstArray);$i++){
                                         ?>
                                            <option value="<?php echo $newPstArray[$i]?>"><?php echo $postTypeArr[$newPstArray[$i]]; ?></option>
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
    
    // add multiple select / deselect functionality
    $("#select_all").click(function () {
          $('.case').attr('checked', this.checked);
    });
    
    $("#select_all").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#select_all").attr("checked", "checked");
        } else {
            $("#select_all").removeAttr("checked");
        }
 
    });
 </script>
<?php include('footer.php');?>