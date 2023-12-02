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

  protected $prefectures=['PCR Test Positive Rate, %'];

 public function __construct()
    {
        parent::__construct();
      
    }
private function oldSet($gid,$day){
  $Capsule=new Capsule;$final=[];
  
$get = Capsule::table(TBL_GRAPH_VALUES)->where('gid', $gid)->where('x_value',  date('Y/m/d',strtotime($day.' days')))->orderBy('y_value','asc')->limit(1)->get();
return $get;
}

private function sevendaysavg($state){
   $jp_date=date('Ymd',strtotime('-3 days'));

  $file = fopen("https://raw.githubusercontent.com/kaz-ogiwara/covid19/master/data/prefectures.csv","r");

$fetchRecord=[];$Calc=[];
while(! feof($file))
  {
    $readline=fgetcsv($file);
    $month=($readline[1]>9)?$readline[1]:'0'.$readline[1];
    $day=($readline[2]>9)?$readline[2]:'0'.$readline[2];
   if($state==$readline[4] && $readline[0].$month.$day<=$jp_date && $readline[0].$month.$day>=date('Ymd',strtotime('-9 days'))){
    $fetchRecord[]=$readline;
    }

    /*if($state==$readline[4] && ($readline[0].$readline[1].$readline[2]==$jp_date)){
    $fetchRecord[]=$readline;
     }*/
  }
 #dd($fetchRecord);
fclose($file);

if(!empty($fetchRecord)){
 
  foreach ($fetchRecord as $key => $value) {
    if (isset($fetchRecord[$key+1])) {
      $Calc['testedPositive'][]=$fetchRecord[$key+1][5]-$fetchRecord[$key][5];
      $Calc['peopleTested'][]=$fetchRecord[$key+1][6]-$fetchRecord[$key][6];
    }
    
  }
}  
# dd($Calc);
return $Calc;
  }

private function twodaysback(){
 $jp_date=date('Ynj',strtotime('-3 days'));
$file = fopen("https://raw.githubusercontent.com/kaz-ogiwara/covid19/master/data/prefectures.csv","r");
$fetchRecord=[];
while(! feof($file))
  {
    $readline=fgetcsv($file);
    if($readline[0].$readline[1].$readline[2]==$jp_date){
    $fetchRecord[]=$readline;
 
    }
  }
fclose($file);
if(!empty($fetchRecord)){

usort($fetchRecord, function($a, $b) {
    return strcmp($a[4] ,$b[4]);
  }); 
}
return $fetchRecord;
}
#summary.csv
public function Run($gid){
 $jp_date=date('Ynj',strtotime('-2 day'));
$file = fopen("https://raw.githubusercontent.com/kaz-ogiwara/covid19/master/data/prefectures.csv","r");
$fetchRecord=[];
while(! feof($file))
  {

    $readline=fgetcsv($file);
    if($readline[0].$readline[1].$readline[2]==$jp_date){
    $fetchRecord[]=$readline;
 
    }
  }
fclose($file);
if(!empty($fetchRecord)){
usort($fetchRecord, function($a, $b) {
    return strcmp($a[4] ,$b[4]);
  }); 
}

  $InsertArray=[];

if(!empty($fetchRecord)){
$all_cities=array_column($fetchRecord, 4);
$fetchOldRecord=$this->twodaysback();
$oldSet=$this->oldSet($gid,-3);
#echo "<pre>";print_r($fetchRecord);die;
 $today=date('Y/m/d',strtotime('-2 day'));
$date_exp=explode("/", $today);
$k=2;
foreach ($all_cities as $key => $each_value) {
  foreach ($this->prefectures as $each_value_) {
      $fetchAvgRecord=$this->sevendaysavg($each_value);
       $fetchRecord[$key][4];
       $peopleTested=$fetchRecord[$key][6];
       $testedPositive=$fetchRecord[$key][5];
       $daily_tested=$peopleTested-$fetchOldRecord[$key][6];
      array_push($fetchAvgRecord['peopleTested'], $daily_tested);
      $daily_positive=$testedPositive-$fetchOldRecord[$key][5];
      array_push($fetchAvgRecord['testedPositive'], $daily_positive);

      $testedPositiveAvg=array_sum($fetchAvgRecord['testedPositive'])/7;
      $peopleTestedAvg=array_sum($fetchAvgRecord['peopleTested'])/7;

      $value=($testedPositiveAvg/$peopleTestedAvg)*100;
      $value=round($value,0);
      #dd($fetchAvgRecord);die;


    
    $data_row=$oldSet[0]['data_row']+1;
  
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
  $get = Capsule::table('post')->select('post_cms')->where('post_id', 368)->get();
  $previus_day=date('Y-m-d',strtotime('-3 day'));
  $today=date('Y-m-d',strtotime('-2 day'));
   $post_cms=str_replace($previus_day, $today, $get[0]['post_cms']);
  $result = Capsule::table('post')->where('post_id', 368)->update(['post_cms'=>$post_cms]);

}
}
$obj = new covidAutomation();
$obj->Run(312);