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

	protected $prefectures=['Total Confirmed Cases',
'Daily Confirmed Cases',
'Daily Cases, 7days Avg',
'Total Deaths',
'Daily Deaths',
'Daily Deaths, 7days Avg',
'Total Discharged',
'Daily Discharged',
'Daily Discharged, 7days Avg',
'Total Hospitalized',
'Daily Hospitalized',
'Daily Hospitalized, 7days Avg'];

 public function __construct()
    {
        parent::__construct();
      
    }

    private function sevendays_avg($gid,$state,$row){
	$Capsule=new Capsule;$final=[];
	
$get = Capsule::table(TBL_GRAPH_VALUES)->select('y_sub_value','value')->where('gid', $gid)->where('y_value', $state)->whereBetween('data_row', [$row-5,$row])->orderBy('y_sub_value','asc')->get();#echo "<pre>";print_r($get);
$result = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Daily Confirmed Cases') { return true; }
return false;
});
$final['testedPositive']=array_values(array_column($result, 'value'));
$result_s = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Daily Deaths') { return true; }
return false;
});

	$final['deaths']=array_values(array_column($result_s, 'value'));

	$result = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Daily Discharged') { return true; }
return false;
});
$final['discharged']=array_values(array_column($result, 'value'));

#dd($final);
	return $final;
}
private function oldSet($gid,$day){
	$Capsule=new Capsule;$final=[];
	
$get = Capsule::table(TBL_GRAPH_VALUES)->where('gid', $gid)->where('x_value', date('Y/m/d',strtotime($day.' days')))->orderBy('y_value','asc')->get();#echo "<pre>";print_r($get);
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

	$result = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Total Discharged') { return true; }
return false;
});
$final['discharges']=array_values($result);


	return $final;
}

private function sevendaysavg($state){
   $jp_date=date('Ymd',strtotime('-3 days')); 
   $avg_date=date('Ymd',strtotime('-9 days'));

  $file = fopen("https://raw.githubusercontent.com/kaz-ogiwara/covid19/master/data/prefectures.csv","r");

$fetchRecord=[];$Calc=[];
while(! feof($file))
  {
    $readline=fgetcsv($file);
    $month=($readline[1]>9)?$readline[1]:'0'.$readline[1];
    $day=($readline[2]>9)?$readline[2]:'0'.$readline[2];
   if($state==$readline[4] && $readline[0].$month.$day<=$jp_date && $readline[0].$month.$day>=$avg_date){
    $fetchRecord[]=$readline;
    }

  
  }
 #dd($fetchRecord);
fclose($file);

if(!empty($fetchRecord)){
 
  foreach ($fetchRecord as $key => $value) {
    if (isset($fetchRecord[$key+1])) {
      $Calc['testedPositive'][]=$fetchRecord[$key+1][5]-$fetchRecord[$key][5];
      $Calc['discharged'][]=$fetchRecord[$key+1][7]-$fetchRecord[$key][7];
       $Calc['deaths'][]=$fetchRecord[$key+1][8]-$fetchRecord[$key][8];
    }
    
  }
}  
return $Calc;
  }

public function Run($gid){
	  $jp_date=date('Ymd',strtotime('-2 days'));
	  $todayy=date('Y/n/j',strtotime('-2 days'));
	  $today=date('Y/m/d',strtotime('-2 days'));
$file = fopen("https://raw.githubusercontent.com/kaz-ogiwara/covid19/master/data/prefectures.csv","r");
$fetchRecord=[];
while(! feof($file))
  {
  	$readline=fgetcsv($file);
  	 $month=($readline[1]>9)?$readline[1]:'0'.$readline[1];
    $day=($readline[2]>9)?$readline[2]:'0'.$readline[2];
  	if($readline[0].$month.$day==$jp_date){
  	$fetchRecord[]=$readline;
 
    }
  }
fclose($file);

if(!empty($fetchRecord)){
	//Custom Push
$testedPositive=array_sum(array_column($fetchRecord, 5));
$peopleTested=array_sum(array_column($fetchRecord, 6));
$discharged=array_sum(array_column($fetchRecord, 7));
$deaths=array_sum(array_column($fetchRecord, 8));
$today_=explode("/", $todayy);
$JapanData=[$today_[0],$today_[1],$today_[2],"日本","Japan",$testedPositive,$peopleTested,$discharged,$deaths];
array_push($fetchRecord,$JapanData);
usort($fetchRecord, function($a, $b) {
    return strcmp($a[4] ,$b[4]);
	});	
}

	$InsertArray=[];

if(!empty($fetchRecord)){
$all_cities=array_column($fetchRecord, 4);
$oldSet=$this->oldSet($gid,-3);
#$SevenDaysoldSet=$this->oldSet($gid,'2020/05/23');
#echo "<pre>";print_r($SevenDaysoldSet);#die;
$date_exp=explode("/", $today);
$k=2;
foreach ($all_cities as $key => $each_value) {
	foreach ($this->prefectures as $each_value_) {
		if($each_value=='Japan'){
		$fetchAvgRecord=$this->sevendays_avg($gid,$each_value,$oldSet['cases'][0]['data_row']);
		}else{
			$fetchAvgRecord=$this->sevendaysavg($each_value);
		}
		#dd($fetchAvgRecord);
		if($each_value_=='Total Confirmed Cases'){
			$value=$fetchRecord[$key][5];
		}elseif($each_value_=='Total Deaths'){
			$value=$fetchRecord[$key][8];
		}elseif($each_value_=='Total Discharged'){
			$value=$fetchRecord[$key][7];
		}elseif ($each_value_=='Total Hospitalized') {
			$value='';/*$fetchRecord[$key][6]*/;
		}elseif ($each_value_=='Daily Confirmed Cases') {
			$value=$fetchRecord[$key][5]-$oldSet['cases'][$key]['value'];
		}elseif ($each_value_=='Daily Deaths') {
			$value=$fetchRecord[$key][8]-$oldSet['deaths'][$key]['value'];
		}elseif ($each_value_=='Daily Discharged') {
			$value=$fetchRecord[$key][7]-$oldSet['discharges'][$key]['value'];
		}elseif ($each_value_=='Daily Hospitalized') {
			$value='';/*$fetchRecord[$key][6]-$oldSet['hosp'][$key]['value'];*/
		}elseif ($each_value_=='Daily Cases, 7days Avg') {
		$current_cases=$fetchRecord[$key][5]-$oldSet['cases'][$key]['value'];
		array_push($fetchAvgRecord['testedPositive'], $current_cases);
		$value=round(array_sum($fetchAvgRecord['testedPositive'])/7);
		}elseif ($each_value_=='Daily Deaths, 7days Avg') {
		$current_deaths=$fetchRecord[$key][8]-$oldSet['deaths'][$key]['value'];
		array_push($fetchAvgRecord['deaths'], $current_deaths);
		$value=round(array_sum($fetchAvgRecord['deaths'])/7);
		}elseif ($each_value_=='Daily Discharged, 7days Avg') {
		$current_discharge=$fetchRecord[$key][7]-$oldSet['discharges'][$key]['value'];
		array_push($fetchAvgRecord['discharged'], $current_discharge);
		$value=round(array_sum($fetchAvgRecord['discharged'])/7);
		}elseif ($each_value_=='Daily Hospitalized, 7days Avg') {
		
		$value='';/*round((7/$logs));*/
		}


		
		$data_row=$oldSet['cases'][0]['data_row']+1;
	
		$InsertArray[]= ['gid'=>$gid, 'x_value'=>$today,'date'=>$date_exp[2],'month'=>$date_exp[1],'year'=>$date_exp[0],'y_value'=>str_replace("_", " ", $each_value),'y_sub_value'=>$each_value_,'value'=>$value,'data_row'=>$data_row,'data_coloumn'=>$k];
		

	$k++;
}
}


    //echo "<pre>";print_r($SevenDaysoldSet);
      echo "<pre>";print_r($InsertArray);
      $Capsule=new Capsule;
      Capsule::table(TBL_GRAPH_VALUES)->insert($InsertArray);
       $this->postCMSreplace();
    
	
}
}

private function postCMSreplace(){
  $Capsule=new Capsule;
  $get = Capsule::table('post')->select('post_cms')->where('post_id', 366)->get();
  $previus_day=date('Y-m-d',strtotime('-3 day'));
  $today=date('Y-m-d',strtotime('-2 day'));
   $post_cms=str_replace($previus_day, $today, $get[0]['post_cms']);
  $result = Capsule::table('post')->where('post_id', 366)->update(['post_cms'=>$post_cms]);

}

}
$obj = new covidAutomation();
$obj->Run(307);