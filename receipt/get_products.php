<?php
include("../dbconfig.php");

if (isset($_POST['bill_no'])) {
    $bill_no = $_POST['bill_no'];

    $query = "SELECT grand_total FROM sales1 WHERE bill_no = '$bill_no'";
    $result = mysqli_query($conn, $query);

    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    echo json_encode($products);
}
?>
