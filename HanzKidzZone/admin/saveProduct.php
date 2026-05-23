<?php

session_start();

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

if($_SESSION['role'] !== 'admin'){

    die("Access Denied");
}

include("../config/db.php");

// VALIDATE INPUTS
$name =
trim($_POST['name']);

$price =
trim($_POST['price']);

$category =
trim($_POST['category']);

$stock =
trim($_POST['stock']);

$description =
trim($_POST['description']);

if(

    

   empty($category) ||

   empty($description) ||

    $stock === ""

){

    die("All Fields Required");
}

// IMAGE
$imageName =
$_FILES['image']['name'];

$tempName =
$_FILES['image']['tmp_name'];

// CREATE UNIQUE IMAGE NAME
$newImageName =

time()

. "_"

. basename($imageName);

$uploadPath =

"../uploads/"

. $newImageName;

// MOVE IMAGE
if(

    !move_uploaded_file(
        $tempName,
        $uploadPath
    )

){

    die("Image Upload Failed");
}

// SAVE PATH TO DB
$imagePath =

"uploads/"

. $newImageName;

// INSERT PRODUCT
$sql = "

INSERT INTO products

(
    name,
    price,
    category,
    description,
    image,
    stock
)

VALUES

(?,?,?,?,?,?)
";

$stmt = $conn->prepare($sql);

if(!$stmt){

    die(

        "Prepare Failed: "

        .

        $conn->error
    );
}

$stmt->bind_param(

    "sdsssi",

    $name,
    $price,
    $category,
    $description,
    $imagePath,
    $stock
);

if($stmt->execute()){

    header(
        "Location:products.php"
    );

    exit;

}else{

    echo "Insert Failed";
}
?>