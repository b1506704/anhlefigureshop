<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_POST['mskh']) && isset($_POST['login'])) {
    $_SESSION['mskh'] = $_POST['mskh'];
    header('location: index.php');
    exit;
}
?>
<?=template_header('Đăng nhập')?>

<div class="login content-wrapper">
    <h2>Đăng nhập</h2>

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