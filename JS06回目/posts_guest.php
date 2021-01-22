<?php
include("funcs.php");
$pdo = db_connect();

$u_id    = $_SESSION["u_id"]; //自分
$u_name  = $_SESSION["u_name"]; //自分
$r_post_id = $_GET["post_id"]; //コメントする相手のポストid

//テニ活用SQL コメントする相手の情報とテニ活のテーブルを結合
$sql = "SELECT * FROM gs_user_table INNER JOIN gs_an_table ON gs_an_table.u_id = gs_user_table.u_id WHERE post_id = '$r_post_id' ORDER BY indate DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//テニ活表示 編集・削除はidを持って遷移
$view = "";
$result = $stmt->fetch(); //コメントする相手の情報
$view .= '<p id="post"><div id="post_container"><div id="fb1"><img border="0" src="'.$result["u_imgpath"].'" width="auto" height="50px" alt="ユーザー画像"><br>';
$view .= '<span>'.$result["u_name"]."</span></div>";
$view .= '<div id="fb2">'.$result["category"].'　　<span class="small_date">'.date('Y年m月d日 H:i', strtotime($result["indate"]))."</span><br><br>";
$view .= nl2br($result["act"]);
if($result["save_img_name"]){$view .= '<br><br><img border="0" src="'.$result["save_img_name"].'" width="auto" height="200px" alt="テニ活画像">';}
$view .= "<br></div></div></p>";

//リプライ用SQL リプライ情報とユーザー情報のテーブルを結合
$sql2 = "SELECT * FROM gs_reply_table INNER JOIN gs_user_table ON gs_reply_table.u_id = gs_user_table.u_id WHERE r_post_id = '$r_post_id'";
$stmt2 = $pdo->prepare($sql2);
$status2 = $stmt2->execute();

//リプライ表示
  if($status2==false){
    sql_error($stmt2);
  }else{
    while($result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $view2 .= '<p id="post"><div id="post_container"><div id="fb1"><img border="0" src="'.$result2["u_imgpath"].'" width="auto" height="50px" alt="ユーザー画像"><br>';
      $view2 .= '<span>'.$result2["u_name"]."</span></div>";
      $view2 .= '<div id="fb2"><span class="small_date">'.date('Y年m月d日 H:i', strtotime($result2["r_date"]))."</span><br><br>";
      $view2 .= nl2br($result2["r_comment"]);
      $view2 .= "<br></div></div></p>";
    }
  }


?>

<!DOCTYPE html>
<html lang="ja">
<script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <title>投稿ページ</title>
</head>
<body>
<div>
  <?php include("inc/menu_guest_post.html");?>
</div>
<div id="container">
  <div class="posts"><?=$view?></div>
</div>
<div id="container">
  <div class="posts"><?=$view2?></div>
</div>
</body>
</html>