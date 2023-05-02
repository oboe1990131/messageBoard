<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 樣式外部連結 -->
    <link rel="stylesheet" type="text/css" href="loginstyle.css">
    <title>Login</title>
</head>
<body>
    <div id="frm">
        <!-- 我這邊就用一個form表單去接收用戶輸入的帳密 -->
        <!-- 然後會把我接收到的帳密丟給processlogin  (去判斷) -->
        <form action="processlogin.php" method="POST">
            <p>
                <label>Username:</label>
                <input type="text" id="user" name="useraccount"/>
            </p>
            <p>
                <label>Password:</label>
                <input type="password" id="pass" name="password"/>
            </p>
            <p>
                <input type="submit" id="btn" value="Login">
            </p>
            <p>
                <a href="regist.php">註冊會員</a>
            </p>
        </form>
    </div>
</body>
</html>