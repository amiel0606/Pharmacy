<?php
require_once 'dbCon.php';
$barcode = $_POST['barcode'];
$category = $_POST["category"];
$brandName = $_POST['brandName'];
$description = $_POST['description'];
$qty = $_POST['qty'];
$priceBought = $_POST['priceBought'];
$exp_date = $_POST['exp_date'];
$priceSale = $_POST['priceSale'];
$requiredFields = array("barcode", "brandName", "description", "qty", "priceBought", "priceSale", "category");

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        echo "error: Please fill in all required fields.";
        exit();
    }
}
$sql = "INSERT INTO tbl_products (barcode, brandName, description, stock, priceBought, priceSale, exp_date, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiiiss", $barcode, $brandName, $description, $qty, $priceBought, $priceSale, $exp_date, $category);
$result = $stmt->execute();

if ($result) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();