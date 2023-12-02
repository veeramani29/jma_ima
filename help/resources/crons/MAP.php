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

	protected $prefectures=['Tested positive','Recovered','Deaths'];
	protected $prefectures_=['Daily cases','Total cases'];

 public function __construct()
    {
        parent::__construct();
          /*    $Capsule=new Capsule;
$oldSet=$this->oldSet(303,-8);
        foreach ($oldSet as $key => $region) {
        	Capsule::table(TBL_GRAPH_VALUES)->where('gid', 303)->where('x_value', date('Y/m/d',strtotime('-3 day')))->where('data_coloumn', $region['data_coloumn'])->update(['region'=>$region['region']]);
        }*/
      
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

private function oldSet($gid,$day){
	$Capsule=new Capsule;$final=[];
	
$get = Capsule::table(TBL_GRAPH_VALUES)->select('region','data_row')->where('gid', $gid)->where('x_value', date('Y/m/d',strtotime($day.' day')))->groupBy('region')->orderBy('region','asc')->get();
return $get;
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
$today=date('Y/m/d',strtotime('-2 day'));
if(!empty($fetchRecord)){
$all_cities=array_column($fetchRecord, 4);
$fetchOldRecord=$this->twodaysback();
$oldSet=$this->oldSet($gid,-3);
#echo "<pre>";print_r($oldSet);die;

$date_exp=explode("/", $today);
$k=2;
foreach ($all_cities as $key => $region) {
	foreach ($this->prefectures_ as $keys => $each_value) {
	foreach ($this->prefectures as $each_value_) {
			
		
		if($each_value=='Total cases'){
			$total_case=$fetchRecord[$key][5];
			$total_recover=$fetchRecord[$key][7];
			$total_death=$fetchRecord[$key][8];

			if($each_value_=='Tested positive'){
			$value=$total_case;
			}elseif($each_value_=='Recovered'){
			$value=$total_recover;
			}else{
			$value=$total_death;
			}

		}else{
			$daily_case=$fetchRecord[$key][5]-$fetchOldRecord[$key][5];
			$daily_recover=$fetchRecord[$key][7]-$fetchOldRecord[$key][7];
			$daily_death=$fetchRecord[$key][8]-$fetchOldRecord[$key][8];

			if($each_value_=='Tested positive'){
			$value=$daily_case;
			}elseif($each_value_=='Recovered'){
			$value=$daily_recover;
			}else{
			$value=$daily_death;
			}

			if($value<0) $value=max($value,0);
		}


		
		$data_row=$oldSet[0]['data_row']+1;
	#'old'=>$fetchOldRecord[$key][5],'new'=>$fetchRecord[$key][5],
		$InsertArray[]= ['gid'=>$gid, 'x_value'=>$today,'date'=>$date_exp[2],'month'=>$date_exp[1],'year'=>$date_exp[0],'y_value'=>str_replace("_", " ", $each_value_),'y_sub_value'=>$each_value,'value'=>$value,'data_row'=>$data_row,'data_coloumn'=>$k,'region'=>$oldSet[$key]['region']];
		

	$k++;
}
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
	$get = Capsule::table('post')->select('post_cms')->where('post_id', 363)->get();
	$previus_day=date('Y-m-d',strtotime('-3 day'));
	$today=date('Y-m-d',strtotime('-2 day'));
	$post_cms=$get[0]['post_cms'];
	$post_cms=preg_replace('/'.$previus_day.'/', $today, $post_cms, 2);
	 #$post_cms=str_replace($previus_day, $today, $get[0]['post_cms']);
	$result = Capsule::table('post')->where('post_id', 363)->update(['post_cms'=>$post_cms]);

}

}
$obj = new covidAutomation();
$obj->Run(303);