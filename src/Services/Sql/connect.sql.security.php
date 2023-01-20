<?php
    $time = time();
    $time_check = $time - 1800;

    $sitekeygg = '6Lccbg4kAAAAABhS70V3ObOsAKpz68u816H6zye4';
    $secretkeygg = '6Lccbg4kAAAAAMIPIN_lLrOwH5oFmQlRQjP4m9Od';

    define("N", "root");
    define("H", "127.0.0.1");
    define("PW", "yosiket14789");
    define("DB", "redeem_system");

    try {
        $conn = new PDO("mysql:host=".H.";dbname=".DB, N, PW);
        $conn->exec("set names utf8mb4");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connectwarning = "Connection " . DB . " Successfully!!!";
        // echo('<p align="center">' . $connectwarning . '</p>');
    } catch(PDOException $e) {
        $connectwarning = "Connection " . DB . " Fail: " . $e->getMessage() . "\n";
        echo('<p align="center">' . $connectwarning . '</p>');
    }

    function db_q($str, $arr = [])
    {
        global $conn;
        try {
            http_response_code(202);
            $exec = $conn->prepare($str);
            $exec->execute($arr);
        } catch(PDOException $e) {
            http_response_code(204);
            return false;
        }
        return $exec;
    }

    function db_return($status, $msg)
    {
        $json = ['status' => $status, 'message' => $msg];
        if ($status == true) {
            http_response_code(202);
            echo(json_encode($json));
        } else {
            http_response_code(400);
            echo(json_encode($json));
        }
    }
