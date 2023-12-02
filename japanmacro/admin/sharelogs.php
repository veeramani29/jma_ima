<?php include('header.php');?>
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Share Logs</h1>
	</div>
	<!-- end page-heading -->
	<table cellspacing="0" cellpadding="5" border="1">
		<tr>
			<th>id</th>
			<th>Date and time</th>
			<th>From Email</th>
			<th>To Email</th>
			<th>Link</th>
			<th>Message</th>
		</tr>
		<?php foreach ($sharelogObj->getAllLogs() as $log) {?>
		<tr>
			<td><?php echo $log['id'];?></td>
			<td><?php echo $log['datetime'];?></td>
			<td><?php echo $log['from_email'];?></td>
			<td style="word-wrap:break-word"><?php echo $log['to_email'];?></td>
			<td style="word-wrap:break-word"><?php echo $log['link'];?></td>
			<td style="word-wrap:break-word"><?php echo $log['message'];?></td>
		</tr>		
		<?php } ?>
	</table>
	<div class="clear">&nbsp;</div>

</div>
<?php include('footer.php');?>