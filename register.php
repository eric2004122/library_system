<!DOCTYPE html>
<html>
<head>
    <title>使用者註冊</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="register-container">
        <h1>使用者註冊</h1>
        <form action="register_process.php" method="post">
             <input type="text" name="username" placeholder="使用者名稱" required><br>
            <input type="password" name="password" placeholder="密碼" required><br>
            <button type="submit">註冊</button>
        </form>
    </div>
</body>
</html>