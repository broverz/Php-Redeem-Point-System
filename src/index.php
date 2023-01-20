<?php
$http = $_SERVER['SERVER_NAME'];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

<?php

ob_start();
session_start();

error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 1);
// ini_set('error_log', './Logs/Errors.log');
date_default_timezone_set("Asia/Bangkok");

require_once('./Services/Functions/all_func.php');
require_once('./Services/Sql/connect.sql.security.php');

$copyright = "2022" . " - " . date("Y"); /* © */

if (isset($_SESSION['adminlogin']) || isset($_SESSION['userlogin'])) {
    $user_id = $_SESSION['adminlogin'] . $_SESSION['userlogin'];
    $stmt = db_q("SELECT * FROM users WHERE uid = ? LIMIT 1", [$user_id]);
    $plr = $stmt->fetch(PDO::FETCH_ASSOC);
}

$closesite = true; /* false = [This site is a scam] */
if ($closesite) {
    $getPage = $_GET['page'];
    if ($getPage) {
        $page = "Pages/" . $getPage . ".php";
        if (file_exists($page)) {
            include_once($page);
        } elseif ($getPage == 'logout') {
            if (isset($_SESSION['userlogin']) || isset($_SESSION['adminlogin'])) {
                alertmsg('sww', 'ออกจากระบบเรียบร้อย!!', '');
            };
            unset($_SESSION['adminlogin']);
            unset($_SESSION['userlogin']);
            header('location: /?page=login');
        } elseif ($getPage == 'test') {
            alertmsg('err', 'test');
            header('location: /');
        } else {
            header('location: /?page=home');
        }
    } else {
        require_once('./Pages/home.php');
    }
} else {
    // require_once('');
    echo 'This site is a scam';
}
?>