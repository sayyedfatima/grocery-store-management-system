
<?php

session_start();

include "db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['dispatch_order'])) {

    $order_id = $_POST['order_id'];

    $update = "UPDATE orders SET status='Dispatched' WHERE id='$order_id'";
    mysqli_query($conn, $update);

}

$sql = "SELECT orders.id, orders.quantity, orders.total_price, orders.order_date, orders.status,
               products.name AS product_name,
               user.name AS customer_name, user.email AS customer_email
        FROM orders
        JOIN products ON orders.product_id = products.id
        JOIN user ON orders.user_id = user.id
        ORDER BY orders.order_date DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>All Orders - Admin</title>

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

        .container {
            width: 95%;
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
            background-color: #1b5e20;
            color: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .empty {
            text-align: center;
            background-color: white;
            padding: 30px;
        }

        .status-processing {
            color: #e65100;
            font-weight: bold;
        }

        .status-dispatched {
            color: #1b5e20;
            font-weight: bold;
        }

        .dispatch-button {
            padding: 6px 12px;
            background-color: #1565c0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .dispatch-button:hover {
            background-color: #0d47a1;
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

    <h2>All Customer Orders</h2>

    <?php if (mysqli_num_rows($result) == 0) { ?>

        <div class="empty">
            <h3>No orders placed yet.</h3>
        </div>

    <?php } else { ?>

        <table>

            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
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

                <td><?php echo $row['customer_name']; ?></td>

                <td><?php echo $row['customer_email']; ?></td>

                <td><?php echo $row['product_name']; ?></td>

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
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="dispatch_order" class="dispatch-button">
                                Mark Dispatched
                            </button>
                        </form>
                    <?php } else { ?>
                        —
                    <?php } ?>
                </td>

            </tr>

            <?php } ?>

        </table>

    <?php } ?>

</div>

</body>

</html>