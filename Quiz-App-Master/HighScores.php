<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High Scores</title>
    <link rel="stylesheet" href="general.CSS" />
    <link rel="stylesheet" href="quiz-page.CSS" />
</head>
<body>
    <?php
   // $currentscore = $_GET["score"]; //to get varible from js page


    $servername = "localhost";
    $uname = "root";
    $password = "";
    $database = "quiz-app";
    //to connect
    $conn = mysqli_connect($servername,$uname,$password,$database);
    //to check conection
    if(!$conn){
        die("connection faild: ".mysqli_connect_error());
    }


    $mquery ="SELECT `maxScore` FROM `user` ORDER BY maxScore ";
    $cquery = "SELECT `username` , `maxScore` FROM `user` WHERE username = '".$_COOKIE["username"]."'";
    $query = "SELECT `username`, `maxScore` FROM `user` ORDER BY maxScore";

    if (!($result = mysqli_query($conn,$query))){
        echo "could not execute quere!".mysqli_error();
        die;
    }
    if (!($cresult = mysqli_query($conn,$cquery))){
        echo "could not execute quere!".mysqli_error();
        die;
    }
    if (!($mresult = mysqli_query($conn,$mquery))){
        echo "could not execute quere!".mysqli_error();
        die;
    }
    ?>
      

    
<div class='content-div'>
        <div id='highscore' class='flex-center flex-column'>
<?php

$rank_count =1;
while($mrow = mysqli_fetch_row($mresult)){
    foreach($mrow as  $mvalue){
    if($mvalue >= $currentscore)
     $rank_count++;
    }
    $rank_count++;
}
?>
        <table border ="2">
            <thead>
                <tr>
                    <th><mark>Rank</mark></th>
                    <th><mark>User Name </mark></th>
                    <th><mark>High Score </mark> </th>
                    <th><mark>Current Score </mark></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                   while ($crow = mysqli_fetch_row($cresult)){
                    print("<tr>");
                    print("<td> $rank_count </td>");
                    foreach($crow as  $cvalue)
                    print("<td>$cvalue</td>");
                    print("<td> ". $currentscore ." </td>");                    
                    print("</tr>");
                    }
                   ?>
                </tr>
            </tbody>
        </table>   
</div></div>

<br>
        <div class='content-div'>
        <div id='highscore' class='flex-center flex-column'>     
<table>
    <caption><h3 class='header'> High Score Table :</h3></caption>
    <thead>
    <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>Score</th>
    </tr>
</thead>

<tbody>
    <?php
    $count=1;
    while ($count != 11){
        $row = mysqli_fetch_row($result);
        print("<tr>");
        print("<td>".$count." .</td>");
        foreach($row as  $value)
        print("<td>$value</td>");
        print("</tr>");
        $count++;
    }
        ?>
</tbody>
</table>
<br>
     <a class="button" href="index.html">Go Home</a>
  </div></div>   
</body>
</html>