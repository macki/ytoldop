<?php 
	include_once 'Src/DBop/DBoperationCategory.php';
	include_once 'Src/DBop/DBoperationBasic.php';
?>

<?php

	class CreateFilterMenu
	{
		private $category = array();
		
		function __construct()
		{
			DBoperationCategory::GetCategory();	
			$this->category = DBoperationCategory::$ArrayCategory;
					
			echo "<div id='menuCategory'>";	
				$this->DisplayMenuCategory();
				echo "<br></br>";
				$this->DisplayMenuFilter();
			echo "</div>";
		}
		
		private function  DisplayMenuCategory()
		{
			foreach ($this->category as &$value )
			{
				echo"<a href= index.php?category=".$value."&filter=".$_GET['filter'].">".$value."</A>";
				echo " || ";
			}
		}
		
		private function DisplayMenuFilter()
		{
			$counter = 0;
			
			foreach(DBoperationPhoto::$filterArrayModeDescription as &$value )
			{
				echo"<a href= index.php?category=".$_GET['category'].
					"&filter=".DBoperationPhoto::$filterArrayMode[$counter].">".$value."</A>";
				echo " || ";
					
				$counter++;
			}	
		}
		
	}
?>