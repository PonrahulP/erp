<?php
include("../dbconfig.php");

if(isset($_POST['code'])){
    $category = mysqli_real_escape_string($conn, $_POST['code']);
    $sql = "SELECT product_name,unit_price FROM products WHERE product_code='$category'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
?>
