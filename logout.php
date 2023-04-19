<?php
//登出操作程序

//1清除用戶端的cookie值，使得用戶端的session會員卡號消掉
setcookie("PHPSESSID", null, time()-1, "/");

//2把目前頁面被assign的$_SESSION["useraccount"]變數消掉
$_SESSION["useraccount"] = array();

//3把伺服器端的會員卡也消掉
session_destroy();

echo '<script>alert("登出成功"); location="./login.php"</script>';
?>