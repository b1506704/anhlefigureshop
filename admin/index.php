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
    if (isset($_POST['logout'])) {
        unset($_SESSION['mskh']);
        header("location: index.php"); 
    }
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
                    <meta http-equiv="Cache-control" content="no-cache">
                    <title>$title</title>
                    <link href="style.css" rel="stylesheet" type="text/css">
                    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
                </head>
                <body>
                    <header>
                        <div class="content-wrapper">
                            <h1>Admin Panel</h1>
                            <nav>
                                <a href="index.php">Home</a>
                                <a href="index.php?page=bill">Bills</a>
                                $mskh
                                $login_status
                            </nav>
                            
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
                            <p>&copy; $year, Anh Lê Figure Shop Admin Panel. Developed by Le Bao Anh - B1506704 from CTU</p>
                        </div>
                    </footer>
                </body>
            </html>
            EOT;
}
// Page is set to home (home.php) by default, so when the visitor visits that will be the page they see.
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'dashboard';
// Include and show the requested page
include $page . '.php';
?>