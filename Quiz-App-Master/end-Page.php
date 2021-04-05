<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Congrats!</title>
    <link rel="stylesheet" href="general.CSS">
</head>

<body>
<div class='content-div'>
        <div id='end' class='flex-center flex-column'>

        <img src="images/Quiz_Time.png" alt="text image on Quiz Time" width=1000px hight=500px><br>
        
    <?php
        $username = $_COOKIE["username"];
        $currentScore = isset($_COOKIE["currentScore"])?$_COOKIE["currentScore"]:0;
        $databaseName = "Quiz_App";
        $database = mysqli_connect( "localhost","root", "", $databaseName);
        if(!$database){
            die("database connection faild: ".mysqli_connect_error());
        }
        //Querys
        $maxScore_Query  = "SELECT `maxScore` FROM user WHERE `username` =\"$username\" LIMIT 1";

        //check username
        $maxScoreResult = mysqli_query($database,$maxScore_Query);
        $row = $maxScoreResult->fetch_assoc();
        $maxScore = $row["maxScore"];
        //username match
        
        print("<span class='textbox'>Current Score ".$currentScore." </span>");
        print("<span class='textbox'>");
        if($currentScore>$maxScore){
            print("New ");
            $newmaxScore_Query  = "UPDATE `user` SET `maxScore`= $currentScore WHERE `username` =\"$username\" LIMIT 1";
            mysqli_query($database,$newmaxScore_Query);
            $maxScore = $currentScore;
        }
        //Close MySQL Connection
        mysqli_close($database);
        print("Max Score ".$maxScore." </span> </span>");
    ?>
            <a class='button' href='quiz-Page.html'>Play Again</a>
            <a class="button" href="Leaderboard.php">Leader Board</a>
        </div>
    </div>
</body>

</html>