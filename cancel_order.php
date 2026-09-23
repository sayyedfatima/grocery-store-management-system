
<?php

session_start();

include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {

    $order_id = $_GET['id'];

    $sql = "SELECT * FROM orders WHERE id='$order_id' AND user_id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $order = mysqli_fetch_assoc($result);

    if ($order && $order['status'] != 'Dispatched') {

        $product_id = $order['product_id'];
        $quantity = $order['quantity'];

        $restore_stock = "UPDATE products SET stock = stock + '$quantity' WHERE id='$product_id'";
        mysqli_query($conn, $restore_stock);

        $delete_order = "DELETE FROM orders WHERE id='$order_id'";
        mysqli_query($conn, $delete_order);

    }

}

header("Location: my_orders.php");
exit();

?>