<?php
session_start();
if(!isset($_SESSION["useraccount"])){
    echo '<script>alert("請循正規管道登入。")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    die;
}

// 確認使用者有無在開發者工具那邊把密碼欄位刪掉
$password = (isset($_POST["password"])) ? $_POST["password"] : null;
$passwordoublechk = (isset($_POST["passwordoublechk"])) ? $_POST["passwordoublechk"] : null;

// 看使用者的密碼欄位是否為空
if($password == "" || $passwordoublechk == ""){
    echo '<script>alert("您似乎有欄位沒填到，請再檢查一下！")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
}
else{
    //看使用者兩次輸入的密碼是否一樣
    if($password != $passwordoublechk){
        echo '<script>alert("您兩個密碼似乎不同，請再檢查一下！")</script>';
        echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
    }
    else{
        // 把使用者輸入的密碼雜湊
        $hash = hash("sha256", $password); // 將密碼做雜湊處理
        
        //查詢密碼是否與舊的一樣
        include("connect.php");
        $sql_check = "SELECT * FROM `member` WHERE `useraccount` = ? AND `password` = ?";
        $stmt_check = mysqli_prepare($db, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ss", $_SESSION["useraccount"], $hash);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        //我用mysqli_stmt_get_result()取得我剛剛查詢得到哦東西，會是一列陣列
        //再用mysqli_num_rows()函數，來得知  "重複的筆數"  是幾筆。(你會得到一個整數結果)

        // 看使用者輸入的密碼是否與舊的一樣
        if(mysqli_num_rows($result_check) != 0){
            echo '<script>alert("新密碼不能與舊密碼相同，請重新輸入！")</script>';
            echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
        }
        else{
            //如果密碼沒有相同，就執行INSERT INTO語句，更新會員資料
            $sql = "UPDATE `member` SET `password` = ? WHERE `useraccount` = ?";
            $stmt = mysqli_prepare($db, $sql);            
            mysqli_stmt_bind_param($stmt, "ss", $hash, $_SESSION["useraccount"]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo '<script>alert("密碼更新成功！")</script>';
            echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
        }
    }
}
?>