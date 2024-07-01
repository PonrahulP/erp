<?php
session_start();
include ("../dbconfig.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['btn'])){
    $filename=$_FILES['excel']['name'];
    $file_ext=pathinfo($filename,PATHINFO_EXTENSION);
    $allowed_ext=['xls','csv','xlsx'];
    if(in_array($file_ext,$allowed_ext)){
        $inputFileName = $_FILES['excel']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $data= $spreadsheet->getActiveSheet()->toArray();
        $count="0";
        foreach($data as $row){
            if($count>0){
                $name=$row['0'];
                $code=$row['1'];
                $description=$row['2'];
                $uprice=$row['3'];
                $quantity=$row['4'];
                $image=$row['5'];
                

                $query="INSERT INTO products (product_name,product_code,description,unit_price,quantity,image) VALUES ('$name','$code','$description','$uprice','$quantity','$image')";
                $result=mysqli_query($conn,$query);
                $msg=true;
            }else{
                $count="1";
            }
        }
        if(isset($msg)){
            $_SESSION['msg']="SUCCESSFULLY IMPORTED";
            header('Location:index.php');
            exit(0);
        }else{
            $_SESSION['msg']="NOT IMPORTED";
            header('Location:index.php');
            exit(0);
        }
    }else{
        $_SESSION['msg']="INVALID FILE";
        header('Location:index.php');
        exit(0);
    }
}
?>