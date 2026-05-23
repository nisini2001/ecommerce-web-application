<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "hanzkidz_db"
);

if($conn->connect_error){
    die("Connection failed");
}

?>