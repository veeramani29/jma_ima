<?php
namespace resources\crons;
ini_set('memory_limit', '2000M');
ini_set('max_execution_time', 0);
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'Crons.php';
use \App\Libraries\mailer\PHPMailer;
use \Illuminate\Database\Capsule\Manager as Capsule;

/*set_include_path(SERVER_ROOT.'/admin/voucherImport/Classes/');
include 'PHPExcel/IOFactory.php';
require(SERVER_ROOT.'/admin/XLSXReader.php');*/

class covidAutomation extends Crons {

	

 public function __construct()
    {
        parent::__construct();
    }


private function oldSet($gid){
	$Capsule=new Capsule;$final=[];
	$get = Capsule::table(TBL_GRAPH_VALUES)->where('gid', $gid)->where('x_value', date('Y/m/d',strtotime('-2 days')))->orderBy('y_value','asc')->get();#dd($get);
$result = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Total Confirmed Cases') { return true; }
return false;
});
$final['cases']=array_values($result);
$result_s = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Total Deaths') { return true; }
return false;
});

	$final['deaths']=array_values($result_s);
	return $final;
}

public function Run($gid){

	
	$InsertArray=[];
	$read=file_get_contents('/var/www/www/resources/crons/response.txt');
#$read=file_get_contents('https://opendata.ecdc.europa.eu/covid19/casedistribution/json/');
$readArray = json_decode(($read), true);
if(isset($readArray['records']) && !empty($readArray['records'])){
	$fetchRecord=$this->getDailyCases($readArray,$this->ASIA);#$oldSet_=$this->getTotalCases($this->ASIA,'asia'); 
	$oldSet=$this->oldSet($gid);#dd($oldSet);
 $date=date('Y/m/d',strtotime('-1 day'));
$date_exp=explode("/", $date);
$k=2;
foreach ($this->ASIA as $key => $each_value) {
	foreach ($this->ThirdGraph as $each_value_) {
		if($fetchRecord[$key]['cases']<0){
			$fetchRecord[$key]['cases']=max($fetchRecord[$key]['cases'],0);
		}elseif ($fetchRecord[$key]['deaths']<0) {
			$fetchRecord[$key]['deaths']=max($fetchRecord[$key]['deaths'],0);
		}
		if($each_value_=='Daily Confirmed Cases'){
			$value=$fetchRecord[$key]['cases'];
		}elseif($each_value_=='Daily Deaths'){
			$value=$fetchRecord[$key]['deaths'];
		}elseif($each_value_=='Total Confirmed Cases'){
			$value=$oldSet['cases'][$key]['value']+$fetchRecord[$key]['cases'];
			#$value=trim($oldSet_[$key][1])+$fetchRecord[$key]['cases'];
		}elseif ($each_value_=='Total Deaths') {
			$value=$oldSet['deaths'][$key]['value']+$fetchRecord[$key]['deaths'];
			#$value=trim($oldSet_[$key][2])+$fetchRecord[$key]['deaths'];
		}
		$data_row=$oldSet['cases'][0]['data_row']+1;

		$InsertArray[]= ['gid'=>$gid, 'x_value'=>$date,'date'=>$date_exp[2],'month'=>$date_exp[1],'year'=>$date_exp[0],'y_value'=>str_replace("_", " ", $each_value),'y_sub_value'=>$each_value_,'value'=>$value,'data_row'=>$data_row,'data_coloumn'=>$k];
		

	$k++;
}
}


      #echo "<pre>";print_r($fetchRecord);
      echo "<pre>";print_r($InsertArray);
      $Capsule=new Capsule;
      Capsule::table(TBL_GRAPH_VALUES)->insert($InsertArray);
    
	
}
}
}
$obj = new covidAutomation();
$obj->Run(302);