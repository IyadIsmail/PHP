<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$StudentID = $_SESSION['StudentID'];

if(isset($_POST["iebugaround"])){
    if (isset($_POST['StudentName'])) {
        $StudentName = $_POST['StudentName'];
        $findme = '-';
        $pos = strpos($StudentName, $findme);
        $Fname = substr($StudentName,0,$pos);
        $Lname = substr($StudentName,$pos+1);
        $_SESSION['FirstName'] = $Fname;
        $_SESSION['LastName'] = $Lname;
        header('Location: FinishedCourses.php');
    }else{
        header('Location: GradChoose.php');
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
        <title>Grad Student Choose</title>
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
                            <label>&emsp;Please select which student:</label>
                        </td>
                    </tr>
                </table>
                <?php 
                    mysql_connect($host, $username, $password) or
                    die("Could not connect: " . mysql_error());
                    mysql_select_db($db_name);
                    $result = mysql_query("SELECT Fname,Lname FROM Grad_Students where SID = $StudentID");
                    echo "<table class=requiredField1>";
                    while($row = mysql_fetch_array($result)) {
                      $Fname = $row['Fname'];
                      $Lname = $row['Lname'];
                      $StudentName = $Fname.'-'.$Lname;
                      echo "<tr>";
                      echo "<td class = table_d1 width = 250><input type= radio name=StudentName value=$StudentName>".ucfirst(strtolower($Fname))." ".ucfirst(strtolower($Lname))."<br></td>";             
                      echo "</tr>";     
                    } 
                    echo "<tr>";
                    echo "<td class = table_d1 width = 250><input type= radio name=StudentName value='None'>"."None of the above"."</td>";
                    echo "</tr>";                   
                ?>
                </table> 
                <fieldset>&emsp;<input name="Finished_Courses" id="submit" value="Finished_Courses" class="button big round deep-red" type="submit"/>
            </form>  
        </div>
    </body>
</html>


