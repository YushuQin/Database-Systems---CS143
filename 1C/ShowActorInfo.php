<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ActorInfo</title>

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

<body data-spy="scroll" data-target=".navbar-collapse">
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
            <li><a href="./index.html">Home</a></li>
            <li ><a href="./ShowMovieInfo.php?mid=4651">Movies</a></li>
            <li class="active"><a href="./ShowActorInfo.php?aid=2047170">Actors</a></li>
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
         <!-- </div> -->
        <!-- </div> -->


      <!-- </div> -->


<?php

if(isset($_GET['aid']) && $_GET['aid']){
    //echo $_GET['aid'];
    $dbConnection = mysql_connect("localhost", "cs143", "");
    if(!$dbConnection){
        die('Could not connect:'.mysql_error());
    }

    else{
        mysql_select_db("TEST", $dbConnection);
        $aid = $_GET['aid'];
        $queryActor = "select * from Actor where id = $aid";
        //echo $queryActor;
    	$resultActor = mysql_query($queryActor, $dbConnection);
        if (!$resultActor){
            die('Invalid query: '.mysql_error());
        }
        else{
            $tuple = mysql_fetch_row($resultActor);
            //print_r($tuple);
            
            
            // echo "Name: $tuple[2] $tuple[1] <br>";
            
            ?>

            <div class="container-fluid">
            <div class="row">
                <h1 class="marginTop"><?php echo "$tuple[2] $tuple[1]"?></h1>
                
            </div>
          </div>

          <?php
            echo "Sex: $tuple[3] <br>";
            echo "Date of Birth: $tuple[4] <br>";
        
            if($tuple[5]){
                echo "Date of Death: $tuple[5]<br>"; 
                 }
            else{
                echo "Date of Death: Still Alive<br>";
             
            }
            echo "<h3>--Acted in--</h3>";
            $queryMovie = "select role, title, id from Movie, (select mid, role from MovieActor where MovieActor.aid=$aid) MA where id= MA.mid;";
            $resultMovie = mysql_query($queryMovie, $dbConnection);
            $rowCount = mysql_num_rows($resultMovie);
            //echo $rowCount;
            if($rowCount == 0){
                    echo "No record ";
            }
            else{
                for ($row = 0; $row < $rowCount; $row++){
                    $tuple = mysql_fetch_row($resultMovie);
                    //print_r($tuple); echo "<br>";
                    echo "act $tuple[0] in";
                    echo "<a href='./ShowMovieInfo.php?mid=$tuple[2]'> $tuple[1] </a><br/>";
                } 
            }

       	}
    }
    mysql_close($db_connection);
}

?>
</div>
</div>




</body>
</html>
