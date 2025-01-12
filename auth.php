<?php
session_start();
require_once('config.php');

function login($username, $password) {
    global $conn;
    $username = $conn->real_escape_string($username);
    //  $password = $conn->real_escape_string($password);

    $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
       if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
             $_SESSION['username'] = $user['username'];
             $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

function logout() {
    session_destroy();
    header('Location: index.php');
}
if (isset($_SESSION['login_error'])) {
        unset($_SESSION['login_error']);
    }

?>