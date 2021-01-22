<?php
session_start();
$u_id = $_SESSION["u_id"];

//POSTデータ取得
$r_post_id = $_POST["r_post_id"];
$r_comment = $_POST["r_comment"];

echo $u_id.'<br>';
echo $r_post_id.'<br>';
echo $r_comment.'<br>';

//DB接続 定型文 PDOを使えるようにするためのコマンド
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = "INSERT INTO gs_reply_table(reply_id,u_id,r_post_id,r_date,r_comment) VALUES (NULL,:a1,:a2,sysdate(),:a3)";
$stmt = $pdo->prepare($sql);
//bindValue 連携させる
$stmt->bindValue(':a1', $u_id,      PDO::PARAM_STR);
$stmt->bindValue(':a2', $r_post_id, PDO::PARAM_INT);
$stmt->bindValue(':a3', $r_comment, PDO::PARAM_STR);
$status = $stmt->execute();

//コメント数を１増加
$sql2 = "UPDATE gs_an_table SET comment_num = comment_num + 1 WHERE post_id = $r_post_id;";
$stmt2 = $pdo->prepare($sql2);
$status2 = $stmt2->execute();

//データ登録（実行）後処理
if($status==false || $status2==false){
  //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //act.phpへリダイレクト
  header("Location: posts.php?post_id=$r_post_id");
  exit;
}
?>