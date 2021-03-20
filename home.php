<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM hanghoa ORDER BY MSHH DESC LIMIT 3');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_header('Trang chủ')?>

<div class="featured">
    <h2>Anh Lê's Shop Figure</h2>
    <p>Nơi phân phối figure chất lượng, nhập khẩu 100% từ Nhật Bản </p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Sản phẩm mới nhập kho</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
        <a href="index.php?page=product&MSHH=<?=$product['MSHH']?>" class="product">
            <img src="./assets/imgs/<?=$product['QuyCach']?>" width="200" height="200" alt="<?=$product['TenHH']?>">
            <span class="name"><?=$product['TenHH']?></span>
            <span class="price">
                &dollar;<?=$product['Gia']?>
                <?php if ($product['Gia'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['Gia']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>