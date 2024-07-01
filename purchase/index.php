<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo"<script> alert('Failed! Please Register')";
    header("Location: ../login/index.php");
    exit();
}
include("../dbconfig.php");
$query="SELECT bill_no FROM purchase1 ORDER BY bill_no DESC";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
// $lastid=$row['bill_no'];
if(empty($row['bill_no'])){
    $number="P-0000001";
}else{
    $idd=str_replace("P-","",$row['bill_no']);
    $id=str_pad($idd+1, 7,0,STR_PAD_LEFT);
    $number="P-".$id;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Page</title>
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
            <h5><a href="table.php" style="text-decoration:none;"><i class="bi bi-journal-richtext"></i> Purchase Report</a></h5>
            <hr>
            <nav class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../main/index.php" style="text-decoration:none;">Home</a></li>
                    <li class="breadcrumb-item"><a href="../products/index.php" style="text-decoration:none;">Add Products</a></li>
                    <li class="breadcrumb-item active">Add Purchase</li>
                </ol>
            </nav>
                <form action="http://localhost/erp/purchase/create.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="supplier" class="form-label fw-bold">Supplier Id:</label>
                            <?php 
                          $query ="SELECT supplier_id FROM suppliers";
                           $result = $conn->query($query);
                       if($result->num_rows> 0){
                            $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
                              }
                              ?>
                            <?php
                          include("../dbconfig.php");
                        // include("fetch-data.php);
                           ?>
                          <select name="supplier" class="form-control" style="border-color:black;">
                           <option>Select Supplier</option>
                            <?php 
                       foreach ($options as $option) {
                          ?>
                      <option><?php echo $option['supplier_id']; ?> </option>
                            <?php 
                            }
                      ?>
                           </select>
                           <a href="../suppliers/index.php" style="text-decoration:none;">Add Supplier</a>
                        </div>
                        <div class="col-md-2">
                            <label for="bill" class="form-label fw-bold">Bill No:</label>
                            <input type="text"  class="form-control" style="border-color:black;" name="bill" id="bill" value="<?php echo $number;?>" readonly>
                            <input type="hidden"  class="form-control" name="bill1[]" id="bill1[]" value="<?php echo $number;?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="image" class="form-label fw-bold">Bill:</label>
                            <input type="file"  class="form-control" style="border-color:black;" name="image" id="image" >
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label fw-bold">Purchase Date:</label>
                            <input type="date"  class="form-control" style="border-color:black;" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" >
                        </div>
                    </div>
                    <div class="card" style="border-color:black;">
  <div class="card-body">
                    <div class="table-responsive">
            <table class="table table-bordered" id="salesTable" style="border-color:black;">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php
                $query = "SELECT product_code FROM products";
                $result = mysqli_query($conn, $query);
                echo '<input list="code" name="code[]" class="form-control" style="border-color:black;" />';
                echo '<datalist id="code">';
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['product_code'] . '">' . $row['product_code'] . '</option>';
                }
                echo '</datalist>';
                ?></td>
                        <td><input type="text" name="product_name[]" class="form-control" style="border-color:black;"></td>
                        <td><input type="number" name="quantity[]" class="form-control" required style="border-color:black;"></td>
                        <td><input type="number" name="unit_price[]" class="form-control" required style="border-color:black;"></td>
                        <td><input type="number" name="cgst[]" class="form-control" required style="border-color:black;"></td>
                        <td><input type="number" name="sgst[]" class="form-control" required style="border-color:black;"></td>
                        <td><input type="number" name="total[]" class="form-control" readonly style="border-color:black;"></td>
                        <td><i class="bi bi-x-circle-fill btn btn-danger h5 removeRow"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <i class="bi bi-plus-square-fill btn btn-primary" id="addRow"></i>
        <button type="submit"  id="btn" name="btn" class="btn btn-success">Submit</button>
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
    $("#addRow").click(function(){
        var newRow = '<tr>' +
            '<td>' +
                '<?php
                $query = "SELECT product_code FROM products";
                $result = mysqli_query($conn, $query);
                echo '<input list="code" name="code[]" class="form-control"  style="border-color:black;"/>';
                echo '<datalist id="code">';
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['product_code'] . '">' . $row['product_code'] . '</option>';
                }
                echo '</datalist>';
                ?>' +
            '</td>' +
            '<td><input type="text" name="product_name[]" class="form-control" style="border-color:black;"></td>' +
            '<td><input type="number" name="quantity[]" class="form-control" required style="border-color:black;"></td>' +
            '<td><input type="number" name="unit_price[]" class="form-control" required style="border-color:black;"></td>' +
            '<td><input type="number" name="cgst[]" class="form-control" required style="border-color:black;"></td>' +
            '<td><input type="number" name="sgst[]" class="form-control" required style="border-color:black;"></td>' +
            '<td><input type="number" name="total[]" class="form-control" readonly style="border-color:black;"></td>' +
            '<td><i class="bi bi-x-circle-fill btn btn-danger h5 removeRow"></i></td>' +
            '</tr>';
        $("#salesTable tbody").append(newRow);
    });

    $(document).on('click', '.removeRow', function(){
        $(this).closest('tr').remove();
    });

    $(document).on('change', 'input[list="code"]', function(){
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
                    } else {
                        row.find('input[name="product_name[]"]').val("");
                    }
                }
            });
        } else {
            row.find('input[name="product_name[]"]').val("");
        }
    });

    $(document).on('input', 'input[name="quantity[]"], input[name="unit_price[]"], input[name="cgst[]"], input[name="sgst[]"]', function(){
        var row = $(this).closest('tr');
        var qty = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
        var unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
        var cgst = parseFloat(row.find('input[name="cgst[]"]').val()) || 0;
        var sgst = parseFloat(row.find('input[name="sgst[]"]').val()) || 0;
        var cgst1=((unitPrice*cgst/100));
        var sgst1=((unitPrice*sgst/100));
        var total =(unitPrice+cgst1+sgst1)*qty;
        row.find('input[name="total[]"]').val(total);
    });

    $("#salesForm").on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'http://localhost/erp/purchase/create.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response){
                alert('Data Submitted Successfully');
                $("#salesTable tbody").empty().append('<tr>' +
                    '<td>' +
                        '<?php
                        $query = "SELECT product_code FROM products";
                        $result = mysqli_query($conn, $query);
                        echo '<input list="code" name="code[]" class="form-control" />';
                        echo '<datalist id="code">';
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<option value="' . $row['product_code'] . '">' . $row['product_code'] . '</option>';
                        }
                        echo '</datalist>';
                        ?>' +
                    '</td>' +
                    '<td><input type="text" name="product_name[]" class="form-control" ></td>' +
                    '<td><input type="number" name="quantity[]" class="form-control" required></td>' +
                    '<td><input type="number" name="unit_price[]" class="form-control" required></td>' +
                    '<td><input type="number" name="cgst[]" class="form-control" required></td>' +
                    '<td><input type="number" name="sgst[]" class="form-control" required></td>' +
                    '<td><input type="number" name="total[]" class="form-control" readonly></td>' +
                    '<td><i class="bi bi-x-circle-fill btn btn-danger h5 removeRow"></i></td>' +
                    '</tr>');
            }
        });
    });
});
  </script>
</html>