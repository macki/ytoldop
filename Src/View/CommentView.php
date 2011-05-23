
<?php
	
	include_once 'Src/Model/comment/OutputCommentModel.php';
	include_once 'Src/Model/comment/InputCommentModel.php';

	class CommentView
	{
		private $comment = array();
		
		function __construct($com)
		{
			$this->comment = $com;
		
			echo "<div id='center'>";
				$this->DisplayPhoto();
				$this->DisplayCommentsFromDatabase();
				$this->DisplayComementsInput();
			echo "</div>";
		}
			
		private function DisplayPhoto()
		{
				echo" <img src =".$_GET['photoUrl']. " />";
		}
		
		private function DisplayCommentsFromDatabase()
		{
				while($row = mysql_fetch_array($this->comment))
				{
					$newComment = new OutputCommentModel($row['CommentText']);
				}
				
		}
		
		private function DisplayComementsInput()
		{
			$nowy = new InputCommentModel();
		}
	}

?>