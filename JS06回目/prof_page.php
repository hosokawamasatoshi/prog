<?php
$id = $_GET["id"];

//DB接続 定型文 PDOを使えるようにするためのコマンド
include("funcs.php");
$pdo = db_connect();

$sql = 'SELECT * FROM gs_user_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// $view="";
if($status==false){
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //IDでSELSECTしているの1データのみ該当（ループ不要）
  $row = $stmt->fetch();
}
// var_dump($row);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
  <link rel="stylesheet" href="kadai06.css">
  <title>プロフィール編集</title>
</head>
<header></header>
<body>
<form method="post" action="update_prof.php">
  <div id="act_input">
    <fieldset id="act_fs">
      <label>　　　名前<input type="text" name="u_name" value="<?=$row["u_name"]?>"></label><br>
      <label>　　　画像<input type="file" name="img_content" value="<?=$row["img_content"]?>"></label><br>
      <label>好きな選手<input type="text" name="favorit_player" value="<?=$row["favorit_player"]?>"></label><br>
      <label>　自己紹介<textarea rows="10" cols="60" name="profile"><?=$row["profile"]?></textarea></label><br>
      <input type="hidden" name="id" value="<?=$row["id"]?>">
      <input id="activity_btn" type="submit" value="保存">
    </fieldset>
  </div>
</form>

</body>
</html>