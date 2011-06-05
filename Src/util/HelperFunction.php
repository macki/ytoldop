<?php

class HelperFcuntion
{
	public static  function  CheckFileExist($url)
	{
			if (file_exists($url)) {
			    echo "The file $filename exists";
			} else {
			    echo "The file $filename does not exist";
			}			
	}
	
	public static  function  CurrentLocation()
	{
			$current_url = $_SERVER['PHP_SELF'];
		
			echo "Current Localization ".$current_url;	
	}

}
?>