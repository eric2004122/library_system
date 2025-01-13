<?php
require_once('auth.php');
require_once('config.php');
if (!isAdmin()) {
    header('Location: index.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $action = $_POST['action'];
    if ($action == 'pay_fine') {
       $fineId = intval($_POST['fine_id']);
             $sql = "UPDATE fines SET paid=1 WHERE id = $fineId";
          if ($conn->query($sql) === TRUE) {
             header('Location: fines.php');
          } else {
               echo "繳納罰款失敗: " . $conn->error;
          }
    }
 }
?>
<!DOCTYPE html>
<html>
<head>
    <title>管理使用者罰款</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>管理使用者罰款</h1>
        <ul id="fine-list">
            </ul>
         <button onclick="location.href='admin_dashboard.php'">返回</button>
             <div id="messageModal" class="modal">
            <div class="modal-content message">
                <span class="close">×</span>
                <p id="modalMessage"></p>
            </div>
        </div>
    </div>
    <script>
    const fineList = document.getElementById('fine-list');
        const messageModal = document.getElementById('messageModal');
          const modalMessage = document.getElementById('modalMessage');
    async function fetchFines() {
              const response = await fetch('api/getFines.php');
             const fines = await response.json();
             fines.forEach(fine => {
                const listItem = document.createElement('li');
                listItem.textContent = `使用者ID: ${fine.user_id} (罰款金額: ${fine.amount}  已繳款: ${fine.paid == 1 ? '是' : '否'})`;
                if (fine.paid == 0)
                {
                   const payBtn = document.createElement('button');
                  payBtn.textContent = '繳納';
                  payBtn.onclick = () => payFine(fine.id);
                   listItem.appendChild(payBtn);
               }
                    fineList.appendChild(listItem);
            });
        }
          async function payFine(fineId) {
            const response = await fetch('fines.php', {
                   method: 'POST',
                    headers: {
                     'Content-Type': 'application/x-www-form-urlencoded',
                     },
                  body: 'action=pay_fine&fine_id=' + fineId
             });
            if (response.ok) {
                 fineList.innerHTML = "";
                 fetchFines();
               showModalMessage("繳納成功");
             } else {
               showModalMessage('繳納失敗');
            }
        }
        fetchFines();
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