<?php
include "connect.php";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $country_id =$_GET['country_id'];
    $sql = "SELECT * from divisions where country_id='$country_id'";
    $divisions = $con->query($sql);
    if ($divisions->num_rows > 0) {
        $data = [];
        while ($row = $divisions->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}


?>