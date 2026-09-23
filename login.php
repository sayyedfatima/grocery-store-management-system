
<?php

session_start();

include "db.php";

$message = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email' LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];

            header("Location: products.php");
            exit();

        } else {
            $message = "Invalid email or password.";
        }

    } else {

        $message = "Invalid email or password.";

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Login - Grocery Mart</title>

    <style>

        body {
            font-family: Arial;
            background-color: #f4f4f4;
        }

        .container {
            width: 400px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
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
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            color: green;
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

    <h2>Login</h2>

    <form method="POST">

        <label>Email</label>

        <input type="email" name="email" required>

        <label>Password</label>

        <input type="password" name="password" required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <?php if ($message != "") { ?>

        <div class="message">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <a href="forgot_password.php">Forgot Password?</a>

    <a href="register.php">Don't have an account? Register</a>

    <a href="index.php">← Back to Home</a>

</div>

</body>
</html>