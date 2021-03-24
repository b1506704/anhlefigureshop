<?php
// The amounts of products to show on each page
$num_products_on_each_page = 4;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM hanghoa ORDER BY MSHH DESC LIMIT ?,?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
$total_products = $pdo->query('SELECT * FROM hanghoa')->rowCount();
?>
<?=template_header('Figures')?>

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