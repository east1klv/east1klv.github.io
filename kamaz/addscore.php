<?php 
        // Create connection
        // Statement: mysqli_connect(host,username,password,dbname)
        // NOTICE: se lo script è installato nello stesso server del Data Base, host->localhost 
        $db = mysql_connect('sql11.freesqldatabase.com', 'sql11190992', 'EAhHptAQpF') or die('Could not connect: ' . mysql_error()); 
        mysql_select_db('sql11190992') or die('Could not select database');
        mysql_query("set names utf8", $db);
        //mysql_query("SET NAMES 'cp1251'");
        //mysql_query("SET CHARACTER SET 'cp1251'");    
        // Strings must be escaped to prevent SQL injection attack. 
        $name = mysql_real_escape_string($_GET['name'], $db);
        $company = mysql_real_escape_string($_GET['company'], $db); 
        $post = mysql_real_escape_string($_GET['post'], $db); 
        $phone = mysql_real_escape_string($_GET['phone'], $db); 
        $color = mysql_real_escape_string($_GET['color'], $db);  
        $score = mysql_real_escape_string($_GET['score'], $db);  
        $md5key = mysql_real_escape_string($_GET['md5key'], $db); 
        $secretKey = "MyKey"; // It is the same Unity3D posts
        $secretSum = $name.$score.$secretKey;
        
          if (md5($secretSum) === $md5key) {
        echo "Yes! It is the right MD5, let's write on the database";
       // Check if the name already exists 
        $checkname = mysql_query("SELECT 1 FROM scores WHERE name='$name' LIMIT 1");
        // ------------------------------------------------
        // if exists --------------------------------------
        //-------------------------------------------------
        if (mysql_fetch_row($checkname)) {  
        // Check score from database
        $checkscore = mysql_query("SELECT score FROM scores WHERE name='$name'");
        $checkscorerow = mysql_fetch_array($checkscore);
        echo "Score from the database: ".$checkscorerow['score'];// Debug Code
         
                // if the new score are better than old one
                if ($score < $checkscorerow['score']){
                    echo "<br>Great! New personal record";
                     
                    // Update the existing name with new score
                    // AGGIORNA db_name SETTA il valore di score dove name è uguale a quello ottenuto con GET
                    $queryupdate = "UPDATE scores SET score=$score WHERE name='$name'";
                    $colorupdate = "UPDATE scores SET color=$color WHERE name='$name'";     
                    $resultupdate = mysql_query($queryupdate) or die('Query failed: ' . mysql_error());
                    $resultupdate2 = mysql_query($colorupdate) or die('Query failed: ' . mysql_error());
                    mysqli_close($db); // Close the connection with the database
                    echo "<br>Connection Closed!"; 
                    break; // stop the execution of the script
                } else {
                    echo "<br>Bad! Are you tired?";
                    mysqli_close($db); // Close the connection with the database
                    echo "<br>Connection Closed!"; 
                    break; // stop the execution of the script
                }   
          
        // ------------------------------------------------
        // if not exists ----------------------------------
        // ------------------------------------------------
        } else {
                echo "New Player";// Debug Code
                // Insert a new name and a new score 
                $query = "INSERT INTO scores VALUES (NULL, '$name', '$company', '$post', '$phone', '$color', '$score');"; 
                $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
        }      
           
        mysqli_close($db); // Close the connection with the database
        echo "<br>Connection Closed!"; 
         
    } else {
        // Debug Code
        echo "Bad MD5! Who are you?";
        echo "<br>Data received: ".$name." ".$score." ".$md5key;
        echo "<br>MD5 calculated by the server: ".md5($secretSum);
        break;
    }
?>