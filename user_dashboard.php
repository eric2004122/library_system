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
    <title>使用者介面</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>歡迎, <?php echo $_SESSION['username']; ?></h1>
        <p><a href="logout.php">登出</a></p>
         <div class="user-top-section">
        <div style="margin-bottom: 10px;">
            <input type="text" id="bookSearch" placeholder="搜尋書名/作者">
        </div>
       </div>
        <h2>可借閱書籍</h2>
        <ul id="book-list" class="card-list">
        </ul>

        <div class="borrowed-book-container">
            <div class="borrowed-book-section">
                <h2>已歸還紀錄</h2>
                <ul id="borrowed-book-list-returned">
                </ul>
            </div>
             <div class="borrowed-book-section">
                <h2>未歸還紀錄</h2>
                  <ul id="borrowed-book-list-unreturned">
                </ul>
            </div>
        </div>
          <button onclick="location.href='borrow_history.php'">查看借閱紀錄</button>
              <div id="messageModal" class="modal">
            <div class="modal-content message">
                <span class="close">×</span>
                <p id="modalMessage"></p>
            </div>
        </div>
    </div>
    <script>
    const bookList = document.getElementById('book-list');
    const borrowedBookListReturned = document.getElementById('borrowed-book-list-returned');
    const borrowedBookListUnreturned = document.getElementById('borrowed-book-list-unreturned');
    const bookSearchInput = document.getElementById('bookSearch');
        const messageModal = document.getElementById('messageModal');
          const modalMessage = document.getElementById('modalMessage');
    let allBooks = [];
        async function fetchBooks() {
            const response = await fetch('api/getBooks.php');
            const books = await response.json();
            allBooks = books;
             updateBookList(books);
        }

        function updateBookList(books) {
            bookList.innerHTML = "";
               books.forEach(book => {
                 const listItem = document.createElement('li');
                 listItem.classList.add('card');
                   const cardBody = document.createElement('div');
                   cardBody.classList.add('card-body');
                cardBody.textContent = `${book.title} by ${book.author} (庫存: ${book.stock}) (狀態: ${book.borrow_status ?? '在架上'})`;
                 if(book.stock > 0) {
                   const borrowBtn = document.createElement('button');
                  borrowBtn.textContent = '借閱';
                   borrowBtn.onclick = () => borrowBook(book.id);
                    cardBody.appendChild(borrowBtn);
                   }
                 listItem.appendChild(cardBody);
                bookList.appendChild(listItem);
            });
        }
         bookSearchInput.addEventListener('input', function() {
              const searchTerm = bookSearchInput.value.toLowerCase();
             const filteredBooks = allBooks.filter(book => {
                 const title = book.title.toLowerCase();
                const author = book.author.toLowerCase();
                return title.includes(searchTerm) || author.includes(searchTerm);
            });

             updateBookList(filteredBooks);
        });

      async function fetchBorrowedBooks() {
              const response = await fetch('api/getBorrowedBooks.php');
             const books = await response.json();
             borrowedBookListReturned.innerHTML = '';
              borrowedBookListUnreturned.innerHTML = '';

             books.forEach(book => {
                const listItem = document.createElement('li');
                listItem.textContent = `${book.title} by ${book.author} (借閱日期: ${book.borrow_date})`;
                   if (book.overdue_days > 0){
                       listItem.textContent += ` (逾期: ${book.overdue_days} 天)`;
                   }
               if (book.return_date == null){
                     const returnBtn = document.createElement('button');
                  returnBtn.textContent = '歸還';
                  returnBtn.onclick = () => returnBook(book.borrow_id, book.id);
                  listItem.appendChild(returnBtn);
                 borrowedBookListUnreturned.appendChild(listItem);
                } else {
                    listItem.textContent += ` (歸還日期: ${book.return_date})`;
                   borrowedBookListReturned.appendChild(listItem);
                 }

            });
        }
        async function returnBook(borrowId, bookId) {
            const response = await fetch('api/returnBook.php', {
                 method: 'POST',
                 headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ borrow_id: borrowId, book_id: bookId })
            });

             if (response.ok) {
                 bookList.innerHTML = "";
                borrowedBookListReturned.innerHTML = "";
                 borrowedBookListUnreturned.innerHTML = "";
                 fetchBooks();
                 fetchBorrowedBooks();
                showModalMessage("歸還成功");
             } else {
                  showModalMessage('歸還失敗');
            }
         }

        async function borrowBook(bookId) {
           const response = await fetch('api/borrowBook.php', {
                 method: 'POST',
                 headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ book_id: bookId })
            });

            if (response.ok) {
                 bookList.innerHTML = "";
                 borrowedBookListReturned.innerHTML = "";
                  borrowedBookListUnreturned.innerHTML = "";
                  fetchBooks();
                  fetchBorrowedBooks();
               showModalMessage("借閱成功");
             } else {
                showModalMessage('借閱失敗');
            }
         }

        fetchBooks();
         fetchBorrowedBooks();
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