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


private $COUNTRY=['TT'=>'India',
'AN'=>'Andaman and Nicobar Islands',
'AP'=>'Andhra Pradesh',
'AR'=>'Arunachal Pradesh',
'AS'=>'Assam',
'BR'=>'Bihar',
'CH'=>'Chandigarh',
'CT'=>'Chhattisgarh',
#'DN'=>'veera',
'DD'=>'Dadra and Nagar Haveli and Daman and Diu',
'DL'=>'Delhi',
'GA'=>'Goa',
'GJ'=>'Gujarat',
'HR'=>'Haryana',
'HP'=>'Himachal Pradesh',
'JK'=>'Jammu and Kashmir',
'JH'=>'Jharkhand',
'KA'=>'Karnataka',
'KL'=>'Kerala',
'LA'=>'Ladakh',
'LD'=>'Lakshadweep',
'MH'=>'Maharashtra',
'MN'=>'Manipur',
'MP'=>'Madhya Pradesh',
'ML'=>'Meghalaya',
'MZ'=>'Mizoram',
'NL'=>'Nagaland',
'OR'=>'Odisha',
'PY'=>'Puducherry',
'PB'=>'Punjab',
'RJ'=>'Rajasthan',
'SK'=>'Sikkim',
'TN'=>'Tamil Nadu',
'TG'=>'Telangana',
'TR'=>'Tripura',
'UP'=>'Uttar Pradesh',
'UT'=>'Uttarakhand',
'WB'=>'West Bengal'
];


	protected $prefectures=['COVID-19 Doubling Time Cases',
	'COVID-19 Doubling Time Deaths'];

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
		'collation' => 'utf8_general_ci',
		'prefix'    => ''
		
		]);
		
		$Capsule->setAsGlobal();
		$Capsule->bootEloquent();
      
    }

    private function oldRow($gid,$day){
	$Capsule=new Capsule;$final=[];
	
$get = Capsule::table(TBL_GRAPH_VALUES)->where('gid', $gid)->where('x_value',  date('Y/m/d',strtotime($day.' days')))->limit(1)->get(); 
return $get[0]['data_row'];
}
private function oldSet($gid,$day){
	$Capsule=new Capsule;$final=[];
	
$get = Capsule::table(TBL_GRAPH_VALUES)->where('gid', 133)->where('x_value',  date('Y/m/d',strtotime($day.' days')))->orderBy('y_value','asc')->get(); 
$result = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Total Confirmed Cases') { return true; }
return false;
});
$final_cases=array_values($result);  
$india=$final_cases[13];
unset($final_cases[13]);
array_unshift($final_cases, $india);
$final['cases']=$final_cases;
$result_s = array_filter($get, function ($item)  {
if ($item['y_sub_value']=='Total Deaths') { return true; }
return false;
});

$final_deaths=array_values($result_s);
$india=$final_deaths[13];
unset($final_deaths[13]);
array_unshift($final_deaths, $india);
$final['deaths']=$final_deaths;



	return $final;
}




public function Run($gid){
  $jp_date=date('d-M-y',strtotime('-1 day'));
  $today=date('Y/m/d',strtotime('-1 day'));
$file = fopen("state_wise_daily.csv","r");
$allState=fgetcsv($file); 
unset($allState[0]);unset($allState[1]);unset($allState[2]);unset($allState[11]);unset($allState[41]);
/*asort(($allState));*/$allState=array_values($allState);
$fetchRecord=[];
while(! feof($file))
  {

  	$readline=fgetcsv($file);
	if($readline[0]==$jp_date){
	$fetchRecord[$readline[2]]=$readline;
	}

	
  }
fclose($file);
//dd($fetchRecord);

	$InsertArray=[];

if(!empty($fetchRecord)){
$allState=$allState;

$Confirmed=$fetchRecord['Confirmed']; $confirmed_=$Confirmed[11];
unset($Confirmed[0]);unset($Confirmed[1]);unset($Confirmed[2]);unset($Confirmed[11]);unset($Confirmed[41]); $Confirmed=array_values($Confirmed);

$Deceased=$fetchRecord['Deceased'];$deceased_=$Deceased[11];
unset($Deceased[0]);unset($Deceased[1]);unset($Confirmed[2]);unset($Deceased[41]);
unset($Deceased[11]);$Deceased=array_values($Deceased);
$data_row=$this->oldRow($gid,-2); 
$oldSet=$this->oldSet($gid,-2); $SevenDaysoldSet=$this->oldSet($gid,-8);
#dd($allState);

$date_exp=explode("/", $today);
$k=2;

foreach ($allState as $key => $each_value) {  
	if($each_value=='DD'){
		$dd_confirmed=$confirmed_;
		$dd_deceased=$deceased_;
	}else{
		$dd_confirmed=0;
		$dd_deceased=0;
	
	}


	foreach ($this->prefectures as $each_value_) {
		if ($each_value_=='COVID-19 Doubling Time Cases') {
			$current_cases=$oldSet['cases'][$key]['value']+($Confirmed[$key]+$dd_confirmed);
			$seven_days_before_cases=$SevenDaysoldSet['cases'][$key]['value'];
		$logs=log($current_cases,2)-log($seven_days_before_cases,2);
		$value=round((7/$logs));
		}elseif ($each_value_=='COVID-19 Doubling Time Deaths') {
		$current_deaths=$oldSet['deaths'][$key]['value']+($Deceased[$key]+$dd_deceased);
		$seven_days_before_deaths=$SevenDaysoldSet['deaths'][$key]['value'];
		$logs=log($current_deaths,2)-log($seven_days_before_deaths,2);
		$value=round((7/$logs));
		}
		if(is_nan($value) || is_infinite($value)){
		$value='';
		}

		$InsertArray[]= ['gid'=>$gid, 'x_value'=>$today,'date'=>$date_exp[2],'month'=>$date_exp[1],'year'=>$date_exp[0],'y_value'=>str_replace("_", " ", $this->COUNTRY[$each_value]),'y_sub_value'=>$each_value_,'value'=>$value,'data_row'=>($data_row+1),'data_coloumn'=>$k];
		

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
	$get = Capsule::table('post')->select('post_cms')->where('post_id', 90)->get();
	$previus_day=date('Y-m-d',strtotime('-2 day'));
	$today=date('Y-m-d',strtotime('-1 day'));
	$post_cms=$get[0]['post_cms'];
	$post_cms=preg_replace('/'.$previus_day.'/', $today, $post_cms, 1);
	 #$post_cms=str_replace($previus_day, $today, $get[0]['post_cms']);
	$result = Capsule::table('post')->where('post_id', 90)->update(['post_cms'=>$post_cms]);

}

}
$obj = new covidAutomation();
$obj->Run(135);
