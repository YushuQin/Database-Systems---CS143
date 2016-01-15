<html>
<head>
    <title>MovieInfo</title>

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
            <li><a href="./index.html">Home</a></li>
            <li class="active"><a href="./ShowMovieInfo.php">Movies</a></li>
            <li><a href="./ShowActorInfo.php?aid=52794">Actors</a></li>
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

if(isset($_GET['mid']) && $_GET['mid']){
    //echo $_GET['mid'];
    $dbConnection = mysql_connect("localhost", "cs143", "");
    if(!$dbConnection){
        die('Could not connect:'.mysql_error());
    }

    else{
        mysql_select_db("TEST", $dbConnection);
        $mid = $_GET['mid'];
        
        $queryMovie = "select * from Movie where id = $mid";
        //echo "$queryMovie<br>";
        $resultMovie = mysql_query($queryMovie,$dbConnection);

        $queryDirector = "select first, last, dob, dod from Director,(select did from MovieDirector where MovieDirector.mid=$mid) MD where MD.did=id";
        $resultDirector = mysql_query($queryDirector,$dbConnection);

        $queryGenre = "select genre from MovieGenre where mid = $mid";
        $resultGenre = mysql_query($queryGenre,$dbConnection);
        
        
        if(!$resultMovie && !$resultDirector && !$resultGenre){
            die('Invalid query: '.mysql_error());
        }
        else{
            $tupleMovie = mysql_fetch_row($resultMovie);
            //print_r($tupleMovie);
            $tupleDirector = mysql_fetch_row($resultDirector);
            //print_r($tupleDirector);
            $tupleGenre = mysql_fetch_row($resultGenre);
            ?>
            <div class="container-fluid">
            <div class="row">
                <h1 class="marginTop"><?php echo "$tupleMovie[1]"?></h1>
            </div></div>
            <?php

            // echo "Title: $tupleMovie[1] ($tupleMovie[2])<br>";
            echo "Year: $tupleMovie[2]<br>";
            echo "Director: ";
            if(mysql_num_rows($resultDirector)==0)
                echo "No record<br>";
            else{
                echo "$tupleDirector[0] $tupleDirector[1] ($tupleDirector[2] ~ $tupleDirector[3] )<br>";
            }
            echo "Genre: ";
            if(mysql_num_rows($resultGenre)==0)
                echo "No record<br>";
            else{
                echo "$tupleGenre[0]<br>";
            }
            echo "Producer: $tupleMovie[4]<br>";
            echo "MPAA Rating: $tupleMovie[3]<br>";
       }
        echo "<h3>-- Actors in this movie -- </h3>";
       $queryActor = "select first, last, role, id from Actor, (select aid, role from MovieActor where mid=$mid) MA where MA.aid=id";
       $resultActor = mysql_query($queryActor,$dbConnection);
       if(!$resultActor){
            die('Invalid query: '.mysql_error());
        }
        else{
            $rowCount = mysql_num_rows($resultActor);
            //echo $rowCount;
            if($rowCount == 0){
                    echo "No record ";
            }
            else{
                for ($row = 0; $row < $rowCount; $row++){
                    $tupleActor = mysql_fetch_row($resultActor);
                    echo "<a href = './ShowActorInfo.php?aid= $tupleActor[3]'> $tupleActor[0] $tupleActor[1] </a>"; 
                    echo "act as $tupleActor[2]<br>";
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