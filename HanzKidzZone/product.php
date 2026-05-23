<?php

session_start();

include("config/db.php");

if(!isset($_GET['id'])){

    die("Product Not Found");
}

$id = $_GET['id'];

$stmt = $conn->prepare(

    "SELECT * FROM products WHERE id=?"
);

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){

    die("Product Not Found");
}

$product = $result->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

    <title>

        <?php echo $product['name']; ?>

    </title>

    <link
    rel="stylesheet"
    href="style.css">

</head>

<body>

    <header>

        <h1>Hanz Kidz Zone</h1>

        <a href="index.php">

            Back To Shop

        </a>

    </header>

    <div class="product-details">

        <img
        src="<?php echo $product['image']; ?>"
        width="300">

        <h2>

            <?php
            echo $product['name'];
            ?>

        </h2>

        <p>

            Price:
            $

            <?php
            echo number_format(
                $product['price'],
                2
            );
            ?>

        </p>

        <p>

            Category:

            <?php
            echo $product['category'];
            ?>

        </p>

        <p>

            Stock:

            <?php
            echo $product['stock'];
            ?>

        </p>

        <button
        onclick="addToCart(<?php echo $product['id']; ?>)">

            Add To Cart

        </button>

    </div>

    <script>

        function addToCart(productId){

            let cart =
            JSON.parse(
                localStorage.getItem("cart")
            ) || [];

            const existing =
            cart.find(
                item => item.id == productId
            );

            if(existing){

                existing.quantity += 1;

            }else{

                cart.push({

                    id: productId,

                    quantity: 1
                });
            }

            localStorage.setItem(
                "cart",
                JSON.stringify(cart)
            );

            alert("Added To Cart");
        }

    </script>

</body>

</html>