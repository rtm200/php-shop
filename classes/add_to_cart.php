<?php
include_once 'db.php';

$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];

    if (!empty($productId) && is_numeric($productId)) {
        try {
            $sql = "INSERT INTO cart (product_id) VALUES (:product_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'Invalid product ID.';
    }
} else {
    echo 'Invalid request method.';
}
?>