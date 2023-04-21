<?php
session_start();

//從登入頁面那邊撈取帳號密碼(也順便執行變數分離)
$useraccount = (isset($_POST["useraccount"])) ? $_POST["useraccount"] : null;
$password = (isset($_POST["password"])) ? $_POST["password"] : null;

// 這邊我先看使用者是否有漏填帳密
if($useraccount == "" || $password == ""){
    echo '<script>alert("您似乎有漏填帳後或密碼，請再檢查一下")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}
else{
    //引入連資料庫程式，去查資料
    include("connect.php");
    $hash = hash("sha256", $password);
    $sql = "SELECT * FROM `member` WHERE `useraccount` = ? AND `password` = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $useraccount, $hash);
    mysqli_stmt_execute($stmt);
    $result_num = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result_num);

    // 確認有無吻合的帳密，用筆數來做確認
    if (mysqli_num_rows($result_num) == 0) {
        echo '<script>alert("密碼不正確，請重新輸入")</script>';
        echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    }
    else{
        // 如果帳號密碼正確的話，我就把member表單資料放進會員認證卡裡面
        $_SESSION["member_id"] = $row["member_id"];
        // 那其中我這個id是後面串表要使用的
        $_SESSION["useraccount"] = $row["useraccount"];
        header("Location: indext.php");
    }
}
?>