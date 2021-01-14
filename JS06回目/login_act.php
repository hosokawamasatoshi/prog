<?php
session_start();
$lid = $_POST["u_id"];
$lpw = $_POST["u_pw"];

//DB接続します
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = "SELECT * FROM gs_user_table WHERE u_id=:u_id AND u_pw=:u_pw";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $lid);
$stmt->bindValue(':u_pw', $lpw);
$res = $stmt->execute();

//execute(SQL実行時にエラーがある場足)
if($res==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

//抽出データを取得 1レコードのみ
$val = $stmt->fetch();

//該当レコードがあればSESSIONに値を代入 session ID,user ID&Name
if($val["id"] != ""){
  $_SESSION["chk_ssid"] = session_id(); //ユニークなsession_idを付与
  $_SESSION["u_id"] = $val['u_id'];
  $_SESSION["u_name"] = $val['u_name'];

  header("Location: select.php");
}else{
  header("Location: login.php");
}

?>
