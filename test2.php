<?php
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="wiu"; // Database name 

$row = 1;
if (($handle = fopen("Uploads/Student Course List.csv", "r")) !== FALSE) {
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
    echo $result ."<br>";
    $id = substr($result, 0, 5);
    $course = substr($result, 5, 5);
    $name = substr($result, 10);
    $findme = '-';
    $pos = strpos($name, $findme);
    $lname = substr($name,0,$pos);
    $fname = substr($name,$pos+1);
    $fname = str_replace('-',' ',$fname);

    echo $id ."<br>";
    echo $course ."<br>";
    echo $lname ."<br>";
    echo $name ."<br>";
    echo $fname ."<br>";
    }
    fclose($handle);
}
?>