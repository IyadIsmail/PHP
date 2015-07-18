<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$Firstname = $_SESSION['Firstname'];
$Lastname = $_SESSION['Lastname'];
$Studentname = $Firstname." ".$Lastname;
$StudentID = $_SESSION['StudentID'];
$Term = $_SESSION['Term'];
$Year = $_SESSION['Year'];
$Area1 = $_SESSION['textarea'];

$str_arr = explode("\n", $Area1);
$Num_Notes = count($str_arr);

for($count=$Num_Notes; $count < 4; $count++)
 $str_arr[$count] = '';
$Text1 = $str_arr[0];
$Text2 = $str_arr[1];
$Text3 = $str_arr[2];
$Text4 = $str_arr[3];

if ($Year == 'y'){
    $y = date('Y');
}elseif ($Year == 'y1'){
    $y1 = date('Y');
    $y = $y1+1;
}else{
    $y1 = date('Y');
    $y = $y1+2;
}
$cy = date('Y');
$courses = '';
$c = $_SESSION['course'];
$N = count($c);
if($N > 0){
 $courses = $c[0];   
    for($i = 1; $i < $N; $i++){
        $courses = $courses.' '.$c[$i];  
    }
}
for($i=$N; $i < 6; $i++)
 $c[$i] = '';
$N1 = $c[0];
$N2 = $c[1];
$N3 = $c[2];
$N4 = $c[3];
$N5 = $c[4];
$N6 = $c[5];
$area = '';
//$_SESSION['textarea'] = '';
//To check witch button is pressed
if(isset($_POST["iebugaround"])){
    
    //$_SESSION['textarea'] = $_POST['textarea'] ;
    //$area = $_POST['textarea'];
    
    //$out = preg_replace('/\s\n/', ',', $area);
    
    
    if ($_POST['print']) {
     header('Location: main.php');
    }
}
?>
             
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Print</title>
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
        <div id="content_area">
            <form action="#" method="post">
            <input name="iebugaround" type="hidden" value="1">
            <div>  
            <center><h3><font color="#999">Western Illinois University<br>Advising Form</font></center>
            </div>						
            <table>
                <tr> 
                    <td class="table_d">
                        <label class="requiredField1">Student Name: <?php echo $Studentname;?></label>
                        <input name="Studentname" type="hidden" value="<?php echo $Studentname;?>">
                    </td>
                    <td class="table_d">
                        <label class="requiredField1">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Student ID:  <?php echo $StudentID;?></label>
                        <input name="StudentID" type="hidden" value="<?php echo $StudentID;?>">    
                    </td>                    
                </tr>
            </table>
                <center><label>Recommended Courses </label></center>
            <table>
                <tr> 
                    <td class="table_d">
                        <label class="requiredField1">1. <?php echo $c[0];?></label>
                    </td>
                </tr>
                <tr>
                    <td class="table_d">
                        <label class="requiredField1">2. <?php echo $c[1];?> </label>   
                    </td>
                </tr>
                <tr>
                    <td class="table_d">
                        <label class="requiredField1">3. <?php echo $c[2];?> </label>   
                    </td>   
                </tr>
                <tr>
                    <td class="table_d">
                        <label class="requiredField1">4. <?php echo $c[3];?> </label>   
                    </td>   
                </tr>
                <tr>
                    <td class="table_d">
                        <label class="requiredField1">5. <?php echo $c[4];?> </label>   
                    </td>
                </tr>
                <tr>   
                    <td class="table_d">
                        <label class="requiredField1">6. <?php echo $c[5];?> </label>   
                    </td>   
                </tr>
            </table>
                <center><label>Other Notes </label></center>
            <table>
                <tr> 
                    <td class="table_d">
                        <label class="requiredField1">1.  <?php echo $str_arr[0];?></label>
                    </td>
                </tr>
                <tr>
                    <td class="table_d">
                        <label class="requiredField1">2.  <?php echo $str_arr[1];?></label>   
                    </td>
                </tr>
                <tr>
                    <td class="table_d">
                        <label class="requiredField1">3.  <?php echo $str_arr[2];?></label>   
                    </td>
                </tr>
                <tr>
                    <td class="table_d">
                        <label class="requiredField1">4.  <?php echo $str_arr[3];?></label>   
                    </td>
                </tr>                
            </table>
                        
            <br>
                
            <table>
                <tr> 
                    <td class="table_d">
                        <label class="requiredField1"><?php echo ("$m - $d - $cy");?></label>
                    </td> 
                    <td class="table_d">
                        <label class="requiredField1">&emsp;&emsp;&emsp;&emsp;&emsp;Advisor Signature</label> 
                    </td>                    
                </tr>
            </table> 
            <br>
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

