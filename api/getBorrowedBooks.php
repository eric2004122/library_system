<?php
require_once('../config.php');
require_once('../auth.php');
header('Content-Type: application/json');

if (isLoggedIn()) {
     $userId = $_SESSION['user_id'];
     $sql = "SELECT b.id, b.title, b.author, bor.id AS borrow_id, bor.borrow_date, bor.return_date, bor.due_date FROM borrowings bor JOIN books b ON bor.book_id = b.id WHERE bor.user_id = $userId";

    $result = $conn->query($sql);
    $books = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
              $row['overdue_days'] = 0;
            if($row['return_date'] == null) {
               $today = new DateTime();
               $dueDate = new DateTime($row['due_date']);
               if($today > $dueDate) {
                   $interval = $today->diff($dueDate);
                   $row['overdue_days'] = $interval->days;
              }
             }
             $books[] = $row;
        }
    }
    echo json_encode($books);

} else {
     http_response_code(401);
    echo json_encode(array('message' => '未授權'));
}

?>