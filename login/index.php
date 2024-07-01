<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  </head>
  <style>
    #heading{
        margin-left:530px;
    }
    body{
       background-color:coral;
    }
  </style>
  <body onload='document.form1.password.focus()'>
  <nav class="navbar navbar-expand bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light fw-bold" id="heading">LogIn Page</a>
            <!-- <a href="../users/index.php" class="navbar-brand text-light">Register</a> -->
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h5><i class="bi bi-journal-richtext"></i>Log In</h5>
                <a href="../users/index.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Register</a>
            </div>
            <nav class="my-3">
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item active">Log In</li><hr> -->
                </ol>
            </nav><hr>
            <div class="col-md-8">
                <form action="http://localhost/erp/login/function.php" name="form1" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-bold">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" style="border-color:black;" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password" class="form-label fw-bold">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" style="border-color:black;" placeholder="Enter Passsword">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="login" id="login" class="btn btn-dark" onclick="CheckPassword(document.form1.password)">Log In</button>
                    </div>
</form>
</div>
</div>
</div>
</body>
</html>
<script>
    function CheckPassword(inputtxt){
        var decimal=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
        if(inputtxt.value.match(decimal)){
            alert('Correct,try another....');
            return true;
        }else{
            alert('Wrong..!');
            return false;
        }
    }
</script>