
<?php

session_start();

include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Grocery Products</title>

    <style>

        body {
            font-family: Arial;
            background-color: #f4f4f4;
            margin: 0;
        }

        header {
            background-color: green;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #333;
            padding: 12px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        .welcome-bar {
            background-color: #e8f5e9;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: #2e7d32;
        }

        .welcome-bar a {
            color: #c62828;
            margin-left: 15px;
            text-decoration: none;
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
        }

        th {
            background-color: green;
            color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .cart-button {
            background-color: orange;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }

        .cart-button:hover {
            background-color: darkorange;
        }

    </style>

</head>

<body>

<header>

    <h1>Grocery Mart</h1>

</header>

<nav>

    <a href="index.php">Home</a>

    <a href="products.php">Products</a>

    <a href="cart.php">View Cart</a>

    <a href="my_orders.php">My Orders</a>

</nav>

<div class="welcome-bar">
    Welcome, <?php echo $_SESSION['user_name']; ?>!
    <a href="logout.php">Logout</a>
</div>

<div class="container">

    <h2>Our Grocery Products</h2>

    <table>

        <tr>

            <th>ID</th>

            <th>Product Image</th>

            <th>Product Name</th>

            <th>Description</th>

            <th>Price</th>

            <th>Stock</th>

            <th>Category</th>

            <th>Action</th>

        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>

            <td>
                <?php echo $row['id']; ?>
            </td>

            <td>
                <?php
                    $imageFile = "images/" . $row['image'];

                    if (!empty($row['image']) && file_exists($imageFile)) {
                        echo '<img src="' . $imageFile . '" alt="' . $row['name'] . '" class="product-image">';
                    } else {
                        echo '<img src="https://placehold.co/150x150?text=' . urlencode($row['name']) . '" alt="' . $row['name'] . '" class="product-image">';
                    }
                ?>
            </td>

            <td>
                <?php echo $row['name']; ?>
            </td>

            <td>
                <?php echo $row['description']; ?>
            </td>

            <td>
                ₹<?php echo $row['price']; ?>
            </td>

            <td>
                <?php echo $row['stock']; ?>
            </td>

            <td>
                <?php echo $row['category']; ?>
            </td>

            <td>

                <form method="POST" action="add_to_cart.php">

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?php echo $row['id']; ?>"
                    >

                    <button type="submit" class="cart-button">
                        Add to Cart
                    </button>

                </form>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>

</html>