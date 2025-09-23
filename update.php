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
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $profilePicSQL = '';
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = $_FILES['profile_pic']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($fileExtension, $allowedExtensions)) {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            $newFileName = 'uploads/' . uniqid() . "." . $fileExtension;
            if (move_uploaded_file($fileTmpPath, $newFileName)) {
                $profilePicSQL = ", profile_pic='$newFileName'";
            } else {
                $error = "File upload failed.";
            }
        } else {
            $error = "Invalid file type. Only jpg, jpeg, png, webp allowed.";
        }
    }

    if (empty($error)) {
        $sqlUpdate = "UPDATE users SET name='$name', email='$email', pass='$password' $profilePicSQL WHERE id=$id";
        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Update User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<style>
body {
    background: linear-gradient(135deg, #6a1b9a, #9c27b0);
    min-height: 100vh;
    margin: 0;
    padding-top: 70px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.custom-navbar { position: fixed; top: 0; width: 100%; background: linear-gradient(135deg, #6a1b9a, #9c27b0); box-shadow: 0 2px 10px rgba(0,0,0,0.3); z-index: 1030; padding: 0.5rem 1rem; }
.custom-navbar-container { max-width: 1140px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; }
.custom-navbar-brand { color: white; font-weight: 700; font-size: 1.5rem; text-decoration: none; }
.custom-navbar-toggler { display: none; font-size: 1.5rem; background: transparent; border: none; color: white; cursor: pointer; }
.custom-navbar-menu { display: flex; gap: 1.25rem; align-items: center; }
.custom-navbar-menu a { color: white; text-decoration: none; font-weight: 500; transition: color 0.3s ease; }
.custom-navbar-menu a:hover { color: #f3e5f5; }
.custom-navbar-menu .custom-btn-logout { background: white; color: #6a1b9a; padding: 0.3rem 0.8rem; border-radius: 5px; font-weight: 600; text-decoration: none; transition: background-color 0.3s ease, color 0.3s ease; }
.custom-navbar-menu .custom-btn-logout:hover { background: #4a148c; color: white; }
@media (max-width: 768px) {
    .custom-navbar-toggler { display: block; }
    .custom-navbar-menu { flex-direction: column; width: 100%; display: none; margin-top: 0.5rem; background: linear-gradient(135deg, #6a1b9a, #9c27b0); border-radius: 0 0 8px 8px; padding: 0.5rem 0; }
    .custom-navbar-menu.show { display: flex; }
    .custom-navbar-menu a { padding: 0.5rem 1rem; width: 100%; }
}
.container { background-color: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 480px; }
h2 { text-align: center; margin-bottom: 20px; color: #6a1b9a; }
label { font-weight: bold; display: block; margin-bottom: 8px; }
input[type="text"], input[type="email"], input[type="file"] {
    width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #6a1b9a; border-radius: 8px; background-color: #f5f5f5; color: #333; font-size: 16px;
}
input[type="text"]:focus, input[type="email"]:focus, input[type="file"]:focus {
    border-color: #9c27b0; background-color: #fff; box-shadow: 0 0 0 0.25rem rgba(156,39,176,0.25); outline: none;
}
button {
    background-color: #6a1b9a; color: white; padding: 14px; border-radius: 8px; width: 100%; border: none; font-size: 16px; cursor: pointer; margin-top: 20px;
}
button:hover { background-color: #4a148c; }
.error { color: #FF4D4D; font-size: 14px; font-weight: bold; text-align: center; margin-top: 10px; }
@media (max-width: 576px) {
    .container { padding: 15px; max-width: 100%; }
    h2 { font-size: 18px; }
    button { padding: 12px; font-size: 14px; }
    input[type="text"], input[type="email"], input[type="file"] { padding: 10px; font-size: 14px; }
}
</style>
</head>
<body>

<nav class="custom-navbar" role="navigation" aria-label="Main Navigation">
    <div class="custom-navbar-container">
        <a href="#" class="custom-navbar-brand">AS-Ltd</a>
        <button class="custom-navbar-toggler" aria-expanded="false" aria-controls="customNavbarMenu" aria-label="Toggle navigation">&#9776;</button>
        <div class="custom-navbar-menu" id="customNavbarMenu">
            <a href="dashboard.php">Home</a>
            <a href="index.php">Users</a>
            <a href="create.php">Add User</a>
            <a href="logout.php" class="custom-btn-logout">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2>Update User</h2>
    <form method="post" action="" enctype="multipart/form-data">
         <label for="profile_pic">Change Profile Picture:</label>
        <input type="file" name="profile_pic" accept="image/*" />
        <label for="name">Change Your Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required />

        <label for="email">Change Your Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required />

        <label for="password">Change Your Password:</label>
        <input type="text" name="password" value="<?= htmlspecialchars($row['pass']) ?>" required />

       

        <?php if (!empty($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <button type="submit">Update</button>
    </form>
</div>

<script>
const toggler = document.querySelector('.custom-navbar-toggler');
const menu = document.querySelector('.custom-navbar-menu');

toggler.addEventListener('click', () => {
    const expanded = toggler.getAttribute('aria-expanded') === 'true';
    toggler.setAttribute('aria-expanded', !expanded);
    menu.classList.toggle('show');
});
</script>

</body>
</html>
