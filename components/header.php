<?php 
include_once 'classes/fetch.php';

$get = new GET();


$cartCount = $get->getCartNumber();
?>
<header>
    <h2>Logo</h2>
    <div style="display: flex; gap: 16px; align-items:center;">
        <a class="exploreBtn" href="index.php#products">Explore</a>
        <span class="cardBtn">
            <i class='bx bx-shopping-bag'></i>
            <span class="cardBtnCounter">
                <?= $cartCount; ?>
            </span>
            <div class="cardModal">
                <div class="cardModal-body">
                    <div class="cardModal-top">
                        <?php $get->getCartProducts(); ?>
                    </div>
                    <div class="cardModal-bottom">
                        <span>Total: <?php echo $get->getPrice(); ?>$</span>
                        <button>Payment</button>
                    </div>
                </div>
            </div>
        </span>
    </div>
</header>

<script>
$(document).ready(function() {
    $('.cardBtn').on('click', function(e) {
        var modal = $(this).find('.cardModal');
        modal.addClass('open');
        $(this).css('background-color', 'white'); 
        $(this).css('color', 'black'); 
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.cardBtn, .cardModal').length) {
            $('.cardModal').removeClass('open');
            $('.cardBtn').css('background-color', '');
            $('.cardBtn').css('color', '');
        }
    });

    $(document).on('click', '.deleteProduct', function() {
        var cartId = $(this).data('cart-id');
        
        $.ajax({
            url: 'classes/delete_from_cart.php',
            type: 'POST',
            data: { cart_id: cartId },
            success: function(response) {
                location.reload(); 
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
        
    });
});

</script>