

<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
$userRole = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hanz Kidz Zone</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header>

    <div class="logo">
        <h1>Hanz Kidz Zone</h1>
    </div>

    <div class="header-right">
        <div class="cart-badge">
            Cart:
            <span id="cart-count">0</span>
        </div>
        <div class="auth-links">
            <?php if ($loggedIn): ?>
                <?php if ($userRole === 'admin'): ?>
                    <a class="btn" href="admin/dashboard.php">Admin Dashboard</a>
                <?php else: ?>
                    <a class="btn" href="orders.php">My Orders</a>
                <?php endif; ?>
                <a class="btn logout-btn" href="logout.php">Logout</a>
            <?php else: ?>
                <a class="btn" href="login.php">Login</a>
                <a class="btn" href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>

</header>

<section class="search-section">

    <input
        type="text"
        id="search-input"
        placeholder="Search products..."
        onkeyup="searchProducts()"
    >

</section>

<div
    class="category-buttons"
    id="category-buttons">
</div>

<div id="products"></div>

<section class="cart-section">

    <h2>Shopping Cart</h2>

    <div id="cart-items"></div>

    <h3 id="total-price">

        Total: $0.00

    </h3>

    <button
        class="checkout-btn"
        id="checkout-btn">

        Checkout

    </button>

</section>

<script src="assets/js/script.js"></script>

</body>

</html>