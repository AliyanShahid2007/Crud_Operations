<?php
    include 'db.php';
    session_start();

    $error = ""; // error message variable
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MyApp</title>
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
        .login-card {
            max-width: 400px;
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

    <div class="card shadow-lg login-card">
        <div class="card-body p-4">
            <h3 class="text-center mb-4 text-purple fw-bold" style="color:#4a148c;">Login</h3>
            
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="password" class="form-control" name="pass" required>
                </div>

                <?php if(!empty($error)): ?>
                    <p class="text-danger text-center fw-semibold"><?= $error ?></p>
                <?php endif; ?>

                <div class="d-grid">
                    <button class="btn btn-purple text-white">Login</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <small class="text-muted">Don’t have an account? <a href="create.php" class="text-decoration-none" style="color:#6a1b9a;">Register</a></small>
            </div>
        </div>
    </div>

    <?php
        if($_SERVER['REQUEST_METHOD'] =='POST'){
            $email = $_POST['email'];
            $password = $_POST['pass'];

            $sql = "SELECT * FROM users WHERE email='$email' AND pass='$password'";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid email or password";
            }
        }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
