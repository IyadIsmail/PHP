<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

$studentname = $_SESSION['studentname'];
$studentID = $_SESSION['studentID'];
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
$cy = date('Y');
$courses = '';

if(isset($_POST["iebugaround"])){
    $course = $_POST['course'];
    $_SESSION['course']= $_POST['course'];
    $Num_courses = count($course);
    if($Num_courses > 0){
     $courses = $course[0];   
        for($count = 1; $count < $Num_courses; $count++){
            $courses = $courses.' '.$course[$count];  
        }
    }
    for($count=$Num_courses; $count < 6; $count++)
     $course[$count] = '';
    $Course1 = $course[0];
    $Course2 = $course[1];
    $Course3 = $course[2];
    $Course4 = $course[3];
    $Course5 = $course[4];
    $Course6 = $course[5];
    
    $area = '';
    $_SESSION['textarea'] = $_POST['textarea'] ;
    $area = $_POST['textarea'];
    $area = trim($area);
    $out = preg_replace('/\s\n/', ',', $area);
    
    if($_POST['Save']) {  
        // Create connection
        $conn = new mysqli($host, $username, $password, $db_name);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "INSERT INTO tt1 VALUES ($studentID,'$studentname', CURDATE(),'$term','$y','$courses','$out')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        if($Num_courses > 0){   
            for($count = 0; $count < $Num_courses; $count++){
                $sql = "SELECT CN FROM tt2 where CN ='$course[$count]' AND term = '$term' AND year = '$y'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    $sql = "UPDATE tt2 SET Num = Num+1 WHERE CN = '$course[$count]' AND term = '$term' AND year = '$y'";  
            }else{
                    $sql = "INSERT INTO tt2 VALUES ('$course[$count]',1,'$term','$y')";
            }
            
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        }
        $conn->close();
        header('Location: print.php');
    } 
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
                        <td class="table_d">
                            <label class="requiredField1">Student Name: <?php echo $studentname;?></label>
                            <input name="studentname" type="hidden" value="<?php echo $studentname;?>">
                        </td>
                        <td class="table_d">
                            <label class="requiredField1">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Student ID:  <?php echo $studentID;?></label>
                            <input name="studentID" type="hidden" value="<?php echo $studentID;?>">    
                        </td>
                    </tr>
                    <tr> 
                        <td class="table_d">
                            <label class="requiredField1">&emsp;Term:  <?php echo $term;?></label>
                            <input name="term" type="hidden" value="<?php echo $term;?>">    
                        </td> 
                       <td class="table_d">
                            <label class="requiredField1">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Year:  <?php echo $y;?></label>
                            <input name="year" type="hidden" value="<?php echo $y;?>">    
                        </td> 
                    </tr>
                </table>  
                <h3><font color="#999">&emsp;Courses</font></h3>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&nbsp;Deficiencies&emsp;&emsp;</td> 
                        <td class="table_d1">CS214&emsp;&emsp;&emsp;&emsp;&nbsp;<input type="checkbox" name="course[]" value="CS214"></td>
                        <td class="table_d1">CS250&emsp;&emsp;&emsp;&emsp;&nbsp;<input type="checkbox" name="course[]" value="CS250"></td>
                        <td class="table_d1">CS310&emsp;&emsp;&emsp;&emsp;&nbsp;<input type="checkbox" name="course[]" value="CS350"></td>
                        <td class="table_d1">CS351&emsp;&emsp;&emsp;&emsp;&nbsp;<input type="checkbox" name="course[]" value="CS351"></td>
                        <td class="table_d1">CS355&emsp;&emsp;&emsp;&emsp;&nbsp;<input type="checkbox" name="course[]" value="CS355"></td>
                    </tr>
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&nbsp;Core- Programming&emsp;</td> 
                        <td class="table_d1">CS500&emsp;&emsp;&emsp;&emsp;&nbsp;IP<input type="checkbox" name="course[]" value="CS500"></td>
                    </tr>
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&emsp;Core - OS&emsp;</td> 
                        <td class="table_d1">CS410G&emsp;&emsp;OS<input type="checkbox" name="course[]" value="CS410"></td>
                        <td class="table_d1">CS512&emsp;&emsp;AOS<input type="checkbox" name="course[]" value="CS512"></td>
                        <td class="table_d1">CS513&emsp;&emsp;&nbsp;TOS<input type="checkbox" name="course[]" value="CS513"></td>
                    </tr>
                    <tr> 
                        <td class="table_d">&nbsp;&nbsp;&nbsp;Core - Networks&emsp;</td> 
                        <td class="table_d1">CS420G&emsp;&nbsp;&nbsp;&nbsp;CN<input type="checkbox" name="course[]" value="CS420"></td>
                        <td class="table_d1">CS556&emsp;&nbsp;&nbsp;&nbsp;ACN<input type="checkbox" name="course[]" value="CS556"></td>
                        <td class="table_d1">CS557&emsp;&emsp;TCN<input type="checkbox" name="course[]" value="CS557"></td>
                    </tr>                    
                    <tr> 
                        <td class="table_d">&emsp;&emsp;Core - AI&emsp;</td> 
                        <td class="table_d1">CS460G&emsp;&nbsp;&nbsp;&nbsp;&nbsp;AI<input type="checkbox" name="course[]" value="CS460"></td>
                        <td class="table_d1">CS548&emsp;&nbsp;&nbsp;&nbsp;&nbsp;AAI<input type="checkbox" name="course[]" value="CS548"></td>
                        <td class="table_d1">CS549&emsp;&emsp;&nbsp;TAI<input type="checkbox" name="course[]" value="CS549"></td>
                    </tr> 
                    <tr> 
                        <td class="table_d">&nbsp;&nbsp;&nbsp;&nbsp;Core - Graphics&nbsp;</td> 
                        <td class="table_d1">CS465G&emsp;&nbsp;&nbsp;&nbsp;CG<input type="checkbox" name="course[]" value="CS465"></td>
                        <td class="table_d1">CS566&emsp;&nbsp;&nbsp;&nbsp;ACG<input type="checkbox" name="course[]" value="CS566"></td>
                        <td class="table_d1">CS567&emsp;&emsp;TCG<input type="checkbox" name="course[]" value="CS567"></td>
                    </tr>
                    <tr> 
                        <td class="table_d">&emsp;&emsp;Core - DB&emsp;</td> 
                        <td class="table_d1">CS470G&emsp;&nbsp;&nbsp;&nbsp;DB<input type="checkbox" name="course[]" value="CS470"></td>
                        <td class="table_d1">CS522&emsp;&nbsp;&nbsp;&nbsp;ADB<input type="checkbox" name="course[]" value="CS522"></td>
                        <td class="table_d1">CS523&emsp;&emsp;TDB<input type="checkbox" name="course[]" value="CS523"></td>
                    </tr>
                        <td class="table_d">&emsp;&nbsp;&nbsp;Core - Arch&emsp;</td> 
                        <td class="table_d1">CS560&emsp;&emsp;&nbsp;&nbsp;CA<input type="checkbox" name="course[]" value="CS560"></td>
                        <td class="table_d1">CS561&emsp;&emsp;ACA<input type="checkbox" name="course[]" value="CS561"></td>
                        <td class="table_d1">CS562&emsp;&emsp;TCA<input type="checkbox" name="course[]" value="CS562"></td>
                    </tr>  
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&emsp;&nbsp;&nbsp;Electives&emsp;&emsp;&nbsp;&nbsp;</td> 
                        <td class="table_d1">CS412G&emsp;&emsp;&emsp;&nbsp;<input type="checkbox" name="course[]" value="CS412"></td>
                        <td class="table_d1">CS540&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="course[]" value="CS540"></td>
                        <td class="table_d1">CS575&emsp;&emsp;&emsp;&nbsp;IS<input type="checkbox" name="course[]" value="CS575"></td>
                        <td class="table_d1">CS585&emsp;&emsp;&nbsp;TSE<input type="checkbox" name="course[]" value="CS585"></td>
                        <td class="table_d1">CS590&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="course[]" value="CS590"></td>
                    </tr>
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&nbsp;&nbsp;&nbsp;Exit Options&emsp;&nbsp;&nbsp;</td> 
                        <td class="table_d1">CS600&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="course[]" value="CS600"></td>
                        <td class="table_d1">CS601&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="course[]" value="CS601"></td>
                        <td class="table_d1">CS595&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="course[]" value="CS595"></td>
                        <td class="table_d1">CS599&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="course[]" value="CS599"></td>
                    </tr>
                </table> 
                <h3><font color="#999">&emsp;Other Notes</font></h3>
                <textarea id="element_2" type="text" class="requiredField2" name="textarea">
                </textarea>
                <fieldset>&emsp;<input name="Save" id="submit" value="Save" class="button big round deep-red" type="submit"/>
                </fieldset>
            </form>  
        </div>
        </div>   
    </body>
</html>