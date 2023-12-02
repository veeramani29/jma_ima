<?php
namespace resources\crons;
ini_set('memory_limit', '2000M');
ini_set('max_execution_time', 0);
ini_set('display_errors',1); 
error_reporting(E_ALL);
require 'Crons.php';
use \App\Libraries\mailer\PHPMailer;
use \Illuminate\Database\Capsule\Manager as Capsule;


class covidAutomation extends Crons {

	

 public function __construct()
    {
    	 parent::__construct();
    	$Capsule=new Capsule;
		$Capsule->addConnection([
		'driver'    => env('DB_CONNECTION'),
		'host'      =>  env('DB_HOST'),
		'database'  =>  'ima_live',
		'username'  =>  env('DB_USERNAME'),
		'password'  => env('DB_PASSWORD'),
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => ''
		
		]);
		
		$Capsule->setAsGlobal();
		$Capsule->bootEloquent();

       
    }



private function oldSet($gid){
	$Capsule=new Capsule;$final=[];
	$get = Capsule::table(TBL_GRAPH_VALUES)->where('gid', $gid)->where('x_value', date('Y/m/d',strtotime('-2 days')))->orderBy('y_value','asc')->get();
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

	$date_=date('Y/m/d',strtotime('-1 day'));
$arrContextOptions=array(
    "ssl"=>array(
         "verify_peer"=>false,
         "verify_peer_name"=>false,
    ),
); 
	$InsertArray=[];
$read=file_get_contents('/var/www/www/resources/crons/response.txt');

#$read=file_get_contents('https://opendata.ecdc.europa.eu/covid19/casedistribution/json/', false, stream_context_create($arrContextOptions));
$readArray = json_decode(($read), true);
if(isset($readArray['records']) && !empty($readArray['records'])){
	$fetchRecord=$this->getDailyCases($readArray,$this->ASIA);
	$oldSet=$this->oldSet($gid);#$oldSet_=$this->getTotalCases($this->ASIA,'asia');  
$date_exp=explode("/", $date_);
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

		$InsertArray[]= ['gid'=>$gid, 'x_value'=>$date_,'date'=>$date_exp[2],'month'=>$date_exp[1],'year'=>$date_exp[0],'y_value'=>str_replace("_", " ", $each_value),'y_sub_value'=>$each_value_,'value'=>$value,'data_row'=>$data_row,'data_coloumn'=>$k];
		

	$k++;
}
}


    //echo "<pre>";print_r($fetchRecord);
     echo "<pre>";print_r($InsertArray);
      $Capsule=new Capsule;
      Capsule::table(TBL_GRAPH_VALUES)->insert($InsertArray);
       $this->postCMSreplace();
    
	
}
}
private function postCMSreplace(){
  $Capsule=new Capsule;
  $get = Capsule::table('post')->select('post_cms')->where('post_id', 85)->get();
  $previus_day=date('Y-m-d',strtotime('-2 day'));$previus_day_=date('F d,Y',strtotime('-2 day'));
  $today=date('Y-m-d',strtotime('-1 day'));$today_=date('F d,Y',strtotime('-1 day'));
   $post_cms=str_replace([$previus_day,$previus_day_], [$today,$today_], $get[0]['post_cms']);
  $result = Capsule::table('post')->where('post_id', 85)->update(['post_cms'=>$post_cms]);

}

}
$obj = new covidAutomation();
$obj->Run(131);