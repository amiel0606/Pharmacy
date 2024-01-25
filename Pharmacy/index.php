<?php
include_once './includes/header.php';
if (isset($_SESSION['uID'])) {
    header("Location: ./dashboard.php");
}
?>
    <link rel="stylesheet" href="./css/index.css">
    <div class="wrap">
    <div class="form-box signup">
        <img src="./images/logo.jpg" class="logo">
        <div class="error-container">
            <p id="error" style="display:none;"></p>
            <button id="closeError" style="display:none;">X</button>
        </div>
        <form action="./includes/login.php" method="post">
            <input id="user" name="UserName" type="text" placeholder="Username">
            <input id="pass" name="password" type="password" placeholder="Password">
            <input id="login" name="submit" type="submit"value="Log In"></input>
        </form>
    </div>
</div>
    <script>
        $(document).ready(function(){
            var urlParams = new URLSearchParams(window.location.search);
            var error = urlParams.get('error');
            if(error){
                var errorMessage;
                switch(error){
                    case 'WrongLogin':
                        errorMessage = 'The login credentials are incorrect';
                        break;
                    case 'EmptyInput':
                        errorMessage = 'Please fill in all fields';
                        break;
                    case 'stmtFailed':
                        errorMessage = 'An error occurred';
                        break;
                    case 'none':
                        errorMessage = 'You have successfully logged in';
                        break;
                    default:
                        errorMessage = 'An unknown error occurred';
                }
                $("#error").html(errorMessage).show();
                $("#closeError").show();
            }
            $("#closeError").click(function(){
                $("#error").hide();
                $(this).hide();
            });
        });
</script>
<?php
include_once './includes/footer.php';
?>