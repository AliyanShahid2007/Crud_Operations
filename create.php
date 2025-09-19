<?php
    include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4a148c, #7b1fa2, #9c27b0);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .add-card {
            max-width: 500px;
            width: 100%;
            border-radius: 15px;
        }
        .btn-purple {
            background-color: #6a1b9a;
            border: none;
        }
        .btn-purple:hover {
            background-color: #4a148c;
        }
    </style>
</head>
<body>

    <div class="card shadow-lg add-card">
        <div class="card-body p-4">
            <h3 class="text-center mb-4 fw-bold" style="color:#4a148c;">Register</h3>

            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" name="add" class="btn btn-purple text-white">Register</button>
                </div>
            </form>
             <div class="mt-3 text-center">
                <small class="text-muted">Do you have an account? <a href="login.php" class="text-decoration-none" style="color:#6a1b9a;">Login</a></small>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST['add'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "INSERT INTO users(name,email,pass) VALUES('$name','$email','$password')";

            if($conn->query($sql)){
                echo "<script>alert('User Added'); window.location='index.php';</script>";
            }
            else{
                echo "Error: " . $conn->error;
            }
        }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
