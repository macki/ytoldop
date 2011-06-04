<?php

	if($_SESSION['podloty_loggedin'] == 'ok')
	{
		$spr = $_SESSION['podloty_loggedin'];
		
		unset($_SESSION['podloty_loggedin']);
		unset($_SESSION['userNick']);
	
		session_destroy();
		
		if(!empty($spr))
		{
			ob_end_clean();
			header("Location: index.php");
		}
	}
	else
	{
		ob_end_clean();
		header("Location: index.php");
	}

?>