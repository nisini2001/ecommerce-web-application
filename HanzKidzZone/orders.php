<?php

session_start();

include("config/db.php");

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

$user_id =
$_SESSION['user_id'];

$stmt = $conn->prepare(

    "SELECT *

    FROM orders

    WHERE user_id=?

    ORDER BY created_at DESC"
);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$orders =
$stmt->get_result();

?>

<!DOCTYPE html>

<html>

<head>

    <title>My Orders</title>

    <link rel="stylesheet"
    href="style.css">

</head>

<body>

    <h1>

        My Orders

    </h1>

    <a href="index.php">

        Back Home

    </a>

    <br><br>

    <?php

    if($orders->num_rows == 0){

        echo "<p>No Orders Found</p>";
    }

    while(
        $order =
        $orders->fetch_assoc()
    ){

    ?>

    <div class="order-box">

        <h3>

            Order #

            <?php
            echo $order['id'];
            ?>

        </h3>

        <p>

            <strong>Total:</strong>

            $

            <?php
            echo number_format(
                $order['total'],
                2
            );
            ?>

        </p>

        <p>

            <strong>Status:</strong>

            <?php
            echo $order['status'];
            ?>

        </p>

        <p>

            <strong>Date:</strong>

            <?php
            echo $order['created_at'];
            ?>

        </p>

        <a
        href="orderDetails.php?id=<?php echo $order['id']; ?>">

            View Details

        </a>

    </div>

    <hr>

    <?php
    }
    ?>

</body>

</html>