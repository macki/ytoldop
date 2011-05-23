<?php ob_start(); ?>
<?php
	session_start();

   	include_once 'Src/DBop/DBoperationPhoto.php';
	include_once 'Src/DBop/DBoperationBasic.php';
	include_once 'Src/DBop/DBoperationComment.php';
	
	include_once 'Src/View/FilterMenuView.php';
	include_once 'Src/util/HandyFunction.php';
	include_once 'Src/View/MainMenuView.php';
	
	include_once 'Src/Model/comment/InputCommentModel.php';
	
	include_once 'Src/HTMLview/IdoleHTMLview.php';
	include_once 'Src/HTMLview/KonkursyHTMLview.php';
	include_once 'Src/HTMLview/ZasadyHTMLview.php';
	include_once 'Src/HTMLview/DodajHTMLview.php';
	include_once 'Src/HTMLview/RadarHTMLview.php';
	include_once 'Src/HTMLview/LigaHTMLview.php';
	include_once 'Src/HTMLview/LaseryHTMLview.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Podloty</title>
<link rel="stylesheet" type="text/css" href="style/style.css" />
	
	<body>
	
		<!-- Needed for Facebook API initialization -->
			<div id="fb-root"></div>
			<script src="http://connect.facebook.net/en_US/all.js"></script>
			<script>
			  FB.init({
			    appId  : '169289066463546',
			    status : true, // check login status
			    cookie : true, // enable cookies to allow the server to access the session
			    xfbml  : true  // parse XFBML
			  });
			</script>

		<!-- Page Basic elements -->	
		<!-- Logo/Top -->
			<div id="top">
				<img src='Source/top.png' width=100% align='left'>
			</div>
		
		<!-- Main Menu  -->
			<div id ="mainMenu">
				<?php 
					$mainMenu = new MainMenuView();
				?>	
			</div>
			
		<!-- Category filters (cateogry/filters) -->
			<div id = "menuCategory">
				<?php 
					$menuView = new CreateFilterMenu();
				 ?>
			</div>
		

		<fb:like width="200" show_faces="no" href="dasdas"></fb:like>
		

		
	</body>
			
</head>
</html>

<?php 

	
	//-- navigate to current page
	CheckCurrentPage();


	//TODO:: fest chujowe to jest trzeba to jakos inaczej
	//-- ction NON-PHOTO CLICK
	if($_GET['photoUrl'] == '')
	{
		DBoperationPhoto::GetPhotos($_GET['category'],$_GET['filter']);
		
	}
	else 
	{	
		DBoperationComment::GetComment();
		
	}	
		
	
	//DBoperationPhoto::GetPhotos('all');
	//echo "<top>s</top>";
	//echo "xFile Project";

	ob_end_flush();
	
	
	function CheckCurrentPage()
	{
		switch($_GET['page'])
		{
			case 'idole':
			{
				$idole = new idoleHTMLview();
			}
			break;
			case 'konkursy':
			{
				$konkursy= new KonkursyHTMLview();
			}
			break;
			case 'zasady':
			{
				$zasady = new ZasadyHTMLview();
			}
			break;
			case 'dodaj':
			{
				$dodaj= new DodajHTMLview();
			}
			break;
			case 'radar':
			{
				$radar = new RadarHTMLview();
			}
			break;
			case 'liga':
			{
				$liga = new LigaHTMLview();
			}
			case 'lasery':
			{
				$Lasery = new LaseryHTMLview();
			}
			break;
		}
		
	}
	
?>
