<?php 
$urlRefresh = "index.php";
header("Refresh: 5; URL=\"" . $urlRefresh . "\""); // redirect in 5 seconds
?>


<?php

   	include_once 'Src/DBop/DBoperationPhoto.php';
	include_once 'Src/DBop/DBoperationBasic.php';
	include_once 'Src/DBop/DBoperationComment.php';
	include_once 'Src/View/FilterMenuView.php';
	include_once 'Src/util/HandyFunction.php';
	include_once 'Src/Model/comment/InputCommentModel.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Podloty</title>
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	
	<body>
		
		<div id="top">
			<img src='Source/top.png' width=100% align='left'>
		</div>
	
	
		<div id = "menuCategory">
			<?php 
				$menuView = new CreateFilterMenu();
			 ?>
		</div>
	
		
	</body>
			
</head>
</html>

<?php 

	//TODO:: NOT ALLOWED REFRESH all the time
	
		 if(DBoperationComment::AddCommentToDatabase($_POST['commentText'], $_GET['photoId']))
		 {
		 	echo "Comment was added to photo" ;
		 }
		 else 
		 {
		 	echo "Try Later" ;
		 }		
	
	
	 echo "<br>";
	 echo "<a href='index.php'>Go back</a>";
	 echo "<br>";
	 echo"<a href= index.php?photoId=".$_GET['photoId'].
					"&photoUrl=".$_GET['photoUrl'].">Go to last podlot image</a>";

	
?>

