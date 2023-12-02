<?php
ini_set('memory_limit', '2000M');
ini_set('max_execution_time', 0);
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'cron_class.php';
set_include_path(dirname(__DIR__).'/admin/voucherImport/Classes/');

include 'PHPExcel/IOFactory.php';
require(dirname(__DIR__).'/admin/XLSXReader.php');

class rstudioAutomation extends Cron {
	public $classes = array('alanee_classes/mailer/class.phpmailer.php');




private function Add_Values($getArray){

$post = new Post();
$final_str = '';
foreach ($getArray as $arrRecord) {
$fieldList = $valueList = '';
foreach ($arrRecord as $fieldName => $fieldValue) {
$fieldList .= "`" .$fieldName . "`,";
if (is_string($fieldValue))
$valueList .= "'" . ($fieldValue) . "',";
else
$valueList .= $fieldValue . ',';


} 

$valueList_ = substr($valueList, 0, -1);
$final_str.= '(' . $valueList_ . '),';



}
$fieldList = substr($fieldList, 0, -1);
$final_str = substr($final_str, 0, -1);

  $insertQuery = 'INSERT INTO  graph_values  (' . $fieldList . ')  VALUES '.$final_str.";";
$post->executeQuery($insertQuery);

}
private function Update_Post($gid,$data_coloumn){
$post = new Post();
 $select_gid="Select post_id ,post_cms From post where post_cms LIKE '%{graph_yield_daily $gid-%'";
$find_num_post_rows=$post->executeQuery($select_gid);
if($find_num_post_rows->num_rows>0)
{
$get_post_rows=$find_num_post_rows->fetch_assoc();
$postid = $get_post_rows['post_id'];
$post_cms=$get_post_rows['post_cms']; 

if (preg_match_all("/{(.*?)}/", $post_cms, $graph_yield))
{

if(isset($graph_yield) && is_array($graph_yield[0])){
foreach ($graph_yield[0] as  $graph_yield_var)
{
$post_str = substr(strrchr($graph_yield_var, "-"), 1);
if (strpos($post_str,"$gid") !== false)
{
  $templatestr = str_replace($post_str, "$data_coloumn|$gid}", $post_cms);
}


} 
}	
if(isset($templatestr) && $templatestr!=''){
 $update="Update post set post_cms='$templatestr' where post_id='$postid'";
 $post->executeQuery($update); 
}

}

}



}
	private function getCol($matrix, $col)
	{
		
	$column =array();
	for( $i=0; $i<=count($matrix); $i++)
	{
	if($i!=0 || $i!='0')
	{
	if(!$matrix[$i][$col])
	{
	$matrix[$i][$col]=0;
	}
	//if($col!=1){$column[]=floatval($matrix[$i][$col]);}else{ $column[]=$matrix[$i][$col];}
	if($col!=1){if($matrix[$i][$col]!=""){$column[]=($matrix[$i][$col]);}else{$column[]="";}}else{ $column[]=$matrix[$i][$col];}
	}
	}
	return $column;
	}

	public function Run() {
	
//Unlink Existing Files from this directory
$dir = dirname(__DIR__)."/public/uploads/rstudio_xls/";
$scanned_directory = array_diff(scandir($dir), array('..', '.','index.php'));
if(count($scanned_directory)>0){
foreach ($scanned_directory as $eachfile) {
unlink($dir.$eachfile);
}
}

$out= "***************** Rstudio Automation - START"."<br><br>";
//AWS sync means getting file from bucket to our server dir	
$evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
if($evenPath == "test")
{
 shell_exec("AWS_ACCESS_KEY_ID=AKIAI2UV3D475Y37MUWA AWS_SECRET_ACCESS_KEY=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 aws s3 sync s3://testing.content.japanmacroadvisors.com/rstudio_xls /var/www/www/public/uploads/rstudio_xls ");
}elseif($evenPath == "production"){
 shell_exec("AWS_ACCESS_KEY_ID=AKIAI2UV3D475Y37MUWA AWS_SECRET_ACCESS_KEY=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 aws s3 sync s3://content.jma/rstudio_xls /var/www/www/public/uploads/rstudio_xls ");
}
			


$after_sync_scanned_directory = array_diff(scandir($dir), array('..', '.','index.php'));
if(count($after_sync_scanned_directory)>0){
foreach ($after_sync_scanned_directory as $eachfile_) {
	$inputFileName=$dir.$eachfile_;

	try
{
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
}catch (Exception $e) {
$out.="Can't read File!! ".$inputFileName;
}

//Main Code Started

$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
#PHPExcel_Shared_Date::ExcelToPHP(39984,PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);

	

$xlsx = new XLSXReader($inputFileName);
$sheetNames = $xlsx->getSheetNames();
$sheet = $xlsx->getSheet($sheetNames[1]);
$dataArray1=array();

$x=1;
	foreach($sheet->getData() as $key1=>$row) 
	{
	    $y=1;
		foreach($row as  $key2=>$cell) 
		{
			if($key1==0 && $key2==0){$cellval="";}else{$cellval=trim($cell);}
		$dataArray1[$x][$y] =$cellval;
			$y++;
		}
		$x++;
	}
	
									
									$source = addslashes("New");						
									$title = addslashes("New");
									$description = addslashes("New" );
									$isPremium = addslashes("New"); 
									$filepath = addslashes($inputFileName);  
			
			
							$post = new Post();
			 				  $graph_details_count_query="SELECT gid from graph_details where filepath='".$inputFileName."'";
							$find_num_rows=$post->executeQuery($graph_details_count_query);
							$a=0;$minustwo=0;
							if($find_num_rows->num_rows>0){
								$get_numrows=$find_num_rows->fetch_assoc();
								 $gid = $get_numrows['gid'];
								$incr_col="select data_coloumn from graph_values where gid='$gid' ORDER BY data_coloumn DESC LIMIT 1";
								$incr_col01=$post->executeQuery($incr_col);
								$get_numrows1=$incr_col01->fetch_assoc();
								$a= 1808-1;
								$minustwo=2;
								 
								 //$query_pag_data   = "delete from graph_values where gid = '$gid'";
								//$results = $post->executeQuery($query_pag_data);
							}else{
							 $query= "insert into graph_details(source,title,description,isPremium,filepath) values('".$source."','".$title."','".$description."','".$isPremium."','".$filepath."')";
							
							$gid = $post->insertQuery($query);
							
							}

			 

	
			
	
									$data=array();
									$data1=array(); 
									for($i=0;$i<=count($dataArray1[1]);$i++)
									{ 
										$ar=array();
										if($i!=0 || $i!='0')
										{
											$ar=$this->getCol($dataArray1,$i);

											array_push($data,$ar);
										}
									}
									

										
										//echo "<pre>";
										//print_r($data[0]);
								//	$insertxlArray = array();
									$Allthe_Array=array();	
									for($xval=1;$xval<count($data[0]);$xval++)
									{

										$b = 3;
										$sc = 1;
							
									$insertxlArray=array();	
									for($yval=1;$yval<=count($dataArray1[1]);$yval++)
										
									{
										 if($dataArray1[1][$yval])
											 
										{ 

											if(trim($data[0][$xval])!='0' || trim($data[0][$xval])!=0)
									{

											
									
										
										$insertxlArray['gid']  = $gid;
										$insertxlArray['x_value']  = trim($data[0][$xval]);
										$yearmonth=explode('/', trim($data[0][$xval]));

						#$yearmonth=explode('/', trim($dataArray1[2][$yval]));
						#$insertxlArray['date']  = empty($yearmonth[2]) ? '' : trim($yearmonth[2]);
						#$insertxlArray['month']  = empty($yearmonth[1]) ? '' : trim($yearmonth[1]);
						#$insertxlArray['year']  = empty($yearmonth[0]) ? '' : trim($yearmonth[0]);

						$insertxlArray['date']  =0;
						$insertxlArray['month']  = 0;
						$insertxlArray['year']  = $yearmonth[0];
											
										 $insertxlArray['y_value']  = trim($dataArray1[1][2]);
										$date = DateTime::createFromFormat('Y/m/d', $dataArray1[2][1]);
							
										if($date == false) 
										{
										$insertxlArray['y_sub_value']  = trim($dataArray1[2][$yval]);
										}
										else
										{  
										$insertxlArray['y_sub_value']  ="";
										}

								$insertxlArray['value']  = $dataArray1[$xval+1][$yval];
								$insertxlArray['data_row']  = trim($xval);
								 $insertxlArray['data_coloumn']  = trim($yval)+$a;
								$data_coloumn = addslashes($insertxlArray['data_coloumn'])-$minustwo;
								$Allthe_Array[]=$insertxlArray;
								 $gid = addslashes($gid);	
										

								/*					
			  $x_value = addslashes($insertxlArray['x_value']);
			$date = addslashes($insertxlArray['date']);
			$month = addslashes($insertxlArray['month']); 
			$year = addslashes($insertxlArray['year']);
		
			$y_value = addslashes($insertxlArray['y_value']);
			$y_sub_value = addslashes($insertxlArray['y_sub_value']);
			$value = addslashes($insertxlArray['value']);
			$data_row = addslashes($insertxlArray['data_row']);
			$data_coloumn = addslashes($insertxlArray['data_coloumn'])-$minustwo;*/
			
			
			/*  $graph_values_query= "insert into graph_values(gid,x_value,date,month,year,y_value,y_sub_value,value,data_row,data_coloumn) values('".$gid."','".$x_value."','".$date."','".$month."','".$year."','".$y_value."','".$y_sub_value."','".$value."','".$data_row."','".$data_coloumn."')";
 			 $post->insertQuery($graph_values_query);*/
										
									}
										
									}
									}
									
									}

									if(!empty($Allthe_Array) && count($Allthe_Array)>0){
									 
							 		 	$this->Add_Values($Allthe_Array);
						
									     $this->Update_Post($gid,$data_coloumn);
									}
									
							 $graph_values_count_query="SELECT COUNT(*) as num from graph_values where gid=$gid";
							$find_num_rows=$post->executeQuery($graph_values_count_query);

							if($find_num_rows->num_rows>0){
								$get_numrows=$find_num_rows->fetch_assoc();
								#printf ("There are %d rows in a table",$get_numrows['num']);  
								$out.="There are ".$get_numrows['num']." rows saved in a table <br><br>";
							}
									
									
									
									
				

//Deleting existing files from bucket 
$evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
if($evenPath == "test")
{
shell_exec("AWS_ACCESS_KEY_ID=AKIAI2UV3D475Y37MUWA AWS_SECRET_ACCESS_KEY=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 aws s3 rm s3://testing.content.japanmacroadvisors.com/rstudio_xls/$eachfile_ ");
}elseif($evenPath == "production"){
shell_exec("AWS_ACCESS_KEY_ID=AKIAI2UV3D475Y37MUWA AWS_SECRET_ACCESS_KEY=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 aws s3 rm s3://content.jma/rstudio_xls/$eachfile_ ");
}

//Main code End	
} //Files Loop End
}else{
		$out.= "***************** We dont have any files to automation <br><br>";
}
echo $out.= "***************** Rstudio Automation - END <br><br>";

		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->IsHTML(true);  
		$mail->SMTPDebug  = 0;  // enables SMTP debug information (for testing)
		$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AddReplyTo('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
		$mail->WordWrap = 50;
		$mail->Subject = 'Number of rows updated';
        $mail->Body = $out;
		$mail->AddAddress('swati.shetty@japanmacroadvisors.com','Swati Shetty');
		$mail->AddAddress('monali.samaddar@japanmacroadvisors.com','Monali Samaddar');
		//$mail->AddAddress('priyanka.dhar@japanmacroadvisors.com','Priyanka Dhar');
		
		$mail->Send();
		$mail->clearAddresses();
	    $mail->clearAttachments(); 
								
	}
	
}

$obj = new rstudioAutomation();
$obj->Run();
