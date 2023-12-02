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





private function oldSet($gid,$day){
	$Capsule=new Capsule;$final=[];
	echo date('Y/m/d',strtotime($day.' days'));
	$get = Capsule::table(TBL_GRAPH_VALUES)->where('gid', $gid)->where('x_value', date('Y/m/d',strtotime($day.' days')))->orderBy('y_value','asc')->get();
	
$result = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Total Number of Confirmed Cases') { return true; }
return false;
});
$final['cases']=array_values($result);
$result_s = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Total number of Deaths') { return true; }
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
	$fetchRecord=$this->getDailyCases($readArray,$this->EU);
	$oldSet=$this->oldSet($gid,-2)/*$this->getTotalCases($this->EU,'eu');*/;   
	$SevenDaysoldSet=$this->oldSet($gid,-8);
  $date_exp=explode("/", $date_);
$k=2;
foreach ($this->EU as $key => $each_value) {
	foreach ($this->SecondGraph as $each_value_) {

		if($fetchRecord[$key]['cases']<0){
			$fetchRecord[$key]['cases']=max($fetchRecord[$key]['cases'],0);
		}elseif ($fetchRecord[$key]['deaths']<0) {
			$fetchRecord[$key]['deaths']=max($fetchRecord[$key]['deaths'],0);
		}
		
		if($each_value_=='Daily New Confirmed Cases'){
			$value=$fetchRecord[$key]['cases'];
		}elseif($each_value_=='Daily New Deaths'){
			$value=$fetchRecord[$key]['deaths'];
		}elseif($each_value_=='Total Number of Confirmed Cases'){
			$value=$oldSet['cases'][$key]['value']+$fetchRecord[$key]['cases'];
			#$value=$oldSet[$key][1]+$fetchRecord[$key]['cases'];
			$current_cases=$value;
			$seven_days_before_cases=$SevenDaysoldSet['cases'][$key]['value'];
		}elseif ($each_value_=='Total number of Deaths') {
			$value=$oldSet['deaths'][$key]['value']+$fetchRecord[$key]['deaths'];
			#$value=$oldSet[$key][2]+$fetchRecord[$key]['deaths'];
			#$current_deaths=$value;
			#$seven_days_before_deaths=$SevenDaysoldSet['deaths'][$key]['value'];
		}elseif ($each_value_=='COVID-19 Doubling Time Cases') {
		$current_cases=$fetchRecord[$key]['cases'];
			$seven_days_before_cases=$SevenDaysoldSet['cases'][$key]['value'];
		$logs=log($current_cases,2)-log($seven_days_before_cases,2);
		$value=round((7/$logs));
		}elseif ($each_value_=='COVID-19 Doubling Time Deaths') {
				$current_deaths=$fetchRecord[$key]['deaths'];
			$seven_days_before_deaths=$SevenDaysoldSet['deaths'][$key]['value'];
		$logs=log($current_deaths,2)-log($seven_days_before_deaths,2);
		$value=round((7/$logs));
		}

		
		$data_row=$oldSet['cases'][0]['data_row']+1; //or +7

		$InsertArray[]= ['gid'=>$gid, 'x_value'=>$date_,'date'=>$date_exp[2],'month'=>$date_exp[1],'year'=>$date_exp[0],'y_value'=>str_replace("_", " ", $each_value),'y_sub_value'=>$each_value_,'value'=>$value,'data_row'=>$data_row,'data_coloumn'=>$k];
		

	$k++;
}
}

		#echo "<pre>";print_r($oldSet);
   		 #echo "<pre>";print_r($SevenDaysoldSet);
      #	echo "<pre>";print_r($InsertArray);
      	 #echo "<pre>";print_r($fetchRecord);
      
      $Capsule=new Capsule;
      Capsule::table(TBL_GRAPH_VALUES)->insert($InsertArray);
    
	
}
}
}
$obj = new covidAutomation();
$obj->Run(132);