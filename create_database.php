<?php
require_once('config.php'); // 引用你的資料庫設定檔

// 建立資料庫
$db_name = 'library_db';
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($conn->query($sql_create_db) === TRUE) {
    echo "資料庫 '$db_name' 建立成功<br>";
} else {
    die("建立資料庫失敗: " . $conn->error);
}

// 選取資料庫
$conn->select_db($db_name);

// 建立 users 表格
$sql_create_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL
)";

if ($conn->query($sql_create_users) === TRUE) {
    echo "表格 'users' 建立成功<br>";
} else {
   die("建立表格 'users' 失敗: " . $conn->error);
}

// 建立 books 表格
$sql_create_books = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE NOT NULL,
    stock INT NOT NULL
)";

if ($conn->query($sql_create_books) === TRUE) {
    echo "表格 'books' 建立成功<br>";
} else {
    die("建立表格 'books' 失敗: " . $conn->error);
}

//建立 borrowings 表格
$sql_create_borrowings = "CREATE TABLE IF NOT EXISTS borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATE NOT NULL
)";

if ($conn->query($sql_create_borrowings) === TRUE) {
    echo "表格 'borrowings' 建立成功<br>";
} else {
   die("建立表格 'borrowings' 失敗: " . $conn->error);
}

echo "資料庫和表格建立完成！";

// 關閉連線
$conn->close();
?>