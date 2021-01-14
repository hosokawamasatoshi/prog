<?php
//GETでidを取得
$id = $_GET["id"];

//DB接続します
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = 'DELETE FROM gs_an_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if($status==false){
  //execute(SQL実行時にエラーがある場足)
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  header("Location: user_page.php");
  exit;
}
?>
