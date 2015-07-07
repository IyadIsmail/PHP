<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$errors1 = array();
$err1 = 0;

if(isset($_POST["iebugaround"])){
    //lets fetch posted details
 $studentID = $_POST['studentID'];
  //check studentid is present and numeric
    if(empty($studentID) || (!ctype_digit ($studentID))){
    //let echo error message
    $errors1[] = "Please input a Student ID";
    $err1 = 1;
    } 
    // Check if Id is already in
    mysql_connect($host, $username, $password) or
        die("Could not connect: " . mysql_error());
    mysql_select_db($db_name);
    $result1 = mysql_query("SELECT sn FROM tt1 where sid = $studentID");
    $row1 = mysql_fetch_row($result1);
    if (mysql_num_rows($result1)== 0) {
        $errors1[] = "Please input a Student ID, There is no Student exist with the current ID";
        $err1 = 2;
    }
    if(!$errors1){
    $_SESSION['studentID'] = $_POST['studentID'];
    $_SESSION['term'] = $_POST['term'];
    $_SESSION['year'] = $_POST['year'];
    $_SESSION['studentname'] = $row1[0]; 
    if ($_POST['Notes']) {
     header('Location: ExistingStudentNotes.php');
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
        <title>Advising Notes</title>
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
                <li class="hide-from-printer"><a href="Statistics.php">Statistics</a>
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
                            <fieldset class="fieldset3"><input type="text" name="studentID" class="requiredField1" /></fieldset>
                        </td>
                        <td>
                            <label>&emsp;&emsp;&emsp;Term</label>
                            <fieldset class="fieldset3">&emsp;&emsp;&emsp;&nbsp;<select name="term">
                                                            <option value="Spring">Spring</option>
                                                            <option value="Summer">Summer</option>
                                                            <option value="Fall">Fall</option>
                                                        </select></fieldset>
                        </td>
                        <td>
                            <label>&nbsp;Year</label>
                            <fieldset class="fieldset3"><select name="year">
                                                            <option value="y"><?php echo $y; ?></option> 
                                                            <option value="y1"><?php echo $y1; ?></option>
                                                            <option value="y2"><?php echo $y2; ?></option>      
                                                        </select></fieldset>
                        </td> 
                    </tr>
                </table> 
                <fieldset>&emsp;<input name="Notes" id="submit" value="Notes" class="button big round deep-red" type="submit"/>
                <?php
                    if($err1 == 1 ){
                    echo '<script>';
                    echo 'alert("Please input a Student ID");';
                    echo 'location.href="ExistingStudent.php"';
                    echo '</script>'; 
                    } elseif($err1 == 2 ){
                    echo '<script>';
                    echo 'alert("Please input a Student ID, There is no Student exist with current ID");';
                    echo 'location.href="ExistingStudent.php"';
                    echo '</script>'; 
                    }else {
                        $err1 == 0;
                    }
                    ?>
            </form>  
        </div>
    </body>
</html>


