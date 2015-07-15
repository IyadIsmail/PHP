<?php
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="wiu"; // Database name 

$row = 1;
$filename = 'uploads/Student Course List.csv';
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
                $sql = "SELECT sid FROM test1 where sid ='$id' AND fname = '$fname' And lname ='$lname'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    $sql = "SELECT sid FROM test2 where sid ='$id' AND fname = '$fname' And lname ='$lname' AND course='$course'";
                    $result1 = $conn->query($sql);
                    if ($result->num_rows == 0){
                        $sql = "INSERT INTO test2 VALUES ($id,'$fname','$lname','$course','spring','2015')";  
                        if ($conn->query($sql) === TRUE) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        } 
                    }
                }else{
                    $sql = "INSERT INTO test1 VALUES ($id,'$fname','$lname')";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }                    
                    $sql = "INSERT INTO test2 VALUES ($id,'$fname','$lname','$course','spring','2015')";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
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
    echo "The file $filename does not exist";
}
?>
