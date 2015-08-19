<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$errors = array();
$err = 0;

if(isset($_POST["iebugaround"])){
//lets fetch posted details
$FirstName = $_POST['FirstName'];
$LastName = $_POST['LastName'];
$StudentID = $_POST['StudentID'];

//check student Firstname is present and alphabetic
    if(empty($FirstName) || (!ctype_alpha(str_replace(' ', '', $FirstName)))){
    //let echo error message
    $errors[] = "Please input a Student First Name";
    $err = 1;
    }
//check student Lastname is present and alphabetic
    elseif(empty($LastName) || (!ctype_alpha(str_replace(' ', '', $LastName)))){
    //let echo error message
    $errors[] = "Please input a Student Last Name";
    $err = 2;
    }
 //check studentid is present and numeric
    elseif(empty($StudentID) || (!ctype_digit ($StudentID))){
        //let echo error message
        $errors[] = "Please input a Student ID";
        $err = 3;
    }elseif(strlen($StudentID) != 4){
        $errors[] = "Please input only 4 digit Student ID";
        $err = 4;
    }else{   
    // Check if Student is already in
    mysql_connect($host, $username, $password) or
        die("Could not connect: " . mysql_error());
    mysql_select_db($db_name);
    $result = mysql_query("SELECT Fname FROM Advised_Students where SID =$StudentID AND Lname = '$LastName' AND Fname = '$FirstName'");
    if (mysql_num_rows($result)> 0) {
        $errors[] = "Please input another Student ID, There is a Student exist with the current ID";
        $err = 5;
    }else{//review
        $result = mysql_query("SELECT Fname FROM Current_Students where SID =$StudentID AND Lname = '$LastName' AND Fname = '$FirstName'");
        if (mysql_num_rows($result)> 0) {
            $errors[] = "Please input another Student ID, There is a Student exist with the current ID";
            $err = 5;
            }
        }
    }
    if(!$errors){
    $_SESSION['FirstName'] = $_POST['FirstName'];
    $_SESSION['LastName'] = $_POST['LastName'];
    $_SESSION['StudentID'] = $_POST['StudentID'];
    $_SESSION['Term'] = $_POST['Term'];
    $_SESSION['Year'] = $_POST['Year'];
    returnheader("NewStudentNotes.php");
    }
}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
        <link rel="stylesheet" type="text/css" href="Styles/print.css" /> 
        <link href="Styles/style.css" rel="stylesheet" type="text/css" />
        <title>New Student</title>
    </head>
    <body>  
        <div id="centeredmenu">
            <ul>
                <li class="hide-from-printer"><a href="main.php">Advising</a>
                    <ul>
                        <li class="hide-from-printer"><a href="NewStudent.php" class="hide-from-printer">New Student</a></li>
                        <li class="hide-from-printer"><a href="ExistingStudent.php" class="hide-from-printer">Existing Student</a></li>
                    </ul>
                </li>
                <li class="hide-from-printer"><a href="main.php">Statistics</a>
                    <ul>
                        <li class="hide-from-printer"><a href="GeneralStats.php" class="hide-from-printer">General Statistics</a></li>
                        <li class="hide-from-printer"><a href="TermStats.php" class="hide-from-printer">Term Statistics</a></li>
                    </ul>                     
                </li>
                <li class="hide-from-printer"><a href="Upload.php">Upload</a>               
                </li>                
                <li class="hide-from-printer"><a href="logout.php">Sign Out</a>
                </li>
            </ul>
            <br>
            <br>
        <div id="content_area">
            <form action="#" method="post">
                <input name="iebugaround" type="hidden" value="1">
                <table>
                    <tr> 
                        <td>
                            <label>&emsp;First Name</label>
                            <fieldset class="fieldset3"><input type="text" name="FirstName" class="requiredField1" /></fieldset>
                        </td> 
                        <td>
                            <label>&emsp;Last Name</label>
                            <fieldset class="fieldset3"><input type="text" name="LastName" class="requiredField1" /></fieldset>
                        </td> 
                        <td>
                            <label>&emsp;Student ID</label>
                            <fieldset class="fieldset3"><input type="text" name="StudentID" class="requiredField1" /></fieldset>
                        </td>
                        <td>
                            <label>&emsp;&emsp;&emsp;Term</label>
                            <fieldset class="fieldset4">&emsp;&emsp;&emsp;&nbsp;<select name="Term">
                                                            <option value="Spring">Spring</option>
                                                            <option value="Summer">Summer</option>
                                                            <option value="Fall">Fall</option>
                                                        </select></fieldset>
                        </td>
                        <td>
                            <label>&nbsp;Year</label>
                            <fieldset class="fieldset3"><select name="Year">
                                                            <option value="y"><?php echo $y; ?></option> 
                                                            <option value="y1"><?php echo $y1; ?></option>
                                                            <option value="y2"><?php echo $y2; ?></option>       
                                                        </select></fieldset>
                        </td>                        
                    </tr>
                </table>  
                <fieldset>&emsp;<input name="Notes" id="submit" value="Notes" class="button big round deep-red" type="submit"/>
                    <?php
                    if($err == 1 ){
                    echo '<script>';
                    echo 'alert("Please input a Student First Name");';
                    echo 'location.href="NewStudent.php"';
                    echo '</script>';
                    }elseif($err == 2){
                    echo '<script>';
                    echo 'alert("Please input a Student Last Name");';
                    echo 'location.href="NewStudent.php"';
                    echo '</script>';
                    }elseif($err == 3){
                    echo '<script>';
                    echo 'alert("Please input a Student ID");';
                    echo 'location.href="NewStudent.php"';
                    echo '</script>'; 
                    }elseif($err == 4 ){
                    echo '<script>';
                    echo 'alert("Please input another Student ID, It should be 4 digit only!!!");';
                    echo 'location.href="NewStudent.php"';
                    echo '</script>'; 
                    }elseif($err == 5 ){
                    echo '<script>';
                    echo 'alert("Please input another Student ID, There is a Student exist with the current ID");';
                    echo 'location.href="NewStudent.php"';
                    echo '</script>'; 
                    } else {
                        $err == 0;
                    }
                    ?>
                </fieldset>
            </form>  
        </div>
        </div>   
    </body>
</html>
