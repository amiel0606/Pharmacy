<?php
include_once './includes/header.php';
?>
    <link rel="stylesheet" href="./css/index.css">
    <div class="wrap">
        <div class="form-box signup">
            <img src="./images/logo.jpg" class="logo">
            <form action="./includes/login.php" method="post">
                <input id="user" name="UserName" type="text" placeholder="Username">
                <input id="pass" name="password" type="password" placeholder="Password">
                <input id="login" name="submit" type="submit"value="Log In"></input>
            </form>
        </div>
    </div>
<?php
include_once './includes/footer.php';
?>