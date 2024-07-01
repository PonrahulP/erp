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
    <title>Bank Balance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
  <?php include("../navbar.php");?>
  <?php include("../float.php");?>
  <div class="container mt-5">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h5><i class="bi bi-journal-richtext"></i> Balance Report Details</h5>
                <a href="table.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Balance</a>
            </div>
            <div class="col-md-12 table-responsive mt-3">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
include("../dbconfig.php");

// Define your SQL queries
$expensesQuery = "SELECT 'Expense' as type, amount,name as description , date FROM expenses WHERE payment_type='bank' ";
$incomeQuery = "SELECT 'Income' as type,  amount, name as description, date FROM income WHERE payment_type='bank'";
$depositQuery = "SELECT 'Deposit' as type,  amount, bank_name as description, date FROM c2b";
$withdrawQuery = "SELECT 'Withdraw' as type, amount, bank_name as description, date FROM b2c";
$paymentQuery="SELECT 'Purchase' as type,  amount, bill_no as description, date FROM payment WHERE payment_type='bank'";
$receiptQuery="SELECT 'Sales' as type, amount, bill_no as description, date FROM receipt WHERE payment_type='bank'";
$combinedQuery = "$expensesQuery UNION ALL $incomeQuery UNION ALL $depositQuery UNION ALL $withdrawQuery UNION ALL $paymentQuery UNION ALL $receiptQuery ORDER BY date DESC";
$result = mysqli_query($conn, $combinedQuery);

$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}

mysqli_close($conn);
?>
        <?php $id=1; foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo $id++; ?></td>
                    <td><?php echo ($transaction['type']); ?></td>
                    <td><?php echo ($transaction['amount']); ?></td>
                    <td><?php echo ($transaction['description']); ?></td>
                    <td><?php echo ($transaction['date']); ?></td>
                </tr>
            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- row end -->
        </div>
        <!-- Container end -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>
</html>