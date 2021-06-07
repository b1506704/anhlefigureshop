<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $query = $pdo->prepare('SELECT * FROM hanghoa WHERE MSHH = ?');
    $query->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $query->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}
// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    
    $query = $pdo->prepare('SELECT * FROM hanghoa WHERE MSHH IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $query->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['Gia'] * (int)$products_in_cart[$product['MSHH']];
    }
}

if (!isset($_SESSION['mskh'])) {
    header('location: index.php?page=login');
    exit;
}

$bills = array();


if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $query_dat_hang = $pdo->prepare('INSERT INTO dathang VALUES (?, ?, ?, ?, ?, ?)');
    $query_ct_dat_hang = $pdo->prepare('INSERT INTO chitietdathang VALUES (?, ?, ?, ?, ?)');

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date("Y-m-d H:i:s");

    foreach ($products as $to_insert_product) {
        $so_don_dh = rand(1,10000);
        $mshh = $to_insert_product['MSHH'];
        $so_luong = $products_in_cart[$to_insert_product['MSHH']];
        $gia = (float)$to_insert_product['Gia'] * (int)$products_in_cart[$to_insert_product['MSHH']];
        $giam_gia = $gia * rand(5,100) / 100;
        $query_dat_hang->execute([$so_don_dh, $_SESSION['mskh'], 1, $date, NULL, 0]);
        $query_ct_dat_hang->execute([$so_don_dh, $mshh, $so_luong, $gia, $giam_gia]);
        
    }

    $query_refresh = $pdo->prepare('SELECT * FROM dathang WHERE mskh = ? ORDER BY NgayDH ASC');
    $query_refresh->execute([$_SESSION['mskh']]);

    $bills = $query_refresh->fetchAll(PDO::FETCH_ASSOC);

    unset($_SESSION['cart']);

    header('location: index.php?page=cart');
}

if (isset($_SESSION['mskh'])) {
    $stmt = $pdo->prepare('SELECT * FROM dathang WHERE mskh = ? ORDER BY NgayDH ASC');
    $stmt->execute([$_SESSION['mskh']]);
    $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<?=template_header('Giỏ hàng')?>

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