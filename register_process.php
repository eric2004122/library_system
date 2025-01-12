<?php
require_once('auth.php');
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $username = $conn->real_escape_string($_POST['username']);
     $password = $_POST['password'];
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
     $role = "user"; // 設定新使用者預設為 user

        // 檢查使用者名稱是否重複
        $sql_check_user = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql_check_user);

        if ($result->num_rows > 0) {
            session_start();
            $_SESSION['register_error'] = "使用者名稱已存在，請選擇其他名稱。";
            header('Location: register.php');
             exit();
        }

        // 新增使用者到資料庫
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";

        if ($conn->query($sql) === TRUE) {
           session_start();
              $_SESSION['register_success'] = "註冊成功！";
              header('Location: index.php');
              exit();
        } else {
           session_start();
            $_SESSION['register_error'] = "註冊失敗，請稍後再試。";
           header('Location: register.php');
            exit();
        }

 }
?>