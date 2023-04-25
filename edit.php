<?php
// 這邊是用session擋住直接輸入網址的使用者
session_start();
if(!isset($_SESSION["useraccount"])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
}

//先檢驗id，看使用者有沒有利用開發工具偷改id來竄改別人留言
include ("connect.php");
$id = $_GET["id"];
$sql = "SELECT u.`id`, u.`message`, u.`auther_id`, u.`mood`
        FROM `usermessage` AS u
        LEFT JOIN `member` AS m ON u.`auther_id` = m.`member_id`
        -- LEFT JOIN `emotion` AS e ON u.`mood` = e.`mood`
        WHERE (u.`id`= $id) AND (`auther_id` = '{$_SESSION["member_id"]}')";
$result = mysqli_query($db, $sql) ?? die("insert error");  //去資料庫幫我拉出那個我要編輯的資料
$row = mysqli_fetch_array($result); //幫我把抓到的陣列資料轉成非陣列，可以顯示出來之資料型別

if(mysqli_num_rows($result) == 0){
    echo '<script>alert("你編輯錯留言了!")</script>';
    header("Refresh:0; url=./login.php");
    exit;
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
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>"><br><br>

        <label>您的留言</label>
        <textarea cols="100" rows="10" name="message"><?php echo nl2br($row["message"]); ?></textarea>
        
        <p>請告訴我們您現在的心情如何：</p>
        <!-- TODO  再精簡化，學長說的其實不是這個方法-->
        <input type="radio" name="mood" id="happy" value="1" <?php if ($row['mood'] === '1') { echo 'checked'; }?>>
        <label for="happy">開心</label><br>

        <input type="radio" name="mood" id="very_happy" value="2" <?php if ($row['mood'] === '2') { echo 'checked'; }?>>
        <label for="sad">很開心</label><br>
        
        <input type="radio" name="mood" id="annoy" value="3" <?php if ($row['mood'] === '3') { echo 'checked'; }?>>
        <label for="angry">煩</label><br>

        <input type="radio" name="mood" id="very_annoy" value="4" <?php if ($row['mood'] === '4') { echo 'checked'; }?>>
        <label for="angry">很煩</label><br>

        <input type="radio" name="mood" id="angry" value="5" <?php if ($row['mood'] === '5') { echo 'checked'; }?>>
        <label for="angry">怒</label><br>

        <input type="radio" name="mood" id="very_angry" value="6" <?php if ($row['mood'] === '6') { echo 'checked'; }?>>
        <label for="angry">很惱怒</label><br>

        <button type="submit" style="width: 80px; height: 30px">送出</button>
        <a href="indext.php">取消編輯</a>
        <br>
        <br>
    </form>
</body>
</html>