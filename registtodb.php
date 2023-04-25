<?php
// 確認使用者有沒有故意從開發工具那邊故意動手腳
$useraccount = (isset($_POST["useraccount"])) ? trim($_POST["useraccount"]) : null;
$password = (isset($_POST["password"])) ? trim($_POST["password"]) : null;
$passwordoublechk = (isset($_POST["passwordoublechk"])) ? trim($_POST["passwordoublechk"]) : null;
$nickname = (isset($_POST["nickname"])) ? trim($_POST["nickname"]) : null;


// 這邊先確認使用者是否有欄位沒填到資料
// TODO 1這邊我先把判斷式改成這樣子 (雖然這樣子有點長)  2或者，我在加一層if else判斷式
if(($useraccount == "" || $useraccount == null) || ($password == "" || $password == null) || ($passwordoublechk == "" || $passwordoublechk == null) || ($nickname == "" || $nickname == null)){
    
    echo "您似乎有欄位沒填到，請再檢查一下!";
    header("Refresh:2; url=./regist.php");
}
else{
    //再確認使用者密碼有無輸入不一致
    if($password != $passwordoublechk){
        echo "您的密碼似乎有打錯，請再檢查一下!";
        header("Refresh:2; url=./regist.php");
    }
    else{
        //查詢帳號、暱稱是否已經存在(驗到帳號有重複，就要去更改了)
        include("connect.php");
        $sql_check = "SELECT `useraccount`, `nickname`
                        FROM `member` 
                        WHERE `useraccount` = ? OR `nickname` = ?";
        $stmt_check = mysqli_prepare($db, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ss", $useraccount, $nickname);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        //我用mysqli_stmt_get_result()取得我剛剛查詢得到哦東西，會是一列陣列
        //再用mysqli_num_rows()函數，來得知  "重複的筆數"  是幾筆。(你會得到一個整數結果)

        
        if(mysqli_num_rows($result_check) > 0){
            echo '<script>alert("這個帳號或暱稱已經有人註冊了，請重新輸入！")</script>';
            header("Refresh:0; url=./regist.php");
        }
        else{
            //如果帳號沒人註冊過，就執行INSERT INTO語句
            $hash = hash("sha256", $password); // 將密碼做雜湊處理
            $sql_insert = "INSERT INTO `member`(`useraccount`, `password`, `nickname`) VALUES(?, ?, ?)";
            $stmt_insert = mysqli_prepare($db, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "sss", $useraccount, $hash, $nickname);
            mysqli_stmt_execute($stmt_insert);
            echo "<script>alert('您已註冊成功！')</script>";
            header("Refresh:0; url=./login.php");
        }
    }
}
?>
