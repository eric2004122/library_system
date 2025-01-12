<?php
require_once('../config.php');
require_once('../auth.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $data = json_decode(file_get_contents("php://input"), true);
    $borrowId = $conn->real_escape_string($data['borrow_id']);
    $bookId = $conn->real_escape_string($data['book_id']);

     $returnDate = date("Y-m-d");
     $sql = "UPDATE borrowings SET return_date = '$returnDate' WHERE id = '$borrowId'";
       if ($conn->query($sql) !== TRUE) {
          http_response_code(500);
           echo json_encode(array('message' => '歸還失敗'));
           exit;
     }
     //增加庫存
    $sql = "UPDATE books SET stock = stock + 1 WHERE id = '$bookId'";
    if ($conn->query($sql) !== TRUE) {
          http_response_code(500);
           echo json_encode(array('message' => '歸還失敗'));
           exit;
    }

      //更新書籍狀態
       $sql = "INSERT INTO borrow_status(book_id, status) VALUES ($bookId, 'available') ON DUPLICATE KEY UPDATE status = 'available'";
       if ($conn->query($sql) !== TRUE) {
                http_response_code(500);
                 echo json_encode(array('message' => '借閱失敗'));
                 exit;
            }
      http_response_code(200);
      echo json_encode(array('message' => '歸還成功'));

} else {
    http_response_code(401);
    echo json_encode(array('message' => '未授權'));
}
?>