<?php

	class DBoperationBasic
	{
		//-- database parameters 
		public static  $DBname = "podloty2";		
		public static  $connection;
		public static  $ConnectionSuccesfull  = -1;
		public static  $Result;
		
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
		
	}
?>