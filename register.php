
<?php

include "db.php";

$message = "";

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_sql = "SELECT * FROM user WHERE email='$email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {

        $message = "This email is already registered. Please login instead.";

    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (name, email, password)
                VALUES ('$name', '$email', '$hashedPassword')";

        if (mysqli_query($conn, $sql)) {
            $message = "Registration successful!";
        } else {
            $message = "Registration failed: " . mysqli_error($conn);
        }

    }

}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Register - Grocery Mart</title>

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

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #2e7d32;
            text-decoration: none;
        }

        .back {
            text-align: center;
            margin-top: 15px;
        }

        .back a {
            color: #555;
            text-decoration: none;
        }

    </style>

</head>

<body>

<header>
    <h1>🛒 Grocery Mart</h1>
</header>

<div class="container">

    <h2>Create Account</h2>

    <form method="POST">

        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="register">
            Register
        </button>

    </form>

    <?php if ($message != "") { ?>

        <div class="message">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <div class="login-link">
        Already have an account?
        <a href="login.php">Login</a>
    </div>

    <div class="back">
        <a href="index.php">← Back to Home</a>
    </div>

</div>

</body>
</html>