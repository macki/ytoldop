<?php

	class DBoperationBasic
	{
		//-- database parameters 
		public static  $DBname = "podloty2";		
		public static  $connection;
		public static  $ConnectionSuccesfull  = -1;
		public static  $Result;
	
		public static $host = "localhost";
		public static $userName = "root";
		public static $password = "";
		public static $userNameErr = "ErrorLogger";
		public static $passwordErr = "errlog";
		
		//--Return Connection handler
		public static function Connect()
		{	
			DBoperationBasic::$connection = mysql_connect("localhost","root","");
			
			if (!DBoperationBasic::$connection)
			{
			  die('Could not connect: ' . mysql_error());
			  header("Location: ErrorPage.php");
			  return false;
		 	}
			
		 	return true;
		}
		
		//--Return Connection handler
		public static function Connect_Modf()
		{	
			self::$connection = mysql_connect(self::$host, self::$userName, self::$password);
			
			if(!self::$connection)
				throw new DBEx("Could not connect: " . mysql_error());
				
			if(!mysql_select_db(self::$DBname, self::$connection))
				throw new DBEx("Could not select db: " . mysql_error());
			
			if(!mysql_query('SET NAMES utf8'))
				throw new DBEx("Could not set names utf8: " . mysql_error());
			
		 	return true;
		}
		
	//-- Method for inserts, updates, deletes
		//-- Return: true/false - success/unsuccess
		public static function ExecuteNonQuery($query)
		{
			if(self::Connect_Modf() == true)
			{		
				$result = mysql_query($query);
				
				if(!$result)
				{
					self::LogError(mysql_escape_string(mysql_error()), "MYSQL_NonQuery");
					mysql_close(self::$connection);
					return false;
				}

				mysql_close(self::$connection);
				return true;
			}
		}
		
		public static function ExecuteQuery($query)
		{
			if(self::Connect_Modf() == true)
			{
				$result = mysql_query($query);
				
				if(!$result)
				{
					self::LogError(mysql_escape_string(mysql_error()), "MYSQL_Query");
					mysql_close(self::$connection);
					return false;
				}
					
				mysql_close(self::$connection);
				return $result;
			}
		}
		
		public static function ExecuteScalar($query)
		{
			if(self::Connect_Modf() == true)
			{
				$result = mysql_query($query);
				
				
				if(!$result)
				{
					self::LogError(mysql_escape_string(mysql_error()), "MYSQL_Scalar");
					mysql_close(self::$connection);
					return false;
				}
				
				mysql_close(self::$connection);
					
				$row = mysql_fetch_row($result);
				return $row[0];
			}
		}
		
		public static function LogError($err, $type = null)
		{
			date_default_timezone_set('Europe/Warsaw');
			
			if($errConnection = mysql_connect(self::$host, self::$userNameErr, self::$passwordErr))
			{
				mysql_select_db(self::$DBname, $errConnection);
				mysql_query('SET NAMES utf8');
				mysql_query("insert into ErrorLog(ErrorTime, ErrorMsg, ErrorType) values('".date('Y-m-d H:i:s')."','".$err."','".$type."')");
				mysql_close($errConnection);
			}
		}
	
		
	}
?>