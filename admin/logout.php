<?php
    ob_start();
	session_start();
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie("name", "", time() - 3600, "/");
            setcookie("pass", "", time() - 3600, "/");
            setcookie("code", "", time() - 3600, "/");
        }
    }
    $_COOKIE = array();
    $_SESSION = array();
	session_destroy();
    session_unset();
	header("location:http://localhost/www/TDUONG/admin/trang-chu/");
	exit();
    ob_end_flush();
?>