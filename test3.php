<?php
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="wiu"; // Database name 

$row = 1;
if (($handle = fopen("Student Course List.csv", "r")) !== FALSE) {
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
    //echo $result;
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
    //$out = str_replace('<br>', ' ', $course);
    if ($id != 0){
                $sql = "SELECT sid FROM test1 where sid ='$id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    $sql = "INSERT INTO test2 VALUES ($id,'$fname','$lname','$course','spring','2015')";  
                }else{
                    $sql = "INSERT INTO test1 VALUES ($id,'$lname','$fname')";
                    $sql1 = "INSERT INTO test2 VALUES ($id,'$fname','$lname','$course','spring','2015')";
                }
                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } 
                if ($conn->query($sql1) === TRUE) {
                    //echo "New record created successfully";
                } 
        }
    }
        $conn->close();
    fclose($handle);
}
?>
