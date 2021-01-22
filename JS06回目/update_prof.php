<?php
session_start();
$u_id = $_SESSION["u_id"];

//POSTデータ取得
$u_name         = $_POST["u_name"];
$favorit_player = $_POST["favorit_player"];
$profile        = $_POST["profile"];
//画像関連取得
$file       = $_FILES["img"]; //ファイルデータ受け取り
$img_name   = basename($file["name"]);
$tmp_path   = $file["tmp_name"];
$img_error  = $file["error"];
$img_size   = $file["size"];
$upload_dir = './img/';
$save_img_name = date('YmdHis').$img_name;
echo $u_id.'<br>';
echo $tmp_path.'<br>';
echo $upload_dir.'<br>';
echo $save_img_name.'<br>';

//画像サイズチェック
if($img_size > 1048576 || $img_error == 2){
  echo 'ファイルサイズは１MB未満にしてください。';
}
//拡張子チェック
$allow_ext = array('jpg','jpeg','png');
$file_ext = pathinfo($img_name, PATHINFO_EXTENSION);
if(!in_array(strtolower($file_ext), $allow_ext)){
  echo '画像ファイルを添付してください。';
}
//ファイルはあるか
if(is_uploaded_file("$tmp_path")){
  if(move_uploaded_file($tmp_path, $upload_dir.$save_img_name)){
    echo $img_name.'を'.$upload_dir.'にアップしました。';
  }else{
    echo 'ファイルが保存できませんでした。';
  }
} else {
  echo 'ファイルが選択されていません。';
  echo '<br>';
}

//DB接続
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = "UPDATE gs_user_table SET u_name=:a2,profile=:a3,favorit_player=:a4,u_imgpath=:a5,img_size=:a6 WHERE u_id=:a1";
$stmt = $pdo->prepare($sql);

//bindValue 連携させる
$stmt->bindValue(':a1', $u_id,                      PDO::PARAM_STR);
$stmt->bindValue(':a2', $u_name,                    PDO::PARAM_STR);
$stmt->bindValue(':a3', $profile,                   PDO::PARAM_STR);
$stmt->bindValue(':a4', $favorit_player,            PDO::PARAM_STR);
$stmt->bindValue(':a5', $upload_dir.$save_img_name, PDO::PARAM_STR);
$stmt->bindValue(':a6', $img_size,                  PDO::PARAM_INT);
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