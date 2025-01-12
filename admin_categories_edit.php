<?php
require_once('auth.php');
require_once('config.php');

if (!isAdmin()) {
    header('Location: index.php');
    exit();
}
 $categoryId = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE id = '$categoryId'";
    $result = $conn->query($sql);
        if ($result->num_rows != 1) {
              header('Location: admin_categories.php');
               exit();
          }
$category = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>編輯書籍類別</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>編輯書籍類別</h1>
         <form action="admin_categories.php" method="post">
              <input type="hidden" name="action" value="edit_category">
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            <input type="text" name="name" placeholder="類別名稱" value="<?php echo $category['name']; ?>" required> <br>
               <input type="number" name="borrow_period" placeholder="借閱期限" value="<?php echo $category['borrow_period']; ?>" required> <br>
            <button type="submit">更新</button>
        </form>
    </div>
</body>
</html>