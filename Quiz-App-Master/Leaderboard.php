<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="general.CSS" />
    <link rel="stylesheet" href="quiz-page.CSS" />
</head>
<body>
    <?php

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
    
    $query = "SELECT `username`, `maxScore` FROM `user` ORDER BY maxScore";
    $dmquery="SELECT `maxScore` FROM `user` ORDER BY maxScore";
    if (!($result = mysqli_query($conn,$query))){
        echo "could not execute quere!".mysqli_error();
        die;
    }

    if (!($dmresult = mysqli_query($conn,$dmquery))){
        echo "could not execute quere!".mysqli_error();
        die;
    }

    $uquery = "SELECT `username` , `maxScore` FROM `user` WHERE username = '".$_COOKIE["username"]."'";
    $mquery = "SELECT `maxScore` FROM `user` WHERE username = '".$_COOKIE["username"]."'";
    if (!($uresult = mysqli_query($conn,$uquery))){
        echo "could not execute quere!".mysqli_error();
        die;
    }
    
    if (!($umax = mysqli_query($conn,$mquery))){
        echo "could not execute quere!".mysqli_error();
        die;
    }
    ?>
      

    
<div class='content-div'>
        <div id='Leaderboard' class='flex-center flex-column'>

    <?php

$rank_count =1;
while($dmrow = mysqli_fetch_row($dmresult)){
    foreach($dmrow as $key => $value){
    if($key == "maxScore" || $umax <= $value)
     $rank_count++;
}}
$rank_count++;
?>

        <table class=utable  border ='2'>
        <h3 class='header'> <img src="Leader_Board.png" alt=" text image og Leader board" width=1000px hight=500px></h3>
            <thead>
                <tr>
                    <th><img src="Rank.png" alt="rank lable image" width=100px hight=50px></th>
                    <th><img src="Name.png" alt="name lable image" width=100px hight=50px> </th>
                    <th><img src="MaxScore.png" alt="Max Score lable image" width=100px hight=50px> </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                   while ($urow = mysqli_fetch_row($uresult)){
                    print("<tr>");
                    print("<td> $rank_count </td>");
                    foreach($urow as  $uvalue)
                    print("<td>$uvalue</td>");                  
                    print("</tr>");
                    }
                   ?>
                </tr>
            </tbody>
        </table>   
</div></div>

        <div class='content-div'>
        <div id='Leaderboard' class='flex-center flex-column'>     
<table>
    <tr>
        <th><img src="Rank.png" alt="rank lable image" width=300px hight=200px></th>
        <th><img src="Name.png" alt="name lable image" width=300px hight=200px> </th>
        <th><img src="MaxScore.png" alt="Max Score lable image" width=300px hight=200px> </th>
    </tr>
</thead>

<tbody>
    <?php
    $count=1;
    while ($count != 11){
        $row = mysqli_fetch_row($result);
        print("<tr>");
        print("<td>".$count." .</td>");
        foreach($row as $value){
        print("<td>$value</td>");}
        print("</tr>");
        $count++;
    }
        ?>
</tbody>
</table>
<br><br>

     <a class="button" href="index.html">Go Home</a>
  </div></div>   
</body>
</html>