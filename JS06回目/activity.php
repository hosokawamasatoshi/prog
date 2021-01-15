<!DOCTYPE html>
<html lang="ja">
<script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="kadai06.css">
  <title>テニスイキタイ</title>
</head>
<body>
<form method="post" action="insert_activity.php">
  <div id="act_input">
    <fieldset id="act_fs">
      <label><input id="act_date" type="date" name="indate"></label>
      <div class="radio_wrap">
        <label><input type="radio" name="category" value="練習">練習</label>
        <label><input type="radio" name="category" value="試合">試合</label>
        <label><input type="radio" name="category" value="その他">その他</label>
      </div>
      <label><textarea rows="10" cols="60" name="act"></textarea></label>
      <input id="activity_btn" type="submit" value="送信">
    </fieldset>
  </div>
</form>

</body>
</html>