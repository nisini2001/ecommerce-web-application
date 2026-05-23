<?php
session_start();

include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Please login first";
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['cart']) || empty($data['cart'])) {
    echo "Cart is empty";
    exit;
}

$cartItems = [];
$productIds = [];

foreach ($data['cart'] as $item) {
    $productId = isset($item['id']) ? (int)$item['id'] : 0;
    $quantity = isset($item['quantity']) ? max(1, (int)$item['quantity']) : 1;

    if ($productId <= 0) {
        continue;
    }

    $productIds[] = $productId;
    $cartItems[$productId] = [
        'quantity' => $quantity
    ];
}

$productIds = array_unique($productIds);

if (count($productIds) === 0) {
    echo "Cart is empty";
    exit;
}

$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$sql = "SELECT id, name, price FROM products WHERE id IN ($placeholders)";
$stmt = $conn->prepare($sql);
$types = str_repeat('i', count($productIds));
$stmt->bind_param($types, ...$productIds);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[$row['id']] = $row;
}

if (count($products) === 0) {
    echo "Invalid cart items";
    exit;
}

$total = 0;
foreach ($cartItems as $productId => $item) {
    if (!isset($products[$productId])) {
        echo "Invalid cart item";
        exit;
    }

    $product = $products[$productId];
    $quantity = $item['quantity'];
    $total += $product['price'] * $quantity;
}

if ($total <= 0) {
    echo "Invalid cart total";
    exit;
}

$userId = $_SESSION['user_id'];
$conn->begin_transaction();

$sql = "INSERT INTO orders (user_id, total) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $userId, $total);

if (!$stmt->execute()) {
    $conn->rollback();
    echo "Order failed";
    exit;
}

$orderId = $conn->insert_id;
$itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");

foreach ($cartItems as $productId => $item) {
    $product = $products[$productId];
    $quantity = $item['quantity'];
    $price = $product['price'];
    $productName = $product['name'];

    $itemStmt->bind_param("iisdi", $orderId, $productId, $productName, $price, $quantity);
    if (!$itemStmt->execute()) {
        $conn->rollback();
        echo "Order failed";
        exit;
    }
}

$conn->commit();

echo "Order placed successfully";
$itemStmt->close();
$stmt->close();
$conn->close();
?>