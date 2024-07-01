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
    <title>Sales Update Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script>
        $(document).on('change', '.name', function(){
            var code = $(this).val();
            var row = $(this).closest('tr');
            if (code) {
                $.ajax({
                    url: "get_products1.php",
                    method: "POST",
                    data: { code: code },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            row.find('.code').val(data.product_code);
                        } else {
                            row.find('.code').val("");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to fetch product data:", error);
                    }
                });
            } else {
                row.find('.code').val("");
            }
        });
$(document).ready(function() {
    // Calculate totals when quantity or unit price changes
    $(document).on('input', '.quantity, .unit_price', function() {
        calculateRowTotal($(this).closest('tr'));
        calculateSubTotal();
           calculateGrandTotal();
    });
    // Calculate CGST amount
    $(document).on('input', '#cgst', function() {
        var subTotal = parseFloat($("#sub").val()) || 0;
        var cgstRate = parseFloat($(this).val()) || 0;
        var cgstAmount = (subTotal * cgstRate) / 100;
        $("#cgsta").val(cgstAmount.toFixed(2));
        calculateGrandTotal();
    });

    // Calculate SGST amount
    $(document).on('input', '#sgst', function() {
        var subTotal = parseFloat($("#sub").val()) || 0;
        var sgstRate = parseFloat($(this).val()) || 0;
        var sgstAmount = (subTotal * sgstRate) / 100;
        $("#sgsta").val(sgstAmount.toFixed(2));
        calculateGrandTotal();
    });

    // Recalculate grand total when discount changes
    $(document).on('input', '#dis', function() {
        calculateGrandTotal();
    });

    // Function to calculate the row total
    function calculateRowTotal(row) {
        var quantity = parseFloat(row.find('.quantity').val()) || 0;
        var unitPrice = parseFloat(row.find('.unit_price').val()) || 0;
        var total = quantity * unitPrice;
        row.find('.total').val(total.toFixed(2));
    }

    // Function to calculate the sub total
    function calculateSubTotal() {
        var subTotal = 0;
        $('.total').each(function() {
            subTotal += parseFloat($(this).val()) || 0;
        });
        $("#sub").val(subTotal.toFixed(2));
    }

    // Function to calculate the grand total
    function calculateGrandTotal() {
        var subTotal = parseFloat($("#sub").val()) || 0;
        var cgstAmount = parseFloat($("#cgsta").val()) || 0;
        var sgstAmount = parseFloat($("#sgsta").val()) || 0;
        var discount = parseFloat($("#dis").val()) || 0;
        var grandTotal = subTotal + cgstAmount + sgstAmount - discount;
        $("#grand").val(grandTotal.toFixed(2));
    }
});
    </script>
</head>
<body>
<?php include("../navbar.php"); ?>
<div class="container mt-5">
    <div class="row">
        <h5><i class="bi bi-plus-square-fill"></i> Update Sales</h5>
        <hr>
        <nav class="my-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="table.php" style="text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item active">Update Sales</li>
            </ol>
        </nav>
        <?php
        include("../dbconfig.php");
        $bill = $_GET['bill'];
        $sql = "SELECT * FROM sales1 WHERE bill_no='$bill'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_array($res)) {
        ?>
        <form action="update.php?bill=<?php echo $bill;?>" method="POST">
            <div class="card" style="border-color:black;">
                <div class="card-body" style="border-color:black;">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="customerid" class="form-label fw-bold">Customer ID:</label>
                            <a href="../customer/table.php" style="text-decoration:none;"><input type="text" name="customer_id" id="customerid" style="border-color:black;" class="form-control" value="<?php echo $row['customer_id']; ?>"></a><br>
                        </div>
                        <div class="col-md-3">
                            <label for="bill" class="form-label fw-bold">Bill No:</label>
                            <input type="text" name="bill_no" id="bill" style="border-color:black;" class="form-control" value="<?php echo $row['bill_no']; ?>" readonly><br>
                        </div>
                        <div class="col-md-3">
                            <label for="invoice">Invoice No:</label>
                            <input type="text" style="border-color:black;" name="invoice_no" id="invoice" class="form-control" value="<?php echo $row['invoice_no']; ?>" readonly><br>
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label fw-bold">Sales Date:</label>
                            <input type="date" name="sales_date" id="date" style="border-color:black;" class="form-control" value="<?php echo $row['sales_date']; ?>"><br>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="sub" class="form-label fw-bold">Sub Total:</label>
                            <input type="text" name="sub_total" id="sub" style="border-color:black;" class="form-control" value="<?php echo $row['sub_total']; ?>" readonly><br>
                        </div>
                        <div class="col-md-3">
                            <label for="cgst" class="form-label fw-bold">CGST%:</label>
                            <input type="text" name="cgst" id="cgst" style="border-color:black;" class="form-control" value="<?php echo $row['cgst']; ?>"><br>
                        </div>
                        <div class="col-md-3">
                            <label for="cgsta" class="form-label fw-bold">CGST Amount:</label>
                            <input type="text" name="cgst_amount" id="cgsta" style="border-color:black;" class="form-control" value="<?php echo $row['cgst_amount']; ?>"><br>
                        </div>
                        <div class="col-md-3">
                        <label for="type" class="form-label fw-bold">Sales Type:</label>
                        <select class="form-select" aria-label="Default select example" style="border-color:black;" name="type">
  <option selected>Choose...</option>
  <option value="Bill To Bill">Bill To Bill</option>
  <option value="Bill To Cash">Bill To Cash</option>
</select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="sgst" class="form-label fw-bold">SGST%:</label>
                            <input type="text" name="sgst" id="sgst" style="border-color:black;" class="form-control" value="<?php echo $row['sgst']; ?>"><br>
                        </div>
                        <div class="col-md-3">
                            <label for="sgsta" class="form-label fw-bold">SGST Amount:</label>
                            <input type="text" name="sgsta" id="sgsta" style="border-color:black;" class="form-control" value="<?php echo $row['sgst_amount']; ?>"><br>
                        </div>
                        <div class="col-md-3">
                            <label for="dis" class="form-label fw-bold">Discount:</label>
                            <input type="text" name="dis" id="dis" style="border-color:black;" class="form-control" value="<?php echo $row['discount']; ?>"><br>
                        </div>
                        <div class="col-md-3">
                            <label for="grand" class="form-label fw-bold">Grand Total:</label>
                            <input type="text" name="grand_total" style="border-color:black;" id="grand" class="form-control" value="<?php echo $row['grand_total']; ?>"><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="card" style="border-color:black;">
                    <div class="card-body">
                        <table id="salesTable" class="display table table-bordered" style="width:100%;border-color:black;">
                            <thead>
                                <tr>
                                    <th>PRODUCT NAME</th>
                                    <th>PRODUCT CODE</th>
                                    <th>QUANTITY</th>
                                    <th>UNIT PRICE</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql1 = "SELECT * FROM sales2 WHERE bill_no='$bill'";
                                $res1 = mysqli_query($conn, $sql1);
                                if (mysqli_num_rows($res1) > 0) {
                                    while ($row1 = mysqli_fetch_array($res1)) {
                                        echo "<tr>";
                                        echo "<td><select class='form-select name' name='product_name[]' style='border-color:black;'>
                                                <option value='{$row1['product_name']}' selected>{$row1['product_name']}</option>";
                                        $sql2 = "SELECT product_name FROM products";
                                        $res2 = mysqli_query($conn, $sql2);
                                        if (mysqli_num_rows($res2) > 0) {
                                            while ($row2 = mysqli_fetch_array($res2)) {
                                                echo "<option value='{$row2['product_name']}'>{$row2['product_name']}</option>";
                                            }
                                        }
                                        echo "</select></td>";
                                        echo "<td><input type='text' style='border-color:black;'' name='product_code[]' value='{$row1['product_code']}' class='form-control code'></td>";
                                        echo "<td><input type='text' name='quantity[]' style='border-color:black;' value='{$row1['quantity']}' class='form-control quantity'> <input type='hidden' name='quantity1[]' value='{$row1['quantity']}' class='form-control quantity'></td>";
                                        echo "<td><input type='text' name='unit_price[]' style='border-color:black;'' value='{$row1['unit_price']}' class='form-control unit_price'></td>";
                                        echo "<td><input type='text' name='total[]' style='border-color:black;'' value='{$row1['total']}' class='form-control total' readonly></td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
        <?php
            }
        }
        ?>
    </div>
</div>
</body>
</html>
