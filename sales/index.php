<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo"<script> alert('Failed! Please Register')";
    header("Location: ../login/index.php");
    exit();
}
include("../dbconfig.php");
if (isset($_SESSION['low_stock_products']) && !empty($_SESSION['low_stock_products'])) {
    $lowStockProducts = json_encode($_SESSION['low_stock_products']);
} else {
    $lowStockProducts = json_encode([]);
}

$query="SELECT bill_no FROM sales1 ORDER BY bill_no DESC";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
// $lastid=$row['bill_no'];
if(empty($row['bill_no'])){
    $number="S-0000001";
}else{
    $idd=str_replace("S-","",$row['bill_no']);
    $id=str_pad($idd+1, 7,0,STR_PAD_LEFT);
    $number="S-".$id;
}

$query="SELECT invoice_no FROM sales1 ORDER BY invoice_no DESC";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
// $lastid=$row['bill_no'];
if(empty($row['invoice_no'])){
    $numbers="IN-0000001";
}else{
    $idd=str_replace("IN-","",$row['invoice_no']);
    $id=str_pad($idd+1, 7,0,STR_PAD_LEFT);
    $numbers="IN-".$id;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
  <?php include("../navbar.php");?>
  
    <div class="container mt-5">
        <div class="row">
            <h5><a href="table.php" style="text-decoration:none;"><i class="bi bi-journal-richtext"></i> Sales Report</a></h5>
            <hr>
            <nav class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../main/index.php" style="text-decoration:none;">Home</a></li>
                    <li class="breadcrumb-item"><a href="../products/index.php" style="text-decoration:none;">Add Products</a></li>
                    <li class="breadcrumb-item active">Add Sales</li>
                </ol>
            </nav>
            <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']);
        }
        ?>
            
                <form action="http://localhost/erp/sales/create.php" method="POST">

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="customer" class="form-label fw-bold">Customer Id:</label>
                            <?php 
                          $query ="SELECT customer_id FROM customers";
                           $result = $conn->query($query);
                       if($result->num_rows> 0){
                            $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
                              }
                              ?>
                            <?php
                          include("../dbconfig.php");
                        // include("fetch-data.php);
                           ?>
                          <select name="customer" class="form-control" style="border-color:black;" >
                           <option>Select Customers</option>
                            <?php 
                       foreach ($options as $option) {
                          ?>
                      <option><?php echo $option['customer_id']; ?> </option>
                            <?php 
                            }
                      ?>
                           </select>
                        </div>
                        <div class="col-md-2">
                            <label for="bill" class="form-label fw-bold">Bill No:</label>
                            <input type="text"  class="form-control" style="border-color:black;"  name="bill" id="bill" value="<?php echo $number;?>" readonly>
                            <!-- <input type="hidden"  class="form-control" name="bill1[]" id="bill1[]" value="<?php echo $number;?>" readonly> -->
                        </div>
                        <div class="col-md-3">
                            <label for="invoice" class="form-label fw-bold">Invoice No:</label>
                            <input type="text"  class="form-control" style="border-color:black;"  name="invoice" id="invoice" value="<?php echo $numbers; ?>" readonly >
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                            <label for="type" class="form-label fw-bold">Sales Type:</label>
                            <select class="form-select" name="type" style="border-color:black;"  aria-label="Default select example">
                            <option selected>Choose</option>
                            <option value="Bill to Bill">Bill To Bill</option>
                             <option value="Bill to Cash">Bill To Cash</option>
                               </select>
                            </div>
                            <div class="col-md-3">
                            <label for="date" class="form-label fw-bold">Sales Date:</label>
                            <input type="date"  class="form-control" style="border-color:black;"  name="date" id="date" value="<?php echo date('Y-m-d'); ?>" >

                        </div>
                    </div>
                    <div class="card">
  <div class="card-body">
                    <div class="table-responsive">
            <table class="table table-bordered" id="salesTable" >
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php
                $query = "SELECT product_code FROM products";
                $result = mysqli_query($conn, $query);
                echo '<input list="code" name="product[]" style="border-color:black;" class="form-control" />';
                echo '<datalist id="code">';
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['product_code'] . '">' . $row['product_code'] . '</option>';
                }
                echo '</datalist>';
                ?></td>
                        <td><input type="text" name="product_name[]" class="form-control" style="border-color:black;" ></td>
                        <td><input type="text" name="quantity[]" class="form-control" style="border-color:black;"  required></td>
                        <td><input type="text" name="unit_price[]" class="form-control" style="border-color:black;"  required></td>
                        <td><input type="text" name="total[]" class="form-control" style="border-color:black;"  readonly></td>
                        <td><i class="bi bi-x-circle-fill btn btn-danger h5 removeRow"></i></td>
                    </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan='4' class="text-end fw-bold">Sub-total:</td>
                    <td><input type="text" name="sub" id="sub" style="border-color:black;"  class="form-control" required></td>
                    </tr>
                    <tr>
                    <td colspan='4' class="text-end fw-bold">Discount:</td>
                    <td><input type="text" name="discount" style="border-color:black;"  id="discount" class="form-control" required></td>
                    </tr>
                    <tr>
                    <td colspan='3' class="text-end fw-bold">CGST%:</td>
                    <td><input type="text" name="cgst" style="border-color:black;"  id="cgst" class="form-control" required></td>
                    <td><input type="text" name="cgstamnt" id="cgstamnt" style="border-color:black;"  class="form-control" required></td>
                    </tr>
                    <tr>
                    <td colspan='3' class="text-end fw-bold">SGST%:</td>
                    <td><input type="text" name="sgst" style="border-color:black;"  id="sgst" class="form-control" required></td>
                    <td><input type="text" name="sgstamnt" id="sgstamnt" style="border-color:black;"  class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>  <i class="bi bi-plus-square-fill btn btn-primary" id="addRow"></i></td>
                        <td colspan='3' class="text-end fw-bold">Grand Total:</td>
                        <td><input type="text" name="grand" style="border-color:black;"  id="grand" class="form-control" required></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <button type="submit"  id="btn" name="btn" class="btn btn-success">Generate Invoice</button>
       
                </div>
                
                </div>
                </form>
            <!-- row end -->
        </div>
        <!-- Container end -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>
  <script>
    $(document).ready(function(){
        var lowStockProducts = <?php echo $lowStockProducts; ?>;
        if (lowStockProducts.length > 0) {
            alert('Warning: Stock quantity for the following products is less than 30: ' + lowStockProducts.join(', '));
            <?php unset($_SESSION['low_stock_products']); ?>
        }
    // Add a new row to the sales table
    $("#addRow").click(function(){
        var newRow = '<tr>' +
           '<td>' +
                '<?php
                $query = "SELECT product_code FROM products";
                $result = mysqli_query($conn, $query);
                echo '<input list="code" name="product[]" class="form-control" style="border-color:black;" />';
                echo '<datalist id="code">';
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['product_code'] . '">' . $row['product_code'] . '</option>';
                }
                echo '</datalist>';
                ?>' +
            '</td>' +
            '<td><input type="text" name="product_name[]" class="form-control" style="border-color:black;" ></td>' +
            '<td><input type="text" name="quantity[]" class="form-control" required style="border-color:black;" ></td>' +
            '<td><input type="text" name="unit_price[]" class="form-control" required style="border-color:black;" ></td>' +
            '<td><input type="text" name="total[]" class="form-control" readonly style="border-color:black;" ></td>' +
            '<td><i class="bi bi-x-circle-fill btn btn-danger h5 removeRow"></i></td>' +
            '</tr>';
        $("#salesTable tbody").append(newRow);
        subtotal();
    });

    // Remove a row from the sales table
    $(document).on('click', '.removeRow', function(){
        $(this).closest('tr').remove();
        subtotal();
    });

    // Auto-fill product details based on product code
    $(document).on('change', 'input[name="product[]"]', function(){
        var code = $(this).val();
        var row = $(this).closest('tr');
        if (code) {
            $.ajax({
                url: "get_products.php",
                method: "POST",
                data: { code: code },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        row.find('input[name="product_name[]"]').val(data.product_name);
                        row.find('input[name="unit_price[]"]').val(data.unit_price);
                    } else {
                        row.find('input[name="product_name[]"]').val("");
                        row.find('input[name="unit_price[]"]').val("");
                    }
                }
            });
        } else {
            row.find('input[name="product_name[]"]').val("");
            row.find('input[name="unit_price[]"]').val("");
        }
    });

    
    $(document).on('input', 'input[name="quantity[]"], input[name="unit_price[]"], input[name="cgst"], input[name="sgst"], input[name="discount"], input[name="sub"]', function(){
                var row = $(this).closest('tr');
                var qty = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
                var unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
                var tprice = unitPrice * qty;
                row.find('input[name="total[]"]').val(tprice.toFixed(2));

                var cgst = parseFloat($("#cgst").val()) || 0;
                var sgst = parseFloat($("#sgst").val()) || 0;
                var discount = parseFloat($("#discount").val()) || 0;
                var sub = parseFloat($("#sub").val()) || 0;
                
                var cgstAmount = (sub * cgst) / 100;
                $("#cgstamnt").val(cgstAmount.toFixed(2));

                var sgstAmount = (sub * sgst) / 100;
                $("#sgstamnt").val(sgstAmount.toFixed(2));

                var grandTotal = sub + cgstAmount + sgstAmount - discount;
                $("#grand").val(grandTotal.toFixed(2));

                subtotal();
            });

    // Calculate the grand total of all products
    function subtotal(){
        var subtotal = 0;
        $("input[name='total[]']").each(function(){
            subtotal += parseFloat($(this).val()) || 0;
        });
        $("#sub").val(subtotal.toFixed(2));
    }
   
    // Handle form submission via AJAX
    $("#invoice").on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'http://localhost/erp/sales/create.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response){
                alert('Data Submitted Successfully');
                $("#salesTable tbody").empty().append('<tr>' +
                   '<td>' +
                '<?php
                $query = "SELECT product_code FROM products";
                $result = mysqli_query($conn, $query);
                echo '<input list="code" name="product[]" class="form-control" style="border-color:black;"  />';
                echo '<datalist id="code">';
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['product_code'] . '">' . $row['product_code'] . '</option>';
                }
                echo '</datalist>';
                ?>' +
            '</td>' +
                    '<td><input type="text" name="product_name[]" style="border-color:black;"  class="form-control" ></td>' +
                    '<td><input type="number" name="quantity[]" style="border-color:black;"  class="form-control" required></td>' +
                    '<td><input type="number" name="unit_price[]" style="border-color:black;"  class="form-control" required></td>' +
                    '<td><input type="number" name="total[]" style="border-color:black;"  class="form-control" readonly></td>' +
                    '<td><i class="bi bi-x-circle-fill btn btn-danger h5 removeRow"></i></td>' +
                    '</tr>');
            }
        });
    });
});

</script>
</html>