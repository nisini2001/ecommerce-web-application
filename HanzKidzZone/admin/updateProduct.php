<?php

session_start();

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

if($_SESSION['role'] !== 'admin'){

    die("Access Denied");
}

include("../config/db.php");

$id =
$_POST['id'];

$name =
trim($_POST['name']);

$price =
trim($_POST['price']);

$category =
trim($_POST['category']);

// IF NEW IMAGE UPLOADED
if(!empty($_FILES['image']['name'])){

    $imageName =
    $_FILES['image']['name'];

    $tempName =
    $_FILES['image']['tmp_name'];

    // UNIQUE IMAGE NAME
    $newImageName =
    time() .
    "_" .
    basename($imageName);

    $folder =
    "../uploads/" .
    $newImageName;

    move_uploaded_file(
        $tempName,
        $folder
    );

    $imagePath =
    "uploads/" .
    $newImageName;

    $sql = "

    UPDATE products

    SET
    name=?,
    price=?,
    category=?,
    image=?

    WHERE id=?

    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(

        "sdssi",

        $name,
        $price,
        $category,
        $imagePath,
        $id
    );

}else{

    // WITHOUT IMAGE UPDATE
    $sql = "

    UPDATE products

    SET
    name=?,
    price=?,
    category=?

    WHERE id=?

    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(

        "sdsi",

        $name,
        $price,
        $category,
        $id
    );
}

if($stmt->execute()){

    header(
        "Location:products.php"
    );

    exit;

}else{

    echo "Update Failed";
}
?>