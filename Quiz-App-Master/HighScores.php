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
$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "quiz-app";
    //to connect
    $conn = mysqli_connect($servername,$username,$password,$database);
    //to check conection
    if(!$conn){
        die("connection faild: ".mysqli_connect_error());
    }


    $query = "SELECT `username`, `maxScore` FROM `user` ORDER BY maxScore";
    if (!($result = mysqli_query($conn,$query))){
        echo "could not execute quere!".mysqli_error();
        die;
    }

    
?>
<div class='content-div'>
        <div id='highscore' class='flex-center flex-column'>
<table>
    <caption><h3 class='header'> High Score Table :</h3></caption>
    <thead>
    <tr>
        <th>Place</th>
        <th>Name</th>
        <th>Score</th>
    </tr>
</thead>

<tbody>
    <?php
    $count=1;
    while ($row = mysqli_fetch_row($result)){
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