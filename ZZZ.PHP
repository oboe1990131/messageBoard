<?php
echo PHP_VERSION."<br/>";

// $a = array();
// $b;
$c = "";
$d = null;

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

if($c == $d){
    echo "這是==的if，，，，，，代表在==之下   null等價空字串";
}
else{
    echo "這是==的else";
}

echo "<br/>";

if($c === $d){
    echo "這是===的if";
}
else{
    echo "這是===的else";
}
echo "<br/>";
if(isset($d)){
    echo "空字串有被認為是有放東西進去";
}
else{
    echo "空字串被認為沒放東西進去";
}

echo "<br/>";



exit("程式執行到這邊");
?>








