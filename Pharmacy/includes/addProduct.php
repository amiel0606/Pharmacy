<?php
require_once 'dbCon.php';
$category = $_POST["category"];
$brandName = $_POST['brandName'];
$description = $_POST['description'];
$qty = $_POST['qty'];
$priceBought = $_POST['priceBought'];
$exp_date = $_POST['exp_date'];
$priceSale = $_POST['priceSale'];
$stockAlert = $_POST['stockAlert'];
$requiredFields = array("brandName", "description", "qty", "priceBought", "priceSale", "category");

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        echo "error: Please fill in all required fields.";
        exit();
    }
}
$sql = "INSERT INTO tbl_products (brandName, description, stock, priceBought, priceSale, stockAlert, exp_date, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiiiiss", $brandName, $description, $qty, $priceBought, $priceSale, $stockAlert, $exp_date, $category);
$result = $stmt->execute();

if ($result) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();