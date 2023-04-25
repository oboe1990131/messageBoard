<!DOCTYPE html>
<html lang="zh-Hans-TW">
<head>
    <!-- 編碼方式 -->
    <meta charset="UTF-8">
    <!-- 使用者預設看到畫面的大小比例 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regist</title>
</head>

<body>
    <h1 style="text-align:center">會員註冊<br></h1>
    <hr/>

    <form action="registtodb.php" method="post">
        <p>
            <label>帳號:</label>
            <input type="text" name="useraccount"/>
        </p>
        <p>
            <label>密碼:</label>
            <input type="password"name="password"/>
        </p>
        <p>
            <label>確認密碼:</label>
            <input type="password"name="passwordoublechk"/>
        </p>
        <p>
            <label>暱稱:</label>
            <input type="text"name="nickname"/>
        </p>
        <hr>
        <button type="submit" style="width: 80px; height: 30px">送出</button>
    </form>
    <a href="login.php">回登入頁</a>
</body>
</html>