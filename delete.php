<?php
session_start();
if(!isset($_SESSION['useraccount'])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
}

$id = $_GET["id"];
// TODO   id也要做驗證，因為也是前端傳來的
$member_id = $_SESSION["member_id"];

//先檢驗id，看使用者有沒有利用開發工具偷改id來竄改別人留言
// TODO這邊改成用count這個方法，這樣也剛好可以跟下面的if條件式配合
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
    echo '<script>alert("您刪錯留言了")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
    die;
}
else{
    //去把我指定的留言刪掉
    $sql_delete= "DELETE FROM `usermessage` WHERE `id`= ?";
    $stmt_delete = mysqli_prepare($db, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id);
    mysqli_stmt_execute($stmt_delete);
    echo "<script>";
    echo "alert('您已刪除成功！')";
    echo "</script>";
    echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
}
?>