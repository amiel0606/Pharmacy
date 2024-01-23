<?php
include_once './includes/header.php';
if (!isset($_SESSION["uID"])) {
    header("location: ./index.php");
    exit();
}
else if ($_SESSION['role'] != 'Admin') {
    header("location: ./dashboard.php");
    exit();
}
?>

    <div class="right-panel">
        <p class="name">Name</p>
        <p class="role">Role</p>
        <div class="add-employee">
            <h1>Add Employee</h1>
            <div class="user-info">
            <div class="error-container">
                <p id="error" style="display:none;"></p>
                <button id="closeError" style="display:none;">X</button>
            </div>
            <form action="./includes/register.php" method="post">
                <input required class="inputs" placeholder="First Name" type="text" name="fname" id="fname">
                <input required required class="inputs" placeholder="Last Name" type="text" name="lname" id="lname">
                <input required class="inputs" placeholder="Username" type="text" name="uname" id="uname">
                <select required name="role" id="roles">
                    <option value="" disabled selected hidden>Select a Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Employee">Employee</option>
                </select>
                <input required class="inputs" placeholder="Password" type="password" name="pass" id="pass">
                <input required class="inputs" placeholder="Confirm Password" type="password" name="ConfPassword" id="cpass">
                <input id="btnAdd" name="add" type="submit" value="Add Employee"></input>
            </form>
            </div>
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
                case 'UsernameTaken':
                    errorMessage = 'The username is already taken';
                    break;
                case 'PassNotMatching':
                    errorMessage = 'The passwords do not match';
                    break;
                case 'InvalidUsername':
                    errorMessage = 'The username is invalid';
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
        $('#btnUpdate, #btnAdd').hide();
        var ajaxCompleted = false;
        $('#passs').on('keyup change', function() {
            if($(this).val() != '') {
                $('#btnUpdate').show();
            } else {
                $('#btnUpdate').hide();
            }
        });
        $('input, select').on('keyup change', function() {
            if(ajaxCompleted) {
                var anyFilled = false;
                $('input, select').each(function() {
                    if($(this).val() != '') {
                        anyFilled = true;
                    }
                });
                if(anyFilled) {
                    $('#btnAdd').show();
                } else {
                    $('#btnAdd').hide();
                }
            }
        });
        $.ajax({
            url: './includes/getUserData.php',
            type: 'post',
            data: {username: '<?php echo $_SESSION["username"]; ?>'},
            success: function(response){
                var data = response.split(',');
                $('.name').text(data[0] + ' ' + data[1]);
                $('.role').text(data[3]);
                $('#fnames').val(data[0]).trigger('change');
                $('#lnames').val(data[1]).trigger('change');
                $('#unames').val(data[2]).trigger('change');
                $('#roless').val(data[3]).trigger('change');
                ajaxCompleted = true;
            }
        });
    });
</script>
<?php 
include_once './includes/footer.php';
?>