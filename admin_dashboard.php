
<?php

session_start();

include "db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard - Grocery Mart</title>

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

        .top-bar {
            background-color: #e8f5e9;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: #1b5e20;
        }

        .top-bar a {
            color: #c62828;
            margin-left: 15px;
            text-decoration: none;
        }

        .container {
            width: 95%;
            margin: 30px auto;
        }

        h2 {
            text-align: center;
        }

        .add-button {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 20px;
            background-color: #1b5e20;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .add-button:hover {
            background-color: #2e7d32;
        }

        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
        }

        th {
            background-color: #1b5e20;
            color: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .edit-link {
            color: #1565c0;
            text-decoration: none;
            margin-right: 10px;
        }

        .delete-link {
            color: #c62828;
            text-decoration: none;
        }

    </style>

</head>

<body>

<header>
    <h1>Admin Dashboard - Grocery Mart</h1>
</header>

<nav>
    <a href="admin_dashboard.php">Manage Products</a>
    <a href="admin_orders.php">All Orders</a>
</nav>

<div class="top-bar">
    Logged in as Admin
    <a href="admin_logout.php">Logout</a>
</div>

<div class="container">

    <h2>Manage Products</h2>

    <a href="admin_add_product.php" class="add-button">+ Add New Product</a>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>

            <td><?php echo $row['id']; ?></td>

            <td><?php echo $row['name']; ?></td>

            <td><?php echo $row['description']; ?></td>

            <td>₹<?php echo $row['price']; ?></td>

            <td><?php echo $row['stock']; ?></td>

            <td><?php echo $row['category']; ?></td>

            <td><?php echo $row['image']; ?></td>

            <td>
                <a href="admin_edit_product.php?id=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                <a href="admin_delete_product.php?id=<?php echo $row['id']; ?>" class="delete-link">Delete</a>
            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>

</html>