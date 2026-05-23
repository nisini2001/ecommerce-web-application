<?php

session_start();

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

include("config/db.php");

$order_id =
$_GET['id'];

$user_id =
$_SESSION['user_id'];

// VERIFY ORDER BELONGS TO USER
$stmt = $conn->prepare(

    "SELECT *

    FROM orders

    WHERE id=?
    AND user_id=?"
);

$stmt->bind_param(
    "ii",
    $order_id,
    $user_id
);

$stmt->execute();

$orderResult =
$stmt->get_result();

if($orderResult->num_rows === 0){

    die("Access Denied");
}

// GET ITEMS
$stmt = $conn->prepare(

    "SELECT *

    FROM order_items

    WHERE order_id=?"
);

$stmt->bind_param(
    "i",
    $order_id
);

$stmt->execute();

$result =
$stmt->get_result();

?>

<!DOCTYPE html>

<html>

<head>

    <title>Order Details</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <h1>

        Order Details

    </h1>

    <a href="orders.php">

        Back Orders

    </a>

    <br><br>

    <table
    border="1"
    cellpadding="10">

        <tr>

            <th>Product</th>

            <th>Price</th>

            <th>Quantity</th>

            <th>Subtotal</th>

        </tr>

        <?php

        $grandTotal = 0;

        while(
            $item =
            $result->fetch_assoc()
        ){

            $subtotal =

            $item['price']
            *
            $item['quantity'];

            $grandTotal +=
            $subtotal;

        ?>

        <tr>

            <td>

                <?php
                echo $item['product_name'];
                ?>

            </td>

            <td>

                $

                <?php
                echo number_format(
                    $item['price'],
                    2
                );
                ?>

            </td>

            <td>

                <?php
                echo $item['quantity'];
                ?>

            </td>

            <td>

                $

                <?php
                echo number_format(
                    $subtotal,
                    2
                );
                ?>

            </td>

        </tr>

        <?php
        }
        ?>

        <tr>

            <td colspan="3">

                <strong>

                    Total

                </strong>

            </td>

            <td>

                <strong>

                    $

                    <?php
                    echo number_format(
                        $grandTotal,
                        2
                    );
                    ?>

                </strong>

            </td>

        </tr>

    </table>

</body>

</html>