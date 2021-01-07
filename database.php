<?php
    $mysqli = new mysqli("localhost","cse716-group8-project4","cse716project4","controllerdb");
 
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
?>