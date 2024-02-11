<?php
    require_once 'dbCon.php';
    $term = $_GET['term'];
    $likeTerm = '%' . $term . '%';
    $stmt = $conn->prepare("SELECT tbl_records.*, tbl_cart.datePurchased, tbl_cart.status, tbl_cart.brandName, tbl_cart.description 
                            FROM tbl_records 
                            INNER JOIN tbl_cart ON tbl_records.transID = tbl_cart.transID
                            WHERE tbl_records.name LIKE ?
                            GROUP BY tbl_records.transID");
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $records = array();
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    echo json_encode($records);
    $stmt->close();
    $conn->close();