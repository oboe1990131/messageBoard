<?php
//session機制
session_start();
if(!isset($_SESSION["useraccount"])){
    header("Refresh:3; url=./login.php");
    echo "請遵循正規管道登入";
    exit;
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