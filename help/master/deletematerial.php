<?php include('controlPanel.php');

$id= $_REQUEST['id'];

$getMaterial = $materialObj->getMaterialDetails($id);

$material_title_img    = '../'.trim($getMaterial[0]['material_title_img']);
$material_path   = '../'.trim($getMaterial[0]['material_path']);

if(file_exists($material_title_img)) {
	unlink($material_title_img);
}
if(file_exists($material_path)) {
	unlink($material_path);
}
$materialObj->deleteMaterial($id);
$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");

exit(0);