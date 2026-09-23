<?php

session_start();

$message = "";

$admin_username = "admin";
$admin_password = "admin123";

if (isset($_POST['admin_login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $admin_username && $password == $admin_password) {

        $_SESSION['admin_logged_in'] = true;

        header("Location: admin_dashboard.php");
        exit();

    } else {

        $message = "Invalid admin username or password.";

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Login - Grocery Mart</title>

    <style>

        body {
            font-family: Arial;
            background-color: #f4f4f4;
        }

        .container {
            width: 350px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
            color: #1b5e20;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #1b5e20;
            color: white;
            border: none;
            cursor: pointer;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            color: red;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>Admin Login</h2>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="admin_login">
            Login
        </button>

    </form>

    <?php if ($message != "") { ?>

        <div class="message">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <a href="index.php">← Back to Home</a>

</div>

</body>
</html>