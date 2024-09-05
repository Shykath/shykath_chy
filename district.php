<?php
include_once "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $division_id =$_GET['division_id'];
    $sql = "SELECT * from districts where division_id='$division_id'";
    $districts = $con->query($sql);
    if ($districts->num_rows > 0) {
        $data = [];
        while ($row = $districts->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}


?>