<?php
session_start();
include "../dbconfig.php";
if(isset($_POST['login'])){
    
    $name=$_POST['name'];
    $password=$_POST['password'];
    $sql="SELECT * FROM users WHERE username='$name'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($result);
    if(password_verify($password,$row['password'])){
        $_SESSION['uname']=$row['username'];
        echo "<script>alert ('Login Success');</script>";
        echo "<script>window.location.href='../main/index.php'</script>";
    }else{
        echo "<script>alert ('Login Failed');</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}else{
    echo "<script>alert ('Login Failed');</script>";
    echo "<script>window.location.href='index.php'</script>";
}
?>