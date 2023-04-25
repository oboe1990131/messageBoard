<?php

// 使用者送甚麼過來，我就做甚麼事，但，這邊的精神是在於sql語句的模組化




session_start();
if(!isset($_SESSION["useraccount"])){
    echo '<script>alert("請循正規管道登入。")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    die;
}





// 剛剛前端的欄位如果有東西就放進變數裡，如果沒東西就把null放進去
// TODO這邊目前的工作   驗證欄位有沒有被拔掉，       那如果今天使用者沒輸入東西   就是空字串 (在isset那邊是會被認定有東西的)  、  有輸入東西  都會被視為isset而通過
$password = (isset($_POST['password'])) ? $_POST['password'] : null;
$passwordoublechk = (isset($_POST['passwordoublechk'])) ? $_POST['passwordoublechk'] : null;
$nickname = (isset($_POST['nickname'])) ? $_POST['nickname'] : null;








// TODO這邊的工作  篩掉輸入不完全
// 只有打密碼
// 只有打密碼doublechk
// 打暱稱+密碼
// 打暱稱+密碼doublechk，          這邊就統整出，你只要有打密碼，你就要全打，你不能只打一個
if(($password !== "" && $passwordoublechk === "") || ($password === "" && $passwordoublechk !== "")){
    echo "你的密碼欄位沒有填完全，請再確認!";
    header("Refresh:2; url=./membercenter.php");
    exit;
}
elseif($password === null || $passwordoublechk === null || $nickname === null){
    echo "你的欄位沒有填完全，請再確認!";
    header("Refresh:2; url=./membercenter.php");
    exit;
}












/*-------------依據使用者可能會修改：  1暱稱、  2密碼、  3暱稱+密碼---------------------------*/



// TODO  要去檢查   如果我自己在用一次相同的暱稱   會發生甚麼事
// 查詢系列
include("connect.php");
$sql_check = "SELECT `useraccount`, `password`, `nickname`
                FROM `member`";






/*-------------依據使用者想---------------------------*/
                // 如果想查詢暱稱有無重複，就加這句
$where_nickname = (($nickname !== "") && ($password === "")) ? " WHERE `nickname` = ? AND `useraccount` != ?" : "";

                // 如果想查詢密碼有無跟舊的一樣，就加這句
$where_password = (($nickname === "") && ($password !== "")) ? " WHERE `useraccount` = ? AND `password` = ?" : "";

                // 如果想查暱稱、密碼，就加這句     但，這樣會有個問題   暱稱重複會被攔下來、密碼重複也會被攔下來
$where_nickname_password = (($nickname !== "") && ($password != "")) ? " WHERE (`useraccount` = ? AND `password` = ?) OR (`nickname` = ? AND `useraccount` != ?)" : "";

/*-----------------------------------------------*/





$sql_check .= $where_nickname.$where_password.$where_nickname_password;

$stmt_check = mysqli_prepare($db, $sql_check);






/*--------------------------------------------------*/
if(($nickname !== "") && ($password === "")){
    // 如果是想查詢暱稱有無重複，這樣綁定
    mysqli_stmt_bind_param($stmt_check, "ss", $nickname, $_SESSION['useraccount']);
}

if(($nickname === "") && ($password !== "")){
    // 如果是想查詢密碼有無重複舊的，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "ss", $_SESSION['useraccount'], $hash);
}

if(($nickname !== "") && ($password !== "")){
    // 如果想查詢暱稱有無重複、密碼有無重複舊的，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "ssss", $_SESSION['useraccount'], $hash, $nickname, $_SESSION['useraccount']);
}
/*--------------------------------------------------*/





mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$result_check_content = mysqli_fetch_array($result_check);


// TODO這邊的工作：幫我看重複     (這邊我不用筆數判斷了，我用帳號來判斷)
if($result_check_content['useraccount'] === $_SESSION['useraccount']){
    echo "密碼不可與舊的相同，請再確認!";
    header("Refresh:2; url=./membercenter.php");
    exit;
}
elseif(($result_check_content['useraccount'] !== $_SESSION['useraccount']) && ($result_check_content !== null)){
    echo "暱稱不可與別人相同，請再確認!";
    header("Refresh:2; url=./membercenter.php");
    exit;
}













/*---------------------檢查沒問題之後，就是去更新使用者想要更新的內容-----------------------------*/

    $sql_update = "UPDATE `member`";





/*--------------------------------------------------*/
$where_nickname = (($nickname != "") && ($password == "")) ? " SET `nickname` = ? WHERE `useraccount` = ?" : "";

$whrer_password = (($nickname == "") && ($password != "")) ? " SET `password` = ? WHERE `useraccount` = ?" : "";

$where_nickname_password = (($nickname != "") && ($password != "")) ? " SET `nickname` = ?, `password` = ? WHERE `useraccount` = ?" : "";

$sql_update .= $where_nickname.$where_password.$where_nickname_password;
/*--------------------------------------------------*/


// echo '<pre>';
// print_r($result);
// gettype($result);

echo $where_nickname;
echo "<br>";
echo $where_password;
echo "<br>";
echo $where_nickname_password;
echo "<br>";
echo $sql_update;
echo "<br>";
die("run to here.");


$stmt_update = mysqli_prepare($db, $sql_update);






/*--------------------------------------------------*/
if($nickname !== ""){
    // 如果是想改暱稱，這樣綁定
    mysqli_stmt_bind_param($stmt_check, "ss", $nickname, $_SESSION['useraccount']);
    echo "有綁定暱稱";
}

if($password !== ""){
    // 如果是想改密碼，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "ss", $hash , $_SESSION['useraccount']);
    echo "有綁定密碼";
}

if(($nickname !== "") && ($password !== "")){
    // 如果想改暱稱、密碼，這樣綁定
    $hash = hash("sha256", $password);
    mysqli_stmt_bind_param($stmt_check, "sss", $nickname, $hash , $_SESSION['useraccount']);
    echo "有綁定暱稱、密碼";
}
/*--------------------------------------------------*/

// echo '<pre>';
// print_r($result);
// gettype($result);

echo "<br>";
die("run to here.");


mysqli_stmt_execute($stmt_update);

echo '<script>alert("更新完成")</script>';
echo '<meta http-equiv="refresh" content="0; url=./indext.php">';

?>