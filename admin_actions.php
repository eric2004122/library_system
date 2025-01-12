<?php
require_once('auth.php');
require_once('config.php');

if (!isAdmin()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'add_book') {
        $title = $conn->real_escape_string($_POST['title']);
        $author = $conn->real_escape_string($_POST['author']);
        $publish_date = $conn->real_escape_string($_POST['publish_date']);
        $stock = intval($_POST['stock']);
          $category = intval($_POST['category']);

        $sql = "INSERT INTO books (title, author, publish_date, stock, category) VALUES ('$title', '$author', '$publish_date', $stock, $category)";
        if ($conn->query($sql) === TRUE) {
            header('Location: admin_dashboard.php');
        } else {
            echo "新增書籍失敗: " . $conn->error;
        }
    } else if ($action == 'edit_book') {
        $id = intval($_POST['id']);
          $title = $conn->real_escape_string($_POST['title']);
        $author = $conn->real_escape_string($_POST['author']);
          $publish_date = $conn->real_escape_string($_POST['publish_date']);
        $stock = intval($_POST['stock']);
         $category = intval($_POST['category']);

        $sql = "UPDATE books SET title='$title', author='$author', publish_date='$publish_date', stock=$stock, category = $category WHERE id=$id";
          if ($conn->query($sql) === TRUE) {
              header('Location: admin_dashboard.php');
        } else {
            echo "編輯書籍失敗: " . $conn->error;
        }
    } else if ($action === "edit_user_borrow") {
        $userId = intval($_POST['user_id']);
          $borrowLimit = intval($_POST['borrow_limit']);
           $borrowPeriod = intval($_POST['borrow_period']);
           $sql = "UPDATE users SET borrow_limit = '$borrowLimit', borrow_period='$borrowPeriod' WHERE id = '$userId'";
              if ($conn->query($sql) === TRUE) {
                  header('Location: admin_dashboard.php');
            } else {
                echo "更新使用者借閱設定失敗: " . $conn->error;
            }

    }
}
?>