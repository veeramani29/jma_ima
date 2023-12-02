<?php
/*
 * Author : Dinson Kadudhus
 * Date   : 2010 - July - 09
 */
class mysql
{
	protected $connection;
	protected $hostname;
	protected $database;
	protected $username;
	protected $password;
	function __construct() 
	{
                $dbhost  = '10.0.1.108';
                $dbuser  = 'jma';
                $dbpass  = 'JMA-AWS-DBMAIN-JMA-K#G7H';
                $dbname  = 'jma_www';
                
		$this->database = $dbname;
		$this->hostname = $dbhost;
		$this->username = $dbuser;
		$this->password = $dbpass;
	}
	public function open() 
	{
		if(is_null($this->database)) 
			die("MySQL database not selected");
		if(is_null($this->hostname)) 
			die("MySQL hostname not set");
		$this->connection = @mysql_connect($this->hostname, $this->username, $this->password);
		if($this->connection === false) 
			die("Could not connect to database. Check your username and password then try again.\n");
		if(!mysql_select_db($this->database, $this->connection))
			die("Could not select database");
	}
	public function close() 
	{
		mysql_close($this->connection);
		$this->connection = null;
	}
	public function affectedRows() 
	{
		return mysql_affected_rows($this->connection);
	}
	public function insertId() 
	{
		return mysql_insert_id($this->connection);
	}
	public function numRows($result) 
	{
		return mysql_num_rows($result);
	}
	public function insert($sql) 
	{
		if($this->connection === false) 
		{
			die('No Database Connection Found.');
		}
		$result=@mysql_query($sql,$this->connection);
		if($result === false) 
		{
			die(mysql_error());
		}
	}
	public function query($sql) 
	{
		if($this->connection === false) 
		{
			die('No Database Connection Found.');
		}
		$result = @mysql_query($sql,$this->connection);
		if($result === false) 
		{
			die(mysql_error());
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
		while($data = @mysql_fetch_array($result))
		{
			$temp[$i]=$data;
			$i++;
		}
		if (!is_array($temp)) 
		{
			die(mysql_error());
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
                $valueList .= "'" . mysql_real_escape_string($fieldValue) . "',";
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
