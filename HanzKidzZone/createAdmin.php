<?php

include("config/db.php");

$email = "admin@gmail.com";

$password = password_hash(
    "123456",
    PASSWORD_DEFAULT
);

$sql = "

INSERT INTO admins
(email,password)

VALUES
(?,?)

";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ss",
    $email,
    $password
);

if($stmt->execute()){

    echo "Admin Created";

}else{

    echo "Failed";
}

?>