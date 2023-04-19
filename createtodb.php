<?php
session_start();
if(!isset($_SESSION["useraccount"])){
    echo '<script>alert("請循正規管道登入。")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    die;
}

//把留言頁面送出之  留言者id & 留言內容  先放進變數裡面
include ("connect.php");
$id = mysqli_real_escape_string($db, $_SESSION["member_id"]);
$message = (isset($_POST["message"])) ? $_POST["message"] : null;

if($message == ""){
    echo '<script>alert("您似乎忘記填寫流言了，請再確定一下！")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./create.php">';
    die;
}
else{
    $message = htmlspecialchars($message);
    $message = nl2br($message);
    $message = str_replace("\r\n", "", $message);
    $message = mysqli_real_escape_string($db, $message);
}

//去資料庫新增留言
$sql = "INSERT INTO `usermessage`  (`message`, `auther_id`) VALUES(?, ?)";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "si", $message, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

//重新導頁回首頁
header("Location:indext.php");
?>