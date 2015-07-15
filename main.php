<?php
session_start();
require_once 'config.php';
require_once 'cookies.php';
$title = "Advising Notes";
$content = '';
$row = 1;
$filename = 'uploads/Student Course List.csv';
$FileTerm = '';
$FileYear = '';
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
        <link rel="stylesheet" type="text/css" href="Styles/print.css" />    
        <title><?php echo $title; ?></title>
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
                <?php echo $content; ?>
                <?php 
                if(isset($_SESSION['FileTerm'])){
                    $FileTerm = $_SESSION['FileTerm']; 
                    $FileYear = $_SESSION['FileYear'];
                    if ($FileYear == 'y'){
                        $FileY = date('Y');
                    }elseif ($FileYear == 'y1'){
                        $y1 = date('Y');
                        $FileY = $y1+1;
                    }else{
                        $y1 = date('Y');
                        $FileY = $y1+2;
                    }
                }
                if ($FileTerm != ''){
                    if (file_exists($filename)) {
                    if (($handle = fopen("uploads/Student Course List.csv", "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        $row++;
                        for ($c=0; $c < $num; $c++) {
                            $result = '';
                            $data[4] = str_replace(' ','-',$data[4]);
                            $data[$c] = str_replace(' ','',$data[$c]);
                            $data[1] = substr($data[1], 0, 8);
                            if ($data[3] != '' & substr($data[1], 0, 2) == 'CS' & substr($data[7],0,4) == 'GRAD'){
                                $result = $result.' '.$data[3].$data[1].$data[4]."<br>";
                            }  
                        }
                    // Create connection
                    $conn = new mysqli($host, $username, $password, $db_name);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                    $id = substr($result, 0, 5);
                    $course = substr($result, 5, 5);
                    $name = substr($result, 10);
                    $findme = '-';
                    $pos = strpos($name, $findme);
                    $lname = substr($name,0,$pos);
                    $fname = substr($name,$pos+1);
                    $pos1 = strpos($fname, $findme);
                    if ($pos1 != null){
                        $fname = substr($fname,0,$pos1);
                    }
                    $fname = str_replace('<br>', '', $fname);
                    if ($id != 0){
                                $sql = "SELECT sid FROM Grad_Students where SID ='$id' AND Fname = '$fname' And Lname ='$lname'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) { 
                                    $sql = "SELECT SID FROM Grad_Courses where SID ='$id' AND Fname = '$fname' And Lname ='$lname' AND Course_Name='$course'";
                                    $result1 = $conn->query($sql);
                                    if ($result->num_rows == 0){
                                        $sql = "INSERT INTO Grad_Courses VALUES ($id,'$fname','$lname','$course','$FileTerm','$FileY')";  
                                        if ($conn->query($sql) === TRUE) {
                                            //echo "New record created successfully";
                                        } else {
                                            echo "Error: " . $sql . "<br>" . $conn->error;
                                        } 
                                    }
                                }else{
                                    $sql = "INSERT INTO Grad_Students VALUES ($id,'$fname','$lname')";
                                    if ($conn->query($sql) === TRUE) {
                                        //echo "New record created successfully";
                                    } else {
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }                    
                                    $sql = "INSERT INTO Grad_Courses VALUES ($id,'$fname','$lname','$course','$FileTerm','$FileY')";
                                    if ($conn->query($sql) === TRUE) {
                                        //echo "New record created successfully";
                                    } else {
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }                    
                                }
                            }
                        }
                        $conn->close();
                        fclose($handle);
                        }
                    } else {
                        $filename = substr($filename,8);
                        echo "<h3><font color=#999>&emsp;Upload $filename </font></h3>";
                    }
                }
                ?>
            </div>
        </div>   
    </body>
</html>


