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
    <div id="messageModal" class="modal">
            <div class="modal-content message">
                <span class="close">×</span>
                <p id="modalMessage"></p>
            </div>
        </div>
    </div>
  <script>
    const bookList = document.getElementById('book-list');
     const userList = document.getElementById('user-list');
       const messageModal = document.getElementById('messageModal');
          const modalMessage = document.getElementById('modalMessage');
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
                    const deleteBtn = document.createElement('button');
                  deleteBtn.textContent = '刪除';
                  deleteBtn.onclick = () => deleteBook(book.id);
                   listItem.appendChild(deleteBtn);
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
                     const deleteBtn = document.createElement('button');
                  deleteBtn.textContent = '刪除';
                  deleteBtn.onclick = () => deleteUser(user.id);
                   listItem.appendChild(deleteBtn);
                userList.appendChild(listItem);
            });
        }


        function deleteBook(bookId) {
             if (confirm("確定要刪除這本書籍嗎？")) {
                 fetch('admin_actions.php', {
                   method: 'POST',
                     headers: {
                     'Content-Type': 'application/x-www-form-urlencoded',
                     },
                 body: 'action=delete_book&id=' + bookId
                  }).then(response => {
                      if (response.ok) {
                          bookList.innerHTML = "";
                          fetchBooks();
                           showModalMessage("刪除書籍成功");
                      } else {
                           showModalMessage("刪除書籍失敗");
                      }
                  });
             }
        }
        function deleteUser(userId) {
             if (confirm("確定要刪除這個使用者嗎？")) {
                fetch('admin_actions.php', {
                   method: 'POST',
                     headers: {
                     'Content-Type': 'application/x-www-form-urlencoded',
                     },
                 body: 'action=delete_user&id=' + userId
                 }).then(response => {
                     if (response.ok) {
                          userList.innerHTML = "";
                          fetchUsers();
                            showModalMessage("刪除使用者成功");
                       } else {
                           showModalMessage('刪除使用者失敗');
                       }
                  });
             }
        }
        function editUser(userId) {
             window.location.href = `admin_user_edit.php?id=${userId}`;
         }
        function editBook(bookId) {
            window.location.href = `edit_book.php?id=${bookId}`;
        }

         fetchUsers();
        fetchBooks();
       function showModalMessage(message) {
              modalMessage.textContent = message;
              messageModal.style.display = "flex";
            }
         var span = document.getElementsByClassName("close");
          for (const sp of span) {
           sp.onclick = function() {
              if (sp.closest(".modal"))
               {
                sp.closest(".modal").style.display = "none";
              }
        }
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
     if (event.target.className === "modal")
  {
     event.target.style.display = "none";
  }
}
    </script>
</body>
</html>