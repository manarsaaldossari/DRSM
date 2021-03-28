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

$iserror = false;

$usernameError = array("reapetedUsername"=>false,"incorrectUsername"=>false); 

$passwordError =array("passwordMatch"=>false,"inCorrectPassowrd"=>false);

$errorMessage= array("reapetedUsername"=>"Username already exists",
                    "passwordMatch"=>"The two passwords do not match",
                    "incorrectUsername"=>"The username you entered did not match our records",
                    "inCorrectPassowrd"=>"wrong password, please try again");

$logIn_start = isset($_POST["logIn_start"])?true:false;
$sinUp_start = isset($_POST["sinUp_start"])?true:false;
$logIn = isset($_POST["logIn"])?true:false;
$sinUp = isset($_POST["sinUp"])?true:false;
$canLogIn = false;
$canSignUp = false;
define("Five_dayes",(60*60*24)*5);

//In case of SingUp or LogIn
if($logIn || $sinUp){
    //USER Authintication varibules
    $username = $_POST["username"];
    $password0 = $_POST["password0"];
    //in case of sinUp--> Password checking ,Username and passowrd length checking
    if($sinUp){
        $password1 = $_POST["password1"];
        if(strcmp($password0,$password1)!=0){
            $passwordError["passwordMatch"] = true;
            $iserror = true;
        }
    }
    if(!$iserror){
        // DB Variables connection variuble
        $databaseName = "Quiz-App";
        $database = mysqli_connect( "localhost","root", "", $databaseName);
        if(!$database){
            die("database connection faild: ".mysqli_connect_error());
        }
        //Querys
        $usernameMatch_Query  = "SELECT * FROM user WHERE username='$username' LIMIT 1";
        $insertUser_Query = "INSERT INTO `user`(`username`, `password`) VALUES (\"$username\",\"$password0\")";


        //check username
        $usernameResult = mysqli_query($database,$usernameMatch_Query);
        //username match
        if($usernameResult->num_rows>0){
            if($sinUp){
                $usernameError["reapetedUsername"]=true;
                $iserror = true;
            }
            elseif($logIn){
            $row = $usernameResult->fetch_assoc();
            $savedPassword = $row["password"];
            $maxScore = $row["maxScore"];
            if(strcmp($savedPassword,$password0)!=0){
                $passwordError["inCorrectPassowrd"]=true;
                $iserror = true;
            }
            }
        //username no match
        }else{
            if($sinUp){
                if(!(mysqli_query($database,$insertUser_Query)))
                    die(mysqli_error()."</body></html>");
                $maxScore = 0 ;
            }
            elseif($logIn){
                $usernameError["incorrectUsername"]=true;
                $iserror = true;
            }
        }
        //Close MySQL Connection
        mysqli_close($database);
    }
    
    if(!$iserror){
        setcookie("username",$username,time()+Five_dayes);
        setcookie("maxScore",$maxScore,time()+Five_dayes);
        
        header("Location:index.html", true, 301);
        exit();  
        } 

}

    //Page Rendreing
    print("<div class='content-div'><div id='home' class='flex-center flex-column'>
            <span class='header'>" );
    if($logIn_start || $logIn){
        print("<img src='Header_login_page.png' alt='text image on login page' width=1000px hight=500px><br>
            <h6>welcome back :)</h6></span>");
    }else{
        print("<img src='Header_signup_page.png' alt='text image on signup page' width=1000px hight=500px><br>
            <h6>lets join us :)</h6></span>");
    }
    //username
    print("<form action='authentication-Page.PHP' method='post'>
        <label>Username ");
    if($iserror&&(in_array(true,$usernameError))){
        foreach ($usernameError as $key => $value) {
            if($value){
                print("<span class='error'> * ".$errorMessage[$key]."</span> ");
                break;
            }
        } 
    }

    print("</label><br><input class='text' type='text' name='username' ");

    if($iserror&&(!in_array(true,$usernameError))){
        print("value='$username'");
    }
    //passowrd 
    print("placeholder='Enter your name' required><br><label>Password ");
    if($iserror&&(in_array(true,$passwordError))){
        foreach ($passwordError as $key => $value) {
            if($value){
                print("<span class='error'> * ".$errorMessage[$key]."</span> ");
                break;
            }
        } 
    }
            
    print("</label><br>"."<input class='text' type='password' name='password0' placeholder='write password' required><br>");
    if($sinUp||$sinUp_start){
        print("<label>Confirm Password </label><br>
        <input class='text' type='password' name='password1' placeholder='rewrite password'required><br>");
    }
    //sin up or log in button
    if($sinUp||$sinUp_start){
        print("<input class='button' type='submit' name='sinUp' value='Sign Up'><br>");
    }else{
        print("<input class='button' type='submit' name='logIn' value='Log In'><br>");
    }
    //start page
    print("<span class='header'> <a href='start-Page.html'> < Start page</a></span>"."</form></div></div>");

?>
</body>

</html>