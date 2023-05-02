<?php
//session機制
session_start();
if(!isset($_SESSION["useraccount"])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
}

// 去資料庫抓心情相關資料
include("connect.php");
$select_sql = "SELECT `id`, `mood`, `mood_id`
                FROM `emotion`";
$stmt_select = mysqli_prepare($db, $select_sql);
mysqli_stmt_execute($stmt_select);
$select_result = mysqli_stmt_get_result($stmt_select);
?>

<!DOCTYPE html>
<html>
    <head> 
        <title>create message</title>
        <style>
            table{
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>

    <body style="text-align:center">
    <h2 style="text-align:center">心情抒發區<br></h2>
    <hr/>

    <a href="indext.php">回首頁</a>

    <form action="createtodb.php" method="post">
        <table>
            <tr>
                <td>您的大名:</td>
                <td><?php echo $_SESSION["useraccount"]; ?><br><br></td>
            </tr>
            
            <tr>
                <td>您的留言:</td>
                <td><textarea cols="100" rows="10" name="message"></textarea><br><br></td> 
            </tr>

            <tr>
                <td>您現在心情：</td>
            </tr>

            <?php
            while($emotion = mysqli_fetch_array($select_result)):
            ?>

            <tr>
                <td><label><?php echo $emotion["mood"];?></label></td>
                <td><input type="radio" name="mood" id="<?php echo $emotion["mood_id"]?>" value="<?php echo $emotion["id"]?>"></td>                
            </tr>

            <?php
            endwhile
            ?>

            <br>
            <button type="submit" style="width: 80px; height: 30px">送出</button>
        </table>
    </form>
    </body>
</html>