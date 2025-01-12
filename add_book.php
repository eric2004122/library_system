<?php
require_once('auth.php');
require_once('config.php');
if (!isAdmin()) {
    header('Location: index.php');
    exit();
}
 $sql = "SELECT id, name FROM categories";
  $result = $conn->query($sql);
 $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>新增書籍</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>新增書籍</h1>
        <form action="admin_actions.php" method="post">
            <input type="hidden" name="action" value="add_book">
            <input type="text" name="title" placeholder="書名" required><br>
            <input type="text" name="author" placeholder="作者" required><br>
             <input type="date" name="publish_date" placeholder="出版日期" required><br>
             <select name="category" required>
                  <?php
                       foreach ($categories as $category)
                      {
                            echo '<option value="'. $category['id'] .'">' . $category['name'] . '</option>';
                       }
                   ?>
              </select><br>
            <input type="number" name="stock" placeholder="庫存量" required><br>
            <button type="submit">新增</button>
        </form>
    </div>
</body>
</html>