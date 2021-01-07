<?php
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY indate DESC");
$status = $stmt->execute();

//データ表示
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
    $view .= $result["indate"]."　　".$result["category"]."<br>";
    $view .= $result["act"]."";
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
  <div  class="background_all hero_bg">
    <?php include("inc/menu_p.html");?>
    <h1>テニスダイスキ</h1>
  </div>
  <div id="container">
    <div class="posts"><?=$view?></div>
  </div>
</body>
</html>