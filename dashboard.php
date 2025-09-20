<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background: #f8f9fa;
      margin: 0;
      padding-top: 70px; /* for sticky navbar */
      font-family: Arial, sans-serif;
    }

    /* Custom navbar styles */
    .dash-nav {
      position: fixed;
      top: 0;
      width: 100%;
      background: linear-gradient(135deg, #6a1b9a, #9c27b0);
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      z-index: 1030;
      padding: 0.5rem 1rem;
    }

    .dash-nav-inner {
      max-width: 1140px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .dash-nav-brand {
      color: white;
      font-weight: 700;
      font-size: 1.5rem;
      text-decoration: none;
    }

    .dash-nav-toggle {
      display: none;
      font-size: 1.5rem;
      background: transparent;
      border: none;
      color: white;
      cursor: pointer;
    }

    .dash-nav-menu {
      display: flex;
      gap: 1.25rem;
      align-items: center;
    }

    .dash-nav-menu a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .dash-nav-menu a:hover,
    .dash-nav-menu a.active {
      color: #f3e5f5;
    }

    .dash-nav-menu .btn-exit {
      background: white;
      color: #6a1b9a;
      padding: 0.3rem 0.8rem;
      border-radius: 5px;
      font-weight: 600;
      text-decoration: none;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dash-nav-menu .btn-exit:hover {
      background: #4a148c;
      color: white;
    }

    /* Responsive nav */
    @media (max-width: 768px) {
      .dash-nav-toggle {
        display: block;
      }

      .dash-nav-menu {
        flex-direction: column;
        width: 100%;
        display: none;
        margin-top: 0.5rem;
        background: linear-gradient(135deg, #6a1b9a, #9c27b0);
        border-radius: 0 0 8px 8px;
        padding: 0.5rem 0;
      }

      .dash-nav-menu.active {
        display: flex;
      }

      .dash-nav-menu a {
        padding: 0.5rem 1rem;
        width: 100%;
      }
    }

    /* Main content card */
    .dash-content {
      max-width: 700px;
      margin: 2rem auto;
    }

    .dash-card {
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border: none;
      padding: 3rem;
      border-radius: 15px;
      background: white;
      text-align: center;
    }

    .dash-card h1 {
      color: #6a1b9a;
      font-weight: 700;
    }

    .dash-card p {
      margin-top: 1rem;
      font-size: 1.1rem;
      color: #555;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="dash-nav" role="navigation" aria-label="Dashboard Navigation">
  <div class="dash-nav-inner">
    <a href="dashboard.php" class="dash-nav-brand">My Admin Panel</a>
    <button class="dash-nav-toggle" aria-expanded="false" aria-controls="dashMenu" aria-label="Toggle navigation">
      &#9776;
    </button>
    <div class="dash-nav-menu" id="dashMenu">
      <a href="dashboard.php">Home</a>
      <a href="index.php">Users</a>
      <a href="create.php">Add User</a>
      <a href="login.php" class="btn-exit">Logout</a>
    </div>
  </div>
</nav>
<!-- End Navbar -->

<div class="dash-content">
  <div class="dash-card">
    <h1>Hey! <?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest' ?>, You're Logged In 🎉</h1>
    <p>Welcome to your dashboard. Enjoy your session!</p>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const toggleBtn = document.querySelector('.dash-nav-toggle');
  const navMenu = document.querySelector('.dash-nav-menu');

  toggleBtn.addEventListener('click', () => {
    const expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
    toggleBtn.setAttribute('aria-expanded', !expanded);
    navMenu.classList.toggle('active');
  });
</script>

</body>
</html>
