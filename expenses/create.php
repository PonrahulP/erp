<?php
session_start();
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Method:POST');
header('Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-With');
include ('function.php');
$requestmethod=$_SERVER['REQUEST_METHOD'];
if($requestmethod=='POST'){
    $inputdata=json_decode(file_get_contents("php://input"),true);
    if(empty($inputdata)){
        $storeexpenses=storeexpenses($_POST);
    }else{
        $storeexpenses=storeexpenses($inputdata);
    }
    header("Location:table.php");
    echo $storeexpenses;
}else{
    $data=[
        'status'=>404,
        'message'=>$requestmethod."Method Not Allowed",
    ];
    header("HTTP/1.0 404 Method Not Allowed");
    echo json_encode($data);
}

?>