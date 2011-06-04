<?php
	
	function  validemail($email) {
	
		if (!preg_match("/^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@([a-zA-Z0-9_-]+)(\.[a-zA-Z0-9_-]+)*(\.[a-zA-Z]{2,4})$/i", $email))
		{
		  return false;
		}
		
	 return true;
	}
	
	function validdata(&$d)
	{
		
		$d = str_replace("\'","`",$d);
		
		if(preg_match("/[<>\$\"\\'(\);\%\?\{\}\#\=\&]/",$d))
		{
			return false;
		}
		
		return true;
	}
	
	function validkonto($k)
	{
		if(!preg_match("/[0-9]{26}/",$k))
		{
			return false;
		}
		
		return true;
	}
	
	function validkwota($k)
	{
		if(!preg_match("/^[0-9]+(\.|,){0,1}([0-9]*)$/",$k))
		{
			return false;
		}
		
		return true;
	}

?>