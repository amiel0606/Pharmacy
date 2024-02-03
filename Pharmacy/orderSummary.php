<?php
include_once './includes/header.php';
if (!isset($_SESSION["uID"])) {
    header("location: ./index.php");
    exit();
}
?>
<link rel="stylesheet" href="./css/records.css">
<div class="right-panel">
    <p class="name">Name</p>
    <p class="role">Role</p>
    <h1 class="title">Order Summary</h1>
    <div id="orderSummary-container">
        <table id="orderSummary">
            <tr>

            </tr>
        </table>
</div>
<script>
$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var transID = urlParams.get('transID');
    var custName = urlParams.get('custName');
    $.ajax({
        url: './includes/viewRecord.php',
        type: 'GET',
        data: {transID: transID, custName: custName},
        success: function(data) {
            $('#orderSummary').html(data);
        }
    });
});
</script>
<?php
include_once './includes/footer.php';
?>