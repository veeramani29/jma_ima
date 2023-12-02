<?php
define('SERVER_ROOT' , realpath( dirname(__DIR__).'/../'));
require SERVER_ROOT . '/bootstrap/autoload.php';
$app=require SERVER_ROOT . '/bootstrap/app.php';
$app->boot(); 
use Dotenv\Dotenv;
$dotenv = new Dotenv(SERVER_ROOT);
$dotenv->load();
/*
 * Author : Dinson Kadudhus
 * Date   : 2010 - July - 09
 */
class mysql
{
	public $connection;
	protected $hostname;
	protected $database;
	protected $username;
	protected $password;
	function __construct() 
	{
		/* $config_file = '../config/conf.ini';
		$confVals = parse_ini_file($config_file,true);
		$conf_env = $confVals['environment'];
		$db_config_file = '../config/database.ini';
		$dbVals = parse_ini_file($db_config_file,true);
		$config = $dbVals[$conf_env];
		$this->hostname = $config['host'];
		$this->database = $config['database'];
		$this->username = $config['user'];
		$this->password = $config['password']; */
		
		$this->hostname =  env('DB_HOST');
		$this->database = env('DB_DATABASE');
		$this->username = env('DB_USERNAME');
		$this->password = env('DB_PASSWORD');
		
		/*
                $dbhost  = 'localhost';
                $dbuser  = 'root';
                $dbpass  = '';
                $dbname  = 'jma_www';
                
		$this->database = $dbname;
		$this->hostname = $dbhost;
		$this->username = $dbuser;
		$this->password = $dbpass;
		*/
	}
	public function open() 
	{
		if(is_null($this->database)) 
			die("MySQL database not selected");
		if(is_null($this->hostname)) 
			die("MySQL hostname not set");
		$this->connection =  mysqli_connect($this->hostname,$this->username,$this->password,$this->database);
		if($this->connection === false) 
			die("Could not connect to database. Check your username and password then try again.\n");
		if(!mysqli_select_db($this->connection,$this->database))
			die("Could not select database");
	}
	public function close() 
	{
		mysqli_close($this->connection);
		$this->connection = null;
	}
	public function affectedRows() 
	{
		return mysqli_affected_rows($this->connection);
	}
	public function insertId() 
	{
		return mysqli_insert_id($this->connection);
	}
	public function numRows($result) 
	{
		return mysqli_num_rows($result);
	}
	public function insert($sql) 
	{
		if($this->connection === false) 
		{
			die('No Database Connection Found.');
		}
		$result=@mysqli_query($this->connection,$sql);
		if($result === false) 
		{
			die(mysqli_error($this->connection));
		}
	}
	public function query($sql) 
	{
		if($this->connection === false) 
		{
			die('No Database Connection Found.');
		}
		$result = @mysqli_query($this->connection,$sql);
		if($result === false) 
		{
			die(mysqli_error($this->connection));
		}
		return $result;
	}
	public function fetchArray($result) 
	{

		if ($this->connection === false) 
		{
			die('No Database Connection Found.');
		}
		$i=0;
		$temp=array();
		while($data = @mysqli_fetch_array($result))
		{
			$temp[$i]=$data;
			$i++;
		}
		if (!is_array($temp)) 
		{
			die(mysqli_error($this->connection));
		}
		return $temp;
	}
	function selectQuery($sql) 
	{
		$this->open();
		$results = $this->fetchArray($this->query($sql));
		$this->close();
		return $results;
	}
	function insertQuery($sql) 
	{
		$this->open();
		$this->query($sql);
		$primary_key = $this->insertId();
		$this->close();
		return $primary_key;
	}
	function executeQuery($sql) 
	{
		$this->open();
		$results = $this->query($sql);
		$this->close();
		return $results;
	}
        
        /**
	 * Function inserts a record into a table.
	 * Input @param: Table name, Associative array of record [Field name as array
	 * key & field value as array value].
	 * @return ID of record inserted if it succeeds, else returns FALSE
	 */
    function insertRecord($tableName, $arrRecord)
    {
		
        $tableName = trim($tableName);

        if (empty($tableName) || empty($arrRecord) || !is_array($arrRecord))
            return FALSE;


        
        $fieldList = $valueList = '';
        foreach ($arrRecord as $fieldName => $fieldValue) {
            $fieldList .= $fieldName . ',';
            if (is_string($fieldValue))
                $valueList .= "'" . mysqli_real_escape_string($this->connection,$fieldValue) . "',";
            else
                $valueList .= $fieldValue . ',';
        }
        $fieldList = substr($fieldList, 0, -1);
        $valueList = substr($valueList, 0, -1);
        
       $insertQuery = 'INSERT INTO ' . $tableName .  ' (' . $fieldList . ') '.
        'VALUE (' . $valueList . ');';

        $this->query($insertQuery);
        
        $primary_key = $this->insertId();

		if($primary_key)
			return $primary_key;
        return FALSE;
    }
	
}


?>
