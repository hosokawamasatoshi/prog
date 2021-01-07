<?php
//入力チェック データが送られてきていないか空の場合はエラー
if(
  !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["indate"]) || $_POST["indate"]=="" ||
  !isset($_POST["category"]) || $_POST["category"]=="" ||
  !isset($_POST["act"]) || $_POST["act"]==""
){
  exit("ParamError");
}

//POSTデータ取得
$name = $_POST["name"];
$indate = $_POST["indate"];
$category = $_POST["category"];
$act = $_POST["act"];

echo $name;

//DB接続 定型文 PDOを使えるようにするためのコマンド
try{
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
}catch(PDOException $e){
  exit('DbConnectError:' .$e->getMessage());
};

//データ登録SQL作成
$sql = "INSERT INTO gs_an_table(id,name,indate,category,act)
VALUES(NULL, :a1, :a2, :a3, :a4)";

$stmt = $pdo->prepare($sql);

//bindValue 連携させる
$stmt->bindValue(':a1', $name, PDO::PARAM_STR); //数値の場合 PARAM_INT
$stmt->bindValue(':a2', $indate, PDO::PARAM_STR);
$stmt->bindValue(':a3', $category, PDO::PARAM_STR);
$stmt->bindValue(':a4', $act, PDO::PARAM_STR);
$status = $stmt->execute(); //実行する

//データ登録（実行）後処理
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //act.phpへリダイレクト
  header("Location: activity.php");
  exit;
}
?>