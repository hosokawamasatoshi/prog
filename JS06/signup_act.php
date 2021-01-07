<?php
//入力チェック データが送られてきていないか空の場合はエラー
if(
  !isset($_POST["sid"]) || $_POST["sid"]=="" ||
  !isset($_POST["spw"]) || $_POST["spw"]=="" ||
  !isset($_POST["u_name"]) || $_POST["u_name"]==""
){
  exit("ParamError");
}

session_start();
$sid = $_POST["sid"];
$u_name = $_POST["u_name"];
$spw = $_POST["spw"];
$indate = date("Y-m-d H:i:s");
$life_flg = 1;

//DB接続
try{
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
}catch(PDOException $e){
  exit('データベースに接続できませんでした。' .$e->getMessage());
}

//ユーザー名の重複確認
function u_id_exists($pdo, $u_name){
  $sql = "SELECT COUNT(u_id) FROM gs_user_table WHERE u_id = :u_name";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':u_name', $u_name);
  $stmt->execute();
  $count=$stmt->fetch(PDO::FETCH_ASSOC); //結果を配列で取得
  if($count['count(u_id)']>0){ //件数を取得
    return true;
  }else{
    return false;
  }
}

//データ登録SQL作成
$sql = "INSERT INTO gs_user_table(id,u_name,u_id,u_pw,life_flg,indate)VALUES(NULL,:a1,:a2,:a3,:a4,:a5)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $u_name);
$stmt->bindValue(':a2', $sid);
$stmt->bindValue(':a3', $spw);
$stmt->bindValue(':a4', $life_flg);
$stmt->bindValue(':a5', $indate);
$res = $stmt->execute();

//データ登録（実行）後処理
if($res==false){
  //execute(SQL実行時にエラーがある場足)
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //SESSIONに値を代入して移行
  $_SESSION["chk_ssid"] = session_id(); //ユニークなsession_idを利用
  $_SESSION["u_name"] = $u_name;
  header("Location: select.php");
}
?>