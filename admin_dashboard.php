<?php
require_once('auth.php');
if (!isAdmin()) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>管理員介面</title>
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>管理員儀表板</h1>
        <p><a href="logout.php">登出</a></p>
          <div class="admin-section">
             <h2>書籍管理</h2>
           <button onclick="location.href='add_book.php'">新增書籍</button>
            <button onclick="location.href='admin_categories.php'">管理書籍類別</button>
           <ul id="book-list">
            </ul>
        </div>
        <div class="admin-section">
          <h2>使用者管理</h2>
        <ul id="user-list">
        </ul>
         </div>
             <div class="admin-section">
          <h2>罰款管理</h2>
         <button onclick="location.href='fines.php'">管理罰款</button>
        </div>
    </div>
   <script>
    const bookList = document.getElementById('book-list');
     const userList = document.getElementById('user-list');
        async function fetchBooks() {
            const response = await fetch('api/getBooks.php');
            const books = await response.json();
             books.forEach(book => {
                const listItem = document.createElement('li');
                listItem.textContent = `${book.title} by ${book.author} (出版日期: ${book.publish_date})`;
                 const editBtn = document.createElement('button');
                  editBtn.textContent = '編輯';
                  editBtn.onclick = () => editBook(book.id);
                   listItem.appendChild(editBtn);
                    bookList.appendChild(listItem);
            });
        }

         async function fetchUsers() {
              const response = await fetch('api/getUsers.php');
             const users = await response.json();
             users.forEach(user => {
                const listItem = document.createElement('li');
                listItem.textContent = `${user.username} (權限: ${user.role})`;
                  const editBtn = document.createElement('button');
                  editBtn.textContent = '編輯';
                   editBtn.onclick = () => editUser(user.id);
                   listItem.appendChild(editBtn);
                userList.appendChild(listItem);
            });
        }

        function editUser(userId) {
             window.location.href = `admin_user_edit.php?id=${userId}`;
         }
        function editBook(bookId) {
            window.location.href = `edit_book.php?id=${bookId}`;
        }

         fetchUsers();
        fetchBooks();
    </script>
</body>
</html>