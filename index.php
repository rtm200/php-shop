<?php 
include_once 'classes/fetch.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="components/header.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include_once 'components/header.php'; ?>
    <main>
        <section class="home">
            <div class="home-left">
                <h2>Blaw Blaw <span style="color: white; -webkit-text-stroke: 2px black;">Blaw</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel deleniti facere ea fugiat molestias dolor facilis aliquam veritatis dolorum repellendus. Eveniet quasi sed nisi neque ex magni, fugiat ipsa incidunt!</p>
                <div class="home-left-buttons">
                    <button class="home-left-buttons-first">Download App</button>
                    <button class="home-left-buttons-second">Our Places</button>
                </div>
            </div>
            <div class="home-right">
                <img src="img/raw.png">
                <div class="home-right-card">
                    <span class="stars">
                        <i class='bx bxs-star' ></i>
                        <i class='bx bxs-star' ></i>
                        <i class='bx bxs-star' ></i>
                        <i class='bx bxs-star' ></i>
                        <i class='bx bxs-star' ></i>
                    </span>
                    <span class="comment">blaw blaw blaw blaw blaw blaw</span>
                </div>
            </div>
        </section>
        <section id="products" class="products">
            <h3>All the Products</h3>
            <div class="productCards">
                <?php 
                    include_once 'classes/fetch.php';            
                    $get = new GET();

                    $productsPerPage = 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $productsPerPage;

                    $totalProducts = $get->getTotalProducts();
                    $totalPages = ceil($totalProducts / $productsPerPage);

                    $get->getProductsPaginated($offset, $productsPerPage);

                ?>
            </div>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>#products" <?php echo $i === $page ? 'class="active"' : ''; ?>>
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
<script>
    $(document).on('click', '.buy', function () {
        const productId = $(this).attr('product-id');

        $.ajax({
            url: 'classes/add_to_cart.php',
            type: 'POST',
            data: { product_id: productId },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
</script>
</html>