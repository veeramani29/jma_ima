<?php include('header.php');
$alaneememcached = new Alaneememcached();
$status = '';
if($_POST['FluchCache']){
	try {
		if($_POST['cType'] == 'graph'){
			if($alaneememcached->deleteAllChartData()){
				$status = "All cached items are cleared.";
			}else{
				$status = "Couldn't clear any cache items.";
			}
		}elseif($_POST['cType'] == 'all'){
			if($alaneememcached->flushCache()){
				$status = "All cached items are cleared.";
			}else{
				$status = "Couldn't clear any cache items.";
			}
		}
	}catch (Exception $ex){
		$status = $ex->getMessage();
	}
}
?>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Cache Settings</h1>
	</div>
	<!-- end page-heading -->
	<table cellspacing="0" cellpadding="5" border="1">
	<?php if($status != ''){?>
		<tr>
			<td align="center"><?php echo $status;?></td>
		</tr>
	<?php }?>
		<tr>
			<td height="60px" align="center"><form action="" method="post"><input type="Submit" value="Clear All Chart Cache" name="FluchCache"><input type="hidden" name="cType" value="graph"></form></td>
		</tr>
		<tr>
			<td height="60px" align="center"><form action="" method="post"><input type="Submit" value="Clear All Cache (Flush)" name="FluchCache"><input type="hidden" name="all" value="all"></form></td>
		</tr>	
		<tr>
			<td><h2>Current cached items</h3></td>
		</tr>
		<tr>
			<td>
			<?php 
				try {
				$allCachedKeys = array();
				$allCachedKeys = $alaneememcached->getAllKeys();
				}catch (Exception $ex){
					echo $ex->getMessage();
				}
				echo '<pre>';
				print_r($allCachedKeys);
				echo '</pre>';
			?>
			
			</td>
		</tr>	
	</table>
	
	<div class="clear">&nbsp;</div>

</div>
<?php include('footer.php');?>