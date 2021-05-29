<?php
// Get the 4 most recently added products
$query = $pdo->prepare('SELECT * FROM hanghoa ORDER BY MSHH DESC LIMIT 4');
$query->execute();
$recently_added_products = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_header('Trang chủ')?>

<div class="featured">
    <h2>Anh Le's Figure Shop</h2>
    <p>Nơi phân phối mô hình 3d chất lượng, nhập khẩu 100% từ Nhật Bản </p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Sản phẩm mới nhập kho</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
        <a href="index.php?page=product&MSHH=<?=$product['MSHH']?>" class="product">
            <img src="./assets/imgs/<?=$product['HinhAnh']?>" width="200" height="200" alt="<?=$product['TenHH']?>">
            <span class="name"><?=$product['TenHH']?></span>
            <span class="price">
                &dollar;<?=$product['Gia']?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>