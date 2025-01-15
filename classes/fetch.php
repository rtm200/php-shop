<?php
include_once 'db.php';

$db = new Database();
$conn = $db->connect();

class GET {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect(); 
    }

    public function getTotalProducts() {
        $sql = "SELECT COUNT(*) AS total FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    public function getProductsPaginated($offset, $limit) {
        $sql = "SELECT * FROM products LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $image = $row['image'];
            $info = $row['info'];
            $rate = $row['rating'];
            $filledStars = str_repeat('<i class="bx bxs-star"></i>', $rate);
            $emptyStars = str_repeat('<i class="bx bx-star"></i>', 5 - $rate);
    
            echo '
                <div class="productCard">
                    <img src="' . $image . '">
                    <div class="productCard-content">
                        <div style="flex-wrap: wrap; display: flex; align-items: center; justify-content: space-between;">
                            <h4>' . $name . '</h4>
                            <h5>' . $price . '$</h5>
                        </div>
                        <span class="productLine"></span>
                        <p>' . $info . '</p>
                        <div style="margin-top: 10px; flex-wrap: wrap; display: flex; align-items: center; justify-content: space-between;">
                            <span class="productRates">
                                ' . $filledStars . $emptyStars . '
                            </span>
                            <button class="buy" product-id="' . $id . '">BUY</button>
                        </div>
                    </div>
                </div>
            ';
        }
    }
    public function getCartProducts() {
        $sql = "
            SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.image 
            FROM cart c
            JOIN products p ON c.product_id = p.id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cart_id = $row['cart_id'];
            $product_id = $row['product_id'];
            $name = $row['name'];
            $price = $row['price'];
            $image = $row['image'];
    
            echo '
                <div class="cardModal-top-product">
                    <div class="cardModal-top-product-left">
                        <img src="' . $image . '" alt="' . $name . '">
                        <div style="display: flex; flex-direction: column; gap:1px;">
                            <span style="line-height: 15px;">' . $name . '</span>
                            <span style="font-size: 0.75rem; color: grey; font-weight: 600;">' . $price . '$</span>
                        </div>
                    </div>
                    <span class="deleteProduct" data-cart-id="' . $cart_id . '">
                        <i class="bx bxs-trash"></i>
                    </span>
                </div>
            ';
        }
    }

    public function getCartNumber() {
        $sql = "SELECT COUNT(*) as count FROM cart";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    
    public function getPrice() {
        $sql = "
            SELECT SUM(p.price) AS total_price
            FROM cart c
            JOIN products p ON c.product_id = p.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total_price'] ?? 0;
    }
}

?>