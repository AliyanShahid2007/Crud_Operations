<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "User ID nahi mili.";
    exit;
}
$id = intval($_GET['id']);

$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows === 0) {
    echo "User nahi mila.";
    exit;
}
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "UPDATE users SET name='$name', email='$email', pass='$password' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
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
        .update-card {
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

    <div class="card shadow-lg update-card">
        <div class="card-body p-4">
            <h3 class="text-center mb-4 fw-bold" style="color:#4a148c;">Update Your Profile</h3>
            
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="text" class="form-control" name="password" value="<?= htmlspecialchars($row['pass']) ?>" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-purple text-white">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
