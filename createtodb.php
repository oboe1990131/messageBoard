<?php
session_start();
if(!isset($_SESSION["useraccount"])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
}

//把留言頁面送出之  留言者id & 留言內容 & 心情  先放進變數裡面
include ("connect.php");
$id = mysqli_real_escape_string($db, $_SESSION["member_id"]);
$message = (isset($_POST["message"])) ? $_POST["message"] : null;
$mood = $_POST["mood"];

if(($message == "" || !isset($message)) || ($mood == "" || !isset($mood))){
    echo '<script>alert("您似乎有漏填了，請再確定一下！")</script>';
    header("Refresh:0; url=./create.php");
    exit;
}
else{
    // 把訊息做資安預防、換行處理
    $message = nl2br($message);
    $message = str_replace("\r\n", "", $message);
    $message = mysqli_real_escape_string($db, $message);
}

//去資料庫新增留言
$sql = "INSERT INTO `usermessage`  (`message`, `auther_id`, `mood`) VALUES(?, ?, ?)";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "sis", $message, $id, $mood);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

//重新導頁回首頁
header("Location:indext.php");
?>