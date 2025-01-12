<?php
require_once('../config.php');
require_once('../auth.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $data = json_decode(file_get_contents("php://input"), true);
    $bookId = $conn->real_escape_string($data['book_id']);
    $userId = $_SESSION['user_id'];

     //檢查使用者借閱次數
      $sql = "SELECT COUNT(*) as count FROM borrowings WHERE user_id = '$userId' AND return_date IS NULL";
        $result = $conn->query($sql);
         if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
               $borrowCount =  $row['count'];
            // 檢查使用者借閱上限
            $sql = "SELECT borrow_limit FROM users WHERE id = $userId";
             $result = $conn->query($sql);
           if ($result->num_rows > 0) {
                 $row = $result->fetch_assoc();
                  $borrowLimit = $row['borrow_limit'];
                  if ($borrowCount >= $borrowLimit)
                  {
                        http_response_code(400);
                        echo json_encode(array('message' => '您已達到借閱上限。'));
                       exit;
                   }
            }
         }

      //檢查書是否有庫存
      $sql = "SELECT stock FROM books WHERE id = '$bookId'";
      $result = $conn->query($sql);
     if ($result->num_rows > 0) {
         $row = $result->fetch_assoc();
        if($row['stock'] <= 0) {
              http_response_code(400);
              echo json_encode(array('message' => '書本無庫存'));
              exit;
         }

     }

      //減少庫存
    $sql = "UPDATE books SET stock = stock - 1 WHERE id = '$bookId'";
    if ($conn->query($sql) !== TRUE) {
          http_response_code(500);
          echo json_encode(array('message' => '借閱失敗'));
           exit;
    }
  //設定借閱日期
    $borrowDate = date("Y-m-d");
        $sql = "SELECT b.borrow_period as borrow_period, c.borrow_period as category_borrow_period FROM users b JOIN books bo ON b.id = '$userId' JOIN categories c ON bo.category = c.id";
        $result = $conn->query($sql);
         if ($result->num_rows > 0) {
             $row = $result->fetch_assoc();
            $borrowPeriod = $row['category_borrow_period'] == 0 ? $row['borrow_period'] : $row['category_borrow_period'];
            $dueDate = date('Y-m-d', strtotime("+$borrowPeriod days"));
             } else {
               $dueDate = date('Y-m-d', strtotime("+30 days"));
          }

    $sql = "INSERT INTO borrowings (user_id, book_id, borrow_date, due_date) VALUES ($userId, $bookId, '$borrowDate', '$dueDate')";
    if ($conn->query($sql) === TRUE) {
        //更新書籍狀態
       $sql = "INSERT INTO borrow_status(book_id, status) VALUES ($bookId, 'borrowed') ON DUPLICATE KEY UPDATE status = 'borrowed'";
       if ($conn->query($sql) !== TRUE) {
                http_response_code(500);
                 echo json_encode(array('message' => '借閱失敗'));
                 exit;
            }
       http_response_code(200);
      echo json_encode(array('message' => '借閱成功'));
    } else {
       http_response_code(500);
      echo json_encode(array('message' => '借閱失敗'));
    }
} else {
    http_response_code(401);
    echo json_encode(array('message' => '未授權'));
}
?>