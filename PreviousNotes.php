<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$LastName = $_SESSION['LastName'];
$StudentID = $_SESSION['StudentID'];

if(isset($_POST["iebugaround"])){
    if (isset($_POST['FirstName'])) {
        $_SESSION['FirstName1'] = $_POST['FirstName'];
        header('Location: ExistingStudentNotes.php');
    }else{
        header('Location: PreviousNotes.php');
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
                    $result = mysql_query("SELECT Fname FROM Advised_Students where SID = $StudentID and Lname = '$LastName'");
                    echo "<table class=requiredField1>";
                    while($row = mysql_fetch_array($result)) {
                      echo "<tr>";
                      echo "<td class = table_d1 width = 250><input type= radio name=FirstName value=$row[Fname]>".ucfirst(strtolower($row['Fname']))." ".ucfirst($LastName)."<br></td>";             
                      echo "</tr>";     
                    } 
                    echo "<tr>";
                    echo "<td class = table_d1 width = 250><input type= radio name=FirstName value='None'>"."None of the above"."</td>";
                    echo "</tr>";
                ?>
                </table> 
                <fieldset>&emsp;<input name="Next" id="submit" value="Next" class="button big round deep-red" type="submit"/>
            </form>  
        </div>
    </body>
</html>

