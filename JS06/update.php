<?php
//POSTデータ取得
$id = $_POST["id"];
$name = $_POST["name"];
$indate = $_POST["indate"];
$category = $_POST["category"];
$post = $_POST["post"];

//DB接続 定型文 PDOを使えるようにするためのコマンド
try{
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
}catch(PDOException $e){
  exit('DbConnectError:' .$e->getMessage());
};

//データ登録SQL作成
$sql = "UPDATE gs_an_table SET name=:name,indate=:indate,category=:category,post=:post WHERE id=:id";

$stmt = $pdo->prepare($sql);

//bindValue 連携させる
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //数値の場合 PARAM_INT
$stmt->bindValue(':indate', $indate, PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);
$stmt->bindValue(':post', $post, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行する

//データ登録（実行）後処理
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //index.phpへリダイレクト
  header("Location: select.php");
  exit;
}

?>