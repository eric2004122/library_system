<?php
require_once('auth.php');
require_once('config.php');

if (!isAdmin()) {
    header('Location: index.php');
    exit();
}
$userId = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);
        if ($result->num_rows != 1) {
              header('Location: admin_dashboard.php');
               exit();
          }
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>編輯使用者借閱設定</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>編輯使用者借閱設定</h1>
        <form action="admin_actions.php" method="post">
         <input type="hidden" name="action" value="edit_user_borrow">
          <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
           <input type="number" name="borrow_limit" placeholder="借閱上限" value="<?php echo $user['borrow_limit'] ?>" required> <br>
            <input type="number" name="borrow_period" placeholder="借閱期限" value="<?php echo $user['borrow_period'] ?>" required> <br>
            <button type="submit">更新</button>
             <button onclick="location.href='admin_dashboard.php'">返回</button>
        </form>
    </div>
</body>
</html>