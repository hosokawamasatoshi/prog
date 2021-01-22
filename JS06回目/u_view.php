<?php
//DB接続 定型文 PDOを使えるようにするためのコマンド
include("funcs.php");
$pdo = db_connect();

session_start();
loginCheck(); //セッションチェック 前ページと現在のSESSION_IDを比較
$u_id   = $_SESSION["u_id"];
$u_name = $_SESSION["u_name"];

$post_id = $_GET["post_id"]; //全ページからの受け取り

$sql = 'SELECT * FROM gs_an_table WHERE post_id=:post_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
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
<body>
<form method="post" action="update.php" enctype="multipart/form-data">
  <div id="act_input">
    <div class="act_wrap">
      <div class="flex_wrap">
        <div><input id="act_date" type="text" name="indate" value="<?=$row["indate"]?>"></div><br>
        <div class="radio_wrap">
          <label><input type="radio" name="category" value="練習" 
            <?php if(!empty($row['category'])&&$row['category']==="練習"){echo 'checked';}?>>練習</label>
          <label><input type="radio" name="category" value="試合" 
            <?php if(!empty($row['category'])&&$row['category']==="試合"){echo 'checked';}?>>試合</label>
          <label><input type="radio" name="category" value="その他" 
            <?php if(!empty($row['category'])&&$row['category']==="その他"){echo 'checked';}?>>その他</label>
        </div>
      </div>
      <textarea rows="10" name="act"><?=$row["act"]?></textarea><br>
      <label id="prof_label"><input type="file" name="image" accept="image/*"></label>
      <input type="hidden" name="post_id" value="<?=$post_id?>">
      <input type="hidden" name="u_id" value="<?=$u_id?>">
      <input type="hidden" name="save_img_name" value="<?=$row["save_img_name"]?>">
      <input id="activity_btn" type="submit" value="保存">
    </div>
  </div>
</form>

</body>
</html>