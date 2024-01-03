<?php
include_once 'dbCon.php'; 
session_start();
$username = $_SESSION["username"];
$query = "SELECT fName, lName, username, role FROM tbl_users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo implode(',', $user);