<?php
if (isset($_POST["add"])) {
    $Fname = $_POST["fname"];
    $Lname = $_POST["lname"];
    $role = $_POST["role"];
    $UserName = $_POST["uname"];
    $password = $_POST["pass"];
    $ConfPassword = $_POST["ConfPassword"];

    require_once 'functions.php';
    require_once 'dbCon.php';

    if (emptyInputSignup($Fname,$Lname,$role,$UserName,$password,$ConfPassword) !== false) {
        header("location: ../settings.php?error=EmptyInput");
        exit();
    }
    if (passMatch($password,$ConfPassword) !==false) {
        header("location: ../settings.php?error=PassNotMatching");
        exit();
    }
    if (InvalidUser($UserName) !== false) {
        header("location: ../settings.php?error=InvalidUsername");
        exit();
    }
    if (userExist($conn,$UserName) !== false) {
        header("location: ../settings.php?error=UsernameTaken");
        exit();
    }
    createUser($conn,$UserName,$Lname,$Fname,$role,$password,$ConfPassword);
}
else {
    header("location: ../settings.php");
    exit();
}
