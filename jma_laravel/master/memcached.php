<?php include('header.php');
$alaneememcached = new Alaneememcached();
$status = '';
if(isset($_POST['FluchCache']) && $_POST['FluchCache']){
	try {

		if(isset($_POST['cType']) && $_POST['cType'] == 'graph'){
			if($alaneememcached->deleteAllChartData()){
				$status = "All cached items are cleared.";
			}else{
				$status = "Couldn't clear any cache items.";
			}
		}elseif(isset($_POST['all']) && $_POST['all'] == 'all'){
			if($alaneememcached->flushCache()){
				$status = "All cached items are cleared.";
			}else{
				$status = "Couldn't clear any cache items.";
			}
		}elseif(isset($_POST['cType']) && $_POST['cType'] == 'files'){

			$files = glob(realpath(dirname(getcwd())).'/storage/json_logs/*'); 
			
			if(count($files)>0){
			
				foreach($files as $file){ 
				if(is_file($file) && $file!=realpath(dirname(getcwd())).'/storage/json_logs/index.php')
				unlink($file);
				}
				$status = "All log files are cleared.";
			}else{
				$status = "Couldn't clear any log file items.";
			}
		}
	}catch (Exception $ex){
		 $status = $ex->getMessage();
	}
}
?>
<!-- start content -->
<div id="content">
	<div  align="right" style="color:orange;font-weight: bold;float: right;">
Click <a download="" href="<?php echo '../storage/logs/data_download_track.txt';?>">here</a> to download weekly report about data downlod </div>
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
			<td><h2>Clear Json Log Files</h3></td>
		</tr>


			<tr>
			<td height="60px" align="center"><form action="" method="post"><input type="Submit" value="Clear All Json Log Files" name="FluchCache"><input type="hidden" name="cType" value="files"></form></td>
		</tr>



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