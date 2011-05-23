<?php
	
 	include_once 'Src/View/PhotoView.php';

	class DBoperationPhoto
	{
		//-- filters
		public static $filterArrayMode = array('all',
												'newest',
												'MosttopComment',
												'topRated',
										  		'worstRated',
										   		'top10',
										   		'Worste10',
										   		'topNonPodlot',
										   		'top10NonPodlot');	
		
		public static $filterArrayModeDescription = array('wszystkie',
												'swie¿utkie',
												'Najbardziej obgadane',
												'Liga Mistrzów',
										        'Nigdy w ¿yciu',
										        'TOP 10',
										        'Parszywa 12stka',
										        'Œlicznotki [NIE]podloty',
										        'TOP 10 [NIE]podloty');
		
		//-- database column
		public static  $url = 'url';
		private static $nameCategory = 'name';
		
		//-- database parameters 
		public  static   $DBname = "podloty";
		private static  $photoTable = 'photo';
		private static  $categoryTable = 'category';
		
		//-- connection results flags
		public static  $connection;
		public static  $ConnectionSuccesfull  = -1;
		public static  $Result;


		//-- Get Photos from DB
		public static  function GetPhotos($modeCategory,$modeFilter)
		{
			if(DBoperationBasic::Connect() == TRUE)
			{			
				DBoperationPhoto::SendQueryGetPhoto($modeCategory,$modeFilter);
	
				$ConnectionSuccesfull = 1;
				mysql_close();		
			}
			else 
			{
			   $ConnectionSuccesfull = -1;
			   //:TODO Jakis komunikat jak co
			}
		}		
			
		//-- Get result of filtering Data
		//-- Call Displayin function
		private static  function  SendQueryGetPhoto($modeCategory,$modeFilter)
		{
			mysql_select_db(DBoperationBasic::$DBname, DBoperationBasic::$connection);
			
			$result = DBoperationPhoto::FilterData($modeCategory,$modeFilter);
			
			ShowPhoto::DisplayPhoto($result);
					
		}
		
		//-- Filtering Data [Category, Filters]
		private function FilterData($modeCategory,$modeFilter)
		{
			switch ($modeFilter)
			{
					case 'all':
					{
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT * from photo ");	
						}
						else
						 {
				 			$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."'");
						 }

			 			return $result;
					}
					case 'newest':
					{
						
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." ORDER BY UploadedDate DESC ");	
						}
						else
						 {
				 			$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."' ORDER BY UploadedDate DESC");
						 }
						
						return $result;
					}
					case 'MosttopComment':
					{
					//-- adding comment should increase value in column "numberOfComments"
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." ORDER BY numberOfComments DESC ");
						}
						else 
						{
				 			$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."' ORDER BY numberOfComments DESC");
						}
						return $result;
					}
					case 'topRated':
					{
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." ORDER BY Rank DESC ");
						}
						else 
						{
							$result = mysql_query("SELECT *from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."'  ORDER BY Rank DESC");
						}
						
						return $result;
					}
					case 'worstRated':
					{
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." ORDER BY Rank ASC ");
						}
						else 
						{
							$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."'  ORDER BY Rank ASC");
						}
						
						return $result;
					}
					case 'top10': //liga mistrzow
					{
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." ORDER BY Rank DESC Limit 0,10 ");
						}
						else 
						{
							$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."'  ORDER BY Rank DESC Limit 0,10");
							
						}
						
						return $result;	
					}
					case 'Worste10': //parszywa 12
					{
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." ORDER BY Rank ASC Limit 0,12 ");
						}
						else 
						{
							$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."'  ORDER BY Rank ASC Limit 0,12");	
						}
						
						return $result;	
					}
					case 'topNonPodlot': 
					{
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." where NonPodlot = 1 ORDER BY Rank DESC ");
						}
						else 
						{
							$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."'  where NonPodlot = 1 ORDER BY Rank DESC");	
						}
						
						return $result;
					}
					case 'top10NonPodlot': //mistrzowie podworka
					{
						if($modeCategory == 'Wszystkie')
						{
							$result = mysql_query("SELECT *
							 FROM ".DBoperationBasic::$DBname."."
							.self::$photoTable." where NonPodlot = 1 ORDER BY Rank DESC Limit 0,10 ");
						}
						else 
						{
							$result = mysql_query("SELECT * from photo 
				 			join category cat on photo.CategoryID = cat.CategoryID
				 			where cat.Name = '".$modeCategory."' where NonPodlot = 1 ORDER BY Rank DESC Limit 0,10");	
						}
						
						return $result;
					}
				
				default:
					{
						//all
						$result = mysql_query("SELECT * from photo ");	
					}
			}
		 	
		 	return $result;
		}
		
	
	}
?>