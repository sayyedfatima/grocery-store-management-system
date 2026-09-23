
<!DOCTYPE html>
<html>
<head>
    <title>Grocery Mart</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        header {
            background-color: #2e7d32;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #1b5e20;
            padding: 12px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-size: 16px;
        }

        .welcome {
            text-align: center;
            padding: 70px 20px;
            background-color: white;
        }

        .welcome h2 {
            font-size: 32px;
            color: #2e7d32;
        }

        .welcome p {
            font-size: 18px;
            color: #555;
        }

        .button {
            display: inline-block;
            background-color: #2e7d32;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #1b5e20;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <header>
        <h1>🛒 Grocery Mart</h1>
        <p>Fresh Products at Your Doorstep</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>

    <div class="welcome">
        <h2>Welcome to Grocery Mart</h2>

        <p>
            Shop for fresh and quality grocery products at affordable prices.
        </p>

        <a href="products.php" class="button">View Products</a>
    </div>

    <footer>
        <p>© 2026 Grocery Mart | All Rights Reserved</p>
    </footer>

</body>
</html>