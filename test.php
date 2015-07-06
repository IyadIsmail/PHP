<?php
if ($_POST['previous']) {
     header('Location: config.php');
} else if($_POST['submit']) {
      header('Location: NewStudentNotes.php');
} 
?>

    if($_POST['Save']) {  
        // Create connection
        $conn = new mysqli($host, $username, $password, $db_name);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
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