<?php
include "util.php";
// phân trang
$num_bills_on_each_page = 4;
$current_page = isset($_GET['bill_p']) && is_numeric($_GET['bill_p']) ? (int)$_GET['bill_p'] : 1;
$query = $pdo->prepare('SELECT * FROM dathang ORDER BY NgayDH ASC LIMIT ?,?');
$query->bindValue(1, ($current_page - 1) * $num_bills_on_each_page, PDO::PARAM_INT);
$query->bindValue(2, $num_bills_on_each_page, PDO::PARAM_INT);
$query->execute();
$bills = $query->fetchAll(PDO::FETCH_ASSOC);
$total_bills = $pdo->query('SELECT * FROM dathang')->rowCount();
// sự kiện xóa đơn đặt hàng
if (isset($_GET['d_bill'])) {
    $chi_tiet_dh_query = $pdo->prepare('DELETE FROM chitietdathang WHERE SoDonDH = ?');
    $chi_tiet_dh_query->execute([$_GET['d_bill']]);

    $stmt = $pdo->prepare('DELETE FROM dathang WHERE SoDonDH = ?');
    $stmt->execute([$_GET['d_bill']]);

    $_SESSION['msg'] = "Đã xóa đơn đặt hàng " . $_GET['d_bill'];

    header('location: bill.php?&bill_p=' . $_SESSION['current_bill_page']);
}
// sự kiện duyệt/ bỏ duyệt đơn đặt hàng
if (isset($_GET['c_bill'])) {
    $duyet_query = $pdo->prepare('SELECT * FROM dathang WHERE SoDonDH = ?');
    $duyet_query->execute([$_GET['c_bill']]);
    $bill = $duyet_query->fetch(PDO::FETCH_ASSOC);

    $status = $bill['Duyet'];
    
    $stmt = $pdo->prepare('UPDATE dathang SET Duyet = ? WHERE SoDonDH = ?');
    $date_query = $pdo->prepare('UPDATE dathang SET NgayGH = ? WHERE SoDonDH = ?');

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date("Y-m-d H:i:s");

    if ($status == 0) {
        $stmt->execute([1, $_GET['c_bill']]);
        $date_query->execute([$date, $_GET['c_bill']]);
        $_SESSION['msg'] = "Đã duyệt đơn hàng " . $_GET['c_bill'];
    } elseif ($status == 1) {
        $stmt->execute([0, $_GET['c_bill']]);
        $date_query->execute([null, $_GET['c_bill']]);
        $_SESSION['msg'] = "Đã bỏ duyệt đơn hàng " . $_GET['c_bill'];
    }

    header('location: bill.php?&bill_p=' . $_SESSION['current_bill_page']);
} 

?>
<?=template_header('Quản Lý Đặt Hàng')?>

<div class="cart content-wrapper">
    <h1>Quản Lý Đặt Hàng</h1>
    <form method="post">
        <div class="buttons">
            <p style="font-family: monospace;">Hoạt động gần nhất: <?=isset($_SESSION['msg']) ? $_SESSION['msg'] : '' ?></p>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Số Đơn Đặt Hàng</td>
                    <td>Mã Số Khách Hàng</td>
                    <td>Mã Nhân Viên Duyệt Đơn</td>
                    <td>Ngày Đặt Hàng</td>
                    <td>Ngày Giao Hàng</td>
                    <td>Tình Trạng</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bills)): ?>
                <tr>
                    <td style="text-align:center; font-family:monospace">Đơn Đặt Hàng Trống</td>
                </tr>
                <?php else: ?>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                    <td>
                        <a><?=$bill['SoDonDH']?></a>
                    </td>
                    <td>
                        <a><?=$bill['MSKH']?></a>
                    </td>
                    <td>
                        <a><?=$bill['MSNV']?></a>
                    </td>
                    <td>
                        <a><?=$bill['NgayDH']?></a>
                    </td>
                    <td>
                        <a><?=$bill['NgayGH']?></a>
                    </td>
                    <td>
                    <a><?=$bill['Duyet'] == 0 ? 'Chưa Duyệt' : 'Đã Duyệt' ?></a>
                    <td class="actions">
                        <a href="bill.php?c_bill=<?=$bill['SoDonDH']?>" class="edit">
                            <?=$bill['Duyet'] == 0 ? 'Duyệt' : 'Bỏ Duyệt' ?>
                        </a>
                        <a href="bill.php?d_bill=<?=$bill['SoDonDH']?>" class="trash">
                            Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="buttons">
            <?php if ($current_page > 1): ?>
            <a href="bill.php?&bill_p=<?=$current_page-1?>">
            <
            </a>
            <?php endif; ?>
            <?php if ($total_bills > ($current_page * $num_bills_on_each_page) - $num_bills_on_each_page + count($bills)): ?>
            <a href="bill.php?&bill_p=<?=$current_page+1?>">
            >
            </a>
        <?php endif; ?>
        </div>
    </form>
</div>
<?php $_SESSION['current_bill_page']=isset($_GET['bill_p']) ? (int)$_GET['bill_p'] : 1;?>
<?=template_footer()?>