<?php
session_start();
require_once 'config.php';
//redirect function
function returnheader($location){
	$returnheader = header("location: $location");
	return $returnheader;
}

// Connect to server and select databse.
 
$connection = mysql_connect("$host", "$username", "$password")or die("cannot connect");
$db_select = mysql_select_db("$db_name")or die("cannot select DB");

$errors = array();
$err = 0;
if(isset($_POST["iebugaround"])){
//lets fetch posted details
$myusername = $_POST['username'];
$mypassword = $_POST['password'];

//check username is present
if(empty($myusername)){
    //let echo error message
    $errors[] = "Please input a username";
    $err = 1;
}

//check password was present
if(empty($mypassword) & !empty($myusername)){
    //let echo error message
    $errors[] = "Please input a password";
    $err = 2;
}

if(!$errors){
    //encrypt the password
    //$mypassword = sha1($mypassword);
    //$salt = md5("userlogin");
    //$pepper = "kikikikikicbtr";

    //$passencrypt = $salt . $mypassword . $pepper;

    // To protect MySQL injection (more detail about MySQL injection)
    $myusername = stripslashes($myusername);
    $mypassword = stripslashes($mypassword);
    $myusername = mysql_real_escape_string($myusername);
    $mypassword = mysql_real_escape_string($mypassword);

    $sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
    $result = mysql_query($sql);
    $result_num = mysql_num_rows($result);
    
    if($result_num > 0){
		while($row = mysql_fetch_array($result)){
			$idsess = stripslashes($row["id"]);
			$firstnamesess = stripslashes($row["firstname"]);
			$username = stripslashes($row["username"]);
			
			$_SESSION["SESS_USERID"] = $idsess;
			$_SESSION["SESS_USERFIRSTNAME"] = $firstnamesess;
			$_SESSION["SESS_USERNAME"] = $username;
			setcookie("userloggedin", $username);
			setcookie("userloggedin", $username, time()+43200); // expires in 1 hour
			//success lets login to page
			returnheader("main.php");
		}
	} else {
		//tell there is no username etc
		$errors[] = "Your username or password are incorrect";
                $err = 3;
                //echo "Your username or password are incorrect";
	}
}
}else{
    $myusername = "";
}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advising</title>
        <link href="Styles/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="loginwrap">
            <h1>Login Area</h1>
            <div id="loginform">
                <form action="#" method="post">
                <input name="iebugaround" type="hidden" value="1"> 
                <label>Username</label>
                <fieldset class="fieldset2"><input type="text" name="username" class="requiredField" value="<?php echo $myusername ; ?>"/></fieldset>
                <label>Password</label>
                <fieldset class="fieldset2"><input type="password" name="password" class="text requiredField subject"/></fieldset>
                <fieldset><input name="submit" id="submit" value="Login" class="button big round deep-red" type="submit"/>
                    <?php
                    if($err == 1 ){
                    echo '<script>';
                    echo 'alert("Please input a username");';
                    echo 'location.href="index.php"';
                    echo '</script>';
                    }elseif($err == 2){
                    echo '<script>';
                    echo 'alert("Please input a password");';
                    echo 'location.href="index.php"';
                    echo '</script>';                    
                    }elseif($err == 3){
                    echo '<script>';
                    echo 'alert("Your username or password are incorrect");';
                    echo 'location.href="index.php"';
                    echo '</script>'; 
                    }else{
                        $err ==0;
                    }
                    ?>
                </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>