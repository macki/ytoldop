<?php

class InputCommentModel
{
	//-- defined visual element
	private $boxTextStyle = "width:300px;
							height:90px;
							background-color:#F0F18F;
							-moz-border-radius: 15px;
							border-radius: 15px;";
	
	private $submitButtonStyle = "background-color:#53760D;
								  color:#D0F18F;";

	private $personIcon = "<img src='Source/person.gif' alt='Angry face' />"; 
	
	

	function __construct()
	{
		 $this->ShowCommentForm();
		
	}
	
	private function  ShowCommentForm()
	{
		echo
		"
		<form action='indexAddComment.php?photoUrl=".$_GET['photoUrl']."
			&photoId=".$_GET['photoId']."	' method='post'>
		<br />
		  <textarea name='commentText'
		   	style='".$this->boxTextStyle."'>
		  </textarea>"."".$this->personIcon."
		  <br></br><input type='submit' value='Add Comment' style = '".$this->submitButtonStyle."' />
		</form>		
		";
	}
	
	
	
}

?>


