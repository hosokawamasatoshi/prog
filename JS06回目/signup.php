<?php
session_start();
$errorMessage = "";

if (isset($_POST["login_btn"])) {
  //ユーザIDの入力チェック
  if(empty($_POST["u_id"])){  //値が空のとき
    $errorMessage = 'IDが未入力です';
  }else if(empty($_POST["u_pw"])){
    $errorMessage = 'パスワードが未入力です';
  }else if(empty($_POST["u_name"])){
    $errorMessage = 'ユーザーネームが未入力です';
  }else{
    //DB接続
    include("funcs.php");
    $pdo = db_connect();

    //ID・ユーザーネームの重複確認
    $stmt1 = $pdo->prepare("SELECT * FROM gs_user_table WHERE u_id=:u1");
    $stmt1->execute(array(':u1' => $_POST["u_id"]));
    $result1 = $stmt1->fetch();
    $stmt2 = $pdo->prepare("SELECT * FROM gs_user_table WHERE u_name=:u2");
    $stmt2->execute(array(':u2' => $_POST["u_name"]));
    $result2 = $stmt2->fetch();
    if($result1){
      $errorMessage = 'そのIDはすでに使用されています';
    }else if($result2){
      $errorMessage = 'そのユーザーネームはすでに使用されています';
    }else{
      //入力漏れや重複がない場合は登録へ遷移
      $_SESSION = $_POST;
      header("Location: signup_act.php");
    }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
  <link rel="stylesheet" href="kadai06.css">
  <title>テニスダイスキ</title>
</head>
<body class="background_all">
  <div class="login_h1">
    <h1>テニスダイスキ</h1>
  </div>
  <div id="error_disp"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
  <form method="post" action="" class="login_form">
    <fieldset>
      <legend>新規登録</legend>
      <label>ID<br><input type="text" name="u_id"></label><br>
      <label>PW<br><input type="password" name="u_pw"></label><br>
      <label>ユーザーネーム<br><input type="text" name="u_name"></label><br>
      <input type="submit" value="登録" id="login_btn" name="login_btn">
    </fieldset>
  </form>
</body>
</html>