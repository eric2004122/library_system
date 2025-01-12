<?php
require_once('config.php'); // 引用你的資料庫設定檔

// 建立 categories 表格
$sql_create_categories = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    borrow_period INT NOT NULL
)";

if ($conn->query($sql_create_categories) === TRUE) {
    echo "表格 'categories' 建立成功<br>";
} else {
    die("建立表格 'categories' 失敗: " . $conn->error);
}

// 建立 fines 表格
$sql_create_fines = "CREATE TABLE IF NOT EXISTS fines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount INT NOT NULL,
    paid BOOLEAN DEFAULT 0
)";

if ($conn->query($sql_create_fines) === TRUE) {
    echo "表格 'fines' 建立成功<br>";
} else {
    die("建立表格 'fines' 失敗: " . $conn->error);
}

// 建立 borrow_status 表格
$sql_create_borrow_status = "CREATE TABLE IF NOT EXISTS borrow_status (
    book_id INT PRIMARY KEY,
    status ENUM('available', 'borrowed', 'reserved') DEFAULT 'available'
)";

if ($conn->query($sql_create_borrow_status) === TRUE) {
    echo "表格 'borrow_status' 建立成功<br>";
} else {
    die("建立表格 'borrow_status' 失敗: " . $conn->error);
}
// 修改 users 表格，新增 borrow_limit 欄位
$sql_add_borrow_limit = "ALTER TABLE users ADD COLUMN borrow_limit INT DEFAULT 3";
if ($conn->query($sql_add_borrow_limit) === TRUE) {
    echo "表格 'users' 新增 'borrow_limit' 欄位成功<br>";
} else {
    die("修改表格 'users' 失敗: " . $conn->error);
}
// 修改 users 表格，新增 borrow_period 欄位
$sql_add_borrow_period = "ALTER TABLE users ADD COLUMN borrow_period INT DEFAULT 30";
if ($conn->query($sql_add_borrow_period) === TRUE) {
    echo "表格 'users' 新增 'borrow_period' 欄位成功<br>";
} else {
    die("修改表格 'users' 失敗: " . $conn->error);
}
// 修改 books 表格，新增 category 欄位
$sql_add_category = "ALTER TABLE books ADD COLUMN category INT NOT NULL";
if ($conn->query($sql_add_category) === TRUE) {
    echo "表格 'books' 新增 'category' 欄位成功<br>";
} else {
    die("修改表格 'books' 失敗: " . $conn->error);
}
// 修改 borrowings 表格，新增 due_date 欄位
$sql_add_due_date = "ALTER TABLE borrowings ADD COLUMN due_date DATE";
if ($conn->query($sql_add_due_date) === TRUE) {
    echo "表格 'borrowings' 新增 'due_date' 欄位成功<br>";
} else {
    die("修改表格 'borrowings' 失敗: " . $conn->error);
}
// 修改 borrowings 表格，新增 overdue_days 欄位
$sql_add_overdue_days = "ALTER TABLE borrowings ADD COLUMN overdue_days INT DEFAULT 0";
if ($conn->query($sql_add_overdue_days) === TRUE) {
    echo "表格 'borrowings' 新增 'overdue_days' 欄位成功<br>";
} else {
    die("修改表格 'borrowings' 失敗: " . $conn->error);
}
// 修改 borrowings 表格，新增 fine 欄位
$sql_add_fine = "ALTER TABLE borrowings ADD COLUMN fine INT DEFAULT 0";
if ($conn->query($sql_add_fine) === TRUE) {
    echo "表格 'borrowings' 新增 'fine' 欄位成功<br>";
} else {
    die("修改表格 'borrowings' 失敗: " . $conn->error);
}

echo "資料庫和表格修改完成！";

// 關閉連線
$conn->close();
?>