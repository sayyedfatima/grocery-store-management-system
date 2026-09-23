<?php

session_start();

include "db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE id='$id'";

    mysqli_query($conn, $sql);

}

header("Location: admin_dashboard.php");
exit();

?>