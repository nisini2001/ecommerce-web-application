<?php

session_start();

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

if($_SESSION['role'] !== 'admin'){

    die("Access Denied");
}

include("../config/db.php");

$sql = "

SELECT

orders.id,
orders.total,
orders.status,
orders.created_at,

users.email

FROM orders

JOIN users
ON orders.user_id = users.id

ORDER BY orders.id DESC

";

$result = $conn->query($sql);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Manage Orders</title>

    <link rel="stylesheet"
    href="../assets/css/style.css">

</head>

<body>

    <h1>Manage Orders</h1>

   <a href="dashboard.php">

    Back Dashboard

</a>

|

<a href="../index.php">

    Visit Website

</a>

|

<a href="logout.php">

    Logout

</a>

    <br><br>

    <table
    border="1"
    cellpadding="10">

        <tr>

            <th>Order ID</th>

            <th>Customer</th>

            <th>Total</th>

            <th>Status</th>

            <th>Date</th>

            <th>View Items</th>

        </tr>

        <?php

        while(
            $order =
            $result->fetch_assoc()
        ){

        ?>

        <tr>

            <td>

                <?php
                echo $order['id'];
                ?>

            </td>

            <td>

                <?php
                echo $order['email'];
                ?>

            </td>

            <td>

                $

                <?php
                echo number_format(
                    $order['total'],
                    2
                );
                ?>

            </td>

            <td>

                <form
                action="updateOrderStatus.php"
                method="POST">

                    <input
                    type="hidden"
                    name="order_id"
                    value="<?php echo $order['id']; ?>">

                    <select name="status">

                        <option
                        value="Pending"
                        <?php
                        if($order['status'] == 'Pending'){
                            echo 'selected';
                        }
                        ?>>

                            Pending

                        </option>

                        <option
                        value="Processing"
                        <?php
                        if($order['status'] == 'Processing'){
                            echo 'selected';
                        }
                        ?>>

                            Processing

                        </option>

                        <option
                        value="Shipped"
                        <?php
                        if($order['status'] == 'Shipped'){
                            echo 'selected';
                        }
                        ?>>

                            Shipped

                        </option>

                        <option
                        value="Delivered"
                        <?php
                        if($order['status'] == 'Delivered'){
                            echo 'selected';
                        }
                        ?>>

                            Delivered

                        </option>

                        <option
                        value="Cancelled"
                        <?php
                        if($order['status'] == 'Cancelled'){
                            echo 'selected';
                        }
                        ?>>

                            Cancelled

                        </option>

                    </select>

                    <button type="submit">

                        Update

                    </button>

                </form>

            </td>

            <td>

                <?php
                echo $order['created_at'];
                ?>

            </td>

            <td>

                <a
                href="orderDetails.php?id=<?php echo $order['id']; ?>">

                    View

                </a>

            </td>

        </tr>

        <?php
        }
        ?>

    </table>

</body>

</html>