<?php
session_start();
if(!isset($_SESSION["useraccount"])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
}

// 確認使用者有無在開發者工具那邊把暱稱欄位刪掉
$nickname = (isset($_POST["nickname"])) ? $_POST["nickname"] : null;

// 看使用者的暱稱欄位是否為空
if($nickname == "" || !isset($nickname)){
    echo '<script>alert("您似乎有欄位沒填到，請再檢查一下！")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
}
else{
    //如果沒問題，就執行INSERT INTO語句，更新會員暱稱
    $sql = "UPDATE `member` SET `nickname` = ? WHERE `useraccount` = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $nickname, $_SESSION["useraccount"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo '<script>alert("暱稱更新成功！")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
}
?>