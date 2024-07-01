<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
     crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
     crossorigin="anonymous"></script>
  </head>
  <style>
    #heading{
        margin-left:530px;
    }
    body{
       background-color:coral;
    }
  </style>
  <body>
  <nav class="navbar navbar-expand bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light fw-bold" id="heading">Register Page</a>
            <!-- <a href="../login/index.php" class="navbar-brand text-light">Log In</a> -->
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h5><i class="bi bi-journal-richtext"></i>Register</h5>
                <a href="../login/index.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Log In</a>
            </div>
            <nav class="my-3">
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item active">Register Page</li> -->
                </ol>
            </nav><hr>
            <div class="col-md-8">
                <form action="create.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="uname" class="form-label fw-bold">Username:</label>
                            <input type="text" name="uname" id="uname" class="form-control" style="border-color:black;" placeholder="Enter Username">
                        </div>
                        <div class="col-md-6">
                            <label for="pwd" class="form-label fw-bold">Password:</label>
                            <input type="text" name="pwd" id="pwd" class="form-control" style="border-color:black;" placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mail" class="form-label fw-bold">Email Id:</label>
                            <input type="text" name="mail" id="mail" class="form-control" style="border-color:black;" placeholder="Enter Email Id">
                        </div>
                        <div class="col-md-6">
                            <label for="contact" class="form-label fw-bold">Contact:</label>
                            <input type="text" name="contact" id="contact" class="form-control" style="border-color:black;" placeholder="Enter Contact">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                        <label for="contact" class="form-label fw-bold">Role:</label>
                        <select class="form-select" name="role" id="role" style="border-color:black;" aria-label="Default select example">
                        <option selected>Role:</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                        </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bank" class="form-label fw-bold">Opening Bank Balance:</label>
                            <input type="text" name="bank" id="bank" class="form-control" style="border-color:black;" placeholder="Enter Opening Bank Balance">
                        </div>
                        <div class="col-md-6">
                            <label for="cash" class="form-label fw-bold">Opening Cash Balance:</label>
                            <input type="text" name="cash" id="cash" class="form-control" style="border-color:black;" placeholder="Enter Opening Cash Balance">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="logo" class="form-label fw-bold">Logo:</label>
                            <input type="file" name="logo" id="logo" class="form-control" style="border-color:black;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="regis" id="regis" class="btn btn-success">Register</button>
                    </div>
</form>
</div>            
</div>
</div>
</body>
</html>