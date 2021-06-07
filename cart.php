<?php
// sự kiện thêm hàng vào vỏ hàng
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    $query = $pdo->prepare('SELECT * FROM hanghoa WHERE MSHH = ?');
    $query->execute([$_POST['product_id']]);
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if ($product && $quantity > 0) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    header('location: index.php?page=cart');
    exit;
}
// sự kiện xóa hàng khỏi vỏ hàng
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
// sự kiện cập nhật vỏ hàng
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    header('location: index.php?page=cart');
    exit;
}
// lưu vỏ hàng vào session
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// lấy thông tin hàng hóa từ csdl dựa trên vỏ hàng
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $query = $pdo->prepare('SELECT * FROM hanghoa WHERE MSHH IN (' . $array_to_question_marks . ')');
    $query->execute(array_keys($products_in_cart));
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        $subtotal += (float)$product['Gia'] * (int)$products_in_cart[$product['MSHH']];
    }
}
// điều hướng về trang login nếu chưa đăng nhập
if (!isset($_SESSION['mskh'])) {
    header('location: index.php?page=login');
    exit;
}

$bills = array();
$khach_hang = array();
$dia_chi = array();
// sự kiện đặt hàng
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $query_dat_hang = $pdo->prepare('INSERT INTO dathang VALUES (?, ?, ?, ?, ?, ?)');
    $query_ct_dat_hang = $pdo->prepare('INSERT INTO chitietdathang VALUES (?, ?, ?, ?, ?)');
    $query_tru_so_luong = $pdo->prepare('UPDATE hanghoa SET soluonghang = ? WHERE mshh = ?');

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date("Y-m-d H:i:s");
    // thêm vào bảng dathang và chitietdathang
    // cập nhật số lượng hàng
    foreach ($products as $to_insert_product) {
        $so_don_dh = rand(1,10000);
        $mshh = $to_insert_product['MSHH'];
        $so_luong_trong_kho = $to_insert_product['SoLuongHang'];
        $so_luong = $products_in_cart[$to_insert_product['MSHH']];
        $gia = (float)$to_insert_product['Gia'] * (int)$products_in_cart[$to_insert_product['MSHH']];
        $giam_gia = $gia * rand(5,100) / 100;
        $query_dat_hang->execute([$so_don_dh, $_SESSION['mskh'], 1, $date, NULL, 0]);
        $query_ct_dat_hang->execute([$so_don_dh, $mshh, $so_luong, $gia, $giam_gia]);
        $query_tru_so_luong->execute([$so_luong_trong_kho - $so_luong, $mshh]);
    }

    $query_refresh = $pdo->prepare('SELECT * FROM dathang WHERE mskh = ? ORDER BY NgayDH ASC');
    $query_refresh->execute([$_SESSION['mskh']]);

    $bills = $query_refresh->fetchAll(PDO::FETCH_ASSOC);

    unset($_SESSION['cart']);

    header('location: index.php?page=cart');
}
// lấy thông tin về khách hàng, đơn đặt hàng từ csdl
if (isset($_SESSION['mskh'])) {
    $query_kh = $pdo->prepare('SELECT * FROM khachhang WHERE mskh = ?');
    $query_kh->execute([$_SESSION['mskh']]);
    $khach_hang = $query_kh->fetch(PDO::FETCH_ASSOC);
    $ma_dc = $khach_hang['MaDC'];
    $query_dc = $pdo->prepare('SELECT * FROM diachikh WHERE madc = ?');
    $query_dc->execute([$ma_dc]);
    $dia_chi = $query_dc->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM dathang WHERE mskh = ? ORDER BY NgayDH ASC');
    $stmt->execute([$_SESSION['mskh']]);
    $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<?=template_header('Giỏ hàng')?>
<!-- Hiển thị giỏ hàng -->
<div class="cart content-wrapper">
    <h1 >Giỏ Hàng</h1>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Sản phẩm</td>
                    <td>Giá</td>
                    <td>Số lượng</td>
                    <td>Thành tiền</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center; font-family:monospace">Giỏ hàng trống</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&MSHH=<?=$product['MSHH']?>">
                            <img src="./assets/imgs/<?=$product['HinhAnh']?>" width="50" height="50" alt="<?=$product['TenHH']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&MSHH=<?=$product['MSHH']?>"><?=$product['TenHH']?></a>
                        <br>
                        <a href="index.php?page=cart&remove=<?=$product['MSHH']?>" class="remove">Xóa</a>
                    </td>
                    <td class="price">&dollar;<?=$product['Gia']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['MSHH']?>" value="<?=$products_in_cart[$product['MSHH']]?>" min="1" max="<?=$product['SoLuongHang']?>" placeholder="0" required>
                    </td>
                    <td class="price">&dollar;<?=$product['Gia'] * $products_in_cart[$product['MSHH']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <div>
                <span class="text">Tổng số tiền:</span>
                <span class="price">&dollar;<?=$subtotal?></span>
            </div>
        </div>
        <div class="buttons">
            <input type="submit" value="Cập Nhật" name="update">
            <input type="submit" value="Đặt hàng" name="placeorder">
    
        </div>
    </form>
</div>
<!-- Hiển thị thông tin khách hàng -->
<div class='cart content-wrapper'>
    <h1>Thông Tin Khách Hàng</h1>
    <table>
        <thead>
            <tr>
                <td>Má Số Khách Hàng</td>
                <td>Tên Khách Hàng</td>
                <td>Tên Công Ty</td>
                <td>Địa Chỉ</td>
                <td>Số Điện Thoại</td>
                <td>Email</td>
            </tr>
        </thead>
        <tbody >
            <tr>
                <td>
                    <a><?=$khach_hang['MSKH']?></a>
                </td>
                <td>
                    <a><?=$khach_hang['HoTenKH']?></a>
                </td>
                <td>
                    <a><?=$khach_hang['TenCongTy']?></a>
                </td>
                <td>
                    <a><?=$dia_chi['DiaChi']?></a>
                </td>
                <td>
                    <a><?=$khach_hang['SoDienThoai']?></a>
                </td>
                <td>
                    <a><?=$khach_hang['Email']?></a>
                </td>
               
            </tr>
        </tbody>
    </table>
</div>
<!-- Hiển thị đơn đặt hàng -->
<div class='cart content-wrapper'>
    <h1 style="position: sticky; top: 50px; width: 100%; background-color: white;">Đơn Đặt Hàng</h1>
    <table>
        <thead>
            <tr>
                <td>Số Đơn Đặt Hàng</td>
                <td>Mã Số Khách Hàng</td>
                <td>Ngày Đặt Hàng</td>
                <td>Ngày Giao Hàng</td>
                <td>Tình Trạng</td>
            </tr>
        </thead>
        <tbody >
            <?php if ($bills === null) : ?>
            <tr>
                <td colspan='5' style='text-align:center; font-family:monospace'>Đơn Đặt Hàng Trống</td>
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
                    <a><?=$bill['NgayDH']?></a>
                </td>
                <td>
                    <a><?=$bill['NgayGH']?></a>
                </td>
                <td>
                <a><?=$bill['Duyet'] == 0 ? 'Chưa Duyệt' : 'Đã Duyệt' ?></a>
                </td>
                
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?=template_footer()?>