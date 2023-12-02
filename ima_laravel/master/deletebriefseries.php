<?php include('controlPanel.php');

$id= $_REQUEST['id'];

$getBriefSeries = $briefSeriesObj->getBriefSeriesDetails($id);

$briefseries_title_img    = '../'.trim($getBriefSeries[0]['briefseries_title_img']);
$briefseries_path   = '../'.trim($getBriefSeries[0]['briefseries_summary_path']);
$briefseries_ppt_path   = '../'.trim($getBriefSeries[0]['briefseries_ppt_path']);

if(file_exists($briefseries_title_img)) {
	unlink($briefseries_title_img);
}
if(file_exists($briefseries_path)) {
	unlink($briefseries_path);
}
if(file_exists($briefseries_ppt_path)) {
	unlink($briefseries_ppt_path);
}
$briefSeriesObj->deleteBriefSeries($id);
$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");

exit(0);