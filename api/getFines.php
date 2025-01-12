<?php
require_once('../config.php');
require_once('../auth.php');
header('Content-Type: application/json');

if (isAdmin()) {
  $sql = "SELECT id, user_id, amount, paid FROM fines WHERE paid = 0";
    $result = $conn->query($sql);
    $fines = [];
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fines[] = $row;
        }
    }
    echo json_encode($fines);
} else {
   http_response_code(401);
    echo json_encode(array('message' => '未授權'));
}
?>