<?php 
  require ("fpdf186/fpdf.php");
  require ("../dbconfig.php");
  require ("word.php");

  //customer and invoice details
  $info=[
    "customer1"=>"",
    "address"=>"",
    "mobile"=>"",
  ];
  $info1=[
    "invoice_no"=>"",
    "invoice_date"=>"",
    "total_amt"=>"",
    "words"=>"",
  ];
  $bill=$_GET['bill'];
  $query="SELECT * FROM sales1 WHERE bill_no='$bill'";
  $res=mysqli_query($conn,$query);
  if($res->num_rows>0){
      $row=$res->fetch_assoc();
      $obj=new IndianCurrency($row['grand_total']);
     
      
      $info1=[
        "invoice_no"=>$row['invoice_no'],
        "invoice_date"=>$row['sales_date'],
        "total_amt"=>$row['grand_total'],
        "words"=>$obj->get_words(),
      ];
  }


//   $bill=$_GET['bill'];
  $customer=$_GET['customer'];
    $query="SELECT * FROM customers WHERE customer_id='$customer'";
    $res=mysqli_query($conn,$query);
    if($res->num_rows>0){
        $row=$res->fetch_assoc();
        // $cus=$row['cutomer_id'];
        $info=[
            "customer1"=>$row['name'],
            "address"=>$row['address'],
            "mobile"=>$row['contact'],
          ];
    }

  
  
  //invoice Products
  $products_info=[];
  $bill=$_GET['bill'];
  $query="SELECT sales2.product_name,sales2.unit_price,sales2.quantity,sales1.cgst,sales1.sgst,sales2.total,sales1.discount
  ,sales1.grand_total FROM sales2 INNER JOIN sales1 ON sales1.bill_no=sales2.bill_no WHERE sales1.bill_no='$bill'";
  $res=mysqli_query($conn,$query);
  if(mysqli_num_rows($res)>0){
      while($row=$res->fetch_array()){
        $products_info[]=[
            "name"=>$row['product_name'],
            "price"=>$row['unit_price'],
            "qty"=>$row['quantity'],
            // "cgst"=>$row['cgst'],
            // "sgst"=>$row['sgst'],
            "total"=>$row['total'],
            // "discount"=>$row['discount'],
            // "net"=>$row['grand_total'],
        ];
      }
  }
  class PDF extends FPDF
  {
    function Header(){
     
      $this->Image('../images/mobile.jpg', 10, 6, 30); 
      $this->SetY(10);
      $this->SetX(50);
      //Display Company Info
      $this->SetFont('Arial','B',14);
        $this->Cell(0,10,"AAA",0,1);
        $this->SetFont('Arial','',14);
        $this->SetX(50);
        $this->Cell(0,7,"BBB,",0,1);
        $this->SetX(50);
        $this->Cell(0,7,"CCC 636002.",0,1);
        $this->SetX(50);
        $this->Cell(0,7,"PH : 8778731770",0,1);
        
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"INVOICE",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info,$info1,$products_info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,$info["customer1"],0,1);
      $this->Cell(50,7,$info["address"],0,1);
      $this->Cell(50,7,$info["mobile"],0,1);
      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice No : ".$info1["invoice_no"]);
      
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice Date : ".$info1["invoice_date"]);
      
      //Display Table headings
      $this->SetY(95);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(40,9,"DESCRIPTION",1,0);
      $this->Cell(20,9,"PRICE",1,0,"C");
      $this->Cell(20,9,"QTY",1,0,"C");
      $this->Cell(20,9,"TOTAL",1,0,"C");
      $this->SetFont('Arial','',12);
      
      //Display table product rows
      foreach($products_info as $row){
        $this->Cell(40,9,$row["name"],"LR",0);
        $this->Cell(20,9, $row["price"], "R", 0,"C"); 
        $this->Cell(20,9,$row["qty"],"R",0,"C");
        $this->Cell(20,9,$row["total"],"R",0,"C");
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(40,9,"","LR",0);
        $this->Cell(20,9,"","R",0,"C");
        $this->Cell(20,9,"","R",0,"C");
        $this->Cell(20,9,"","R",0,"C");
        $this->Cell(30,9,"","R",1,"R");
      }
      //Display table total row
      
      $this->SetFont('Arial','B',12);
      $this->Cell(160,9,"TOTAL",1,0,"C");
      $this->Cell(40,9,$info1["total_amt"],1,1,"C");
      
      //Display amount in words
      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,9,"Amount in Words ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,9,$info1["words"],0,1);
      
    }
    function Footer(){
      
      //set footer position
      $this->SetY(-50);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"for ABC COMPUTERS",0,1,"R");
      $this->Ln(15);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
      
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$info1,$products_info);
  $pdf->Output();
?>