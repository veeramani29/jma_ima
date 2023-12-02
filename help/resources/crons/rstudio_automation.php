<?php
namespace resources\crons;
ini_set('memory_limit', '2000M');
ini_set('max_execution_time', 0);
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'Crons.php';
use \App\Libraries\mailer\PHPMailer;
use \Illuminate\Database\Capsule\Manager as Capsule;
set_include_path(SERVER_ROOT.'/admin/voucherImport/Classes/');

include 'PHPExcel/IOFactory.php';
require(SERVER_ROOT.'/admin/XLSXReader.php');

class rstudioAutomation extends Crons {

 public function __construct()
    {
        parent::__construct();
    }

private function Update_Post($gid,$data_coloumn){
	$Capsule=new Capsule;

$users = Capsule::table(TBL_POST)->select('post_id', 'post_cms')->where('post_cms', 'like', '%{graph_yield_daily $gid-%')->get();





if(count($users)>0)
{
	$get_post_rows = json_decode(json_encode($users), true);

$postid = isset($get_post_rows['post_id'])?$get_post_rows['post_id']:$get_post_rows[0]['post_id'];
$post_cms=isset($get_post_rows['post_cms'])?$get_post_rows['post_cms']:$get_post_rows[0]['post_cms'];

if (preg_match_all("/{(.*?)}/", $post_cms, $graph_yield))
{

if(isset($graph_yield) && is_array($graph_yield[0])){
foreach ($graph_yield[0] as  $graph_yield_var)
{
	
$post_str = substr(strrchr($graph_yield_var, "-"), 1);
if (strpos($post_str, $gid) !== false)
{
 $templatestr = str_replace($post_str, "$data_coloumn|$gid}", $post_cms);
}


} 
}	

if(isset($templatestr) && $templatestr!=''){
	Capsule::table(TBL_POST)->where('post_id',  $postid)->update(array('post_cms' => $templatestr ));
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
$dir = SERVER_ROOT."/public/uploads/rstudio_xls/";
$scanned_directory = array_diff(scandir($dir), array('..', '.','index.php'));
if(count($scanned_directory)>0){
foreach ($scanned_directory as $eachfile) {
unlink($dir.$eachfile);
}
}

$out= "***************** Rstudio Automation - START"."<br><br>";
//AWS sync means getting file from bucket to our server dir	

 $evenPath = env('APP_ENV');

 
if($evenPath != "development")
{
 shell_exec("AWS_ACCESS_KEY_ID=".env('AWS_ACCESS_KEY_ID')." AWS_SECRET_ACCESS_KEY=".env('AWS_ACCESS_KEY_ID')." aws s3 sync s3://".env('BUCK_NAME')."/rstudio_xls /var/www/www/public/uploads/rstudio_xls ");
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
			
			
					$find_num_rows = Capsule::table(TBL_GRAPH_DETAILS)->where('filepath', $inputFileName)->pluck('name');
			 				
								$a=0;$minustwo=0;
							if(count($find_num_rows)>0){
								
								 $gid = $find_num_rows;

					 $get_numrows1 = Capsule::table(TBL_GRAPH_VALUES)->where('gid', $gid)->orderBy('data_coloumn','desc')->pluck('data_coloumn');
					$a= $get_numrows1-1;	$minustwo=2;
								 
								 //$query_pag_data   = "delete from graph_values where gid = '$gid'";
								//$results = $post->executeQuery($query_pag_data);
							}else{
							 $query= "insert into ".TBL_GRAPH_DETAILS." (source,title,description,isPremium,filepath) values('".$source."','".$title."','".$description."','".$isPremium."','".$filepath."')";
								$gid = Capsule::insert($query);
							
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
									$insertxlArray = array();
									for($xval=1;$xval<count($data[0]);$xval++)
									{

										$b = 3;
										$sc = 1;
							
										
									for($yval=1;$yval<=count($dataArray1[1]);$yval++)
										
									{
										 if($dataArray1[1][$yval])
											 
										{ 

											if(trim($data[0][$xval])!='0' || trim($data[0][$xval])!=0)
									{

											
									

										$insertxlArray['x_value']  = trim($data[0][$xval]);
										 $yearmonth=explode('/', trim($dataArray1[2][$yval]));
										$insertxlArray['date']  = empty($yearmonth[2]) ? '' : $yearmonth[2];
										$insertxlArray['month']  = empty($yearmonth[1]) ? '' : $yearmonth[1];
										$insertxlArray['year']  = empty($yearmonth[0]) ? '' : $yearmonth[0];
											
										 $insertxlArray['y_value']  = $dataArray1[1][2];
										$date = DateTime::createFromFormat('Y/m/d', $dataArray1[2][1]);
							
										if($date == false) 
										{
										$insertxlArray['y_sub_value']  = $dataArray1[2][$yval];
										}
										else
										{  
										$insertxlArray['y_sub_value']  ="";
										}

								$insertxlArray['value']  = $dataArray1[$xval+1][$yval];
								$insertxlArray['data_row']  = $xval;
								$insertxlArray['data_coloumn']  = $yval;
										//echo "<pre>";
										//print_r($insertxlArray);

								 $gid = addslashes($gid);						
			  $x_value = addslashes($insertxlArray['x_value']);
			$date = addslashes($insertxlArray['date']);
			$month = addslashes($insertxlArray['month']); 
			$year = addslashes($insertxlArray['year']);
		
			$y_value = addslashes($insertxlArray['y_value']);
			$y_sub_value = addslashes($insertxlArray['y_sub_value']);
			$value = addslashes($insertxlArray['value']);
			$data_row = addslashes($insertxlArray['data_row']);
			$data_coloumn = addslashes($insertxlArray['data_coloumn'])-$minustwo;
			
			
			  $graph_values_query= "insert into ".TBL_GRAPH_VALUES." (gid,x_value,date,month,year,y_value,y_sub_value,value,data_row,data_coloumn) values('".$gid."','".$x_value."','".$date."','".$month."','".$year."','".$y_value."','".$y_sub_value."','".$value."','".$data_row."','".$data_coloumn."')";
 			Capsule::insert($graph_values_query);
 			 
										
									}
										
										
										
										
								
									
								}
									}
									
									}
									


						$this->Update_Post($gid,$data_coloumn);
						$get_numrows = Capsule::table(TBL_GRAPH_VALUES)->where('gid',$gid)->count();
						#printf ("There are %d rows in a table",$get_numrows['num']);  
						$out.="There are ".$get_numrows." rows saved in a table <br><br>";
							
									
									
									
									
				

//Deleting existing files from bucket 

if($evenPath != "development")
{
 shell_exec("AWS_ACCESS_KEY_ID=".env('AWS_ACCESS_KEY_ID')." AWS_SECRET_ACCESS_KEY=".env('AWS_ACCESS_KEY_ID')." aws s3 sync s3://".env('BUCK_NAME')."/rstudio_xls /var/www/www/public/uploads/rstudio_xls ");
}


//Main code End	
} //Files Loop End
}else{
		$out.= "***************** We dont have any files to automation <br><br>";
}
echo $out.= "***************** Rstudio Automation - END <br><br>";

		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->IsMail();
		$mail->IsHTML(true);  
		$mail->SMTPDebug  = 0;  // enables SMTP debug information (for testing)
		$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AddReplyTo('info@japanmacroadvisors.com', 'JMA Info');
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
		$mail->WordWrap = 50;
		$mail->Subject = 'Number of rows updated';
        $mail->Body = $out;
		$mail->AddAddress('swati.shetty@japanmacroadvisors.com','Swati Shetty');
		$mail->AddAddress('monali.samaddar@japanmacroadvisors.com ','Monali Samaddar');
		//$mail->AddAddress('priyanka.dhar@japanmacroadvisors.com','Priyanka Dhar');
		
		$mail->Send();
		$mail->clearAddresses();
	    $mail->clearAttachments(); 
								
	}
	
}

$obj = new rstudioAutomation();
$obj->Run();