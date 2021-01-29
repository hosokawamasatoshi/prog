<?php
include("funcs.php");
$pdo = db_connect();

$u_id = $_GET["u_id"];

//ユーザー情報とテニ活のテーブルを結合
$sql = "SELECT * FROM gs_user_table INNER JOIN gs_an_table ON gs_an_table.u_id = gs_user_table.u_id WHERE gs_an_table.u_id = '$u_id' ORDER BY indate DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//統計データ（月次）
$sql3 = "SELECT category as category, COUNT(*) as count FROM gs_an_table WHERE u_id='$u_id' AND DATE_FORMAT(indate, '%Y%m') = DATE_FORMAT(sysdate(), '%Y%m') AND category='練習'";
$stmt3 = $pdo->prepare($sql3);
$status3 = $stmt3->execute();
$result3 = $stmt3->fetch();

$sql4 = "SELECT category as category, COUNT(*) as count FROM gs_an_table WHERE u_id='$u_id' AND DATE_FORMAT(indate, '%Y%m') = DATE_FORMAT(sysdate(), '%Y%m') AND category='試合'";
$stmt4 = $pdo->prepare($sql4);
$status4 = $stmt4->execute();
$result4 = $stmt4->fetch();

$sql5 = "SELECT category as category, COUNT(*) as count FROM gs_an_table WHERE u_id='$u_id' AND DATE_FORMAT(indate, '%Y%m') = DATE_FORMAT(sysdate(), '%Y%m') AND category='その他'";
$stmt5 = $pdo->prepare($sql5);
$status5 = $stmt5->execute();
$result5 = $stmt5->fetch();

//ユーザー情報取得
$stmt2 = $pdo->prepare("SELECT * FROM gs_user_table WHERE u_id = '$u_id'");
$status2 = $stmt2->execute();

//データ表示 ユーザー情報（該当データ１件のみ）
$user = "";
$result2 = $stmt2->fetch();
$user .= '<div class="prof_fb1">';
$user .=   '<div class="disp_inblk" id="prof_img_wrap"><p id="prof_img"><img border="0" src="'.$result2["u_imgpath"].'" width="auto" height="100px" alt="ユーザー画像"></p></div>';
$user .=   '<div class="prof_fb2" id="prof_info">';
$user .=     '<div class="disp_inblk prof_fb2">';
$user .=       '<div id="name_disp" class="disp_inblk"><span class="user_name2">'.$result2["u_name"].'</span></div>';
$user .=     '</div>';
$user .=     '<div id="staticdata_wrap" class="link_small staticdata"><a>今月のテニ活</a><br>';
$user .=     '<a><span class="va_t">練習&nbsp;</span><span class="fs_30">'.$result3["count"].'</span>&nbsp;回&nbsp;&nbsp;&nbsp;<span class="va_t">試合&nbsp;</span><span class="fs_30">'.$result4["count"].'</span>&nbsp;回&nbsp;&nbsp;&nbsp;<span class="va_t">その他&nbsp;</span><span class="fs_30">'.$result5["count"].'</span>&nbsp;回</a></div>';
$user .= '</div></div>';
$user .= '<table id="user_info">';
$user .=   '<tr><th><span class="font_green">登録日</span></th><td>'.date('Y年n月d日', strtotime($result2["sign_date"])).'</td></tr>';
$user .=   '<tr><th><span class="font_green">好きな選手</span></th><td>'.$result2["favorit_player"]."</td></tr>";
$user .=   '<tr><th><span class="font_green">プロフィール</span></th><td>'.nl2br($result2["profile"])."</td></tr>";
$user .= "</table>";

//データ表示 テニ活
$view = "";
if($status==false){
  //execute(SQL実行時にエラーがある場足)
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
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
  <script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <title>表示</title>
</head>
<body>
<header></header>
<?php include("inc/menu_myp_guest.html");?>
<div id="container">
  <div class="posts"><?=$user?></div>
</div>
<div id="container">
  <div class="posts"><?=$view?></div>
</div>
</body>
</html>