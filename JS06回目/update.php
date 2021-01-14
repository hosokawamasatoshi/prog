<?php
//POSTデータ取得
$id       = $_POST["id"];
$u_id   = $_POST["u_id"];
$indate   = $_POST["indate"];
$category = $_POST["category"];
$act      = $_POST["act"];

//DB接続 定型文 PDOを使えるようにするためのコマンド
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = "UPDATE gs_an_table SET u_id=:u_id,indate=:indate,category=:category,act=:act WHERE id=:id";
$stmt = $pdo->prepare($sql);

//bindValue 連携させる
$stmt->bindValue(':u_id',     $u_id,     PDO::PARAM_STR);
$stmt->bindValue(':indate',   $indate,     PDO::PARAM_STR);
$stmt->bindValue(':category', $category,   PDO::PARAM_STR);
$stmt->bindValue(':act',      $act,        PDO::PARAM_STR);
$stmt->bindValue(':id',       $id,         PDO::PARAM_INT); //数値の場合 PARAM_INT
$status = $stmt->execute(); //実行する

//データ登録（実行）後処理
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //index.phpへリダイレクト
  header("Location: user_page.php");
  exit;
}

?>