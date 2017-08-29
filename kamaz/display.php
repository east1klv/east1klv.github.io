<?php
   // Connect to database
    // NOTICE: se lo script è installato nello stesso server del Data Base, mysql_host->localhost 
    $database = mysql_connect('sql11.freesqldatabase.com', 'sql11190992', 'EAhHptAQpF') or die('Could not connect: ' . mysql_error()); 
    mysql_select_db('sql11190992') or die('Could not select database');
    //mysql_query("set names utf8", $database);
    //mysql_query ("set_client='utf8'", $database);
    //mysql_query ("set character_set_results='utf8'", $database);
    //mysql_query ("set collation_connection='utf8_general_ci'");
    //mysql_query ("SET NAMES utf8", $database);
    mysql_set_charset('utf8');
    // Send a query, order the records in descending 
    $query = "SELECT * FROM scores ORDER BY score ASC LIMIT 10";
    // Store the result inside a variable or If fails send an error message
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
   
    // How many rows there are inside the result
    $num_results = mysql_num_rows($result);  
    // Loop 5 times, remember some line above that LIMIT 5
    for($i = 0; $i < $num_results; $i++)
    {
        $row = mysql_fetch_array($result);
     
     //    echo $row['name'] . "\t" . date("H:i:s.u",$row['score']). "\n";
     echo json_encode($row['name'] . ":" . $row['company'] . ":"  . $row['post'] . ":"  . $row['phone'] . ":" . $row['color'] . ":" . $row['score'],  JSON_UNESCAPED_UNICODE);
     }
   
?>