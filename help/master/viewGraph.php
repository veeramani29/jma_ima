<?php include('header.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
extension_loaded('zip');
ini_set('memory_limit', '1000M');

if(!isset($_GET['id'])){
	header('Location: listGraph.php');
}
$id = $_GET['id'];

$db = new mysql();
//$lines = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$id."' order by vid");
$lines = $db->selectQuery("SELECT y_value, y_sub_value, min(vid) FROM graph_values where gid = '".$id."' GROUP BY y_value, y_sub_value order by min(vid)");
?>
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>View Graph</h1></div>
<div style="padding: 10px; border: 1px #d7d7d7 solid; border-radius: 5px">
<table id="product-table"><tr>
<th class="table-header-repeat line-left minwidth-1"><a>Id</a></th>
<th class="table-header-repeat line-left" style="width: 100%"><a>Column</a></th>
</tr>
<?php

$i = 0;
foreach($lines as $line)
{
	if($line['y_sub_value'])
		echo "<tr><td>".$id.'-'.$i."</td><td>".$line['y_value'].'-'.$line['y_sub_value'].'</td></tr>';
	else
		echo "<tr><td>".$id.'-'.$i."</td><td>".$line['y_value'].'</td></tr>';
	$i++;
}
	
?>
</table>
</div>
</div>
</div>
<?php include('footer.php');?>
