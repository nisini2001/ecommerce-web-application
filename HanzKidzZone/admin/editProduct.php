<?php

session_start();

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

if($_SESSION['role'] !== 'admin'){

    die("Access Denied");
}

include("../config/db.php");

$id = $_GET['id'];

$sql = "

SELECT * FROM products

WHERE id=?

";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();

$product = $result->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

    <title>Edit Product</title>

    <link rel="stylesheet"
    href="../assets/css/style.css">

</head>

<body>

    <div class="form-container">

        <h1>Edit Product</h1>

        <form
            action="updateProduct.php"
            method="POST"
            enctype="multipart/form-data"
        >

            <input
                type="hidden"
                name="id"
                value="<?php echo $product['id']; ?>"
            >

            <input
                type="text"
                name="name"
                value="<?php echo $product['name']; ?>"
                required
            >

            <input
                type="number"
                step="0.01"
                name="price"
                value="<?php echo $product['price']; ?>"
                required
            >

            <select name="category" required>

                <option value="Toys"
                <?php
                if($product['category'] == 'Toys'){
                    echo 'selected';
                }
                ?>>

                    Toys

                </option>

                <option value="Clothes"
                <?php
                if($product['category'] == 'Clothes'){
                    echo 'selected';
                }
                ?>>

                    Clothes

                </option>

                <option value="Books"
                <?php
                if($product['category'] == 'Books'){
                    echo 'selected';
                }
                ?>>

                    Books

                </option>

                <option value="Accessories"
                <?php
                if($product['category'] == 'Accessories'){
                    echo 'selected';
                }
                ?>>

                    Accessories

                </option>

                <option value="General"
                <?php
                if($product['category'] == 'General'){
                    echo 'selected';
                }
                ?>>

                    General

                </option>

            </select>

            <br><br>

            <img
            src="../<?php echo $product['image']; ?>"
            width="120">

            <br><br>

            <input
                type="file"
                name="image"
            >

            <br><br>

            <button type="submit">

                Update Product

            </button>

        </form>

    </div>

</body>

</html>