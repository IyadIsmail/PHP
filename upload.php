<?php
session_start();
require_once 'config.php';
require_once 'cookies.php';
$error = 0;
if(isset($_POST["iebugaround"])){
    if ($_POST['Upload_File']){
        if(!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE){
            header('Location: Upload.php');
        }else{
            $_SESSION['FileTerm'] = $_POST['FileTerm'];
            $_SESSION['FileYear'] = $_POST['FileYear'];
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
            $uploadOk = 1;
            $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check file size
            if ($_FILES['fileToUpload']['size'] > 500000) {
                //echo "Sorry, your file is too large.";
                $uploadOk = 0;
                $error = 1;
            }
            // Allow certain file formats
            elseif($FileType != 'csv') {
                //echo "Sorry, only csv files are allowed.";
                $uploadOk = 0;
                $error = 2;
            }
            else{
                $FileName = $_FILES['fileToUpload']['name'];
                if ($FileName != "Student Course List.csv") {
                    $uploadOk = 0;
                    $error = 3;
                }
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {  
                if ($error == 1){
                    echo '<script>';
                    echo 'alert("Sorry, your file is too large.");';
                    echo 'location.href="Upload.php"';
                    echo '</script>';
                }elseif($error == 2){
                    echo '<script>';
                    echo 'alert("Sorry, only csv files are allowed.");';
                    echo 'location.href="Upload.php"';
                    echo '</script>';                    
                }elseif($error == 3){
                    echo '<script>';
                    echo 'alert("Sorry, incorrect filename.");';
                    echo 'location.href="Upload.php"';
                    echo '</script>';                    
                }else{
                    $error = 0;
                }
            // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
                //echo "The file ". basename( $_FILES['fileToUpload']['name']). " has been uploaded.";
                    header('Location: main.php');
            } else {
                echo '<script>';
                echo 'alert("Sorry, there was an error uploading your file.");';
                echo 'location.href="Upload.php"';
                echo '</script>';                
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
        <title>Upload File</title>
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
                <li class="hide-from-printer"><a href="main.php">Statistics</a>
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
            <br>
            <br>
        <div id="content_area">
            <form action="#" method="post" enctype="multipart/form-data">
                <input name="iebugaround" type="hidden" value="1">
                <table>
                    <tr>
                        <td>
                            <label>&emsp;Select File to upload:</label>
                            <fieldset class="fieldset3"><input type="file" name="fileToUpload" class="requiredField5" value ="1"/></fieldset>
                        </td> 
                        <td>
                            <label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Term</label>
                            <fieldset class="fieldset3">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<select name="FileTerm">
                                                            <option value="Spring">Spring</option>
                                                            <option value="Summer">Summer</option>
                                                            <option value="Fall">Fall</option>
                                                        </select></fieldset>
                        </td>
                        <td>
                            <label>&emsp;&nbsp;&nbsp;Year</label>
                            <fieldset class="fieldset3">&emsp;&emsp;<select name="FileYear">
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




