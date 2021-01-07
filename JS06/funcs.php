<?php
//関数
function h($str){
  $s = htmlspecialchars($str, ENT_QUOTES);
  return $s;
}

//LOGIN認証チェック関数
function loginCheck(){
  if( !isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    echo("LOGIN Error!");
    exit;
  }else{
    session_regenerate_id(ture); //セッションハイジャック対策
    $_SESSION["chk_ssid"] = session_id(); //古いキーを更新
  }
}

//DB接続
function db_connect(){
  try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
  }catch(PDOException $e){
    exit('データベースに接続できませんでした。' .$e->getMessage());
  }
  return $pdo;
}

?>