<?php
require_once('auth.php');
require_once('config.php');

if (!isAdmin()) {
    header('Location: index.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $action = $_POST['action'];
     if ($action === "add_category") {
         $name = $conn->real_escape_string($_POST['name']);
          $borrowPeriod = intval($_POST['borrow_period']);

        $sql = "INSERT INTO categories (name, borrow_period) VALUES ('$name', '$borrowPeriod')";
            if ($conn->query($sql) === TRUE) {
              header('Location: admin_categories.php');
             } else {
                echo "新增書籍類別失敗: " . $conn->error;
            }
         } else if ($action === "edit_category") {
             $id = intval($_POST['id']);
         $name = $conn->real_escape_string($_POST['name']);
          $borrowPeriod = intval($_POST['borrow_period']);
              $sql = "UPDATE categories SET name = '$name', borrow_period = '$borrowPeriod' WHERE id = '$id'";
                  if ($conn->query($sql) === TRUE) {
                    header('Location: admin_categories.php');
                } else {
                    echo "更新書籍類別失敗: " . $conn->error;
                }
       }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>管理書籍類別</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>管理書籍類別</h1>
        <h2>新增書籍類別</h2>
         <form method="post">
             <input type="hidden" name="action" value="add_category">
             <input type="text" name="name" placeholder="類別名稱" required> <br>
               <input type="number" name="borrow_period" placeholder="借閱期限" required> <br>
            <button type="submit">新增</button>
               <button onclick="location.href='admin_dashboard.php'">返回</button>
        </form>
         <h2>編輯書籍類別</h2>
           <ul id="category-list">
            </ul>
    </div>
     <script>
    const categoryList = document.getElementById('category-list');
    async function fetchCategories() {
              const response = await fetch('api/getCategories.php');
             const categories = await response.json();
             categories.forEach(category => {
                const listItem = document.createElement('li');
                listItem.textContent = `${category.name} (借閱期限: ${category.borrow_period})`;
                 const editBtn = document.createElement('button');
                  editBtn.textContent = '編輯';
                  editBtn.onclick = () => editCategory(category.id);
                   listItem.appendChild(editBtn);
                    categoryList.appendChild(listItem);
            });
        }
          function editCategory(categoryId) {
            window.location.href = `admin_categories_edit.php?id=${categoryId}`;
        }

        fetchCategories();
    </script>
</body>
</html>