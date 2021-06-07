<?php
$log = '';
if (isset($_POST['mskh']) && isset($_POST['login'])) {
    $stmt = $pdo->prepare('SELECT mskh, matkhau FROM khachhang WHERE mskh = ?');

    if($stmt->execute([trim($_POST['mskh'])])){
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()){
                $mskh = $row['mskh'];
                $mat_khau = $row['matkhau'];
                if($_POST['matkhau'] == $mat_khau){
                    // tài khoản admin có mskh là 181097
                    // nếu là admin thì điều hướng vào trang quản lý
                    // nếu là khách hàng thì điều hướng vào trang mua hàng
                    if ($mskh == 181097) {
                        $_SESSION['mskh_admin'] = $mskh;
                        header("location: admin.php");    
                    } else {
                        $_SESSION['mskh'] = $mskh;
                        header("location: index.php");
                    }                            
                    $log = 'Đăng nhập thành công';
                } else {
                    $log = 'Sai mật khẩu/tài khoản';
                }
            } else {
                $log = 'Lỗi kết nối';
            }
        } else {
            $log = 'Không tồn tại tài khoản';
        }
    }
}
?>
<?=template_header('Đăng nhập')?>

<div class="login content-wrapper">
    <h2>Đăng nhập</h2>
    <div><?=$log?>
    <form method="post">
        <div class="container">
            <label for="mskh"><b>Mã Khách Hàng</b></label>
            <input type="text" placeholder="Nhập mã khách hàng" name="mskh" required>

            <label for="matkhau"><b>Mật Khẩu</b></label>
            <input type="password" placeholder="Nhập mật khẩu" name="matkhau" required>
            <button type="submit" name="login">Đăng nhập</button>
        </div>
        <div class="container" style="background-color:#f1f1f1">
            <button type="button" class="cancelbtn">Trở Về</button>
        </div>
    </form>
</div>

<?=template_footer()?>