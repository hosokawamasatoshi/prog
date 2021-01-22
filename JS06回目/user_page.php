<?php
include("funcs.php");
$pdo = db_connect();

session_start();
loginCheck(); //セッションチェック 前ページと現在のSESSION_IDを比較
$u_id   = $_SESSION["u_id"];
$u_name = $_SESSION["u_name"];


//テニ活用SQL ユーザー情報とテニ活のテーブルを結合
$sql = "SELECT * FROM gs_user_table INNER JOIN gs_an_table ON gs_an_table.u_id = gs_user_table.u_id WHERE gs_an_table.u_id = '$u_id' ORDER BY indate DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//ユーザー情報用SQL
$stmt2 = $pdo->prepare("SELECT * FROM gs_user_table WHERE u_id = '$u_id'");
$status2 = $stmt2->execute();

//ユーザー情報表示（該当データ１件のみ）
$user = "";
$result2 = $stmt2->fetch();
$user .= '<table id="user_info">';
$user .= '<tr?><th><img border="0" src="'.$result2["u_imgpath"].'" width="auto" height="100px" alt="ユーザー画像"></th><td>';
$user .= '<a><span class="font_bold">'.$result2["u_name"].'</span></a><br>';
$user .= '<a class="float_right" href="prof_page.php"><span class="link_small">プロフィール編集</span></a></td></tr>';
$user .= '<tr><th><span class="font_green">登録日</span></th><td>'.date('Y年n月d日', strtotime($result2["sign_date"])).'</td></tr>';
$user .= '<tr><th><span class="font_green">好きな選手</span></th><td>'.$result2["favorit_player"]."</td></tr>";
$user .= '<tr><th><span class="font_green">プロフィール</span></th><td>'.nl2br($result2["profile"])."</td></tr>";
$user .= "</table>";

//テニ活表示 編集・削除はidを持って遷移
$view = "";
if($status==false){
  sql_error($stmt);
}else{
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p id="post"><div id="post_container"><div id="fb1"><img border="0" src="'.$result["u_imgpath"].'" width="auto" height="50px" alt="ユーザー画像"><br>';
    $view .= '<span>'.$result["u_name"]."</span></div>";
    $view .= '<div id="fb2">'.$result["category"].'　　<span class="small_date">'.date('Y年m月d日 H:i', strtotime($result["indate"]))."</span>";
    $view .= '<a class="float_right" href="delete.php?post_id='.$result["post_id"].'"><span class="link_small text-align">削除</span></a>';
    $view .= '<a class="float_right" href="u_view.php?post_id='.$result["post_id"].'"><span class="link_small text-align">編集</span></a><br><br>';
    $view .= nl2br($result["act"]);
    if($result["save_img_name"]){$view .= '<br><br><img border="0" src="'.$result["save_img_name"].'" width="auto" height="200px" alt="テニ活画像">';}
    $view .= "<br></div></div></p>";
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