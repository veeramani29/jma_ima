<?php include('header.php');?>
<?php
$userArr=$userObj->getUserList();
for($i=0;$i<count($userArr);$i++)
{
if($i!=0)
$userEmails=$userEmails.','.$userArr[$i]['user_email'];
else
$userEmails=$userArr[$i]['user_email'];
}
?>
<script>
$(document).ready(function() {
  document.getElementById("emails").select();
});
</script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>User Emails</h1></div>


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
                 <form action="" name="add_categoryr" id="add_categoryr" method="post">
                
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>
                            <th valign="top">Emails</th>
                            <td>
                            <!-- <select style="width:250px;" size="10" 
                    name="emails[]" id="emails[]" multiple="multiple" >
                        <?php print_r($userEmails);?>
                      </select>-->
					  <textarea rows="10" cols="100" id="emails" name="emails" ><?php echo $userEmails;?></textarea>
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