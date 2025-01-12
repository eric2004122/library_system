<?php
require_once('../config.php');
header('Content-Type: application/json');

$sql = "SELECT b.id, b.title, b.author, b.publish_date, b.stock, bs.status AS borrow_status FROM books b LEFT JOIN borrow_status bs ON b.id = bs.book_id";
$result = $conn->query($sql);
$books = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

echo json_encode($books);
?>