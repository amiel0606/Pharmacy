<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'dbCon.php';
$searchTerm = $_GET['term'];
$stmt = $conn->prepare("SELECT * FROM tbl_products WHERE pID LIKE ? OR brandName LIKE ? OR description LIKE ? OR category LIKE ?");
$likeTerm = '%' . $searchTerm . '%';
$stmt->bind_param('ssss', $likeTerm, $likeTerm, $likeTerm, $likeTerm);
$stmt->execute();
$result = $stmt->get_result();
$results = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
echo json_encode($results);

