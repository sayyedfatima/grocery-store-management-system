
<?php

session_start();

include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];

$discount_percent = $_SESSION['coupon_discount'] ?? 0;

$order_placed = false;
$error_message = "";
$placed_total = 0;

if (isset($_POST['place_order']) && !empty($cart)) {

    $user_id = $_SESSION['user_id'];
    $stock_ok = true;

    foreach ($cart as $product_id => $quantity) {

        $sql = "SELECT * FROM products WHERE id='$product_id'";
        $result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($result);

        if ($product && $quantity > $product['stock']) {
            $stock_ok = false;
            $error_message = "Not enough stock for " . $product['name'] . ". Only " . $product['stock'] . " left.";
            break;
        }

    }

    if ($stock_ok) {

        foreach ($cart as $product_id => $quantity) {

            $sql = "SELECT * FROM products WHERE id='$product_id'";
            $result = mysqli_query($conn, $sql);
            $product = mysqli_fetch_assoc($result);

            if ($product) {

                $line_total = $product['price'] * $quantity;
                $line_discount = ($line_total * $discount_percent) / 100;
                $final_line_total = $line_total - $line_discount;

                $placed_total = $placed_total + $final_line_total;

                $insert = "INSERT INTO orders (user_id, product_id, quantity, total_price, order_date, status)
                           VALUES ('$user_id', '$product_id', '$quantity', '$final_line_total', NOW(), 'Processing')";

                mysqli_query($conn, $insert);

                $new_stock = $product['stock'] - $quantity;

                $update_stock = "UPDATE products SET stock='$new_stock' WHERE id='$product_id'";

                mysqli_query($conn, $update_stock);

            }

        }

        $_SESSION['cart'] = [];
        $cart = [];
        $_SESSION['coupon_discount'] = 0;

        $order_placed = true;

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Bill - Grocery Mart</title>

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
            max-width: 700px;
            margin: 30px auto;
        }

        h2 {
            text-align: center;
        }

        .bill-box {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: green;
            color: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 16px;
        }

        .grand-total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 20px;
            font-weight: bold;
            color: #1b5e20;
            border-top: 2px solid #ccc;
            margin-top: 10px;
        }

        .bill-mode {
            margin-top: 20px;
        }

        .bill-mode label {
            display: block;
            margin-top: 8px;
        }

        .confirm-button {
            display: block;
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .confirm-button:hover {
            background-color: darkgreen;
        }

        .empty {
            text-align: center;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
        }

        .success-box {
            text-align: center;
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 6px;
        }

        .success-amount {
            font-size: 28px;
            margin: 15px 0;
            color: #1b5e20;
        }

        .error-box {
            text-align: center;
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            margin-bottom: 20px;
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

    <h2>Your Bill</h2>

    <?php if ($order_placed) { ?>

        <div class="success-box">
            Your order has been placed successfully!
            <div class="success-amount">
                Total Paid: ₹<?php echo $placed_total; ?>
            </div>
            <a href="my_orders.php">View My Orders</a>
            &nbsp; | &nbsp;
            <a href="products.php">Continue Shopping</a>
        </div>

    <?php } elseif (empty($cart)) { ?>

        <div class="empty">
            <h3>Your cart is empty.</h3>
            <a href="products.php">Continue Shopping</a>
        </div>

    <?php } else { ?>

        <?php if ($error_message != "") { ?>
            <div class="error-box">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>

        <div class="bill-box">

            <table>

                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>

                <?php

                $grand_total = 0;

                foreach ($cart as $product_id => $quantity) {

                    $sql = "SELECT * FROM products WHERE id='$product_id'";
                    $result = mysqli_query($conn, $sql);
                    $product = mysqli_fetch_assoc($result);

                    if ($product) {

                        $total = $product['price'] * $quantity;
                        $grand_total = $grand_total + $total;

                ?>

                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>₹<?php echo $product['price']; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>₹<?php echo $total; ?></td>
                </tr>

                <?php

                    }

                }

                $discount_amount = ($grand_total * $discount_percent) / 100;
                $final_total = $grand_total - $discount_amount;

                ?>

            </table>

            <div class="summary-row">
                <span>Bill Subtotal:</span>
                <span>₹<?php echo $grand_total; ?></span>
            </div>

            <?php if ($discount_percent > 0) { ?>
                <div class="summary-row">
                    <span>Discount (<?php echo $discount_percent; ?>%):</span>
                    <span>-₹<?php echo $discount_amount; ?></span>
                </div>
            <?php } ?>

            <div class="grand-total-row">
                <span>Final Bill Amount:</span>
                <span>₹<?php echo $final_total; ?></span>
            </div>

            <form method="POST">

                <div class="bill-mode">

                    <strong>Select Bill Mode:</strong>

                    <label>
                        <input type="radio" name="payment_method" value="COD" checked>
                        Cash on Delivery
                    </label>

                    <label>
                        <input type="radio" name="payment_method" value="UPI">
                        UPI
                    </label>

                    <label>
                        <input type="radio" name="payment_method" value="Card">
                        Debit/Credit Card
                    </label>

                </div>

                <button type="submit" name="place_order" class="confirm-button">
                    Confirm Order & Generate Bill
                </button>

            </form>

        </div>

    <?php } ?>

</div>

</body>

</html>