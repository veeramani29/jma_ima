<?php
namespace resources\crons;
define('SERVER_ROOT' , realpath( dirname(__DIR__).'/../'));
require SERVER_ROOT . '/bootstrap/autoload.php';
$app=require SERVER_ROOT . '/bootstrap/app.php';
$app->boot(); 
use Dotenv\Dotenv;
$dotenv = new Dotenv(SERVER_ROOT);
$dotenv->load();
require_once 'simple_html_dom.php';
/*set_time_limit(-1);
ini_set('max_execution_time', -1);*/
 //echo  env('APP_ENV');
//dd($app);

use \Illuminate\Database\Capsule\Manager as Capsule;

class Crons {
	public $notificationMailTo;
	public $View = '';
	public $viewPath = '';
	

	protected $ASIA=['China','India','Indonesia','Iran','Japan','Malaysia','Philippines','South_Korea','Thailand'];
	protected $EU=['Belgium','France','Germany','Italy','Netherlands','Spain','Switzerland','United_Kingdom'];
	protected $GL=['China','Europe','Global','India','Japan','United_States_of_America'];
protected $FirstGraph=['Total Confirmed Cases', 'Daily Confirmed Cases','Total Deaths','Daily Deaths','COVID-19 Doubling Time Cases','COVID-19 Doubling Time Deaths'];
protected $FirstGraph_jp=['感染者数（累計）', '感染者数（新規）','死亡者数（累計）','死亡者数（新規）','累計死者数の倍加日数','累計感染者数の倍加日数'];
protected $SecondGraph=['Total Number of Confirmed Cases', 'Daily New Confirmed Cases','Total number of Deaths','Daily New Deaths','COVID-19 Doubling Time Cases','COVID-19 Doubling Time Deaths'];
protected $SecondGraph_jp=['感染者数（累計）', '感染者数（新規）','死亡者数（累計）','死亡者数（新規）','累計感染者数が倍増するまでの日数','累計死者数が倍増するまでの日数'];
protected $ThirdGraph=['Total Confirmed Cases', 'Daily Confirmed Cases','Total Deaths','Daily Deaths'];
protected $ThirdGraph_jp=['感染者数（累計）', '感染者数（新規）','死亡者数（累計）','死亡者数（新規）'];


	public function __construct(){

set_time_limit(0);
		
 		#$file = fopen("https://api.covid19india.org/csv/latest/state_wise_daily.csv","r");


  	#$readline=fgetcsv($file);dd($readline);
			$this->con_intialize();
			#$a=$this->getTotalCasesIMA();
			#dd($a);
		
		require SERVER_ROOT.'/config/constants.php';
		if(env('APP_ENV') == 'production' && PHP_SAPI != 'cli'){
			exit ("Error... Direct script execution is prohibited");
		}
		
		
	}

	private function con_intialize(){

		

		$Capsule=new Capsule;
		$Capsule->addConnection([
		'driver'    => env('DB_CONNECTION'),
		'host'      =>  env('DB_HOST'),
		'database'  =>  env('DB_DATABASE'),
		'username'  =>  env('DB_USERNAME'),
		'password'  => env('DB_PASSWORD'),
		'charset'   => 'utf8mb4',
		'collation' => 'utf8mb4_unicode_ci',
		'prefix'    => ''
		
		]);
		
		$Capsule->setAsGlobal();
		$Capsule->bootEloquent();
    	
   		//$rs = Capsule::table('admin')->limit(100)->get();
  		//echo "<pre>";print_r($rs);
	}

/*	protected function ReadenvFile(){
		$env_variables=array();
		 $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $lines = file(SERVER_ROOT.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        ini_set('auto_detect_line_endings', $autodetect);
        foreach ($lines as $line) {
        	$keyexplode=explode("=", $line);
        	$env_variables[$keyexplode[0]]=$keyexplode[1];
        }
        return $env_variables;
	}*/
	
protected function getDailyCases($readArray,$countries){
	$result = array_filter($readArray['records'], function ($item) use ($countries) {
    if ($item['dateRep']==date('d/m/Y',strtotime('-1 day')) && in_array($item['countriesAndTerritories'], $countries)) {
        return true;
    }
    return false;
});
	return array_values($result);
}

protected function getTotalCases($countries,$flag){
if($flag=='eu')
 $read=file_get_html("https://www.ecdc.europa.eu/en/cases-2019-ncov-eueea");
else
 $read=file_get_html("https://www.ecdc.europa.eu/en/geographical-distribution-2019-ncov-cases");

 $table=$read->find('div.field-name-field-pt-table',0);
$Total_Arr=[];
foreach($table->find('tbody tr') as $tr)
{	 $splitArr=explode(" ", $tr->plaintext);
	 if($flag!='eu')unset($splitArr[0]);
	 $splitArr=array_values(array_filter($splitArr));
if (in_array(trim($splitArr[0]), $countries)) {
	$Total_Arr[]=$splitArr;
    }
}
usort($Total_Arr, function($a, $b) {
    return strcmp($a[0] ,$b[0]);
	});
return $Total_Arr;
}



protected function getTotalCasesIMA(){

 echo $read=file_get_html("https://www.mohfw.gov.in/");die;

 $table=$read->find('section#state-data',0);
$Total_Arr=[];
foreach($table->find('table tbody tr') as $tr)
{	 $splitArr=explode(" ", $tr->plaintext);
	 
	 $splitArr=array_values(array_filter($splitArr));
	$Total_Arr[]=$splitArr;
 
}
/*usort($Total_Arr, function($a, $b) {
return strcmp($a[0] ,$b[0]);
});*/
return $Total_Arr;
}
		
	
	}
	
