<!-- create, delete, update product -->
<!-- create -->
<?php
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    // $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $tenhh = isset($_POST['tenhh']) ? $_POST['tenhh'] : '';
    $hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : '';
    $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
    $soluong = isset($_POST['soluong']) ? $_POST['soluong'] : '';
    $maloai = isset($_POST['maloai']) ? $_POST['maloai'] : '';
    $mota = isset($_POST['mota']) ? $_POST['mota'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO hanghoa (TenHH, HinhAnh, Gia, SoLuongHang, MaLoaiHang, GhiChu) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$tenhh, $hinhanh, $gia, $soluong, $maloai, $mota]);
    // Output message
    $msg = 'Created Successfully!';
    header('location: index.php?page=cdu');
    exit;
}
// if (true) {
    $render_create_page = '
    <div class="update content-wrapper">
        <h1>Thêm Hàng Hóa</h1>
        <form method="post">
            <label for="tenhh">Tên Hàng Hóa</label>
            <label for="hinhanh">Hình Ảnh</label>
            <input type="text" name="tenhh" required>
            <input type="file" name="hinhanh" required>
            <label for="gia">Giá</label>
            <label for="soluong">Số Lượng</label>
            <input type="number" name="gia" placeholder="... $" required >
            <input type="number" name="soluong" required>
            <label for="maloai">Mã Loại</label>
            <label for="mota">Mô Tả</label>
            <select name="maloai" required>
                <option value="1/12">
                    1/12
                </option>
            </select>
            <!-- <input type="text" name="maloai" placeholder="John Doe" > -->
            <input type="text" name="mota" required>
            <input type="submit" value="Thêm">
        </form>
        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </div>"
    ';
// }
?>
<?=template_header('Create')?>
<?=$render_create_page?>
<?=template_footer()?>

<!-- update -->
