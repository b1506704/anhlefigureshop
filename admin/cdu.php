<!-- create, delete, update product -->
<!-- create -->

<?php
include "util.php";
$render_create_page = '';
$render_update_page = '';
// render update page
if (isset($_GET['u_mshh'])) {
    $stmt = $pdo->prepare('SELECT DISTINCT * FROM hanghoa WHERE mshh = ?');
    $stmt->execute([$_GET['u_mshh']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $ten_hh= $product['TenHH'];
    $hinh_anh= $product['HinhAnh'];
    $gia= $product['Gia'];
    $so_luong= $product['SoLuongHang'];
    $ma_loai= $product['MaLoaiHang'];
    $mo_ta= $product['GhiChu'];
    $render_update_page = "
    <div class='update content-wrapper'>
        <h1>Cập Nhật Hàng Hóa</h1>
        <form method='post'>
            <label for='tenhh'>Tên Hàng Hóa</label>
            <label for='hinhanh'>Hình Ảnh</label>
            <input type='text' name='tenhh' value='$ten_hh' required autofocus>
            <input type='file' name='hinhanh' value='$hinh_anh' required>
            <label for='gia'>Giá</label>
            <label for='soluong'>Số Lượng</label>
            <input type='number' name='gia' value='$gia' required >
            <input type='number' name='soluong' value='$so_luong' required>
            <label for='maloai'>Mã Loại</label>
            <label for='mota'>Mô Tả</label>
            <select name='maloai' value='$ma_loai' required>
                <option value='1/12'>
                    1/12
                </option>
            </select>
            <input type='text' name='mota' value='$mo_ta' required>
            <div>
                <input type='submit' value='Lưu'>
            </div>
        </form>
    </div>
    ";
    if (!empty($_POST)) {
        $tenhh = isset($_POST['tenhh']) ? $_POST['tenhh'] : '';
        $hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : '';
        $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
        $soluong = isset($_POST['soluong']) ? $_POST['soluong'] : '';
        $maloai = isset($_POST['maloai']) ? $_POST['maloai'] : '';
        $mota = isset($_POST['mota']) ? $_POST['mota'] : '';
        $stmt = $pdo->prepare('UPDATE hanghoa SET TenHH = ? , HinhAnh = ?, Gia = ?, SoLuongHang = ?, MaLoaiHang = ?, GhiChu = ? WHERE mshh = ?');
        $stmt->execute([$tenhh, $hinhanh, $gia, $soluong, $maloai, $mota, $_GET['u_mshh']]);
        $_SESSION['msg'] = "Đã cập nhật Figure " . $tenhh;
        unset($_GET['u_mshh']);
        header('location: index.php?&p=' . $_SESSION['current_page']);
        exit;
    }

} else {
    $render_create_page = "
    <div class='update content-wrapper'>
        <h1>Cập Nhật Hàng Hóa</h1>
        <form method='post'>
            <label for='tenhh'>Tên Hàng Hóa</label>
            <label for='hinhanh'>Hình Ảnh</label>
            <input type='text' name='tenhh' required autofocus>
            <input type='file' name='hinhanh' required>
            <label for='gia'>Giá</label>
            <label for='soluong'>Số Lượng</label>
            <input type='number' name='gia' required >
            <input type='number' name='soluong' required>
            <label for='maloai'>Mã Loại</label>
            <label for='mota'>Mô Tả</label>
            <select name='maloai' required>
                <option value='1/12'>
                    1/12
                </option>
            </select>
            <input type='text' name='mota' required>
            <div>
                <input type='submit' value='Thêm'>
            </div>
        </form>
    </div>
    ";
    if (!empty($_POST)) {
        $tenhh = isset($_POST['tenhh']) ? $_POST['tenhh'] : '';
        $hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : '';
        $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
        $soluong = isset($_POST['soluong']) ? $_POST['soluong'] : '';
        $maloai = isset($_POST['maloai']) ? $_POST['maloai'] : '';
        $mota = isset($_POST['mota']) ? $_POST['mota'] : '';
        $stmt = $pdo->prepare('INSERT INTO hanghoa (TenHH, HinhAnh, Gia, SoLuongHang, MaLoaiHang, GhiChu) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$tenhh, $hinhanh, $gia, $soluong, $maloai, $mota]);
        $_SESSION['msg'] = "Đã thêm Figure " . $tenhh;
        unset($_POST);
        header('location: index.php?&p=' . $_SESSION['current_page']);
        exit;
    }
}
?>
<?=template_header("Quản Lý Hàng Hóa")?>
<?=$render_create_page?>
<?=$render_update_page?>
<?=template_footer()?>

