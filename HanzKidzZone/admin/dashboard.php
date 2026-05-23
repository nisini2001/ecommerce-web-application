<?php

session_start();

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

if($_SESSION['role'] !== 'admin'){

    die("Access Denied");
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
    href="../assets/css/style.css">

</head>

<body>

    <div class="dashboard">
        <h1>Admin Dashboard</h1>

        <p>
            Welcome Admin
        </p>

        <nav class="dashboard-links">
            <a href="orders.php">Manage Orders</a>
            <a href="products.php">Manage Products</a>
            <a href="../index.php">Visit Website</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

</body>

</html>