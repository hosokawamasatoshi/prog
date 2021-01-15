<?php
include("funcs.php");
$pdo = db_connect();

$u_id = $_GET["u_id"];

//ユーザー情報とテニ活のテーブルを結合
$sql = "SELECT * FROM gs_user_table INNER JOIN gs_an_table ON gs_an_table.u_id = gs_user_table.u_id WHERE gs_an_table.u_id = '$u_id' ORDER BY indate DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//ユーザー情報取得
$stmt2 = $pdo->prepare("SELECT * FROM gs_user_table WHERE u_id = '$u_id'");
$status2 = $stmt2->execute();

//データ表示 ユーザー情報（該当データ１件のみ）
$user = "";
$result2 = $stmt2->fetch();
$user .= '<table id="user_info">';
$user .= '<tr?><th><img border="0" src="'.$result2["u_imgpath"].'" width="auto" height="100px" alt="ユーザー画像"></th><td>';
$user .= '<a><span class="font_bold">'.$result2["u_name"].'</span></a></td></tr>';
$user .= '<tr><th><span class="font_green">登録日</span></th><td>'.date('Y年n月d日', strtotime($result2["sign_date"])).'</td></tr>';
$user .= '<tr><th><span class="font_green">好きな選手</span></th><td>'.$result2["favorit_player"]."</td></tr>";
$user .= '<tr><th><span class="font_green">プロフィール</span></th><td>'.nl2br($result2["profile"])."</td></tr>";
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
    $view .= '<p id="post"><div id="post_container"><div id="fb1"><img border="0" src="'.$result["u_imgpath"].'" width="auto" height="50px" alt="ユーザー画像"><br>';
    $view .= '<span>'.$result["u_name"]."</span></div>";
    $view .= '<div id="fb2">'.$result["category"].'　　<span class="small_date">'.date('Y年m月d日 H:i', strtotime($result["indate"]))."</span>";
    $view .= '<a class="float_right"href="delete.php?id='.$result["id"].'"></a>';
    $view .= '<a class="float_right" href="u_view.php?id='.$result["id"].'"></a><br><br>';
    $view .= nl2br($result["act"]);
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