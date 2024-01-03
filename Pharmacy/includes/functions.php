<?php
function emptyInputSignup($Fname,$Lname,$role,$UserName,$password,$ConfPassword) {
    $result;
    if (empty($Fname) || empty($Lname) || empty($role) || empty($UserName) || empty($password) || empty($ConfPassword)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function InvalidUser($UserName) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $UserName)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function passMatch($password,$ConfPassword) {
    $result;
    if ($password != $ConfPassword) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function userExist($conn,$UserName) {
    $sql = "SELECT * FROM tbl_users WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("location: ../settings.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $UserName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createUser($conn,$UserName,$Lname,$Fname,$role,$password){
    $sql = "INSERT INTO tbl_users(username, password, role, fname, lname) VALUES(?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("location: ../settings.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $UserName, $hashedPass, $role, $Fname, $Lname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../settings.php?error=none");
    exit();
}

function emptyInputLogin($uName,$pwd) {
    $result;
    if (empty($uName) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $uName, $pwd) {
    $UserExists = userExist($conn,$uName);

    if ($UserExists == false) {
        header("location: ../settings.php?error=WrongLogin");
        exit();
    }
    $pwdHashed = $UserExists["password"];
    $checkPass = password_verify($pwd, $pwdHashed);

    if ($checkPass === false) {
        header("location: ../settings.php?error=WrongLogin");
        exit();
    }
    else if ($checkPass === true) {
        session_start();
        $_SESSION["uID"] = $UserExists["uID"]; 
        $_SESSION["username"] = $UserExists["username"];
        header("location: ../settings.php");
        exit();
    }
}


