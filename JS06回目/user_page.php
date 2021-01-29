<?php
include("funcs.php");
$pdo = db_connect();

session_start();
loginCheck(); //セッションチェック 前ページと現在のSESSION_IDを比較
$u_id   = $_SESSION["u_id"];
$u_name = $_SESSION["u_name"];
$u_imgpath = $_SESSION["u_imgpath"];

//テニ活用SQL ユーザー情報とテニ活のテーブルを結合
$sql = "SELECT * FROM gs_user_table INNER JOIN gs_an_table ON gs_an_table.u_id = gs_user_table.u_id WHERE gs_an_table.u_id = '$u_id' ORDER BY indate DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//テニ活表示 編集・削除はidを持って遷移
$view = "";
if($status==false){
  sql_error($stmt);
}else{
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p id="post"><div id="post_container"><div id="fb1"><img border="0" src="'.$result["u_imgpath"].'" width="auto" height="50px" alt="ユーザー画像"><br>';
    $view .= '<span class="user_name">'.$result["u_name"]."</span></div>";
    $view .= '<div id="fb2"><a id="category_block">'.$result["category"].'</a><span class="small_date">'.date('Y年m月d日 H:i', strtotime($result["indate"]))."</span>";
    $view .= '<a class="float_right" href="delete.php?post_id='.$result["post_id"].'"><span class="link_small text-align">削除</span></a>';
    $view .= '<a class="float_right" href="u_view.php?post_id='.$result["post_id"].'"><span class="link_small text-align">編集</span></a><br><br>';
    $view .= nl2br($result["act"]);
    if($result["save_img_name"]){$view .= '<br><br><img border="0" src="'.$result["save_img_name"].'" width="auto" height="200px" alt="テニ活画像">';}
    $view .= '<br><br><a class="float_left" href="posts.php?post_id='.$result["post_id"].'"><i class="far fa-heart heart"> '.$result["heart_num"].'</i><i class="far fa-comment comment"> '.$result["comment_num"].'</i></a><br><br>';
    $view .= "</div></div></p>";
  }
}

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

//ユーザー情報用SQL（該当データ１件のみ）
$stmt2 = $pdo->prepare("SELECT * FROM gs_user_table WHERE u_id = '$u_id'");
$status2 = $stmt2->execute();
$result2 = $stmt2->fetch();
$user = "";

$user .= '<div class="prof_fb1">';
$user .=   '<div class="disp_inblk" id="prof_img_wrap"><p id="prof_img"><img border="0" src="'.$result2["u_imgpath"].'" width="auto" height="100px" alt="ユーザー画像"></p></div>';
$user .=   '<div class="prof_fb2" id="prof_info">';
$user .=     '<div class="disp_inblk prof_fb2">';
$user .=       '<div id="name_disp" class="disp_inblk"><span class="user_name2">'.$result2["u_name"].'</span></div>';
$user .=       '<div id="prof_edit"><a class="link_small" href="prof_page.php">プロフィール編集</a></div>';
$user .=     '</div>';
$user .=     '<div id="staticdata_wrap" class="link_small staticdata"><a>今月のテニ活</a><br>';
$user .=     '<a><span class="va_t">練習&nbsp;</span><span class="fs_30">'.$result3["count"].'</span>&nbsp;回&nbsp;&nbsp;&nbsp;<span class="va_t">試合&nbsp;</span><span class="fs_30">'.$result4["count"].'</span>&nbsp;回&nbsp;&nbsp;&nbsp;<span class="va_t">その他&nbsp;</span><span class="fs_30">'.$result5["count"].'</span>&nbsp;回</a></div>';
$user .= '</div></div>';
$user .= '<table id="user_info">';
$user .=   '<tr><th><span class="font_green">登録日</span></th><td>'.date('Y年n月d日', strtotime($result2["sign_date"])).'</td></tr>';
$user .=   '<tr><th><span class="font_green">好きな選手</span></th><td>'.$result2["favorit_player"]."</td></tr>";
$user .=   '<tr><th><span class="font_green">プロフィール</span></th><td>'.nl2br($result2["profile"])."</td></tr>";
$user .= "</table>";

?>

<!DOCTYPE html>
<html lang="ja">
<script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <title>ユーザーページ</title>
</head>
<body>
<header></header>
<?php include("inc/menu_myp.html");?>
<div id="container">
  <div class="posts"><?=$user?></div>
</div>
<div id="container">
  <div class="posts"><?=$view?></div>
</div>
</body>
</html>