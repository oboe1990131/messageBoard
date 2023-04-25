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
        <label>您的大名:<?php echo $_SESSION["useraccount"]; ?></label><br><br>
        
        <label>您的留言:</label>   
        <textarea cols="100" rows="10" name="message"></textarea><br><br>

        <p>請告訴我們您現在的心情如何：</p>
        <input type="radio" name="mood" id="happy" value="1">
        <label for="happy">開心</label><br>

        <input type="radio" name="mood" id="very_happy" value="2">
        <label for="sad">很開心</label><br>
        
        <input type="radio" name="mood" id="annoy" value="3">
        <label for="angry">煩</label><br>

        <input type="radio" name="mood" id="very_annoy" value="4">
        <label for="angry">很煩</label><br>

        <input type="radio" name="mood" id="angry" value="5">
        <label for="angry">怒</label><br>

        <input type="radio" name="mood" id="very_angry" value="6">
        <label for="angry">很惱怒</label><br>

        <button type="submit" style="width: 80px; height: 30px">送出</button>
    </form>
    <a href="indext.php">回首頁</a>
    </body>
</html>