<?php

 class HandyFunction
 {
 	
 	//-- NOT USED anymore
	public static function curPageURL()
	 {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 
		 if ($_SERVER["SERVER_PORT"] != "80")
		 {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 }
		 else
		 {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 
		 return $pageURL;
	}
	//-- NOT USED anymore
	public static function GetFilterMode($url)
	{

		$tab =  explode('?', $url, 2);
			
		if($tab[1] == '')
			return 'Wszystkie';
		
		$_SESSION['cos'] = $tab[1];	
			
		return $tab[1]; 
	}
	//-- NOT USED anymore
	public static function ResolveCategoryMode()
	{
		$mode = HandyFunction::curPageURL();
		$mode = HandyFunction::GetFilterMode($mode);
		
		return $mode;
	}
	
	
 }

?>