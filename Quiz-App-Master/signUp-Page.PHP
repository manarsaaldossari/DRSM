<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>Quiz Time</title>
    <link rel="stylesheet" href="general.CSS" /> 
</head>

<body>
<?php
print("<h3>Hellllloooooo000</h3>");
$username = isset($_POST["username"])?$_POST["username"]:"";
$password0 = isset($_POST["password0"])?$_POST["password0"]:"";
$password1 = isset($_POST["password1"])?$_POST["password1"]:"";
$iserror = false;
$formerror = array("usernameerror"=>false,"password0error"=>false,"password1error"=>false,"passwordMatcherror"=>false);
print("<h3>Hellllloooooo111</h3>");

if(isset($_POST["submit"])){
    if(isset($_POST["submit"])){
    if($username == ""){
        $formerror["usernameerror"] = true;
        $iserror = true;
    }
    if($password0 == ""){
        $formerror["password0error"] = true;
        $iserror = true;
    }
    if($password1 == ""){
        $formerror["password1error"] = true;
        $iserror = true;
    }
    if(strcmp($password0,$password1)!=0){
        $formerror["passwordMatcherror"] = true;
        $iserror = true;
    }
    if(!$iserror){
        print("no form error");
        // DB Variables connection variuble
        $databaseName = "Quiz-App";
        $database = mysqli_connect( "localhost","root", "", $databaseName);
        if(!$database){
            die("database connection faild: ".mysqli_connect_error());
        }
        print("no connection error");
        $query1 = "SELECT * FROM user";
        $query = "INSERT INTO `user`(`username`, `password`) VALUES (\"$username\",\"$password0\")";

        if(!(mysqli_query($database,$query))){
                die(mysqli_error()."</body></html>");
        }
        print("no query error");
        //Close MySQL Connection
        mysqli_close($database);

        header("index.html", true, 301);
        print("<br>header");
        exit();           

    }
}
}

/*print("<h3>Hellllloooooo3333</h3>");

print( "<div class='content-div'>
<div id='home' class='flex-center flex-column'>
    <h2>Here you can Login</h2>

    <h4 align='left'>lets join us :)</h6>

        <form action='Quiz-App-Master/signUp-Page.PHP' method='post'>
            <label>Username</label><br>
            <input type='text' name='username' placeholder='Enter your name'><br>
            <input type='password' name='password0' placeholder='write password'><br>
            <input type='password' name='password1' placeholder='rewrite password'><br>
        </form>
        <input  type='submit' name='submit' value='Sign Up'>

        <a class='button' href='login-page.html'>Log IN</a>
</div>
</div>)");
*/

?>

    <div class='content-div'>
        <div id='home' class='flex-center flex-column'>
            <h2>Here you can Login</h2>

            <h4 align='left'>lets join us :)</h6>

                <form action='signUp-Page.PHP' method='post'>
                    <label>Username</label><br>
                    <input type='text' name='username' placeholder='Enter your name'><br>
                    <input type='password' name='password0' placeholder='write password'><br>
                    <input type='password' name='password1' placeholder='rewrite password'><br>
                    <input class='button' type='submit' name='submit' value='Sign Up'>
                    <a class='button' href='login-page.html'>Log IN</a>
                </form>
        </div>
    </div>
</body>

</html>