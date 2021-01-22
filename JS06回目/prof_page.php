<?php
session_start();
$u_id = $_SESSION["u_id"];

//DB接続
include("funcs.php");
$pdo = db_connect();

$sql = 'SELECT * FROM gs_user_table WHERE u_id=:a1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $u_id, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //IDでSELSECTしているの1データのみ該当
  $row = $stmt->fetch();
}
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
<form method="POST" action="update_prof.php" enctype="multipart/form-data">
  <div id="act_input">
    <div class="act_wrap">
      <label id="prof_label">　　　名前<input type="text" name="u_name" value="<?=$row["u_name"]?>"></label>
      <label id="prof_label">　　　画像<input type="file" name="img" accept="image/*" value="<?=$row["u_imgpath"]?>"></label>
      <label id="prof_label">好きな選手<input type="text" name="favorit_player" value="<?=$row["favorit_player"]?>"></label>
      <label id="prof_label">　自己紹介<textarea rows="10" cols="60" name="profile"><?=$row["profile"]?></textarea></label>
      <input id="activity_btn" type="submit" value="保存">
    </div>
  </div>
</form>
</body>
</html>