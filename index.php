<?php include "db.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | MyApp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
            min-height: 100vh;
            margin: 0;
            padding-top: 70px; /* space for sticky navbar */
            color: white;
        }

        /* Customized Navbar Styling with new class names */
        .nav-mainbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 1030;
            padding: 0.5rem 1rem;
        }

        .nav-container {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .nav-branding {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .nav-toggler-btn {
            display: none;
            font-size: 1.5rem;
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
        }

        .nav-menu-list {
            display: flex;
            gap: 1.25rem;
            align-items: center;
        }

        .nav-menu-list a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-menu-list a:hover {
            color: #f3e5f5;
        }

        .nav-menu-list .btn-logout-custom {
            background: white;
            color: #6a1b9a;
            padding: 0.3rem 0.8rem;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-menu-list .btn-logout-custom:hover {
            background: #4a148c;
            color: white;
        }

        /* Responsive Toggle Menu */
        @media (max-width: 768px) {
            .nav-toggler-btn {
                display: block;
            }

            .nav-menu-list {
                flex-direction: column;
                width: 100%;
                display: none;
                margin-top: 0.5rem;
                background: linear-gradient(135deg, #6a1b9a, #9c27b0);
                border-radius: 0 0 8px 8px;
                padding: 0.5rem 0;
            }

            .nav-menu-list.active {
                display: flex;
            }

            .nav-menu-list a {
                padding: 0.5rem 1rem;
                width: 100%;
            }
        }

        /* Table container styling */
        .table-wrapper {
            background-color: #fff;
            color: #333;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #6a1b9a;
            font-weight: bold;
        }

        .btn-purple {
            background-color: #6a1b9a;
            color: white;
            border: none;
        }

        .btn-purple:hover {
            background-color: #4a148c;
        }

        .action-links a {
            margin-right: 10px;
            text-decoration: none;
        }

        .action-links a.edit {
            color: #6a1b9a;
            font-weight: 500;
        }

        .action-links a.delete {
            color: #c62828;
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .table-responsive {
                font-size: 14px;
            }

            .btn {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
         .btn-purple {
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
            border: none;
            color: #fff !important;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-purple:hover {
            background: linear-gradient(135deg, #4a148c, #6a1b9a);
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }
        .btn-exit { 
            background: white !important;  
            color: #6a1b9a !important; 
            padding: 0.3rem 0.8rem; 
            border-radius: 5px; 
            font-weight: 600; 
            text-decoration: none; 
            transition: background-color 0.3s ease, color 0.3s ease; }

        .btn-exit:hover { 
            background: #4a148c !important; 
            color: white !important; 
        }
    
    </style>
</head>
<body>

<!-- Customized Navbar -->
<nav class="nav-mainbar" role="navigation" aria-label="Primary Navigation">
    <div class="nav-container">
        <a href="#" class="nav-branding">AS-Ltd</a>
        <button class="nav-toggler-btn" aria-expanded="false" aria-controls="navMenuList" aria-label="Toggle navigation">
            &#9776;
        </button>
        <div class="nav-menu-list" id="navMenuList">
        <a href="dashboard.php">Home</a>
      <a href="index.php">Users</a>
      <a href="create.php">Add User</a>
      <a href="product.php">Add Product</a>
      <a href="showproduct.php">Products</a>
     <a href="login.php" class="btn-exit">Logout</a>
       
        </div>
    </div>
</nav>
<!-- End Customized Navbar -->

<div class="container table-wrapper mt-5">
    <h2>User Management Panel</h2>

    <div class="mb-3 text-end">
        <a href="create.php" class="btn btn-purple">Add New User</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Profile Img</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $conn->query("SELECT * FROM users");
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['pass']) ?></td>
                                <td><img src="<?= htmlspecialchars($row['profile_pic']) ?>" alt="Profile" width="50" height="50"></td>
                                <td class="action-links">
                                    <a class="edit" href="update.php?id=<?= $row['id'] ?>">Edit</a>
                                    <a class="delete" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users found.</td>
                        </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Navbar toggle script -->
<script>
    const toggleBtn = document.querySelector('.nav-toggler-btn');
    const menuList = document.querySelector('.nav-menu-list');

    toggleBtn.addEventListener('click', () => {
        const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        toggleBtn.setAttribute('aria-expanded', !isExpanded);
        menuList.classList.toggle('active');
    });
</script>

</body>
</html>
