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
    <title>Expenses Page</title>
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
            <h5><i class="bi bi-plus-square-fill"></i> <a href="table.php" style="text-decoration:none;">Expenses Report</a></h5>
            <hr>
            <nav class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../main/index.php" style="text-decoration:none;">Home</a></li>
                    <li class="breadcrumb-item"><a href="../balance/table.php" style="text-decoration:none;">Balance</a></li>
                    <li class="breadcrumb-item active">Add Expenses</li>
                </ol>
            </nav>
            <div class="col-md-8">
                <form action="http://localhost/erp/expenses/create.php" method="POST">
                    <div class="row mb-3">
                    <div class="input-group mb-3">
                     <label class="input-group-text" for="inputGroupSelect01" style="border-color:black;">Expenses Type</label>
                     <select class="form-select" id="inputGroupSelect01" name="type" style="border-color:black;">
                     <option selected>Choose...</option>
                      <option value="Office">Office</option>
                      <option value="Salary">Salary</option>
                       <option value="Rent">Rent</option>
                     </select>
                      </div> 

                    </div>

                    <label for="browser" class="form-label fw-bold">Expenses Name:</label>
                    <input list="browsers" name="name" id="name" style="border-color:black;">
                   <datalist id="browsers">
                    <option value=" Rahul">
                    <option value="Subbru">
                   <option value="Raja">
                  <option value="Ponraj">
                  <option value="Sangu">
                   </datalist>

                     <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-bold">Date:</label>
                            <input type="date" name="date" id="date" style="border-color:black;" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="amnt" class="form-label fw-bold">Amount:</label>
                            <input type="text" name="amnt" id="amnt" style="border-color:black;" class="form-control" placeholder="Enter Amount">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="payment" class="form-label fw-bold">Payment Type:</label><br>
                            <input type="radio" name="payment" id="payment" style="border-color:black;"  value="cash">
                            <label for="payment" class="form-label fw-bold">Cash</label>
                            <input type="radio" name="payment" id="payment" style="border-color:black;" value="bank">
                            <label for="payment" class="form-label fw-bold">Bank</label>
                        </div>
                </div>

                    <div class="mb-3">
                        <button type="submit" name="btn" id="btn" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
            <!-- row end -->
        </div>
        <!-- Container end -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>
  <script>
    window.onload = function() {
    setInterval(function(){
        var date = new Date();
        var displayDate = date.toLocaleDateString();
        document.getElementById('date').innerHTML = displayDate;
    });
  }
  </script>
</html>