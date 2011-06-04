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
		
		//-- Category
		private function  DisplayMenuCategory()
		{
			foreach ($this->category as &$value )
			{
				if(isset($_GET['filter']))
				{
					echo"<a href= index.php?category=".$value."&filter=".$_GET['filter'].">".$value."</A>";
				}
				else 
				{
					echo"<a href= index.php?category=".$value."&filter=all>".$value."</A>";
				}
				echo " || ";
			}
		}
		
		//Display Filters 
		private function DisplayMenuFilter()
		{
			$counter = 0;
			
			foreach(DBoperationPhoto::$filterArrayModeDescription as &$value )
			{
				if(isset($_GET['category']))
				{
					echo"<a href= index.php?category=".$_GET['category'].
						"&filter=".DBoperationPhoto::$filterArrayMode[$counter].">".$value."</A>";
				}
				else
				{
					echo"<a href= index.php?category=''".
						"&filter=".DBoperationPhoto::$filterArrayMode[$counter].">".$value."</A>";
				}

				echo " || ";
					
				$counter++;
			}	
		}
		
	}
?>