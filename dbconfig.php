<?php
$servername='localhost';
$username='root';
$password='';
$db='erp-project';
$conn=mysqli_connect($servername,$username,$password,$db);
if(!$conn){
    die("CONNECTION FAILED:" .mysqli_connect_error());
}
?>