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

DELETE FROM products

WHERE id=?

";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i",$id);

if($stmt->execute()){
    header("Location:products.php");
    exit;
}else{
    echo "Delete Failed";
}

?>