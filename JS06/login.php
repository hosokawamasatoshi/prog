<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <title>テニスダイスキ / ログイン</title>
</head>
<body class="background_all">
    <header>
      <nav class="">
        <div class="title_logo">
          <h1>テニスダイスキ</h1>
        <div>
      </nav>
    </header>
    <form method="post" action="login_act.php" class="login_form">
      <fieldset>
        <legend>ログイン</legend>
        <label>ID<br><input type="text" name="lid"></label><br>
        <label>PW<br><input type="password" name="lpw"></label><br>
        <input type="submit" value="ログイン" id="login_btn">
      </fieldset>
    </form>
</body>
</html>