<?php
session_start();
if(!isset($_SESSION["useraccount"])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
}

include("connect.php");
$useraccount = $_SESSION["useraccount"];   //抓取是哪個帳號要看資料
$sql = "SELECT * FROM `member` WHERE `useraccount`= ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "s", $useraccount);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="zh-Hans-TW">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>membercenter</title>
        <style>
            button{
                width: 150px; height: 30px;
            }
            h1{
                text-align: center;
            }
        </style>
    </head>

    <body>
        <h1>會員中心</h1>
        <hr>

        <form action="updatemembercenter.php" method="post">
            <p>
                <label>帳號:<?php  echo $row["useraccount"];  ?></label>
            </p>
            <p>
                <label>新密碼:</label>
                <input type="password" name="password"/>
            </p>
            <p>
                <label>確認新密碼:</label>
                <input type="password" name="passwordoublechk"/>
            </p>
            <p>
                <label>暱稱:</label>
                <input type="text" name="nickname" value="<?php echo htmlspecialchars($row["nickname"]);?>">
            </p>
            
            <button type="submit">修改</button>
        </form>
        
        <a href="indext.php">回首頁</a>
    </body>
</html>