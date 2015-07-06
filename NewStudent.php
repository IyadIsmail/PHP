<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$errors = array();
$err = 0;

if(isset($_POST["iebugaround"])){
//lets fetch posted details
$studentname = $_POST['studentname'];
$studentID = $_POST['studentID'];

//check studentname is present and alphabetic
    if(empty($studentname) || (!ctype_alpha ($studentname))){
    //let echo error message
    $errors[] = "Please input a Student Name";
    $err = 1;
    }
 //check studentid is present and numeric
    if(empty($studentID) || (!ctype_digit ($studentID))){
    //let echo error message
    $errors[] = "Please input a Student ID";
    $err = 2;
    }   

    if(!$errors){
    $_SESSION['studentname'] = $_POST['studentname'];
    $_SESSION['studentID'] = $_POST['studentID'];
    $_SESSION['term'] = $_POST['term'];
    $_SESSION['year'] = $_POST['year'];
    returnheader("NewStudentNotes.php");
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                <li class="hide-from-printer"><a href="#">Statistics</a>
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
                            <label>&emsp;Student Name</label>
                            <fieldset class="fieldset3"><input type="text" name="studentname" class="requiredField1" /></fieldset>
                        </td> 
                        <td>
                            <label>&emsp;Student ID</label>
                            <fieldset class="fieldset3"><input type="text" name="studentID" class="requiredField1" /></fieldset>
                        </td>
                        <td>
                            <label>&emsp;&emsp;&emsp;Term</label>
                            <fieldset class="fieldset4">&emsp;&emsp;&emsp;&nbsp;<select name="term">
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
                    if($err == 1 ){
                    echo '<script>';
                    echo 'alert("Please input a Student Name");';
                    echo 'location.href="NewStudent.php"';
                    echo '</script>';
                    }elseif($err == 2 ){
                    echo '<script>';
                    echo 'alert("Please input a Student ID");';
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
