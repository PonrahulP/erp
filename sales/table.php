<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo "<script>alert('Failed! Please Register');</script>";
    header("Location: ../login/index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
<?php include("../navbar.php"); ?>
<?php include("../float.php"); ?>
<div class="container mt-5">
    <div class="row">
        <div class="d-flex justify-content-between">
            <h5><i class="bi bi-journal-richtext"></i> Sales Details</h5>
            <a href="index.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Sales</a>
        </div>
        <div class="col-md-12 table-responsive mt-3">
            <table id="example" class="display table table-bordered" style="width:100%;border-color:black;">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Bill.No</th>
                    <th>Customer ID</th>
                    <th>Grand Total</th>
                    <th>Sales Date</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody id="data">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
   
    fetch("http://localhost/erp/sales/read.php").then(
        res => {
            res.json().then(
                data => {
                    if (data.data.length > 0) {
                        var temp = "";
                        data.data.forEach((itemData) => {
                            temp += "<tr>";
                            temp += "<td>" + itemData.id + "</td>";
                            temp += "<td>" + itemData.bill_no + "</td>";
                            temp += "<td><a href='../customer/table.php' style='text-decoration:none;'>" + itemData.customer_id + "</a></td>";
                            temp += "<td>" + itemData.grand_total + "</td>";
                            temp += "<td>" + itemData.sales_date + "</td>";
                            temp += "<td><i id='delete' class='bi bi-trash-fill' data-bill='" + itemData.bill_no + "'></i></td>";
                            temp += "<td><a href='form_update.php?bill="+itemData.bill_no+"'><i class='bi bi-eye-fill'></i></a></td>";
                            temp += "</tr>";
                        });
                        document.getElementById('data').innerHTML = temp;
                    }
                }
            )
        }
    );

    $(document).on('click', '#delete', function() {
        var bill = $(this).data('bill');
        var qty = $(this).closest('tr').find("td:eq(5)").html();
        var code = $(this).closest('tr').find("td:eq(3)").html();
        var confirmation = confirm('Are you sure you want to delete this item?');
        if (confirmation) {
            var deleteURL = "http://localhost/erp/sales/delete.php?bill=" + bill + '&qty=' + qty + '&code=' + code;
            $.ajax({
                url: deleteURL,
                method: 'DELETE',
                success: function() {
                    alert("Item deleted successfully.");
                    location.reload();
                }
            });
        }
    });

});
</script>
</body>
</html>
