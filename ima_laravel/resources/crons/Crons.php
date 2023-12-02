<?php
namespace resources\crons;
define('SERVER_ROOT' , realpath( dirname(__DIR__).'/../'));
require SERVER_ROOT . '/bootstrap/autoload.php';
$app=require SERVER_ROOT . '/bootstrap/app.php';
$app->boot(); 
use Dotenv\Dotenv;
$dotenv = new Dotenv(SERVER_ROOT);
$dotenv->load();


 //echo  env('APP_ENV');
//dd($app);

use \Illuminate\Database\Capsule\Manager as Capsule;

class Crons {
	public $notificationMailTo;
	public $View = '';
	public $viewPath = '';
	

	

	public function __construct(){
 		
			$this->con_intialize();
		
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
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
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
	

		
	
	}
	
