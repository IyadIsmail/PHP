<?php
require_once 'config.php';
session_start();
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

    if ($_POST['print']) {
     header('Location: main.php');
    }
}



?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Statistics</title>
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
                        <td class="table_d">
                            <label class="requiredField1">&emsp;&emsp;Term:  <?php echo $Term;?></label>   
                        </td> 
                       <td class="table_d">
                            <label class="requiredField1">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Year:  <?php echo $y;?></label>
                        </td> 
                    </tr>
                </table>  						
                <?php
                require_once 'config.php';
                $Stats = $_SESSION['Stats'];
                // Create connection
                mysql_connect($host, $username, $password) or
                    die("Could not connect: " . mysql_error());
                mysql_select_db($db_name);
                if($Stats == '1'){
                   $result = mysql_query("SELECT Course_Name,Count(SID) FROM Advised_Courses where Term = '$Term' AND Year = '$y' GROUP BY Course_Name ORDER By Course_Name");
                    if (mysql_num_rows($result) > 0) { 
                        echo "<h3><font color=#999>&emsp;Advised Courses</font></h3>";
                        echo "<table class=requiredField4 border = 1>"; 
                        echo "<tr>";
                        echo "<td class = table_d1 width = 100><center>Course Name</center></td>";
                        echo "<td class = table_d1 width = 100><center>Totally Advised</center></td>";                
                        echo "</tr>"; 
                        while($row = mysql_fetch_array($result)) { 
                            echo "<tr>"; 
                            echo "<td class = table_d1 width = 100><center>".$row['Course_Name']."<br>"."</center></td>"; 
                            echo "<td class = table_d1 width = 100><center>".$row['Count(SID)']."<br>"."</center></td>";  
                            echo "</tr>"; 
                        } 
                        echo "</table>"; 
                    }     
                }else{
                   $result = mysql_query("SELECT Course_Name,Count(SID) FROM Courses_Taken where Term = '$Term' AND Year = '$y' GROUP BY Course_Name ORDER By Course_Name");
                    if (mysql_num_rows($result) > 0) { 
                        echo "<h3><font color=#999>&emsp;Courses Taken</font></h3>";
                        echo "<table class=requiredField4 border = 1>"; 
                        echo "<tr>";
                        echo "<td class = table_d1 width = 100><center>Course Name</center></td>";
                        echo "<td class = table_d1 width = 100><center>Total </center></td>";                
                        echo "</tr>"; 
                        while($row = mysql_fetch_array($result)) { 
                            echo "<tr>"; 
                            echo "<td class = table_d1 width = 100><center>".$row['Course_Name']."<br>"."</center></td>"; 
                            echo "<td class = table_d1 width = 100><center>".$row['Count(SID)']."<br>"."</center></td>";  
                            echo "</tr>"; 
                        } 
                        echo "</table>"; 
                    }                      
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



