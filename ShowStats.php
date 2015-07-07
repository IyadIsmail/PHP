<?php
session_start();
$term = $_SESSION['term'];
$year = $_SESSION['year'];
    if ($year == 'y'){
        $y = date('Y');
    }elseif ($year == 'y1'){
        $y1 = date('Y');
        $y = $y1+1;
    }else{
        $y1 = date('Y');
        $y = $y1+2;
    }
require_once 'cookies.php';
require_once 'config.php';
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
                            <label class="requiredField1">&emsp;&emsp;Term:  <?php echo $term;?></label>
                            <input name="term" type="hidden" value="<?php echo $term;?>">    
                        </td> 
                       <td class="table_d">
                            <label class="requiredField1">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Year:  <?php echo $y;?></label>
                            <input name="year" type="hidden" value="<?php echo $y;?>">    
                        </td> 
                    </tr>
                </table>  						
                <?php
                require_once 'config.php';
                $term = $_SESSION['term'];
                $year = $_SESSION['year'];
                    if ($year == 'y'){
                        $y = date('Y');
                    }elseif ($year == 'y1'){
                        $y1 = date('Y');
                        $y = $y1+1;
                    }else{
                        $y1 = date('Y');
                        $y = $y1+2;
                    }
                // Create connection
                mysql_connect($host, $username, $password) or
                    die("Could not connect: " . mysql_error());
                mysql_select_db($db_name);
                $result = mysql_query("SELECT cn,Num FROM tt2 where term = '$term' AND year = '$y' ORDER By cn");
                if (mysql_num_rows($result) > 0) { 
                    echo "<h3><font color=#999>&emsp;Advised Courses</font></h3>";
                    echo "<table class=requiredField4 border = 1>"; 
                    echo "<tr>";
                    echo "<td class = table_d1 width = 100><center>Course Name</center></td>";
                    echo "<td class = table_d1 width = 100><center>Totally Advised</center></td>";                
                    echo "</tr>"; 
                    while($row = mysql_fetch_array($result)) { 
                        echo "<tr>"; 
                        echo "<td class = table_d1 width = 100><center>".$row['cn']."<br>"."</center></td>"; 
                        echo "<td class = table_d1 width = 100><center>".$row['Num']."<br>"."</center></td>";  
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



