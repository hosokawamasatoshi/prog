<?php
include("funcs.php");
$pdo = db_connect();

//データ登録SQL作成 テーブル結合
$sql = "SELECT * FROM gs_an_table INNER JOIN gs_user_table ON gs_an_table.u_id = gs_user_table.u_id ORDER BY indate DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
$view = "";
if($status==false){
  sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループ fetch：一行ずつ取り出す
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p  id="post"><div id="post_container">';
    $view .= '<div id="fb1"><a href="user_page_guest.php?u_id='.$result["u_id"].'"><img border="0" src="'.$result["u_imgpath"].'" width="auto" height="50px" alt="ユーザー画像"></a><br>';
    $view .= '<a class="href_font" href="user_page_guest.php?u_id='.$result["u_id"].'">'.$result["u_name"]."</a></div>";
    $view .= '<div id="fb2"><a id="category_block">'.$result["category"].'</a><a class="small_date">'.date('Y年m月d日 H:i', strtotime($result["indate"]))."</a>";
    $view .= '<div class="float_right"><i class="far fa-heart like"> '.$result["like_num"].'</i>';
    $view .= '<a href="posts_guest.php?post_id='.$result["post_id"].'"><i class="far fa-comment comment"> '.$result["comment_num"].'</i></a></div><br><br>';
    $view .= '<a class="act_text" href="posts_guest.php?post_id='.$result["post_id"].'">'.nl2br($result["act"]).'</a>';
    if($result["save_img_name"]){$view .= '<br><br><img border="0" src="'.$result["save_img_name"].'" width="auto" height="200px" alt="テニ活画像">';}
    $view .= '</div></div></p>';
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
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <title>テニスダイスキ</title>
</head>
<body>
  <div>
    <?php include("inc/menu_guest.html");?>
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