<?php

// 使用者送甚麼過來，我就做甚麼事，但，這邊的精神是在於sql語句的模組化




session_start();
if(!isset($_SESSION["useraccount"])){
    echo '<script>alert("請循正規管道登入。")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    die;
}


// 剛剛前端的欄位如果有東西就放進變數裡，如果沒東西就把null方進去
// TODO  在加一個  不等於空字串  看看
$password = (isset($_POST['password'])) ? $_POST['password'] : null;
$passwordoublechk = (isset($_POST['passwordoublechk'])) ? $_POST['passwordoublechk'] : null;
$nickname = (isset($_POST['nickname'])) ? $_POST['nickname'] : null;










// 如果使用者今天只送密碼過來，就代表使用者想改密碼

// 如果使用者今天只送暱稱過來，就代表使用者想改暱稱

// 如果使用者今天送密碼、暱稱過來，就代表使用者想改密碼、暱稱



// TODO  要去檢查   如果我自己在用一次相同的暱稱   會發生甚麼事


// 查詢系列
include("connect.php");
$sql_check = "SELECT `useraccount`, `password`, `nickname`
                FROM `member`";

////////////////////////////////////////////////////
                // 如果想查詢暱稱有無重複，就加這句
$where_nickname = isset($nickname) ? " WHERE `nickname` = ?" : "";

                // 如果想查詢密碼有無跟舊的一樣，就加這句
$where_password = isset($password) ? " WHERE `useraccount` = ? AND `password` = ?" : "";

                // 如果想查暱稱、密碼，就加這句     但，這樣會有個問題   暱稱重複會被攔下來、密碼重複也會被攔下來
$where_nickname_password = (isset($nickname) && isset($password)) ? " WHERE (`useraccount` = ? AND `password` = ?) OR (`nickname` = ?)" : "";

////////////////////////////////////////////////////


$sql_check .= $where_nickname.$where_password.$where_nickname_password;


$stmt_check = mysqli_prepare($db, $sql_check);



////////////////////////////////////////////////////
if($nickname !== ""){
    // 如果是想查詢暱稱有無重複，這樣綁定
    mysqli_stmt_bind_param($stmt_check, "s", $nickname);
}

if($password !== ""){
    // 如果是想查詢密碼有無重複舊的，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "ss", $_SESSION['useraccount'], $hash);
}

if(($nickname !== "") && ($password !== "")){
    // 如果想查詢暱稱有無重複、密碼有無重複舊的，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "sss", $_SESSION['useraccount'], $hash, $nickname);
}


/*----------------註解內容------------------------*/




mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if(mysqli_num_rows($result_check) > 0){
    echo '<script>alert("有重複請確認")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
}
else{
    $sql_update = "UPDATE `member`";
}


$where_nickname = isset($nickname) ? " SET `nickname` = ? WHERE `useraccount` = ?" : "";

$whrer_password = isset($password) ? " SET `password` = ? WHERE `useraccount` = ?" : "";

$where_nickname_password = (isset($nickname) && isset($password)) ? " SET `nickname` = ?, `password` = ? WHERE `useraccount` = ?" : "";

$sql_update .= $where_nickname.$where_password.$where_nickname_password;

$stmt_update = mysqli_prepare($db, $sql_update);

////////////////////////////////////////////////////

if($nickname !== ""){
    // 如果是想查詢暱稱有無重複，這樣綁定
    mysqli_stmt_bind_param($stmt_check, "ss", $nickname, $_SESSION['useraccount']);
}

if($password !== ""){
    // 如果是想查詢密碼有無重複舊的，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "ss", $hash , $_SESSION['useraccount']);
}

if(($nickname !== "") && ($password !== "")){
    // 如果想查詢暱稱有無重複、密碼有無重複舊的，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "sss", $nickname, $hash , $_SESSION['useraccount']);
}

mysqli_stmt_execute($stmt_update);
echo '<script>alert("更新完成")</script>';
echo '<meta http-equiv="refresh" content="0; url=./indext.php">';

?>