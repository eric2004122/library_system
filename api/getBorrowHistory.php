<?php
require_once('../config.php');
require_once('../auth.php');
header('Content-Type: application/json');

if (isLoggedIn()) {
     $userId = $_SESSION['user_id'];
     $sql = "SELECT b.title, b.author, bor.borrow_date, bor.return_date  FROM borrowings bor JOIN books b ON bor.book_id = b.id WHERE bor.user_id = $userId ORDER BY bor.borrow_date DESC";

    $result = $conn->query($sql);
    $books = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }
    echo json_encode($books);

} else {
     http_response_code(401);
    echo json_encode(array('message' => '未授權'));
}

?>