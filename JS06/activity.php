<?php
session_start();



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <title>テニスイキタイ</title>
</head>
<header>
  <nav class="">
    <div>
    <div>
  </nav>
</header>
<body>
<form method="post" action="insert.php">
  <div id="act_input">
    <fieldset>
      <legend>テニ活</legend>
      <label>名前: <input type="text" name="name"></label><br>
      <label>日付: <input type="date" name="indate"></label><br>
      <label>項目: <input type="text" name="category"></label><br>
      <label>内容: <textarea rows="10" cols="60" name="act"></textarea></label><br>
      <input type="submit" value="送信">
    </fieldset>
  </div>
</form>

</body>
</html>