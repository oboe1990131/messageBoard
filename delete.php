<?php
session_start();
if(!isset($_SESSION['useraccount'])){
    echo '<script>alert("請循正規管道登入。")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    die;
}

//先檢驗id，看使用者有沒有利用開發工具偷改id來竄改別人留言
include ("connect.php");
$id = $_GET["id"];
$sql = "SELECT `id`, `message`, `auther_id`, `member_id`
        FROM `usermessage` AS u
        LEFT JOIN `member` AS m
        ON `auther_id` = `member_id`
        WHERE `id`= $id AND `auther_id` = '{$_SESSION["member_id"]}'";
$result = mysqli_query($db, $sql) ?? die("insert error");  //去資料庫幫我拉出那個我要編輯的資料
$row = mysqli_fetch_array($result); //幫我把抓到的陣列資料轉成非陣列，可以顯示出來之資料型別

if(mysqli_num_rows($result) == 0){
    echo '<script>alert("you are deleting the wrong message.")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
    die;
}
else{
    //去把我指定的留言刪掉
    $id= $_GET["id"]; //把剛剛抓到的辨識刪除目標id先存進id變數中
    $sql= "DELETE FROM `usermessage` WHERE `id`= $id";
    $result= mysqli_query($db, $sql) ?? die("delete error");
    echo "<script>";
    echo "alert('您已刪除成功！')";
    echo "</script>";
    echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
}
?>