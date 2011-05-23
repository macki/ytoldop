<?php
	class OutputCommentModel
	{
	
		private $personIcon = "<img src='Source/person.gif' alt='Angry face' />"; 
		
		function __construct($commentText)
		{ 
			echo "<div id='outputBox'>";
				echo $commentText;
			echo "</div>";
			echo $this->personIcon;
		}
		
		
	}	
?>

