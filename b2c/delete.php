<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Method:DELETE');
header('Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-with');
include("function.php");
$requestmethod=$_SERVER["REQUEST_METHOD"];
if($requestmethod=="DELETE"){
    $deleteb2c=deleteb2c($_GET);
    echo $deleteb2c;
    header("Location:table.php");

}

else{
    $data=[
        'status'=>404,
        'message'=>$requestmethod.'Method Not Allowed',
    ];
    header("HTTP/1.0 404 Method Not Allowed");
    echo json_encode($data);
}
?>