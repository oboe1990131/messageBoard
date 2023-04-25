<?php
//session機制
session_start();
if(!isset($_SESSION["useraccount"])){
  header("Refresh:3; url=./login.php");
  echo "請遵循正規管道登入";
  exit;
}

//連線資料庫，查詢留言
include("connect.php");
$find = (isset($_GET["find"])) ? trim($_GET["find"]) : null;
$sql = "SELECT u.`id`, m.`nickname`, u.`message`, u.`auther_id`, m.`member_id`, u.`mood`, e.`id` AS emotion_id, e.`mood`
        FROM `usermessage` AS u
        LEFT JOIN `member` AS m ON u.`auther_id` = m.`member_id`
        LEFT JOIN `emotion` AS e ON u.`mood` = e.`id`";

// TODO這邊sql語法的模組化技術成分很高，要多看
$where = ($find != "" && isset($find)) ? " WHERE `nickname` LIKE ? OR `message` LIKE ?" : "";
$order = " ORDER BY u.`id` DESC";
$query_string = $sql.$where.$order;

$stmt_find = mysqli_prepare($db, $query_string);

if($find != "" && isset($find)){
  $like_str = "%{$find}%";
  mysqli_stmt_bind_param($stmt_find, "ss", $like_str, $like_str);
}

mysqli_stmt_execute($stmt_find);
$result_find = mysqli_stmt_get_result($stmt_find);
?>

<!DOCTYPE html>
<html>
    <head>
      <style>
        th {
            border:1px solid black;
        }

        table{
            margin-left: auto;
            margin-right: auto;
        }
      </style>
    </head>

    <body style="text-align: center;">  <!--文字置中-->
        <h1>心情留言板</h1>
        <p><?php echo "親愛的會員".$_SESSION["useraccount"]."歡迎回來";?></p>
        <a href="membercenter.php">會員中心</a>

        <form action="indext.php" method="get">
            請輸入欲查詢：
            <input type="text" name="find">
            <button type="submit" style="width: 80px; height: 30px;">送出</button>
        </form>
        
        <a href="indext.php">回首頁</a>
        <br>
        <a href="logout.php">登出</a>
        <br>

        <a href="create.php" >新增留言</a>   <!--這邊點選下去會進入留言填寫頁面-->
        <hr/>

        <table>
            <tr >
                <th>流水號</th>
                <th>留言者</th>
                <th>留言內容</th>
                <th>心情</th>
                <th>操作</th>
            </tr>

              <?php
              // 這邊就是要用while迴圈幫我把留言都印出來
              while($row = mysqli_fetch_array($result_find)):
              ?>
              
            <tr>
              <td><?php echo $row["id"]; ?> </td>   <!--印出你在資料庫抓到的東西-->
              <td><?php echo htmlspecialchars($row["nickname"]); ?> </td>
              <td><?php echo $row["message"]; ?><hr> </td>
              <td><?php echo $row["mood"]; ?><hr> </td>
              <td>
              <?php  if($_SESSION["member_id"] == $row["auther_id"]) :?>
                    <a href="edit.php?id=<?php echo $row["id"] ?>">編輯</a>
                    <!--這邊主要是帶我到編輯頁面，只是我會順便帶著使用者id到編輯頁面的-->

                    <button onclick="return confirmDelete(<?php echo $row['id'];?>)">刪除</button>
                    <!--我現在要怎麼攜帶一個可以辨識我要刪除的目標-->
              <?php endif ?>
              </td>
            </tr>
            <?php
                endwhile
              ?>
        </table>

        <script>
          <?php //123 ?>
          //456
              function confirmDelete(id){
                if(confirm("確認要刪除這篇留言嗎?")){
                  window.location.href="delete.php?id="+id;
                  //帶著我要刪除的那筆留言的id到刪除程式那邊去
                }
                else{
                  alert("您已取消刪除留言");
                }
              }
        </script>

    </body>
</html>