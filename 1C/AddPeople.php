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

    <h3>--Add Actot / Director--</h3>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    Identity:
    	<input type="checkbox" name="identity[]" value="actor" /> Actor
   		<input type="checkbox" name="identity[]" value="director" /> Director 
   		<?php 
   			if(requiredCheck($_POST["identity"]) == false)
   				echo " * Check at least one box!";
   		?>
   	
    <hr>
    First Name:
    	<input type="text" name="firstname" />
    	<?php 
   			if(requiredCheck($_POST["firstname"]) == false)
   				echo "* First Name Required!";
   			else
   				$firstname = $_POST["firstname"];
   		?>	
   	<br>
	Last name: 
		<input type="text" name="lastname" /> 
		<?php 
   			if(requiredCheck($_POST["lastname"]) == false)
   				echo "* Last Name Required!";
   			else $lastname = $_POST["lastname"]
   		?>	
	<br>
	Sex:
		<input type="radio" name="sex" value="Male" /> Male 
		<input type="radio" name="sex" value="Female" /> Female
		<?php 
   			if(requiredCheck($_POST["sex"]) == false)
   				echo "* Check on box!"; 
   			else $sex = $_POST["sex"];
   		?>	
	<br>
	Date of Birth:
		<input type="text" name="dob" /> 
		<?php 
   			if(requiredCheck($_POST["dob"]) == false)
   				echo "* Select Date of Birth!";
   			else $dob =  $_POST["dob"];
   			//echo $dob;
   		?>	
	<br>
    Date of Die: 
    	<input type="text" name="dod" /> (Do not select if alive now)
    	<?php
    	if(requiredCheck($_POST["dod"]) == false)
   			$dod = "NULL";
    	else $dod =  $_POST["dod"];
    	?>
    <br>

    <input type="submit" value="add!" />

    
    </form>
  

<?php
	if($infoIntegrity == true){
		//echo "$infoIntegrity";
		$dbConnection = mysql_connect("localhost", "cs143", "");
		if(!$dbConnection){
			die('Could not connect:'.mysql_error());
		}
		else{
			mysql_select_db("TEST", $dbConnection);
			$queryMaxId = "select id from MaxPersonID";
			$resMaxId = mysql_query($queryMaxId,$dbConnection);
			$tuple = mysql_fetch_row($resMaxId);
			$maxId = $tuple[0];
			//echo "$maxId";
			$newId = $maxId+1;
			if(in_array("actor", $_POST["identity"])){
				$queryInsert = "insert into Actor values($newId, '$lastname', '$firstname', '$sex', '$dob', '$dod')";
				//echo "$queryInsert";
				mysql_query($queryInsert, $dbConnection);			
			}
			if(in_array("director", $_POST["identity"])){
				$queryInsert = "insert into Director values($newId, '$lastname', '$firstname','$dob', '$dod')";
				//echo "$queryInsert";
				mysql_query($queryInsert, $dbConnection);			
			}
			$queryUpdate = "update MaxPersonID set id = $newId";
			mysql_query($queryUpdate,$dbConnection);
			//echo "Insert suceed!";
			
		}
		mysql_close($db_connection);
	}


?>    

</body>
</html>