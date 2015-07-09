<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>"Advising Notes for New Student"</title>
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
        <link rel="stylesheet" type="text/css" href="Styles/print.css" /> 
        <link href="Styles/style.css" rel="stylesheet" type="text/css" />
        <script language="javascript">
            function printpage()
            {
                window.print();
            }
        </script>
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
                <li class="hide-from-printer"><a href="#">Statistics</a>
                </li>
                <li class="hide-from-printer"><a href="logout.php">Sign Out</a>
                </li>
            </ul>
        <div id="content_area">
            <form action="aaa1.php" method="post">
            <input name="iebugaround" type="hidden" value="1">
            <div>  
            <center><h3><font color="#999">Western Illinois University<br>Advising Form</font></center>
            </div>						
                <center><label>Other Notes </label></center>
                <textarea id="element_2" type = "text" class="requiredField2" name="textarea">
                </textarea>
                <br>
            <br>
            <table>
                <tr> 
                    <td>
                        <fieldset><input name="submit" id="submit" value="Save" class="button big round deep-red hide-from-printer" type="submit"/>
                    </td>                
                </tr>
            </table>    
            </form>  
        </div>
    </body>
</html>

