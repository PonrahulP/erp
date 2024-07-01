<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo"<script> alert('Failed! Please Register')";
    header("Location: ../login/index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include("../navbar.php"); ?>
<div class="container mt-5">
    <div class="row">
        <h5><a href="table.php" style="text-decoration:none;"><i class="bi bi-journal-richtext"></i> Receipt Report</a></h5>
        <hr>
        <nav class="my-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../main/index.php" style="text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item"><a href="../balance/table.php" style="text-decoration:none;">Balance</a></li>
                <li class="breadcrumb-item active">Add Receipt</li>
            </ol>
        </nav>
        <div class="col-md-8">
            <form action="http://localhost/erp/receipt/create.php" method="POST">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="bill" class="form-label fw-bold">Bill No:</label>
                        <?php 
                        include("../dbconfig.php");
                        $query = "SELECT bill_no FROM sales2";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }
                        ?>
                        <select name="billno" id="billno" class="form-control" style="border-color:black;">
                            <option>Select..</option>
                            <?php 
                            foreach ($options as $option) {
                                echo '<option>' . $option['bill_no'] . '</option>';
                            }
                            ?>
                        </select>
                        <a href="../sales/table.php" style="text-decoration:none;">Add Sales</a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date" class="form-label fw-bold">Date:</label>
                        <input type="date" name="date" id="date" style="border-color:black;" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="amnt" class="form-label fw-bold">Total Amount:</label>
                        <input type="text" name="amnt" id="amnt" style="border-color:black;" class="form-control" placeholder="Enter Total Amount" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="receive" class="form-label fw-bold">Received Amount:</label>
                        <input type="text" name="receive" id="receive" style="border-color:black;" class="form-control" placeholder="Enter Received Amount">
                    </div>
                    <div class="col-md-6">
                        <label for="pend" class="form-label fw-bold">Pending Amount:</label>
                        <input type="text" name="pend" id="pend" style="border-color:black;" class="form-control" placeholder="Enter Pending Amount">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                    <label for="type" class="form-label fw-bold">Payment Type:</label>
                        <select class="form-select" name="type" style="border-color:black;" id="type" aria-label="Default select example">
                            <option selected>Payment Type</option>
                            <option value="Bank">Bank</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" name="btn" id="btn" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    $('#billno').on('change', function() {
        var billNo = $(this).val();
        if (billNo) {
            $.ajax({
                url: "get_products.php",
                method: "POST",
                data: { bill_no: billNo },
                dataType: "json",
                success: function(data) {
                    var totalAmount = 0;
                    $.each(data, function(index, product) {
                        totalAmount += parseFloat(product.grand_total);
                    });
                    $('#amnt').val(totalAmount.toFixed(2));
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
        } else {
            $('#amnt').val("");
        }
    });

    $('#amnt, #receive').on('input', function() {
        var amnt = parseFloat($('#amnt').val()) || 0;
        var paid = parseFloat($('#receive').val()) || 0;
        var pend = amnt - paid;
        $('#pend').val(pend.toFixed(2));
    });
});
</script>
</body>
</html>
