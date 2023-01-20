<?php
    require_once('alertmsg.php');
    // require_once('');
    // require_once('');
    // require_once('');

    function sizetext($size, $msg)
    {
        switch ($size) {
            case 'small':
                $exec = strtolower($msg);
                $exec = htmlspecialchars($exec, ENT_QUOTES, 'UTF-8');
                return $exec;
            case 'big':
                $exec = strtoupper($msg);
                $exec = htmlspecialchars($exec, ENT_QUOTES, 'UTF-8');
                return $exec;
            default:
                $exec = ucwords($msg);
                $exec = htmlspecialchars($exec, ENT_QUOTES, 'UTF-8');
                return $exec;
        }
    }
