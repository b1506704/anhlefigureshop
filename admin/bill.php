<!-- update bill status -->
<!-- see product list with delete, add, and update function -->
<?php
$num_products_on_each_page = 4;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$query = $pdo->prepare('SELECT * FROM hanghoa ORDER BY MSHH ASC LIMIT ?,?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$query->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$query->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$query->execute();
// Fetch the products from the database and return the result as an Array
$products = $query->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
$total_products = $pdo->query('SELECT * FROM hanghoa')->rowCount();

?>
<?=template_header('Quản Lý Đơn Hàng')?>

<div class="cart content-wrapper">
    <h1>Quản Lý Đơn Hàng</h1>
    <form method="post">
        <div class="buttons">
            <a href="index.php?page=cdu.php" class="add">Thêm</a>
        </div>
        <table>
            <thead>
                <tr class="table_header">
                    <td>MSHH</td>
                    <td>Tên HH</td>
                    <td>Hình Ảnh</td>
                    <td>Giá</td>
                    <td>Số Lượng</td>
                    <td>Mã Loại</td>
                    <td>Mô Tả</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td style="text-align:center; font-family:monospace">Giỏ hàng trống</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?=$product['MSHH']?></td>
                    <td><?=$product['TenHH']?></td>
                    <td class="img">
                        <img src="./assets/imgs/<?=$product['HinhAnh']?>" width="50" height="50" alt="<?=$product['TenHH']?>">
                    </td>
                    <td>&dollar;<?=$product['Gia']?></td>
                    <td><?=$product['SoLuongHang'] ?></td>
                    <td><?=$product['MaLoaiHang'] ?></td>
                    <td ><?=$product['GhiChu'] ?></td>
                    <td class="actions">
                        <a href="index.php?page=cdu.php?id=<?=$product['MSHH']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="index.php?page=cdu.php?id=<?=$product['MSHH']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="buttons">
            <?php if ($current_page > 1): ?>
            <a href="index.php?&p=<?=$current_page-1?>">
            <i class="fas fa-angle-double-left fa-sm"></i>
            </a>
            <?php endif; ?>
            <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
            <a href="index.php?&p=<?=$current_page+1?>">
            <i class="fas fa-angle-double-right fa-sm"></i>
            </a>
        <?php endif; ?>
        </div>
    </form>
</div>

<?=template_footer()?>