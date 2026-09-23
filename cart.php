
<?php

session_start();

include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];

$discount_percent = 0;
$coupon_message = "";

if (isset($_POST['apply_coupon'])) {
    $code = $_POST['coupon_code'];
    $sql = "SELECT * FROM coupons WHERE code='$code'";
    $result = mysqli_query($conn, $sql);
    $coupon = mysqli_fetch_assoc($result);

    if ($coupon) {
        $_SESSION['coupon_discount'] = $coupon['discount_percent'];
        $coupon_message = "Coupon applied! " . $coupon['discount_percent'] . "% off.";
    } else {
        $_SESSION['coupon_discount'] = 0;
        $coupon_message = "Invalid coupon code.";
    }
}

if (isset($_SESSION['coupon_discount'])) {
    $discount_percent = $_SESSION['coupon_discount'];
}

$available_coupons = mysqli_query($conn, "SELECT * FROM coupons");

?>
<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart - Grocery Mart</title>
<style>
body { font-family: Arial; background-color: #f4f4f4; margin: 0; }
header { background-color: green; color: white; padding: 20px; text-align: center; }
nav { background-color: #333; padding: 12px; text-align: center; }
nav a { color: white; text-decoration: none; margin: 0 15px; }
.welcome-bar { background-color: #e8f5e9; padding: 10px; text-align: center; font-weight: bold; color: #2e7d32; }
.welcome-bar a { color: #c62828; margin-left: 15px; text-decoration: none; }
.container { width: 90%; margin: 30px auto; }
h2 { text-align: center; }
table { width: 100%; background-color: white; border-collapse: collapse; }
th { background-color: green; color: white; }
th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
.coupon-box { background-color: white; padding: 20px; margin-top: 20px; text-align: center; border-radius: 6px; }
.coupon-box input[type="text"] { padding: 10px; width: 200px; }
.coupon-box button { padding: 10px 20px; background-color: #1565c0; color: white; border: none; cursor: pointer; }
.coupon-message { margin-top: 10px; font-weight: bold; color: #2e7d32; }
.available-coupons { margin-top: 15px; font-size: 14px; color: #555; }
.available-coupons span { display: inline-block; background-color: #e8f5e9; color: #1b5e20; padding: 4px 10px; border-radius: 4px; margin: 3px; font-weight: bold; }
.total { text-align: right; font-size: 18px; margin-top: 20px; }
.grand-total { text-align: right; font-size: 22px; font-weight: bold; color: #1b5e20; }
.empty { text-align: center; background-color: white; padding: 30px; }
.order-button { display: block; width: 220px; margin: 20px auto 0; padding: 12px; background-color: orange; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; text-align: center; text-decoration: none; }
.order-button:hover { background-color: darkorange; }
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
<h2>My Shopping Cart</h2>

<?php if (empty($cart)) { ?>

<div class="empty">
<h3>Your cart is empty.</h3>
<a href="products.php">Continue Shopping</a>
</div>

<?php } else { ?>

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

<div class="coupon-box">
<form method="POST">
<input type="text" name="coupon_code" placeholder="Enter coupon code">
<button type="submit" name="apply_coupon">Apply Coupon</button>
</form>

<?php if ($coupon_message != "") { ?>
<div class="coupon-message"><?php echo $coupon_message; ?></div>
<?php } ?>

<div class="available-coupons">
Available Offers:
<?php while ($c = mysqli_fetch_assoc($available_coupons)) { ?>
<span><?php echo $c['code']; ?> - <?php echo $c['discount_percent']; ?>% OFF</span>
<?php } ?>
</div>

</div>

<div class="total">
Subtotal: ₹<?php echo $grand_total; ?>
</div>

<?php if ($discount_percent > 0) { ?>
<div class="total">
Discount (<?php echo $discount_percent; ?>%): -₹<?php echo $discount_amount; ?>
</div>
<?php } ?>

<div class="grand-total">
Grand Total: ₹<?php echo $final_total; ?>
</div>

<a href="order.php" class="order-button">
Proceed to Order
</a>

<?php } ?>

</div>

</body>
</html>