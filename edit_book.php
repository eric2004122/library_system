<?php
require_once('auth.php');
require_once('config.php');

if (!isAdmin()) {
    header('Location: index.php');
    exit();
}
$bookId = $_GET['id'];
$sql = "SELECT id, title, author, publish_date, stock, category FROM books WHERE id = $bookId";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    header('Location: admin_dashboard.php');
    exit();
}
$book = $result->fetch_assoc();

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
    <title>編輯書籍</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>編輯書籍</h1>
        <form action="admin_actions.php" method="post">
        <input type="hidden" name="action" value="edit_book">
         <input type="hidden" name="id" value="<?php echo $book['id'];?>">
            <input type="text" name="title" placeholder="書名" value="<?php echo $book['title']; ?>"  required><br>
            <input type="text" name="author" placeholder="作者" value="<?php echo $book['author']; ?>" required><br>
             <input type="date" name="publish_date" placeholder="出版日期" value="<?php echo $book['publish_date']; ?>" required><br>
               <select name="category" required>
                  <?php
                       foreach ($categories as $category)
                      {
                          $selected = $category['id'] == $book['category'] ? 'selected' : '';
                            echo '<option value="'. $category['id'] .'" '. $selected .'>' . $category['name'] . '</option>';
                       }
                   ?>
              </select><br>
            <input type="number" name="stock" placeholder="庫存量" value="<?php echo $book['stock']; ?>" required><br>
            <button type="submit">更新</button>
             <button onclick="location.href='admin_dashboard.php'">返回</button>
        </form>
    </div>
</body>
</html>