<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'library_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}
?>