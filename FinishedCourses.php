<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$LastName = $_SESSION['LastName'];
$FirstName = $_SESSION['FirstName'];
$StudentID = $_SESSION['StudentID'];
$Term = $_SESSION['Term'];
$Year = $_SESSION['Year'];
if ($Year == 'y'){
    $y = date('Y');
}elseif ($Year == 'y1'){
    $y1 = date('Y');
    $y = $y1+1;
}else{
    $y1 = date('Y');
    $y = $y1+2;
}
if(isset($_POST["iebugaround"])){
 if ($_POST['Notes']) {
        mysql_connect($host, $username, $password) or
        die("Could not connect: " . mysql_error());
        mysql_select_db($db_name);
        $result = mysql_query("SELECT Fname FROM Advised_Students where SID = $StudentID and Lname = '$LastName'");
        if (mysql_num_rows($result)== 0) {
            $_SESSION['FirstName1'] = 'None';
            header('Location: ExistingStudentNotes.php');            
        }else{
            header('Location: PreviousNotes.php');
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
                    <?php
                        $FirstName = $_SESSION['FirstName'];
                        if($FirstName == ''){
                            echo "<h3><font color=#999>&emsp;This Student have not Finished any course yet........</font></h3>";
                        }else{
                            $Courses_Finished = array(); 
                            //To get Finished courses
                            mysql_connect($host, $username, $password) or
                                die("Could not connect: " . mysql_error());
                            mysql_select_db($db_name);
                            $result = mysql_query("SELECT Course_Name FROM Grad_Courses where SID = $StudentID and Lname = '$LastName' and Fname = '$FirstName' ");
                            $cor = '';    
                            while($row = mysql_fetch_array($result)) {
                                $cor = $cor.$row['Course_Name'].'-';
                                //Used to highlight course
                                $Courses_Finished[$row['Course_Name']] = 1;
                            }
                            $cor = substr($cor, 0, -1);
                            echo "<h3><font color=#999>&emsp;Finished Courses</font></h3>";
                            echo "<table class=requiredField3 border = 1>";
                            echo "<tr>"; 
                            echo "<td class = table_d1 width = 250 style = padding-left:10px>".$cor."</td>"; 
                            echo "</tr>"; 
                            echo "</table>";   
                        }
                    ?>
                <table>
                    <tr>

                    </tr>
                </table> 
                <fieldset>&emsp;<input name="Notes" id="submit" value="Notes" class="button big round deep-red" type="submit"/>
            </form>  
        </div>
    </body>
</html>