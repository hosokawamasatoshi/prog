<?php
session_start();
$errorMessage = "";

include("funcs.php");
$pdo = db_connect(); //DB接続

$lid = $_POST["u_id"];
$lpw = $_POST["u_pw"];

if (isset($_POST["login_btn"])) {
  //ユーザID・PWの入力チェック
  if(empty($_POST["u_id"])){  //値が空のとき
    $errorMessage = 'IDが未入力です';
  }else if(empty($_POST["u_pw"])){
    $errorMessage = 'パスワードが未入力です';
  }else{
    //入力漏れや重複がない場合は登録へ遷移
    $sql = "SELECT * FROM gs_user_table WHERE u_id=:u_id AND u_pw=:u_pw";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':u_id', $lid);
    $stmt->bindValue(':u_pw', $lpw);
    $res = $stmt->execute();
    $val = $stmt->fetch();

    if($val["id"] != ""){
      $_SESSION["chk_ssid"]  = session_id(); //ユニークなsession_idを付与
      $_SESSION["u_id"]      = $val['u_id'];
      $_SESSION["u_name"]    = $val['u_name'];
      $_SESSION["u_imgpath"] = $val['u_imgpath'];
      header("Location: select.php");
    }else{
      $errorMessage = 'IDかパスワードが間違ってます';
    }
  }
}

?>

<!DOCTYPE html>
<html>
<script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <title>テニスダイスキ / ログイン</title>
</head>
<body class="background_all">
  <div class="login_h1">
    <h1>テニスダイスキ</h1>
  </div>
  <div id="error_disp"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
  <form method="post" action="" class="login_form">
    <fieldset>
      <legend>ログイン</legend>
      <label>ID<br><input type="text" name="u_id" class="ime-inactive"></label><br>
      <label>PW<br><input type="password" name="u_pw"></label><br>
      <input type="submit" value="ログイン" id="login_btn" name="login_btn">
    </fieldset>
  </form>
</body>
</html>