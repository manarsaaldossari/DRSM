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
$formerror = array("reapetedUsername"=>false,"passwordMatch"=>false,
                   "incorrectUsername"=>false,"inCorrectPassowrd"=>false);

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
            $formerror["passwordMatch"] = true;
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
                $formerror["reapetedUsername"]=true;
                $iserror = true;
            }
            elseif($logIn){
            $row = $usernameResult->fetch_assoc();
            $savedPassword = $row["password"];
            $maxScore = $row["maxScore"];
            if(strcmp($savedPassword,$password0)!=0){
                $formerror["inCorrectPassowrd"]=true;
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
                $formerror["incorrectUsername"]=true;
                $iserror = true;
            }
        }
    }
    //Close MySQL Connection
    mysqli_close($database);
    if(!$iserror){
        setcookie("username",$username,time()+Five_dayes);
        setcookie("maxScore",$maxScore,time()+Five_dayes);
        header("Location:index.html", true, 301);
        exit();  
        }  
}
    



 //if($iserror&&!$formerror["usernameerror"])
 /*
print( "<div class='content-div'>
<div id='home' class='flex-center flex-column'>
    <span class='header'> Test your knowlge and have fun
    <h6>lets join us :)</h6>
    </span><form action='authentication-Page.PHP' method='post'><label>Username <span class='error'> *");
    if($formerror["usernameerror"])
        print("Username already exists");
     
    print("</span> </label><br><input class='text' type='text' name='username' ");
    if($iserror&&(!$formerror["usernameerror"])){
        print("value='$username'");}
    
    print("placeholder='Enter your name' required><br><label>Password <span class='error'> *");
    if($formerror["passwordMatcherror"])
        print("The two passwords do not match");
            
    print("</span></label><br>".
          "<input class='text' type='password' name='password0' placeholder='write password' required><br>");
    if($logIn){
        print("<label>Confirm Password <span class='error'> *</span></label><br>
        <input class='text' type='password' name='password1' placeholder='rewrite password'required><br>");
    }
            
            print("<input class='button' type='submit' name='submit' value='Sign Up'>
            <a class='button' href='login-page.html'>Log IN</a>
        </form>
</div>
</div>");*/


?>
<div class='content-div'>
<div id='home' class='flex-center flex-column'>
    <span class='header'> Test your knowlge and have fun
    <h6>lets join us :)</h6>
    </span><form action='authentication-Page.PHP' method='post'><label>Username <span class='error'> * Username already exists</span> </label><br>
    <input class='text' type='text' name='username' value='$username' placeholder='Enter your name' required><br>
    <label>Password <span class='error'> * The two passwords do not match</span></label><br>
    <input class='text' type='password' name='password0' placeholder='write password' required><br>
    <label>Confirm Password <span class='error'> *</span></label><br>
    <input class='text' type='password' name='password1' placeholder='rewrite password'required><br>
          
    <input class='button' type='submit' name='sinUp' value='Sign Up'><br>
    <input class='button' type='submit' name='logIn' value='Log In'>
            <!-- <a class='button' href='login-page.html'>Log IN</a> -->
            <span class='header'> <a href="start-Page.html"> < Start page</a></span>
        </form>
</div>
</div>

</body>

</html>