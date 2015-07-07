<?php
session_start();
require_once 'cookies.php';
require_once 'config.php';

if(isset($_POST["iebugaround"])){
    $term = $_POST['term'];
    $year = $_POST['year'];
    $_SESSION['term'] = $_POST['term'];
    $_SESSION['year'] = $_POST['year'];
    if ($year == 'y'){
        $y = date('Y');
    }elseif ($year == 'y1'){
        $y1 = date('Y');
        $y = $y1+1;
    }else{
        $y1 = date('Y');
        $y = $y1+2;
    }
    if ($_POST['Show']) {
     header('Location: ShowStats.php');
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
                            <fieldset class="fieldset4">&emsp;&emsp;&emsp;&nbsp;<select name="term">
                                                            <option value="Spring">Spring</option>
                                                            <option value="Summer">Summer</option>
                                                            <option value="Fall">Fall</option>
                                                        </select></fieldset>
                        </td>
                        <td>
                            <label>&nbsp;Year</label>
                            <fieldset class="fieldset3"><select name="year">
                                                            <option value="y"><?php echo $y; ?></option> 
                                                            <option value="y1"><?php echo $y1; ?></option>
                                                            <option value="y2"><?php echo $y2; ?></option>       
                                                        </select></fieldset>
                        </td>                        
                    </tr>
                </table>  
                <fieldset>&emsp;<input name="Show" id="submit" value="Show" class="button big round deep-red" type="submit"/>
                </fieldset>
            </form>  
        </div>
        </div>   
    </body>
</html>


