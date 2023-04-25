<?php

// 用if...elseif...系列去分類




session_start();
if(!isset($_SESSION["useraccount"])){
    echo '<script>alert("請循正規管道登入。")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./login.php">';
    die;
}


$password = (isset($_POST['password'])) ? $_POST['password'] : null;
$passwordoublechk = (isset($_POST['passwordoublechk'])) ? $_POST['passwordoublechk'] : null;
$nickname = (isset($_POST['nickname'])) ? $_POST['nickname'] : null;






// 看密碼欄位是否有被拔掉
if($password === null || $passwordoublechk === null || $nickname === null){
    echo '<script>alert("您似乎有欄位沒填到，請再檢查一下！")</script>';
    echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
}








// 使用者的密碼欄位為空，代表使用者             """"""""只想單獨改暱稱"""""""""


elseif(($password === "" || $passwordoublechk === "") && ($nickname !== "")){

    // 我就看使用者輸入的暱稱是否有跟別人重複，那這邊的邏輯根本就是registtodb那邊的邏輯
    include("connect.php");
    $sql_check = "SELECT `nickname`
                    FROM `member` 
                    WHERE `nickname` = ?";
    $stmt_check = mysqli_prepare($db, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $nickname);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    //我用mysqli_stmt_get_result()取得我剛剛查詢得到哦東西，會是一列陣列
    //再用mysqli_num_rows()函數，來得知  "重複的筆數"  是幾筆。(你會得到一個整數結果)

    if(mysqli_num_rows($result_check) > 0){
        echo '<script>alert("這個暱稱已經有人註冊了，請重新輸入！")</script>';
        echo '<meta http-equiv="refresh" content="0; url=./regist.php">';
    }
    else{
        // 我就幫使用者把他輸入的暱稱更新進資料庫裏面
        $sql_insert = "UPDATE `member` SET `nickname` = ? WHERE `member_id` = ?";
        $stmt_insert = mysqli_prepare($db, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "si", $nickname, $_SESSION['member_id']);
        mysqli_stmt_execute($stmt_insert);
        echo "<script>";
        echo "alert('您已成功更改暱稱')";
        echo "</script>";
        echo '<meta http-equiv="refresh" content="0; url=./indext.php">';
    }
}








// 使用者只想單獨改密碼
elseif(($password !== "" && $passwordoublechk !== "") && ($nickname === "")){

    // 看兩次輸入的密碼是否一樣
    if($password != $passwordoublechk){
        echo '<script>alert("你兩次輸入的密碼不一樣")</script>';
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
        
        if(mysqli_num_rows($result_check) != 0){
            echo '<script>alert("新密碼不能與舊密碼相同，請重新輸入！")</script>';
            echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
        }
        else{
            //執行INSERT INTO語句，更新會員資料
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










// 使用者想改密碼、暱稱
elseif(($password !== "" && $passwordoublechk !== "") && ($nickname !== "")){
    
    // 看兩次輸入的密碼是否一樣
    if($password != $passwordoublechk){
        echo '<script>alert("你兩次輸入的密碼不一樣")</script>';
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
        
        if(mysqli_num_rows($result_check) != 0){
            echo '<script>alert("新密碼不能與舊密碼相同，請重新輸入！")</script>';
            echo '<meta http-equiv="refresh" content="0; url=./membercenter.php">';
        }
        else{
            // 查詢使用者的暱稱是否有重複
            include("connect.php");
            $sql_check = "SELECT `nickname`
                            FROM `member` 
                            WHERE `nickname` = ?";
            $stmt_check = mysqli_prepare($db, $sql_check);
            mysqli_stmt_bind_param($stmt_check, "s", $nickname);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);

            
            //執行INSERT INTO語句，更新會員資料
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