<?php

class MainMenuView
{
	//-- Menu Item used as link
		private $MenuItemLink = array(			'idole',
												'smiechy',
												'zasady',
												'konkursy',
										  		'dodaj',
										   		'radar',
										   		'liga',
										   		'lasery'
												);	
	//-- Description show on the main page	
		private  $MenuItemDescription = array(  'Lo¿a Szyderców',
												'Przeœmiewcze',
												'Zasady',
												'Konkursy',
										        'Dodaj Fociê',
										        'Podloto - Radar',
												'Liga Podlotów',
												'Twoje Lasery'
												);
													
	
		function __construct()
		{											
			$this->DisplayMainMenuItem();			
		}
		
		private function  DisplayMainMenuItem()
		{
			$iterator = 0;
			
			foreach ( $this->MenuItemDescription as &$value )
			{
				echo"<a href= index.php?page=".$this->MenuItemLink[$iterator].
				">".$value."</A>";
				
				echo " <> ";
				
				
				$iterator++;
			}
		}
	
}	
	
?>