<?php include('header.php');?>

<?php 
if(isset($_POST) && isset($_POST['homepage_graph_id'])) {
	$chartObj->saveHomapageGraph($_POST);	
}
$homepage_chart = $chartObj->getHomepageGraph();
$curerent_url = "http" . (($_SERVER['SERVER_PORT']==443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$subject = "http://www.google.com";
$pattern = "/(\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|])(admin)/i";
preg_match($pattern, $curerent_url, $matches);
?>
<style>
.txt_hpgrh_nor {
	width:650px;
	height:30px;
	border:1px solid #ffffff;
}
.hpgrh TH, .hpgrh .tdBt {
	background-color:#ADABAA;
}
.hpgrh .inp_btn {
	width:120px;
	height:26px;
}
</style>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Homapage Graph (What's New)</h1>
	</div>
	<!-- end page-heading -->
	<div id="Dv_details_show">
		<table cellspacing="5" cellpadding="5" border="1" class="hpgrh">
			<tr>
				<th height="40px">&nbsp;&nbsp;Title&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<?php echo $homepage_chart[0]['title'];?></td>
			</tr>
			<tr>
				<th height="40px">&nbsp;&nbsp;Description&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<?php echo $homepage_chart[0]['description'];?></td>
			</tr>
			<tr>
				<th height="40px">&nbsp;&nbsp;Graph Code&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<?php echo $homepage_chart[0]['graph_code'];?></td>
			</tr>
			<tr>			
				<th height="40px">&nbsp;&nbsp;Report Link&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<?php echo $homepage_chart[0]['report_link'];?></td>
			</tr>
			<tr>			
				<th height="40px">&nbsp;&nbsp;Published Date&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<?php echo $homepage_chart[0]['published_date'];?></td>
			</tr>
			<tr>
				<td height="40px" colspan="2" align="center" class="tdBt"><input type="button" value="Edit" onclick="Homegraph.showEdit();" class="inp_btn"></td>		
			</tr>
		</table>
	</div>
	<div id="Dv_details_edit" style="display:none;">
		<form action = "homepagegraph.php" method="post">
			<table cellspacing="5" cellpadding="5" border="1" class="hpgrh">
				<tr>
					<th height="40px">&nbsp;&nbsp;Title&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<input type="text" name="title" class="txt_hpgrh_nor" value="<?php echo htmlspecialchars($homepage_chart[0]['title']);?>"></td>
				</tr>
				<tr>
					<th height="40px">&nbsp;&nbsp;Description&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<input type="text" name="description" class="txt_hpgrh_nor" value="<?php echo htmlspecialchars($homepage_chart[0]['description']);?>"></td>
				</tr>
				<tr>
					<th height="40px">&nbsp;&nbsp;Graph Code&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<input type="text" name="graph_code" class="txt_hpgrh_nor" value="<?php echo htmlspecialchars($homepage_chart[0]['graph_code']);?>"></td>
				</tr>
				<tr>			
					<th height="40px">&nbsp;&nbsp;Report Link&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<strong><?php echo isset($matches[1]) ? $matches[1] : '';?></strong><input type="text" name="report_link" class="txt_hpgrh_nor" value="<?php echo $homepage_chart[0]['report_link'];?>"></td>
				</tr>
				<tr>			
					<th height="40px">&nbsp;&nbsp;Published Date&nbsp;&nbsp;</th><td>&nbsp;&nbsp;<input type="text" name="published_date" class="txt_hpgrh_nor" value="<?php echo $homepage_chart[0]['published_date'];?>"></td>
				</tr>
				<tr >
					<td height="40px" colspan="2" align="center" class="tdBt"><input type="submit" value="Save" class="inp_btn">&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="Homegraph.showDetails();" class="inp_btn"><input type="hidden" name="homepage_graph_id" value="<?php echo $homepage_chart[0]['id'];?>"></td>		
				</tr>
			</table>
		</form>
	</div>	
	<div class="clear">&nbsp;</div>

</div>
<script>
var Homegraph = {
	showEdit : function() {
		$('#Dv_details_show').hide();
		$('#Dv_details_edit').show();
	},
	showDetails : function() {
		$('#Dv_details_edit').hide();
		$('#Dv_details_show').show();
	}
};
</script>
<?php include('footer.php');?>