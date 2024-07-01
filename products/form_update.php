<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo"<script> alert('Failed! Please Register')";
    header("Location: ../login/index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products Update Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
     crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  </head>
  <body>
  <?php include("../navbar.php");?>
    <div class="container mt-5">
        <div class="row">
            <h5><i class="bi bi-plus-square-fill"></i> Update Products</h5>
            <hr>
            <nav class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="table.php" style="text-decoration:none;">Home</a></li>
                    <li class="breadcrumb-item active">Update Products</li>
                </ol>
            </nav>
            <div class="col-md-8">
              <?php
              $id=$_GET['id'];
              ?>
                <form action="http://localhost/erp/products/update.php?id=<?php echo $id; ?>" method="POST">
                    <div class="row mb-3">
        
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-bold">Product Name:</label>
                            <input type="text" name="name" id="name" style="border-color:black;"  class="form-control" value="<?php echo $_GET['name'];?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label fw-bold">Product Code:</label>
                            <input type="text" name="code" id="code" style="border-color:black;"  class="form-control" value="<?php echo $_GET['code'];?>">
                        </div>
                        <div class="col-md-6">
                        <div class="form-floating">
                        <textarea class="form-control" placeholder="Description" 
                        id="desc" name="desc" style="height: 100px;border-color:black;"><?php echo $_GET['description'];?></textarea>
                       <label for="desc">Description</label>
                         </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="qty" class="form-label fw-bold">Quantity:</label>
                            <input type="text" name="qty" id="qty" style="border-color:black;"  class="form-control" value="<?php echo $_GET['qty'];?>">
                        </div>
                        <div class="col-md-6">
                            <label for="uprice" class="form-label fw-bold">Unit Price:</label>
                            <input type="text" name="uprice" id="uprice" style="border-color:black;"  class="form-control" value="<?php echo $_GET['uprice'];?>">
                        </div>
                    </div>
                   
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="cimage" class="form-label fw-bold">current Image:</label>
                            <input type="hidden" name="cimage" class="form-control" value="<?php echo $_GET['image'];?>"><br>
                            <img src="<?php echo $_GET['image'];?>" style='width:50px; height: 50px;' >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="uimage" class="form-label fw-bold">current Image;</label>
                            <input type="file" name="uimage" style="border-color:black;"  class="form-control"><br>
                        </div>
                    </div>
                    
                
                    <div class="mb-3">
                        <button type="submit" name="update" id="update" class="btn btn-success">Update</button>
                    </div>

                </form>
            </div>
            <!-- row end -->
        </div>
        <!-- Container end -->
    </div>
    
  </body>
</html>