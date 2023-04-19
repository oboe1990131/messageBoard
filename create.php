<?php
session_start();
if(!isset($_SESSION["useraccount"])){
    echo '<script>alert("請循正規管道登入。")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    die;
}
?>

<!DOCTYPE html>
<html>
    <head> 
    </head>

    <body>
    <h2 style="text-align:center">心情抒發區<br></h2>
    <hr/>
    <form action="createtodb.php" method="post">
        <label>您的大名:<?php echo $_SESSION["useraccount"]; ?></label>
        <br>
        <br> 
        <label>您的留言:</label>   
        <textarea cols="100" rows="10" name="message"></textarea>
        <br>
        <br>    
        <button type="submit" style="width: 80px; height: 30px">送出</button>
    </form>
    <a href="indext.php">回首頁</a>
    </body>
</html>