<?php
include_once 'db.php';

$db = new Database();
$conn = $db->connect();

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    
    $sql = "DELETE FROM cart WHERE id = :cart_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    $stmt->execute();
        
} else {
    echo "Invalid data.";
}
?>
