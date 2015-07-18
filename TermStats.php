<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

if(isset($_POST["iebugaround"])){
    $_SESSION['Term'] = $_POST['Term'];
    $_SESSION['Year'] = $_POST['Year'];
    if(isset($_POST['Stats'])){
        $_SESSION['Stats'] = $_POST['Stats'];
        header('Location: ShowStats.php');
    }else{
        header('Location: TermStats.php');
    }
}

?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
        <link rel="stylesheet" type="text/css" href="Styles/print.css" /> 
        <link href="Styles/style.css" rel="stylesheet" type="text/css" />
        <title>Term Statistics</title>
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
            <form action="#" method="post">
                <input name="iebugaround" type="hidden" value="1">
                <table>
                    <tr> 
                        <td>
                            <label>&emsp;&emsp;&emsp;Term</label>
                            <fieldset class="fieldset4">&emsp;&emsp;&emsp;&nbsp;<select name="Term">
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
                <table class=requiredField1>
                    <tr>
                        <td class = table_d1 width = 250>
                            <input type= radio name=Stats value="1"> Courses Advised</td>
                    </tr>
                    <tr>
                        <td class = table_d1 width = 250>
                            <input type= radio name=Stats value="2"> Courses Taken</td>
                    </tr>
                </table>  
                <fieldset>&emsp;<input name="Next" id="submit" value="Next" class="button big round deep-red" type="submit"/>
                </fieldset>
            </form>  
        </div>
        </div>   
    </body>
</html>




