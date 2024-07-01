<?php
// session_start();
require("../dbconfig.php");
function error422($message){
    $data=[
        'status'=>422,
        'message'=>$message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}
    function getstocklist(){
        global $conn;
        $query="SELECT sales1.id,sales2.product_code,sales1.cgst,sales1.cgst_amount,sales1.sgst,sales1.sgst_amount
        FROM sales1
        INNER JOIN sales2 ON sales1.bill_no = sales2.bill_no;
        ";
        $result=mysqli_query($conn,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $res=mysqli_fetch_all($result,MYSQLI_ASSOC);
                $data=[
                    'status'=>201,
                    'message'=>"STOCK FOUND",
                    'data'=>$res,
                ];
                header("HTTP/1.0 201 STOCK FOUND");
                return json_encode($data);
            }else{
                $data=[
                    'status'=>201,
                    'message'=>"STOCK NOT FOUND",
                ];
                header("HTTP/1.0 201 STOCK NOT FOUND");
                return json_encode($data);
            }
        }else{
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
    ?>