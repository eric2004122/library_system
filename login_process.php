<?php
require_once('auth.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
        if (isAdmin()) {
            header('Location: admin_dashboard.php');
        } else {
           header('Location: user_dashboard.php');
        }
    } else {
         session_start();
        $_SESSION['login_error'] = "帳號或密碼錯誤，請重新輸入。";
       header('Location: index.php');
       exit();
    }
}
?>