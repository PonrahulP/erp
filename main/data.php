<?php
require_once("../dbconfig.php");
$sql = "SELECT product_name, quantity FROM sales2 ORDER BY quantity";
$result = mysqli_query($conn,$sql);

$data = [];
$labels = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row["product_name"];
        $data[] = $row["quantity"];
    }
}
// print_r($labels);
// print_r($data);

$conn->close();
?>