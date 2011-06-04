
<?php

class ShowPhoto
{
	//TODO ::
	//	-> pobrac rozdzielczosc usera i dostowac do niej wielkosc zdjec
	private static $maxPhotoWidth = 500;
	
	//--
	private static $photoWidth;
	private static $photoHeight;
	
	public static function DisplayPhoto($resultQuery)
	{
		//TODO::
		// - wyswietlanie ilosci stron nad dole
		// - sportowanie po ilosci zdjec pokyzwanej
		// - wielkosc mianiaturek
		// - pokazywanie wszytko na jednej stronie

		while($row = mysql_fetch_array($resultQuery))
		{
			ShowPhoto::CalculateSize($row['URL']);
			
			 echo "<div id='center'>";
				echo"<a href= index.php?photoId=".$row['PhotoID'].
					"&photoUrl=".$row['URL'].">
					<img src =".$row['URL'].
					" width = '".ShowPhoto::$photoWidth."'
					 height='".ShowPhoto::$photoHeight."'
					>
					</A>";
			echo "</div>";
		}
	}
	
	private static function CalculateSize($url)
	{
		list($width, $height, $type, $attr) = getimagesize($url);
		
		if($width >ShowPhoto::$maxPhotoWidth)
		{
			$scaleFactor = $width / 400;
			
			ShowPhoto::$photoHeight = $height / $scaleFactor;		
			ShowPhoto::$photoWidth = 400;		
		}
		else 
		{
			ShowPhoto::$photoWidth = $width;	
			ShowPhoto::$photoHeight = $height;
		}
		

	}
	
}

?>