<?php

session_start();

if(!isset($_SESSION['user_id'])){

    die("Please Login First");
}

if($_SESSION['role'] !== 'admin'){

    die("Access Denied");
}

include("../config/db.php");

$order_id =
$_POST['order_id'];

$status =
$_POST['status'];

$sql = "

UPDATE orders

SET status=?

WHERE id=?

";

$stmt = $conn->prepare($sql);

$stmt->bind_param(

    "si",

    $status,
    $order_id
);

if($stmt->execute()){

    header(
        "Location:orders.php"
    );

    exit;

}else{

    echo "Update Failed";
}
?>