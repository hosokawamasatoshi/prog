<?php
session_start();
$u_id = $_SESSION["u_id"];

//入力チェック データが送られてきていないか空の場合はエラー
if(
  // !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["indate"]) || $_POST["indate"]=="" ||
  !isset($_POST["category"]) || $_POST["category"]=="" ||
  !isset($_POST["act"]) || $_POST["act"]==""
){
  exit("ParamError");
}

//POSTデータ取得
// $name = $_POST["name"];
$indate   = $_POST["indate"];
$category = $_POST["category"];
$act      = $_POST["act"];
//画像関連取得
$file       = $_FILES["image"]; //ファイルデータ受け取り
$img_name   = basename($file["name"]);
$tmp_path   = $file["tmp_name"];
echo '$tmp_path '.$tmp_path;
$img_error  = $file["error"];
$img_size   = $file["size"];
$upload_dir = './img/';
$save_img_name = $upload_dir.date('YmdHis').$img_name;
echo '$file: '.$file.'<br>';
echo '$act: '.$act.'<br>';
echo '$tmp_name: '.$img_name.'<br>';
echo '$tmp_path: '.$tmp_path.'<br>';
echo '$upload_dir: '.$upload_dir.'<br>';
echo '$save_img_name: '.$save_img_name.'<br>';

//画像サイズチェック
if($img_size > 1048576 || $img_error == 2){
  echo 'ファイルサイズは１MB未満にしてください。<br>';
}
//拡張子チェック
$allow_ext = array('jpg','jpeg','png');
$file_ext  = pathinfo($img_name, PATHINFO_EXTENSION);
if(!in_array(strtolower($file_ext), $allow_ext)){
  echo '画像ファイル（jpg・jpeg・png）を添付してください。<br>';
}
//ファイルはあるか
if(is_uploaded_file("$tmp_path")){
  if(move_uploaded_file($tmp_path, $save_img_name)){
    echo $img_name.'を'.$upload_dir.'にアップしました。<br>';
  }else{
    echo 'ファイルが保存できませんでした。<br>';
  }
} else {
  echo 'ファイルが選択されていません。<br>';
  $save_img_name = "";
  echo '$save_img_name: '.$save_img_name;
}

//DB接続 定型文 PDOを使えるようにするためのコマンド
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = "INSERT INTO gs_an_table(post_id,u_id,indate,category,act,save_img_name)VALUES(NULL,:a1,:a2,:a3,:a4,:a5)";
$stmt = $pdo->prepare($sql);

//bindValue 連携させる
$stmt->bindValue(':a1', $u_id,          PDO::PARAM_STR); //数値の場合 PARAM_INT
$stmt->bindValue(':a2', $indate,        PDO::PARAM_STR);
$stmt->bindValue(':a3', $category,      PDO::PARAM_STR);
$stmt->bindValue(':a4', $act,           PDO::PARAM_STR);
$stmt->bindValue(':a5', $save_img_name, PDO::PARAM_STR);
$status = $stmt->execute(); //実行する

//データ登録（実行）後処理
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //act.phpへリダイレクト
  header("Location: select.php");
  exit;
}
?>