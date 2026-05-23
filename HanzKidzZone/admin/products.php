<?php

session_start();

include("../config/db.php");

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

if($_SESSION['role'] !== 'admin'){

    die("Access Denied");
}

$result = $conn->query(

    "SELECT * FROM products
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Manage Products</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <h1>Manage Products</h1>

    <a href="dashboard.php">

        Back To Dashboard

    </a>

    <br><br>

   <a href="addProduct.php">

        Add Product

    </a>

    <br><br>

    <table border="1"
    cellpadding="10">

        <tr>

            <th>ID</th>

            <th>Image</th>

            <th>Name</th>

            <th>Price</th>

            <th>Category</th>

            <th>Actions</th>

        </tr>

        <?php

        while($product =
        $result->fetch_assoc()){

            ?>

            <tr>

                <td>

                    <?php
                    echo $product['id'];
                    ?>

                </td>

                <td>

                    <img
                    src="../<?php echo $product['image']; ?>"
                    width="80">

                </td>

                <td>

                    <?php
                    echo $product['name'];
                    ?>

                </td>

                <td>

                    $

                    <?php
                    echo $product['price'];
                    ?>

                </td>

                <td>

                    <?php
                    echo $product['category'];
                    ?>

                </td>

                <td>

                    <a href="editProduct.php?id=<?php echo $product['id']; ?>">

                        Edit

                    </a>

                    |

                    <a href="deleteProduct.php?id=<?php echo $product['id']; ?>">

                        Delete

                    </a>

                </td>

            </tr>

            <?php
        }

        ?>

    </table>

</body>

</html>