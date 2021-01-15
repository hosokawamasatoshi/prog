<?php
session_start();
$u_id     = $_POST["u_id"];
$u_pw     = $_POST["u_pw"];
$u_name   = $_POST["u_name"];
$life_flg = 1;

//DB接続
include("funcs.php");
$pdo = db_connect();

//入力チェック データが送られてきていないか空の場合はエラー
if(
  !isset($_POST["u_id"]) || $_POST["u_id"]=="" ||
  !isset($_POST["u_pw"]) || $_POST["u_pw"]=="" ||
  !isset($_POST["u_name"]) || $_POST["u_name"]==""
){
  exit("ParamError：未入力の項目があります");
}elseif(
//ID・ユーザーネームの重複確認
  $stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE u_id = :u_id');
  $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
  $status = $stmt->execute();
){
  exit("ParamError：そのID・ユーザーネームはすでに登録されています");
}

//データ登録SQL作成
$sql = "INSERT INTO gs_user_table(id,u_id,u_name,u_pw,sign_date,life_flg)VALUES(NULL,:a1,:a2,:a3,sysdate(),:a4)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $u_id);
$stmt->bindValue(':a2', $u_name);
$stmt->bindValue(':a3', $u_pw);
$stmt->bindValue(':a4', $life_flg);
$res = $stmt->execute();

//データ登録（実行）後処理
if($res==false){
  //execute(SQL実行時にエラーがある場足)
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //SESSIONに値を代入して移行
  $_SESSION["chk_ssid"] = session_id(); //ユニークなsession_idを利用
  $_SESSION["u_id"] = $u_id;
  $_SESSION["u_name"] = $u_name;
  header("Location: select.php");
}
?>