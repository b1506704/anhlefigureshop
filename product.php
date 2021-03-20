<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['MSHH'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM hanghoa WHERE MSHH = ?');
    $stmt->execute([$_GET['MSHH']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>
<?=template_header('Chi tiết sản phẩm')?>

<div class="product content-wrapper">
    <img src="./assets/imgs/<?=$product['QuyCach']?>" width="500" height="500" alt="<?=$product['TenHH']?>">
    <div>
        <h1 class="name"><?=$product['TenHH']?></h1>
        <span class="price">
            &dollar;<?=$product['Gia']?>
            <?php if ($product['Gia'] > 0): ?>
            <span class="rrp">&dollar;<?=$product['Gia']?></span>
            <?php endif; ?>
        </span>
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['SoLuongHang']?>" placeholder="Số lượng" required>
            <input type="hidden" name="product_id" value="<?=$product['MSHH']?>">
            <input type="submit" value="Thêm vào giỏ">
        </form>
        <div class="description">
            <?=$product['GhiChu']?>
        </div>
    </div>
</div>

<?=template_footer()?>