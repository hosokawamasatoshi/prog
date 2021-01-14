<?php
//DB接続 定型文 PDOを使えるようにするためのコマンド
include("funcs.php");
$pdo = db_connect();

session_start();
loginCheck(); //セッションチェック 前ページと現在のSESSION_IDを比較
$u_id   = $_SESSION["u_id"];
$u_name = $_SESSION["u_name"];

$id = $_GET["id"];

// $sql = 'SELECT * FROM gs_an_table INNER JOIN gs_user_table ON gs_an_table.u_id = gs_user_table.u_id WHERE gs_an_table.id=:id ORDER BY indate DESC';
$sql = 'SELECT * FROM gs_an_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //IDでSELSECTしているの1データのみ該当（ループ不要）
  $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
  <title>テニスダイスキ</title>
</head>
<header></header>
<body>
<form method="post" action="update.php">
  <div id="act_input">
    <fieldset id="act_fs">
      <label><input id="act_date" type="text" name="indate" value="<?=$row["indate"]?>"></label><br>
      <div class="radio_wrap">
        <label><input type="radio" name="category" value="練習" 
          <?php if(!empty($row['category'])&&$row['category']==="練習"){echo 'checked';}?>>練習</label>
        <label><input type="radio" name="category" value="試合" 
          <?php if(!empty($row['category'])&&$row['category']==="試合"){echo 'checked';}?>>試合</label>
        <label><input type="radio" name="category" value="その他" 
          <?php if(!empty($row['category'])&&$row['category']==="その他"){echo 'checked';}?>>その他</label>
      </div>
      <!-- <label><input type="text" name="category" value="<?=$row["category"]?>"></label><br> -->
      <label><textarea rows="10" cols="60" name="act"><?=$row["act"]?></textarea></label><br>
      <input type="hidden" name="id" value="<?=$id?>">
      <input type="hidden" name="u_id" value="<?=$u_id?>">
      <input id="activity_btn" type="submit" value="保存">
    </fieldset>
  </div>
</form>

</body>
</html>