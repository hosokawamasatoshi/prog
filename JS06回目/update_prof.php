<?php
//POSTデータ取得
$id             = $_POST["id"];
$u_name         = $_POST["u_name"];
$favorit_player = $_POST["favorit_player"];
$profile        = $_POST["profile"];

//DB接続 
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = "UPDATE gs_user_table SET u_name=:u_name,favorit_player=:favorit_player,profile=:profile WHERE id=:id";
$stmt = $pdo->prepare($sql);

//bindValue 連携させる
$stmt->bindValue(':id',             $id,             PDO::PARAM_INT); //数値の場合 PARAM_INT
$stmt->bindValue(':u_name',         $u_name,         PDO::PARAM_STR);
$stmt->bindValue(':favorit_player', $favorit_player, PDO::PARAM_STR);
$stmt->bindValue(':profile',        $profile,        PDO::PARAM_STR);
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