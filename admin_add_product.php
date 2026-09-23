<?php

session_start();

include "db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    $sql = "INSERT INTO products (name, description, price, stock, category, image)
            VALUES ('$name', '$description', '$price', '$stock', '$category', '$image')";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $message = "Failed to add product: " . mysqli_error($conn);
    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Product - Admin</title>

    <style>

        body {
            font-family: Arial;
            background-color: #f4f4f4;
            margin: 0;
        }

        header {
            background-color: #1b5e20;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 450px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
            color: #1b5e20;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #1b5e20;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2e7d32;
        }

        .message {
            text-align: center;
            color: red;
            margin-top: 15px;
        }

        .back {
            text-align: center;
            margin-top: 15px;
        }

        .back a {
            color: #1b5e20;
            text-decoration: none;
        }

    </style>

</head>

<body>

<header>
    <h1>Add New Product</h1>
</header>

<div class="container">

    <h2>Product Details</h2>

    <form method="POST">

        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <input type="text" name="description" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" required>

        <label>Stock</label>
        <input type="number" name="stock" required>

        <label>Category</label>
        <input type="text" name="category" required>

        <label>Image Filename (e.g. milk.png, or leave blank)</label>
        <input type="text" name="image">

        <button type="submit" name="add_product">
            Add Product
        </button>

    </form>

    <?php if ($message != "") { ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <div class="back">
        <a href="admin_dashboard.php">← Back to Dashboard</a>
    </div>

</div>

</body>
</html>