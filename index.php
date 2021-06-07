<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'quanlydathang';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    exit('Failed to connect to database!');
}
function template_header($title) {
    // Get the amount of items in the shopping cart, this will be displayed in the header.
    if (isset($_POST['logout'])) {
        unset($_SESSION['mskh']);
        unset($_SESSION['cart']);
        header("location: index.php"); 
    }
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    $login_id = isset($_SESSION['mskh']) ? $_SESSION['mskh'] : '';
    $mskh = isset($_SESSION['mskh']) ? "<a>$login_id</a>" : null;
    $login_status = isset($_SESSION['mskh']) ? 
    '<form method="post">
        <input class="logout" type="submit" name="logout" value="LOGOUT">
    </form>' : '<a href="index.php?page=login">LOGIN</a>';

    echo <<<EOT
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>$title</title>
                    <link href="./assets/css/style.css" rel="stylesheet" type="text/css">
                </head>
                <body>
                    <header>
                        <div class="content-wrapper">
                            <h1>Anh Le's Figure Shop</h1>
                            <nav>
                                <a href="index.php">Home</a>
                                <a href="index.php?page=products">Figures</a>
                                $mskh
                                $login_status
                            </nav>
                            <div class="link-icons">
                                <a href="index.php?page=cart">
                                    &#x1F6D2;
                                    <span>$num_items_in_cart</span>
                                </a>
                            </div>
                        </div>
                    </header>
                    <main>
            EOT;
}
// Template footer
function template_footer() {
    $year = date('Y');
    echo <<<EOT
                    </main>
                    <footer>
                        <div class="content-wrapper">
                            <p>&copy; $year, Anh Lê Figure Shop. Developed by Le Bao Anh - B1506704 from CTU</p>
                        </div>
                    </footer>
                </body>
            </html>
            EOT;
}
// Page is set to home (home.php) by default, so when the visitor visits that will be the page they see.
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';
// Include and show the requested page
include $page . '.php';
?>