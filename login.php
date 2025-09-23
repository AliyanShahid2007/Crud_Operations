<?php
include 'db.php';
session_start();

$error = ""; // error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize inputs
    $email = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND pass = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password";
        }

        $stmt->close();
    } else {
        $error = "Database error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | MyApp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #4a148c, #7b1fa2, #9c27b0);
            min-height: 100vh;
            margin: 0;
            padding-top: 70px; /* For sticky navbar */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            color: white;
        }

        /* Navbar styles */
        .nav-bar {
            position: fixed;
            top: 0;
            width: 100%;
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 1030;
            padding: 0.5rem 1rem;
        }

        .nav-inner {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .nav-brand {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .nav-toggle-btn {
            display: none;
            font-size: 1.5rem;
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
        }

        .nav-links {
            display: flex;
            gap: 1.25rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #f3e5f5;
        }

        /* Fixed logout/login button style */
        .nav-links .btn-logout {
            background: white;
            color: #6a1b9a;
            padding: 0.3rem 0.8rem;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-links .btn-logout:hover {
            background: #4a148c;
            color: white;
        }

        /* Responsive toggle */
        @media (max-width: 768px) {
            .nav-toggle-btn {
                display: block;
            }

            .nav-links {
                flex-direction: column;
                width: 100%;
                display: none;
                margin-top: 0.5rem;
                background: linear-gradient(135deg, #6a1b9a, #9c27b0);
                border-radius: 0 0 8px 8px;
                padding: 0.5rem 0;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a {
                padding: 0.5rem 1rem;
                width: 100%;
            }
        }

        /* Card styling */
        .login-card {
            max-width: 400px;
            width: 100%;
            border-radius: 15px;
            background: white;
            color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
        }

        h3 {
            color: #4a148c;
            font-weight: 700;
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

<!-- Navbar -->
<nav class="nav-bar" role="navigation" aria-label="Primary Navigation">
    <div class="nav-inner">
        <a href="login.php" class="nav-brand">AS-Ltd</a>
        <button class="nav-toggle-btn" aria-expanded="false" aria-controls="navLinks" aria-label="Toggle navigation">
            &#9776;
        </button>
        <div class="nav-links" id="navLinks">
            <a href="login.php">Home</a>
            <a href="login.php" class="btn-logout">Login</a>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<div class="login-card mt-5">
    <h3 class="text-center mb-4">Login</h3>

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
            <p class="text-danger text-center fw-semibold"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div class="d-grid">
            <button class="btn btn-purple text-white">Login</button>    
        </div>
    </form>

    <div class="mt-3 text-center">
        <small class="text-muted">Don’t have an account? <a href="create.php" class="text-decoration-none" style="color:#6a1b9a;">Register</a></small>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Navbar toggle script -->
<script>
    const toggleBtn = document.querySelector('.nav-toggle-btn');
    const navLinks = document.querySelector('.nav-links');

    toggleBtn.addEventListener('click', () => {
        const expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        toggleBtn.setAttribute('aria-expanded', !expanded);
        navLinks.classList.toggle('active');
    });
</script>

</body>
</html>
