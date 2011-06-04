<?php

require_once("Src/DBOp/DBoperationBasic.php");

class ErrorLogger
{
	static function Log($errno, $errstr, $errfile, $errline, $errcontext)
	{
		$message = "ERRNO: ".$errno."; ERRMSG: ".$errstr."; FILE: ".$errfile."; LINE: ".$errline."; CONTEXT: ".$errcontext;
		
		DBoperationBasic::LogError(mysql_escape_string($message), "PHP");
	}
}

?>