<?php include('header.php');?><script language="javascript">    $(document).ready(function() {        $('#add_categoryr').submit(function() {            var ret = true;            $('#cat_error').html('');            var cat     =   $('#category').val();                        if(cat == ''){                $('#cat_error').html('Please enter category.');                ret =  false;            }                         return ret;     });    });        </script><?php $id = $_REQUEST['id'];if($id == ''){    header('Location:listcategory.php');}$getCat   = $catObj->getIndividualCategory($id);$errorMsg = ''; $insertArray = array();  if(isset($_POST['categoryAdd'])){      	if($_POST['categoryAdd']){		                                               $category   = $_POST['category'];                $category   = cleanInputField($category);                					if($category == ''){			$errorMsg ='Please enter Categories<br/>';		}                 else{                               		        $catObj->updteCategories($id,$category);			$successMsg = "Category added successfully.";                        $insertArray = array();                         echo $successMsg;                        header('Location:listcategory.php');		}						}}?><!-- start content-outer --><div id="content-outer"><!-- start content --><div id="content"><div id="page-heading"><h1>Edit Category</h1></div><table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table"><tr>	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>	<th class="topleft"></th>	<td id="tbl-border-top">&nbsp;</td>	<th class="topright"></th>	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th></tr><tr>	<td id="tbl-border-left"></td>	<td>	<!--  start content-table-inner -->	<div id="content-table-inner">		<table border="0" width="100%" cellpadding="0" cellspacing="0">	<tr valign="top">	<td>				<!-- start id-form -->                 <form action="" name="add_categoryr" id="add_categoryr" method="post">                     <?php if($errorMsg !='') { ?>				<div class="error_sent_notification"><?php echo $errorMsg;?></div>	             <?php } ?>                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">                    <tr>                            <th valign="top"> Category:</th>                            <td>                                <input type="text" name="category" id="category" value="<?php echo $getCat?>" class="inp-form" />                                <label for="category" class="error" id="cat_error"></label>                            </td>                            <td></td>                    </tr>                                   <tr>                    <th>&nbsp;</th>                    <td valign="top">                            <input type="submit" value="Submit" name="categoryAdd" value="Submit" class="form-submit" />                    </td>                    <td></td>                </tr>                </table>          </form>	<!-- end id-form  -->	</td>	<td></td></tr></table> <div class="clear"></div> </div><!--  end content-table-inner  --></td><td id="tbl-border-right"></td></tr><tr>	<th class="sized bottomleft"></th>	<td id="tbl-border-bottom">&nbsp;</td>	<th class="sized bottomright"></th></tr></table><div class="clear">&nbsp;</div></div><!--  end content --><div class="clear">&nbsp;</div></div><?php include('footer.php');?>