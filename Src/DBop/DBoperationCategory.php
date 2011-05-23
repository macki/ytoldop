<?php

	class DBoperationCategory
	{
		public static $ArrayCategory = array();
		
		//-- database column
		private static $nameCategory = 'name';
		
		//--
		private static  $categoryTable = 'category';
		
		//-- Get Category from DB
		public static  function GetCategory()		
		{
			if(DBoperationBasic::Connect() == TRUE)
				{	
					if(DBoperationCategory::SendQueryGetCategory() == true){
						$ConnectionSuccesfull = 1;
						mysql_close();
					}else 
						$ConnectionSuccesfull = 0;
				}
				else 
						$ConnectionSuccesfull = -1;
		}

		//-- Send query to database to getting data 	
		private static function SendQueryGetCategory()
		{
			mysql_select_db(DBoperationBasic::$DBname, DBoperationBasic::$connection);

			$result = mysql_query("SELECT name FROM category");
			
				while($row = mysql_fetch_array($result))
				 {
					Array_push(DBoperationCategory::$ArrayCategory, $row[self::$nameCategory]);
				 }		
				 			  
			return false;
		}
		

	}
?>