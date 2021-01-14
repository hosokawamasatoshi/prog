<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <title>テニスダイスキ</title>
</head>
<body class="background_all">
    <header>
      <nav class="">
        <div class="title_logo">
          <h1>テニスダイスキ</h1>
        <div>
      </nav>
    </header>
    <form method="post" action="signup_act.php" class="login_form">
      <fieldset>
        <legend>新規登録</legend>
        <label>ID<br><input type="text" name="u_id"></label><br>
        <label>PW<br><input type="password" name="u_pw"></label><br>
        <label>ユーザーネーム<br><input type="text" name="u_name"></label><br>
        <input type="submit" value="登録" id="login_btn">
      </fieldset>
    </form>
</body>
</html>