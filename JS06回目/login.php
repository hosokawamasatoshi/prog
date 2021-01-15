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
  <form method="post" action="login_act.php" class="login_form">
    <fieldset>
      <legend>ログイン</legend>
      <label>ID<br><input type="text" name="u_id"></label><br>
      <label>PW<br><input type="password" name="u_pw"></label><br>
      <input type="submit" value="ログイン" id="login_btn">
    </fieldset>
  </form>
</body>
</html>