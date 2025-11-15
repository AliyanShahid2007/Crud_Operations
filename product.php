<?php
    include "dbs.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #4a148c, #7b1fa2, #9c27b0);
            min-height: 100vh;
            margin: 0;
            padding-top: 70px;
            color: white;
            font-family: Arial, sans-serif;
        }

        /* Navbar Styling */
        .nav-bar {
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

        .nav-brand {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .nav-toggle {
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

        /* Normal nav links */
        .nav-links a:not(.btn-exit) {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:not(.btn-exit):hover {
            color: #f3e5f5;
        }

        /* Logout button styling */
        .nav-links a.btn-exit {
            background: #ffffff;
            color: #6a1b9a !important;
            padding: 0.4rem 0.9rem;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .nav-links a.btn-exit:hover {
            background: #4a148c;
            color: #fff !important;
            box-shadow: 0 3px 10px rgba(0,0,0,0.25);
        }

        @media (max-width: 768px) {
            .nav-toggle {
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
        .add-card {
            max-width: 500px;
            width: 100%;
            border-radius: 15px;
            background: white;
            color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin: auto;
            padding: 30px;
        }

        h3 {
            color: #4a148c;
            font-weight: 700;
        }

        /* Purple button styling */
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
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="nav-bar" role="navigation" aria-label="Primary Navigation">
    <div class="nav-container">
        <a href="index.php" class="nav-brand">AS-Ltd</a>
        <button class="nav-toggle" aria-expanded="false" aria-controls="mainNav" aria-label="Toggle navigation">
            &#9776;
        </button>
        <div class="nav-links" id="mainNav">
        <a href="dashboard.php">Home</a>
      <a href="index.php">Users</a>
      <a href="create.php">Add User</a>
      <a href="product.php">Add Product</a>
      <a href="showproduct.php">Products</a>
      <a href="login.php" class="btn-exit">Logout</a>
        
        </div>
    </div>
</nav>
<!-- End Navbar -->

<div class="add-card mt-5">
    <h3 class="text-center mb-4">Add product</h3>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Product Img</label>
            <input type="file" class="form-control" name="pro_img" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Des:</label>
            <input type="text" class="form-control" name="des" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price:</label>
            <input type="text" class="form-control" name="price" required>
        </div>

        <div class="d-grid">
            <button type="submit" name="add" class="btn btn-purple">Add Product</button>
        </div>
    </form>

</div>

<?php
    if(isset($_POST['add'])){
        $name = $conn->real_escape_string($_POST['name']);
        $des = $conn->real_escape_string($_POST['des']);
        $price= $conn->real_escape_string($_POST['price']);

           $target_dir = "products_Img/";
        if(!is_dir($target_dir)){
            mkdir($target_dir,0777,true);
        }

        $target_file = $target_dir . time() . "-" . basename($_FILES["pro_img"]["name"]);
        move_uploaded_file($_FILES["pro_img"]["tmp_name"],$target_file);



        $sql = "INSERT INTO products(name, des, price, pro_img) VALUES('$name','$des','$price','$target_file')";

        if($conn->query($sql)){
            echo "<script>alert('Product Added'); window.location='showproduct.php';</script>";
        }
        else{
            echo "Error: " . $conn->error;
        }
    }
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Navbar toggle script -->
<script>
    const toggleBtn = document.querySelector('.nav-toggle');
    const menu = document.querySelector('.nav-links');

    toggleBtn.addEventListener('click', () => {
        const expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        toggleBtn.setAttribute('aria-expanded', !expanded);
        menu.classList.toggle('active');
    });
</script>

</body>
</html>
