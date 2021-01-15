<?php
include("funcs.php");
$pdo = db_connect();

session_start();
loginCheck(); //セッションチェック 前ページと現在のSESSION_IDを比較
$u_id   = $_SESSION["u_id"];
$u_name = $_SESSION["u_name"]; //グローバルナビに使用

//データ登録SQL作成
$sql = "SELECT * FROM gs_an_table INNER JOIN gs_user_table ON gs_an_table.u_id = gs_user_table.u_id";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
$view = "";
if($status==false){
  //execute(SQL実行時にエラーがある場足)
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループ fetch：一行ずつ取り出す
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p id="post"><div id="post_container">';
    $view .= '<div id="fb1"><a href="user_page_guest_login.php?u_id='.$result["u_id"].'"><img border="0" src="'.$result["u_imgpath"].'" width="auto" height="50px" alt="ユーザー画像"></a><br>';
    $view .= '<a class="font_bold href_font" href="user_page_guest_login.php?u_id='.$result["u_id"].'">'.$result["u_name"]."</a></div>";
    $view .= '<div id="fb2">'.$result["category"].'　　<span class="small_date">'.date('Y年m月d日 H:i', strtotime($result["indate"]))."</span><br><br>";
    $view .= nl2br($result["act"]);
    $view .= '<br></div></div></p>';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>
  <script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
  <title>テニスダイスキ</title>
</head>
<body>
<div>
  <?php include("inc/menu.html");?>
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <div class="slide-img" style="background-image: url('img/tennis_02.jpg');"></div>
      </div>
      <div class="swiper-slide">
        <div class="slide-img" style="background-image: url('img/tennis_03.jpg');"></div>
      </div>
      <div class="swiper-slide">
        <div class="slide-img" style="background-image: url('img/tennis_01.jpg');"></div>
      </div>
    </div>
  </div>
</div>
<div id="container">
  <div class="posts"><?=$view?></div>
</div>
<script type="text/javascript" src="init.js"></script> 
<!-- jsファイルはbodyタグの最下部で読み込ませる -->
</body>
</html>