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

    <title>Add Product</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <div class="form-container">

        <h1>Add Product</h1>

       <form
    action="saveProduct.php"
    method="POST"
    enctype="multipart/form-data"
>

    <input
        type="text"
        name="name"
        placeholder="Product Name"
        required
    >

    <input
        type="number"
        step="0.01"
        name="price"
        placeholder="Price"
        required
    >

    <select name="category" required>
        <option value="">Select Category</option>
        <option value="Toys">Toys</option>
        <option value="Clothes">Clothes</option>
        <option value="Books">Books</option>
        <option value="Accessories">Accessories</option>
        <option value="General">General</option>
    </select>

    <input
        type="file"
        name="image"
        required
    >

    <button type="submit">

        Save Product

    </button>

</form>
    </div>

</body>

</html>


