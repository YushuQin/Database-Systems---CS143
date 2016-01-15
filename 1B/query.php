<html>
<head>
	<meta charset="utf-8">
	<title>Movie / Actor Database Query</title>
</head>
<body>

<p>
Please type a MySQL SELECT Query into the box below:<p>
Example: <tt>SELECT * FROM Actor WHERE id=10;</tt><br />
</p>

<p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <textarea name="query" cols="60" rows="8"></textarea><br />
    <input type="submit" value="Submit" />
</form>
</p>


<p><small>Note: tables and fields are case sensitive. Run "show tables" to see the list of available tables.</small></p>

<?php

if(isset($_GET['query']) && $_GET['query']){
	$dbConnection = mysql_connect("localhost", "cs143", "");
	if(!$dbConnection){
		die('Could not connect:'.mysql_error());
	}
	else{
		mysql_select_db("TEST", $dbConnection);
		$query = $_GET['query'];
		$result = mysql_query($query, $dbConnection);
		if (!$result){
			die('Invalid query: '.mysql_error());
		}
		else
		{
			echo "<h2>Results from MySQL:</h2>";
			echo '<table border=1 cellspacing=1 cellpadding=2>';
			
			$tuple = mysql_fetch_array($result);
			//print_r($tuple);
			$keys = array_keys($tuple);
			//print_r($keys);
			//echo count($keys);
			echo '<tr align=center>';
			for($attribute = 1;$attribute < count($keys);$attribute += 2){
				echo '<td><b>'.$keys[$attribute].'</b></td>';
			}
			echo '</tr>';
			
			echo '<tr align=center>';
			for($value = 0;$value < count($tuple)/2;$value++){
				if ($tuple[$value]){
						echo '<td>'.$tuple[$value].'</td>';
					}
					else{
						echo '<td>'. 'N/A'.'</td>';
					}	
			}
			echo '</tr>';

			$rowCount = mysql_num_rows($result);
			//echo $rowCount;
			for($row = 1; $row < $rowCount; $row++){
			 	echo '<tr align=center>';
			 	$tuple = mysql_fetch_row($result);
			 	for($column = 0;$column < count($tuple);$column++){
					
					if ($tuple[$column]){
						echo '<td>'.$tuple[$column].'</td>';
					}
					else{
						echo '<td>'. 'N/A'.'</td>';
					}	
				}
				
				echo '</tr>';
			 }
			 echo '</table>';
		}
		mysql_free_result($result);
    }
	mysql_close($db_connection);
}
?>

</body>
</html> 
