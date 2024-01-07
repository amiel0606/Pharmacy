<?php
require_once 'dbCon.php';

if (isset($_POST['delete'])) {
    $pID = $_POST['pID'];
    $stmt = $conn->prepare("DELETE FROM tbl_products WHERE pID = ?");
    $stmt->bind_param("i", $pID);

    if ($stmt->execute()) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
