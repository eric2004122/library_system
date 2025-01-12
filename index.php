<!DOCTYPE html>
<html>
<head>
    <title>圖書館管理系統</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>圖書館管理系統</h1>
        <h2>登入</h2>
        <form action="login_process.php" method="post">
            <input type="text" name="username" placeholder="使用者名稱" required><br>
            <input type="password" name="password" placeholder="密碼" required><br>
            <button type="submit">登入</button>
        </form>
        <p>還沒有帳號嗎？<a href="register.php">註冊</a></p>
          <?php
            session_start();
        if (isset($_SESSION['register_success'])) {
           echo '<script>
               document.addEventListener("DOMContentLoaded", function() {
                  document.getElementById("modalSuccessMessage").textContent = "'. $_SESSION['register_success'] .'";
                 document.getElementById("successModal").style.display = "flex";
              });
           </script>';
           unset($_SESSION['register_success']);
        }
        if (isset($_SESSION['login_error'])) {
           echo '<script>
               document.addEventListener("DOMContentLoaded", function() {
                  document.getElementById("modalErrorMessage").textContent = "'. $_SESSION['login_error'] .'";
                 document.getElementById("errorModal").style.display = "flex";
              });
           </script>';
           unset($_SESSION['login_error']);
        }
        ?>
           <!-- Modal 結構 -->
        <div id="errorModal" class="modal">
            <div class="modal-content">
                <span class="close">×</span>
                <p id="modalErrorMessage"></p>
            </div>
        </div>
            <!-- Success Modal 結構 -->
    <div id="successModal" class="modal">
         <div class="modal-content success">
              <span class="close">×</span>
             <p id="modalSuccessMessage"></p>
        </div>
    </div>
    </div>

    <script>
     // Get the modal
var modal = document.getElementById("errorModal");
var successModal = document.getElementById("successModal");
// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
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