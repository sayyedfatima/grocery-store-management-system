# 🛒 Grocery Store Management System

A simple, beginner-level web-based Grocery Store Management System built using **HTML, CSS, PHP, and MySQL**. This project was developed as a B.Sc. Computer Science college project, focusing on core web development concepts without using JavaScript.

## 📌 Features

### Customer Side
- User registration with secure password hashing
- Login/logout with session management
- Browse products with images, price, stock, and category
- Add products to cart
- Apply discount coupons (e.g. SAVE10, SAVE20)
- Billing page with subtotal, discount, and final amount
- Place orders with automatic stock deduction
- Stock validation (prevents ordering more than available)
- View order history ("My Orders")
- Cancel orders (only while status is "Processing")

### Admin Side
- Separate admin login
- Add, edit, and delete products
- View all customer orders with customer details
- Mark orders as "Dispatched" (locks them from cancellation)
- Admin logout

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML5, CSS3 |
| Backend | PHP |
| Database | MySQL |
| Server | Apache (via XAMPP) |
| DB Management | phpMyAdmin |

**Note:** No JavaScript was used in this project — all logic is handled server-side using PHP, per project requirements.

## 🗄️ Database Structure

The project uses a MySQL database named `grocery_store` with the following tables:

- **products** — stores product details (name, price, stock, category, image)
- **user** — stores customer accounts (name, email, hashed password)
- **orders** — stores order records (user, product, quantity, total price, status)
- **coupons** — stores discount coupon codes

## 🚀 How to Run This Project Locally

1. Install [XAMPP](https://www.apachefriends.org/) on your system.
2. Copy this project folder into `C:\xampp\htdocs\`
3. Start **Apache** and **MySQL** from the XAMPP Control Panel.
4. Open `http://localhost/phpmyadmin` and create a database named `grocery_store`.
5. Import the database structure (tables: `products`, `user`, `orders`, `coupons`).
6. Visit `http://localhost/grocery-store/index.php` in your browser.

### Default Admin Login
- **Username:** admin
- **Password:** admin123

## 📸 Screenshots

*(Add a few screenshots of your website here once available)*

## 📄 Project Documentation

Full project documentation, including database schema and workflow, is included in the repository as a Word document.

## 👩‍💻 Author

Developed by Fatima as a college mini-project for B.Sc. Computer Science.