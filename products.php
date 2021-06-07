<?php
// phân trang
$num_products_on_each_page = 5;
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$query = $pdo->prepare('SELECT * FROM hanghoa ORDER BY MSHH DESC LIMIT ?,?');
$query->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$query->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
$total_products = $pdo->query('SELECT * FROM hanghoa')->rowCount();
?>
<?=template_header('Kho Hàng')?>

<div class="products content-wrapper">
    <h1>Kho hàng</h1>
    <p style="font-family:monospace; font-size:14px">Hiện tại có <?=$total_products?> sản phẩm</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="index.php?page=product&MSHH=<?=$product['MSHH']?>" class="product">
            <img src="./assets/imgs/<?=$product['HinhAnh']?>" width="200" height="200" alt="<?=$product['TenHH']?>">
            <span class="name"><?=$product['TenHH']?></span>
            <span class="price">
                &dollar;<?=$product['Gia']?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="index.php?page=products&p=<?=$current_page-1?>">&#8619;</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
        <a href="index.php?page=products&p=<?=$current_page+1?>">&#8620;</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>