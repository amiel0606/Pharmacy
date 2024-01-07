<?php
require_once 'dbCon.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM tbl_products WHERE pID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        echo "" . implode(',', $product) . "";
    } else {
        echo "No product found with id: " . $id;
    }
} else {
    echo "Product id is not set";
}

mysqli_close($conn);
