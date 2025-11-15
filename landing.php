<?php include "dbs.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome | AS-Ltd</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
            min-height: 100vh;
            padding-top: 70px;
            color: white;
        }

        /* Navbar */
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
        }
        .nav-branding {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
        }
        .nav-menu-list a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
        }

        /* Product Cards */
        .product-card {
            background: white;
            color: #333;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-title {
            color: #6a1b9a;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-purple {
            background-color: #6a1b9a;
            color: white;
            border: none;
        }
        .btn-purple:hover {
            background-color: #4a148c;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="nav-mainbar">
    <div class="nav-container">
        <a href="#" class="nav-branding">AS-Ltd</a>
        <div class="nav-menu-list">
            <a href="landing.php">Home</a>
            <a href="login.php">Admin Login</a>
        </div>
    </div>
</nav>

<!-- Page Heading -->
<div class="container text-center mt-4">
    <h1 class="fw-bold">Our Products</h1>
    <p class="text-light">Browse the latest items available at AS-Ltd</p>
</div>

<!-- Product Grid -->
<div class="container mt-5">
    <div class="row g-4">

        <?php
        $result = $conn->query("SELECT * FROM products");
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>

        <div class="col-md-4">
            <div class="product-card">
                <img src="<?= htmlspecialchars($row['pro_img']) ?>" alt="Product Image">
                <h5 class="product-title"><?= htmlspecialchars($row['name']) ?></h5>
                <p><?= htmlspecialchars($row['des']) ?></p>
                <h6 class="fw-bold">Price:<?= htmlspecialchars($row['price']) ?> PKR</h6>
                <button class="btn btn-purple w-100 mt-2">Buy Now</button>
            </div>
        </div>

        <?php endwhile; else: ?>

        <div class="col-12 text-center text-light">No Products Available.</div>

        <?php endif; ?>
    </div>
</div>

</body>
</html>
