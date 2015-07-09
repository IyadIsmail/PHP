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
            $data[$c] = str_replace(' ','',$data[$c]);
            $data[1] = substr($data[1], 0, 8);
            if ($data[3] != '' & substr($data[1], 0, 2) == 'CS'){
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
    $name = str_replace('<br>', ' ', $name);
    $out = str_replace('<br>', ' ', $course);
    if ($id != '0'){
                $sql = "SELECT id FROM tt3 where id ='$id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    $sql = "UPDATE tt3 SET courses = concat(courses,' ','$out') WHERE id = '$id'";  
                }else{
                    $sql = "INSERT INTO tt3 VALUES ('$id','$name','$out')";
                }
                if ($conn->query($sql) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
    }
        $conn->close();
    fclose($handle);
}
?>