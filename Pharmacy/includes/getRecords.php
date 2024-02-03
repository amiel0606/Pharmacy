<?php
    require_once 'dbCon.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $sql = "SELECT tbl_records.*, tbl_cart.datePurchased, tbl_cart.status, tbl_cart.brandName, tbl_cart.description 
    FROM tbl_records 
    INNER JOIN tbl_cart ON tbl_records.transID = tbl_cart.transID
    GROUP BY tbl_records.transID";     
    $result = $conn->query($sql);
    $records = array();
    while($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    echo json_encode($records);
    $conn->close();