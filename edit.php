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
        WHERE (u.`id`= $id) AND (`auther_id` = '{$_SESSION["member_id"]}')";
$result = mysqli_query($db, $sql) ?? die("insert error");  //去資料庫幫我拉出那個我要編輯的資料
$row = mysqli_fetch_array($result); //幫我把抓到的陣列資料轉成非陣列，可以顯示出來之資料型別
$rowtest = intval($row["mood"]);

if(mysqli_num_rows($result) == 0){
    echo '<script>alert("你編輯錯留言了!")</script>';
    header("Refresh:0; url=./login.php");
    exit;
}
else{
    //把留言頁面送出之  id & 留言內容  放進變數裡面 (查gpt查到的另一種方法，可將特殊字符替換)
    $id = mysqli_real_escape_string($db, $id);
}

// 查詢心情table，使得我可以用while迴圈印出來
$select_sql = "SELECT `id`, `mood`, `mood_id`
                FROM `emotion`";
$stmt_select = mysqli_prepare($db, $select_sql);
mysqli_stmt_execute($stmt_select);
$result_select = mysqli_stmt_get_result($stmt_select);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit page</title>
    <style>
        table{
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body style="text-align:center">
    <h1 style="text-align: center;">留言編輯區 </h1>
    <p style="text-align: center;">如果覺得剛剛說的有不妥的地方，再修改一下吧～</p>
    <hr/>

    <a href="indext.php">取消編輯</a>
    <br>

<!--基本上同新增頁那邊的邏輯，只差在我是改成拉出特定資料-->
<!--但，現在有一個問題，我要抓出特定使用者的資料，所以，當使用者按下編輯鍵時，我們就要先get他的特定留言 這樣我們才能比對-->
    <form action="edittodb.php" method="post">
        <table>
            <tr>
                <td><label>您的大名：<?php echo $_SESSION["useraccount"]; ?></label></td>
                <td><input type="hidden" name="id" value="<?php echo $row["id"]; ?>"><br><br></td>
            </tr>

            <tr>
                <td><label>您的留言</label></td>
                <td><textarea cols="100" rows="10" name="message"><?php echo str_replace('<br />', "\r\n", $row["message"]); ?></textarea></td>
            </tr>

            <tr>
                <td><p>請告訴我們您現在的心情如何：</p></td>
            </tr>

            <?php
            while($emotion = mysqli_fetch_array($result_select)):
            ?>

            <tr>
                <td><?php echo $emotion["mood"];?></td>
                <td><input type="radio" name="mood" id="<?php echo $emotion["mood_id"];?>" value="<?php echo $emotion["id"];?>"  <?php if($rowtest == $emotion["id"]){ echo "checked";}?>></td>
            </tr>

            <?php
            endwhile
            ?>

            <br>
            <button type="submit" style="width: 80px; height: 30px">送出</button>
            <br>
        </table>
    </form>
</body>
</html>