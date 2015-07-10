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
$pointer1 = 0;
//Used to highlight course
$Courses_Finished = array(); 
//To get Finished courses
// Create connection
mysql_connect($host, $username, $password) or
    die("Could not connect: " . mysql_error());
mysql_select_db($db_name);
$result = mysql_query("SELECT test2.course FROM test1,test2 where test1.sid = $studentID AND test1.sid = test2.sid");
if (mysql_num_rows($result) > 0) { 
    $cor = '';
    while($row = mysql_fetch_array($result)) { 
        $cor = $cor.$row['course'].'-';
        //Used to highlight course
        $Courses_Finished[$row['course']] = 1;
    }
    $cor = substr($cor, 0, -1);
    $pointer1 = 1;
} 

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
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>"Advising Notes for Existing Student"</title>
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
        <link rel="stylesheet" type="text/css" href="Styles/print.css" /> 
        <link href="Styles/style.css" rel="stylesheet" type="text/css" />
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
            $studentID = $_SESSION['studentID'];
            // Create connection
            mysql_connect($host, $username, $password) or
                die("Could not connect: " . mysql_error());
            mysql_select_db($db_name);
            if ($pointer1 ==1) { 
                echo "<h3><font color=#999>&emsp;Finished Courses</font></h3>";
                echo "<table class=requiredField3 border = 1>";
                echo "<tr>"; 
                echo "<td class = table_d1 width = 250 style = padding-left:10px>".$cor."</td>"; 
                echo "</tr>"; 
                echo "</table>"; 
            } 
            $result = mysql_query("SELECT date,ca,term,year,n FROM tt1 where sid = $studentID");
            if (mysql_num_rows($result) > 0) { 
                echo "<h3><font color=#999>&emsp;Previous Notes</font></h3>";
                echo "<table class=requiredField3 border = 1>"; 
                echo "<tr>";
                echo "<td class = table_d1 width = 120><center>Date</center></td>";
                echo "<td class = table_d1 width = 250><center>Courses Advised</center></td>";
                echo "<td class = table_d1 width = 100><center>Term</center></td>";
                echo "<td class = table_d1 width = 100><center>Year</center></td>";
                echo "<td class = table_d1 width = 250><center>Other Notes</center></td>";                
                echo "</tr>"; 
                while($row = mysql_fetch_array($result)) { 
                    $cor = str_replace(' ', '<br>', $row['ca']);
                    $out = str_replace(',', '<br>', $row['n']);
                    echo "<tr>"; 
                    echo "<td class = table_d1 width = 120><center>".$row['date']."<br>"."</center></td>"; 
                    echo "<td class = table_d1 width = 250 style = padding-left:10px>".nl2br($cor)."<br>"."</td>"; 
                    echo "<td class = table_d1 width = 100><center>".$row['term']."<br>"."</center></td>"; 
                    echo "<td class = table_d1 width = 100><center>".$row['year']."<br>"."</center></td>"; 
                    echo "<td class = table_d1 width = 250 style = padding-left:10px>".nl2br($out)."<br>"."</td>"; 
                    echo "</tr>"; 
                } 
                echo "</table>"; 
            }     
            ?>
            <h3><font color="#999">&emsp;Courses</font></h3>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&nbsp;Deficiencies&emsp;&emsp;</td> 
                        <?php if(!isset($Courses_Finished['CS214'])){
                            echo "<td class=table_d1>CS214&emsp;&emsp;&emsp;&emsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS214></td>";
                            }else{
                            echo "<td class=table_d5>CS214&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS250'])){
                            echo "<td class=table_d1>CS250&emsp;&emsp;&emsp;&emsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS250></td>";
                            }else{
                            echo "<td class=table_d5>CS250&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS310'])){
                            echo "<td class=table_d1>CS310&emsp;&emsp;&emsp;&emsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS310></td>";
                            }else{
                            echo "<td class=table_d5>CS310&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</td>";                                    
                            }
                        ?>                        
                        <?php if(!isset($Courses_Finished['CS351'])){
                            echo "<td class=table_d1>CS351&emsp;&emsp;&emsp;&emsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS351></td>";
                            }else{
                            echo "<td class=table_d5>CS351&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS355'])){
                            echo "<td class=table_d1>CS355&emsp;&emsp;&emsp;&emsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS355></td>";
                            }else{
                            echo "<td class=table_d5>CS355&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</td>";                                    
                            }
                        ?>
                    </tr>
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&nbsp;Core- Programming&emsp;</td> 
                        <?php if(!isset($Courses_Finished['CS500'])){
                            echo "<td class=table_d1>CS500&emsp;&emsp;&emsp;&emsp;&nbsp;IP";
                            echo "<input type=checkbox name=course[] value=CS500></td>";
                            }else{
                            echo "<td class=table_d5>CS500&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;IP</td>";                                    
                            }
                        ?>
                    </tr>
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&emsp;Core - OS&emsp;</td>
                        <?php if(!isset($Courses_Finished['CS410'])){
                            echo "<td class=table_d1>CS410G&emsp;&emsp;OS";
                            echo "<input type=checkbox name=course[] value=CS410></td>";
                            }else{
                            echo "<td class=table_d5>CS410G&emsp;&emsp;OS</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS512'])){
                            echo "<td class=table_d1>CS512&emsp;&emsp;AOS";
                            echo "<input type=checkbox name=course[] value=CS512></td>";
                            }else{
                            echo "<td class=table_d5>CS512&emsp;&emsp;AOS</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS513'])){
                            echo "<td class=table_d1>CS513&emsp;&emsp;&nbsp;TOS";
                            echo "<input type=checkbox name=course[] value=CS513></td>";
                            }else{
                            echo "<td class=table_d5>CS513&emsp;&emsp;&nbsp;TOS</td>";                                    
                            }
                        ?>
                    </tr>
                    <tr> 
                        <td class="table_d">&nbsp;&nbsp;&nbsp;Core - Networks&emsp;</td> 
                        <?php if(!isset($Courses_Finished['CS420'])){
                            echo "<td class=table_d1>CS420G&emsp;&nbsp;&nbsp;&nbsp;CN";
                            echo "<input type=checkbox name=course[] value=CS420></td>";
                            }else{
                            echo "<td class=table_d5>CS420G&emsp;&nbsp;&nbsp;&nbsp;CN</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS556'])){
                            echo "<td class=table_d1>CS556&emsp;&nbsp;&nbsp;&nbsp;ACN";
                            echo "<input type=checkbox name=course[] value=CS556></td>";
                            }else{
                            echo "<td class=table_d5>CS556&emsp;&nbsp;&nbsp;&nbsp;ACN</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS557'])){
                            echo "<td class=table_d1>CS557&emsp;&emsp;TCN";
                            echo "<input type=checkbox name=course[] value=CS557></td>";
                            }else{
                            echo "<td class=table_d5>CS557&emsp;&emsp;TCN</td>";                                    
                            }
                        ?>
                    </tr>                    
                    <tr> 
                        <td class="table_d">&emsp;&emsp;Core - AI&emsp;</td> 
                        <?php if(!isset($Courses_Finished['CS460'])){
                            echo "<td class=table_d1>CS460G&emsp;&nbsp;&nbsp;&nbsp;&nbsp;AI";
                            echo "<input type=checkbox name=course[] value=CS460></td>";
                            }else{
                            echo "<td class=table_d5>CS460G&emsp;&nbsp;&nbsp;&nbsp;&nbsp;AI</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS548'])){
                            echo "<td class=table_d1>CS548&emsp;&nbsp;&nbsp;&nbsp;&nbsp;AAI";
                            echo "<input type=checkbox name=course[] value=CS548></td>";
                            }else{
                            echo "<td class=table_d5>CS548&emsp;&nbsp;&nbsp;&nbsp;&nbsp;AAI</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS549'])){
                            echo "<td class=table_d1>CS549&emsp;&emsp;&nbsp;TAI";
                            echo "<input type=checkbox name=course[] value=CS549></td>";
                            }else{
                            echo "<td class=table_d5>CS549&emsp;&emsp;&nbsp;TAI</td>";                                    
                            }
                        ?>                    
                    </tr> 
                    <tr> 
                        <td class="table_d">&nbsp;&nbsp;&nbsp;&nbsp;Core - Graphics&nbsp;</td> 
                        <?php if(!isset($Courses_Finished['CS465'])){
                            echo "<td class=table_d1>CS465G&emsp;&nbsp;&nbsp;&nbsp;CG";
                            echo "<input type=checkbox name=course[] value=CS465></td>";
                            }else{
                            echo "<td class=table_d5>CS465G&emsp;&nbsp;&nbsp;&nbsp;CG</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS566'])){
                            echo "<td class=table_d1>CS566&emsp;&nbsp;&nbsp;&nbsp;ACG";
                            echo "<input type=checkbox name=course[] value=CS566></td>";
                            }else{
                            echo "<td class=table_d5>CS566&emsp;&nbsp;&nbsp;&nbsp;ACG</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS567'])){
                            echo "<td class=table_d1>CS567&emsp;&emsp;TCG";
                            echo "<input type=checkbox name=course[] value=CS567></td>";
                            }else{
                            echo "<td class=table_d5>CS567&emsp;&emsp;TCG</td>";                                    
                            }
                        ?>                     
                    </tr>
                    <tr> 
                        <td class="table_d">&emsp;&emsp;Core - DB&emsp;</td> 
                        <?php if(!isset($Courses_Finished['CS470'])){
                            echo "<td class=table_d1>CS470G&emsp;&nbsp;&nbsp;&nbsp;DB";
                            echo "<input type=checkbox name=course[] value=CS470></td>";
                            }else{
                            echo "<td class=table_d5>CS470G&emsp;&nbsp;&nbsp;&nbsp;DB</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS522'])){
                            echo "<td class=table_d1>CS522&emsp;&nbsp;&nbsp;&nbsp;ADB";
                            echo "<input type=checkbox name=course[] value=CS522></td>";
                            }else{
                            echo "<td class=table_d5>CS522&emsp;&nbsp;&nbsp;&nbsp;ADB</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS523'])){
                            echo "<td class=table_d1>CS523&emsp;&emsp;TDB";
                            echo "<input type=checkbox name=course[] value=CS523></td>";
                            }else{
                            echo "<td class=table_d5>CS523&emsp;&emsp;TDB</td>";                                    
                            }
                        ?>                     
                    </tr>
                        <td class="table_d">&emsp;&nbsp;&nbsp;Core - Arch&emsp;</td> 
                        <?php if(!isset($Courses_Finished['CS560'])){
                            echo "<td class=table_d1>CS560&emsp;&emsp;&nbsp;&nbsp;CA";
                            echo "<input type=checkbox name=course[] value=CS560></td>";
                            }else{
                            echo "<td class=table_d5>CS560&emsp;&emsp;&nbsp;&nbsp;CA</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS561'])){
                            echo "<td class=table_d1>CS561&emsp;&emsp;ACA";
                            echo "<input type=checkbox name=course[] value=CS561></td>";
                            }else{
                            echo "<td class=table_d5>CS561&emsp;&emsp;ACA</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS562'])){
                            echo "<td class=table_d1>CS562&emsp;&emsp;TCA";
                            echo "<input type=checkbox name=course[] value=CS562></td>";
                            }else{
                            echo "<td class=table_d5>CS562&emsp;&emsp;TCA</td>";                                    
                            }
                        ?>                    
                    </tr>  
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&emsp;&nbsp;&nbsp;Electives&emsp;&emsp;&nbsp;&nbsp;</td> 
                        <?php if(!isset($Courses_Finished['CS412'])){
                            echo "<td class=table_d1>CS412G&emsp;&emsp;&emsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS412></td>";
                            }else{
                            echo "<td class=table_d5>CS412G&emsp;&emsp;&emsp;&emsp;&nbsp;</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS540'])){
                            echo "<td class=table_d1>CS540&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS540></td>";
                            }else{
                            echo "<td class=table_d5>CS540&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS575'])){
                            echo "<td class=table_d1>CS575&emsp;&emsp;&emsp;&nbsp;IS";
                            echo "<input type=checkbox name=course[] value=CS575></td>";
                            }else{
                            echo "<td class=table_d5>CS575&emsp;&emsp;&emsp;&emsp;&nbsp;IS</td>";                                    
                            }
                        ?> 
                        <?php if(!isset($Courses_Finished['CS585'])){
                            echo "<td class=table_d1>CS585&emsp;&emsp;&nbsp;TSE";
                            echo "<input type=checkbox name=course[] value=CS585></td>";
                            }else{
                            echo "<td class=table_d5>CS585&emsp;&emsp;&emsp;&nbsp;TSE</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS590'])){
                            echo "<td class=table_d1>CS590&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS590></td>";
                            }else{
                            echo "<td class=table_d5>CS590&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;</td>";                                    
                            }
                        ?>                         
                    </tr>
                </table>
                <br>
                <table class="requiredField1" border="1">
                    <tr> 
                        <td class="table_d">&emsp;&nbsp;&nbsp;&nbsp;Exit Options&emsp;&nbsp;&nbsp;</td> 
                        <?php if(!isset($Courses_Finished['CS600'])){
                            echo "<td class=table_d1>CS600&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS600></td>";
                            }else{
                            echo "<td class=table_d5>CS600&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS601'])){
                            echo "<td class=table_d1>CS601&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS601></td>";
                            }else{
                            echo "<td class=table_d5>CS601&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";                                    
                            }
                        ?>
                        <?php if(!isset($Courses_Finished['CS595'])){
                            echo "<td class=table_d1>CS595&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS595></td>";
                            }else{
                            echo "<td class=table_d5>CS595&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";                                    
                            }
                        ?> 
                        <?php if(!isset($Courses_Finished['CS599'])){
                            echo "<td class=table_d1>CS599&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<input type=checkbox name=course[] value=CS599></td>";
                            }else{
                            echo "<td class=table_d5>CS599&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";                                    
                            }
                        ?>                          
                    </tr>
                </table> 
                <h3><font color="#999">&emsp;Other Notes</font></h3>
                <textarea id="element_2" type="text" class="requiredField2" name="textarea">
                </textarea>
                <fieldset>&emsp;<input name="Save" id="submit" value="Save" class="button big round deep-red" type="submit"/>
                </fieldset>
            </form>  
        </div>
    </body>
</html>

