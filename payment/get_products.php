<?php
include("../dbconfig.php");

if (isset($_POST['bill_no'])) {
    $bill_no = $_POST['bill_no'];

    $query = "SELECT total FROM purchase2 WHERE bill_no = '$bill_no'";
    $result = mysqli_query($conn, $query);

    $totalAmount = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $totalAmount += $row['total'];
    }

    echo json_encode(['total' => $totalAmount]);
}
?>
