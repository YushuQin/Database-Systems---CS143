<html>
<head>
    <title>AddPeople</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
    	#topRow{
      margin-top: 100px;
      text-align: center;
     }
     .navbar-band{
        font-size:1.8em;
     }


     .marginTop{
        margin-top: 30px;
     }

     .center{
        text-align: center;
     }
     .title{
        margin-top: 100px;
        font-size: 300%;
     }
    </style>
</head>

<body>
	 <div class="navbar navbar-default navbar-fixed-top">
      <!-- <div class="container wrapper"> -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" >
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Movie Times</a>
        </div>

        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="./ShowMovieInfo.php">Movies</a></li>
            <li><a href="./ShowActorInfo.php">Actors</a></li>
            <li><a href="./AddMovie.php">Add Movie</a></li>
            <li><a href="./AddPeople.php">Add People</a></li>
            
          </ul>

        </div>
        

      </div>

      <div class="row">
    
     <div class="col-md-6 col-md-offset-3" id="topRow">
      
     <h1 class="marginTop">Find Movies and Actors</h1>
      
     <p class="lead"></p>
      

      
     <p class="bold marginTop">Type in the name of moives and actors</p>
      
     <form class="marginTop" action="Search.php" method="GET">
      
       <div class="input-group">
         <span class="glyphicon glyphicon-search input-group-addon"></span>
          
         <input type="text" name="search" class="form-control" placeholder="actors, movies" />
          
       </div>
          
         <input type="submit" class="btn btn-success btn-lg marginTop" value="Go!" />
         </form>
       
       


<?php
	

if(isset($_GET['search']) && $_GET['search']){
	$dbConnection = mysql_connect("localhost", "cs143", "");
	if(!$dbConnection){
		die('Could not connect:'.mysql_error());
	}
	else{
		mysql_select_db("TEST", $dbConnection);
		echo "<br>You are searching[".$_GET['search']."]...<br><br>";
		$keyword = explode(" ",preg_replace("/\s(?=\s)/", "\\1", $_GET["search"]));
		//print_r($keyword);
		mysql_query('create view FullnameActor as select id,concat_ws(" ",first,last)as fullname,dob from Actor;',$dbConnection);
		//Search in table Actor
		$query="select * from FullnameActor where fullname like '%$keyword[0]%'";
		for($i=0; $i<count($keyword);$i++){
			$query = $query."and fullname like '%$keyword[$i]%'";
		}
		//echo $query;
		$resultActor = mysql_query($query,$dbConnection);
		echo "<h3>Actors:</h3>";
		$rowcount = mysql_num_rows($resultActor);
		if($rowcount == 0){
			echo "No record!";
		}
		else{
			for($row=0;$row<$rowcount;$row++){
				$tupleActor = mysql_fetch_row($resultActor);
				//print_r($tupleActor);
				echo "<a href='./ShowActorInfo.php?aid=$tupleActor[0]'>$tupleActor[1] ($tupleActor[2])</a><br>";
			}
		}
		
		//Search in table Movie
		$query="select * from Movie where title like '%$keyword[0]%'";
		for($i=0; $i<count($keyword);$i++){
			$query = $query."and title like '%$keyword[$i]%'";
		}
		//echo $query;
		$resultMovie = mysql_query($query,$dbConnection);
		echo "<h3>Movies:</h3>";
		$rowcount = mysql_num_rows($resultMovie);
		if($rowcount == 0){
			echo "No record!";
		}
		else{
			for($row=0;$row<$rowcount;$row++){
				$tupleMovie = mysql_fetch_row($resultMovie);
				//print_r($tupleMovie);
				echo "<a href='./ShowMovieInfo.php?mid=$tupleMovie[0]'>$tupleMovie[1] ($tupleActor[2])</a><br>";
			}
		}




	}
	mysql_close($db_connection);
}


?>
</div>

</body>
</html>