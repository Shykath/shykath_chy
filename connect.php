<?php
    $hostname = "http://localhost/crud";
    $con = new mysqli('localhost', 'root', '', 'info');

    if (!$con){
        die(mysqli_error($con));
    }
?>