<html>
<head>
    <title>AddPeople</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
</head>

<body>

<?php
$infoIntegrity = true;
//echo "$infoIntegrity";
function requiredCheck($block){
	
	if(empty($block) && $_SERVER["REQUEST_METHOD"] == "POST"){
		$infoIntegrity = false; 	
		return false;	
	}
	return true;
}

?>

<h3>--Add New Movie--</h3>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	Title: 
		<input type="text" name="title" /> 
		<?php 
   			if(requiredCheck($_POST["title"]) == false)
   				echo "* Title Required!";
   			else $title = $_POST["title"];
   		?>	
	<br>

	Company: 
		<input type="text" name="company" /> 
		<?php 
   			if(requiredCheck($_POST["company"]) == false)
   				echo "* Company Required!";
   			else $company = $_POST["company"];
   		?>	
	<br>

	Year:
		<input type="text" name="year" /> 
		<?php 
	   		if(requiredCheck($_POST["year"]) == false)
	   			echo "* Year Required!";
	   		else $year = $_POST["year"];
	   	?>	
		
	<br>

	MPAA Rating:
		<select name="rating"> 
		<option value="G">G</option>
		<option value="NC-17">NC-17</option>
		<option value="PG">PG</option>
		<option value="PG-13">PG-13</option>
		<option value="R">R</option>
		<option value="surrendere">surrendere</option>
		</select>
		<?php 
	   		if(requiredCheck($_POST["rating"]) == false)
	   			echo "* Rating Required!";
	   		else $rating = $_POST["rating"];
	   	?>	
		
	<br>
	Genre:
		<input type="checkbox" name="genre[]" value="Action" /> Action
   		<input type="checkbox" name="genre[]" value="Adult" /> Adult
   		<input type="checkbox" name="genre[]" value="Adventure" /> Adventure
   		<input type="checkbox" name="genre[]" value="Animation" /> Animation
   		<input type="checkbox" name="genre[]" value="Comedy " /> Comedy 
   		<input type="checkbox" name="genre[]" value="Crime" /> Crime
   		<input type="checkbox" name="genre[]" value="Documentary" /> Documentary
   		<input type="checkbox" name="genre[]" value="Drama" /> Drama
   		<input type="checkbox" name="genre[]" value="Family" /> Family
   		<input type="checkbox" name="genre[]" value="Fantasy" /> Fantasy
   		<input type="checkbox" name="genre[]" value="Horror" /> Horror
   		<input type="checkbox" name="genre[]" value="Musical" /> Musical
   		<input type="checkbox" name="genre[]" value="Mystery" /> Mystery
   		<input type="checkbox" name="genre[]" value="Romance" /> Romance
   		<input type="checkbox" name="genre[]" value="Sci-Fi" /> Sci-Fi
		<input type="checkbox" name="genre[]" value="Short" /> Short
   		<input type="checkbox" name="genre[]" value="Thriller" /> Thriller
   		<input type="checkbox" name="genre[]" value="War" /> War
   		<input type="checkbox" name="genre[]" value="Western" /> Western

   		<?php 
   			if(requiredCheck($_POST["genre"]) == false)
   				echo " * Check at least one box!";
   			else
   				$genre = $_POST["genre"];
   			//print_r($genre);

   		?>
   		<br>

   		<input type="submit" value="Add!">	
</form>

<?php
	if($infoIntegrity = true){
		$dbConnection = mysql_connect("localhost", "cs143", "");
		if(!$dbConnection){
			die('Could not connect:'.mysql_error());
		}
		else{
			mysql_select_db("TEST", $dbConnection);
			$queryMaxId = "select id from MaxMovieID";
			$resMaxId = mysql_query($queryMaxId,$dbConnection);
			$tuple = mysql_fetch_row($resMaxId);
			$maxId = $tuple[0];
			//echo "$maxId";
			$newId = $maxId+1;

			$queryInsertMovie = "Insert into Movie values($newId, '$title', '$year', '$rating', '$company')";
			//echo $queryInsertMovie;
			mysql_query($queryInsertMovie, $dbConnection);
			
			
			for($i=0;$i<count($genre);$i++){
				$queryInsertGenre = "Insert into MovieGenre values($newId, '$genre[$i]')";
				//echo $queryInsertGenre;
				mysql_query($queryInsertGenre, $dbConnection);
				
			}

			$queryUpdate = "update MaxMovieID set id = $newId";
			mysql_query($queryUpdate,$dbConnection);
			//echo "Insert suceed!";
		}


	}

?>



</body>
</html>