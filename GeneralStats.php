<?php
session_start();

require_once 'cookies.php';
require_once 'config.php';

if(isset($_POST["iebugaround"])){

    if ($_POST['print']) {
     header('Location: main.php');
    }
}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>"Advising Notes for Existing Student"</title>
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
        <link rel="stylesheet" type="text/css" href="Styles/print.css" /> 
        <link href="Styles/style.css" rel="stylesheet" type="text/css" />
        <script language="javascript">
            function printpage()
            {
                window.print();
            }
        </script>
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
                require_once 'config.php';
                // Create connection
                mysql_connect($host, $username, $password) or
                    die("Could not connect: " . mysql_error());
                mysql_select_db($db_name);
                $res = mysql_query("SELECT Count(SID) FROM Grad_Students");
                $row = mysql_fetch_array($res);
                $num_rows = $row[0];
                $result = mysql_query("SELECT Grad_Courses.Course_Name,Count(SID) FROM Grad_Courses,Core_Courses WHERE Grad_Courses.Course_Name = Core_Courses.Course_Name GROUP BY Grad_Courses.Course_Name ORDER BY Grad_Courses.Course_Name");
                if (mysql_num_rows($result) > 0) { 
                    echo "<h3><font color=#999>&emsp;Core Courses Needed</font></h3>";
                    echo "<table class=requiredField4 border = 1>"; 
                    echo "<tr>";
                    echo "<td class = table_d1 width = 100><center>Course Name</center></td>";
                    echo "<td class = table_d1 width = 100><center>Totally</center></td>";                
                    echo "</tr>"; 
                    while($row = mysql_fetch_array($result)) { 
                        $c = $num_rows - $row['Count(SID)'];
                        echo "<tr>"; 
                        echo "<td class = table_d1 width = 100><center>". $row['Course_Name']."<br>"."</center></td>"; 
                        echo "<td class = table_d1 width = 100><center>". $c."<br>"."</center></td>";  
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                }     
                ?>
            <table>
                <tr> 
                    <td>
                        <fieldset><input name="print" id="print" value="Print" class="button big round deep-red hide-from-printer" type="submit" onclick="printpage();"/>
                    </td>                    
                </tr>
            </table>   
            </form>  
        </div>
    </body>
</html>





