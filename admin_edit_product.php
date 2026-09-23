<?php

session_start();

include "db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];

if (isset($_POST['update_product'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    $sql = "UPDATE products
            SET name='$name', description='$description', price='$price',
                stock='$stock', category='$category', image='$image'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $message = "Failed to update product: " . mysqli_error($conn);
    }

}

$result = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: admin_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Product - Admin</title>

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
    <h1>Edit Product</h1>
</header>

<div class="container">

    <h2>Update Product Details</h2>

    <form method="POST">

        <label>Product Name</label>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

        <label>Description</label>
        <input type="text" name="description" value="<?php echo $product['description']; ?>" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>

        <label>Category</label>
        <input type="text" name="category" value="<?php echo $product['category']; ?>" required>

        <label>Image Filename</label>
        <input type="text" name="image" value="<?php echo $product['image']; ?>">

        <button type="submit" name="update_product">
            Update Product
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