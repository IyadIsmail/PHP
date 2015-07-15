<?php
session_start();
require_once 'config.php';
if(isset($_POST["iebugaround"])){
    if ($_POST['Upload_File']){
        if(!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE){
            header('Location: test5.php');
        }else{
            $_SESSION['Term'] = $_POST['Term'];
            $_SESSION['Year'] = $_POST['Year'];
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
            $uploadOk = 1;
            $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check file size
            if ($_FILES['fileToUpload']['size'] > 500000) {
                echo "Sorry, your file is too large.";
                //header('Location: test5.php');
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($FileType != 'csv') {
                echo "Sorry, only csv files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
                echo "The file ". basename( $_FILES['fileToUpload']['name']). " has been uploaded.";
                header('Location: test3.php');
            } else {
                echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
                <li class="hide-from-printer"><a href="Statistics.php">Statistics</a>
                    <ul>
                        <li class="hide-from-printer"><a href="GeneralStats.php" class="hide-from-printer">General Statistics</a></li>
                        <li class="hide-from-printer"><a href="TermStats.php" class="hide-from-printer">Term Statistics</a></li>
                    </ul>                     
                </li>
                <li class="hide-from-printer"><a href="logout.php">Sign Out</a>
                </li>
            </ul>
            <br>
            <br>
        <div id="content_area">
            <form action="#" method="post" enctype="multipart/form-data">
                <input name="iebugaround" type="hidden" value="1">
                <table>
                    <tr>
                        <td>
                            <label>&emsp;Select File to upload:</label>
                            <fieldset class="fieldset3"><input type="file" name="fileToUpload" class="requiredField1" value ="1"/></fieldset>
                        </td> 
                        <td>
                            <label>&emsp;&emsp;&emsp;Term</label>
                            <fieldset class="fieldset3">&emsp;&emsp;&emsp;&nbsp;<select name="Term">
                                                            <option value="Spring">Spring</option>
                                                            <option value="Summer">Summer</option>
                                                            <option value="Fall">Fall</option>
                                                        </select></fieldset>
                        </td>
                        <td>
                            <label>&nbsp;Year</label>
                            <fieldset class="fieldset3"><select name="Year">
                                                            <option value="y"><?php echo $y; ?></option> 
                                                            <option value="y1"><?php echo $y1; ?></option>
                                                            <option value="y2"><?php echo $y2; ?></option>      
                                                        </select></fieldset>
                        </td> 
                    </tr>
                </table> 
                <fieldset>&emsp;<input name="Upload_File" id="submit" value="Upload File" class="button big round deep-red" type="submit"/>
            </form>  
        </div>
    </body>
</html>




