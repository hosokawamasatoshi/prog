<?php
session_start();
include("funcs.php");
loginCheck();//セッションチェック 前ページと現在のSESSION_IDを比較
$pdo = db_connect();
$u_name = $_SESSION["u_name"];

//ユーザーのテニ活のみ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE name = '$u_name' ORDER BY indate DESC");
$status = $stmt->execute();

//ユーザー情報取得SQL作成
$stmt2 = $pdo->prepare("SELECT * FROM gs_user_table WHERE u_name = '$u_name'");
$status2 = $stmt2->execute();

//データ表示 ユーザー情報
$user = "";
//Selectデータの数だけ自動でループ fetch：一行ずつ取り出す
while($result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
  $user .= '<img border="0" src="/img/t_woman1.png" width="100" height="100" alt="ユーザー画像">';
  $user .= "<a>".$result2["u_name"]."</a>";
  $user .= '<table id="user_info">';
  $user .= "<tr><th>登録日</th><td>".$result2["indate"]."</td></tr>";
  $user .= "<tr><th>プロフィール</th><td>".$result2["profile"]."</td></tr>";
  $user .= "</table>";
}

//データ表示 テニ活
$view = "";
if($status==false){
  //execute(SQL実行時にエラーがある場足)
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループ fetch：一行ずつ取り出す
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>";
    $view .= $result["name"]."<br>";
    $view .= $result["indate"]."　　".$result["category"];
    $view .= '　　'.'<a href="delete.php?id='.$result["id"].'">'.'[削除]</a>'."<br>";
    $view .= $result["act"];
    $view .= "</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <title>表示</title>
</head>
<body>
<header></header>
<?php include("inc/menu_myp.html");?>
<div id="container">
  <div class="posts"><?=$user?></div>
</div>
<div id="container">
  <div class="posts"><?=$view?></div>
</div>
</body>
</html>