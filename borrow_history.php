<?php
require_once('auth.php');
if (!isLoggedIn() || isAdmin()) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>我的借閱紀錄</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>我的借閱紀錄</h1>
          <p><a href="user_dashboard.php">返回</a></p>
         <ul id="borrowed-history-list">
         </ul>
    </div>
     <script>
        const borrowedHistoryList = document.getElementById('borrowed-history-list');

        async function fetchBorrowedHistory() {
              const response = await fetch('api/getBorrowHistory.php');
             const books = await response.json();
             books.forEach(book => {
                const listItem = document.createElement('li');
                listItem.textContent = `${book.title} by ${book.author} (借閱日期: ${book.borrow_date})`;
                if (book.return_date != null)
                {
                   listItem.textContent += ` (歸還日期: ${book.return_date})`;
                 }
                borrowedHistoryList.appendChild(listItem);
            });
        }
        fetchBorrowedHistory();
    </script>
</body>
</html>