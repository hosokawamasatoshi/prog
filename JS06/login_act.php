<?php
session_start();
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

//DB接続します
try{
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
}catch(PDOException $e){
  exit('データベースに接続できませんでした。' .$e->getMessage());
}

//データ登録SQL作成
$sql = "SELECT * FROM gs_user_table WHERE u_id=:lid AND u_pw=:lpw";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$res = $stmt->execute();

//execute(SQL実行時にエラーがある場足)
if($res==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

//抽出データを取得 1レコードのみ
$val = $stmt->fetch();

//該当レコードがあればSESSIONに値を代入
if($val["id"] != ""){
  $_SESSION["chk_ssid"] = session_id(); //ユニークなsession_idを利用
  $_SESSION["u_name"] = $val['u_name'];
  header("Location: select.php");
}else{
  header("Location: login.php");
}

?>
