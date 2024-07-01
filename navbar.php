<nav class="navbar bg-primary">
  <div class="container-fluid d-flex align-items-center">
    <img class="rounded-circle me-2" style="height: 75px; width: 75px;" src="../images/<?php
      include("../dbconfig.php");
      $sql = "SELECT logo FROM users";
      $result = mysqli_query($conn, $sql);
      if ($row = mysqli_fetch_assoc($result)) {
        echo $row['logo'];
      } else {
        echo "No Data";
      }
    ?>" alt="User-Profile-Image">
    <a class="navbar-brand h1">SmartConnect ERP<i class="bi bi-emoji-heart-eyes"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" style="background-color: #e3f2fd;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dashboard Menu</h5>
        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
        <li class="nav-item">
         <a class="nav-link active text-dark fw-bold" aria-current="page" href="../main/index.php"><i class="bi bi-house h5"></i> Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-fill"></i> Customer
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../customer/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../customer/table.php"><i class="bi bi-journal-richtext"></i> Report</a></li>
            </ul>
          </li>
         
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-box-fill h5"></i> Stock
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../products/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../products/table.php"><i class="bi bi-journal-richtext"></i> Report</a></li>
              <li><a class="dropdown-item" href="../excel/index.php"><i class="bi bi-file-earmark-excel"></i> Import Excel</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-cart-plus-fill h5"></i> Sales
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../sales/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../sales/table.php"><i class="bi bi-journal-richtext"></i> Report</a></li>
            </ul>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-fill-check h5"></i> Suppliers
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../suppliers/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../suppliers/table.php"><i class="bi bi-journal-richtext"></i> Report</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bag-plus-fill h5"></i> Purchase
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../purchase/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../purchase/table.php"><i class="bi bi-journal-richtext"></i> Report</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-wallet-fill h5"></i> Transactions
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../expenses/index.php"><i class="bi bi-coin"></i> Expenses</a></li>
              <li><a class="dropdown-item" href="../income/index.php"><i class="bi bi-currency-rupee"></i> Income</a></li>
              <li><a class="dropdown-item" href="#">Bank</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../c2b/index.php"><i class="bi bi-bank"></i> Deposit</a></li>
              <li><a class="dropdown-item" href="../b2c/index.php"><i class="bi bi-cash-coin"></i> Withdraw</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-credit-card-2-back-fill h5"></i> Payment
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../payment/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../payment/table.php"><i class="bi bi-journal-richtext"></i>  Report</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-receipt h5"></i> Receipt
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../receipt/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../receipt/table.php"><i class="bi bi-journal-richtext"></i> Report</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-percent h5"></i> GST
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../bill_to_bill/table.php"><i class="bi bi-bank2"></i> Bill To Bill</a></li>
              <li><a class="dropdown-item" href="../bill_to_cash/table.php"><i class="bi bi-cash-coin"></i> Bill To Cash</a></li>
              <li><a class="dropdown-item" href="../hsn/table.php"><i class="bi bi-bank"></i> HSN</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="material-icons">account_balance_wallet</span> Balance
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../balance/index.php"><i class="bi bi-plus-square-fill"></i> New Entry</a></li>
              <li><a class="dropdown-item" href="../balance/table.php"><i class="bi bi-journal-richtext"></i> Report</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-sliders h5"></i>  Settings
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="../dbbackup/backup.php"><i class="bi bi-download"></i> Download</a></li>
              <li><a class="dropdown-item" href="http://localhost/erp/logout/logout.php"><i class="bi bi-box-arrow-right"></i> Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>