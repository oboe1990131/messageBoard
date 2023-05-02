<?php
echo PHP_VERSION."<br/>";

// $a = array();
// $b;
// $c = "";
// $d = null;

// if(is_null($a === null)){
//     echo "123"."<br/>";
// }
// else{
//     echo "456789"."<br/>";
// }
//////////////////////////////////







// var_dump(isset($d) );
// echo "<br/>";
// var_dump(empty($d) );
// echo "<br/>";
// var_dump(is_null($d) );
// echo "<br/>";
// var_dump($c == $d);
// echo "<br/>";
// 從這邊就可以看到：空字串 & null 被當成相同的東西了，所以，你那邊的判斷式才成立，否則，定義上，他們根本不是同一個事物。
//////////////////////////////////








// header("Refresh: 0.5; url=login.php");
// echo "将在3秒钟之后跳转到新页面...";
//////////////////////////////////







// $a = 1;
// $b = "1";

// if($c == $d){
//     echo "這是==的if，，，，，，代表在==之下   null等價空字串";
// }
// else{
//     echo "這是==的else";
// }

// echo "<br/>";

// if($c === $d){
//     echo "這是===的if";
// }
// else{
//     echo "這是===的else";
// }
// echo "<br/>";
// if(isset($d)){
//     echo "空字串有被認為是有放東西進去";
// }
// else{
//     echo "空字串被認為沒放東西進去";
// }

// echo "<br/>";

// exit("程式執行到這邊");
//////////////////////////////////









//                  編輯頁面那邊抓過來試著印出來，    少了第一筆資料
// include ("connect.php");
// $id = 159;
// $sql = "SELECT u.`id`, u.`message`, u.`auther_id`, u.`mood`
//         FROM `usermessage` AS u
//         LEFT JOIN `member` AS m ON u.`auther_id` = m.`member_id`
//         WHERE (u.`id`= '159') AND (`auther_id` = '1')";
// $result = mysqli_query($db, $sql) ?? die("insert error");  //去資料庫幫我拉出那個我要編輯的資料
// $row = mysqli_fetch_array($result, MYSQLI_ASSOC); //幫我把抓到的陣列資料轉成非陣列，可以顯示出來之資料型別


// if(mysqli_num_rows($result) == 0){
//     echo '<script>alert("你編輯錯留言了!")</script>';
//     header("Refresh:0; url=./login.php");
//     exit;
// }
// else{
//     //把留言頁面送出之  id & 留言內容  放進變數裡面 (查gpt查到的另一種方法，可將特殊字符替換)
//     $id = mysqli_real_escape_string($db, $id);
// }


// echo '<pre>';
// print_r($row);
// echo "<br>";
// die("run to here.");





//                    查詢心情table試印         ，這個是參照gpt的建議  (後來還是沒有用)
// include ("connect.php");
// $select_sql = "SELECT `id`, `mood`, `mood_id`
//                 FROM `emotion`";
// $stmt = mysqli_prepare($db, $select_sql);
// mysqli_stmt_execute($stmt);
// $result = mysqli_stmt_get_result($stmt);
// while($row = mysqli_fetch_array($result)){
// 	echo $row["id"];
// 	echo $row["mood"];
// 	echo $row["mood_id"];
// }
// $select_result = mysqli_query($db, $select_sql);
// $emotion = mysqli_fetch_array($select_result, MYSQLI_ASSOC);


// echo '<pre>';
// print_r($emotion);
// echo "<br>"."上面是一般print_r"."111111"."下面是while迴圈的"."<br>";


// while($emotion = mysqli_fetch_array($select_result, MYSQLI_ASSOC)){
// 	print_r($emotion);
// 	// $emotion = mysqli_fetch_array($select_result, MYSQLI_ASSOC);
// }
// echo "<br>"."上面是while迴圈"."222222"."下面是再印一次print_r"."<br>";
// echo '<pre>';
// print_r($emotion);
// echo "<br>";
// die("run to here.");








// 這個部分是             首頁那邊抓過來試印出來看看
// $sql = "SELECT u.`id`, m.`nickname`, u.`message`, u.`auther_id`, m.`member_id`, u.`mood`, e.`id` AS emotion_id, e.`mood`
//         FROM `usermessage` AS u
//         LEFT JOIN `member` AS m ON u.`auther_id` = m.`member_id`
//         LEFT JOIN `emotion` AS e ON u.`mood` = e.`id`";

// $stmt_find = mysqli_prepare($db, $sql);
// mysqli_stmt_execute($stmt_find);
// $result_find = mysqli_stmt_get_result($stmt_find);

// while($row = mysqli_fetch_array($result_find)):
// 	echo $row["id"];
// 	echo htmlspecialchars($row["nickname"]);
// 	echo $row["message"];
// 	echo $row["mood"];
// 	die;
// 	endwhile














// // 這部分是採用foreach的方法去嘗試
// $select_sql = "SELECT `id`, `mood`, `mood_id`
//                 FROM `emotion`";
// $select_result = mysqli_query($db, $select_sql);
// $emotion = mysqli_fetch_all($select_result, MYSQLI_ASSOC);


// echo "一般print_r"."<br>";
// echo '<pre>';
// print_r($emotion);
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";



// echo "foreach印出的效果"."<br>";
// foreach($emotion as $key => $val){
// 	echo "我的key值直接被印出來了，如右邊".$key."<br>";
// 	echo "我的val值直接被印出來了，如右邊".$val."<br>";
// }
// // while($emotion = mysqli_fetch_array($select_result, MYSQLI_ASSOC)){
// // 	print_r($emotion);
// 	// $emotion = mysqli_fetch_array($select_result, MYSQLI_ASSOC);
// // }
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";


// // gpt教我雙層迴圈要怎麼印出來
// foreach($emotion as $key1 => $val1){
// 	// 就是第一層的那個$val繼續當key
//     foreach($val1 as $key2 => $val2){
//         echo "第一層的 key: " . $key1 . "<br>";
//         echo "第二層的 key: " . $key2 . "<br>";
//         echo "第二層的 value: " . $val2 . "<br>";
//     }
// }

// TODO後面再來研究那是甚麼問題造成 我的資料庫資料都會漏掉第一筆資料















// $sql_update = "UPDATE `member`";


// /*--------------------------------------------------*/
// $where_nickname = (($nickname !== "") && ($password === "")) ? " SET `nickname` = ? WHERE `useraccount` = ?" : "";

// $where_password = (($nickname === "") && ($password !== "")) ? " SET `password` = ? WHERE `useraccount` = ?" : "";

// $where_nickname_password = (($nickname !== "") && ($password !== "")) ? " SET `nickname` = ?, `password` = ? WHERE `useraccount` = ?" : "";

// $sql_update .= $where_nickname.$where_password.$where_nickname_password;
// /*--------------------------------------------------*/


// $stmt_update = mysqli_prepare($db, $sql_update);




// /*--------------------------------------------------*/
// // TODO 2判別式裡面的括號多打了，  刪掉
// if(($nickname !== "") && ($password === "")){
//     // 如果是想改暱稱，這樣綁定
//     mysqli_stmt_bind_param($stmt_update, "ss", $nickname, $_SESSION['useraccount']);
// }

// if(($nickname === "") && ($password !== "")){
//     // 如果是想改密碼，這樣綁定
//     $hash = hash("sha256", $password);
//     mysqli_stmt_bind_param($stmt_update, "ss", $hash , $_SESSION['useraccount']);
// }

// if(($nickname !== "") && ($password !== "")){
//     // 如果想改暱稱、密碼，這樣綁定
//     $hash = hash("sha256", $password);
//     mysqli_stmt_bind_param($stmt_update, "sss", $nickname, $hash , $_SESSION['useraccount']);
// }
// /*--------------------------------------------------*/



// mysqli_stmt_execute($stmt_update);

// die("run to here");















// $password = (isset($_POST['password'])) ? $_POST['password'] : null;
// $passwordoublechk = (isset($_POST['passwordoublechk'])) ? $_POST['passwordoublechk'] : null;
// $nickname = (isset($_POST['nickname'])) ? $_POST['nickname'] : null;



// include("connect.php");

// // 準備 SQL 查詢
// $sql_check = "SELECT `useraccount`, `password`, `nickname` FROM `member`";
// $where_clauses = [];

// // 如果想查詢暱稱有無重複，就加這句
// if ($nickname !== "" && empty($password)) {
//     $where_clauses[] = " `nickname` = ? AND `useraccount` != ?";
// }

// // 如果想查詢密碼有無跟舊的一樣，就加這句
// if (empty($nickname) && !empty($password)) {
//     $where_clauses[] = " `useraccount` = ? AND `password` = ?";
// }

// // 如果想查暱稱、密碼，就加這句，但這樣會有個問題：暱稱重複會被攔下來、密碼重複也會被攔下來
// if (!empty($nickname) && !empty($password)) {
//     $where_clauses[] = " (`useraccount` = ? AND `password` = ?) OR (`nickname` = ? AND `useraccount` != ?)";
// }

// if (!empty($where_clauses)) {
//     $sql_check .= " WHERE" . implode(" OR", $where_clauses);
// }

// // 準備查詢的參數
// $params = [];
// if (!empty($nickname) && empty($password)) {
//     // 如果是想查詢暱稱有無重複，這樣綁定
//     $params[] = $nickname;
//     $params[] = $_SESSION['useraccount'];
// } elseif (empty($nickname) && !empty($password)) {
//     // 如果是想查詢密碼有無重複舊的，這樣綁定
//     $hash = hash("sha256", $password);
//     $params[] = $_SESSION['useraccount'];
//     $params[] = $hash;
// } elseif (!empty($nickname) && !empty($password)) {
//     // 如果想查詢暱稱有無重複、密碼有無重複舊的，這樣綁定
//     $hash = hash("sha256", $password);
//     $params[] = $_SESSION['useraccount'];
//     $params[] = $hash;
//     $params[] = $nickname;
//     $params[] = $_SESSION['useraccount'];
// }

// // 執行查詢
// $stmt_check = mysqli_prepare($db, $sql_check);
// mysqli_stmt_bind_param($stmt_check, str_repeat("s", count($params)), ...$params);
// mysqli_stmt_execute($stmt_check);
// $result_check = mysqli_stmt_get_result($stmt_check);
// $result_check_content = mysqli_fetch_array($result_check);



// die("run to here");

$password = "testuser20";
$hash = hash("sha256", $password);
echo $hash;
?>

