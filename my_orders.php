
<?php

session_start();

include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT orders.id, orders.quantity, orders.total_price, orders.order_date, orders.status,
               products.name, products.id AS product_id
        FROM orders
        JOIN products ON orders.product_id = products.id
        WHERE orders.user_id = '$user_id'
        ORDER BY orders.order_date DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Orders - Grocery Mart</title>

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

        .empty {
            text-align: center;
            background-color: white;
            padding: 30px;
        }

        .cancel-link {
            color: #c62828;
            text-decoration: none;
            font-weight: bold;
        }

        .status-processing {
            color: #e65100;
            font-weight: bold;
        }

        .status-dispatched {
            color: #1b5e20;
            font-weight: bold;
        }

        .no-action {
            color: #999;
            font-size: 13px;
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

    <a href="cart.php">Cart</a>

    <a href="my_orders.php">My Orders</a>

</nav>

<div class="welcome-bar">
    Welcome, <?php echo $_SESSION['user_name']; ?>!
    <a href="logout.php">Logout</a>
</div>

<div class="container">

    <h2>My Orders</h2>

    <?php if (mysqli_num_rows($result) == 0) { ?>

        <div class="empty">
            <h3>You have no orders yet.</h3>
            <a href="products.php">Start Shopping</a>
        </div>

    <?php } else { ?>

        <table>

            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['quantity']; ?></td>

                <td>₹<?php echo $row['total_price']; ?></td>

                <td><?php echo $row['order_date']; ?></td>

                <td>
                    <?php if ($row['status'] == 'Dispatched') { ?>
                        <span class="status-dispatched">Dispatched</span>
                    <?php } else { ?>
                        <span class="status-processing">Processing</span>
                    <?php } ?>
                </td>

                <td>
                    <?php if ($row['status'] != 'Dispatched') { ?>
                        <a href="cancel_order.php?id=<?php echo $row['id']; ?>" class="cancel-link">Cancel</a>
                    <?php } else { ?>
                        <span class="no-action">Not cancellable</span>
                    <?php } ?>
                </td>

            </tr>

            <?php } ?>

        </table>

    <?php } ?>

</div>

</body>

</html>