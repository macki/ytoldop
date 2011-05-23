<?php
	
	include_once 'Src/View/CommentView.php';

	class DBoperationComment
	{
		//-- database column
		private static $textComment = 'commentText';
			
		//--
		private static  $commentTable = 'comment';
	
	
		//-- Get Comment from DB
		public static  function GetComment()		
		{
			if(DBoperationBasic::Connect() == TRUE)
			{	
				DBoperationComment::SendQueryGetComment();
				
				mysql_close();
			}
			else 
			{
				echo "Problem with Database Check later";
			}
		}
		
		//-- getting filtered then calling CommentView
		private static function SendQueryGetComment()
		{
			$resultQuery = DBoperationComment::FilterData();
			
			new CommentView($resultQuery);

		}
		
		//-- Getting Data from Database
		private static function FilterData()
		{
			$result = mysql_query("SELECT *  
								   from ". DBoperationComment::$commentTable."
								   where  PhotoID = ".$_GET['photoId']);
			return $result;
		}
		
		//-- Add comment to Database
		public static function AddCommentToDatabase($comment,$photoId)
		{
			//TODO:: odpowiednie filtorwanie "$comment"
			// 		 przekaza odpowiednie userID
			
			if(DBoperationBasic::Connect() == TRUE)
			{	
				mysql_select_db("podloty", DBoperationBasic::$connection);
				
				$userId = 2; //::TODO 
						
				mysql_query("INSERT INTO comment (
							PhotoID,
							commentText,
							OwnerID,
							AddedDate,
							Rank) VALUES (
							 '".$photoId."',
							 '".$comment."',
							 '".$userId."',
							 NOW(),
							 '0')");
				
				mysql_close();
				return true;
			}
			else 
			{
				echo "Problem with Database Check later";
			}
			
			
			return false;
		}
	}

?>