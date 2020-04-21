<?php
define('DB_SERVER','localhost');//localhost
define('DB_USER','root');//user
define('DB_PASS','');//not yet set
define('DB_NAME','btc3205');//database name

class  DBConnector{

	public $conn;
	/*database will be connected inside the class constructor
	hence a database connection is created whenever an object is created*/
	
	function __construct (){
		$this->conn=new mysqli(DB_SERVER,DB_USER,DB_PASS)or die("Error:".mysqli_connect_error());
	    mysqli_select_db($this->conn,DB_NAME);
		
	}
	
	public function closeDatabase(){
		mysqli_close($this->conn);
	}
	
}


?>