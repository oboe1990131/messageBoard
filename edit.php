<?php
// 這邊是用session擋住直接輸入網址的使用者
session_start();
if(!isset($_SESSION["useraccount"])){
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
    echo '<script>alert("you are editing the wrong message.")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
    die;
}
else{
    //把留言頁面送出之  id & 留言內容  放進變數裡面 (查gpt查到的另一種方法，可將特殊字符替換)
    $id = mysqli_real_escape_string($db, $id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit page</title>
</head>

<body>
    <h1 style="text-align: center;">留言編輯區 </h1>
    <p style="text-align: center;">如果覺得剛剛說的有不妥的地方，再修改一下吧～</p>
    <hr/>
<!--基本上同新增頁那邊的邏輯，只差在我是改成拉出特定資料-->
<!--但，現在有一個問題，我要抓出特定使用者的資料，所以，當使用者按下編輯鍵時，我們就要先get他的特定留言 這樣我們才能比對-->
    <form action="edittodb.php" method="post">
        <label>您的大名：<?php echo $_SESSION["useraccount"]; ?></label>
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
        <br>
        <br>
        您的留言
        <textarea cols="100" rows="10" name="message"><?php echo nl2br($row["message"]); ?></textarea>
        
        <button type="submit" style="width: 80px; height: 30px">送出</button>
        <a href="indext.php">取消編輯</a>
        <br>
        <br>
    </form>
</body>
</html>