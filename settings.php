<?php
    $host ="feenix-mariadb.swin.edu.au";
    $user ="s105241532";
    $pass ="060305";
    $sql_db = "s105241532_db";

    $conn = mysqli_connect($host, $user, $pass, $sql_db) ;
    if($conn){
        echo"Connection successful";
        mysqli_close($conn);
    }
    else{
        echo"Connection failed";
    }   
?>