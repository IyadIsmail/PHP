<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$errors = array();
$err = 0;

if(isset($_POST["iebugaround"])){
    //lets fetch posted details
    $StudentID = $_POST['StudentID'];
    
    //check studentid is present and numeric
    if(empty($StudentID) || (!ctype_digit ($StudentID))){
    //let echo error message
    $errors[] = "Please input a Student ID";
    $err = 1;
    }else{   
        // Check if student is already in
        //mysql_connect($host, $username, $password) or
            //die("Could not connect: " . mysql_error());
        //mysql_select_db($db_name);
        //$result = mysql_query("SELECT Fname FROM Advised_Students where SID =$StudentID");
        //if (mysql_num_rows($result)== 0) {
            //$result = mysql_query("SELECT Fname FROM Grad_Students where SID =$StudentID");
            //if (mysql_num_rows($result)== 0) {
                //$errors[] = "Please input another Student, There is no Student exist with the Current Input";
                //$err = 3;
                //}        
        //}       
    }
    if(!$errors){      
    $_SESSION['StudentID'] = $_POST['StudentID'];
    $_SESSION['Term'] = $_POST['Term'];
    $_SESSION['Year'] = $_POST['Year'];
    if ($_POST['Finished_Courses']) {
        mysql_connect($host, $username, $password) or
        die("Could not connect: " . mysql_error());
        mysql_select_db($db_name);
        $result = mysql_query("SELECT Fname,Lname FROM Grad_Students where SID = $StudentID");
        if (mysql_num_rows($result)== 0) {
            $_SESSION['FirstName'] = '';
            $_SESSION['LastName'] = '';
            header('Location: FinishedCourses.php');            
        }elseif(mysql_num_rows($result)== 1){
            $row = mysql_fetch_array($result);
            $_SESSION['FirstName'] = $row['Fname'];
            $_SESSION['LastName'] = $row['Lname'];
            header('Location: FinishedCourses.php');
        }else{
            header('Location: GradChoose.php');
        }   
    }
    }
}
?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
        <link rel="stylesheet" type="text/css" href="Styles/print.css" /> 
        <link href="Styles/style.css" rel="stylesheet" type="text/css" />
        <title>Existing Student</title>
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
                            <label>&emsp;Student ID</label>
                            <fieldset class="fieldset3"><input type="text" name="StudentID" class="requiredField1" /></fieldset>
                        </td>
                        <td>
                            <label>&emsp;&emsp;&emsp;Term</label>
                            <fieldset class="fieldset3">&emsp;&emsp;&emsp;&nbsp;<select name="Term">
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
                <fieldset>&emsp;<input name="Finished_Courses" id="submit" value="Finished_Courses" class="button big round deep-red" type="submit"/>
                    <?php
                    if($err == 1 ){
                    echo '<script>';
                    echo 'alert("Please input a Student ID");';
                    echo 'location.href="ExistingStudent.php"';
                    echo '</script>';
                    } else {
                        $err == 0;
                    }
                    ?>
            </form>  
        </div>
    </body>
</html>


