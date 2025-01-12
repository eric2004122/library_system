<?php
require_once('../config.php');
require_once('../auth.php');
header('Content-Type: application/json');

if (isAdmin()) {
    $sql = "SELECT id, username, role, borrow_limit, borrow_period FROM users";
     $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    echo json_encode($users);
} else {
      http_response_code(401);
       echo json_encode(array('message' => '未授權'));
}
?>