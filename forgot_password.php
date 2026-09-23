<?php

include "db.php";

$message = "";

if (isset($_POST['reset'])) {

    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    $check = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");

    if (mysqli_num_rows($check) == 1) {

        $sql = "UPDATE user
                SET password='$new_password'
                WHERE email='$email'";

        if (mysqli_query($conn, $sql)) {
            $message = "Password changed successfully!";
        } else {
            $message = "Something went wrong.";
        }

    } else {

        $message = "Email not found.";

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Forgot Password - Grocery Mart</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        header {
            background-color: #2e7d32;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            width: 350px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        p {
            text-align: center;
            color: #666;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
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
            background-color: #2e7d32;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1b5e20;
        }

        .message {
            text-align: center;
            color: #2e7d32;
            margin-top: 15px;
        }

        .login {
            text-align: center;
            margin-top: 20px;
        }

        .login a {
            color: #2e7d32;
            text-decoration: none;
        }

    </style>

</head>

<body>

<header>
    <h1>🛒 Grocery Mart</h1>
</header>

<div class="container">

    <h2>Forgot Password?</h2>

    <p>Enter your email and create a new password.</p>

    <form method="POST">

        <label>Email</label>
        <input type="email" name="email" required>

        <label>New Password</label>
        <input type="password" name="new_password" required>

        <button type="submit" name="reset">
            Reset Password
        </button>

    </form>

    <?php if ($message != "") { ?>

        <div class="message">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <div class="login">
        <a href="login.php">← Back to Login</a>
    </div>

</div>

</body>
</html>