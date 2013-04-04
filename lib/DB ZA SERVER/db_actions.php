<?php
/*
* Mysqli database manipulation class
* @verion 1.0.0.0
* @author Anonimus
* @license GNU Public License
*/
class Db_Actions{
	//////////////////////////////////////////////////////////////////
	//Database Connection Details
	//@var string $connection this var will hold active connection
	private static $connection;
	//@var string $host database connection host
	public static $host = "localhost";
	//@var string $user database user
	public static $user = "mavinsac_pixfacu";
	//@var string $password database password
	public static $password = "kd45D2##bmP(*kp";
	//@var string $database  mysql database name
	public static $database = "mavinsac_pixfactory";
	////////////////////////////////////////////////////////////////////
	
	//@var string $passwordHashEncryption password hash type
	public static $passwordHashEncryption = "SHA1";
	//@var array $queryResult this var will hold all data from last query
	private static $queryResult = array();
	//@var mixed $lastQuery this var will hold last successsfull query
	private static $lastQuery;
	//@var mixed $queryMicrotimeStart this var will hold time start of our query
	private static $queryMicrotimeStart;
	//@var mixed $queryMicrotimeEnd this var will hold time end of our query
	private static $queryMicrotimeEnd;
	//@var mixed $debugQueryString this var will hold last query string and will be displayed for debug purposess.
	private static $debugQueryString = array();
	
	/************************************************************************************************* 
	*  @method void __construct class construct method
	**************************************************************************************************/
	public function __construct(){}
	
	/************************************************************************************************* 
	*  @method void DbConnect handles database connection 
	**************************************************************************************************/
	public static function DbConnect(){
		try{
			self::$connection = new MySQLi(self::$host, self::$user, self::$password, self::$database);
			if(self::$connection->connect_errno){
				throw new Exception(self::$connection->connect_error, self::$connection->connect_errno);
			}
		}
		catch(Exception $e){
			echo "Error Number: " . $e->getCode() . "<br />" . "Message: " . $e->getMessage() . "<br />Line Number: " . $e->getLine() . "<br />File: " . $e->getFile();
		}
	}
	
	/************************************************************************************************* 
	*  @method int DbSelect handles database select queries
	*  @param string $queryString mysql select query string
	**************************************************************************************************/
	public static function DbSelect($queryString){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		array_push(self::$debugQueryString,$queryString);
		self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
		self::$queryMicrotimeEnd = microtime(true);
		self::$queryResult = array();
		if(self::$lastQuery){
			while($row = self::$lastQuery->fetch_array(MYSQLI_ASSOC)){
			   array_push(self::$queryResult,$row);
		    }
			return self::DbGetNumRows();
		}
	}
	/************************************************************************************************* 
	*  @method void DbSelectRow select only one row
	*  @param string $queryString mysql delete query string
	**************************************************************************************************/
	public static function DbSelectRow($queryString){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		array_push(self::$debugQueryString,$queryString);
		self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
		self::$queryMicrotimeEnd = microtime(true);
		self::$queryResult = array();
		$resultObject = new stdClass();
		while($row = self::$lastQuery->fetch_assoc()){
			array_push(self::$queryResult,$row);
		}
		if(count(self::$queryResult) > 0){
			foreach(self::$queryResult[0] as $key => $value){
			   $resultObject->$key = $value;
		    }
		}
		return $resultObject;
	}
	/************************************************************************************************* 
	*  @method void DbSelectRowByID select only one row
	*  @param string $table mysql table name
	*  @param int $ID table ID field to select data 
	**************************************************************************************************/
	public static function DbSelectRowByID($table, $ID){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		array_push(self::$debugQueryString,"SELECT * FROM " . $table." WHERE id=".$ID);
		self::$lastQuery = self::$connection->query("SELECT * FROM " . $table." WHERE id=".$ID) or die('Mysql error: ' . self::$connection->error);
		self::$queryMicrotimeEnd = microtime(true);
		self::$queryResult = array();
		$resultObject = new stdClass();
		while($row = self::$lastQuery->fetch_assoc()){
			array_push(self::$queryResult,$row);
		}
		if(count(self::$queryResult) > 0){
			foreach(self::$queryResult[0] as $key => $value){
			   $resultObject->$key = $value;
		    }
		}
		
		return $resultObject;
	}
	/************************************************************************************************* 
	*  @method void DbSelectLastRow select last row from table
	*  @param string $table database table to select from
	**************************************************************************************************/
	public static function DbSelectLastRow($table){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		array_push(self::$debugQueryString,"SELECT * FROM " . $table . " ORDER BY id DESC LIMIT 1");
		self::$lastQuery = self::$connection->query("SELECT * FROM " . $table . " ORDER BY id DESC LIMIT 1") or die('Mysql error: ' . self::$connection->error);
		self::$queryMicrotimeEnd = microtime(true);
		self::$queryResult = array();
		$resultObject = new stdClass();
		while($row = self::$lastQuery->fetch_assoc()){
			array_push(self::$queryResult,$row);
		}
		if(count(self::$queryResult) > 0){
			foreach(self::$queryResult[0] as $key => $value){
			   $resultObject->$key = $value;
		    }
		}
		
		return $resultObject;
	}
	/************************************************************************************************* 
	*  @method int DbInsert handles database insert queries
	*  @param string $queryString mysql insert query string
	**************************************************************************************************/
	public static function DbInsert($queryString){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		array_push(self::$debugQueryString,$queryString);
		self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
		self::$queryMicrotimeEnd = microtime(true);
		return self::$connection->insert_id;
	}
	/************************************************************************************************* 
	*  @method int DbInsert2 handles database insert queries but with table and array of fields and value parameters, and data is automatically sanitized
	*  if password filed type is meet, then it is encrypted with selected hash algorithm
	*  @param string $table mysql table to insert in
	*  @param array $fields associative array of table fields and values  $field => $value pairs
	**************************************************************************************************/
	public static function DbInsert2($table,$fields){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		//Build mysqli query string
		try{
		  if(is_array($fields)){
			  $fieldNames = "(";
			  //Fields
			  $fieldCounter = 0;
			  foreach($fields as $key => $value){
				  $fieldCounter++; 
				  if($fieldCounter < count($fields)){
					  $fieldNames .= $key . ", ";
				  }
				  else{
					 $fieldNames .= $key; 
				  }
			  }
			  $fieldNames .= ") ";
			  //Values
			  $fieldValues = "VALUES(";
			  $valueCounter = 0;
			  foreach($fields as $key => $value){
				  $valueCounter++; 
				  if($valueCounter < count($fields)){
					  switch(gettype($value)){
						  case "integer":
						  case "double":
						  //Check if field is of type password
						  if($key == "password"){ $fieldValues .= self::$passwordHashEncryption."('".self::DbSanitizeData($value)."'), "; }
						  else{ $fieldValues .= self::DbSanitizeData($value).", "; }
						  break;
						  case "string":
						  case "boolean":
						  //Check if field is of type password
						  if($key == "password"){ $fieldValues .= self::$passwordHashEncryption."('".self::DbSanitizeData($value)."'), "; }
						  else{ $fieldValues .= "'".self::DbSanitizeData($value)."', "; }
						  break;
						  default:
						  $fieldValues .= "'".self::DbSanitizeData($value)."', ";
						  break;
					  }
				  }
				  else{
					  switch(gettype($value)){
						  case "integer":
						  case "double":
						  //Check if field is of type password
						  if($key == "password"){ $fieldValues .= self::$passwordHashEncryption."('".self::DbSanitizeData($value)."')"; }
						  else{ $fieldValues .= self::DbSanitizeData($value); }
						  break;
						  case "string":
						  case "boolean":
						  //Check if field is of type password
						  if($key == "password"){ $fieldValues .= self::$passwordHashEncryption."('".self::DbSanitizeData($value)."')"; }
						  else{ $fieldValues .= "'".self::DbSanitizeData($value)."'"; }
						  break;
					  }
				  }
			  }
			  $fieldValues .= ")";
			  array_push(self::$debugQueryString,"INSERT INTO " . $table . $fieldNames . $fieldValues);
			  self::$lastQuery = self::$connection->query("INSERT INTO " . $table . $fieldNames . $fieldValues) or die('Mysql error: ' . self::$connection->error);
		  }
		  else{
			  throw new Exception('Method DbInsert2 - Parameter <strong>$fields</strong> is not an array object - this parameter must be an array<br />',9020);
		  }
		}
		catch(Exception $e){
				echo 'Error code: <strong>' . $e->getCode() . "</strong><br />" .$e->getMessage() ."At Line: <strong>".$e->getLine() . "</strong><br />In " . $e->getFile();
		}
		self::$queryMicrotimeEnd = microtime(true);
		return self::$connection->insert_id;
	}
	
	/************************************************************************************************* 
	*  @method int DbUpdate handles database update queries
	*  @param string $queryString mysql update query string
	**************************************************************************************************/
	public static function DbUpdate($queryString){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		array_push(self::$debugQueryString,$queryString);
		self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
		return self::DbGetAffectedRows();
	}
	
	/************************************************************************************************* 
	*  @method int DbUpdate2 handles database update queries
	*  @param string $table mysql table name
	*  @param array $fields associative array of table fields and values  $field => $value pairs
	*  @param mixed $updateCondition this parameter holds logical condition for the update
	**************************************************************************************************/
	public static function DbUpdate2($table,$fields,$updateCondition=""){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		//Build mysqli query string
		try{
		  if(is_array($fields)){
			  //Build query string
			  $queryString = "UPDATE " . $table . " SET ";
			  $valueCounter = 0;
			  foreach($fields as $fieldName => $fieldValue){
				  $valueCounter++;
				  if($valueCounter < count($fields)){
					  switch(gettype($fieldValue)){
						  case "integer":
						  case "double":
						  //Check if field is of type password
						  if($fieldName == "password"){ $queryString .= $fieldName."=".self::$passwordHashEncryption."('".self::DbSanitizeData($fieldValue)."'), "; }
						  else{ $queryString .= $fieldName ."=". self::DbSanitizeData($fieldValue).", "; }
						  break;
						  case "string":
						  case "boolean":
						  //Check if field is of type password
						  if($fieldName == "password"){ $queryString .= $fieldName."=".self::$passwordHashEncryption."('".self::DbSanitizeData($fieldValue)."'), "; }
						  else{ $queryString .= $fieldName."='".self::DbSanitizeData($fieldValue)."', "; }
						  break;
						  default:
						  $queryString .= $fieldName."='".self::DbSanitizeData($fieldValue)."', ";
						  break;
					  }
				  }
				  else{
					  switch(gettype($fieldValue)){
						  case "integer":
						  case "double":
						  //Check if field is of type password
						  if($fieldName == "password"){ $queryString .= $fieldName."=".self::$passwordHashEncryption."('".self::DbSanitizeData($fieldValue)."')"; }
						  else{ $queryString .= $fieldName ."=". self::DbSanitizeData($fieldValue).""; }
						  break;
						  case "string":
						  case "boolean":
						  //Check if field is of type password
						  if($fieldName == "password"){ $queryString .= $fieldName."=".self::$passwordHashEncryption."('".self::DbSanitizeData($fieldValue)."')"; }
						  else{ $queryString .= $fieldName."='".self::DbSanitizeData($fieldValue)."'"; }
						  break;
						  default:
						  $queryString .= $fieldName."='".self::DbSanitizeData($fieldValue)."'";
						  break;
					  }
				  }
			  }
			  if(!empty($updateCondition)) $queryString .= " WHERE " . $updateCondition;
			  
			  array_push(self::$debugQueryString,$queryString);
			  self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
		  }
		  else{
			  throw new Exception('Method DbUpdate2 - Parameter <strong>$fields</strong> is not an array object - this parameter must be an array<br />',9020);
		  }
		}
		catch(Exception $e){
				echo 'Error code: <strong>' . $e->getCode() . "</strong><br />" .$e->getMessage() ."At Line: <strong>".$e->getLine() . "</strong><br />In " . $e->getFile();
		}
		self::$queryMicrotimeEnd = microtime(true);
		return self::DbGetAffectedRows();
	}
	
	/************************************************************************************************* 
	*  @method int DbDelete handles database delete queries
	*  @param string $queryString mysql delete query string
	**************************************************************************************************/
	public static function DbDelete($queryString){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		array_push(self::$debugQueryString,$queryString);
		self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
		return self::DbGetAffectedRows();
	}
	
	/************************************************************************************************* 
	*  @method int DbDeleteRange handles database delete queries with minimum start ID and maximum end ID
	*  @param string $table mysql table name to delete from
	*  @param int $minID from where to start to delete
	*  @param int $maxID where to stop to delete, if ommited or set to 0 all rows unitll the end will be deleted
	**************************************************************************************************/
	public static function DbDeleteRange($table, $minID, $maxID=0){
		try{
			if(is_int($minID) && is_int($maxID) && ($minID > -1 && ($maxID > $minID || $maxID == 0) ) ){
				self::DbConnect();
				self::$connection->set_charset('utf8');
				//If $MaxID stays 0 then $maxID will go to all rows untill the end
				if($maxID == 0){
					$lastRow = self::DbSelectLastRow($table);
					$maxID = $lastRow->id;
				}
				$queryString = "DELETE FROM " . $table . " WHERE id >= ".$minID." AND id <= ".$maxID;
				array_push(self::$debugQueryString,$queryString);
				self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
				return self::DbGetAffectedRows();
			}
			else{
				throw new Exception("<br />minID and maxID parameters must be integers, and also maxID must be bigger than minID.<br />");
			}
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		return 0;
	}
	
	/************************************************************************************************* 
	*  @method mixed DbGetResults returns last query results
	*  @param string $datatype type of return result, stdClass or array
	**************************************************************************************************/
	public static function DbGetResults($datatype='object'){
		//Return generic stdClass object
		if($datatype == "object"){
			$resultObject = new stdClass();
			if(is_array(self::$queryResult)){
				foreach(self::$queryResult as $key => $value){
					$key = strtolower($key);
					if(is_array($value)){
						$subObject = new stdClass();
						foreach($value as $key2 => $val){
							$key2 = strtolower($key2);
							$subObject->$key2 = $val;
						}
						$resultObject->$key = $subObject;
					}
					else{
						$resultObject->$key = $value;
					}
				}
				return $resultObject;
			}
		}
		//Return array object
		else if($datatype == "array"){
		  if(is_array(self::$queryResult)){
			  return self::$queryResult;
		  }
		}
		return false;
	}
	
	/************************************************************************************************* 
	*  @method boolean DbCreateTable creates new table in database
	*  @param string $table_name the name of the database table to be created 
	*  @param array $fields_array multidimensional array of arrays -  array($field_name, $field_type, $default_value) 
	**************************************************************************************************/
	public static function DbCreateTable($table_name, $fields_array){
		self::DbConnect();
		self::$connection->set_charset('utf8');
		self::$queryMicrotimeStart = microtime(true);
		
		$queryString = "CREATE TABLE IF NOT EXISTS " . $table_name . "(";
		//loop try each array and buildthe query string
		$field_counter = 0;
		foreach($fields_array as $field){
			$field_counter++;
			//default value
			if(isset($field['default_value'])){
				switch(gettype($field['default_value'])){
				  case "string":
				  $field['default_value'] = '"'.$field['default_value'].'"';
				  break;
				}
			}
			$queryString .= $field['field_name'] . " " . $field['field_type'] . 
			                (
							  isset($field['default_value']) ? " DEFAULT " . $field['default_value'] : ""
							) . 
							($field_counter < count( $fields_array) ? ", " : "");
		}
		$queryString .= ")";
		array_push(self::$debugQueryString,$queryString);
	    self::$lastQuery = self::$connection->query($queryString) or die('Mysql error: ' . self::$connection->error);
		return true;
	}
	
	/************************************************************************************************* 
	* @method int DbGetTableRows returns int table row count
	* @param string $table, name of database table  
	************************************************************************************************* */
	public static function DbGetTableRows($table){
		$query = "SELECT COUNT(id) AS numRows FROM " . $table;
		$res = self::$connection->query($query);
		$numberOfRowsInTable = 0;
		while($row = $res->fetch_assoc()){
			$numberOfRowsInTable = $row['numRows'];
		}
		mysqli_free_result($res);
		return $numberOfRowsInTable;
	}
	
	/************************************************************************************************* 
	* @method array DbGetNumRows returns last query row number 
	************************************************************************************************* */
	public static function DbGetNumRows(){
		$rows = self::$lastQuery->num_rows;
		
		return $rows;
	}
	
	/************************************************************************************************* 
	* @method array DbGetAffectedRows returns last query affected rows 
	**************************************************************************************************/
	public static function DbGetAffectedRows(){
		return self::$connection->affected_rows;
	}
	
	/************************************************************************************************* 
	*  @method array DbSanitizeData sanitize php input
	*  @var string $data raw php input
	**************************************************************************************************/
	public static function DbSanitizeData($data){
	    $data = trim(strip_tags($data,",."));
	    if (get_magic_quotes_gpc()){ $data = stripslashes($data); }
	    $data = self::$connection->real_escape_string($data);
	    return $data;
	}
	
	/************************************************************************************************* 
	* @method mixed DbGetQueryPerformance return info about query performance
	**************************************************************************************************/
	public static function DbGetQueryPerformance(){
		echo "<br />Query executed in " . number_format((float)self::$queryMicrotimeEnd - (float)self::$queryMicrotimeStart,4) . " seconds.<br />";
	}
	
	/************************************************************************************************* 
	* @method void DbClose close current databse connection
	**************************************************************************************************/
	public static function DbClose(){
		self::$connection->close();
	}
	
	/************************************************************************************************* 
	* @method string DbDebugQuery display information about last query
	**************************************************************************************************/
	public static function DbDebugQuery(){
		foreach(self::$debugQueryString as $key => $query){
			self::DbGetQueryPerformance();
			echo "Query string: <strong>" . $query . "</strong><br />";
		}
	}
	
}
?>