<?php

class ShowPhoto
{

	public static function DisplayPhoto($resultQuery)
	{
		//TODO::
		// - wyswietlanie ilosci stron nad dole
		// - sportowanie po ilosci zdjec pokyzwanej
		// - wielkosc mianiaturek
		// - pokazywanie wszytko na jednej stronie
		
		while($row = mysql_fetch_array($resultQuery))
		{
			 echo "<div id='center'>";
				//echo"<a href= index.php?photoID=2
				//	 &photoUrl=2> asdsad </A>";	
				echo"<a href= index.php?photoId=".$row['PhotoID'].
					"&photoUrl=".$row['URL'].">
					<img src =".$row['URL'].">
					</A>";
			echo "</div>";
		}
	}
}

?>