<?php
// 這邊主要擋住直接key網址的使用者
session_start();
if(!isset($_SESSION["useraccount"])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
}

$id = $_POST["id"];
$member_id = $_SESSION["member_id"];

//先檢驗id，看使用者有沒有利用開發工具偷改id來竄改別人留言
include ("connect.php");
$sql_chkid = "SELECT `id`, `message`, `auther_id`, `member_id`
        FROM `usermessage` AS u
        LEFT JOIN `member` AS m
        ON u.`auther_id` = m.`member_id`
        WHERE `id`= ? AND `auther_id` = ?";
$stmt_chkid = mysqli_prepare($db, $sql_chkid);
mysqli_stmt_bind_param($stmt_chkid, "ii", $id, $member_id);
mysqli_stmt_execute($stmt_chkid);
$result = mysqli_stmt_get_result($stmt_chkid);

if(mysqli_num_rows($result) == 0){
    echo '<script>alert("you are editing the wrong message.")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
    die;
}
else{
    //把留言頁面送出之  id & 留言內容  放進變數裡面 (查gpt查到的另一種方法，可將特殊字符替換)
    $id = mysqli_real_escape_string($db, $id);
}

//先確認使用者有無使用開發工具變動message
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

// 更新留言
$sql = "UPDATE `usermessage` SET `message` = ? WHERE `id` = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "si", $message, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
echo '<script>alert("留言更新成功！")</script>';
echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
?>