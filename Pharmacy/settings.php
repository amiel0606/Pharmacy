<?php
include_once './includes/header.php';
if (!isset($_SESSION["uID"])) {
    header("location: ./index.php");
    exit();
}
?>
    <link rel="stylesheet" href="./css/settings.css">
    <div class="right-panel">
        <p class="name">Name</p>
        <p class="role">Role</p>
        <div class="info">
                <h1 class="title">Settings</h1>
            <div class="user-info">
                <form action="./includes/editProfile.php" method="post">
                    <input class="inputs" readonly type="text" name="fname" id="fnames">
                    <input class="inputs" readonly type="text" name="lname" id="lnames">
                    <input class="inputs" readonly type="text" name="uname" id="unames">
                    <input class="inputs" readonly type="text" name="role" id="roless">
                    <input class="inputs" type="password" name="pass" id="passs">
                    <input id="btnUpdate" name="update" type="submit" value="Update"></input>
                </form>
            </div>
        </div>
        <div class="add-employee">
            <h1>Add Employee</h1>
            <div class="user-info">
            <form action="./includes/register.php" method="post">
                <input class="inputs" placeholder="First Name" type="text" name="fname" id="fname">
                <input class="inputs" placeholder="Last Name" type="text" name="lname" id="lname">
                <input class="inputs" placeholder="Username" type="text" name="uname" id="uname">
                <select name="role" id="roles">
                    <option value="" disabled selected hidden>Select a Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Employee">Employee</option>
                </select>
                <input class="inputs" placeholder="Password" type="password" name="pass" id="pass">
                <input class="inputs" placeholder="Confirm Password" type="password" name="ConfPassword" id="cpass">
                <input id="btnAdd" name="add" type="submit" value="Add Employee"></input>
            </form>
            </div>
        </div>
    </div>
    <script>
$(document).ready(function(){
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