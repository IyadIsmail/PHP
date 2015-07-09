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
    echo $result ."<br>";
    $id = substr($result, 0, 5);
    $course = substr($result, 5, 5);
    $name = substr($result, 10);
    echo $id ."<br>";
    echo $course ."<br>";
    echo $name ."<br>";
    }
    fclose($handle);
}
?>
