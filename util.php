<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'quanlydathang';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    exit('Lỗi kết nối CSDL!');
}
function template_header($title) {
    // sự kiện đăng xuất
    if (isset($_POST['logout'])) {
        unset($_SESSION['mskh']);
        header("location: admin.php"); 
    }
    
    // hiển thị nút thông tin đăng nhập
    $login_id = isset($_SESSION['mskh_admin']) ? $_SESSION['mskh_admin'] : '';
    $mskh = isset($_SESSION['mskh_admin']) ? "<a>$login_id</a>" : null;
    $login_status = isset($_SESSION['mskh_admin']) ? 
    '<form method="post">
        <input class="logout" type="submit" name="logout" value="LOGOUT">
    </form>' : '<a href="index.php?page=login">LOGIN</a>';

    echo <<<EOT
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="Cache-control" content="no-cache">
                    <title>$title</title>
                    <link href="./assets/css/admin_style.css" rel="stylesheet" type="text/css">
                </head>
                <body>
                    <header>
                        <div class="content-wrapper">
                            <h1>Admin Panel</h1>
                            <nav>
                                <a href="admin.php">Home</a>
                                <a href="bill.php">Bills</a>
                                $mskh
                                $login_status
                            </nav>
                            
                        </div>
                    </header>
                    <main>
            EOT;
}
function template_footer() {
    $year = date('Y');
    echo <<<EOT
                    </main>
                    <footer>
                        <div class="content-wrapper">
                            <p>&copy; $year, Anh Lê Figure Shop Admin Panel. Developed by Le Bao Anh - B1506704 from CTU</p>
                        </div>
                    </footer>
                </body>
            </html>
            EOT;
}
?>