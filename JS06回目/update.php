<?php
//POSTデータ取得
$post_id       = $_POST["post_id"];
$u_id          = $_POST["u_id"];
$indate        = $_POST["indate"];
$category      = $_POST["category"];
$act           = $_POST["act"];

//画像関連取得
$file          = $_FILES["image"]; //ファイルデータ受け取り
$img_name      = basename($file["name"]);
$tmp_path      = $file["tmp_name"];
$img_error     = $file["error"];
$img_size      = $file["size"];
$upload_dir    = './img/';

//画像のあるなしで分岐
if(is_uploaded_file($file["tmp_name"])){     //a.アップロードあり
  $save_img_name = $upload_dir.date('YmdHis').$img_name;
  echo 'echo a<br>';
}else if($_POST["save_img_name"]){           //b.元々画像ありアップロードなし
  $save_img_name = $_POST["save_img_name"];
  echo 'echo b<br>';
}else{                                       //c.元々画像なしアップロードなし
  $save_img_name = "";
  echo 'echo c<br>';
}

//画像サイズチェック
if($img_size > 1048576 || $img_error == 2){
  echo 'ファイルサイズは１MB未満にしてください。';
}
//拡張子チェック
$allow_ext = array('jpg','jpeg','png');
$file_ext  = pathinfo($img_name, PATHINFO_EXTENSION);
if(!in_array(strtolower($file_ext), $allow_ext)){
  echo '画像ファイルを添付してください。';
}
//ファイルはあるか
if(is_uploaded_file("$tmp_path")){
  if(move_uploaded_file($tmp_path, $save_img_name)){
    echo $img_name.'を'.$upload_dir.'にアップしました。';
  }else{
    echo 'ファイルが保存できませんでした。';
  }
} else {
  echo 'ファイルが選択されていません。<br>';
}

//DB接続 定型文 PDOを使えるようにするためのコマンド
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成
$sql = "UPDATE gs_an_table SET u_id=:u_id,indate=:indate,category=:category,act=:act,save_img_name=:save_img_name WHERE post_id=:post_id";
$stmt = $pdo->prepare($sql);

//bindValue 連携させる
$stmt->bindValue(':post_id',       $post_id,       PDO::PARAM_INT); //数値の場合 PARAM_INT
$stmt->bindValue(':u_id',          $u_id,          PDO::PARAM_STR);
$stmt->bindValue(':indate',        $indate,        PDO::PARAM_STR);
$stmt->bindValue(':category',      $category,      PDO::PARAM_STR);
$stmt->bindValue(':act',           $act,           PDO::PARAM_STR);
$stmt->bindValue(':save_img_name', $save_img_name, PDO::PARAM_STR);
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